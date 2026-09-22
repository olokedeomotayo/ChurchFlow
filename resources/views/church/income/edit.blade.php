@extends('layouts.church')

@section('title', 'Edit Income')

@section('content')
<div class="mx-auto max-w-4xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Edit Income
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Update the details of this income transaction.
            </p>
        </div>

        <a
            href="{{ route('church.income.show', $income) }}"
            class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
        >
            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M10 19l-7-7m0 0l7-7m-7 7h18"
                />
            </svg>

            Back to Income Details
        </a>
    </div>

    {{-- Form Card --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 bg-slate-50 px-6 py-5">
            <h2 class="text-base font-semibold text-slate-900">
                Income Details
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Make the necessary changes and save the updated record.
            </p>
        </div>

        {{-- Update Form --}}
        <form
            method="POST"
            action="{{ route('church.income.update', $income) }}"
            class="space-y-6 p-6"
        >
            @csrf
            @method('PUT')

            {{-- Category / Source --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Category --}}
                <div>
                    <label
                        for="category"
                        class="mb-1.5 block text-sm font-medium text-slate-700"
                    >
                        Income Category <span class="text-red-500">*</span>
                    </label>

                    <select
                        id="category"
                        name="category"
                        required
                        class="w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500"
                    >
                        <option value="">Select Category</option>

                        <option value="Tithe" @selected(old('category', $income->category) === 'Tithe')>
                            Tithe
                        </option>

                        <option value="Offering" @selected(old('category', $income->category) === 'Offering')>
                            Offering
                        </option>

                        <option value="Donation" @selected(old('category', $income->category) === 'Donation')>
                            Donation
                        </option>

                        <option value="Thanksgiving" @selected(old('category', $income->category) === 'Thanksgiving')>
                            Thanksgiving
                        </option>

                        <option value="Special Offering" @selected(old('category', $income->category) === 'Special Offering')>
                            Special Offering
                        </option>

                        <option value="Pledge" @selected(old('category', $income->category) === 'Pledge')>
                            Pledge
                        </option>

                        <option value="Fundraising" @selected(old('category', $income->category) === 'Fundraising')>
                            Fundraising
                        </option>

                        <option value="Other" @selected(old('category', $income->category) === 'Other')>
                            Other
                        </option>
                    </select>

                    @error('category')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Source --}}
                <div>
                    <label
                        for="source"
                        class="mb-1.5 block text-sm font-medium text-slate-700"
                    >
                        Source
                    </label>

                    <input
                        type="text"
                        id="source"
                        name="source"
                        value="{{ old('source', $income->source) }}"
                        placeholder="e.g. Sunday Service, Building Fund"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500"
                    >

                    @error('source')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            {{-- Amount / Date --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Amount --}}
                <div>
                    <label
                        for="amount"
                        class="mb-1.5 block text-sm font-medium text-slate-700"
                    >
                        Amount <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-medium text-slate-500">
                            ₦
                        </span>

                        <input
                            type="number"
                            id="amount"
                            name="amount"
                            value="{{ old('amount', $income->amount) }}"
                            min="0.01"
                            step="0.01"
                            required
                            placeholder="0.00"
                            class="w-full rounded-lg border border-slate-300 py-2.5 pl-8 pr-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500"
                        >
                    </div>

                    @error('amount')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Income Date --}}
                <div>
                    <label
                        for="income_date"
                        class="mb-1.5 block text-sm font-medium text-slate-700"
                    >
                        Income Date <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="date"
                        id="income_date"
                        name="income_date"
                        value="{{ old('income_date', $income->income_date?->format('Y-m-d')) }}"
                        required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500"
                    >

                    @error('income_date')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            {{-- Financial Account --}}
            <div>
                <label
                    for="financial_account_id"
                    class="mb-1.5 block text-sm font-medium text-slate-700"
                >
                    Financial Account <span class="text-red-500">*</span>
                </label>

                @if($accounts->isNotEmpty())

                    <select
                        id="financial_account_id"
                        name="financial_account_id"
                        required
                        class="w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500"
                    >
                        <option value="">Select Financial Account</option>

                        @foreach($accounts as $account)
                            <option
                                value="{{ $account->id }}"
                                @selected(
                                    (string) old(
                                        'financial_account_id',
                                        $income->financial_account_id
                                    ) === (string) $account->id
                                )
                            >
                                {{ $account->name }}

                                @if($account->is_default)
                                    — Default
                                @endif

                                @if(
                                    $account->id === $income->financial_account_id &&
                                    !$account->is_active
                                )
                                    — Inactive
                                @endif
                            </option>
                        @endforeach
                    </select>

                    <p class="mt-1.5 text-xs text-slate-500">
                        Select the account where this income was received.
                    </p>

                @else

                    <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3">
                        <p class="text-sm font-medium text-amber-800">
                            No financial account is available.
                        </p>

                        <p class="mt-1 text-sm text-amber-700">
                            Please create or activate a financial account before updating this income.
                        </p>

                        <a
                            href="{{ route('church.settings.financial-accounts.create') }}"
                            class="mt-3 inline-flex cursor-pointer items-center rounded-lg bg-amber-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-amber-700"
                        >
                            Create Financial Account
                        </a>
                    </div>

                @endif

                @error('financial_account_id')
                    <p class="mt-1.5 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Payment Method / Reference --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

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
                        <option value="">Select Payment Method</option>

                        <option value="cash" @selected(old('payment_method', $income->payment_method) === 'cash')>
                            Cash
                        </option>

                        <option value="bank_transfer" @selected(old('payment_method', $income->payment_method) === 'bank_transfer')>
                            Bank Transfer
                        </option>

                        <option value="card" @selected(old('payment_method', $income->payment_method) === 'card')>
                            Card
                        </option>

                        <option value="online" @selected(old('payment_method', $income->payment_method) === 'online')>
                            Online
                        </option>

                        <option value="other" @selected(old('payment_method', $income->payment_method) === 'other')>
                            Other
                        </option>
                    </select>

                    @error('payment_method')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Reference --}}
                <div>
                    <label
                        for="reference"
                        class="mb-1.5 block text-sm font-medium text-slate-700"
                    >
                        Reference
                    </label>

                    <input
                        type="text"
                        id="reference"
                        name="reference"
                        value="{{ old('reference', $income->reference) }}"
                        placeholder="Transaction or receipt reference"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500"
                    >

                    @error('reference')
                        <p class="mt-1.5 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            {{-- Member --}}
            <div>
                <label
                    for="member_id"
                    class="mb-1.5 block text-sm font-medium text-slate-700"
                >
                    Member
                </label>

                <select
                    id="member_id"
                    name="member_id"
                    class="w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500"
                >
                    <option value="">Not linked to a member</option>

                    @foreach($members as $member)
                        <option
                            value="{{ $member->id }}"
                            @selected(
                                (string) old(
                                    'member_id',
                                    $income->member_id
                                ) === (string) $member->id
                            )
                        >
                            {{ $member->first_name }}
                            {{ $member->middle_name ? $member->middle_name . ' ' : '' }}
                            {{ $member->last_name }}

                            @if($member->member_id)
                                — {{ $member->member_id }}
                            @endif
                        </option>
                    @endforeach
                </select>

                <p class="mt-1.5 text-xs text-slate-500">
                    Optionally link this income record to a church member.
                </p>

                @error('member_id')
                    <p class="mt-1.5 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <label
                    for="description"
                    class="mb-1.5 block text-sm font-medium text-slate-700"
                >
                    Description
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="4"
                    placeholder="Add any additional details about this income..."
                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500"
                >{{ old('description', $income->description) }}</textarea>

                @error('description')
                    <p class="mt-1.5 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Form Actions --}}
            <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:items-center sm:justify-between">

                {{-- Delete --}}
                <button
                    type="button"
                    onclick="if (confirm('Are you sure you want to delete this income record?')) document.getElementById('delete-income-form').submit();"
                    class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-red-200 bg-white px-5 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50"
                >
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v-3m4 3v6m1-10V4a1 1 0 01-1-1h-4a1 1 0 01-1 1v3m-4 0h14"
                        />
                    </svg>

                    Delete Income
                </button>

                {{-- Update / Cancel --}}
                <div class="flex flex-col gap-3 sm:flex-row">

                    <a
                        href="{{ route('church.income.show', $income) }}"
                        class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        @disabled($accounts->isEmpty())
                        class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>

                        Update Income
                    </button>

                </div>
            </div>
        </form>

        {{-- Separate Delete Form --}}
        <form
            id="delete-income-form"
            method="POST"
            action="{{ route('church.income.destroy', $income) }}"
            class="hidden"
        >
            @csrf
            @method('DELETE')
        </form>

    </div>

</div>
@endsection