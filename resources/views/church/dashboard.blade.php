@extends('layouts.church')

@section('title', 'Church Dashboard')

@section('page_title', 'Church Dashboard')

@section('page_description', 'Overview of your church')

@section('content')

    <div class="w-full space-y-6">

        {{-- ============================================================= --}}
        {{-- SUCCESS / ERROR MESSAGES --}}
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


        {{-- ============================================================= --}}
        {{-- WELCOME --}}
        {{-- ============================================================= --}}

        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                Welcome back, {{ $user?->name ?? 'Church User' }}
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Here's what's happening at
                <span class="font-medium text-slate-700">
                    {{ $church?->name ?? 'your church' }}
                </span>.
            </p>
        </div>


        {{-- ============================================================= --}}
        {{-- SUBSCRIPTION / TRIAL --}}
        {{-- ============================================================= --}}

        @if ($subscription)

            <div class="rounded-xl border border-green-200 bg-green-50 p-5">

                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-green-600">
                            Current Plan
                        </p>

                        <h2 class="mt-1 text-lg font-bold text-slate-900">
                            {{ $subscription->plan?->name ?? 'Subscription' }}
                        </h2>

                        <p class="mt-1 text-sm text-slate-600">
                            Your ChurchFlow subscription is currently active.
                        </p>
                    </div>

                    <div class="text-left md:text-right">

                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                            Active
                        </span>

                        <p class="mt-2 text-xs text-slate-500">
                            {{ ucfirst($subscription->billing_cycle ?? 'monthly') }} Billing
                        </p>

                        @if ($subscription->ends_at)
                            <p class="mt-1 text-sm font-semibold text-slate-900">
                                Renews {{ $subscription->ends_at->format('d M Y') }}
                            </p>
                        @endif

                    </div>

                </div>

            </div>

        @elseif ($trialSubscription)

            <div class="rounded-xl border border-purple-200 bg-purple-50 p-5">

                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-purple-600">
                            Current Plan
                        </p>

                        <h2 class="mt-1 text-lg font-bold text-slate-900">
                            Free Trial
                        </h2>

                        <p class="mt-1 text-sm text-slate-600">
                            Your ChurchFlow trial is currently active.
                        </p>
                    </div>

                    <div class="text-left md:text-right">

                        <span class="inline-flex rounded-full bg-purple-100 px-3 py-1 text-xs font-semibold text-purple-700">
                            Trial Period
                        </span>

                        @if ($trialSubscription->trial_ends_at)

                            <p class="mt-2 text-sm font-semibold text-slate-900">
                                {{ now()->diffInDays($trialSubscription->trial_ends_at) }}
                                Days Remaining
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                Ends {{ $trialSubscription->trial_ends_at->format('d M Y') }}
                            </p>

                        @else

                            <p class="mt-2 text-sm font-semibold text-slate-900">
                                {{ $trialPeriod }} Days
                            </p>

                        @endif

                    </div>

                </div>

            </div>

        @endif


        {{-- ============================================================= --}}
        {{-- CORE STATISTICS --}}
        {{-- ============================================================= --}}

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Total Members --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Total Members
                </p>

                <p class="mt-2 text-2xl font-bold text-slate-900">
                    {{ number_format($totalMembers) }}
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    Members registered
                </p>

            </div>


            {{-- Today's Check-In --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Today's Check-In
                </p>

                <p class="mt-2 text-2xl font-bold text-slate-900">
                    {{ number_format($todayCheckIns) }}
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    People checked in today
                </p>

            </div>


            {{-- Income This Month --}}
            <div class="rounded-xl border border-green-200 bg-green-50 p-5 shadow-sm">

                <p class="text-xs font-medium uppercase tracking-wide text-green-600">
                    Income This Month
                </p>

                <p class="mt-2 text-2xl font-bold text-green-700">
                    ₦{{ number_format((float) $incomeThisMonth, 2) }}
                </p>

                <p class="mt-1 text-xs text-green-600">
                    Total church income
                </p>

            </div>


            {{-- Expenses This Month --}}
            <div class="rounded-xl border border-red-200 bg-red-50 p-5 shadow-sm">

                <p class="text-xs font-medium uppercase tracking-wide text-red-600">
                    Expenses This Month
                </p>

                <p class="mt-2 text-2xl font-bold text-red-700">
                    ₦{{ number_format((float) $expensesThisMonth, 2) }}
                </p>

                <p class="mt-1 text-xs text-red-600">
                    Total church expenses
                </p>

            </div>

        </div>


        {{-- ============================================================= --}}
        {{-- FINANCIAL OVERVIEW --}}
        {{-- ============================================================= --}}

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

            {{-- Monthly Financial Summary --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-5 py-4">

                    <h2 class="text-sm font-semibold text-slate-900">
                        Monthly Financial Summary
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Current month's financial position
                    </p>

                </div>

                <div class="space-y-5 p-5">

                    <div class="flex items-center justify-between">

                        <span class="text-sm text-slate-500">
                            Income
                        </span>

                        <span class="text-sm font-semibold text-green-600">
                            ₦{{ number_format((float) $incomeThisMonth, 2) }}
                        </span>

                    </div>

                    <div class="flex items-center justify-between">

                        <span class="text-sm text-slate-500">
                            Expenses
                        </span>

                        <span class="text-sm font-semibold text-red-600">
                            ₦{{ number_format((float) $expensesThisMonth, 2) }}
                        </span>

                    </div>

                    <div class="border-t border-slate-200 pt-4">

                        <div class="flex items-center justify-between">

                            <span class="text-sm font-semibold text-slate-700">
                                Net Balance
                            </span>

                            <span class="text-lg font-bold
                                {{ $netBalanceThisMonth >= 0
                                    ? 'text-purple-700'
                                    : 'text-red-700'
                                }}"
                            >
                                ₦{{ number_format((float) $netBalanceThisMonth, 2) }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Annual Financial Summary --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-5 py-4">

                    <h2 class="text-sm font-semibold text-slate-900">
                        Annual Financial Summary
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Current year's financial position
                    </p>

                </div>

                <div class="space-y-5 p-5">

                    <div class="flex items-center justify-between">

                        <span class="text-sm text-slate-500">
                            Income
                        </span>

                        <span class="text-sm font-semibold text-green-600">
                            ₦{{ number_format((float) $incomeThisYear, 2) }}
                        </span>

                    </div>

                    <div class="flex items-center justify-between">

                        <span class="text-sm text-slate-500">
                            Expenses
                        </span>

                        <span class="text-sm font-semibold text-red-600">
                            ₦{{ number_format((float) $expensesThisYear, 2) }}
                        </span>

                    </div>

                    <div class="border-t border-slate-200 pt-4">

                        <div class="flex items-center justify-between">

                            <span class="text-sm font-semibold text-slate-700">
                                Net Balance
                            </span>

                            <span class="text-lg font-bold
                                {{ $netBalanceThisYear >= 0
                                    ? 'text-purple-700'
                                    : 'text-red-700'
                                }}"
                            >
                                ₦{{ number_format((float) $netBalanceThisYear, 2) }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Financial Actions --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-5 py-4">

                    <h2 class="text-sm font-semibold text-slate-900">
                        Financial Management
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Manage and review church finances
                    </p>

                </div>

                <div class="space-y-3 p-5">

                    <a
                        href="{{ route('church.income.create') }}"
                        class="block cursor-pointer rounded-lg border border-slate-200 p-4 transition hover:border-green-300 hover:bg-green-50"
                    >
                        <p class="text-sm font-semibold text-slate-900">
                            Record Income
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            Add church income
                        </p>
                    </a>

                    <a
                        href="{{ route('church.expenses.create') }}"
                        class="block cursor-pointer rounded-lg border border-slate-200 p-4 transition hover:border-red-300 hover:bg-red-50"
                    >
                        <p class="text-sm font-semibold text-slate-900">
                            Record Expense
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            Add a church expense
                        </p>
                    </a>

                    <a
                        href="{{ route('church.reports.index') }}"
                        class="block cursor-pointer rounded-lg bg-purple-600 px-4 py-3 text-center text-sm font-semibold text-white transition hover:bg-purple-700"
                    >
                        View Financial Reports
                    </a>

                </div>

            </div>

        </div>


        {{-- ============================================================= --}}
        {{-- QUICK ACTIONS + SUBSCRIPTION --}}
        {{-- ============================================================= --}}

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

            {{-- Quick Actions --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm xl:col-span-2">

                <div class="border-b border-slate-200 px-5 py-4">

                    <h2 class="text-sm font-semibold text-slate-900">
                        Quick Actions
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Common church management tasks
                    </p>

                </div>

                <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-2 lg:grid-cols-4">

                    <a
                        href="{{ route('church.members.create') }}"
                        class="cursor-pointer rounded-lg border border-slate-200 p-4 transition hover:border-purple-300 hover:bg-purple-50"
                    >
                        <p class="text-sm font-semibold text-slate-900">
                            Add Member
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            Register a new member
                        </p>
                    </a>


                    <a
                        href="{{ route('church.checkin.index') }}"
                        class="cursor-pointer rounded-lg border border-slate-200 p-4 transition hover:border-purple-300 hover:bg-purple-50"
                    >
                        <p class="text-sm font-semibold text-slate-900">
                            Check-In
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            Record attendance
                        </p>
                    </a>


                    <a
                        href="{{ route('church.income.create') }}"
                        class="cursor-pointer rounded-lg border border-slate-200 p-4 transition hover:border-purple-300 hover:bg-purple-50"
                    >
                        <p class="text-sm font-semibold text-slate-900">
                            Record Income
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            Add church income
                        </p>
                    </a>


                    <a
                        href="{{ route('church.expenses.create') }}"
                        class="cursor-pointer rounded-lg border border-slate-200 p-4 transition hover:border-purple-300 hover:bg-purple-50"
                    >
                        <p class="text-sm font-semibold text-slate-900">
                            Record Expense
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            Add an expense
                        </p>
                    </a>

                </div>

            </div>


            {{-- Subscription --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-5 py-4">

                    <h2 class="text-sm font-semibold text-slate-900">
                        Subscription
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Your ChurchFlow plan
                    </p>

                </div>

                <div class="space-y-4 p-5">

                    @if ($subscription)

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500">
                                Plan
                            </span>

                            <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                                {{ $subscription->plan?->name ?? 'Active Plan' }}
                            </span>
                        </div>


                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500">
                                Status
                            </span>

                            <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                                Active
                            </span>
                        </div>


                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500">
                                Billing
                            </span>

                            <span class="text-sm font-semibold text-slate-900">
                                {{ ucfirst($subscription->billing_cycle ?? 'monthly') }}
                            </span>
                        </div>


                        @if ($subscription->ends_at)
                            <div>
                                <p class="text-sm text-slate-500">
                                    Subscription ends
                                </p>

                                <p class="mt-1 text-sm font-semibold text-slate-900">
                                    {{ $subscription->ends_at->format('d M Y') }}
                                </p>
                            </div>
                        @endif


                        <a
                            href="{{ route('church.payments.index') }}"
                            class="block cursor-pointer rounded-lg bg-purple-600 px-4 py-2.5 text-center text-xs font-semibold text-white transition hover:bg-purple-700"
                        >
                            Manage Billing
                        </a>

                    @elseif ($trialSubscription)

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500">
                                Plan
                            </span>

                            <span class="rounded-full bg-purple-100 px-2.5 py-1 text-xs font-semibold text-purple-700">
                                Free Trial
                            </span>
                        </div>


                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500">
                                Status
                            </span>

                            <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                                Active
                            </span>
                        </div>


                        @if ($trialSubscription->trial_ends_at)

                            <div>
                                <p class="text-sm text-slate-500">
                                    Trial ends
                                </p>

                                <p class="mt-1 text-sm font-semibold text-slate-900">
                                    {{ $trialSubscription->trial_ends_at->format('d M Y') }}
                                </p>
                            </div>

                        @else

                            <div>
                                <p class="text-sm text-slate-500">
                                    Trial Period
                                </p>

                                <p class="mt-1 text-sm font-semibold text-slate-900">
                                    {{ $trialPeriod }} Days
                                </p>
                            </div>

                        @endif


                        <a
                            href="{{ route('church.payments.index') }}"
                            class="block cursor-pointer rounded-lg bg-purple-600 px-4 py-2.5 text-center text-xs font-semibold text-white transition hover:bg-purple-700"
                        >
                            Upgrade Plan
                        </a>

                    @else

                        <div class="py-4 text-center">

                            <p class="text-sm font-semibold text-slate-700">
                                No Active Subscription
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                Choose a plan to continue using ChurchFlow.
                            </p>

                        </div>


                        <a
                            href="{{ route('church.payments.index') }}"
                            class="block cursor-pointer rounded-lg bg-purple-600 px-4 py-2.5 text-center text-xs font-semibold text-white transition hover:bg-purple-700"
                        >
                            Choose a Plan
                        </a>

                    @endif

                </div>

            </div>

        </div>


        {{-- ============================================================= --}}
        {{-- RECENT ACTIVITY --}}
        {{-- ============================================================= --}}

        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">

                <h2 class="text-sm font-semibold text-slate-900">
                    Recent Church Activity
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Latest activity within your church
                </p>

            </div>

            <div class="flex min-h-[120px] items-center justify-center px-5">

                <p class="text-sm text-slate-400">
                    No recent activity.
                </p>

            </div>

        </div>

    </div>

@endsection