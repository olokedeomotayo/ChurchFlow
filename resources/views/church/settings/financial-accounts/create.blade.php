@extends('layouts.church')

@section('title', 'Add Financial Account')

@section('page_title', 'Add Financial Account')

@section('page_description', 'Add a bank, cash, POS or other financial account')

@section('content')

<div class="w-full space-y-6">

    {{-- HEADER --}}
    <div>
        <a href="{{ route('church.settings.financial-accounts.index') }}"
           class="inline-flex cursor-pointer items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-purple-600">
            <span>←</span>
            <span>Back to Financial Accounts</span>
        </a>

        <h1 class="mt-4 text-xl font-bold text-slate-900">
            Add Financial Account
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Add an account that your church uses to receive income or pay expenses.
        </p>
    </div>


    {{-- VALIDATION ERRORS --}}
    @if ($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">

            <p class="font-semibold">
                Please correct the following:
            </p>

            <ul class="mt-2 list-disc space-y-1 pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif


    {{-- FORM --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

        <form method="POST"
              action="{{ route('church.settings.financial-accounts.store') }}"
              class="space-y-6 p-6">

            @csrf


            {{-- ACCOUNT NAME --}}
            <div>
                <label for="name"
                       class="mb-2 block text-sm font-medium text-slate-700">
                    Account Name
                </label>

                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    required
                    maxlength="255"
                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                    placeholder="e.g. Main Church Account"
                >

                <p class="mt-1.5 text-xs text-slate-500">
                    Give the account a clear name that your church will recognize.
                </p>
            </div>


            {{-- ACCOUNT TYPE --}}
            <div>
                <label for="type"
                       class="mb-2 block text-sm font-medium text-slate-700">
                    Account Type
                </label>

                <select
                    name="type"
                    id="type"
                    required
                    class="w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                >
                    <option value="">Select account type</option>

                    <option value="bank" @selected(old('type') === 'bank')>
                        Bank Account
                    </option>

                    <option value="cash" @selected(old('type') === 'cash')>
                        Cash Account
                    </option>

                    <option value="mobile_money" @selected(old('type') === 'mobile_money')>
                        Mobile Money
                    </option>

                    <option value="pos" @selected(old('type') === 'pos')>
                        POS Account
                    </option>

                    <option value="other" @selected(old('type') === 'other')>
                        Other
                    </option>
                </select>
            </div>


            {{-- PROVIDER + ACCOUNT NUMBER --}}
            <div class="grid gap-6 md:grid-cols-2">

                <div>
                    <label for="provider_name"
                           class="mb-2 block text-sm font-medium text-slate-700">
                        Bank / Provider
                    </label>

                    <input
                        type="text"
                        name="provider_name"
                        id="provider_name"
                        value="{{ old('provider_name') }}"
                        maxlength="255"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                        placeholder="e.g. GTBank"
                    >

                    <p class="mt-1.5 text-xs text-slate-500">
                        Optional.
                    </p>
                </div>


                <div>
                    <label for="account_number"
                           class="mb-2 block text-sm font-medium text-slate-700">
                        Account Number
                    </label>

                    <input
                        type="text"
                        name="account_number"
                        id="account_number"
                        value="{{ old('account_number') }}"
                        maxlength="100"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                        placeholder="e.g. 0123456789"
                    >

                    <p class="mt-1.5 text-xs text-slate-500">
                        Optional.
                    </p>
                </div>

            </div>


            {{-- OPENING BALANCE --}}
            <div>

                <label for="opening_balance"
                       class="mb-2 block text-sm font-medium text-slate-700">
                    Opening Balance
                </label>

                <div class="flex w-full">

                    <span class="flex items-center rounded-l-lg border border-r-0 border-slate-300 bg-slate-50 px-4 text-sm font-semibold text-slate-600">
                        ₦
                    </span>

                    <input
                        type="number"
                        name="opening_balance"
                        id="opening_balance"
                        value="{{ old('opening_balance', '0.00') }}"
                        min="0"
                        step="0.01"
                        required
                        class="w-full rounded-r-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                        placeholder="0.00"
                    >

                </div>

                <p class="mt-1.5 text-xs text-slate-500">
                    The amount available in this account at the beginning of the opening date.
                </p>

            </div>


            {{-- OPENING BALANCE DATE --}}
            <div>

                <label for="opening_balance_date"
                       class="mb-2 block text-sm font-medium text-slate-700">
                    Opening Balance Date
                </label>

                <input
                    type="date"
                    name="opening_balance_date"
                    id="opening_balance_date"
                    value="{{ old('opening_balance_date', now()->toDateString()) }}"
                    required
                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                >

                <p class="mt-1.5 text-xs text-slate-500">
                    Income and expenses dated on or after this date affect the account's current balance.
                </p>

            </div>


            {{-- CURRENCY --}}
            <div>

                <label for="currency"
                       class="mb-2 block text-sm font-medium text-slate-700">
                    Currency
                </label>

                <input
                    type="text"
                    name="currency"
                    id="currency"
                    value="{{ old('currency', 'NGN') }}"
                    maxlength="3"
                    required
                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm uppercase text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                    placeholder="NGN"
                >

                <p class="mt-1.5 text-xs text-slate-500">
                    Use the three-letter currency code, such as NGN.
                </p>

            </div>


            {{-- DEFAULT ACCOUNT --}}
            <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">

                <label class="flex cursor-pointer items-start gap-3">

                    <input
                        type="checkbox"
                        name="is_default"
                        value="1"
                        @checked(old('is_default'))
                        class="mt-1 h-4 w-4 cursor-pointer rounded border-slate-300 text-purple-600 focus:ring-purple-500"
                    >

                    <span>
                        <span class="block text-sm font-semibold text-slate-800">
                            Set as default account
                        </span>

                        <span class="mt-1 block text-xs leading-5 text-slate-500">
                            New financial transactions can use this account as the default.
                            The first account created for the church is automatically made default.
                        </span>
                    </span>

                </label>

            </div>


            {{-- ACTIVE ACCOUNT --}}
            <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">

                <label class="flex cursor-pointer items-start gap-3">

                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        @checked(old('is_active', true))
                        class="mt-1 h-4 w-4 cursor-pointer rounded border-slate-300 text-purple-600 focus:ring-purple-500"
                    >

                    <span>
                        <span class="block text-sm font-semibold text-slate-800">
                            Account is active
                        </span>

                        <span class="mt-1 block text-xs leading-5 text-slate-500">
                            Active accounts can be selected when recording income and expenses.
                        </span>
                    </span>

                </label>

            </div>


            {{-- NOTES --}}
            <div>

                <label for="notes"
                       class="mb-2 block text-sm font-medium text-slate-700">
                    Notes
                </label>

                <textarea
                    name="notes"
                    id="notes"
                    rows="4"
                    class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                    placeholder="Optional notes about this account..."
                >{{ old('notes') }}</textarea>

            </div>


            {{-- INFORMATION --}}
            <div class="rounded-lg border border-purple-200 bg-purple-50 p-4">

                <p class="text-sm font-semibold text-purple-900">
                    Account Balance Calculation
                </p>

                <p class="mt-2 text-sm leading-6 text-purple-800">
                    Opening Balance + Income on or after the opening date
                    − Expenses on or after the opening date
                    = Current Balance
                </p>

            </div>


            {{-- ACTIONS --}}
            <div class="flex flex-col gap-3 border-t border-slate-200 pt-5 sm:flex-row sm:justify-end">

                <a href="{{ route('church.settings.financial-accounts.index') }}"
                   class="cursor-pointer rounded-lg border border-slate-300 px-5 py-2.5 text-center text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                    Cancel
                </a>

                <button
                    type="submit"
                    class="cursor-pointer rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700"
                >
                    Create Account
                </button>

            </div>

        </form>

    </div>

</div>

@endsection