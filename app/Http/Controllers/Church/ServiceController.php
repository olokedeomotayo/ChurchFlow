<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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