<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Member;
use App\Models\Service;
use App\Services\ChurchFinancialService;
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
    public function index(
        Request $request,
        ChurchFinancialService $financialService
    ): View {
        $user = Auth::user();
        $church = $user?->church;

        [$period, $startDate, $endDate] = $this->resolveReportPeriod($request);

        /*
        |--------------------------------------------------------------------------
        | Default Values
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Church Financial Data
        |--------------------------------------------------------------------------
        */

        if ($church) {

            /*
            |--------------------------------------------------------------------------
            | Original Church Opening Position
            |--------------------------------------------------------------------------
            */

            $openingBalance = $financialService->openingBalance($church);

            $openingBalanceDate = $financialService->openingBalanceDate($church);

            /*
            |--------------------------------------------------------------------------
            | Period Income
            |--------------------------------------------------------------------------
            */

            $totalIncome = Income::query()
                ->where('church_id', $church->id)
                ->whereBetween('income_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ])
                ->sum('amount');

            /*
            |--------------------------------------------------------------------------
            | Period Expenses
            |--------------------------------------------------------------------------
            */

            $totalExpenses = Expense::query()
                ->where('church_id', $church->id)
                ->whereBetween('expense_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ])
                ->sum('amount');

            /*
            |--------------------------------------------------------------------------
            | Net Movement
            |--------------------------------------------------------------------------
            */

            $netBalance = $totalIncome - $totalExpenses;

            /*
            |--------------------------------------------------------------------------
            | Period Opening Balance
            |--------------------------------------------------------------------------
            |
            | The report opening balance is the financial position immediately
            | before the selected reporting period begins.
            |
            | If the selected period starts before or on the church's original
            | opening balance date, use the original opening balance.
            |
            | Otherwise:
            |
            | Original Opening Balance
            | + Income before report period
            | - Expenses before report period
            | = Period Opening Balance
            |
            */

            $periodOpeningBalance = $openingBalance;

            if (
                $openingBalanceDate &&
                $startDate->toDateString() > $openingBalanceDate->toDateString()
            ) {
                $incomeBeforePeriod = Income::query()
                    ->where('church_id', $church->id)
                    ->whereDate('income_date', '>=', $openingBalanceDate)
                    ->whereDate('income_date', '<', $startDate)
                    ->sum('amount');

                $expensesBeforePeriod = Expense::query()
                    ->where('church_id', $church->id)
                    ->whereDate('expense_date', '>=', $openingBalanceDate)
                    ->whereDate('expense_date', '<', $startDate)
                    ->sum('amount');

                $periodOpeningBalance =
                    $openingBalance
                    + $incomeBeforePeriod
                    - $expensesBeforePeriod;
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

            $incomeByCategory = Income::query()
                ->where('church_id', $church->id)
                ->whereBetween('income_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ])
                ->selectRaw('category, SUM(amount) as total')
                ->groupBy('category')
                ->orderByDesc('total')
                ->get();

            /*
            |--------------------------------------------------------------------------
            | Expenses By Category
            |--------------------------------------------------------------------------
            */

            $expensesByCategory = Expense::query()
                ->where('church_id', $church->id)
                ->whereBetween('expense_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ])
                ->selectRaw('category, SUM(amount) as total')
                ->groupBy('category')
                ->orderByDesc('total')
                ->get();

            /*
            |--------------------------------------------------------------------------
            | Income Transactions
            |--------------------------------------------------------------------------
            */

            $incomeTransactions = Income::query()
                ->where('church_id', $church->id)
                ->whereBetween('income_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ])
                ->orderByDesc('income_date')
                ->orderByDesc('id')
                ->get();

            /*
            |--------------------------------------------------------------------------
            | Expense Transactions
            |--------------------------------------------------------------------------
            */

            $expenseTransactions = Expense::query()
                ->where('church_id', $church->id)
                ->whereBetween('expense_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ])
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

        [$period, $startDate, $endDate] = $this->resolveReportPeriod($request);

        $incomeTransactions = collect();
        $expenseTransactions = collect();

        $totalIncome = 0;
        $totalExpenses = 0;

        $periodOpeningBalance = 0;
        $closingBalance = 0;

        /*
        |--------------------------------------------------------------------------
        | Financial Data
        |--------------------------------------------------------------------------
        */

        if ($church) {

            $financialService = app(ChurchFinancialService::class);

            $originalOpeningBalance =
                $financialService->openingBalance($church);

            $openingBalanceDate =
                $financialService->openingBalanceDate($church);

            $periodOpeningBalance = $originalOpeningBalance;

            /*
            |--------------------------------------------------------------------------
            | Period Income
            |--------------------------------------------------------------------------
            */

            $totalIncome = Income::query()
                ->where('church_id', $church->id)
                ->whereBetween('income_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ])
                ->sum('amount');

            /*
            |--------------------------------------------------------------------------
            | Period Expenses
            |--------------------------------------------------------------------------
            */

            $totalExpenses = Expense::query()
                ->where('church_id', $church->id)
                ->whereBetween('expense_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ])
                ->sum('amount');

            /*
            |--------------------------------------------------------------------------
            | Period Opening Balance
            |--------------------------------------------------------------------------
            */

            if (
                $openingBalanceDate &&
                $startDate->toDateString() > $openingBalanceDate->toDateString()
            ) {
                $incomeBeforePeriod = Income::query()
                    ->where('church_id', $church->id)
                    ->whereDate('income_date', '>=', $openingBalanceDate)
                    ->whereDate('income_date', '<', $startDate)
                    ->sum('amount');

                $expensesBeforePeriod = Expense::query()
                    ->where('church_id', $church->id)
                    ->whereDate('expense_date', '>=', $openingBalanceDate)
                    ->whereDate('expense_date', '<', $startDate)
                    ->sum('amount');

                $periodOpeningBalance =
                    $originalOpeningBalance
                    + $incomeBeforePeriod
                    - $expensesBeforePeriod;
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

            $incomeTransactions = Income::query()
                ->where('church_id', $church->id)
                ->whereBetween('income_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ])
                ->orderBy('income_date')
                ->orderBy('id')
                ->get();

            $expenseTransactions = Expense::query()
                ->where('church_id', $church->id)
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
                    'Category',
                    'Source',
                    'Payment Method',
                    'Reference',
                    'Amount',
                ]);

                foreach ($incomeTransactions as $income) {
                    fputcsv($handle, [
                        $income->income_date?->format('Y-m-d'),
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
                    'Category',
                    'Vendor',
                    'Payment Method',
                    'Reference',
                    'Amount',
                ]);

                foreach ($expenseTransactions as $expense) {
                    fputcsv($handle, [
                        $expense->expense_date?->format('Y-m-d'),
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
    public function exportPdf(
        Request $request,
        ChurchFinancialService $financialService
    ) {
        $user = Auth::user();
        $church = $user?->church;

        [$period, $startDate, $endDate] = $this->resolveReportPeriod($request);

        $totalIncome = 0;
        $totalExpenses = 0;

        $periodOpeningBalance = 0;
        $closingBalance = 0;

        $incomeByCategory = collect();
        $expensesByCategory = collect();

        $incomeTransactions = collect();
        $expenseTransactions = collect();

        /*
        |--------------------------------------------------------------------------
        | Financial Data
        |--------------------------------------------------------------------------
        */

        if ($church) {

            $originalOpeningBalance =
                $financialService->openingBalance($church);

            $openingBalanceDate =
                $financialService->openingBalanceDate($church);

            $periodOpeningBalance = $originalOpeningBalance;

            /*
            |--------------------------------------------------------------------------
            | Period Income
            |--------------------------------------------------------------------------
            */

            $totalIncome = Income::query()
                ->where('church_id', $church->id)
                ->whereBetween('income_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ])
                ->sum('amount');

            /*
            |--------------------------------------------------------------------------
            | Period Expenses
            |--------------------------------------------------------------------------
            */

            $totalExpenses = Expense::query()
                ->where('church_id', $church->id)
                ->whereBetween('expense_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ])
                ->sum('amount');

            /*
            |--------------------------------------------------------------------------
            | Period Opening Balance
            |--------------------------------------------------------------------------
            */

            if (
                $openingBalanceDate &&
                $startDate->toDateString() > $openingBalanceDate->toDateString()
            ) {
                $incomeBeforePeriod = Income::query()
                    ->where('church_id', $church->id)
                    ->whereDate('income_date', '>=', $openingBalanceDate)
                    ->whereDate('income_date', '<', $startDate)
                    ->sum('amount');

                $expensesBeforePeriod = Expense::query()
                    ->where('church_id', $church->id)
                    ->whereDate('expense_date', '>=', $openingBalanceDate)
                    ->whereDate('expense_date', '<', $startDate)
                    ->sum('amount');

                $periodOpeningBalance =
                    $originalOpeningBalance
                    + $incomeBeforePeriod
                    - $expensesBeforePeriod;
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

            $incomeByCategory = Income::query()
                ->where('church_id', $church->id)
                ->whereBetween('income_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ])
                ->selectRaw('category, SUM(amount) as total')
                ->groupBy('category')
                ->orderByDesc('total')
                ->get();

            /*
            |--------------------------------------------------------------------------
            | Expenses By Category
            |--------------------------------------------------------------------------
            */

            $expensesByCategory = Expense::query()
                ->where('church_id', $church->id)
                ->whereBetween('expense_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ])
                ->selectRaw('category, SUM(amount) as total')
                ->groupBy('category')
                ->orderByDesc('total')
                ->get();

            /*
            |--------------------------------------------------------------------------
            | Income Transactions
            |--------------------------------------------------------------------------
            */

            $incomeTransactions = Income::query()
                ->where('church_id', $church->id)
                ->whereBetween('income_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ])
                ->orderBy('income_date')
                ->orderBy('id')
                ->get();

            /*
            |--------------------------------------------------------------------------
            | Expense Transactions
            |--------------------------------------------------------------------------
            */

            $expenseTransactions = Expense::query()
                ->where('church_id', $church->id)
                ->whereBetween('expense_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ])
                ->orderBy('expense_date')
                ->orderBy('id')
                ->get();
        }

        $netBalance = $totalIncome - $totalExpenses;

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

            'totalIncome' => $totalIncome,
            'totalExpenses' => $totalExpenses,
            'netBalance' => $netBalance,

            'periodOpeningBalance' => $periodOpeningBalance,
            'closingBalance' => $closingBalance,

            'incomeByCategory' => $incomeByCategory,
            'expensesByCategory' => $expensesByCategory,

            'incomeTransactions' => $incomeTransactions,
            'expenseTransactions' => $expenseTransactions,

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