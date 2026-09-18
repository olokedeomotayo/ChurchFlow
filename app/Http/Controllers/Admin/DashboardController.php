<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Church;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the Platform Admin Dashboard.
     */
    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Church Statistics
        |--------------------------------------------------------------------------
        */

        $totalChurches = Church::count();

        $activeChurches = Church::where('status', 'active')->count();

        $trialChurches = Church::where('status', 'trial')->count();

        $suspendedChurches = Church::where('status', 'suspended')->count();


        /*
        |--------------------------------------------------------------------------
        | Subscription Statistics
        |--------------------------------------------------------------------------
        */

        $totalSubscriptions = Subscription::count();

        $activeSubscriptions = Subscription::where('status', 'active')->count();

        $trialSubscriptions = Subscription::where('status', 'trial')->count();

        $expiredSubscriptions = Subscription::where('status', 'expired')->count();

        $cancelledSubscriptions = Subscription::where('status', 'cancelled')->count();


        /*
        |--------------------------------------------------------------------------
        | Plan Statistics
        |--------------------------------------------------------------------------
        */

        $totalPlans = Plan::count();

        $activePlans = Plan::where('is_active', true)->count();


        /*
        |--------------------------------------------------------------------------
        | Monthly Revenue
        |--------------------------------------------------------------------------
        |
        | Revenue is calculated from actual successful payments
        | received during the current month.
        |
        | We do NOT calculate revenue from subscription plan prices,
        | because the actual amount paid may differ depending on
        | the selected billing cycle.
        |
        */

        $monthlyRevenue = Payment::query()
            ->where('status', 'success')
            ->whereNotNull('paid_at')
            ->whereBetween('paid_at', [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ])
            ->sum('amount');


        /*
        |--------------------------------------------------------------------------
        | Subscription Percentages
        |--------------------------------------------------------------------------
        */

        $subscriptionTotal = max($totalSubscriptions, 1);

        $trialPercentage = round(
            ($trialSubscriptions / $subscriptionTotal) * 100
        );

        $activePercentage = round(
            ($activeSubscriptions / $subscriptionTotal) * 100
        );

        $expiredPercentage = round(
            ($expiredSubscriptions / $subscriptionTotal) * 100
        );

        $cancelledPercentage = round(
            ($cancelledSubscriptions / $subscriptionTotal) * 100
        );


        /*
        |--------------------------------------------------------------------------
        | Recent Churches
        |--------------------------------------------------------------------------
        */

        $recentChurches = Church::query()
            ->with([
                'subscriptions.plan',
            ])
            ->latest()
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Recent Subscriptions
        |--------------------------------------------------------------------------
        */

        $recentSubscriptions = Subscription::query()
            ->with([
                'church',
                'plan',
            ])
            ->latest()
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Trials Expiring Within 7 Days
        |--------------------------------------------------------------------------
        */

        $expiringTrials = Subscription::query()
            ->with([
                'church',
                'plan',
            ])
            ->where('status', 'trial')
            ->whereNotNull('trial_ends_at')
            ->whereBetween(
                'trial_ends_at',
                [
                    now(),
                    now()->addDays(7),
                ]
            )
            ->orderBy('trial_ends_at')
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Dashboard View
        |--------------------------------------------------------------------------
        */

        return view('dashboard', compact(
            'totalChurches',
            'activeChurches',
            'trialChurches',
            'suspendedChurches',

            'totalSubscriptions',
            'activeSubscriptions',
            'trialSubscriptions',
            'expiredSubscriptions',
            'cancelledSubscriptions',

            'totalPlans',
            'activePlans',

            'monthlyRevenue',

            'trialPercentage',
            'activePercentage',
            'expiredPercentage',
            'cancelledPercentage',

            'recentChurches',
            'recentSubscriptions',
            'expiringTrials',
        ));
    }
}