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

        .account {
            margin-top: 5px;
            color: #7e22ce;
            font-size: 10px;
            font-weight: bold;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #581c87;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        /*
        |--------------------------------------------------------------------------
        | Financial Position
        |--------------------------------------------------------------------------
        */

        .position-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .position-table td {
            width: 25%;
            padding: 10px;
            border: 1px solid #e2e8f0;
            vertical-align: top;
        }

        .position-label {
            font-size: 8px;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .position-value {
            font-size: 15px;
            font-weight: bold;
        }

        .opening-value {
            color: #334155;
        }

        .income-value {
            color: #15803d;
        }

        .expense-value {
            color: #b91c1c;
        }

        .closing-value {
            color: #7e22ce;
        }

        .position-note {
            margin-top: 4px;
            font-size: 8px;
            color: #94a3b8;
        }

        /*
        |--------------------------------------------------------------------------
        | Net Movement
        |--------------------------------------------------------------------------
        */

        .net-movement {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .net-movement td {
            padding: 10px;
            border: 1px solid #e2e8f0;
        }

        .net-label {
            font-size: 9px;
            font-weight: bold;
            color: #475569;
        }

        .net-value {
            text-align: right;
            font-size: 15px;
            font-weight: bold;
        }

        .positive {
            color: #7e22ce;
        }

        .negative {
            color: #b91c1c;
        }

        /*
        |--------------------------------------------------------------------------
        | Data Tables
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Account Information
        |--------------------------------------------------------------------------
        */

        .account-box {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .account-box td {
            padding: 8px 10px;
            border: 1px solid #e2e8f0;
        }

        .account-label {
            width: 25%;
            background: #f8fafc;
            color: #64748b;
            font-size: 8px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .account-value {
            color: #334155;
            font-size: 9px;
            font-weight: bold;
        }

        /*
        |--------------------------------------------------------------------------
        | Footer
        |--------------------------------------------------------------------------
        */

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

    {{-- ============================================================= --}}
    {{-- HEADER --}}
    {{-- ============================================================= --}}

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

        <div class="account">
            Financial Account:
            {{ $selectedAccount?->name ?? 'All Accounts' }}
        </div>

    </div>


    {{-- ============================================================= --}}
    {{-- SELECTED ACCOUNT --}}
    {{-- ============================================================= --}}

    @if ($selectedAccount)

        <div class="section-title">
            Financial Account
        </div>

        <table class="account-box">

            <tr>

                <td class="account-label">
                    Account Name
                </td>

                <td class="account-value">
                    {{ $selectedAccount->name }}
                </td>

                <td class="account-label">
                    Account Type
                </td>

                <td class="account-value">
                    {{ ucfirst(str_replace('_', ' ', $selectedAccount->type)) }}
                </td>

            </tr>

            <tr>

                <td class="account-label">
                    Provider
                </td>

                <td class="account-value">
                    {{ $selectedAccount->provider_name ?: '-' }}
                </td>

                <td class="account-label">
                    Account Number
                </td>

                <td class="account-value">
                    {{ $selectedAccount->account_number ?: '-' }}
                </td>

            </tr>

            <tr>

                <td class="account-label">
                    Opening Balance
                </td>

                <td class="account-value">
                    ₦{{ number_format((float) $selectedAccount->opening_balance, 2) }}
                </td>

                <td class="account-label">
                    Opening Date
                </td>

                <td class="account-value">
                    {{ $selectedAccount->opening_balance_date?->format('d M Y') ?? '-' }}
                </td>

            </tr>

        </table>

    @endif


    {{-- ============================================================= --}}
    {{-- FINANCIAL POSITION --}}
    {{-- ============================================================= --}}

    <div class="section-title">
        Financial Position
    </div>

    <table class="position-table">

        <tr>

            {{-- Opening Balance --}}
            <td>

                <div class="position-label">
                    Opening Balance
                </div>

                <div class="position-value opening-value">
                    ₦{{ number_format((float) $periodOpeningBalance, 2) }}
                </div>

                <div class="position-note">
                    Balance at start of report period
                </div>

            </td>


            {{-- Income --}}
            <td>

                <div class="position-label">
                    Income During Period
                </div>

                <div class="position-value income-value">
                    + ₦{{ number_format((float) $totalIncome, 2) }}
                </div>

                <div class="position-note">
                    Total recorded income
                </div>

            </td>


            {{-- Expenses --}}
            <td>

                <div class="position-label">
                    Expenses During Period
                </div>

                <div class="position-value expense-value">
                    − ₦{{ number_format((float) $totalExpenses, 2) }}
                </div>

                <div class="position-note">
                    Total recorded expenses
                </div>

            </td>


            {{-- Closing Balance --}}
            <td>

                <div class="position-label">
                    Closing Balance
                </div>

                <div
                    class="position-value
                        {{ $closingBalance >= 0
                            ? 'closing-value'
                            : 'negative'
                        }}"
                >
                    ₦{{ number_format((float) $closingBalance, 2) }}
                </div>

                <div class="position-note">
                    Opening balance + net movement
                </div>

            </td>

        </tr>

    </table>


    {{-- ============================================================= --}}
    {{-- BALANCE CALCULATION --}}
    {{-- ============================================================= --}}

    <table class="net-movement">

        <tr>

            <td>

                <div class="net-label">
                    Balance Calculation
                </div>

                <div style="margin-top: 4px; font-size: 9px; color: #64748b;">
                    Opening Balance + Income During Period − Expenses During Period
                </div>

            </td>

            <td class="net-value {{ $closingBalance >= 0 ? 'positive' : 'negative' }}">

                ₦{{ number_format((float) $periodOpeningBalance, 2) }}
                +
                ₦{{ number_format((float) $totalIncome, 2) }}
                −
                ₦{{ number_format((float) $totalExpenses, 2) }}

                =
                ₦{{ number_format((float) $closingBalance, 2) }}

            </td>

        </tr>

    </table>


    {{-- ============================================================= --}}
    {{-- NET MOVEMENT --}}
    {{-- ============================================================= --}}

    <div class="section-title">
        Net Movement
    </div>

    <table class="net-movement">

        <tr>

            <td>

                <div class="net-label">
                    Net Movement
                </div>

                <div style="margin-top: 4px; font-size: 9px; color: #64748b;">
                    Total income less total expenses for the selected period
                </div>

            </td>

            <td
                class="net-value
                    {{ $netBalance >= 0
                        ? 'positive'
                        : 'negative'
                    }}"
            >
                ₦{{ number_format((float) $netBalance, 2) }}
            </td>

        </tr>

    </table>


    {{-- ============================================================= --}}
    {{-- INCOME BY CATEGORY --}}
    {{-- ============================================================= --}}

    <div class="section-title">
        Income by Category
    </div>

    <table class="data-table">

        <thead>

            <tr>

                <th>
                    Category
                </th>

                <th style="text-align: right;">
                    Total
                </th>

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

        <tfoot>

            <tr class="total-row">

                <td style="text-align: right;">
                    Total Income
                </td>

                <td class="amount">
                    ₦{{ number_format((float) $totalIncome, 2) }}
                </td>

            </tr>

        </tfoot>

    </table>


    {{-- ============================================================= --}}
    {{-- EXPENSES BY CATEGORY --}}
    {{-- ============================================================= --}}

    <div class="section-title">
        Expenses by Category
    </div>

    <table class="data-table">

        <thead>

            <tr>

                <th>
                    Category
                </th>

                <th style="text-align: right;">
                    Total
                </th>

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

        <tfoot>

            <tr class="total-row">

                <td style="text-align: right;">
                    Total Expenses
                </td>

                <td class="amount">
                    ₦{{ number_format((float) $totalExpenses, 2) }}
                </td>

            </tr>

        </tfoot>

    </table>


    {{-- ============================================================= --}}
    {{-- TRANSACTIONS --}}
    {{-- ============================================================= --}}

    <div class="page-break"></div>


    {{-- ============================================================= --}}
    {{-- INCOME TRANSACTIONS --}}
    {{-- ============================================================= --}}

    <div class="section-title">
        Income Transactions
    </div>

    <table class="data-table">

        <thead>

            <tr>

                <th>
                    Date
                </th>

                @if (! $selectedAccount)

                    <th>
                        Financial Account
                    </th>

                @endif

                <th>
                    Category
                </th>

                <th>
                    Source
                </th>

                <th>
                    Payment Method
                </th>

                <th>
                    Reference
                </th>

                <th style="text-align: right;">
                    Amount
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse ($incomeTransactions as $income)

                <tr>

                    <td>
                        {{ $income->income_date?->format('d M Y') }}
                    </td>

                    @if (! $selectedAccount)

                        <td>
                            {{ $income->financialAccount?->name ?? 'Unassigned' }}
                        </td>

                    @endif

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

                    <td colspan="{{ $selectedAccount ? 6 : 7 }}">
                        No income transactions found.
                    </td>

                </tr>

            @endforelse

        </tbody>

        <tfoot>

            <tr class="total-row">

                <td
                    colspan="{{ $selectedAccount ? 5 : 6 }}"
                    style="text-align: right;"
                >
                    Total Income
                </td>

                <td class="amount">
                    ₦{{ number_format((float) $totalIncome, 2) }}
                </td>

            </tr>

        </tfoot>

    </table>


    {{-- ============================================================= --}}
    {{-- EXPENSE TRANSACTIONS --}}
    {{-- ============================================================= --}}

    <div class="section-title">
        Expense Transactions
    </div>

    <table class="data-table">

        <thead>

            <tr>

                <th>
                    Date
                </th>

                @if (! $selectedAccount)

                    <th>
                        Financial Account
                    </th>

                @endif

                <th>
                    Category
                </th>

                <th>
                    Vendor
                </th>

                <th>
                    Payment Method
                </th>

                <th>
                    Reference
                </th>

                <th style="text-align: right;">
                    Amount
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse ($expenseTransactions as $expense)

                <tr>

                    <td>
                        {{ $expense->expense_date?->format('d M Y') }}
                    </td>

                    @if (! $selectedAccount)

                        <td>
                            {{ $expense->financialAccount?->name ?? 'Unassigned' }}
                        </td>

                    @endif

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

                    <td colspan="{{ $selectedAccount ? 6 : 7 }}">
                        No expense transactions found.
                    </td>

                </tr>

            @endforelse

        </tbody>

        <tfoot>

            <tr class="total-row">

                <td
                    colspan="{{ $selectedAccount ? 5 : 6 }}"
                    style="text-align: right;"
                >
                    Total Expenses
                </td>

                <td class="amount">
                    ₦{{ number_format((float) $totalExpenses, 2) }}
                </td>

            </tr>

        </tfoot>

    </table>


    {{-- ============================================================= --}}
    {{-- FOOTER --}}
    {{-- ============================================================= --}}

    <div class="footer">

        Generated by ChurchFlow

        &nbsp; | &nbsp;

        {{ now()->format('d M Y H:i') }}

    </div>

</body>
</html>