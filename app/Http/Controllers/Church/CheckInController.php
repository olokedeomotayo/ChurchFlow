<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckInController extends Controller
{
    public function index(Request $request): View
    {
        $church = $request->user()->church;

        if (!$church) {
            abort(403, 'Your account is not associated with a church.');
        }

        $services = $church->services()
            ->whereIn('status', ['scheduled', 'completed'])
            ->orderByDesc('service_date')
            ->orderByDesc('start_time')
            ->get();

        $selectedService = null;

        if ($request->filled('service_id')) {
            $selectedService = $church->services()
                ->whereKey($request->service_id)
                ->firstOrFail();
        }

        return view('church.checkin.index', [
            'services' => $services,
            'selectedService' => $selectedService,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $church = $request->user()->church;

        if (!$church) {
            abort(403, 'Your account is not associated with a church.');
        }

        $validated = $request->validate([
            'service_id' => ['required', 'integer', 'exists:services,id'],
            'member_id' => ['required', 'integer', 'exists:members,id'],
        ]);

        $service = $church->services()
            ->whereKey($validated['service_id'])
            ->first();

        if (!$service) {
            abort(404);
        }

        $memberBelongsToChurch = $church->members()
            ->whereKey($validated['member_id'])
            ->exists();

        if (!$memberBelongsToChurch) {
            return back()->withErrors([
                'member_id' => 'The selected member does not belong to your church.',
            ]);
        }

        $alreadyCheckedIn = Attendance::query()
            ->where('church_id', $church->id)
            ->where('service_id', $service->id)
            ->where('member_id', $validated['member_id'])
            ->exists();

        if ($alreadyCheckedIn) {
            return back()->with('error', 'This member has already been checked in for this service.');
        }

        Attendance::create([
            'church_id' => $church->id,
            'service_id' => $service->id,
            'member_id' => $validated['member_id'],
            'checked_in_at' => now(),
            'status' => 'present',
        ]);

        return back()->with('success', 'Member checked in successfully.');
    }
}