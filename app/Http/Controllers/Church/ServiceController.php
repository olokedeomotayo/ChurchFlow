<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $church = $request->user()->church;

        if (!$church) {
            abort(403, 'Your account is not associated with a church.');
        }

        $services = $church->services()
            ->orderByDesc('service_date')
            ->orderByDesc('start_time')
            ->paginate(15)
            ->withQueryString();

        return view('church.services.index', compact('services'));
    }

    public function create(Request $request): View
    {
        $church = $request->user()->church;

        if (!$church) {
            abort(403, 'Your account is not associated with a church.');
        }

        return view('church.services.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $church = $request->user()->church;

        if (!$church) {
            abort(403, 'Your account is not associated with a church.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'service_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'status' => ['required', 'in:scheduled,completed,cancelled'],
        ]);

        $church->services()->create($validated);

        return redirect()
            ->route('church.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function show(Request $request, Service $service): View
    {
        $this->ensureBelongsToChurch($request, $service);

        $service->loadCount('attendances');

        return view('church.services.show', compact('service'));
    }

    public function edit(Request $request, Service $service): View
    {
        $this->ensureBelongsToChurch($request, $service);

        return view('church.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $this->ensureBelongsToChurch($request, $service);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'service_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'status' => ['required', 'in:scheduled,completed,cancelled'],
        ]);

        $service->update($validated);

        return redirect()
            ->route('church.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Request $request, Service $service): RedirectResponse
    {
        $this->ensureBelongsToChurch($request, $service);

        $service->delete();

        return redirect()
            ->route('church.services.index')
            ->with('success', 'Service deleted successfully.');
    }

    private function ensureBelongsToChurch(
        Request $request,
        Service $service
    ): void {
        $church = $request->user()->church;

        if (!$church || $service->church_id !== $church->id) {
            abort(404);
        }
    }
}