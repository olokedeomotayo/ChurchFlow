<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $church = $user?->church;

        abort_unless($church, 403);

        abort_unless(
            $user->can('users.view'),
            403
        );

        $users = User::query()
            ->where('church_id', $church->id)
            ->with('roles')
            ->latest()
            ->paginate(20);

        return view('church.users.index', [
            'user' => $user,
            'church' => $church,
            'users' => $users,
        ]);
    }

    public function create(): View
    {
        $user = Auth::user();
        $church = $user?->church;

        abort_unless($church, 403);

        abort_unless(
            $user->can('users.create'),
            403
        );

        $roles = $this->availableRoles($church->id);

        return view('church.users.create', [
            'user' => $user,
            'church' => $church,
            'roles' => $roles,
        ]);
    }

    public function store(
        Request $request,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $user = Auth::user();
        $church = $user?->church;

        abort_unless($church, 403);

        abort_unless(
            $user->can('users.create'),
            403
        );

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
            'role' => ['required', 'string'],
        ]);

        $role = $this->findAvailableRole(
            $validated['role'],
            $church->id
        );

        abort_unless(
            $role,
            422,
            'The selected role is not available.'
        );

        $newUser = User::create([
            'church_id' => $church->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        $newUser->assignRole($role);

        $activityLog->record(
            action: 'created',
            subject: $newUser,
            description: sprintf(
                'Church user created: %s (%s) with role %s.',
                $newUser->name,
                $newUser->email,
                $role->name
            )
        );

        return redirect()
            ->route('church.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $churchUser): View
    {
        $user = Auth::user();
        $church = $user?->church;

        abort_unless($church, 403);

        abort_unless(
            $user->can('users.update'),
            403
        );

        $this->ensureUserBelongsToChurch(
            $churchUser,
            $church->id
        );

        $roles = $this->availableRoles($church->id);

        return view('church.users.edit', [
            'user' => $user,
            'church' => $church,
            'churchUser' => $churchUser,
            'roles' => $roles,
        ]);
    }

    public function update(
        Request $request,
        User $churchUser,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $user = Auth::user();
        $church = $user?->church;

        abort_unless($church, 403);

        abort_unless(
            $user->can('users.update'),
            403
        );

        $this->ensureUserBelongsToChurch(
            $churchUser,
            $church->id
        );

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $churchUser->id,
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
            'role' => ['required', 'string'],
        ]);

        $role = $this->findAvailableRole(
            $validated['role'],
            $church->id
        );

        abort_unless(
            $role,
            422,
            'The selected role is not available.'
        );

        $churchUser->name = $validated['name'];
        $churchUser->email = $validated['email'];

        if (! empty($validated['password'])) {
            $churchUser->password = $validated['password'];
        }

        $churchUser->save();

        $churchUser->syncRoles([$role]);

        $activityLog->record(
            action: 'updated',
            subject: $churchUser,
            description: sprintf(
                'Church user updated: %s (%s). Role: %s.',
                $churchUser->name,
                $churchUser->email,
                $role->name
            )
        );

        return redirect()
            ->route('church.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(
        User $churchUser,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $user = Auth::user();
        $church = $user?->church;

        abort_unless($church, 403);

        abort_unless(
            $user->can('users.delete'),
            403
        );

        $this->ensureUserBelongsToChurch(
            $churchUser,
            $church->id
        );

        abort_if(
            $churchUser->id === $user->id,
            422,
            'You cannot delete your own account.'
        );

        $name = $churchUser->name;
        $email = $churchUser->email;

        $activityLog->record(
            action: 'deleted',
            subject: $churchUser,
            description: sprintf(
                'Church user deleted: %s (%s).',
                $name,
                $email
            )
        );

        $churchUser->delete();

        return redirect()
            ->route('church.users.index')
            ->with('success', 'User deleted successfully.');
    }

    private function availableRoles(int $churchId)
    {
        return Role::query()
            ->where('guard_name', 'web')
            ->where(function ($query) use ($churchId) {
                $query->where('church_id', $churchId)
                    ->orWhere('name', 'church_owner');
            })
            ->where('name', '!=', 'platform_admin')
            ->orderBy('name')
            ->get();
    }

    private function findAvailableRole(
        string $roleName,
        int $churchId
    ): ?Role {
        return Role::query()
            ->where('guard_name', 'web')
            ->where('name', $roleName)
            ->where(function ($query) use ($churchId) {
                $query->where('church_id', $churchId)
                    ->orWhere('name', 'church_owner');
            })
            ->where('name', '!=', 'platform_admin')
            ->first();
    }

    private function ensureUserBelongsToChurch(
        User $churchUser,
        int $churchId
    ): void {
        abort_unless(
            $churchUser->church_id === $churchId,
            404
        );
    }
}