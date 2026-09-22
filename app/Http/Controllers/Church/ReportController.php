<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Expense;
use App\Models\FinancialAccount;
use App\Models\Income;
use App\Models\Member;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Display the church financial report.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $church = $user?->church;

        [$period, $startDate, $endDate] = $this->resolveReportPeriod($request);

        $selectedAccountId = $request->filled('financial_account_id')
            ? (int) $request->financial_account_id
            : null;

        $selectedAccount = null;

        $totalIncome = 0;
        $totalExpenses = 0;
        $netBalance = 0;

        $openingBalance = 0;
        $openingBalanceDate = null;
        $periodOpeningBalance = 0;
        $closingBalance = 0;

        $totalMembers = 0;
        $totalServices = 0;
        $totalAttendance = 0;

        $incomeByCategory = collect();
        $expensesByCategory = collect();

        $incomeTransactions = collect();
        $expenseTransactions = collect();

        $accounts = collect();

        /*
        |--------------------------------------------------------------------------
        | Church Financial Data
        |--------------------------------------------------------------------------
        */

        if ($church) {

            /*
            |--------------------------------------------------------------------------
            | Financial Accounts
            |--------------------------------------------------------------------------
            */

            $accounts = FinancialAccount::query()
                ->where('church_id', $church->id)
                ->orderByDesc('is_default')
                ->orderBy('name')
                ->get();

            /*
            |--------------------------------------------------------------------------
            | Selected Financial Account
            |--------------------------------------------------------------------------
            */

            if ($selectedAccountId) {

                $selectedAccount = $accounts
                    ->firstWhere('id', $selectedAccountId);

                abort_unless(
                    $selectedAccount,
                    404,
                    'The selected financial account was not found.'
                );

            }

            /*
            |--------------------------------------------------------------------------
            | Base Income Query
            |--------------------------------------------------------------------------
            */

            $incomeQuery = Income::query()
                ->where('church_id', $church->id)
                ->with(['member', 'financialAccount']);

            if ($selectedAccount) {
                $incomeQuery->where(
                    'financial_account_id',
                    $selectedAccount->id
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Base Expense Query
            |--------------------------------------------------------------------------
            */

            $expenseQuery = Expense::query()
                ->where('church_id', $church->id)
                ->with(['member', 'financialAccount']);

            if ($selectedAccount) {
                $expenseQuery->where(
                    'financial_account_id',
                    $selectedAccount->id
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Period Income
            |--------------------------------------------------------------------------
            */

            $periodIncomeQuery = (clone $incomeQuery)
                ->whereBetween('income_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ]);

            $totalIncome = (float) $periodIncomeQuery->sum('amount');

            /*
            |--------------------------------------------------------------------------
            | Period Expenses
            |--------------------------------------------------------------------------
            */

            $periodExpenseQuery = (clone $expenseQuery)
                ->whereBetween('expense_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ]);

            $totalExpenses = (float) $periodExpenseQuery->sum('amount');

            /*
            |--------------------------------------------------------------------------
            | Net Movement
            |--------------------------------------------------------------------------
            */

            $netBalance = $totalIncome - $totalExpenses;

            /*
            |--------------------------------------------------------------------------
            | Opening Financial Position
            |--------------------------------------------------------------------------
            */

            if ($selectedAccount) {

                $openingBalance = (float) $selectedAccount->opening_balance;

                $openingBalanceDate =
                    $selectedAccount->opening_balance_date;

                $periodOpeningBalance = $openingBalance;

                /*
                |--------------------------------------------------------------------------
                | Transactions Before Report Period
                |--------------------------------------------------------------------------
                */

                if (
                    $openingBalanceDate &&
                    $startDate->toDateString() >
                    $openingBalanceDate->toDateString()
                ) {

                    $incomeBeforePeriod = (clone $incomeQuery)
                        ->whereDate(
                            'income_date',
                            '>=',
                            $openingBalanceDate
                        )
                        ->whereDate(
                            'income_date',
                            '<',
                            $startDate
                        )
                        ->sum('amount');

                    $expensesBeforePeriod = (clone $expenseQuery)
                        ->whereDate(
                            'expense_date',
                            '>=',
                            $openingBalanceDate
                        )
                        ->whereDate(
                            'expense_date',
                            '<',
                            $startDate
                        )
                        ->sum('amount');

                    $periodOpeningBalance =
                        $openingBalance
                        + (float) $incomeBeforePeriod
                        - (float) $expensesBeforePeriod;
                }

            } else {

                /*
                |--------------------------------------------------------------------------
                | All Accounts Opening Position
                |--------------------------------------------------------------------------
                |
                | Sum all financial account opening balances.
                |
                */

                $openingBalance = (float) $accounts->sum(
                    fn (FinancialAccount $account) =>
                        (float) $account->opening_balance
                );

                $openingBalanceDate = $accounts
                    ->filter(
                        fn (FinancialAccount $account) =>
                            $account->opening_balance_date !== null
                    )
                    ->min('opening_balance_date');

                $periodOpeningBalance = $openingBalance;

                /*
                |--------------------------------------------------------------------------
                | All Transactions Before Report Period
                |--------------------------------------------------------------------------
                |
                | All Accounts mode also includes legacy transactions that
                | may not yet have a financial_account_id.
                |
                */

                if (
                    $openingBalanceDate &&
                    $startDate->toDateString() >
                    $openingBalanceDate->toDateString()
                ) {

                    $incomeBeforePeriod = Income::query()
                        ->where('church_id', $church->id)
                        ->whereDate(
                            'income_date',
                            '>=',
                            $openingBalanceDate
                        )
                        ->whereDate(
                            'income_date',
                            '<',
                            $startDate
                        )
                        ->sum('amount');

                    $expensesBeforePeriod = Expense::query()
                        ->where('church_id', $church->id)
                        ->whereDate(
                            'expense_date',
                            '>=',
                            $openingBalanceDate
                        )
                        ->whereDate(
                            'expense_date',
                            '<',
                            $startDate
                        )
                        ->sum('amount');

                    $periodOpeningBalance =
                        $openingBalance
                        + (float) $incomeBeforePeriod
                        - (float) $expensesBeforePeriod;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Closing Balance
            |--------------------------------------------------------------------------
            */

            $closingBalance =
                $periodOpeningBalance
                + $totalIncome
                - $totalExpenses;

            /*
            |--------------------------------------------------------------------------
            | Income By Category
            |--------------------------------------------------------------------------
            */

            $incomeByCategory = (clone $periodIncomeQuery)
                ->selectRaw('category, SUM(amount) as total')
                ->groupBy('category')
                ->orderByDesc('total')
                ->get();

            /*
            |--------------------------------------------------------------------------
            | Expenses By Category
            |--------------------------------------------------------------------------
            */

            $expensesByCategory = (clone $periodExpenseQuery)
                ->selectRaw('category, SUM(amount) as total')
                ->groupBy('category')
                ->orderByDesc('total')
                ->get();

            /*
            |--------------------------------------------------------------------------
            | Income Transactions
            |--------------------------------------------------------------------------
            */

            $incomeTransactions = (clone $periodIncomeQuery)
                ->orderByDesc('income_date')
                ->orderByDesc('id')
                ->get();

            /*
            |--------------------------------------------------------------------------
            | Expense Transactions
            |--------------------------------------------------------------------------
            */

            $expenseTransactions = (clone $periodExpenseQuery)
                ->orderByDesc('expense_date')
                ->orderByDesc('id')
                ->get();

            /*
            |--------------------------------------------------------------------------
            | Church Summary
            |--------------------------------------------------------------------------
            */

            $totalMembers = Member::query()
                ->where('church_id', $church->id)
                ->count();

            $totalServices = Service::query()
                ->where('church_id', $church->id)
                ->count();

            $totalAttendance = Attendance::query()
                ->where('church_id', $church->id)
                ->count();
        }

        /*
        |--------------------------------------------------------------------------
        | Report Label
        |--------------------------------------------------------------------------
        */

        $reportLabel = $this->getReportLabel(
            $period,
            $startDate,
            $endDate
        );

        /*
        |--------------------------------------------------------------------------
        | Report View
        |--------------------------------------------------------------------------
        */

        return view('church.reports.index', [
            'user' => $user,
            'church' => $church,

            // Financial accounts
            'accounts' => $accounts,
            'selectedAccount' => $selectedAccount,
            'selectedAccountId' => $selectedAccountId,

            // Period activity
            'totalIncome' => $totalIncome,
            'totalExpenses' => $totalExpenses,
            'netBalance' => $netBalance,

            // Financial position
            'openingBalance' => $openingBalance,
            'openingBalanceDate' => $openingBalanceDate,
            'periodOpeningBalance' => $periodOpeningBalance,
            'closingBalance' => $closingBalance,

            // Church summary
            'totalMembers' => $totalMembers,
            'totalServices' => $totalServices,
            'totalAttendance' => $totalAttendance,

            // Categories
            'incomeByCategory' => $incomeByCategory,
            'expensesByCategory' => $expensesByCategory,

            // Transactions
            'incomeTransactions' => $incomeTransactions,
            'expenseTransactions' => $expenseTransactions,

            // Period
            'period' => $period,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'reportLabel' => $reportLabel,
        ]);
    }


    /**
     * Export church financial transactions as CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $user = Auth::user();
        $church = $user?->church;

        [$period, $startDate, $endDate] =
            $this->resolveReportPeriod($request);

        $selectedAccountId = $request->filled('financial_account_id')
            ? (int) $request->financial_account_id
            : null;

        $selectedAccount = null;

        $incomeTransactions = collect();
        $expenseTransactions = collect();

        $totalIncome = 0;
        $totalExpenses = 0;

        $periodOpeningBalance = 0;
        $closingBalance = 0;

        $accounts = collect();

        /*
        |--------------------------------------------------------------------------
        | Financial Data
        |--------------------------------------------------------------------------
        */

        if ($church) {

            $accounts = FinancialAccount::query()
                ->where('church_id', $church->id)
                ->orderByDesc('is_default')
                ->orderBy('name')
                ->get();

            if ($selectedAccountId) {

                $selectedAccount = $accounts
                    ->firstWhere('id', $selectedAccountId);

                abort_unless(
                    $selectedAccount,
                    404,
                    'The selected financial account was not found.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Income Query
            |--------------------------------------------------------------------------
            */

            $incomeQuery = Income::query()
                ->where('church_id', $church->id);

            if ($selectedAccount) {
                $incomeQuery->where(
                    'financial_account_id',
                    $selectedAccount->id
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Expense Query
            |--------------------------------------------------------------------------
            */

            $expenseQuery = Expense::query()
                ->where('church_id', $church->id);

            if ($selectedAccount) {
                $expenseQuery->where(
                    'financial_account_id',
                    $selectedAccount->id
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Period Totals
            |--------------------------------------------------------------------------
            */

            $totalIncome = (float) (clone $incomeQuery)
                ->whereBetween('income_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ])
                ->sum('amount');

            $totalExpenses = (float) (clone $expenseQuery)
                ->whereBetween('expense_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ])
                ->sum('amount');

            /*
            |--------------------------------------------------------------------------
            | Opening Balance
            |--------------------------------------------------------------------------
            */

            if ($selectedAccount) {

                $periodOpeningBalance =
                    (float) $selectedAccount->opening_balance;

                $openingBalanceDate =
                    $selectedAccount->opening_balance_date;

                if (
                    $openingBalanceDate &&
                    $startDate->toDateString() >
                    $openingBalanceDate->toDateString()
                ) {

                    $incomeBeforePeriod = (clone $incomeQuery)
                        ->whereDate(
                            'income_date',
                            '>=',
                            $openingBalanceDate
                        )
                        ->whereDate(
                            'income_date',
                            '<',
                            $startDate
                        )
                        ->sum('amount');

                    $expensesBeforePeriod = (clone $expenseQuery)
                        ->whereDate(
                            'expense_date',
                            '>=',
                            $openingBalanceDate
                        )
                        ->whereDate(
                            'expense_date',
                            '<',
                            $startDate
                        )
                        ->sum('amount');

                    $periodOpeningBalance +=
                        (float) $incomeBeforePeriod
                        - (float) $expensesBeforePeriod;
                }

            } else {

                $periodOpeningBalance = (float) $accounts->sum(
                    fn (FinancialAccount $account) =>
                        (float) $account->opening_balance
                );

                $openingBalanceDate = $accounts
                    ->filter(
                        fn (FinancialAccount $account) =>
                            $account->opening_balance_date !== null
                    )
                    ->min('opening_balance_date');

                if (
                    $openingBalanceDate &&
                    $startDate->toDateString() >
                    $openingBalanceDate->toDateString()
                ) {

                    $incomeBeforePeriod = Income::query()
                        ->where('church_id', $church->id)
                        ->whereDate(
                            'income_date',
                            '>=',
                            $openingBalanceDate
                        )
                        ->whereDate(
                            'income_date',
                            '<',
                            $startDate
                        )
                        ->sum('amount');

                    $expensesBeforePeriod = Expense::query()
                        ->where('church_id', $church->id)
                        ->whereDate(
                            'expense_date',
                            '>=',
                            $openingBalanceDate
                        )
                        ->whereDate(
                            'expense_date',
                            '<',
                            $startDate
                        )
                        ->sum('amount');

                    $periodOpeningBalance +=
                        (float) $incomeBeforePeriod
                        - (float) $expensesBeforePeriod;
                }
            }

            $closingBalance =
                $periodOpeningBalance
                + $totalIncome
                - $totalExpenses;

            /*
            |--------------------------------------------------------------------------
            | Transactions
            |--------------------------------------------------------------------------
            */

            $incomeTransactions = (clone $incomeQuery)
                ->with('financialAccount')
                ->whereBetween('income_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ])
                ->orderBy('income_date')
                ->orderBy('id')
                ->get();

            $expenseTransactions = (clone $expenseQuery)
                ->with('financialAccount')
                ->whereBetween('expense_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ])
                ->orderBy('expense_date')
                ->orderBy('id')
                ->get();
        }

        $netBalance = $totalIncome - $totalExpenses;

        $filename = 'church-financial-report-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(
            function () use (
                $period,
                $startDate,
                $endDate,
                $periodOpeningBalance,
                $totalIncome,
                $totalExpenses,
                $netBalance,
                $closingBalance,
                $selectedAccount,
                $incomeTransactions,
                $expenseTransactions
            ) {

                $handle = fopen('php://output', 'w');

                /*
                |--------------------------------------------------------------------------
                | Report Summary
                |--------------------------------------------------------------------------
                */

                fputcsv($handle, [
                    'CHURCH FINANCIAL REPORT',
                ]);

                fputcsv($handle, [
                    'Period',
                    $this->getReportLabel(
                        $period,
                        $startDate,
                        $endDate
                    ),
                ]);

                fputcsv($handle, [
                    'Financial Account',
                    $selectedAccount?->name ?? 'All Accounts',
                ]);

                fputcsv($handle, []);

                fputcsv($handle, [
                    'FINANCIAL SUMMARY',
                ]);

                fputcsv($handle, [
                    'Opening Balance',
                    $periodOpeningBalance,
                ]);

                fputcsv($handle, [
                    'Total Income',
                    $totalIncome,
                ]);

                fputcsv($handle, [
                    'Total Expenses',
                    $totalExpenses,
                ]);

                fputcsv($handle, [
                    'Net Movement',
                    $netBalance,
                ]);

                fputcsv($handle, [
                    'Closing Balance',
                    $closingBalance,
                ]);

                fputcsv($handle, []);

                /*
                |--------------------------------------------------------------------------
                | Income Transactions
                |--------------------------------------------------------------------------
                */

                fputcsv($handle, [
                    'INCOME TRANSACTIONS',
                ]);

                fputcsv($handle, [
                    'Date',
                    'Financial Account',
                    'Category',
                    'Source',
                    'Payment Method',
                    'Reference',
                    'Amount',
                ]);

                foreach ($incomeTransactions as $income) {

                    fputcsv($handle, [
                        $income->income_date?->format('Y-m-d'),
                        $income->financialAccount?->name ?? 'Unassigned',
                        $income->category,
                        $income->source,
                        $income->payment_method,
                        $income->reference,
                        $income->amount,
                    ]);

                }

                fputcsv($handle, []);

                /*
                |--------------------------------------------------------------------------
                | Expense Transactions
                |--------------------------------------------------------------------------
                */

                fputcsv($handle, [
                    'EXPENSE TRANSACTIONS',
                ]);

                fputcsv($handle, [
                    'Date',
                    'Financial Account',
                    'Category',
                    'Vendor',
                    'Payment Method',
                    'Reference',
                    'Amount',
                ]);

                foreach ($expenseTransactions as $expense) {

                    fputcsv($handle, [
                        $expense->expense_date?->format('Y-m-d'),
                        $expense->financialAccount?->name ?? 'Unassigned',
                        $expense->category,
                        $expense->vendor,
                        $expense->payment_method,
                        $expense->reference,
                        $expense->amount,
                    ]);

                }

                fclose($handle);

            },
            $filename,
            [
                'Content-Type' => 'text/csv; charset=UTF-8',
            ]
        );
    }


    /**
     * Export church financial report as PDF.
     */
    public function exportPdf(Request $request)
    {
        $user = Auth::user();
        $church = $user?->church;

        [$period, $startDate, $endDate] =
            $this->resolveReportPeriod($request);

        $selectedAccountId = $request->filled('financial_account_id')
            ? (int) $request->financial_account_id
            : null;

        $selectedAccount = null;

        $totalIncome = 0;
        $totalExpenses = 0;

        $periodOpeningBalance = 0;
        $closingBalance = 0;

        $incomeByCategory = collect();
        $expensesByCategory = collect();

        $incomeTransactions = collect();
        $expenseTransactions = collect();

        $accounts = collect();

        /*
        |--------------------------------------------------------------------------
        | Financial Data
        |--------------------------------------------------------------------------
        */

        if ($church) {

            $accounts = FinancialAccount::query()
                ->where('church_id', $church->id)
                ->orderByDesc('is_default')
                ->orderBy('name')
                ->get();

            if ($selectedAccountId) {

                $selectedAccount = $accounts
                    ->firstWhere('id', $selectedAccountId);

                abort_unless(
                    $selectedAccount,
                    404,
                    'The selected financial account was not found.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Queries
            |--------------------------------------------------------------------------
            */

            $incomeQuery = Income::query()
                ->where('church_id', $church->id);

            $expenseQuery = Expense::query()
                ->where('church_id', $church->id);

            if ($selectedAccount) {

                $incomeQuery->where(
                    'financial_account_id',
                    $selectedAccount->id
                );

                $expenseQuery->where(
                    'financial_account_id',
                    $selectedAccount->id
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Period Totals
            |--------------------------------------------------------------------------
            */

            $periodIncomeQuery = (clone $incomeQuery)
                ->whereBetween('income_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ]);

            $periodExpenseQuery = (clone $expenseQuery)
                ->whereBetween('expense_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ]);

            $totalIncome =
                (float) $periodIncomeQuery->sum('amount');

            $totalExpenses =
                (float) $periodExpenseQuery->sum('amount');

            /*
            |--------------------------------------------------------------------------
            | Opening Balance
            |--------------------------------------------------------------------------
            */

            if ($selectedAccount) {

                $periodOpeningBalance =
                    (float) $selectedAccount->opening_balance;

                $openingBalanceDate =
                    $selectedAccount->opening_balance_date;

                if (
                    $openingBalanceDate &&
                    $startDate->toDateString() >
                    $openingBalanceDate->toDateString()
                ) {

                    $incomeBeforePeriod = (clone $incomeQuery)
                        ->whereDate(
                            'income_date',
                            '>=',
                            $openingBalanceDate
                        )
                        ->whereDate(
                            'income_date',
                            '<',
                            $startDate
                        )
                        ->sum('amount');

                    $expensesBeforePeriod = (clone $expenseQuery)
                        ->whereDate(
                            'expense_date',
                            '>=',
                            $openingBalanceDate
                        )
                        ->whereDate(
                            'expense_date',
                            '<',
                            $startDate
                        )
                        ->sum('amount');

                    $periodOpeningBalance +=
                        (float) $incomeBeforePeriod
                        - (float) $expensesBeforePeriod;
                }

            } else {

                $periodOpeningBalance = (float) $accounts->sum(
                    fn (FinancialAccount $account) =>
                        (float) $account->opening_balance
                );

                $openingBalanceDate = $accounts
                    ->filter(
                        fn (FinancialAccount $account) =>
                            $account->opening_balance_date !== null
                    )
                    ->min('opening_balance_date');

                if (
                    $openingBalanceDate &&
                    $startDate->toDateString() >
                    $openingBalanceDate->toDateString()
                ) {

                    $incomeBeforePeriod = Income::query()
                        ->where('church_id', $church->id)
                        ->whereDate(
                            'income_date',
                            '>=',
                            $openingBalanceDate
                        )
                        ->whereDate(
                            'income_date',
                            '<',
                            $startDate
                        )
                        ->sum('amount');

                    $expensesBeforePeriod = Expense::query()
                        ->where('church_id', $church->id)
                        ->whereDate(
                            'expense_date',
                            '>=',
                            $openingBalanceDate
                        )
                        ->whereDate(
                            'expense_date',
                            '<',
                            $startDate
                        )
                        ->sum('amount');

                    $periodOpeningBalance +=
                        (float) $incomeBeforePeriod
                        - (float) $expensesBeforePeriod;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Closing Balance
            |--------------------------------------------------------------------------
            */

            $closingBalance =
                $periodOpeningBalance
                + $totalIncome
                - $totalExpenses;

            /*
            |--------------------------------------------------------------------------
            | Categories
            |--------------------------------------------------------------------------
            */

            $incomeByCategory = (clone $periodIncomeQuery)
                ->selectRaw('category, SUM(amount) as total')
                ->groupBy('category')
                ->orderByDesc('total')
                ->get();

            $expensesByCategory = (clone $periodExpenseQuery)
                ->selectRaw('category, SUM(amount) as total')
                ->groupBy('category')
                ->orderByDesc('total')
                ->get();

            /*
            |--------------------------------------------------------------------------
            | Transactions
            |--------------------------------------------------------------------------
            */

            $incomeTransactions = (clone $periodIncomeQuery)
                ->with('financialAccount')
                ->orderBy('income_date')
                ->orderBy('id')
                ->get();

            $expenseTransactions = (clone $periodExpenseQuery)
                ->with('financialAccount')
                ->orderBy('expense_date')
                ->orderBy('id')
                ->get();
        }

        $netBalance =
            $totalIncome - $totalExpenses;

        $reportLabel = $this->getReportLabel(
            $period,
            $startDate,
            $endDate
        );

        /*
        |--------------------------------------------------------------------------
        | Generate PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView('church.reports.pdf', [
            'church' => $church,

            // Financial accounts
            'accounts' => $accounts,
            'selectedAccount' => $selectedAccount,

            // Financial summary
            'totalIncome' => $totalIncome,
            'totalExpenses' => $totalExpenses,
            'netBalance' => $netBalance,

            'periodOpeningBalance' => $periodOpeningBalance,
            'closingBalance' => $closingBalance,

            // Categories
            'incomeByCategory' => $incomeByCategory,
            'expensesByCategory' => $expensesByCategory,

            // Transactions
            'incomeTransactions' => $incomeTransactions,
            'expenseTransactions' => $expenseTransactions,

            // Period
            'period' => $period,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'reportLabel' => $reportLabel,
        ]);

        return $pdf->download(
            'church-financial-report-' . now()->format('Y-m-d') . '.pdf'
        );
    }


    /**
     * Resolve the selected report period.
     */
    private function resolveReportPeriod(Request $request): array
    {
        $period = $request->input('period', 'monthly');

        $allowedPeriods = [
            'monthly',
            'quarterly',
            'yearly',
            'custom',
        ];

        if (! in_array($period, $allowedPeriods, true)) {
            $period = 'monthly';
        }

        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();

        if ($period === 'quarterly') {

            $startDate = now()->startOfQuarter();
            $endDate = now()->endOfQuarter();

        } elseif ($period === 'yearly') {

            $startDate = now()->startOfYear();
            $endDate = now()->endOfYear();

        } elseif ($period === 'custom') {

            $customStartDate = $request->input('start_date');
            $customEndDate = $request->input('end_date');

            if ($customStartDate && $customEndDate) {

                try {

                    $startDate = Carbon::parse($customStartDate)
                        ->startOfDay();

                    $endDate = Carbon::parse($customEndDate)
                        ->endOfDay();

                    if ($startDate->greaterThan($endDate)) {
                        [$startDate, $endDate] = [
                            $endDate,
                            $startDate,
                        ];
                    }

                } catch (\Throwable $e) {

                    $period = 'monthly';

                    $startDate = now()->startOfMonth();
                    $endDate = now()->endOfMonth();
                }
            }
        }

        return [
            $period,
            $startDate,
            $endDate,
        ];
    }


    /**
     * Generate a readable report label.
     */
    private function getReportLabel(
        string $period,
        $startDate,
        $endDate
    ): string {
        return match ($period) {

            'quarterly' =>
                $startDate->format('M Y')
                . ' - '
                . $endDate->format('M Y'),

            'yearly' =>
                $startDate->format('Y'),

            'custom' =>
                $startDate->format('d M Y')
                . ' - '
                . $endDate->format('d M Y'),

            default =>
                $startDate->format('F Y'),
        };
    }
}