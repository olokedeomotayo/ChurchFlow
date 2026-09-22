@extends('layouts.church')

@section('content')

<div class="mx-auto max-w-4xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <a
                href="{{ route('church.expenses.index') }}"
                class="inline-flex cursor-pointer items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-purple-600"
            >
                ← Back to Expenses
            </a>

            <h1 class="mt-4 text-2xl font-bold text-slate-900">
                Expense Details
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                View the details of this expense record.
            </p>
        </div>

        <div class="flex flex-wrap gap-2">

            <a
                href="{{ route('church.expenses.edit', $expense) }}"
                class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700"
            >
                Edit Expense
            </a>

            <form
                method="POST"
                action="{{ route('church.expenses.destroy', $expense) }}"
                onsubmit="return confirm('Are you sure you want to delete this expense?');"
            >
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-red-200 bg-white px-4 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50"
                >
                    Delete
                </button>
            </form>

        </div>

    </div>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif


    {{-- Amount Card --}}
    <div class="rounded-xl bg-purple-600 p-6 text-white shadow-sm">

        <p class="text-sm font-medium text-purple-100">
            Expense Amount
        </p>

        <p class="mt-2 text-3xl font-bold">
            ₦{{ number_format((float) $expense->amount, 2) }}
        </p>

        <div class="mt-4 flex flex-wrap items-center gap-3 text-sm text-purple-100">

            <span>
                {{ $expense->category }}
            </span>

            <span class="text-purple-300">
                •
            </span>

            <span>
                {{ $expense->expense_date?->format('d M Y') }}
            </span>

            @if($expense->financialAccount)

                <span class="text-purple-300">
                    •
                </span>

                <span>
                    {{ $expense->financialAccount->name }}
                </span>

            @endif

        </div>

    </div>


    {{-- Expense Information --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="font-semibold text-slate-900">
                Expense Information
            </h2>
        </div>

        <div class="grid grid-cols-1 gap-x-8 gap-y-6 p-6 md:grid-cols-2">

            {{-- Financial Account --}}
            <div class="md:col-span-2">

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Financial Account
                </p>

                @if($expense->financialAccount)

                    <div class="mt-2 flex flex-wrap items-center gap-2">

                        <p class="text-sm font-semibold text-slate-900">
                            {{ $expense->financialAccount->name }}
                        </p>

                        @if($expense->financialAccount->is_default)
                            <span class="inline-flex rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700">
                                Default
                            </span>
                        @endif

                        @if($expense->financialAccount->is_active)
                            <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                Active
                            </span>
                        @else
                            <span class="inline-flex rounded-full bg-slate-200 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                Inactive
                            </span>
                        @endif

                    </div>

                    <div class="mt-2 flex flex-wrap gap-x-6 gap-y-1 text-xs text-slate-500">

                        <span class="capitalize">
                            Type:
                            {{ str_replace('_', ' ', $expense->financialAccount->type) }}
                        </span>

                        @if($expense->financialAccount->provider_name)
                            <span>
                                Provider:
                                {{ $expense->financialAccount->provider_name }}
                            </span>
                        @endif

                        @if($expense->financialAccount->account_number)
                            <span>
                                Account:
                                {{ $expense->financialAccount->account_number }}
                            </span>
                        @endif

                    </div>

                @else

                    <p class="mt-1 text-sm font-medium text-amber-600">
                        Unassigned
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        This expense was created before financial account
                        tracking was introduced.
                    </p>

                @endif

            </div>


            {{-- Category --}}
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Category
                </p>

                <p class="mt-1 text-sm font-medium text-slate-900">
                    {{ $expense->category }}
                </p>
            </div>


            {{-- Expense Date --}}
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Expense Date
                </p>

                <p class="mt-1 text-sm font-medium text-slate-900">
                    {{ $expense->expense_date?->format('d M Y') ?? '—' }}
                </p>
            </div>


            {{-- Payment Method --}}
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Payment Method
                </p>

                <p class="mt-1 text-sm font-medium capitalize text-slate-900">
                    {{ $expense->payment_method ?: '—' }}
                </p>
            </div>


            {{-- Vendor --}}
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Vendor / Payee
                </p>

                <p class="mt-1 text-sm font-medium text-slate-900">
                    {{ $expense->vendor ?: '—' }}
                </p>
            </div>


            {{-- Reference --}}
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Reference
                </p>

                <p class="mt-1 text-sm font-medium text-slate-900">
                    {{ $expense->reference ?: '—' }}
                </p>
            </div>


            {{-- Associated Member --}}
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Associated Member
                </p>

                @if($expense->member)

                    <p class="mt-1 text-sm font-medium text-slate-900">
                        {{ $expense->member->first_name }}
                        {{ $expense->member->last_name }}
                    </p>

                    @if($expense->member->member_id)
                        <p class="mt-0.5 text-xs text-slate-500">
                            {{ $expense->member->member_id }}
                        </p>
                    @endif

                @else

                    <p class="mt-1 text-sm font-medium text-slate-500">
                        Not associated with a member
                    </p>

                @endif

            </div>


            {{-- Description --}}
            <div class="md:col-span-2">

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Description
                </p>

                <div class="mt-2 rounded-lg bg-slate-50 p-4 text-sm leading-6 text-slate-700">
                    {{ $expense->description ?: 'No description provided.' }}
                </div>

            </div>


            {{-- Notes --}}
            <div class="md:col-span-2">

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Notes
                </p>

                <div class="mt-2 rounded-lg bg-slate-50 p-4 text-sm leading-6 text-slate-700">
                    {{ $expense->notes ?: 'No additional notes.' }}
                </div>

            </div>

        </div>

    </div>


    {{-- Metadata --}}
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="font-semibold text-slate-900">
            Record Information
        </h2>

        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">

            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Created
                </p>

                <p class="mt-1 text-sm text-slate-700">
                    {{ $expense->created_at?->format('d M Y, h:i A') ?? '—' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Last Updated
                </p>

                <p class="mt-1 text-sm text-slate-700">
                    {{ $expense->updated_at?->format('d M Y, h:i A') ?? '—' }}
                </p>
            </div>

        </div>

    </div>

</div>

@endsection