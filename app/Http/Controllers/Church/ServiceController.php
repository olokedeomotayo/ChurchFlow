<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\ActivityLogService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display all services belonging to the church.
     */
    public function index(Request $request): View
    {
        $church = $request->user()->church;

        if (! $church) {
            abort(403, 'Your account is not associated with a church.');
        }

        $services = $church->services()
            ->orderByDesc('service_date')
            ->orderByDesc('start_time')
            ->paginate(15)
            ->withQueryString();

        return view('church.services.index', compact('services'));
    }

    /**
     * Show the create service form.
     */
    public function create(Request $request): View
    {
        $church = $request->user()->church;

        if (! $church) {
            abort(403, 'Your account is not associated with a church.');
        }

        return view('church.services.create');
    }

    /**
     * Store a new service.
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'service_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'status' => [
                'required',
                'in:scheduled,completed,cancelled',
            ],
        ]);

        $service = $church->services()->create($validated);

        $activityLog->record(
            action: 'created',
            subject: $service,
            description: sprintf(
                'Service created: %s on %s.',
                $service->name,
                $service->service_date?->format('d M Y')
            )
        );

        return redirect()
            ->route('church.services.index')
            ->with('success', 'Service created successfully.');
    }

    /**
     * Display a single service.
     */
    public function show(
        Request $request,
        Service $service
    ): View {
        $this->ensureBelongsToChurch($request, $service);

        $service->loadCount('attendances');

        return view('church.services.show', compact('service'));
    }

    /**
     * Show the edit service form.
     */
    public function edit(
        Request $request,
        Service $service
    ): View {
        $this->ensureBelongsToChurch($request, $service);

        return view('church.services.edit', compact('service'));
    }

    /**
     * Update a service.
     */
    public function update(
        Request $request,
        Service $service,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $this->ensureBelongsToChurch($request, $service);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'service_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'status' => [
                'required',
                'in:scheduled,completed,cancelled',
            ],
        ]);

        $service->update($validated);

        $activityLog->record(
            action: 'updated',
            subject: $service,
            description: sprintf(
                'Service updated: %s on %s.',
                $service->name,
                $service->service_date?->format('d M Y')
            )
        );

        return redirect()
            ->route('church.services.index')
            ->with('success', 'Service updated successfully.');
    }

    /**
     * Delete a service.
     */
    public function destroy(
        Request $request,
        Service $service,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $this->ensureBelongsToChurch($request, $service);

        $serviceName = $service->name;
        $serviceDate = $service->service_date?->format('d M Y');

        $activityLog->record(
            action: 'deleted',
            subject: $service,
            description: sprintf(
                'Service deleted: %s on %s.',
                $serviceName,
                $serviceDate
            )
        );

        $service->delete();

        return redirect()
            ->route('church.services.index')
            ->with('success', 'Service deleted successfully.');
    }

    /**
     * Export all services for the authenticated church as CSV.
     */
    public function export(Request $request): Response
    {
        $church = $request->user()->church;

        if (! $church) {
            abort(403, 'Your account is not associated with a church.');
        }

        $services = $church->services()
            ->orderBy('service_date')
            ->orderBy('start_time')
            ->get();

        $filename = 'services-' . now()->format('Y-m-d-His') . '.csv';

        $handle = fopen('php://temp', 'r+');

        fputcsv($handle, [
            'Service ID',
            'Service Name',
            'Description',
            'Service Date',
            'Start Time',
            'End Time',
            'Status',
        ]);

        foreach ($services as $service) {
            fputcsv($handle, [
                $service->id,
                $service->name,
                $service->description,
                $service->service_date?->format('Y-m-d'),
                $service->start_time
                    ? Carbon::parse($service->start_time)->format('H:i')
                    : '',
                $service->end_time
                    ? Carbon::parse($service->end_time)->format('H:i')
                    : '',
                $service->status,
            ]);
        }

        rewind($handle);

        $csv = stream_get_contents($handle);

        fclose($handle);

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Show the service import page.
     */
    public function import(Request $request): View
    {
        $church = $request->user()->church;

        if (! $church) {
            abort(403, 'Your account is not associated with a church.');
        }

        return view('church.services.import');
    }

    /**
     * Import services from CSV.
     */
    public function importStore(
        Request $request,
        ActivityLogService $activityLog
    ): RedirectResponse {
        $church = $request->user()->church;

        if (! $church) {
            abort(403, 'Your account is not associated with a church.');
        }

        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:csv,txt',
                'max:10240',
            ],
        ]);

        $file = $request->file('file');

        $handle = fopen($file->getRealPath(), 'r');

        if (! $handle) {
            return back()->withErrors([
                'file' => 'Unable to read the uploaded CSV file.',
            ]);
        }

        $header = fgetcsv($handle);

        if (! $header) {
            fclose($handle);

            return back()->withErrors([
                'file' => 'The uploaded CSV file is empty.',
            ]);
        }

        $header = array_map(
            fn ($value) => trim((string) $value),
            $header
        );

        $requiredHeaders = [
            'Service Name',
            'Description',
            'Service Date',
            'Start Time',
            'End Time',
            'Status',
        ];

        foreach ($requiredHeaders as $requiredHeader) {
            if (! in_array($requiredHeader, $header, true)) {
                fclose($handle);

                return back()->withErrors([
                    'file' => "Missing required column: {$requiredHeader}",
                ]);
            }
        }

        $columnMap = array_flip($header);

        $imported = 0;
        $skipped = 0;
        $failed = 0;
        $errors = [];
        $rowNumber = 1;

        DB::beginTransaction();

        try {
            while (($row = fgetcsv($handle)) !== false) {
                $rowNumber++;

                if (
                    count(array_filter(
                        $row,
                        fn ($value) => trim((string) $value) !== ''
                    )) === 0
                ) {
                    continue;
                }

                $getValue = function (string $column) use ($row, $columnMap): string {
                    $index = $columnMap[$column] ?? null;

                    if ($index === null) {
                        return '';
                    }

                    return trim((string) ($row[$index] ?? ''));
                };

                $name = $getValue('Service Name');
                $description = $getValue('Description');
                $serviceDate = $getValue('Service Date');
                $startTime = $getValue('Start Time');
                $endTime = $getValue('End Time');
                $status = strtolower($getValue('Status'));

                try {
                    if ($name === '') {
                        throw new \RuntimeException(
                            'Service Name is required.'
                        );
                    }

                    if ($serviceDate === '') {
                        throw new \RuntimeException(
                            'Service Date is required.'
                        );
                    }

                    $parsedDate = Carbon::parse($serviceDate);

                    if ($startTime !== '') {
                        $parsedStartTime = Carbon::createFromFormat(
                            'H:i',
                            $startTime
                        );
                    } else {
                        $parsedStartTime = null;
                    }

                    if ($endTime !== '') {
                        $parsedEndTime = Carbon::createFromFormat(
                            'H:i',
                            $endTime
                        );
                    } else {
                        $parsedEndTime = null;
                    }

                    if (! in_array(
                        $status,
                        ['scheduled', 'completed', 'cancelled'],
                        true
                    )) {
                        throw new \RuntimeException(
                            'Status must be scheduled, completed, or cancelled.'
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Prevent duplicates
                    |--------------------------------------------------------------------------
                    |
                    | A duplicate is identified by:
                    | Church + Service Name + Service Date
                    |
                    */

                    $duplicate = $church->services()
                        ->where('name', $name)
                        ->whereDate('service_date', $parsedDate->toDateString())
                        ->exists();

                    if ($duplicate) {
                        $skipped++;

                        continue;
                    }

                    $service = $church->services()->create([
                        'name' => $name,
                        'description' => $description !== ''
                            ? $description
                            : null,
                        'service_date' => $parsedDate->toDateString(),
                        'start_time' => $parsedStartTime?->format('H:i'),
                        'end_time' => $parsedEndTime?->format('H:i'),
                        'status' => $status,
                    ]);

                    $activityLog->record(
                        action: 'created',
                        subject: $service,
                        description: sprintf(
                            'Service imported: %s on %s.',
                            $service->name,
                            $service->service_date?->format('d M Y')
                        )
                    );

                    $imported++;
                } catch (\Throwable $exception) {
                    $failed++;

                    $errors[] = sprintf(
                        'Row %d: %s',
                        $rowNumber,
                        $exception->getMessage()
                    );
                }
            }

            fclose($handle);

            DB::commit();
        } catch (\Throwable $exception) {
            if (is_resource($handle)) {
                fclose($handle);
            }

            DB::rollBack();

            return back()->withErrors([
                'file' => 'The import failed: ' . $exception->getMessage(),
            ]);
        }

        $message = sprintf(
            'Service import completed. Imported: %d, skipped: %d, failed: %d.',
            $imported,
            $skipped,
            $failed
        );

        if ($errors) {
            session()->flash('import_errors', $errors);
        }

        return redirect()
            ->route('church.services.index')
            ->with('success', $message);
    }

    /**
     * Download a CSV template for service imports.
     */
    public function downloadTemplate(Request $request): Response
    {
        $church = $request->user()->church;

        if (! $church) {
            abort(403, 'Your account is not associated with a church.');
        }

        $filename = 'services-import-template.csv';

        $handle = fopen('php://temp', 'r+');

        fputcsv($handle, [
            'Service Name',
            'Description',
            'Service Date',
            'Start Time',
            'End Time',
            'Status',
        ]);

        fputcsv($handle, [
            'Celebration Service',
            'Weekly Sunday Celebration Service.',
            '2026-10-04',
            '08:00',
            '11:00',
            'scheduled',
        ]);

        fputcsv($handle, [
            'Bible Study',
            'Weekly Bible Study and discipleship service.',
            '2026-10-06',
            '18:00',
            '19:30',
            'scheduled',
        ]);

        rewind($handle);

        $csv = stream_get_contents($handle);

        fclose($handle);

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Ensure the service belongs to the authenticated user's church.
     */
    private function ensureBelongsToChurch(
        Request $request,
        Service $service
    ): void {
        $church = $request->user()->church;

        if (! $church || $service->church_id !== $church->id) {
            abort(404);
        }
    }
}