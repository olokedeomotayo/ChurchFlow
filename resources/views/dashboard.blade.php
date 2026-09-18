@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page_title', 'Dashboard')

@section('page_description', 'Platform overview and activity')

@section('content')

    <div class="w-full space-y-6">


        {{-- ========================================================= --}}
        {{-- Welcome --}}
        {{-- ========================================================= --}}

        <div>

            <h1 class="text-2xl font-bold text-slate-900">
                Welcome back, {{ auth()->user()->name }}
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Here's what's happening across your ChurchFlow platform.
            </p>

        </div>


        {{-- ========================================================= --}}
        {{-- Platform Statistics --}}
        {{-- ========================================================= --}}

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">


            {{-- Total Churches --}}

            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Total Churches
                        </p>

                        <p class="mt-2 text-3xl font-bold text-slate-900">
                            {{ number_format($totalChurches) }}
                        </p>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-purple-100 text-xl text-purple-600">
                        ♜
                    </div>

                </div>

                <p class="mt-4 text-xs text-slate-500">
                    Registered on ChurchFlow
                </p>

            </div>


            {{-- Trial Churches --}}

            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Trial Churches
                        </p>

                        <p class="mt-2 text-3xl font-bold text-slate-900">
                            {{ number_format($trialChurches) }}
                        </p>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-amber-100 text-xl text-amber-600">
                        ◷
                    </div>

                </div>

                <p class="mt-4 text-xs text-slate-500">
                    Currently in trial period
                </p>

            </div>


            {{-- Active Subscriptions --}}

            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Active Subscriptions
                        </p>

                        <p class="mt-2 text-3xl font-bold text-slate-900">
                            {{ number_format($activeSubscriptions) }}
                        </p>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-green-100 text-xl text-green-600">
                        ✓
                    </div>

                </div>

                <p class="mt-4 text-xs text-slate-500">
                    Currently active plans
                </p>

            </div>


            {{-- Monthly Revenue --}}

            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Monthly Revenue
                        </p>

                        <p class="mt-2 text-3xl font-bold text-slate-900">
                            ₦{{ number_format($monthlyRevenue ?? 0, 2) }}
                        </p>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-blue-100 text-xl text-blue-600">
                        ₦
                    </div>

                </div>

                <p class="mt-4 text-xs text-slate-500">
                    Current subscription value
                </p>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- Main Dashboard --}}
        {{-- ========================================================= --}}

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">


            {{-- ===================================================== --}}
            {{-- Recent Church Onboarding --}}
            {{-- ===================================================== --}}

            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm xl:col-span-2">

                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">

                    <div>

                        <h2 class="font-semibold text-slate-900">
                            Recent Church Onboarding
                        </h2>

                        <p class="mt-1 text-xs text-slate-500">
                            Newly registered churches
                        </p>

                    </div>

                    <a
                        href="{{ route('admin.churches.index') }}"
                        class="cursor-pointer text-sm font-semibold text-purple-600 transition hover:text-purple-700"
                    >
                        View All
                    </a>

                </div>


                <div class="overflow-x-auto">

                    <table class="min-w-full">

                        <thead class="bg-slate-50">

                            <tr>

                                <th class="px-6 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                    Church
                                </th>

                                <th class="px-6 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                    Plan
                                </th>

                                <th class="px-6 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                    Status
                                </th>

                                <th class="px-6 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                    Joined
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-100">

                            @forelse ($recentChurches as $church)

                                @php
                                    $subscription = $church->subscriptions
                                        ->sortByDesc('created_at')
                                        ->first();

                                    $statusClasses = match ($church->status) {
                                        'trial' => 'bg-amber-100 text-amber-700',
                                        'active' => 'bg-green-100 text-green-700',
                                        'expired' => 'bg-red-100 text-red-700',
                                        'suspended' => 'bg-slate-200 text-slate-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                        default => 'bg-slate-100 text-slate-600',
                                    };
                                @endphp

                                <tr class="transition hover:bg-slate-50">


                                    {{-- Church --}}

                                    <td class="px-6 py-4">

                                        <div>

                                            <p class="text-sm font-semibold text-slate-900">
                                                {{ $church->name }}
                                            </p>

                                            <p class="mt-1 text-xs text-slate-500">
                                                {{ $church->email ?? 'No email provided' }}
                                            </p>

                                        </div>

                                    </td>


                                    {{-- Plan --}}

                                    <td class="px-6 py-4">

                                        <span class="text-sm text-slate-700">

                                            {{ $subscription?->plan?->name ?? '—' }}

                                        </span>

                                    </td>


                                    {{-- Status --}}

                                    <td class="px-6 py-4">

                                        <span
                                            class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClasses }}"
                                        >
                                            {{ ucfirst($church->status ?? 'Unknown') }}
                                        </span>

                                    </td>


                                    {{-- Joined --}}

                                    <td class="px-6 py-4">

                                        <span class="text-sm text-slate-600">

                                            {{ $church->created_at?->format('d M Y') ?? '—' }}

                                        </span>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="4"
                                        class="px-6 py-12 text-center"
                                    >

                                        <p class="text-sm font-semibold text-slate-700">
                                            No churches onboarded yet.
                                        </p>

                                        <p class="mt-1 text-xs text-slate-500">
                                            Newly registered churches will appear here.
                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- Subscription Overview --}}
            {{-- ===================================================== --}}

            <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">

                    <h2 class="font-semibold text-slate-900">
                        Subscription Overview
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Platform subscription status
                    </p>

                </div>


                <div class="space-y-6 p-6">


                    {{-- Trial --}}

                    <div>

                        <div class="mb-2 flex items-center justify-between">

                            <span class="text-sm text-slate-600">
                                Trial
                            </span>

                            <span class="text-sm font-semibold text-slate-900">
                                {{ $trialSubscriptions }}
                            </span>

                        </div>

                        <div class="h-2 overflow-hidden rounded-full bg-slate-100">

                            <div
                                class="h-2 rounded-full bg-amber-400"
                                style="width: {{ $trialPercentage }}%"
                            ></div>

                        </div>

                    </div>


                    {{-- Active --}}

                    <div>

                        <div class="mb-2 flex items-center justify-between">

                            <span class="text-sm text-slate-600">
                                Active
                            </span>

                            <span class="text-sm font-semibold text-slate-900">
                                {{ $activeSubscriptions }}
                            </span>

                        </div>

                        <div class="h-2 overflow-hidden rounded-full bg-slate-100">

                            <div
                                class="h-2 rounded-full bg-green-500"
                                style="width: {{ $activePercentage }}%"
                            ></div>

                        </div>

                    </div>


                    {{-- Expired --}}

                    <div>

                        <div class="mb-2 flex items-center justify-between">

                            <span class="text-sm text-slate-600">
                                Expired
                            </span>

                            <span class="text-sm font-semibold text-slate-900">
                                {{ $expiredSubscriptions }}
                            </span>

                        </div>

                        <div class="h-2 overflow-hidden rounded-full bg-slate-100">

                            <div
                                class="h-2 rounded-full bg-red-500"
                                style="width: {{ $expiredPercentage }}%"
                            ></div>

                        </div>

                    </div>


                    {{-- Cancelled --}}

                    <div>

                        <div class="mb-2 flex items-center justify-between">

                            <span class="text-sm text-slate-600">
                                Cancelled
                            </span>

                            <span class="text-sm font-semibold text-slate-900">
                                {{ $cancelledSubscriptions }}
                            </span>

                        </div>

                        <div class="h-2 overflow-hidden rounded-full bg-slate-100">

                            <div
                                class="h-2 rounded-full bg-slate-400"
                                style="width: {{ $cancelledPercentage }}%"
                            ></div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- Trial Expiring Soon --}}
        {{-- ========================================================= --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">

                <div>

                    <h2 class="font-semibold text-slate-900">
                        Trial Expiring Soon
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Churches whose trial ends within the next 7 days
                    </p>

                </div>

                <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">
                    {{ $expiringTrials->count() }} {{ \Illuminate\Support\Str::plural('church', $expiringTrials->count()) }}
                </span>

            </div>


            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-6 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                Church
                            </th>

                            <th class="px-6 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                Plan
                            </th>

                            <th class="px-6 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                Trial Ends
                            </th>

                            <th class="px-6 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                Remaining
                            </th>

                            <th class="px-6 py-3 text-right text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse ($expiringTrials as $subscription)

                            @php
                                $daysRemaining = max(
                                    0,
                                    now()->startOfDay()->diffInDays(
                                        \Illuminate\Support\Carbon::parse($subscription->trial_ends_at)->startOfDay(),
                                        false
                                    )
                                );
                            @endphp

                            <tr class="transition hover:bg-slate-50">

                                <td class="px-6 py-4">

                                    <p class="text-sm font-semibold text-slate-900">
                                        {{ $subscription->church?->name ?? 'Unknown Church' }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $subscription->church?->code ?? '—' }}
                                    </p>

                                </td>


                                <td class="px-6 py-4 text-sm text-slate-700">

                                    {{ $subscription->plan?->name ?? 'Free Trial' }}

                                </td>


                                <td class="px-6 py-4 text-sm text-slate-700">

                                    {{ \Illuminate\Support\Carbon::parse($subscription->trial_ends_at)->format('d M Y') }}

                                </td>


                                <td class="px-6 py-4">

                                    <span class="inline-flex rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">

                                        {{ $daysRemaining }}
                                        {{ \Illuminate\Support\Str::plural('day', $daysRemaining) }}

                                    </span>

                                </td>


                                <td class="px-6 py-4 text-right">

                                    <a
                                        href="{{ route('admin.subscriptions.show', $subscription) }}"
                                        class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-purple-300 hover:bg-purple-50 hover:text-purple-700"
                                    >
                                        View
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="px-6 py-12 text-center"
                                >

                                    <p class="text-sm font-semibold text-slate-700">
                                        No trials expiring soon.
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        You're all clear for the next 7 days.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- Recent Subscription Activity --}}
        {{-- ========================================================= --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">

                <div>

                    <h2 class="font-semibold text-slate-900">
                        Recent Subscriptions
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Latest subscription records across ChurchFlow
                    </p>

                </div>

                <a
                    href="{{ route('admin.subscriptions.index') }}"
                    class="cursor-pointer text-sm font-semibold text-purple-600 transition hover:text-purple-700"
                >
                    View All
                </a>

            </div>


            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-6 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                Church
                            </th>

                            <th class="px-6 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                Plan
                            </th>

                            <th class="px-6 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                Status
                            </th>

                            <th class="px-6 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                Started
                            </th>

                            <th class="px-6 py-3 text-right text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse ($recentSubscriptions as $subscription)

                            <tr class="transition hover:bg-slate-50">

                                <td class="px-6 py-4">

                                    <p class="text-sm font-semibold text-slate-900">
                                        {{ $subscription->church?->name ?? 'Unknown Church' }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $subscription->church?->code ?? '—' }}
                                    </p>

                                </td>


                                <td class="px-6 py-4">

                                    <p class="text-sm text-slate-700">
                                        {{ $subscription->plan?->name ?? 'No Plan' }}
                                    </p>

                                </td>


                                <td class="px-6 py-4">

                                    @switch($subscription->status)

                                        @case('trial')

                                            <span class="inline-flex rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">
                                                Trial
                                            </span>

                                            @break

                                        @case('active')

                                            <span class="inline-flex rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                                Active
                                            </span>

                                            @break

                                        @case('expired')

                                            <span class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700">
                                                Expired
                                            </span>

                                            @break

                                        @case('cancelled')

                                            <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                                Cancelled
                                            </span>

                                            @break

                                        @default

                                            <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                                {{ ucfirst($subscription->status ?? 'Unknown') }}
                                            </span>

                                    @endswitch

                                </td>


                                <td class="px-6 py-4 text-sm text-slate-600">

                                    {{ $subscription->starts_at?->format('d M Y') ?? '—' }}

                                </td>


                                <td class="px-6 py-4 text-right">

                                    <a
                                        href="{{ route('admin.subscriptions.show', $subscription) }}"
                                        class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-purple-300 hover:bg-purple-50 hover:text-purple-700"
                                    >
                                        View
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="px-6 py-12 text-center text-sm text-slate-400"
                                >
                                    No subscription activity yet.
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

        <div class="flex items-center justify-between border-t border-slate-200 pt-4">

            <p class="text-xs text-slate-500">
                ChurchFlow Platform Administration
            </p>

            <p class="text-xs text-slate-400">
                {{ number_format($totalChurches) }}
                {{ \Illuminate\Support\Str::plural('church', $totalChurches) }}
                registered
            </p>

        </div>

    </div>

@endsection