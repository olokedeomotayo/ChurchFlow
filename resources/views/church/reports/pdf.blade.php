<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Church Financial Report</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #1e293b;
            margin: 0;
            padding: 25px;
        }

        .header {
            border-bottom: 2px solid #7e22ce;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .church-name {
            font-size: 22px;
            font-weight: bold;
            color: #581c87;
            margin-bottom: 5px;
        }

        .report-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .period {
            color: #64748b;
            font-size: 10px;
        }

        .summary {
            width: 100%;
            margin-bottom: 25px;
        }

        .summary td {
            width: 33.33%;
            padding: 10px;
            border: 1px solid #e2e8f0;
        }

        .summary-label {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .summary-value {
            font-size: 16px;
            font-weight: bold;
        }

        .income-value {
            color: #15803d;
        }

        .expense-value {
            color: #b91c1c;
        }

        .balance-value {
            color: #7e22ce;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #581c87;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .data-table th {
            background: #f1f5f9;
            color: #334155;
            font-size: 9px;
            text-align: left;
            padding: 7px;
            border: 1px solid #cbd5e1;
        }

        .data-table td {
            padding: 7px;
            border: 1px solid #e2e8f0;
            font-size: 9px;
        }

        .amount {
            text-align: right;
            white-space: nowrap;
        }

        .total-row td {
            font-weight: bold;
            background: #f8fafc;
        }

        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #cbd5e1;
            text-align: center;
            color: #64748b;
            font-size: 8px;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <div class="header">
        <div class="church-name">
            {{ $church?->name ?? 'Church' }}
        </div>

        <div class="report-title">
            Financial Report
        </div>

        <div class="period">
            Reporting Period: {{ $reportLabel }}
        </div>
    </div>


    {{-- SUMMARY --}}
    <table class="summary">
        <tr>
            <td>
                <div class="summary-label">Total Income</div>

                <div class="summary-value income-value">
                    ₦{{ number_format((float) $totalIncome, 2) }}
                </div>
            </td>

            <td>
                <div class="summary-label">Total Expenses</div>

                <div class="summary-value expense-value">
                    ₦{{ number_format((float) $totalExpenses, 2) }}
                </div>
            </td>

            <td>
                <div class="summary-label">Net Balance</div>

                <div class="summary-value balance-value">
                    ₦{{ number_format((float) $netBalance, 2) }}
                </div>
            </td>
        </tr>
    </table>


    {{-- INCOME BY CATEGORY --}}
    <div class="section-title">
        Income by Category
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Category</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($incomeByCategory as $item)
                <tr>
                    <td>
                        {{ $item->category }}
                    </td>

                    <td class="amount">
                        ₦{{ number_format((float) $item->total, 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">
                        No income recorded for this period.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>


    {{-- EXPENSES BY CATEGORY --}}
    <div class="section-title">
        Expenses by Category
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Category</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($expensesByCategory as $item)
                <tr>
                    <td>
                        {{ $item->category }}
                    </td>

                    <td class="amount">
                        ₦{{ number_format((float) $item->total, 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">
                        No expenses recorded for this period.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>


    {{-- TRANSACTIONS --}}
    <div class="page-break"></div>

    <div class="section-title">
        Income Transactions
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Category</th>
                <th>Source</th>
                <th>Payment Method</th>
                <th>Reference</th>
                <th style="text-align: right;">Amount</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($incomeTransactions as $income)
                <tr>
                    <td>
                        {{ $income->income_date?->format('d M Y') }}
                    </td>

                    <td>
                        {{ $income->category }}
                    </td>

                    <td>
                        {{ $income->source ?: '-' }}
                    </td>

                    <td>
                        {{ $income->payment_method ?: '-' }}
                    </td>

                    <td>
                        {{ $income->reference ?: '-' }}
                    </td>

                    <td class="amount">
                        ₦{{ number_format((float) $income->amount, 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        No income transactions found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>


    <div class="section-title">
        Expense Transactions
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Category</th>
                <th>Vendor</th>
                <th>Payment Method</th>
                <th>Reference</th>
                <th style="text-align: right;">Amount</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($expenseTransactions as $expense)
                <tr>
                    <td>
                        {{ $expense->expense_date?->format('d M Y') }}
                    </td>

                    <td>
                        {{ $expense->category }}
                    </td>

                    <td>
                        {{ $expense->vendor ?: '-' }}
                    </td>

                    <td>
                        {{ $expense->payment_method ?: '-' }}
                    </td>

                    <td>
                        {{ $expense->reference ?: '-' }}
                    </td>

                    <td class="amount">
                        ₦{{ number_format((float) $expense->amount, 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        No expense transactions found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>


    {{-- FOOTER --}}
    <div class="footer">
        Generated by ChurchFlow
        &nbsp; | &nbsp;
        {{ now()->format('d M Y H:i') }}
    </div>

</body>
</html>