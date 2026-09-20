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
        {{-- REPORT PERIOD --}}
        {{-- ============================================================= --}}

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="mb-4">
                <h2 class="text-sm font-semibold text-slate-900">
                    Report Period
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Select the period you want to analyse.
                </p>
            </div>

            <form
                method="GET"
                action="{{ route('church.reports.index') }}"
                class="space-y-4"
            >

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-4">

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
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
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
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
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
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                        >
                    </div>


                    {{-- Actions --}}
                    <div class="flex items-end gap-2">

                        {{-- Actions --}}
                    <div class="flex items-end gap-2">

                        <button
                            type="submit"
                            class="inline-flex flex-1 cursor-pointer items-center justify-center rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700"
                        >
                            Generate Report
                        </button>

                        <a
                            href="{{ route('church.reports.export', request()->query()) }}"
                            class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-green-300 bg-green-50 px-4 py-2.5 text-sm font-semibold text-green-700 transition hover:border-green-400 hover:bg-green-100"
                        >
                            Export CSV
                        </a>

                        <a
                            href="{{ route('church.reports.export.pdf', request()->query()) }}"
                            class="cursor-pointer inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700"
                        >
                            PDF
                        </a>

                        <a
                            href="{{ route('church.reports.index') }}"
                            class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-red-300 hover:bg-red-50 hover:text-red-600"
                        >
                            Clear
                        </a>

                    </div>


                    </div>

                </div>


                {{-- Selected Period --}}
                <div class="flex items-center justify-between border-t border-slate-100 pt-4">

                    <p class="text-xs text-slate-500">
                        Showing financial figures for:
                    </p>

                    <span class="rounded-full bg-purple-50 px-3 py-1 text-xs font-semibold text-purple-700">
                        {{ $reportLabel }}
                    </span>

                </div>

            </form>

        </div>


        {{-- ============================================================= --}}
        {{-- FINANCIAL SUMMARY --}}
        {{-- ============================================================= --}}

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">

            {{-- Total Income --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Total Income
                </p>

                <p class="mt-2 text-2xl font-bold text-green-600">
                    ₦{{ number_format($totalIncome, 2) }}
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    All recorded church income
                </p>

            </div>


            {{-- Total Expenses --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Total Expenses
                </p>

                <p class="mt-2 text-2xl font-bold text-red-600">
                    ₦{{ number_format($totalExpenses, 2) }}
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    All recorded church expenses
                </p>

            </div>


            {{-- Net Balance --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Net Balance
                </p>

                <p class="mt-2 text-2xl font-bold {{ $netBalance >= 0 ? 'text-purple-600' : 'text-red-600' }}">
                    ₦{{ number_format($netBalance, 2) }}
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
                                        ₦{{ number_format($income->total, 2) }}
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
                                        ₦{{ number_format($expense->total, 2) }}
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

                <h2 class="font-semibold text-slate-900">
                    Income Transactions
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Detailed income transactions for {{ $reportLabel }}
                </p>

            </div>

            <div class="overflow-x-auto">

                @if ($incomeTransactions->count())

                    <table class="min-w-full text-left text-sm">

                        <thead class="border-b border-slate-200 bg-slate-50">

                            <tr>

                                <th class="px-6 py-3 font-semibold text-slate-600">
                                    Date
                                </th>

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
                                        ₦{{ number_format($income->amount, 2) }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                        <tfoot class="border-t border-slate-200 bg-slate-50">

                            <tr>

                                <td
                                    colspan="5"
                                    class="px-6 py-4 text-right font-semibold text-slate-700"
                                >
                                    Total Income
                                </td>

                                <td class="px-6 py-4 text-right font-bold text-green-600">
                                    ₦{{ number_format($totalIncome, 2) }}
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

        <h2 class="font-semibold text-slate-900">
            Expense Transactions
        </h2>

        <p class="mt-1 text-xs text-slate-500">
            Detailed expense transactions for {{ $reportLabel }}
        </p>

    </div>

    <div class="overflow-x-auto">

        @if ($expenseTransactions->count())

            <table class="min-w-full text-left text-sm">

                <thead class="border-b border-slate-200 bg-slate-50">

                    <tr>

                        <th class="px-6 py-3 font-semibold text-slate-600">
                            Date
                        </th>

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
                                ₦{{ number_format($expense->amount, 2) }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

                <tfoot class="border-t border-slate-200 bg-slate-50">

                    <tr>

                        <td
                            colspan="5"
                            class="px-6 py-4 text-right font-semibold text-slate-700"
                        >
                            Total Expenses
                        </td>

                        <td class="px-6 py-4 text-right font-bold text-red-600">
                            ₦{{ number_format($totalExpenses, 2) }}
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
                    Detailed reports will be available here.
                </p>

            </div>

            <div class="grid grid-cols-1 gap-4 p-6 sm:grid-cols-2 lg:grid-cols-3">

                {{-- Financial Reports --}}
                <div
                    class="cursor-pointer rounded-lg border border-slate-200 p-5 transition hover:border-purple-300 hover:bg-purple-50"
                >
                    <h3 class="text-sm font-semibold text-slate-900">
                        Financial Reports
                    </h3>

                    <p class="mt-1 text-xs leading-5 text-slate-500">
                        Analyse income, expenses and financial balance.
                    </p>
                </div>


                {{-- Attendance Reports --}}
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


                {{-- Membership Reports --}}
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
    </script>

@endsection