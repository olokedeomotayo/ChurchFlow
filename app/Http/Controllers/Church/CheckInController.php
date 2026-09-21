<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckInController extends Controller
{
    /**
     * Display the check-in page.
     */
    public function index(Request $request): View
    {
        $church = $request->user()->church;

        if (! $church) {
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

    /**
     * Check a member into a service.
     */
    public function store(
        Request $request,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $church = $request->user()->church;

        if (! $church) {
            abort(403, 'Your account is not associated with a church.');
        }

        $validated = $request->validate([
            'service_id' => [
                'required',
                'integer',
                'exists:services,id',
            ],
            'member_id' => [
                'required',
                'integer',
                'exists:members,id',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Validate Service
        |--------------------------------------------------------------------------
        */

        $service = $church->services()
            ->whereKey($validated['service_id'])
            ->first();

        if (! $service) {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | Validate Member
        |--------------------------------------------------------------------------
        */

        $member = $church->members()
            ->whereKey($validated['member_id'])
            ->first();

        if (! $member) {
            return back()->withErrors([
                'member_id' =>
                    'The selected member does not belong to your church.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Check-In
        |--------------------------------------------------------------------------
        */

        $alreadyCheckedIn = Attendance::query()
            ->where('church_id', $church->id)
            ->where('service_id', $service->id)
            ->where('member_id', $member->id)
            ->exists();

        if ($alreadyCheckedIn) {
            return back()->with(
                'error',
                'This member has already been checked in for this service.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Create Attendance Record
        |--------------------------------------------------------------------------
        */

        $attendance = Attendance::create([
            'church_id' => $church->id,
            'service_id' => $service->id,
            'member_id' => $member->id,
            'checked_in_at' => now(),
            'status' => 'present',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Audit Log
        |--------------------------------------------------------------------------
        */

        $activityLog->record(
            action: 'checked_in',
            subject: $attendance,
            description: sprintf(
                '%s %s checked in for %s.',
                $member->first_name,
                $member->last_name,
                $service->name
            )
        );

        return back()->with(
            'success',
            'Member checked in successfully.'
        );
    }
}