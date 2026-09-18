@extends('layouts.admin')

@section('title', 'Subscriptions')

@section('page_title', 'Subscriptions')

@section('page_description', 'Monitor church subscriptions, trial periods, plans and account status.')

@section('content')

    <div class="w-full space-y-6">


        {{-- ========================================================= --}}
        {{-- Success Message --}}
        {{-- ========================================================= --}}

        @if (session('success'))

            <div class="rounded-xl border border-green-200 bg-green-50 px-5 py-4">

                <div class="flex items-center gap-3">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-green-100 text-sm font-bold text-green-700">
                        ✓
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-green-800">
                            {{ session('success') }}
                        </p>
                    </div>

                </div>

            </div>

        @endif


        {{-- ========================================================= --}}
        {{-- Error Message --}}
        {{-- ========================================================= --}}

        @if (session('error'))

            <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4">

                <div class="flex items-center gap-3">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-red-100 text-sm font-bold text-red-700">
                        !
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-red-800">
                            {{ session('error') }}
                        </p>
                    </div>

                </div>

            </div>

        @endif


        {{-- ========================================================= --}}
        {{-- Summary Cards --}}
        {{-- ========================================================= --}}

        @php

            $trialCount = $subscriptions
                ->where('status', 'trial')
                ->count();

            $activeCount = $subscriptions
                ->where('status', 'active')
                ->count();

            $expiredCount = $subscriptions
                ->where('status', 'expired')
                ->count();

            $cancelledCount = $subscriptions
                ->where('status', 'cancelled')
                ->count();

            $totalCount = $subscriptions->count();

        @endphp


        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">


            {{-- ===================================================== --}}
            {{-- Trial --}}
            {{-- ===================================================== --}}

            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                            Trial
                        </p>

                        <p class="mt-2 text-3xl font-bold text-slate-900">
                            {{ number_format($trialCount) }}
                        </p>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-amber-50 text-lg text-amber-600">
                        ◷
                    </div>

                </div>

                <p class="mt-4 text-xs text-slate-500">
                    Churches currently in trial
                </p>

            </div>


            {{-- ===================================================== --}}
            {{-- Active --}}
            {{-- ===================================================== --}}

            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                            Active
                        </p>

                        <p class="mt-2 text-3xl font-bold text-slate-900">
                            {{ number_format($activeCount) }}
                        </p>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-green-50 text-lg text-green-600">
                        ✓
                    </div>

                </div>

                <p class="mt-4 text-xs text-slate-500">
                    Currently active subscriptions
                </p>

            </div>


            {{-- ===================================================== --}}
            {{-- Expired --}}
            {{-- ===================================================== --}}

            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                            Expired
                        </p>

                        <p class="mt-2 text-3xl font-bold text-slate-900">
                            {{ number_format($expiredCount) }}
                        </p>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-red-50 text-lg text-red-600">
                        !
                    </div>

                </div>

                <p class="mt-4 text-xs text-slate-500">
                    Subscriptions past their end date
                </p>

            </div>


            {{-- ===================================================== --}}
            {{-- Cancelled --}}
            {{-- ===================================================== --}}

            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                            Cancelled
                        </p>

                        <p class="mt-2 text-3xl font-bold text-slate-900">
                            {{ number_format($cancelledCount) }}
                        </p>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-slate-100 text-lg text-slate-500">
                        ×
                    </div>

                </div>

                <p class="mt-4 text-xs text-slate-500">
                    Cancelled subscriptions
                </p>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- Subscription List --}}
        {{-- ========================================================= --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">


            {{-- ===================================================== --}}
            {{-- Header --}}
            {{-- ===================================================== --}}

            <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <h2 class="text-base font-bold text-slate-900">
                        All Subscriptions
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        {{ number_format($totalCount) }}
                        {{ \Illuminate\Support\Str::plural('subscription', $totalCount) }}
                        currently recorded.
                    </p>

                </div>


                <div class="rounded-lg bg-slate-50 px-3 py-2">

                    <p class="text-xs font-semibold text-slate-500">
                        Total
                    </p>

                    <p class="text-sm font-bold text-slate-900">
                        {{ number_format($totalCount) }}
                    </p>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- Table --}}
            {{-- ===================================================== --}}

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-slate-200">


                    {{-- ================================================= --}}
                    {{-- Table Head --}}
                    {{-- ================================================= --}}

                    <thead class="bg-slate-50">

                        <tr>

                            <th
                                scope="col"
                                class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500"
                            >
                                Church
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500"
                            >
                                Plan
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500"
                            >
                                Status
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500"
                            >
                                Started
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500"
                            >
                                Trial Ends
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500"
                            >
                                Ends
                            </th>

                            <th
                                scope="col"
                                class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wide text-slate-500"
                            >
                                Action
                            </th>

                        </tr>

                    </thead>


                    {{-- ================================================= --}}
                    {{-- Table Body --}}
                    {{-- ================================================= --}}

                    <tbody class="divide-y divide-slate-100">

                        @forelse ($subscriptions as $subscription)

                            <tr class="transition hover:bg-slate-50">


                                {{-- ===================================== --}}
                                {{-- Church --}}
                                {{-- ===================================== --}}

                                <td class="whitespace-nowrap px-6 py-5">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-purple-50 text-sm font-bold text-purple-700">

                                            {{ strtoupper(substr($subscription->church?->name ?? 'C', 0, 1)) }}

                                        </div>

                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-semibold text-slate-900">
                                                {{ $subscription->church?->name ?? 'Unknown Church' }}
                                            </p>

                                            <p class="mt-1 text-xs text-slate-500">
                                                {{ $subscription->church?->code ?? '—' }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- ===================================== --}}
                                {{-- Plan --}}
                                {{-- ===================================== --}}

                                <td class="whitespace-nowrap px-6 py-5">

                                    @if ($subscription->plan)

                                        <p class="text-sm font-semibold text-slate-800">
                                            {{ $subscription->plan->name }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-500">

                                            ₦{{ number_format((float) $subscription->plan->price, 2) }}

                                            <span class="mx-1">
                                                /
                                            </span>

                                            {{ ucfirst($subscription->plan->billing_cycle) }}

                                        </p>

                                    @else

                                        <span class="text-sm text-slate-400">
                                            No Plan
                                        </span>

                                    @endif

                                </td>


                                {{-- ===================================== --}}
                                {{-- Status --}}
                                {{-- ===================================== --}}

                                <td class="whitespace-nowrap px-6 py-5">

                                    @switch($subscription->status)

                                        @case('trial')

                                            <span class="inline-flex items-center gap-2 rounded-full bg-amber-50 px-3 py-1.5 text-xs font-bold text-amber-700">

                                                <span class="h-2 w-2 rounded-full bg-amber-500"></span>

                                                Trial

                                            </span>

                                            @break


                                        @case('active')

                                            <span class="inline-flex items-center gap-2 rounded-full bg-green-50 px-3 py-1.5 text-xs font-bold text-green-700">

                                                <span class="h-2 w-2 rounded-full bg-green-500"></span>

                                                Active

                                            </span>

                                            @break


                                        @case('expired')

                                            <span class="inline-flex items-center gap-2 rounded-full bg-red-50 px-3 py-1.5 text-xs font-bold text-red-700">

                                                <span class="h-2 w-2 rounded-full bg-red-500"></span>

                                                Expired

                                            </span>

                                            @break


                                        @case('cancelled')

                                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-600">

                                                <span class="h-2 w-2 rounded-full bg-slate-400"></span>

                                                Cancelled

                                            </span>

                                            @break


                                        @default

                                            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-600">

                                                {{ ucfirst($subscription->status ?? 'Unknown') }}

                                            </span>

                                    @endswitch

                                </td>


                                {{-- ===================================== --}}
                                {{-- Started --}}
                                {{-- ===================================== --}}

                                <td class="whitespace-nowrap px-6 py-5">

                                    <span class="text-sm text-slate-700">

                                        @if ($subscription->starts_at)

                                            {{ \Illuminate\Support\Carbon::parse($subscription->starts_at)->format('d M Y') }}

                                        @else

                                            —

                                        @endif

                                    </span>

                                </td>


                                {{-- ===================================== --}}
                                {{-- Trial Ends --}}
                                {{-- ===================================== --}}

                                <td class="whitespace-nowrap px-6 py-5">

                                    <span class="text-sm text-slate-700">

                                        @if ($subscription->trial_ends_at)

                                            {{ \Illuminate\Support\Carbon::parse($subscription->trial_ends_at)->format('d M Y') }}

                                        @else

                                            —

                                        @endif

                                    </span>

                                </td>


                                {{-- ===================================== --}}
                                {{-- Ends --}}
                                {{-- ===================================== --}}

                                <td class="whitespace-nowrap px-6 py-5">

                                    <span class="text-sm text-slate-700">

                                        @if ($subscription->ends_at)

                                            {{ \Illuminate\Support\Carbon::parse($subscription->ends_at)->format('d M Y') }}

                                        @else

                                            —

                                        @endif

                                    </span>

                                </td>


                                {{-- ===================================== --}}
                                {{-- Action --}}
                                {{-- ===================================== --}}

                                <td class="whitespace-nowrap px-6 py-5 text-right">

                                    <a
                                        href="{{ route('admin.subscriptions.show', $subscription) }}"
                                        class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-purple-300 hover:bg-purple-50 hover:text-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                                    >
                                        View
                                    </a>

                                </td>

                            </tr>

                        @empty

                            {{-- ========================================= --}}
                            {{-- Empty State --}}
                            {{-- ========================================= --}}

                            <tr>

                                <td
                                    colspan="7"
                                    class="px-6 py-16 text-center"
                                >

                                    <div class="mx-auto max-w-md">

                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100">

                                            <span class="text-xl font-bold text-slate-400">
                                                $
                                            </span>

                                        </div>

                                        <h3 class="mt-4 text-sm font-bold text-slate-900">
                                            No subscriptions found
                                        </h3>

                                        <p class="mt-2 text-sm leading-6 text-slate-500">
                                            Church subscriptions will appear here once they are created.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- Footer --}}
        {{-- ========================================================= --}}

        <div class="flex items-center justify-between">

            <p class="text-xs text-slate-500">
                ChurchFlow Subscription Management
            </p>

            <p class="text-xs text-slate-400">
                {{ number_format($totalCount) }}
                {{ \Illuminate\Support\Str::plural('subscription', $totalCount) }}
            </p>

        </div>

    </div>

@endsection