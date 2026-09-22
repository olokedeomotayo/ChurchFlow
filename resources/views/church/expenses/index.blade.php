@extends('layouts.church')

@section('content')

<div class="space-y-6">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                Expenses
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Track and manage your church expenses.
            </p>
        </div>

        <div class="flex flex-wrap gap-2">

            <a
                href="{{ route('church.expenses.import') }}"
                class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
            >
                <span>↓</span>
                Import
            </a>

            <a
                href="{{ route('church.expenses.export', request()->query()) }}"
                class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
            >
                <span>↑</span>
                Export
            </a>

            <a
                href="{{ route('church.expenses.create') }}"
                class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700"
            >
                <span class="text-lg leading-none">+</span>
                Record Expense
            </a>

        </div>

    </div>


    {{-- =====================================================
         FLASH MESSAGES
    ====================================================== --}}

    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif


    {{-- =====================================================
         FINANCIAL ACCOUNT CONTEXT
    ====================================================== --}}

    @if($selectedAccount)

        <div class="rounded-xl border border-purple-200 bg-purple-50 px-5 py-4">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <div class="flex flex-wrap items-center gap-2">

                        <span class="text-xs font-semibold uppercase tracking-wide text-purple-600">
                            Financial Account
                        </span>

                        @if($selectedAccount->is_default)
                            <span class="rounded-full bg-purple-100 px-2.5 py-1 text-[11px] font-semibold text-purple-700">
                                Default
                            </span>
                        @endif

                    </div>

                    <h2 class="mt-1 text-lg font-bold text-slate-900">
                        {{ $selectedAccount->name }}
                    </h2>

                    <p class="mt-1 text-sm capitalize text-slate-600">
                        {{ str_replace('_', ' ', $selectedAccount->type) }}

                        @if($selectedAccount->provider_name)
                            · {{ $selectedAccount->provider_name }}
                        @endif
                    </p>

                </div>

                <div class="rounded-lg border border-purple-200 bg-white px-4 py-3">

                    <p class="text-xs font-medium text-slate-500">
                        Current Balance
                    </p>

                    <p class="mt-1 text-lg font-bold text-slate-900">
                        {{ $selectedAccount->currency }}
                        {{ number_format((float) $selectedAccount->current_balance, 2) }}
                    </p>

                </div>

            </div>

        </div>

    @else

        <div class="rounded-xl border border-slate-200 bg-white px-5 py-4 shadow-sm">

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Financial Accounts
                    </p>

                    <h2 class="mt-1 text-lg font-bold text-slate-900">
                        All Accounts
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Showing expenses across all financial accounts.
                    </p>

                </div>

                <a
                    href="{{ route('church.settings.financial-accounts.index') }}"
                    class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Manage Accounts
                </a>

            </div>

        </div>

    @endif


    {{-- =====================================================
         SUMMARY CARDS
    ====================================================== --}}

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

        {{-- Total Expenses --}}

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        {{ $selectedAccount ? 'Account Expenses' : 'Total Expenses' }}
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        ₦{{ number_format((float) $totalExpenses, 2) }}
                    </p>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-red-50 text-lg text-red-600">
                    ↘
                </div>

            </div>

        </div>


        {{-- This Month --}}

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        This Month
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        ₦{{ number_format((float) $currentMonthExpenses, 2) }}
                    </p>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-purple-50 text-lg text-purple-600">
                    ₦
                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         FILTER EXPENSES
    ====================================================== --}}

    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

        <div class="mb-5">

            <h2 class="text-sm font-semibold text-slate-900">
                Filter Expenses
            </h2>

            <p class="mt-1 text-xs text-slate-500">
                Narrow down the expense records displayed below.
            </p>

        </div>


        <form
            method="GET"
            action="{{ route('church.expenses.index') }}"
            class="space-y-4"
        >

            {{-- Filter Fields --}}

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-5">

                {{-- Financial Account --}}

                <div>

                    <label
                        for="financial_account_id"
                        class="mb-2 block text-xs font-medium text-slate-700"
                    >
                        Financial Account
                    </label>

                    <select
                        id="financial_account_id"
                        name="financial_account_id"
                        class="h-11 w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-3 text-sm text-slate-700 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                    >

                        <option value="">
                            All Accounts
                        </option>

                        @foreach($accounts as $account)

                            <option
                                value="{{ $account->id }}"
                                @selected((int) request('financial_account_id') === $account->id)
                            >
                                {{ $account->name }}
                                @if($account->is_default)
                                    — Default
                                @endif
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Category --}}

                <div>

                    <label
                        for="category"
                        class="mb-2 block text-xs font-medium text-slate-700"
                    >
                        Category
                    </label>

                    <select
                        id="category"
                        name="category"
                        class="h-11 w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-3 text-sm text-slate-700 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                    >

                        <option value="">
                            All Categories
                        </option>

                        @foreach($categories as $category)

                            <option
                                value="{{ $category }}"
                                @selected(request('category') === $category)
                            >
                                {{ $category }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Payment Method --}}

                <div>

                    <label
                        for="payment_method"
                        class="mb-2 block text-xs font-medium text-slate-700"
                    >
                        Payment Method
                    </label>

                    <select
                        id="payment_method"
                        name="payment_method"
                        class="h-11 w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-3 text-sm text-slate-700 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                    >

                        <option value="">
                            All Methods
                        </option>

                        @foreach([
                            'cash' => 'Cash',
                            'bank transfer' => 'Bank Transfer',
                            'card' => 'Card',
                            'cheque' => 'Cheque',
                            'other' => 'Other',
                        ] as $value => $label)

                            <option
                                value="{{ $value }}"
                                @selected(request('payment_method') === $value)
                            >
                                {{ $label }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Date From --}}

                <div>

                    <label
                        for="date_from"
                        class="mb-2 block text-xs font-medium text-slate-700"
                    >
                        Date From
                    </label>

                    <input
                        type="date"
                        id="date_from"
                        name="date_from"
                        value="{{ request('date_from') }}"
                        class="h-11 w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-3 text-sm text-slate-700 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                    >

                </div>


                {{-- Date To --}}

                <div>

                    <label
                        for="date_to"
                        class="mb-2 block text-xs font-medium text-slate-700"
                    >
                        Date To
                    </label>

                    <input
                        type="date"
                        id="date_to"
                        name="date_to"
                        value="{{ request('date_to') }}"
                        class="h-11 w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-3 text-sm text-slate-700 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                    >

                </div>

            </div>


            {{-- Apply Filters --}}

            <div class="flex justify-end">

                <button
                    type="submit"
                    class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                    </svg>

                    Apply Filters

                </button>

            </div>

        </form>

    </div>


    {{-- =====================================================
         ACTIVE FILTERS
    ====================================================== --}}

    @if(
        request()->filled('financial_account_id')
        || request()->filled('category')
        || request()->filled('payment_method')
        || request()->filled('date_from')
        || request()->filled('date_to')
    )

        <div class="flex flex-wrap items-center gap-2">

            <span class="text-xs font-semibold text-slate-500">
                Active filters:
            </span>

            @if($selectedAccount)

                <span class="rounded-full bg-purple-100 px-3 py-1 text-xs font-semibold text-purple-700">
                    Account: {{ $selectedAccount->name }}
                </span>

            @endif

            @if(request('category'))

                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                    Category: {{ request('category') }}
                </span>

            @endif

            @if(request('payment_method'))

                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold capitalize text-slate-700">
                    Payment: {{ request('payment_method') }}
                </span>

            @endif

            @if(request('date_from'))

                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                    From: {{ request('date_from') }}
                </span>

            @endif

            @if(request('date_to'))

                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                    To: {{ request('date_to') }}
                </span>

            @endif

        </div>

    @endif


    {{-- =====================================================
         EXPENSE RECORDS
    ====================================================== --}}

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-5 py-4">

            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <h2 class="font-semibold text-slate-900">
                        Expense Records
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        {{ $expenses->total() }} record(s)
                    </p>

                </div>

                @if($selectedAccount)

                    <span class="inline-flex w-fit items-center rounded-full bg-purple-50 px-3 py-1.5 text-xs font-semibold text-purple-700">
                        {{ $selectedAccount->name }}
                    </span>

                @endif

            </div>

        </div>


        @if($expenses->count())

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-slate-200">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Date
                            </th>

                            @if(!$selectedAccount)

                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Financial Account
                                </th>

                            @endif

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Category
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Description
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Vendor
                            </th>

                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Amount
                            </th>

                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @foreach($expenses as $expense)

                            <tr class="transition hover:bg-slate-50">

                                {{-- Date --}}

                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                                    {{ $expense->expense_date?->format('d M Y') }}
                                </td>


                                {{-- Financial Account --}}

                                @if(!$selectedAccount)

                                    <td class="px-5 py-4">

                                        @if($expense->financialAccount)

                                            <div>

                                                <p class="text-sm font-medium text-slate-900">
                                                    {{ $expense->financialAccount->name }}
                                                </p>

                                                @if($expense->financialAccount->is_default)

                                                    <span class="mt-1 inline-flex rounded-full bg-purple-50 px-2 py-0.5 text-[10px] font-semibold text-purple-700">
                                                        Default
                                                    </span>

                                                @endif

                                            </div>

                                        @else

                                            <span class="text-sm text-amber-600">
                                                Unassigned
                                            </span>

                                        @endif

                                    </td>

                                @endif


                                {{-- Category --}}

                                <td class="px-5 py-4">

                                    <span class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700">
                                        {{ $expense->category }}
                                    </span>

                                </td>


                                {{-- Description --}}

                                <td class="max-w-xs px-5 py-4 text-sm text-slate-600">
                                    {{ $expense->description ?: '—' }}
                                </td>


                                {{-- Vendor --}}

                                <td class="px-5 py-4 text-sm text-slate-600">
                                    {{ $expense->vendor ?: '—' }}
                                </td>


                                {{-- Amount --}}

                                <td class="whitespace-nowrap px-5 py-4 text-right text-sm font-semibold text-slate-900">
                                    ₦{{ number_format((float) $expense->amount, 2) }}
                                </td>


                                {{-- Actions --}}

                                <td class="whitespace-nowrap px-5 py-4 text-right">

                                    <div class="flex justify-end gap-2">

                                        <a
                                            href="{{ route('church.expenses.show', $expense) }}"
                                            class="cursor-pointer rounded-lg px-3 py-1.5 text-xs font-semibold text-purple-600 transition hover:bg-purple-50"
                                        >
                                            View
                                        </a>

                                        <a
                                            href="{{ route('church.expenses.edit', $expense) }}"
                                            class="cursor-pointer rounded-lg px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:bg-slate-100"
                                        >
                                            Edit
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}

            @if($expenses->hasPages())

                <div class="border-t border-slate-200 px-5 py-4">
                    {{ $expenses->links() }}
                </div>

            @endif

        @else

            <div class="px-6 py-16 text-center">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-2xl text-slate-400">
                    ↘
                </div>

                <h3 class="mt-4 text-sm font-semibold text-slate-900">
                    No expenses found
                </h3>

                <p class="mt-1 text-sm text-slate-500">

                    @if($selectedAccount)
                        There are no expenses matching the selected account and filters.
                    @else
                        Start by recording your first church expense.
                    @endif

                </p>

                <a
                    href="{{ route('church.expenses.create') }}"
                    class="mt-5 inline-flex cursor-pointer items-center rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700"
                >
                    Record Expense
                </a>

            </div>

        @endif

    </div>

</div>

@endsection