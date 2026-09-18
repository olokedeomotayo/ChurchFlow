<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlanController extends Controller
{
    /**
     * Display all subscription plans.
     */
    public function index(): View
    {
        $plans = Plan::query()
            ->withCount('subscriptions')
            ->latest()
            ->get();

        return view('admin.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new plan.
     */
    public function create(): View
    {
        return view('admin.plans.create');
    }

    /**
     * Store a new subscription plan.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:plans,slug'],
            'description' => ['nullable', 'string'],

            // Pricing
            'monthly_price' => ['required', 'numeric', 'min:0'],
            'annual_price' => ['required', 'numeric', 'min:0'],

            // Usage
            'member_limit' => ['nullable', 'integer', 'min:1'],

            // Status
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        Plan::create($validated);

        return redirect()
            ->route('admin.plans.index')
            ->with(
                'success',
                'Subscription plan created successfully.'
            );
    }

    /**
     * Show the form for editing a plan.
     */
    public function edit(Plan $plan): View
    {
        $plan->loadCount('subscriptions');

        return view('admin.plans.edit', compact('plan'));
    }

    /**
     * Update an existing subscription plan.
     */
    public function update(
        Request $request,
        Plan $plan
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:plans,slug,' . $plan->id,
            ],
            'description' => ['nullable', 'string'],

            // Pricing
            'monthly_price' => ['required', 'numeric', 'min:0'],
            'annual_price' => ['required', 'numeric', 'min:0'],

            // Usage
            'member_limit' => ['nullable', 'integer', 'min:1'],

            // Status
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $plan->update($validated);

        return redirect()
            ->route('admin.plans.index')
            ->with(
                'success',
                'Subscription plan updated successfully.'
            );
    }

    /**
     * Activate a subscription plan.
     */
    public function activate(Plan $plan): RedirectResponse
    {
        $plan->update([
            'is_active' => true,
        ]);

        return back()->with(
            'success',
            'Subscription plan activated successfully.'
        );
    }

    /**
     * Deactivate a subscription plan.
     */
    public function deactivate(Plan $plan): RedirectResponse
    {
        $plan->update([
            'is_active' => false,
        ]);

        return back()->with(
            'success',
            'Subscription plan deactivated successfully.'
        );
    }
}