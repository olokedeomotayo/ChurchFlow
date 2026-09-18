<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Church;
use Illuminate\Http\Request;



class ChurchController extends Controller
{
    /**
     * Display all churches.
     */
    public function index(Request $request)
    {
        $churches = Church::query()
            ->with([
                'users' => function ($query) {
                    $query->whereHas('roles', function ($roleQuery) {
                        $roleQuery->where('name', 'church_owner');
                    });
                },
                'subscriptions.plan',
            ])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.churches.index', compact('churches'));
    }

    /**
     * Display a specific church.
     */
    public function show(Church $church)
    {
        $church->load([
            'users.roles',
            'subscriptions.plan',
        ]);

        return view('admin.churches.show', compact('church'));
    }

    /**
     * Show the form for editing a church.
     */
    public function edit(Church $church)
    {
        return view('admin.churches.edit', compact('church'));
    }


        /**
         * Update the specified church.
         */
        public function update(Request $request, Church $church)
        {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['nullable', 'email', 'max:255'],
                'phone' => ['nullable', 'string', 'max:50'],
                'address' => ['nullable', 'string', 'max:500'],
                'city' => ['nullable', 'string', 'max:100'],
                'state' => ['nullable', 'string', 'max:100'],
                'country' => ['nullable', 'string', 'max:100'],
                'timezone' => ['nullable', 'string', 'max:100'],
                'status' => ['required', 'in:trial,active,expired,suspended,cancelled'],
            ]);

            $church->update($validated);

            return redirect()
                ->route('admin.churches.show', $church)
                ->with('success', 'Church information updated successfully.');
        }

        /**
     * Activate a church account.
     */
    public function activate(Church $church)
    {
        $church->update([
            'status' => 'active',
        ]);

        return redirect()
            ->route('admin.churches.show', $church)
            ->with('success', 'Church account activated successfully.');
    }


    /**
     * Suspend a church account.
     */
    public function suspend(Church $church)
    {
        $church->update([
            'status' => 'suspended',
        ]);

        return redirect()
            ->route('admin.churches.show', $church)
            ->with('success', 'Church account suspended successfully.');
    }

    /**
 * Extend a church trial period.
 */
public function extendTrial(Request $request, Church $church)
{
    $validated = $request->validate([
        'days' => ['required', 'integer', 'min:1', 'max:365'],
    ]);

    $currentEnd = $church->trial_ends_at
        ? \Carbon\Carbon::parse($church->trial_ends_at)
        : now();

    $newEnd = $currentEnd->copy()->addDays((int) $validated['days']);

    $church->update([
        'trial_ends_at' => $newEnd,
        'status' => 'trial',
    ]);

    return redirect()
        ->route('admin.churches.show', $church)
        ->with(
            'success',
            "Trial extended by {$validated['days']} days. New trial end date: " .
            $newEnd->format('d M Y, h:i A') . '.'
        );
}
}