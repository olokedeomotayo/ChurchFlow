<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $church = $user?->church;

        abort_unless($church, 403);

        abort_unless(
            $user->can('roles.view'),
            403
        );

        $roles = Role::query()
            ->where('guard_name', 'web')
            ->where(function ($query) use ($church) {
                $query->where('church_id', $church->id)
                    ->orWhereNull('church_id');
            })
            ->withCount('users')
            ->with('permissions')
            ->orderBy('name')
            ->get();

        return view('church.roles.index', [
            'user' => $user,
            'church' => $church,
            'roles' => $roles,
        ]);
    }

    public function create(): View
    {
        $user = Auth::user();
        $church = $user?->church;

        abort_unless($church, 403);

        abort_unless(
            $user->can('roles.create'),
            403
        );

        $permissions = Permission::query()
            ->where('guard_name', 'web')
            ->orderBy('name')
            ->get();

        return view('church.roles.create', [
            'user' => $user,
            'church' => $church,
            'permissions' => $permissions,
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
            $user->can('roles.create'),
            403
        );

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => [
                'string',
                'exists:permissions,name',
            ],
        ]);

        $roleExists = Role::query()
            ->where('guard_name', 'web')
            ->where('church_id', $church->id)
            ->where('name', $validated['name'])
            ->exists();

        abort_if(
            $roleExists,
            422,
            'A role with this name already exists for your church.'
        );

        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
            'church_id' => $church->id,
        ]);

        $role->syncPermissions(
            $validated['permissions'] ?? []
        );

        $activityLog->record(
            action: 'created',
            subject: $role,
            description: sprintf(
                'Church role created: %s with %d permission(s).',
                $role->name,
                count($validated['permissions'] ?? [])
            )
        );

        return redirect()
            ->route('church.roles.index')
            ->with('success', 'Role created successfully.');
    }

    public function edit(Role $role): View
    {
        $user = Auth::user();
        $church = $user?->church;

        abort_unless($church, 403);

        abort_unless(
            $user->can('roles.update'),
            403
        );

        $this->ensureRoleBelongsToChurch(
            $role,
            $church->id
        );

        $permissions = Permission::query()
            ->where('guard_name', 'web')
            ->orderBy('name')
            ->get();

        $role->load('permissions');

        return view('church.roles.edit', [
            'user' => $user,
            'church' => $church,
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }

    public function update(
        Request $request,
        Role $role,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $user = Auth::user();
        $church = $user?->church;

        abort_unless($church, 403);

        abort_unless(
            $user->can('roles.update'),
            403
        );

        $this->ensureRoleBelongsToChurch(
            $role,
            $church->id
        );

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => [
                'string',
                'exists:permissions,name',
            ],
        ]);

        $roleExists = Role::query()
            ->where('guard_name', 'web')
            ->where('church_id', $church->id)
            ->where('name', $validated['name'])
            ->where('id', '!=', $role->id)
            ->exists();

        abort_if(
            $roleExists,
            422,
            'A role with this name already exists for your church.'
        );

        $role->name = $validated['name'];
        $role->save();

        $role->syncPermissions(
            $validated['permissions'] ?? []
        );

        $activityLog->record(
            action: 'updated',
            subject: $role,
            description: sprintf(
                'Church role updated: %s with %d permission(s).',
                $role->name,
                count($validated['permissions'] ?? [])
            )
        );

        return redirect()
            ->route('church.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    public function destroy(
        Role $role,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $user = Auth::user();
        $church = $user?->church;

        abort_unless($church, 403);

        abort_unless(
            $user->can('roles.delete'),
            403
        );

        $this->ensureRoleBelongsToChurch(
            $role,
            $church->id
        );

        abort_if(
            $role->users()->exists(),
            422,
            'This role cannot be deleted while users are assigned to it.'
        );

        $roleName = $role->name;

        $activityLog->record(
            action: 'deleted',
            subject: $role,
            description: sprintf(
                'Church role deleted: %s.',
                $roleName
            )
        );

        $role->delete();

        return redirect()
            ->route('church.roles.index')
            ->with('success', 'Role deleted successfully.');
    }

    private function ensureRoleBelongsToChurch(
        Role $role,
        int $churchId
    ): void {
        abort_unless(
            $role->guard_name === 'web'
            && $role->church_id === $churchId,
            404
        );
    }
}