<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AttendanceController extends Controller
{
    /**
     * Display attendance records.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $church = $user?->church;

        abort_unless($church, 403);

        abort_unless(
            $user->can('attendance.view'),
            403
        );

        $attendance = Attendance::query()
            ->with('service')
            ->where('church_id', $church->id)
            ->when(
                $request->filled('service_id'),
                fn ($query) => $query->where(
                    'service_id',
                    $request->service_id
                )
            )
            ->when(
                $request->filled('attendance_date'),
                fn ($query) => $query->whereDate(
                    'attendance_date',
                    $request->attendance_date
                )
            )
            ->orderByDesc('attendance_date')
            ->paginate(20)
            ->withQueryString();

        $services = $church->services()
            ->orderByDesc('service_date')
            ->orderByDesc('start_time')
            ->get();

        $allAttendance = Attendance::query()
            ->where('church_id', $church->id)
            ->get();

        $totalAttendance = $allAttendance->sum(
            fn (Attendance $record) => $record->total
        );

        $totalServices = $allAttendance->count();

        $averageAttendance = $totalServices > 0
            ? round($totalAttendance / $totalServices, 1)
            : 0;

        $highestAttendance = $allAttendance
            ->load('service')
            ->sortByDesc(
                fn (Attendance $record) => $record->total
            )
            ->first();

        return view('church.attendance.index', [
            'user' => $user,
            'church' => $church,
            'attendance' => $attendance,
            'services' => $services,
            'totalAttendance' => $totalAttendance,
            'totalServices' => $totalServices,
            'averageAttendance' => $averageAttendance,
            'highestAttendance' => $highestAttendance,
        ]);
    }

    /**
     * Display the attendance creation form.
     */
    public function create(): View
    {
        $user = auth()->user();
        $church = $user?->church;

        abort_unless($church, 403);

        abort_unless(
            $user->can('attendance.view'),
            403
        );

        $services = $church->services()
            ->orderByDesc('service_date')
            ->orderByDesc('start_time')
            ->get();

        return view('church.attendance.create', [
            'user' => $user,
            'church' => $church,
            'services' => $services,
        ]);
    }

    /**
     * Store a new attendance record.
     */
    public function store(
        Request $request,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $user = $request->user();
        $church = $user?->church;

        abort_unless($church, 403);

        abort_unless(
            $user->can('attendance.view'),
            403
        );

        $validated = $request->validate([
            'service_id' => [
                'required',
                'integer',
                'exists:services,id',
            ],
            'attendance_date' => [
                'required',
                'date',
            ],
            'men' => [
                'required',
                'integer',
                'min:0',
            ],
            'women' => [
                'required',
                'integer',
                'min:0',
            ],
            'teenagers' => [
                'required',
                'integer',
                'min:0',
            ],
            'children' => [
                'required',
                'integer',
                'min:0',
            ],
            'guests' => [
                'required',
                'integer',
                'min:0',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        $serviceBelongsToChurch = $church->services()
            ->whereKey($validated['service_id'])
            ->exists();

        abort_unless($serviceBelongsToChurch, 404);

        $attendanceExists = Attendance::query()
            ->where('church_id', $church->id)
            ->where('service_id', $validated['service_id'])
            ->whereDate(
                'attendance_date',
                $validated['attendance_date']
            )
            ->exists();

        abort_if(
            $attendanceExists,
            422,
            'Attendance has already been recorded for this service and date.'
        );

        $attendance = Attendance::create([
            'church_id' => $church->id,
            'service_id' => $validated['service_id'],
            'attendance_date' => $validated['attendance_date'],
            'men' => $validated['men'],
            'women' => $validated['women'],
            'teenagers' => $validated['teenagers'],
            'children' => $validated['children'],
            'guests' => $validated['guests'],
            'notes' => $validated['notes'] ?? null,
        ]);

        $activityLog->record(
            action: 'created',
            subject: $attendance,
            description: sprintf(
                'Attendance recorded for %s: %d people.',
                $attendance->attendance_date->format('d M Y'),
                $attendance->total
            )
        );

        return redirect()
            ->route('church.attendance.index')
            ->with(
                'success',
                'Attendance recorded successfully.'
            );
    }

    /**
     * Display the attendance edit form.
     */
    public function edit(Attendance $attendance): View
    {
        $user = auth()->user();
        $church = $user?->church;

        abort_unless($church, 403);

        abort_unless(
            $user->can('attendance.view'),
            403
        );

        $this->ensureAttendanceBelongsToChurch(
            $attendance,
            $church->id
        );

        $services = $church->services()
            ->orderByDesc('service_date')
            ->orderByDesc('start_time')
            ->get();

        return view('church.attendance.edit', [
            'user' => $user,
            'church' => $church,
            'attendance' => $attendance,
            'services' => $services,
        ]);
    }

    /**
     * Update an attendance record.
     */
    public function update(
        Request $request,
        Attendance $attendance,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $user = $request->user();
        $church = $user?->church;

        abort_unless($church, 403);

        abort_unless(
            $user->can('attendance.view'),
            403
        );

        $this->ensureAttendanceBelongsToChurch(
            $attendance,
            $church->id
        );

        $validated = $request->validate([
            'service_id' => [
                'required',
                'integer',
                'exists:services,id',
            ],
            'attendance_date' => [
                'required',
                'date',
            ],
            'men' => [
                'required',
                'integer',
                'min:0',
            ],
            'women' => [
                'required',
                'integer',
                'min:0',
            ],
            'teenagers' => [
                'required',
                'integer',
                'min:0',
            ],
            'children' => [
                'required',
                'integer',
                'min:0',
            ],
            'guests' => [
                'required',
                'integer',
                'min:0',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        $serviceBelongsToChurch = $church->services()
            ->whereKey($validated['service_id'])
            ->exists();

        abort_unless($serviceBelongsToChurch, 404);

        $duplicate = Attendance::query()
            ->where('church_id', $church->id)
            ->where('service_id', $validated['service_id'])
            ->whereDate(
                'attendance_date',
                $validated['attendance_date']
            )
            ->where('id', '!=', $attendance->id)
            ->exists();

        abort_if(
            $duplicate,
            422,
            'Attendance has already been recorded for this service and date.'
        );

        $attendance->update([
            'service_id' => $validated['service_id'],
            'attendance_date' => $validated['attendance_date'],
            'men' => $validated['men'],
            'women' => $validated['women'],
            'teenagers' => $validated['teenagers'],
            'children' => $validated['children'],
            'guests' => $validated['guests'],
            'notes' => $validated['notes'] ?? null,
        ]);

        $activityLog->record(
            action: 'updated',
            subject: $attendance,
            description: sprintf(
                'Attendance updated for %s: %d people.',
                $attendance->attendance_date->format('d M Y'),
                $attendance->total
            )
        );

        return redirect()
            ->route('church.attendance.index')
            ->with(
                'success',
                'Attendance updated successfully.'
            );
    }

    /**
     * Delete an attendance record.
     */
    public function destroy(
        Attendance $attendance,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $user = auth()->user();
        $church = $user?->church;

        abort_unless($church, 403);

        abort_unless(
            $user->can('attendance.view'),
            403
        );

        $this->ensureAttendanceBelongsToChurch(
            $attendance,
            $church->id
        );

        $date = $attendance->attendance_date?->format('d M Y');
        $total = $attendance->total;

        $activityLog->record(
            action: 'deleted',
            subject: $attendance,
            description: sprintf(
                'Attendance deleted for %s: %d people.',
                $date,
                $total
            )
        );

        $attendance->delete();

        return redirect()
            ->route('church.attendance.index')
            ->with(
                'success',
                'Attendance deleted successfully.'
            );
    }

    /**
     * Download the attendance import template.
     */
    public function downloadTemplate(): StreamedResponse
    {
        $user = auth()->user();

        abort_unless($user, 403);

        abort_unless(
            $user->can('attendance.view'),
            403
        );

        $headers = [
            'service_id',
            'attendance_date',
            'men',
            'women',
            'teenagers',
            'children',
            'guests',
            'notes',
        ];

        return response()->streamDownload(
            function () use ($headers) {
                $file = fopen('php://output', 'w');

                fputcsv($file, $headers);

                fputcsv($file, [
                    '1',
                    '2026-09-20',
                    '85',
                    '110',
                    '35',
                    '60',
                    '12',
                    'Sample attendance record',
                ]);

                fclose($file);
            },
            'churchflow_attendance_template.csv',
            [
                'Content-Type' => 'text/csv',
            ]
        );
    }

    /**
     * Display the attendance import page.
     */
    public function import(): View
    {
        $user = auth()->user();
        $church = $user?->church;

        abort_unless($church, 403);

        abort_unless(
            $user->can('attendance.view'),
            403
        );

        return view('church.attendance.import', [
            'user' => $user,
            'church' => $church,
        ]);
    }

    /**
     * Import attendance records from CSV.
     */
    public function importStore(
        Request $request,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $user = $request->user();
        $church = $user?->church;

        abort_unless($church, 403);

        abort_unless(
            $user->can('attendance.view'),
            403
        );

        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:csv,txt',
                'max:5120',
            ],
        ]);

        $file = $request->file('file');

        $handle = fopen($file->getRealPath(), 'r');

        if ($handle === false) {
            return back()->withErrors([
                'file' => 'Unable to open the uploaded CSV file.',
            ]);
        }

        $headers = fgetcsv($handle);

        if ($headers === false) {
            fclose($handle);

            return back()->withErrors([
                'file' => 'The CSV file is empty.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Clean CSV Headers
        |--------------------------------------------------------------------------
        */

        $headers = array_map(
            function ($header) {
                $header = trim((string) $header);

                // Remove UTF-8 BOM if present.
                return strtolower(
                    preg_replace('/^\xEF\xBB\xBF/', '', $header)
                );
            },
            $headers
        );

        $requiredHeaders = [
            'service_id',
            'attendance_date',
            'men',
            'women',
            'teenagers',
            'children',
            'guests',
            'notes',
        ];

        foreach ($requiredHeaders as $requiredHeader) {
            if (! in_array($requiredHeader, $headers, true)) {
                fclose($handle);

                return back()->withErrors([
                    'file' => "Missing required column: {$requiredHeader}",
                ]);
            }
        }

        $imported = 0;
        $skipped = 0;
        $rowNumber = 1;
        $skipReasons = [];

        /*
        |--------------------------------------------------------------------------
        | Process CSV Rows
        |--------------------------------------------------------------------------
        */

        while (($row = fgetcsv($handle)) !== false) {
            $rowNumber++;

            // Skip completely empty rows.
            if (
                count($row) === 1 &&
                trim((string) $row[0]) === ''
            ) {
                continue;
            }

            // Ensure the row has enough columns.
            $row = array_pad(
                $row,
                count($headers),
                ''
            );

            $data = [];

            foreach ($headers as $index => $header) {
                $data[$header] = trim(
                    (string) ($row[$index] ?? '')
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Validate Service
            |--------------------------------------------------------------------------
            */

            $serviceId = $data['service_id'];

            if (
                $serviceId === '' ||
                ! ctype_digit($serviceId) ||
                (int) $serviceId <= 0
            ) {
                $skipped++;

                $skipReasons[] =
                    "Row {$rowNumber}: Invalid service_id.";

                continue;
            }

            $service = $church->services()
                ->whereKey((int) $serviceId)
                ->first();

            if (! $service) {
                $skipped++;

                $skipReasons[] =
                    "Row {$rowNumber}: Service ID {$serviceId} does not belong to this church.";

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Parse Attendance Date
            |--------------------------------------------------------------------------
            */

            $rawDate = $data['attendance_date'];

            $attendanceDate = $this->parseImportDate(
                $rawDate
            );

            if (! $attendanceDate) {
                $skipped++;

                $skipReasons[] =
                    "Row {$rowNumber}: Invalid attendance date '{$rawDate}'. Use YYYY-MM-DD or M/D/YYYY.";

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Validate Attendance Counts
            |--------------------------------------------------------------------------
            */

            $countFields = [
                'men',
                'women',
                'teenagers',
                'children',
                'guests',
            ];

            $counts = [];
            $invalidCount = false;

            foreach ($countFields as $field) {
                $value = $data[$field];

                if (
                    $value === '' ||
                    ! ctype_digit($value)
                ) {
                    $invalidCount = true;

                    $skipReasons[] =
                        "Row {$rowNumber}: {$field} must be a whole number greater than or equal to zero.";

                    break;
                }

                $counts[$field] = (int) $value;
            }

            if ($invalidCount) {
                $skipped++;

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Prevent Duplicate Attendance
            |--------------------------------------------------------------------------
            */

            $duplicate = Attendance::query()
                ->where('church_id', $church->id)
                ->where('service_id', $service->id)
                ->whereDate(
                    'attendance_date',
                    $attendanceDate
                )
                ->exists();

            if ($duplicate) {
                $skipped++;

                $skipReasons[] =
                    "Row {$rowNumber}: Attendance already exists for {$service->name} on {$attendanceDate}.";

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Create Attendance Record
            |--------------------------------------------------------------------------
            */

            $attendance = Attendance::create([
                'church_id' => $church->id,
                'service_id' => $service->id,
                'attendance_date' => $attendanceDate,
                'men' => $counts['men'],
                'women' => $counts['women'],
                'teenagers' => $counts['teenagers'],
                'children' => $counts['children'],
                'guests' => $counts['guests'],
                'notes' => $data['notes'] !== ''
                    ? $data['notes']
                    : null,
            ]);

            $imported++;
        }

        fclose($handle);

        /*
        |--------------------------------------------------------------------------
        | Audit Log
        |--------------------------------------------------------------------------
        */

        if ($imported > 0) {
            $activityLog->record(
                action: 'imported',
                subject: null,
                description: "{$imported} attendance record(s) imported."
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        $message =
            "{$imported} attendance record(s) imported successfully.";

        if ($skipped > 0) {
            $message .= " {$skipped} row(s) were skipped.";
        }

        $redirect = redirect()
            ->route('church.attendance.import')
            ->with('success', $message);

        if (! empty($skipReasons)) {
            $redirect->with(
                'import_warnings',
                $skipReasons
            );
        }

        return $redirect;
    }

    /**
     * Export church attendance records to CSV.
     */
    public function export(): StreamedResponse
    {
        $user = auth()->user();
        $church = $user?->church;

        abort_unless($church, 403);

        abort_unless(
            $user->can('attendance.view'),
            403
        );

        $attendance = Attendance::query()
            ->with('service')
            ->where('church_id', $church->id)
            ->orderBy('attendance_date')
            ->get();

        $filename =
            'churchflow_attendance_' .
            now()->format('Y-m-d_H-i-s') .
            '.csv';

        return response()->stream(
            function () use ($attendance) {
                $file = fopen('php://output', 'w');

                fputcsv($file, [
                    'service_id',
                    'service',
                    'attendance_date',
                    'men',
                    'women',
                    'teenagers',
                    'children',
                    'guests',
                    'total',
                    'notes',
                ]);

                foreach ($attendance as $record) {
                    fputcsv($file, [
                        $record->service_id,
                        $record->service?->name,
                        $record->attendance_date?->format('Y-m-d'),
                        $record->men,
                        $record->women,
                        $record->teenagers,
                        $record->children,
                        $record->guests,
                        $record->total,
                        $record->notes,
                    ]);
                }

                fclose($file);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' =>
                    'attachment; filename="' . $filename . '"',
            ]
        );
    }

    /**
     * Parse supported CSV attendance dates.
     */
    private function parseImportDate(
        string $value
    ): ?string {
        $formats = [
            'Y-m-d',
            'n/j/Y',
            'm/d/Y',
            'n/j/y',
            'm/d/y',
        ];

        foreach ($formats as $format) {
            $date = \DateTime::createFromFormat(
                '!' . $format,
                $value
            );

            if (
                $date !== false &&
                $date->format($format) === $value
            ) {
                return $date->format('Y-m-d');
            }
        }

        return null;
    }

    /**
     * Ensure attendance belongs to the authenticated church.
     */
    private function ensureAttendanceBelongsToChurch(
        Attendance $attendance,
        int $churchId
    ): void {
        abort_unless(
            $attendance->church_id === $churchId,
            404
        );
    }
}