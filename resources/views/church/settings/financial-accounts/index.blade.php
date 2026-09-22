@extends('layouts.church')

@section('title', 'Financial Accounts')

@section('page_title', 'Financial Accounts')

@section('page_description', 'Manage your church bank, cash and other financial accounts')

@section('content')

<div class="w-full space-y-6">

    {{-- ============================================================= --}}
    {{-- FLASH MESSAGES --}}
    {{-- ============================================================= --}}

    @if (session('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

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


    {{-- ============================================================= --}}
    {{-- HEADER --}}
    {{-- ============================================================= --}}

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <a href="{{ route('church.settings.financial.edit') }}"
               class="inline-flex cursor-pointer items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-purple-600">
                <span>←</span>
                <span>Financial Settings</span>
            </a>

            <h1 class="mt-3 text-xl font-bold text-slate-900">
                Financial Accounts
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Manage the accounts used to receive income and pay expenses.
            </p>
        </div>

        @can('financial-settings.update')
            <a href="{{ route('church.settings.financial-accounts.create') }}"
               class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700">
                + Add Account
            </a>
        @endcan

    </div>


    {{-- ============================================================= --}}
    {{-- TOTAL BALANCE --}}
    {{-- ============================================================= --}}

    <div class="rounded-xl border border-purple-200 bg-purple-50 p-6">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <p class="text-sm font-medium text-purple-700">
                    Total Current Balance
                </p>

                <p class="mt-2 text-3xl font-bold tracking-tight text-purple-900">
                    ₦{{ number_format((float) $totalBalance, 2) }}
                </p>

                <p class="mt-1 text-xs text-purple-700">
                    Combined balance across all financial accounts.
                </p>
            </div>

            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-white text-purple-600 shadow-sm">

                <svg class="h-7 w-7"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2
                             3 .895 3 2-1.343 2-3 2m0-10V6m0 12v-2
                             m9-4a9 9 0 11-18 0 9 9 0 0118 0z"/>

                </svg>

            </div>

        </div>

    </div>


    {{-- ============================================================= --}}
    {{-- ACCOUNTS --}}
    {{-- ============================================================= --}}

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">

            <h2 class="text-base font-semibold text-slate-900">
                Your Financial Accounts
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Each account has its own opening balance and current balance.
            </p>

        </div>


        @if ($accounts->isEmpty())

            <div class="px-6 py-12 text-center">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-500">

                    <svg class="h-7 w-7"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M3 10h18M5 6h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z"/>

                    </svg>

                </div>

                <h3 class="mt-4 text-sm font-semibold text-slate-900">
                    No financial accounts yet
                </h3>

                <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                    Add your church's first bank, cash, POS or other financial account
                    to start tracking balances separately.
                </p>

                @can('financial-settings.update')
                    <a href="{{ route('church.settings.financial-accounts.create') }}"
                       class="mt-5 inline-flex cursor-pointer items-center justify-center rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700">
                        Add Your First Account
                    </a>
                @endcan

            </div>

        @else

            <div class="divide-y divide-slate-200">

                @foreach ($accounts as $account)

                    <div class="p-6 transition hover:bg-slate-50">

                        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                            {{-- ACCOUNT INFORMATION --}}
                            <div class="flex min-w-0 items-start gap-4">

                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-purple-50 text-purple-600">

                                    @if ($account->type === 'bank')

                                        <svg class="h-6 w-6"
                                             fill="none"
                                             stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M3 10l9-7 9 7M5 10h14M6 10v8m4-8v8m4-8v8m4-8v8M3 20h18"/>
                                        </svg>

                                    @elseif ($account->type === 'cash')

                                        <svg class="h-6 w-6"
                                             fill="none"
                                             stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M3 7h18v10H3V7zm3 3h.01M18 13h.01M12 10a2 2 0 100 4 2 2 0 000-4z"/>
                                        </svg>

                                    @else

                                        <svg class="h-6 w-6"
                                             fill="none"
                                             stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M4 7h16M4 12h16M4 17h16"/>
                                        </svg>

                                    @endif

                                </div>


                                <div class="min-w-0">

                                    <div class="flex flex-wrap items-center gap-2">

                                        <h3 class="truncate text-base font-semibold text-slate-900">
                                            {{ $account->name }}
                                        </h3>

                                        @if ($account->is_default)
                                            <span class="rounded-full bg-purple-50 px-2.5 py-1 text-xs font-semibold text-purple-700">
                                                Default
                                            </span>
                                        @endif

                                        @if ($account->is_active)
                                            <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                                Active
                                            </span>
                                        @else
                                            <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">
                                                Inactive
                                            </span>
                                        @endif

                                    </div>

                                    <div class="mt-1 flex flex-wrap gap-x-3 gap-y-1 text-xs text-slate-500">

                                        <span class="capitalize">
                                            {{ str_replace('_', ' ', $account->type) }}
                                        </span>

                                        @if ($account->provider_name)
                                            <span>
                                                {{ $account->provider_name }}
                                            </span>
                                        @endif

                                        @if ($account->account_number)
                                            <span>
                                                {{ $account->account_number }}
                                            </span>
                                        @endif

                                    </div>

                                    <p class="mt-2 text-xs text-slate-500">
                                        Opening balance:
                                        <span class="font-medium text-slate-700">
                                            {{ $account->currency }}
                                            {{ number_format((float) $account->opening_balance, 2) }}
                                        </span>

                                        @if ($account->opening_balance_date)
                                            <span class="mx-1">•</span>
                                            {{ $account->opening_balance_date->format('d M Y') }}
                                        @endif
                                    </p>

                                </div>

                            </div>


                            {{-- BALANCE --}}
                            <div class="lg:text-right">

                                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                                    Current Balance
                                </p>

                                <p class="mt-1 text-xl font-bold text-slate-900">
                                    {{ $account->currency }}
                                    {{ number_format((float) $account->current_balance, 2) }}
                                </p>

                            </div>


                            {{-- ACTIONS --}}
                            <div class="flex flex-wrap items-center gap-2">

                                @can('financial-settings.update')

                                    <a href="{{ route('church.settings.financial-accounts.edit', $account) }}"
                                       class="cursor-pointer rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                                        Edit
                                    </a>

                                    @if ($account->is_active && ! $account->is_default)

                                        <form method="POST"
                                              action="{{ route('church.settings.financial-accounts.default', $account) }}">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="cursor-pointer rounded-lg border border-purple-200 bg-purple-50 px-3 py-2 text-sm font-medium text-purple-700 transition hover:bg-purple-100">
                                                Set Default
                                            </button>

                                        </form>

                                    @endif

                                    @if ($account->is_active)

                                        @if (! $account->is_default)

                                            <form method="POST"
                                                  action="{{ route('church.settings.financial-accounts.deactivate', $account) }}">

                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                        onclick="return confirm('Are you sure you want to deactivate this account?')"
                                                        class="cursor-pointer rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                                                    Deactivate
                                                </button>

                                            </form>

                                        @endif

                                    @else

                                        <form method="POST"
                                              action="{{ route('church.settings.financial-accounts.activate', $account) }}">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="cursor-pointer rounded-lg border border-green-200 bg-green-50 px-3 py-2 text-sm font-medium text-green-700 transition hover:bg-green-100">
                                                Activate
                                            </button>

                                        </form>

                                    @endif

                                    @if (! $account->is_default)

                                        <form method="POST"
                                              action="{{ route('church.settings.financial-accounts.destroy', $account) }}">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this financial account? This cannot be undone.')"
                                                    class="cursor-pointer rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-100">
                                                Delete
                                            </button>

                                        </form>

                                    @endif

                                @endcan

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>


    {{-- ============================================================= --}}
    {{-- ACCOUNTING INFORMATION --}}
    {{-- ============================================================= --}}

    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-base font-semibold text-slate-900">
            How Account Balances Work
        </h2>

        <div class="mt-4 grid gap-4 md:grid-cols-3">

            <div class="rounded-lg bg-slate-50 p-4">

                <p class="text-sm font-semibold text-slate-800">
                    Opening Balance
                </p>

                <p class="mt-1 text-sm leading-6 text-slate-500">
                    The amount available in the account at the beginning of its opening date.
                </p>

            </div>

            <div class="rounded-lg bg-slate-50 p-4">

                <p class="text-sm font-semibold text-slate-800">
                    Income
                </p>

                <p class="mt-1 text-sm leading-6 text-slate-500">
                    Income assigned to the account increases its current balance.
                </p>

            </div>

            <div class="rounded-lg bg-slate-50 p-4">

                <p class="text-sm font-semibold text-slate-800">
                    Expenses
                </p>

                <p class="mt-1 text-sm leading-6 text-slate-500">
                    Expenses assigned to the account reduce its current balance.
                </p>

            </div>

        </div>

        <div class="mt-5 rounded-lg border border-purple-200 bg-purple-50 p-4">

            <p class="text-sm font-semibold text-purple-900">
                Current Balance
            </p>

            <p class="mt-2 text-sm leading-6 text-purple-800">
                Opening Balance + Income on or after the opening date
                − Expenses on or after the opening date
                = Current Balance
            </p>

        </div>

    </div>

</div>

@endsection