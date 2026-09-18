<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ChurchDashboardController extends Controller
{
    /**
     * Display the church dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();

        $church = $user?->church;

        /*
        |--------------------------------------------------------------------------
        | Trial Period
        |--------------------------------------------------------------------------
        |
        | Get the trial period configured by the Platform Admin.
        | Default to 30 days if no setting exists.
        |
        */

        $trialPeriod = (int) (
            Setting::where('key', 'trial_period')
                ->value('value') ?? 30
        );


        /*
        |--------------------------------------------------------------------------
        | Current Subscription
        |--------------------------------------------------------------------------
        |
        | Always prioritize the church's active paid subscription.
        |
        */

        $subscription = null;

        if ($church) {

            $subscription = Subscription::query()
                ->with('plan')
                ->where('church_id', $church->id)
                ->where('status', 'active')
                ->latest('starts_at')
                ->first();
        }


        /*
        |--------------------------------------------------------------------------
        | Trial Subscription
        |--------------------------------------------------------------------------
        |
        | Only retrieve the trial subscription when there is
        | no active paid subscription.
        |
        */

        $trialSubscription = null;

        if ($church && !$subscription) {

            $trialSubscription = Subscription::query()
                ->with('plan')
                ->where('church_id', $church->id)
                ->where('status', 'trial')
                ->latest()
                ->first();
        }


        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        return view('church.dashboard', [

            'user' => $user,

            'church' => $church,

            'trialPeriod' => $trialPeriod,

            'subscription' => $subscription,

            'trialSubscription' => $trialSubscription,

        ]);
    }
}