<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GroupController extends Controller
{
    /**
     * Display all groups and departments belonging to the church.
     */
    public function index(Request $request): View
    {
        $church = $request->user()->church;

        if (!$church) {
            abort(403, 'Your account is not associated with a church.');
        }

        $groups = $church->groups()
            ->with(['leader', 'members'])
            ->orderBy('type')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('church.groups.index', compact('groups'));
    }

    /**
     * Show the create form.
     */
    public function create(Request $request): View
    {
        $church = $request->user()->church;

        if (!$church) {
            abort(403, 'Your account is not associated with a church.');
        }

        $members = $church->members()
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        return view('church.groups.create', compact('members'));
    }

    /**
     * Store a new group or department.
     */
    public function store(Request $request): RedirectResponse
    {
        $church = $request->user()->church;

        if (!$church) {
            abort(403, 'Your account is not associated with a church.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'in:group,department'],
            'status' => ['required', 'in:active,inactive'],
            'leader_id' => [
                'nullable',
                'integer',
                'exists:members,id',
            ],
        ]);

        // Make sure the selected leader belongs to this church.
        if (!empty($validated['leader_id'])) {
            $leaderBelongsToChurch = $church->members()
                ->whereKey($validated['leader_id'])
                ->exists();

            if (!$leaderBelongsToChurch) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'leader_id' => 'The selected leader does not belong to your church.',
                    ]);
            }
        }

        $church->groups()->create($validated);

        return redirect()
            ->route('church.groups.index')
            ->with('success', 'Group/Department created successfully.');
    }

    /**
     * Display a group or department.
     */
    public function show(Request $request, Group $group): View
    {
        $this->ensureBelongsToChurch($request, $group);

        $group->load(['leader', 'members']);

        return view('church.groups.show', compact('group'));
    }

    /**
     * Show the edit form.
     */
    public function edit(Request $request, Group $group): View
    {
        $this->ensureBelongsToChurch($request, $group);

        $members = $request->user()->church->members()
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        return view('church.groups.edit', compact('group', 'members'));
    }

    /**
     * Update a group or department.
     */
    public function update(
        Request $request,
        Group $group
    ): RedirectResponse {
        $this->ensureBelongsToChurch($request, $group);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'in:group,department'],
            'status' => ['required', 'in:active,inactive'],
            'leader_id' => [
                'nullable',
                'integer',
                'exists:members,id',
            ],
        ]);

        // Make sure the selected leader belongs to this church.
        if (!empty($validated['leader_id'])) {
            $leaderBelongsToChurch = $request->user()->church
                ->members()
                ->whereKey($validated['leader_id'])
                ->exists();

            if (!$leaderBelongsToChurch) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'leader_id' => 'The selected leader does not belong to your church.',
                    ]);
            }
        }

        $group->update($validated);

        return redirect()
            ->route('church.groups.index')
            ->with('success', 'Group/Department updated successfully.');
    }

    /**
     * Delete a group or department.
     */
    public function destroy(
        Request $request,
        Group $group
    ): RedirectResponse {
        $this->ensureBelongsToChurch($request, $group);

        $group->delete();

        return redirect()
            ->route('church.groups.index')
            ->with('success', 'Group/Department deleted successfully.');
    }

    /**
     * Ensure the group belongs to the authenticated user's church.
     */
    private function ensureBelongsToChurch(
        Request $request,
        Group $group
    ): void {
        $church = $request->user()->church;

        if (!$church || $group->church_id !== $church->id) {
            abort(404);
        }
    }

    /**
 * Show the member assignment form.
 */
public function editMembers(
    Request $request,
    Group $group
): View {
    $this->ensureBelongsToChurch($request, $group);

    $church = $request->user()->church;

    $members = $church->members()
        ->orderBy('first_name')
        ->orderBy('last_name')
        ->get();

    $group->load('members');

    $assignedMemberIds = $group->members
        ->pluck('id')
        ->toArray();

    return view('church.groups.members', [
        'group' => $group,
        'members' => $members,
        'assignedMemberIds' => $assignedMemberIds,
    ]);
}


/**
 * Update the members assigned to the group.
 */
public function updateMembers(
    Request $request,
    Group $group
): RedirectResponse {
    $this->ensureBelongsToChurch($request, $group);

    $church = $request->user()->church;

    $validated = $request->validate([
        'member_ids' => ['nullable', 'array'],
        'member_ids.*' => ['integer', 'exists:members,id'],
    ]);

    $memberIds = $validated['member_ids'] ?? [];

    // Only allow members belonging to the current church.
    $validMemberIds = $church->members()
        ->whereIn('id', $memberIds)
        ->pluck('id')
        ->toArray();

    $group->members()->sync($validMemberIds);

    return redirect()
        ->route('church.groups.show', $group)
        ->with('success', 'Group members updated successfully.');
}
}