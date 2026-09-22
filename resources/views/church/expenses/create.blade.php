@extends('layouts.church')

@section('content')

<div class="mx-auto max-w-4xl space-y-6">

    {{-- Header --}}
    <div>
        <a
            href="{{ route('church.expenses.index') }}"
            class="inline-flex cursor-pointer items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-purple-600"
        >
            ← Back to Expenses
        </a>

        <h1 class="mt-4 text-2xl font-bold text-slate-900">
            Record Expense
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Record a new expense for {{ $church->name }}.
        </p>
    </div>


    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4">
            <p class="mb-2 text-sm font-semibold text-red-800">
                Please correct the following errors:
            </p>

            <ul class="list-inside list-disc space-y-1 text-sm text-red-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- No Financial Account Warning --}}
    @if($accounts->isEmpty())
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-5">
            <div class="flex gap-3">
                <div class="mt-0.5 text-amber-600">
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
                            d="M12 9v2m0 4h.01M10.29 3.86l-7.82 13a2 2 0 001.71 3h15.64a2 2 0 001.71-3l-7.82-13a2 2 0 00-3.42 0z"
                        />
                    </svg>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-amber-800">
                        No active financial account
                    </h3>

                    <p class="mt-1 text-sm text-amber-700">
                        You need at least one active financial account before
                        recording an expense.
                    </p>

                    <a
                        href="{{ route('church.settings.financial-accounts.create') }}"
                        class="mt-3 inline-flex cursor-pointer items-center gap-2 rounded-lg bg-amber-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-amber-700"
                    >
                        Create Financial Account
                    </a>
                </div>
            </div>
        </div>
    @endif


    {{-- Form --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

        <form
            method="POST"
            action="{{ route('church.expenses.store') }}"
            class="space-y-6 p-6"
        >

            @csrf


            {{-- Expense Information --}}
            <div>
                <h2 class="text-base font-semibold text-slate-900">
                    Expense Information
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Enter the basic details of the expense.
                </p>
            </div>


            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                {{-- Financial Account --}}
                <div class="md:col-span-2">

                    <label
                        for="financial_account_id"
                        class="mb-1.5 block text-sm font-semibold text-slate-700"
                    >
                        Financial Account
                        <span class="text-red-500">*</span>
                    </label>

                    <select
                        id="financial_account_id"
                        name="financial_account_id"
                        required
                        @disabled($accounts->isEmpty())
                        class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-purple-500 focus:ring-purple-500 disabled:cursor-not-allowed disabled:bg-slate-100"
                    >
                        <option value="">
                            Select financial account
                        </option>

                        @foreach($accounts as $account)
                            <option
                                value="{{ $account->id }}"
                                @selected(
                                    (string) old(
                                        'financial_account_id',
                                        $defaultAccount?->id
                                    ) === (string) $account->id
                                )
                            >
                                {{ $account->name }}

                                @if($account->is_default)
                                    — Default
                                @endif
                            </option>
                        @endforeach
                    </select>

                    <p class="mt-1.5 text-xs text-slate-500">
                        Select the account from which this expense was paid.
                    </p>

                    @error('financial_account_id')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Category --}}
                <div>
                    <label
                        for="category"
                        class="mb-1.5 block text-sm font-semibold text-slate-700"
                    >
                        Category
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        id="category"
                        name="category"
                        value="{{ old('category') }}"
                        required
                        maxlength="100"
                        placeholder="e.g. Utilities, Salaries, Transport"
                        class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-purple-500 focus:ring-purple-500"
                    >

                    @error('category')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Amount --}}
                <div>
                    <label
                        for="amount"
                        class="mb-1.5 block text-sm font-semibold text-slate-700"
                    >
                        Amount
                        <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-medium text-slate-500">
                            ₦
                        </span>

                        <input
                            type="number"
                            id="amount"
                            name="amount"
                            value="{{ old('amount') }}"
                            required
                            min="0.01"
                            step="0.01"
                            placeholder="0.00"
                            class="w-full rounded-lg border-slate-300 pl-8 text-sm shadow-sm focus:border-purple-500 focus:ring-purple-500"
                        >
                    </div>

                    @error('amount')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Expense Date --}}
                <div>
                    <label
                        for="expense_date"
                        class="mb-1.5 block text-sm font-semibold text-slate-700"
                    >
                        Expense Date
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="date"
                        id="expense_date"
                        name="expense_date"
                        value="{{ old('expense_date', now()->format('Y-m-d')) }}"
                        required
                        class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-purple-500 focus:ring-purple-500"
                    >

                    @error('expense_date')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Payment Method --}}
                <div>
                    <label
                        for="payment_method"
                        class="mb-1.5 block text-sm font-semibold text-slate-700"
                    >
                        Payment Method
                    </label>

                    <select
                        id="payment_method"
                        name="payment_method"
                        class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-purple-500 focus:ring-purple-500"
                    >
                        <option value="">
                            Select payment method
                        </option>

                        <option
                            value="cash"
                            @selected(old('payment_method') === 'cash')
                        >
                            Cash
                        </option>

                        <option
                            value="bank transfer"
                            @selected(old('payment_method') === 'bank transfer')
                        >
                            Bank Transfer
                        </option>

                        <option
                            value="card"
                            @selected(old('payment_method') === 'card')
                        >
                            Card
                        </option>

                        <option
                            value="cheque"
                            @selected(old('payment_method') === 'cheque')
                        >
                            Cheque
                        </option>

                        <option
                            value="other"
                            @selected(old('payment_method') === 'other')
                        >
                            Other
                        </option>
                    </select>

                    @error('payment_method')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Vendor --}}
                <div>
                    <label
                        for="vendor"
                        class="mb-1.5 block text-sm font-semibold text-slate-700"
                    >
                        Vendor / Payee
                    </label>

                    <input
                        type="text"
                        id="vendor"
                        name="vendor"
                        value="{{ old('vendor') }}"
                        maxlength="255"
                        placeholder="e.g. Electricity Company"
                        class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-purple-500 focus:ring-purple-500"
                    >

                    @error('vendor')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Reference --}}
                <div>
                    <label
                        for="reference"
                        class="mb-1.5 block text-sm font-semibold text-slate-700"
                    >
                        Reference
                    </label>

                    <input
                        type="text"
                        id="reference"
                        name="reference"
                        value="{{ old('reference') }}"
                        maxlength="100"
                        placeholder="e.g. EXP-0001"
                        class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-purple-500 focus:ring-purple-500"
                    >

                    @error('reference')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Member --}}
                <div class="md:col-span-2">

                    <label
                        for="member_id"
                        class="mb-1.5 block text-sm font-semibold text-slate-700"
                    >
                        Associated Member
                    </label>

                    <select
                        id="member_id"
                        name="member_id"
                        class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-purple-500 focus:ring-purple-500"
                    >
                        <option value="">
                            None / Not associated with a member
                        </option>

                        @foreach($members as $member)
                            <option
                                value="{{ $member->id }}"
                                @selected(
                                    (string) old('member_id') ===
                                    (string) $member->id
                                )
                            >
                                {{ $member->first_name }}
                                {{ $member->last_name }}

                                @if($member->member_id)
                                    — {{ $member->member_id }}
                                @endif
                            </option>
                        @endforeach
                    </select>

                    @error('member_id')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Description --}}
                <div class="md:col-span-2">

                    <label
                        for="description"
                        class="mb-1.5 block text-sm font-semibold text-slate-700"
                    >
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="3"
                        placeholder="Brief description of the expense..."
                        class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-purple-500 focus:ring-purple-500"
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Notes --}}
                <div class="md:col-span-2">

                    <label
                        for="notes"
                        class="mb-1.5 block text-sm font-semibold text-slate-700"
                    >
                        Notes
                    </label>

                    <textarea
                        id="notes"
                        name="notes"
                        rows="3"
                        placeholder="Additional notes..."
                        class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-purple-500 focus:ring-purple-500"
                    >{{ old('notes') }}</textarea>

                    @error('notes')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>


            {{-- Actions --}}
            <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('church.expenses.index') }}"
                    class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    @disabled($accounts->isEmpty())
                    class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700 disabled:cursor-not-allowed disabled:bg-slate-300"
                >
                    Record Expense
                </button>

            </div>

        </form>

    </div>

</div>

@endsection