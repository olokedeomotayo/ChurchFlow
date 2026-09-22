@extends('layouts.church')

@section('title', 'Reports')

@section('page_title', 'Reports')

@section('page_description', 'Financial, membership and attendance reports')

@section('content')

    <div class="w-full space-y-6">

        {{-- ============================================================= --}}
        {{-- HEADER --}}
        {{-- ============================================================= --}}

        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                Church Reports
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Overview of your church's financial, membership and attendance data.
            </p>
        </div>


        {{-- ============================================================= --}}
        {{-- REPORT FILTERS --}}
        {{-- ============================================================= --}}

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="mb-5">
                <h2 class="text-sm font-semibold text-slate-900">
                    Report Filters
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Select the financial account and period you want to analyse.
                </p>
            </div>

            <form
                method="GET"
                action="{{ route('church.reports.index') }}"
                class="space-y-5"
            >

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5">

                    {{-- Financial Account --}}
                    <div>
                        <label
                            for="financial_account_id"
                            class="mb-1.5 block text-xs font-semibold text-slate-700"
                        >
                            Financial Account
                        </label>

                        <select
                            id="financial_account_id"
                            name="financial_account_id"
                            class="h-11 w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-3 text-sm text-slate-700 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                        >
                            <option value="">
                                All Accounts
                            </option>

                            @foreach ($accounts as $account)

                                <option
                                    value="{{ $account->id }}"
                                    @selected((string) $selectedAccountId === (string) $account->id)
                                >
                                    {{ $account->name }}
                                    @if ($account->is_default)
                                        — Default
                                    @endif
                                </option>

                            @endforeach

                        </select>
                    </div>


                    {{-- Period --}}
                    <div>
                        <label
                            for="period"
                            class="mb-1.5 block text-xs font-semibold text-slate-700"
                        >
                            Period
                        </label>

                        <select
                            id="period"
                            name="period"
                            onchange="toggleCustomDateFields()"
                            class="h-11 w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-3 text-sm text-slate-700 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                        >
                            <option value="monthly" @selected($period === 'monthly')>
                                Monthly
                            </option>

                            <option value="quarterly" @selected($period === 'quarterly')>
                                Quarterly
                            </option>

                            <option value="yearly" @selected($period === 'yearly')>
                                Yearly
                            </option>

                            <option value="custom" @selected($period === 'custom')>
                                By Date
                            </option>
                        </select>
                    </div>


                    {{-- Start Date --}}
                    <div
                        id="start-date-field"
                        class="{{ $period === 'custom' ? '' : 'hidden' }}"
                    >
                        <label
                            for="start_date"
                            class="mb-1.5 block text-xs font-semibold text-slate-700"
                        >
                            Start Date
                        </label>

                        <input
                            type="date"
                            id="start_date"
                            name="start_date"
                            value="{{ request('start_date') }}"
                            class="h-11 w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-3 text-sm text-slate-700 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                        >
                    </div>


                    {{-- End Date --}}
                    <div
                        id="end-date-field"
                        class="{{ $period === 'custom' ? '' : 'hidden' }}"
                    >
                        <label
                            for="end_date"
                            class="mb-1.5 block text-xs font-semibold text-slate-700"
                        >
                            End Date
                        </label>

                        <input
                            type="date"
                            id="end_date"
                            name="end_date"
                            value="{{ request('end_date') }}"
                            class="h-11 w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-3 text-sm text-slate-700 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                        >
                    </div>


                    {{-- Apply Filter --}}
                    <div class="flex items-end">

                        <button
                            type="submit"
                            class="inline-flex h-11 w-full cursor-pointer items-center justify-center gap-2 rounded-lg bg-purple-600 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-200"
                        >
                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 4h18M6 9h12M10 14h4M11 19h2"
                                />
                            </svg>

                            Apply Filters
                        </button>

                    </div>

                </div>


                {{-- Selected Context --}}
                <div class="border-t border-slate-100 pt-4">

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                        <div>
                            <p class="text-xs font-semibold text-slate-700">
                                Report Context
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                Financial figures for the selected period and account.
                            </p>
                        </div>

                        <div class="flex flex-wrap items-center gap-2">

                            <span class="rounded-full bg-purple-50 px-3 py-1 text-xs font-semibold text-purple-700">
                                {{ $reportLabel }}
                            </span>

                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                {{ $selectedAccount?->name ?? 'All Accounts' }}
                            </span>

                        </div>

                    </div>

                </div>

            </form>

        </div>


        {{-- ============================================================= --}}
        {{-- SELECTED ACCOUNT INFORMATION --}}
        {{-- ============================================================= --}}

        @if ($selectedAccount)

            <div class="rounded-xl border border-purple-200 bg-purple-50 shadow-sm">

                <div class="flex flex-col gap-4 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <div class="flex flex-wrap items-center gap-2">

                            <h2 class="font-semibold text-purple-900">
                                {{ $selectedAccount->name }}
                            </h2>

                            @if ($selectedAccount->is_default)

                                <span class="rounded-full bg-purple-100 px-2.5 py-1 text-[11px] font-semibold text-purple-700">
                                    Default
                                </span>

                            @endif

                            @if ($selectedAccount->is_active)

                                <span class="rounded-full bg-green-100 px-2.5 py-1 text-[11px] font-semibold text-green-700">
                                    Active
                                </span>

                            @else

                                <span class="rounded-full bg-slate-200 px-2.5 py-1 text-[11px] font-semibold text-slate-600">
                                    Inactive
                                </span>

                            @endif

                        </div>

                        <p class="mt-1 text-xs text-purple-700">
                            {{ ucfirst(str_replace('_', ' ', $selectedAccount->type)) }}

                            @if ($selectedAccount->provider_name)
                                · {{ $selectedAccount->provider_name }}
                            @endif
                        </p>

                    </div>

                    <div class="text-left sm:text-right">

                        <p class="text-xs font-semibold uppercase tracking-wide text-purple-600">
                            Current Balance
                        </p>

                        <p class="mt-1 text-xl font-bold text-purple-900">
                            ₦{{ number_format((float) $selectedAccount->current_balance, 2) }}
                        </p>

                    </div>

                </div>

            </div>

        @endif


        {{-- ============================================================= --}}
        {{-- FINANCIAL POSITION --}}
        {{-- ============================================================= --}}

        <div class="rounded-xl border border-purple-200 bg-purple-50 shadow-sm">

            <div class="border-b border-purple-200 px-6 py-5">

                <h2 class="font-semibold text-purple-900">
                    Financial Position
                </h2>

                <p class="mt-1 text-xs text-purple-700">
                    Opening position, financial activity and closing position for {{ $reportLabel }}.
                </p>

            </div>

            <div class="grid grid-cols-1 gap-4 p-6 sm:grid-cols-2 xl:grid-cols-4">

                {{-- Opening Balance --}}
                <div class="rounded-lg border border-purple-100 bg-white p-4">

                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Opening Balance
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        ₦{{ number_format((float) $periodOpeningBalance, 2) }}
                    </p>

                    @if ($openingBalanceDate)

                        <p class="mt-1 text-[11px] text-slate-400">
                            Opening date:
                            {{ $openingBalanceDate->format('d M Y') }}
                        </p>

                    @else

                        <p class="mt-1 text-[11px] text-slate-400">
                            No opening balance date configured.
                        </p>

                    @endif

                </div>


                {{-- Income --}}
                <div class="rounded-lg border border-green-100 bg-green-50 p-4">

                    <p class="text-xs font-semibold uppercase tracking-wide text-green-600">
                        Income During Period
                    </p>

                    <p class="mt-2 text-2xl font-bold text-green-700">
                        + ₦{{ number_format((float) $totalIncome, 2) }}
                    </p>

                    <p class="mt-1 text-[11px] text-green-600">
                        Total income recorded
                    </p>

                </div>


                {{-- Expenses --}}
                <div class="rounded-lg border border-red-100 bg-red-50 p-4">

                    <p class="text-xs font-semibold uppercase tracking-wide text-red-600">
                        Expenses During Period
                    </p>

                    <p class="mt-2 text-2xl font-bold text-red-700">
                        − ₦{{ number_format((float) $totalExpenses, 2) }}
                    </p>

                    <p class="mt-1 text-[11px] text-red-600">
                        Total expenses recorded
                    </p>

                </div>


                {{-- Closing Balance --}}
                <div class="rounded-lg border border-purple-200 bg-white p-4">

                    <p class="text-xs font-semibold uppercase tracking-wide text-purple-600">
                        Closing Balance
                    </p>

                    <p
                        class="mt-2 text-2xl font-bold
                            {{ $closingBalance >= 0
                                ? 'text-purple-700'
                                : 'text-red-700'
                            }}"
                    >
                        ₦{{ number_format((float) $closingBalance, 2) }}
                    </p>

                    <p class="mt-1 text-[11px] text-slate-400">
                        Opening balance + net movement
                    </p>

                </div>

            </div>


            {{-- Balance Calculation --}}
            <div class="border-t border-purple-200 px-6 py-4">

                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <p class="text-xs font-semibold text-purple-900">
                            Balance Calculation
                        </p>

                        <p class="mt-1 text-xs text-purple-700">
                            ₦{{ number_format((float) $periodOpeningBalance, 2) }}
                            +
                            ₦{{ number_format((float) $totalIncome, 2) }}
                            −
                            ₦{{ number_format((float) $totalExpenses, 2) }}
                        </p>

                    </div>

                    <span class="text-sm font-bold text-purple-900">
                        = ₦{{ number_format((float) $closingBalance, 2) }}
                    </span>

                </div>

            </div>

        </div>


        {{-- ============================================================= --}}
        {{-- FINANCIAL SUMMARY --}}
        {{-- ============================================================= --}}

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">

            {{-- Total Income --}}
            <div class="rounded-xl border border-green-200 bg-green-50 p-5 shadow-sm">

                <p class="text-xs font-semibold uppercase tracking-wide text-green-600">
                    Total Income
                </p>

                <p class="mt-2 text-2xl font-bold text-green-700">
                    ₦{{ number_format((float) $totalIncome, 2) }}
                </p>

                <p class="mt-1 text-xs text-green-600">
                    Income recorded during {{ $reportLabel }}
                </p>

            </div>


            {{-- Total Expenses --}}
            <div class="rounded-xl border border-red-200 bg-red-50 p-5 shadow-sm">

                <p class="text-xs font-semibold uppercase tracking-wide text-red-600">
                    Total Expenses
                </p>

                <p class="mt-2 text-2xl font-bold text-red-700">
                    ₦{{ number_format((float) $totalExpenses, 2) }}
                </p>

                <p class="mt-1 text-xs text-red-600">
                    Expenses recorded during {{ $reportLabel }}
                </p>

            </div>


            {{-- Net Movement --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Net Movement
                </p>

                <p
                    class="mt-2 text-2xl font-bold
                        {{ $netBalance >= 0
                            ? 'text-purple-600'
                            : 'text-red-600'
                        }}"
                >
                    ₦{{ number_format((float) $netBalance, 2) }}
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    Total income less total expenses
                </p>

            </div>

        </div>


        {{-- ============================================================= --}}
        {{-- FINANCIAL BREAKDOWN --}}
        {{-- ============================================================= --}}

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">

            {{-- Income By Category --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">

                    <h2 class="font-semibold text-slate-900">
                        Income by Category
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Income breakdown for {{ $reportLabel }}
                    </p>

                </div>

                <div class="p-6">

                    @forelse ($incomeByCategory as $income)

                        @php
                            $percentage = $totalIncome > 0
                                ? ($income->total / $totalIncome) * 100
                                : 0;
                        @endphp

                        <div class="mb-5 last:mb-0">

                            <div class="mb-2 flex items-center justify-between">

                                <p class="text-sm font-semibold text-slate-900">
                                    {{ $income->category }}
                                </p>

                                <div class="text-right">

                                    <p class="text-sm font-semibold text-green-600">
                                        ₦{{ number_format((float) $income->total, 2) }}
                                    </p>

                                    <p class="text-[11px] text-slate-400">
                                        {{ number_format($percentage, 1) }}%
                                    </p>

                                </div>

                            </div>

                            <div class="h-2 overflow-hidden rounded-full bg-slate-100">

                                <div
                                    class="h-2 rounded-full bg-green-500"
                                    style="width: {{ min($percentage, 100) }}%"
                                ></div>

                            </div>

                        </div>

                    @empty

                        <div class="py-8 text-center">

                            <p class="text-sm font-semibold text-slate-700">
                                No income recorded
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                There is no income for the selected period.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>


            {{-- Expenses By Category --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">

                    <h2 class="font-semibold text-slate-900">
                        Expenses by Category
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Expense breakdown for {{ $reportLabel }}
                    </p>

                </div>

                <div class="p-6">

                    @forelse ($expensesByCategory as $expense)

                        @php
                            $percentage = $totalExpenses > 0
                                ? ($expense->total / $totalExpenses) * 100
                                : 0;
                        @endphp

                        <div class="mb-5 last:mb-0">

                            <div class="mb-2 flex items-center justify-between">

                                <p class="text-sm font-semibold text-slate-900">
                                    {{ $expense->category }}
                                </p>

                                <div class="text-right">

                                    <p class="text-sm font-semibold text-red-600">
                                        ₦{{ number_format((float) $expense->total, 2) }}
                                    </p>

                                    <p class="text-[11px] text-slate-400">
                                        {{ number_format($percentage, 1) }}%
                                    </p>

                                </div>

                            </div>

                            <div class="h-2 overflow-hidden rounded-full bg-slate-100">

                                <div
                                    class="h-2 rounded-full bg-red-500"
                                    style="width: {{ min($percentage, 100) }}%"
                                ></div>

                            </div>

                        </div>

                    @empty

                        <div class="py-8 text-center">

                            <p class="text-sm font-semibold text-slate-700">
                                No expenses recorded
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                There are no expenses for the selected period.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>


        {{-- ============================================================= --}}
        {{-- INCOME TRANSACTIONS --}}
        {{-- ============================================================= --}}

        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <h2 class="font-semibold text-slate-900">
                            Income Transactions
                        </h2>

                        <p class="mt-1 text-xs text-slate-500">
                            Detailed income transactions for {{ $reportLabel }}
                        </p>

                    </div>

                    @if ($selectedAccount)

                        <span class="w-fit rounded-full bg-purple-50 px-3 py-1 text-xs font-semibold text-purple-700">
                            {{ $selectedAccount->name }}
                        </span>

                    @endif

                </div>

            </div>

            <div class="overflow-x-auto">

                @if ($incomeTransactions->count())

                    <table class="min-w-full text-left text-sm">

                        <thead class="border-b border-slate-200 bg-slate-50">

                            <tr>

                                <th class="px-6 py-3 font-semibold text-slate-600">
                                    Date
                                </th>

                                @if (! $selectedAccount)

                                    <th class="px-6 py-3 font-semibold text-slate-600">
                                        Financial Account
                                    </th>

                                @endif

                                <th class="px-6 py-3 font-semibold text-slate-600">
                                    Category
                                </th>

                                <th class="px-6 py-3 font-semibold text-slate-600">
                                    Source
                                </th>

                                <th class="px-6 py-3 font-semibold text-slate-600">
                                    Payment Method
                                </th>

                                <th class="px-6 py-3 font-semibold text-slate-600">
                                    Reference
                                </th>

                                <th class="px-6 py-3 text-right font-semibold text-slate-600">
                                    Amount
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @foreach ($incomeTransactions as $income)

                                <tr class="transition hover:bg-slate-50">

                                    <td class="whitespace-nowrap px-6 py-4 text-slate-700">
                                        {{ $income->income_date?->format('d M Y') }}
                                    </td>

                                    @if (! $selectedAccount)

                                        <td class="px-6 py-4 text-slate-600">
                                            {{ $income->financialAccount?->name ?? 'Unassigned' }}
                                        </td>

                                    @endif

                                    <td class="px-6 py-4 font-medium text-slate-900">
                                        {{ $income->category }}
                                    </td>

                                    <td class="px-6 py-4 text-slate-600">
                                        {{ $income->source ?: '—' }}
                                    </td>

                                    <td class="px-6 py-4 text-slate-600">
                                        {{ $income->payment_method ?: '—' }}
                                    </td>

                                    <td class="px-6 py-4 text-slate-600">
                                        {{ $income->reference ?: '—' }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-right font-semibold text-green-600">
                                        ₦{{ number_format((float) $income->amount, 2) }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                        <tfoot class="border-t border-slate-200 bg-slate-50">

                            <tr>

                                <td
                                    colspan="{{ $selectedAccount ? 5 : 6 }}"
                                    class="px-6 py-4 text-right font-semibold text-slate-700"
                                >
                                    Total Income
                                </td>

                                <td class="px-6 py-4 text-right font-bold text-green-600">
                                    ₦{{ number_format((float) $totalIncome, 2) }}
                                </td>

                            </tr>

                        </tfoot>

                    </table>

                @else

                    <div class="px-6 py-12 text-center">

                        <p class="text-sm font-semibold text-slate-700">
                            No income transactions
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            There are no income transactions for the selected period.
                        </p>

                    </div>

                @endif

            </div>

        </div>


        {{-- ============================================================= --}}
        {{-- EXPENSE TRANSACTIONS --}}
        {{-- ============================================================= --}}

        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <h2 class="font-semibold text-slate-900">
                            Expense Transactions
                        </h2>

                        <p class="mt-1 text-xs text-slate-500">
                            Detailed expense transactions for {{ $reportLabel }}
                        </p>

                    </div>

                    @if ($selectedAccount)

                        <span class="w-fit rounded-full bg-purple-50 px-3 py-1 text-xs font-semibold text-purple-700">
                            {{ $selectedAccount->name }}
                        </span>

                    @endif

                </div>

            </div>

            <div class="overflow-x-auto">

                @if ($expenseTransactions->count())

                    <table class="min-w-full text-left text-sm">

                        <thead class="border-b border-slate-200 bg-slate-50">

                            <tr>

                                <th class="px-6 py-3 font-semibold text-slate-600">
                                    Date
                                </th>

                                @if (! $selectedAccount)

                                    <th class="px-6 py-3 font-semibold text-slate-600">
                                        Financial Account
                                    </th>

                                @endif

                                <th class="px-6 py-3 font-semibold text-slate-600">
                                    Category
                                </th>

                                <th class="px-6 py-3 font-semibold text-slate-600">
                                    Vendor
                                </th>

                                <th class="px-6 py-3 font-semibold text-slate-600">
                                    Payment Method
                                </th>

                                <th class="px-6 py-3 font-semibold text-slate-600">
                                    Reference
                                </th>

                                <th class="px-6 py-3 text-right font-semibold text-slate-600">
                                    Amount
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @foreach ($expenseTransactions as $expense)

                                <tr class="transition hover:bg-slate-50">

                                    <td class="whitespace-nowrap px-6 py-4 text-slate-700">
                                        {{ $expense->expense_date?->format('d M Y') }}
                                    </td>

                                    @if (! $selectedAccount)

                                        <td class="px-6 py-4 text-slate-600">
                                            {{ $expense->financialAccount?->name ?? 'Unassigned' }}
                                        </td>

                                    @endif

                                    <td class="px-6 py-4 font-medium text-slate-900">
                                        {{ $expense->category }}
                                    </td>

                                    <td class="px-6 py-4 text-slate-600">
                                        {{ $expense->vendor ?: '—' }}
                                    </td>

                                    <td class="px-6 py-4 text-slate-600">
                                        {{ $expense->payment_method ?: '—' }}
                                    </td>

                                    <td class="px-6 py-4 text-slate-600">
                                        {{ $expense->reference ?: '—' }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-right font-semibold text-red-600">
                                        ₦{{ number_format((float) $expense->amount, 2) }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                        <tfoot class="border-t border-slate-200 bg-slate-50">

                            <tr>

                                <td
                                    colspan="{{ $selectedAccount ? 5 : 6 }}"
                                    class="px-6 py-4 text-right font-semibold text-slate-700"
                                >
                                    Total Expenses
                                </td>

                                <td class="px-6 py-4 text-right font-bold text-red-600">
                                    ₦{{ number_format((float) $totalExpenses, 2) }}
                                </td>

                            </tr>

                        </tfoot>

                    </table>

                @else

                    <div class="px-6 py-12 text-center">

                        <p class="text-sm font-semibold text-slate-700">
                            No expense transactions
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            There are no expense transactions for the selected period.
                        </p>

                    </div>

                @endif

            </div>

        </div>


        {{-- ============================================================= --}}
        {{-- CHURCH SUMMARY --}}
        {{-- ============================================================= --}}

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">

            {{-- Members --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Members
                        </p>

                        <p class="mt-2 text-2xl font-bold text-slate-900">
                            {{ number_format($totalMembers) }}
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            Registered church members
                        </p>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-purple-100 text-xl text-purple-600">
                        ♟
                    </div>

                </div>

            </div>


            {{-- Services --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Services
                        </p>

                        <p class="mt-2 text-2xl font-bold text-slate-900">
                            {{ number_format($totalServices) }}
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            Services recorded
                        </p>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-blue-100 text-xl text-blue-600">
                        ◷
                    </div>

                </div>

            </div>


            {{-- Attendance --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Attendance Records
                        </p>

                        <p class="mt-2 text-2xl font-bold text-slate-900">
                            {{ number_format($totalAttendance) }}
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            Total attendance records
                        </p>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-green-100 text-xl text-green-600">
                        ✓
                    </div>

                </div>

            </div>

        </div>


        {{-- ============================================================= --}}
        {{-- REPORT CATEGORIES --}}
        {{-- ============================================================= --}}

        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h2 class="font-semibold text-slate-900">
                    Reports
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Detailed report categories available in ChurchFlow.
                </p>

            </div>

            <div class="grid grid-cols-1 gap-4 p-6 sm:grid-cols-2 lg:grid-cols-3">

                <div
                    class="cursor-pointer rounded-lg border border-slate-200 p-5 transition hover:border-purple-300 hover:bg-purple-50"
                >
                    <h3 class="text-sm font-semibold text-slate-900">
                        Financial Reports
                    </h3>

                    <p class="mt-1 text-xs leading-5 text-slate-500">
                        Analyse income, expenses, account balances and financial movement.
                    </p>
                </div>


                <div
                    class="cursor-pointer rounded-lg border border-slate-200 p-5 transition hover:border-purple-300 hover:bg-purple-50"
                >
                    <h3 class="text-sm font-semibold text-slate-900">
                        Attendance Reports
                    </h3>

                    <p class="mt-1 text-xs leading-5 text-slate-500">
                        Review attendance across church services.
                    </p>
                </div>


                <div
                    class="cursor-pointer rounded-lg border border-slate-200 p-5 transition hover:border-purple-300 hover:bg-purple-50"
                >
                    <h3 class="text-sm font-semibold text-slate-900">
                        Membership Reports
                    </h3>

                    <p class="mt-1 text-xs leading-5 text-slate-500">
                        Analyse church membership and member growth.
                    </p>
                </div>

            </div>

        </div>

    </div>


    {{-- ============================================================= --}}
    {{-- CUSTOM DATE FIELD TOGGLE --}}
    {{-- ============================================================= --}}

    <script>
        function toggleCustomDateFields() {
            const period = document.getElementById('period').value;

            const startDateField = document.getElementById('start-date-field');
            const endDateField = document.getElementById('end-date-field');

            if (period === 'custom') {
                startDateField.classList.remove('hidden');
                endDateField.classList.remove('hidden');
            } else {
                startDateField.classList.add('hidden');
                endDateField.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            toggleCustomDateFields();
        });
    </script>

@endsection