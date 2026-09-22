<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Member;
use App\Models\Setting;
use App\Models\Subscription;
use App\Services\ChurchFinancialService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ChurchDashboardController extends Controller
{
    /**
     * Display the church dashboard.
     */
    public function index(ChurchFinancialService $financialService): View
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
        */

        $totalMembers = 0;
   

        /*
        |--------------------------------------------------------------------------
        | Financial Position
        |--------------------------------------------------------------------------
        */

        $openingBalance = 0;
        $openingBalanceDate = null;
        $incomeSinceOpeningBalance = 0;
        $expensesSinceOpeningBalance = 0;
        $currentBalance = 0;

        /*
        |--------------------------------------------------------------------------
        | Monthly Financial Summary
        |--------------------------------------------------------------------------
        */

        $incomeThisMonth = 0;
        $expensesThisMonth = 0;
        $netBalanceThisMonth = 0;

        /*
        |--------------------------------------------------------------------------
        | Annual Financial Summary
        |--------------------------------------------------------------------------
        */

        $incomeThisYear = 0;
        $expensesThisYear = 0;
        $netBalanceThisYear = 0;

        if ($church) {

            /*
            |--------------------------------------------------------------------------
            | Membership
            |--------------------------------------------------------------------------
            */

            $totalMembers = Member::query()
                ->where('church_id', $church->id)
                ->count();

            /*
            |--------------------------------------------------------------------------
            | Today's Attendance
            |--------------------------------------------------------------------------
            */

           

            /*
            |--------------------------------------------------------------------------
            | Opening Balance
            |--------------------------------------------------------------------------
            */

            $openingBalance = $financialService->openingBalance($church);

            $openingBalanceDate = $financialService->openingBalanceDate($church);

            /*
            |--------------------------------------------------------------------------
            | Financial Activity Since Opening Balance
            |--------------------------------------------------------------------------
            |
            | These values are calculated using the opening balance date.
            |
            | Income on/after opening date
            | - Expenses on/after opening date
            | = Movement since opening
            |
            */

            $incomeSinceOpeningBalance =
                $financialService->incomeSinceOpeningBalance($church);

            $expensesSinceOpeningBalance =
                $financialService->expensesSinceOpeningBalance($church);

            /*
            |--------------------------------------------------------------------------
            | Current Financial Balance
            |--------------------------------------------------------------------------
            |
            | Opening Balance
            | + Income since opening date
            | - Expenses since opening date
            | = Current Balance
            |
            */

            $currentBalance =
                $financialService->currentBalance($church);

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

            $netBalanceThisMonth =
                $incomeThisMonth - $expensesThisMonth;

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

            $netBalanceThisYear =
                $incomeThisYear - $expensesThisYear;
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
            

            /*
            | Financial Position
            */
            'openingBalance' => $openingBalance,
            'openingBalanceDate' => $openingBalanceDate,
            'incomeSinceOpeningBalance' => $incomeSinceOpeningBalance,
            'expensesSinceOpeningBalance' => $expensesSinceOpeningBalance,
            'currentBalance' => $currentBalance,

            /*
            | Monthly Financial Summary
            */
            'incomeThisMonth' => $incomeThisMonth,
            'expensesThisMonth' => $expensesThisMonth,
            'netBalanceThisMonth' => $netBalanceThisMonth,

            /*
            | Annual Financial Summary
            */
            'incomeThisYear' => $incomeThisYear,
            'expensesThisYear' => $expensesThisYear,
            'netBalanceThisYear' => $netBalanceThisYear,
        ]);
    }
}