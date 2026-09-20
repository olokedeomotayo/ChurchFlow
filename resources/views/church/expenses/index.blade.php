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
                href="{{ route('church.expenses.export') }}"
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
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
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
                        Total Expenses
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


        {{-- Current Month --}}

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
         FILTERS
    ====================================================== --}}

    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

        <div class="mb-4">
            <h2 class="text-sm font-semibold text-slate-900">
                Filter Expenses
            </h2>
        </div>

        <form
            method="GET"
            action="{{ route('church.expenses.index') }}"
            class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-5"
        >

            {{-- Category --}}

            <div>
                <label
                    for="category"
                    class="mb-1.5 block text-xs font-semibold text-slate-600"
                >
                    Category
                </label>

                <select
                    id="category"
                    name="category"
                    class="w-full rounded-lg border-slate-300 text-sm focus:border-purple-500 focus:ring-purple-500"
                >
                    <option value="">All Categories</option>

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
                    class="mb-1.5 block text-xs font-semibold text-slate-600"
                >
                    Payment Method
                </label>

                <select
                    id="payment_method"
                    name="payment_method"
                    class="w-full rounded-lg border-slate-300 text-sm focus:border-purple-500 focus:ring-purple-500"
                >
                    <option value="">All Methods</option>

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
                    class="mb-1.5 block text-xs font-semibold text-slate-600"
                >
                    From
                </label>

                <input
                    type="date"
                    id="date_from"
                    name="date_from"
                    value="{{ request('date_from') }}"
                    class="w-full rounded-lg border-slate-300 text-sm focus:border-purple-500 focus:ring-purple-500"
                >
            </div>


            {{-- Date To --}}

            <div>
                <label
                    for="date_to"
                    class="mb-1.5 block text-xs font-semibold text-slate-600"
                >
                    To
                </label>

                <input
                    type="date"
                    id="date_to"
                    name="date_to"
                    value="{{ request('date_to') }}"
                    class="w-full rounded-lg border-slate-300 text-sm focus:border-purple-500 focus:ring-purple-500"
                >
            </div>


            {{-- Buttons --}}

            <div class="flex items-end gap-2">

                <button
                    type="submit"
                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800"
                >
                    Filter
                </button>

                <a
                    href="{{ route('church.expenses.index') }}"
                    class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Clear
                </a>

            </div>

        </form>

    </div>


    {{-- =====================================================
         EXPENSE TABLE
    ====================================================== --}}

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-5 py-4">

            <h2 class="font-semibold text-slate-900">
                Expense Records
            </h2>

            <p class="mt-1 text-xs text-slate-500">
                {{ $expenses->total() }} record(s)
            </p>

        </div>


        @if($expenses->count())

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

                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                                    {{ $expense->expense_date?->format('d M Y') }}
                                </td>

                                <td class="px-5 py-4">

                                    <span class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700">
                                        {{ $expense->category }}
                                    </span>

                                </td>

                                <td class="max-w-xs px-5 py-4 text-sm text-slate-600">
                                    {{ $expense->description ?: '—' }}
                                </td>

                                <td class="px-5 py-4 text-sm text-slate-600">
                                    {{ $expense->vendor ?: '—' }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-right text-sm font-semibold text-slate-900">
                                    ₦{{ number_format((float) $expense->amount, 2) }}
                                </td>

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
                    Start by recording your first church expense.
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