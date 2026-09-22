@extends('layouts.church')

@section('title', 'Income')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                Income
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Track and manage income received by your church.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <a
                href="{{ route('church.income.import') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 cursor-pointer"
            >
                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 0115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"
                    />
                </svg>

                Import
            </a>

            <a
                href="{{ route('church.income.export') }}"
                class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 cursor-pointer"
            >
                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                    />
                </svg>

                Export
            </a>

            <a
                href="{{ route('church.income.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800 cursor-pointer"
            >
                <svg
                    class="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 4v16m8-8H4"
                    />
                </svg>

                Record Income
            </a>
        </div>
    </div>


    {{-- Financial Account Switcher --}}
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                    Financial Account
                </p>

                <h2 class="mt-1 text-lg font-bold text-slate-900">
                    {{ $selectedAccount?->name ?? 'All Accounts' }}
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    @if($selectedAccount)
                        Showing income records and totals for this account only.
                    @else
                        Showing income across all financial accounts.
                    @endif
                </p>
            </div>

            <form
                method="GET"
                action="{{ route('church.income.index') }}"
                class="w-full lg:w-auto"
            >
                {{-- Preserve other filters --}}
                @if(request('category'))
                    <input
                        type="hidden"
                        name="category"
                        value="{{ request('category') }}"
                    >
                @endif

                @if(request('payment_method'))
                    <input
                        type="hidden"
                        name="payment_method"
                        value="{{ request('payment_method') }}"
                    >
                @endif

                @if(request('date_from'))
                    <input
                        type="hidden"
                        name="date_from"
                        value="{{ request('date_from') }}"
                    >
                @endif

                @if(request('date_to'))
                    <input
                        type="hidden"
                        name="date_to"
                        value="{{ request('date_to') }}"
                    >
                @endif

                <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                    <label
                        for="financial_account_id"
                        class="text-sm font-medium text-slate-700"
                    >
                        View Account
                    </label>

                    <select
                        id="financial_account_id"
                        name="financial_account_id"
                        onchange="this.form.submit()"
                        class="min-w-[240px] rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200 cursor-pointer"
                    >
                        <option value="">
                            All Accounts
                        </option>

                        @foreach($accounts as $account)
                            <option
                                value="{{ $account->id }}"
                                @selected($selectedAccountId === $account->id)
                            >
                                {{ $account->name }}
                                @if($account->is_default)
                                    — Default
                                @endif

                                @if(!$account->is_active)
                                    — Inactive
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>


    {{-- Account Information --}}
    @if($selectedAccount)
        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
            <div class="flex flex-wrap items-center gap-x-6 gap-y-3">

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                        Account
                    </p>

                    <p class="mt-1 font-semibold text-slate-900">
                        {{ $selectedAccount->name }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                        Type
                    </p>

                    <p class="mt-1 font-semibold capitalize text-slate-900">
                        {{ str_replace('_', ' ', $selectedAccount->type) }}
                    </p>
                </div>

                @if($selectedAccount->provider_name)
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                            Provider
                        </p>

                        <p class="mt-1 font-semibold text-slate-900">
                            {{ $selectedAccount->provider_name }}
                        </p>
                    </div>
                @endif

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                        Status
                    </p>

                    <p class="mt-1">
                        @if($selectedAccount->is_active)
                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-slate-200 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                Inactive
                            </span>
                        @endif
                    </p>
                </div>

                @if($selectedAccount->is_default)
                    <div>
                        <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700">
                            Default Account
                        </span>
                    </div>
                @endif

            </div>
        </div>
    @endif


    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

        {{-- Total Income --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        {{ $selectedAccount?->name ?? 'Total Income' }}
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        ₦{{ number_format((float) $totalIncome, 2) }}
                    </p>

                    @if($selectedAccount)
                        <p class="mt-1 text-xs text-slate-500">
                            Total income for this account
                        </p>
                    @endif
                </div>

                <div class="rounded-lg bg-emerald-50 p-2.5 text-emerald-600">
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                </div>
            </div>
        </div>


        {{-- This Month --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        This Month
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        ₦{{ number_format((float) $currentMonthIncome, 2) }}
                    </p>

                    @if($selectedAccount)
                        <p class="mt-1 text-xs text-slate-500">
                            {{ $selectedAccount->name }}
                        </p>
                    @else
                        <p class="mt-1 text-xs text-slate-500">
                            Across all accounts
                        </p>
                    @endif
                </div>

                <div class="rounded-lg bg-blue-50 p-2.5 text-blue-600">
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                        />
                    </svg>
                </div>
            </div>
        </div>

    </div>


    {{-- Filters --}}
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

        <div class="mb-4 flex items-center justify-between">
            <div>
                <h2 class="text-base font-semibold text-slate-900">
                    Filter Income
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Narrow down the records displayed below.
                </p>
            </div>

            @if(request()->hasAny([
                'category',
                'payment_method',
                'date_from',
                'date_to'
            ]))
                <a
                    href="{{ route('church.income.index', $selectedAccountId ? ['financial_account_id' => $selectedAccountId] : []) }}"
                    class="text-sm font-medium text-slate-600 hover:text-slate-900 cursor-pointer"
                >
                    Clear Filters
                </a>
            @endif
        </div>

        <form
            method="GET"
            action="{{ route('church.income.index') }}"
        >
            {{-- Keep selected account --}}
            @if($selectedAccountId)
                <input
                    type="hidden"
                    name="financial_account_id"
                    value="{{ $selectedAccountId }}"
                >
            @endif

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">

                {{-- Category --}}
                <div>
                    <label
                        for="category"
                        class="mb-1.5 block text-sm font-medium text-slate-700"
                    >
                        Category
                    </label>

                    <select
                        id="category"
                        name="category"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200 cursor-pointer"
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
                        class="mb-1.5 block text-sm font-medium text-slate-700"
                    >
                        Payment Method
                    </label>

                    <select
                        id="payment_method"
                        name="payment_method"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200 cursor-pointer"
                    >
                        <option value="">
                            All Methods
                        </option>

                        <option
                            value="cash"
                            @selected(request('payment_method') === 'cash')
                        >
                            Cash
                        </option>

                        <option
                            value="bank_transfer"
                            @selected(request('payment_method') === 'bank_transfer')
                        >
                            Bank Transfer
                        </option>

                        <option
                            value="card"
                            @selected(request('payment_method') === 'card')
                        >
                            Card
                        </option>

                        <option
                            value="pos"
                            @selected(request('payment_method') === 'pos')
                        >
                            POS
                        </option>

                        <option
                            value="mobile_money"
                            @selected(request('payment_method') === 'mobile_money')
                        >
                            Mobile Money
                        </option>

                        <option
                            value="other"
                            @selected(request('payment_method') === 'other')
                        >
                            Other
                        </option>
                    </select>
                </div>


                {{-- Date From --}}
                <div>
                    <label
                        for="date_from"
                        class="mb-1.5 block text-sm font-medium text-slate-700"
                    >
                        Date From
                    </label>

                    <input
                        type="date"
                        id="date_from"
                        name="date_from"
                        value="{{ request('date_from') }}"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                    >
                </div>


                {{-- Date To --}}
                <div>
                    <label
                        for="date_to"
                        class="mb-1.5 block text-sm font-medium text-slate-700"
                    >
                        Date To
                    </label>

                    <input
                        type="date"
                        id="date_to"
                        name="date_to"
                        value="{{ request('date_to') }}"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                    >
                </div>

            </div>

            <div class="mt-4 flex justify-end">
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800 cursor-pointer"
                >
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414A1 1 0 0013 14.414V19l-2 2v-6.586a1 1 0 00-.293-.707L4.293 7.293A1 1 0 014 6.586V4z"
                        />
                    </svg>

                    Apply Filters
                </button>
            </div>
        </form>
    </div>


    {{-- Income Records --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-5 py-4">
            <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="font-semibold text-slate-900">
                        Income Records
                    </h2>

                    <p class="text-sm text-slate-500">
                        @if($selectedAccount)
                            Income recorded under {{ $selectedAccount->name }}.
                        @else
                            Income recorded across all financial accounts.
                        @endif
                    </p>
                </div>

                <span class="text-sm text-slate-500">
                    {{ $incomes->total() }} record{{ $incomes->total() === 1 ? '' : 's' }}
                </span>
            </div>
        </div>


        @if($incomes->count())
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">

                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Date
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Category
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Source
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Member
                            </th>

                            @if(!$selectedAccount)
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Financial Account
                                </th>
                            @endif

                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Payment Method
                            </th>

                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Amount
                            </th>

                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 bg-white">

                        @foreach($incomes as $income)
                            <tr class="transition hover:bg-slate-50">

                                {{-- Date --}}
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-700">
                                    {{ $income->income_date?->format('d M Y') }}
                                </td>


                                {{-- Category --}}
                                <td class="px-5 py-4">
                                    <div class="text-sm font-semibold text-slate-900">
                                        {{ $income->category }}
                                    </div>

                                    @if($income->reference)
                                        <div class="mt-0.5 text-xs text-slate-500">
                                            Ref: {{ $income->reference }}
                                        </div>
                                    @endif
                                </td>


                                {{-- Source --}}
                                <td class="px-5 py-4 text-sm text-slate-600">
                                    {{ $income->source ?: '—' }}
                                </td>


                                {{-- Member --}}
                                <td class="px-5 py-4 text-sm text-slate-600">
                                    @if($income->member)
                                        <div class="font-medium text-slate-800">
                                            {{ $income->member->first_name }}
                                            {{ $income->member->last_name }}
                                        </div>

                                        @if($income->member->member_id)
                                            <div class="text-xs text-slate-500">
                                                {{ $income->member->member_id }}
                                            </div>
                                        @endif
                                    @else
                                        —
                                    @endif
                                </td>


                                {{-- Financial Account --}}
                                @if(!$selectedAccount)
                                    <td class="px-5 py-4">
                                        @if($income->financialAccount)
                                            <div class="text-sm font-medium text-slate-800">
                                                {{ $income->financialAccount->name }}
                                            </div>

                                            <div class="mt-1 flex flex-wrap gap-1">
                                                @if($income->financialAccount->is_default)
                                                    <span class="inline-flex rounded-full bg-blue-100 px-2 py-0.5 text-[10px] font-semibold text-blue-700">
                                                        Default
                                                    </span>
                                                @endif

                                                @if(!$income->financialAccount->is_active)
                                                    <span class="inline-flex rounded-full bg-slate-200 px-2 py-0.5 text-[10px] font-semibold text-slate-600">
                                                        Inactive
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-sm text-slate-400">
                                                Unassigned
                                            </span>
                                        @endif
                                    </td>
                                @endif


                                {{-- Payment Method --}}
                                <td class="px-5 py-4">
                                    @if($income->payment_method)
                                        <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium capitalize text-slate-700">
                                            {{ str_replace('_', ' ', $income->payment_method) }}
                                        </span>
                                    @else
                                        <span class="text-sm text-slate-400">
                                            —
                                        </span>
                                    @endif
                                </td>


                                {{-- Amount --}}
                                <td class="whitespace-nowrap px-5 py-4 text-right">
                                    <span class="text-sm font-bold text-emerald-700">
                                        ₦{{ number_format((float) $income->amount, 2) }}
                                    </span>
                                </td>


                                {{-- Actions --}}
                                <td class="whitespace-nowrap px-5 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">

                                        <a
                                            href="{{ route('church.income.show', $income) }}"
                                            class="inline-flex items-center rounded-lg border border-slate-200 p-2 text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 cursor-pointer"
                                            title="View"
                                        >
                                            <svg
                                                class="h-4 w-4"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                                />
                                            </svg>
                                        </a>

                                        <a
                                            href="{{ route('church.income.edit', $income) }}"
                                            class="inline-flex items-center rounded-lg border border-slate-200 p-2 text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 cursor-pointer"
                                            title="Edit"
                                        >
                                            <svg
                                                class="h-4 w-4"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-7.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 7.5-7.5z"
                                                />
                                            </svg>
                                        </a>

                                    </div>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>


            {{-- Pagination --}}
            @if($incomes->hasPages())
                <div class="border-t border-slate-200 px-5 py-4">
                    {{ $incomes->links() }}
                </div>
            @endif

        @else

            {{-- Empty State --}}
            <div class="px-6 py-16 text-center">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-500">
                    <svg
                        class="h-7 w-7"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                </div>

                <h3 class="mt-4 text-base font-semibold text-slate-900">
                    No income records found
                </h3>

                <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                    @if($selectedAccount)
                        There are no income records for
                        <strong>{{ $selectedAccount->name }}</strong>
                        matching the current filters.
                    @else
                        There are no income records matching the current filters.
                    @endif
                </p>

                <div class="mt-5">
                    <a
                        href="{{ route('church.income.create') }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 cursor-pointer"
                    >
                        <svg
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4v16m8-8H4"
                            />
                        </svg>

                        Record Income
                    </a>
                </div>

            </div>

        @endif

    </div>

</div>
@endsection