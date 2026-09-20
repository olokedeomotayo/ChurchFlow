<?php

namespace App\Http\Controllers\Church;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Member;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Display the church reports.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $church = $user?->church;

        [$period, $startDate, $endDate] = $this->resolveReportPeriod($request);

        $totalIncome = 0;
        $totalExpenses = 0;
        $netBalance = 0;

        $totalMembers = 0;
        $totalServices = 0;
        $totalAttendance = 0;

        $incomeByCategory = collect();
        $expensesByCategory = collect();

        $incomeTransactions = collect();
        $expenseTransactions = collect();

        if ($church) {

            /*
            |--------------------------------------------------------------------------
            | Financial Summary
            |--------------------------------------------------------------------------
            */

            $totalIncome = Income::query()
                ->where('church_id', $church->id)
                ->whereBetween('income_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ])
                ->sum('amount');

            $totalExpenses = Expense::query()
                ->where('church_id', $church->id)
                ->whereBetween('expense_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ])
                ->sum('amount');

            $netBalance = $totalIncome - $totalExpenses;


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

        $reportLabel = $this->getReportLabel(
            $period,
            $startDate,
            $endDate
        );

        return view('church.reports.index', [
            'user' => $user,
            'church' => $church,

            'totalIncome' => $totalIncome,
            'totalExpenses' => $totalExpenses,
            'netBalance' => $netBalance,

            'totalMembers' => $totalMembers,
            'totalServices' => $totalServices,
            'totalAttendance' => $totalAttendance,

            'incomeByCategory' => $incomeByCategory,
            'expensesByCategory' => $expensesByCategory,

            'incomeTransactions' => $incomeTransactions,
            'expenseTransactions' => $expenseTransactions,

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

        if ($church) {

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

        $filename = 'church-financial-report-' . now()->format('Y-m-d') . '.csv';

        return response()->streamDownload(
            function () use (
                $incomeTransactions,
                $expenseTransactions
            ) {

                $handle = fopen('php://output', 'w');

                /*
                |--------------------------------------------------------------------------
                | Income
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
                | Expenses
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
    public function exportPdf(Request $request)
    {
        $user = Auth::user();
        $church = $user?->church;

        [$period, $startDate, $endDate] = $this->resolveReportPeriod($request);

        $totalIncome = 0;
        $totalExpenses = 0;

        $incomeByCategory = collect();
        $expensesByCategory = collect();

        $incomeTransactions = collect();
        $expenseTransactions = collect();

        if ($church) {

            /*
            |--------------------------------------------------------------------------
            | Financial Summary
            |--------------------------------------------------------------------------
            */

            $totalIncome = Income::query()
                ->where('church_id', $church->id)
                ->whereBetween('income_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ])
                ->sum('amount');

            $totalExpenses = Expense::query()
                ->where('church_id', $church->id)
                ->whereBetween('expense_date', [
                    $startDate->toDateString(),
                    $endDate->toDateString(),
                ])
                ->sum('amount');


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

        $pdf = Pdf::loadView('church.reports.pdf', [
            'church' => $church,

            'totalIncome' => $totalIncome,
            'totalExpenses' => $totalExpenses,
            'netBalance' => $netBalance,

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

                    $startDate = \Carbon\Carbon::parse($customStartDate)
                        ->startOfDay();

                    $endDate = \Carbon\Carbon::parse($customEndDate)
                        ->endOfDay();

                    if ($startDate->greaterThan($endDate)) {
                        [$startDate, $endDate] = [$endDate, $startDate];
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