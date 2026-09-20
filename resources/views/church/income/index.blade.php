@extends('layouts.church')

@section('title', 'Income')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Income
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Track and manage income received by your church.
            </p>
        </div>

        <a
            href="{{ route('church.income.create') }}"
            class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
        >
            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4v16m8-8H4"/>
            </svg>
            Record Income
        </a>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

        {{-- Total Income --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Income
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        ₦{{ number_format((float) $totalIncome, 2) }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100 text-purple-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-10V5m0 14v-3m9-4a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Current Month --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        This Month
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        ₦{{ number_format((float) $currentMonthIncome, 2) }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-100 text-green-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 10h18M7 15h2m4 0h2m-8 4h10a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>

    {{-- Filters --}}
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

        <div class="mb-4">
            <h2 class="text-base font-semibold text-slate-900">
                Filter Income
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Narrow the records by category, payment method or date.
            </p>
        </div>

        <form
            method="GET"
            action="{{ route('church.income.index') }}"
            class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-5"
        >

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
                    class="w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500"
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
                    class="mb-1.5 block text-sm font-medium text-slate-700"
                >
                    Payment Method
                </label>

                <select
                    id="payment_method"
                    name="payment_method"
                    class="w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500"
                >
                    <option value="">All Methods</option>
                    <option value="cash" @selected(request('payment_method') === 'cash')>
                        Cash
                    </option>
                    <option value="bank_transfer" @selected(request('payment_method') === 'bank_transfer')>
                        Bank Transfer
                    </option>
                    <option value="card" @selected(request('payment_method') === 'card')>
                        Card
                    </option>
                    <option value="online" @selected(request('payment_method') === 'online')>
                        Online
                    </option>
                    <option value="other" @selected(request('payment_method') === 'other')>
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
                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500"
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
                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500"
                >
            </div>

            {{-- Actions --}}
            <div class="flex items-end gap-2">
                <button
                    type="submit"
                    class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800"
                >
                    Filter
                </button>

                <a
                    href="{{ route('church.income.index') }}"
                    class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Reset
                </a>
            </div>

        </form>
    </div>

    {{-- Income Records --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-base font-semibold text-slate-900">
                    Income Records
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    {{ $incomes->total() }} record{{ $incomes->total() === 1 ? '' : 's' }}
                </p>
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

                    <tbody class="divide-y divide-slate-200 bg-white">

                        @foreach($incomes as $income)
                            <tr class="transition hover:bg-slate-50">

                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-700">
                                    {{ $income->income_date?->format('d M Y') }}
                                </td>

                                <td class="px-5 py-4">
                                    <span class="inline-flex rounded-full bg-purple-100 px-2.5 py-1 text-xs font-semibold text-purple-700">
                                        {{ $income->category }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-sm text-slate-700">
                                    {{ $income->source ?: '—' }}
                                </td>

                                <td class="px-5 py-4 text-sm text-slate-700">
                                    @if($income->member)
                                        {{ $income->member->first_name }}
                                        {{ $income->member->last_name }}
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </td>

                                <td class="px-5 py-4 text-sm text-slate-700">
                                    {{ $income->payment_method
                                        ? ucwords(str_replace('_', ' ', $income->payment_method))
                                        : '—'
                                    }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-right text-sm font-semibold text-slate-900">
                                    ₦{{ number_format((float) $income->amount, 2) }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">

                                        <a
                                            href="{{ route('church.income.show', $income) }}"
                                            class="cursor-pointer rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:bg-slate-100"
                                        >
                                            View
                                        </a>

                                        <a
                                            href="{{ route('church.income.edit', $income) }}"
                                            class="cursor-pointer rounded-lg border border-purple-200 px-3 py-1.5 text-xs font-semibold text-purple-700 transition hover:bg-purple-50"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('church.income.destroy', $income) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this income record?');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="cursor-pointer rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-50"
                                            >
                                                Delete
                                            </button>
                                        </form>

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

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-purple-100 text-purple-600">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-10V5m0 14v-3m9-4a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <h3 class="mt-4 text-base font-semibold text-slate-900">
                    No income records found
                </h3>

                <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
                    Start recording your church income to keep your financial records organized.
                </p>

                <a
                    href="{{ route('church.income.create') }}"
                    class="mt-5 inline-flex cursor-pointer items-center rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700"
                >
                    Record Your First Income
                </a>

            </div>

        @endif

    </div>

</div>
@endsection