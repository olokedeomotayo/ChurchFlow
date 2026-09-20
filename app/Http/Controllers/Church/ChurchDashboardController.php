<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Member;
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
        */

        $trialPeriod = (int) (
            Setting::where('key', 'trial_period')->value('value') ?? 30
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

        if ($church && ! $subscription) {
            $trialSubscription = Subscription::query()
                ->with('plan')
                ->where('church_id', $church->id)
                ->where('status', 'trial')
                ->latest()
                ->first();
        }

        /*
        |--------------------------------------------------------------------------
        | Dashboard Statistics
        |--------------------------------------------------------------------------
        |
        | All figures are restricted to the authenticated church.
        |
        */

        $totalMembers = 0;
        $todayCheckIns = 0;

        $incomeThisMonth = 0;
        $expensesThisMonth = 0;
        $netBalanceThisMonth = 0;

        $incomeThisYear = 0;
        $expensesThisYear = 0;
        $netBalanceThisYear = 0;

        if ($church) {

            /*
            |--------------------------------------------------------------------------
            | Total Members
            |--------------------------------------------------------------------------
            */

            $totalMembers = Member::query()
                ->where('church_id', $church->id)
                ->count();

            /*
            |--------------------------------------------------------------------------
            | Today's Check-Ins
            |--------------------------------------------------------------------------
            */

            $todayCheckIns = Attendance::query()
                ->where('church_id', $church->id)
                ->whereDate('checked_in_at', today())
                ->count();

            /*
            |--------------------------------------------------------------------------
            | Current Month
            |--------------------------------------------------------------------------
            */

            $monthStart = now()->startOfMonth()->toDateString();
            $monthEnd = now()->endOfMonth()->toDateString();

            $incomeThisMonth = Income::query()
                ->where('church_id', $church->id)
                ->whereBetween('income_date', [
                    $monthStart,
                    $monthEnd,
                ])
                ->sum('amount');

            $expensesThisMonth = Expense::query()
                ->where('church_id', $church->id)
                ->whereBetween('expense_date', [
                    $monthStart,
                    $monthEnd,
                ])
                ->sum('amount');

            $netBalanceThisMonth = $incomeThisMonth - $expensesThisMonth;

            /*
            |--------------------------------------------------------------------------
            | Current Year
            |--------------------------------------------------------------------------
            */

            $yearStart = now()->startOfYear()->toDateString();
            $yearEnd = now()->endOfYear()->toDateString();

            $incomeThisYear = Income::query()
                ->where('church_id', $church->id)
                ->whereBetween('income_date', [
                    $yearStart,
                    $yearEnd,
                ])
                ->sum('amount');

            $expensesThisYear = Expense::query()
                ->where('church_id', $church->id)
                ->whereBetween('expense_date', [
                    $yearStart,
                    $yearEnd,
                ])
                ->sum('amount');

            $netBalanceThisYear = $incomeThisYear - $expensesThisYear;
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

            'totalMembers' => $totalMembers,
            'todayCheckIns' => $todayCheckIns,

            'incomeThisMonth' => $incomeThisMonth,
            'expensesThisMonth' => $expensesThisMonth,
            'netBalanceThisMonth' => $netBalanceThisMonth,

            'incomeThisYear' => $incomeThisYear,
            'expensesThisYear' => $expensesThisYear,
            'netBalanceThisYear' => $netBalanceThisYear,
        ]);
    }
}