<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(Request $request): View
    {
        $church = $request->user()->church;

        if (!$church) {
            abort(403, 'Your account is not associated with a church.');
        }

        $attendance = Attendance::query()
            ->with(['member', 'service'])
            ->where('church_id', $church->id)
            ->when(
                $request->filled('service_id'),
                fn ($query) => $query->where('service_id', $request->service_id)
            )
            ->orderByDesc('checked_in_at')
            ->paginate(20)
            ->withQueryString();

        $services = $church->services()
            ->withCount('attendances')
            ->orderByDesc('service_date')
            ->orderByDesc('start_time')
            ->get();

        $totalAttendance = Attendance::query()
            ->where('church_id', $church->id)
            ->count();

        $totalServices = $services->count();

        $averageAttendance = $totalServices > 0
            ? round($services->avg('attendances_count'), 1)
            : 0;

        $highestAttendanceService = $services
            ->sortByDesc('attendances_count')
            ->first();

        return view('church.attendance.index', [
            'attendance' => $attendance,
            'services' => $services,
            'totalAttendance' => $totalAttendance,
            'totalServices' => $totalServices,
            'averageAttendance' => $averageAttendance,
            'highestAttendanceService' => $highestAttendanceService,
        ]);
    }
}