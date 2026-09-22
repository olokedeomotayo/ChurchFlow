@extends('layouts.church')

@section('title', 'Financial Settings')

@section('page_title', 'Financial Settings')

@section('page_description', 'Manage your church financial accounts and starting balances.')

@section('content')
<div class="space-y-6">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            {{ session('error') }}
        </div>
    @endif

    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-xl font-semibold text-slate-900">
                Financial Accounts
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Manage the bank accounts, cash, POS and other financial accounts used by
                {{ $church->name }}.
            </p>
        </div>

        <a
            href="{{ route('church.settings.financial-accounts.create') }}"
            class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700"
        >
            + Add Financial Account
        </a>
    </div>

    {{-- Financial Summary --}}
    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

        {{-- Total Balance --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Current Balance
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        ₦{{ number_format((float) $totalBalance, 2) }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-purple-100 text-purple-600">
                    ₦
                </div>
            </div>
        </div>

        {{-- Number of Accounts --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Financial Accounts
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        {{ $accounts->count() }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                    #
                </div>
            </div>
        </div>

        {{-- Active Accounts --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Active Accounts
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        {{ $accounts->where('is_active', true)->count() }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-green-100 text-green-600">
                    ✓
                </div>
            </div>
        </div>

    </div>

    {{-- Accounts --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">
            <h3 class="text-base font-semibold text-slate-900">
                Your Financial Accounts
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                Each account has its own opening balance and current balance.
                Income and expenses can be assigned to the appropriate account.
            </p>
        </div>

        @if($accounts->isEmpty())

            <div class="px-6 py-12 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-purple-100 text-purple-600">
                    ₦
                </div>

                <h3 class="mt-4 text-base font-semibold text-slate-900">
                    No financial accounts yet
                </h3>

                <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
                    Create your first financial account to start tracking balances
                    separately for your church.
                </p>

                <a
                    href="{{ route('church.settings.financial-accounts.create') }}"
                    class="mt-5 inline-flex cursor-pointer items-center rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-purple-700"
                >
                    + Create First Account
                </a>
            </div>

        @else

            <div class="divide-y divide-slate-100">

                @foreach($accounts as $account)

                    <div class="p-6">

                        <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">

                            {{-- Account Information --}}
                            <div class="min-w-0 flex-1">

                                <div class="flex flex-wrap items-center gap-2">

                                    <h4 class="text-base font-semibold text-slate-900">
                                        {{ $account->name }}
                                    </h4>

                                    @if($account->is_default)
                                        <span class="rounded-full bg-purple-100 px-2.5 py-1 text-xs font-semibold text-purple-700">
                                            Default
                                        </span>
                                    @endif

                                    @if($account->is_active)
                                        <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                                            Active
                                        </span>
                                    @else
                                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                            Inactive
                                        </span>
                                    @endif

                                </div>

                                <p class="mt-1 text-sm capitalize text-slate-500">
                                    {{ str_replace('_', ' ', $account->type) }}
                                    @if($account->provider_name)
                                        · {{ $account->provider_name }}
                                    @endif
                                </p>

                                @if($account->account_number)
                                    <p class="mt-1 text-sm text-slate-500">
                                        Account:
                                        <span class="font-medium text-slate-700">
                                            {{ $account->account_number }}
                                        </span>
                                    </p>
                                @endif

                            </div>

                            {{-- Balance --}}
                            <div class="lg:min-w-[220px] lg:text-right">

                                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                    Current Balance
                                </p>

                                <p class="mt-1 text-2xl font-bold text-slate-900">
                                    {{ $account->currency }}
                                    {{ number_format((float) $account->current_balance, 2) }}
                                </p>

                                <p class="mt-1 text-xs text-slate-500">
                                    Opening:
                                    {{ $account->currency }}
                                    {{ number_format((float) $account->opening_balance, 2) }}
                                </p>

                                @if($account->opening_balance_date)
                                    <p class="text-xs text-slate-500">
                                        From
                                        {{ $account->opening_balance_date->format('d M Y') }}
                                    </p>
                                @endif

                            </div>

                        </div>

                        {{-- Actions --}}
                        <div class="mt-5 flex flex-wrap items-center gap-2 border-t border-slate-100 pt-4">

                            <a
                                href="{{ route('church.settings.financial-accounts.edit', $account) }}"
                                class="inline-flex cursor-pointer items-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
                            >
                                Edit
                            </a>

                            @if(!$account->is_default && $account->is_active)
                                <form
                                    method="POST"
                                    action="{{ route('church.settings.financial-accounts.default', $account) }}"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="cursor-pointer rounded-lg border border-purple-200 bg-purple-50 px-3 py-2 text-sm font-medium text-purple-700 hover:bg-purple-100"
                                    >
                                        Set as Default
                                    </button>
                                </form>
                            @endif

                            @if($account->is_active)

                                @if(!$account->is_default)
                                    <form
                                        method="POST"
                                        action="{{ route('church.settings.financial-accounts.deactivate', $account) }}"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="cursor-pointer rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-sm font-medium text-amber-700 hover:bg-amber-100"
                                        >
                                            Deactivate
                                        </button>
                                    </form>
                                @endif

                            @else

                                <form
                                    method="POST"
                                    action="{{ route('church.settings.financial-accounts.activate', $account) }}"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="cursor-pointer rounded-lg border border-green-200 bg-green-50 px-3 py-2 text-sm font-medium text-green-700 hover:bg-green-100"
                                    >
                                        Activate
                                    </button>
                                </form>

                            @endif

                            @if(!$account->is_default)

                                <form
                                    method="POST"
                                    action="{{ route('church.settings.financial-accounts.destroy', $account) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this financial account?');"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="cursor-pointer rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm font-medium text-red-700 hover:bg-red-100"
                                    >
                                        Delete
                                    </button>
                                </form>

                            @endif

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

    {{-- Balance Explanation --}}
    <div class="rounded-xl border border-purple-200 bg-purple-50 p-5">

        <h3 class="text-sm font-semibold text-purple-900">
            How ChurchFlow calculates account balances
        </h3>

        <div class="mt-3 space-y-1 text-sm text-purple-800">
            <p>Opening Balance</p>
            <p>+ Income recorded on or after the account opening date</p>
            <p>− Expenses recorded on or after the account opening date</p>
            <p class="font-semibold">= Current Account Balance</p>
        </div>

        <p class="mt-4 text-xs leading-5 text-purple-700">
            Each financial account is calculated independently.
            The total balance shown above is the combined balance of the church's accounts.
        </p>

    </div>

</div>
@endsection