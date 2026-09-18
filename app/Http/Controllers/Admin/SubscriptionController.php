<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    /**
     * Display all church subscriptions.
     */
    public function index(): View
    {
        $subscriptions = Subscription::query()
            ->with([
                'church',
                'plan',
            ])
            ->latest()
            ->get();

        return view(
            'admin.subscriptions.index',
            compact('subscriptions')
        );
    }


    /**
     * Display a specific subscription.
     */
    public function show(Subscription $subscription): View
    {
        $subscription->load([
            'church',
            'plan',
        ]);

        return view(
            'admin.subscriptions.show',
            compact('subscription')
        );
    }


    /**
     * Activate a subscription.
     */
    public function activate(
        Subscription $subscription
    ): RedirectResponse {

        if ($subscription->status === 'active') {
            return back()->with(
                'success',
                'This subscription is already active.'
            );
        }

        DB::transaction(function () use ($subscription) {

            $subscription->update([
                'status' => 'active',
                'cancelled_at' => null,
                'starts_at' => $subscription->starts_at ?? now(),
                'ends_at' => $subscription->ends_at ?? now()->addMonth(),
            ]);

            if ($subscription->church) {
                $subscription->church->update([
                    'status' => 'active',
                ]);
            }
        });

        return back()->with(
            'success',
            'Subscription activated successfully.'
        );
    }


    /**
     * Extend the trial period.
     */
    public function extendTrial(
        Subscription $subscription
    ): RedirectResponse {

        if ($subscription->status !== 'trial') {
            return back()->with(
                'error',
                'Only subscriptions currently in trial can be extended.'
            );
        }

        DB::transaction(function () use ($subscription) {

            $currentEnd = $subscription->trial_ends_at
                ? Carbon::parse($subscription->trial_ends_at)
                : now();

            $newTrialEnd = $currentEnd->copy()->addDays(30);

            $subscription->update([
                'trial_ends_at' => $newTrialEnd,
                'ends_at' => $newTrialEnd,
            ]);

            if ($subscription->church) {
                $subscription->church->update([
                    'trial_ends_at' => $newTrialEnd,
                    'status' => 'trial',
                ]);
            }
        });

        return back()->with(
            'success',
            'Trial period extended by 30 days successfully.'
        );
    }


    /**
     * Change the subscription plan.
     */
    public function changePlan(
        Subscription $subscription
    ): View {

        $plans = Plan::query()
            ->where('is_active', true)
            ->orderBy('price')
            ->get();

        return view(
            'admin.subscriptions.change-plan',
            compact(
                'subscription',
                'plans'
            )
        );
    }


    /**
     * Update the subscription plan.
     */
    public function updatePlan(
        Subscription $subscription
    ): RedirectResponse {

        request()->validate([
            'plan_id' => [
                'required',
                'integer',
                'exists:plans,id',
            ],
        ]);

        $plan = Plan::query()
            ->where('is_active', true)
            ->findOrFail(
                request('plan_id')
            );

        $subscription->update([
            'plan_id' => $plan->id,
        ]);

        return redirect()
            ->route(
                'admin.subscriptions.show',
                $subscription
            )
            ->with(
                'success',
                'Subscription plan updated successfully.'
            );
    }


    /**
     * Cancel a subscription.
     */
    public function cancel(
        Subscription $subscription
    ): RedirectResponse {

        if ($subscription->status === 'cancelled') {
            return back()->with(
                'success',
                'This subscription is already cancelled.'
            );
        }

        DB::transaction(function () use ($subscription) {

            $subscription->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);

            if ($subscription->church) {
                $subscription->church->update([
                    'status' => 'inactive',
                ]);
            }
        });

        return back()->with(
            'success',
            'Subscription cancelled successfully.'
        );
    }


    /**
     * Renew a subscription.
     */
    public function renew(
        Subscription $subscription
    ): RedirectResponse {

        DB::transaction(function () use ($subscription) {

            $startDate = now();

            $endDate = match ($subscription->plan?->billing_cycle) {

                'yearly',
                'annual' => $startDate->copy()->addYear(),

                'weekly' => $startDate->copy()->addWeek(),

                'quarterly' => $startDate->copy()->addMonths(3),

                default => $startDate->copy()->addMonth(),

            };

            $subscription->update([
                'status' => 'active',
                'starts_at' => $startDate,
                'ends_at' => $endDate,
                'trial_ends_at' => null,
                'cancelled_at' => null,
            ]);

            if ($subscription->church) {
                $subscription->church->update([
                    'status' => 'active',
                    'trial_ends_at' => null,
                ]);
            }
        });

        return back()->with(
            'success',
            'Subscription renewed successfully.'
        );
    }
}