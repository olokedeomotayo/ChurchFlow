@extends('layouts.admin')

@section('title', 'Church Details')
@section('page_title', 'Church Details')
@section('page_description', 'View and manage church account information')

@section('content')

    {{-- ========================================================= --}}
    {{-- Success Message --}}
    {{-- ========================================================= --}}

    @if (session('success'))
        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4">
            <div class="flex items-center gap-3">
                <div class="flex h-7 w-7 items-center justify-center rounded-full bg-green-100 text-sm font-bold text-green-700">
                    ✓
                </div>

                <p class="text-sm font-semibold text-green-700">
                    {{ session('success') }}
                </p>
            </div>
        </div>
    @endif


    {{-- ========================================================= --}}
    {{-- Error Message --}}
    {{-- ========================================================= --}}

    @if (session('error'))
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4">
            <div class="flex items-center gap-3">
                <div class="flex h-7 w-7 items-center justify-center rounded-full bg-red-100 text-sm font-bold text-red-700">
                    !
                </div>

                <p class="text-sm font-semibold text-red-700">
                    {{ session('error') }}
                </p>
            </div>
        </div>
    @endif


    {{-- ========================================================= --}}
    {{-- Action Bar --}}
    {{-- ========================================================= --}}

    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        {{-- Back Button --}}

        <a
            href="{{ route('admin.churches.index') }}"
            class="inline-flex w-fit items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 shadow-sm transition hover:bg-slate-50 hover:text-slate-800"
        >
            <span>←</span>
            Back to Churches
        </a>


        {{-- Action Buttons --}}

        <div class="flex flex-wrap items-center gap-3">

            {{-- Edit Church --}}

            <a
                href="{{ route('admin.churches.edit', $church) }}"
                class="inline-flex items-center gap-2 rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700"
            >
                <span>✎</span>
                Edit Church
            </a>


            {{-- Activate Church --}}

            @if ($church->status !== 'active')

                <form
                    method="POST"
                    action="{{ route('admin.churches.activate', $church) }}"
                >
                    @csrf
                    @method('PATCH')

                   <button
                        type="submit"
                        class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-green-200 bg-green-50 px-4 py-2.5 text-sm font-semibold text-green-700 shadow-sm transition hover:bg-green-100"
                    >
                        <span>✓</span>
                        Activate
                    </button>
                </form>

            @endif


            {{-- Suspend Church --}}

            @if ($church->status === 'active')

                <form
                    method="POST"
                    action="{{ route('admin.churches.suspend', $church) }}"
                >
                    @csrf
                    @method('PATCH')

                   <button
                        type="submit"
                        class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-semibold text-red-700 shadow-sm transition hover:bg-red-100"
                    >
                                            <span>⏸</span>
                        Suspend
                    </button>
                </form>

            @endif

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- Church Overview --}}
    {{-- ========================================================= --}}

    <div class="mb-8 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        {{-- Church Header --}}

        <div class="border-b border-slate-200 px-6 py-6 lg:px-8">

            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                <div class="flex items-center gap-4">

                    {{-- Church Initial --}}

                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-purple-100 text-xl font-bold text-purple-700">
                        {{ strtoupper(substr($church->name, 0, 1)) }}
                    </div>


                    {{-- Church Name --}}

                    <div>

                        <h1 class="text-xl font-bold text-slate-900">
                            {{ $church->name }}
                        </h1>

                        <p class="mt-1 text-sm text-slate-500">
                            {{ $church->code }}
                        </p>

                    </div>

                </div>


                {{-- Church Status --}}

                @php

                    $churchStatusStyles = [
                        'active' => [
                            'wrapper' => 'bg-green-50 text-green-700',
                            'dot' => 'bg-green-500',
                            'label' => 'Active',
                        ],

                        'trial' => [
                            'wrapper' => 'bg-blue-50 text-blue-700',
                            'dot' => 'bg-blue-500',
                            'label' => 'Trial',
                        ],

                        'suspended' => [
                            'wrapper' => 'bg-red-50 text-red-700',
                            'dot' => 'bg-red-500',
                            'label' => 'Suspended',
                        ],

                        'expired' => [
                            'wrapper' => 'bg-orange-50 text-orange-700',
                            'dot' => 'bg-orange-500',
                            'label' => 'Expired',
                        ],

                        'cancelled' => [
                            'wrapper' => 'bg-slate-100 text-slate-600',
                            'dot' => 'bg-slate-400',
                            'label' => 'Cancelled',
                        ],
                    ];

                    $churchStatus = $churchStatusStyles[$church->status] ?? [
                        'wrapper' => 'bg-slate-100 text-slate-600',
                        'dot' => 'bg-slate-400',
                        'label' => ucfirst($church->status),
                    ];

                @endphp


                <span
                    class="inline-flex w-fit items-center gap-2 rounded-full px-4 py-2 text-xs font-bold {{ $churchStatus['wrapper'] }}"
                >

                    <span
                        class="h-2 w-2 rounded-full {{ $churchStatus['dot'] }}"
                    ></span>

                    {{ $churchStatus['label'] }}

                </span>

            </div>

        </div>


        {{-- Church Information --}}

        <div class="px-6 py-8 lg:px-8">

            <div class="mb-6">

                <h2 class="text-base font-bold text-slate-900">
                    Church Information
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    General information registered on the ChurchFlow platform.
                </p>

            </div>


            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">

                {{-- Church Name --}}

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Church Name
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-800">
                        {{ $church->name ?: '—' }}
                    </p>
                </div>


                {{-- Church Code --}}

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Church Code
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-800">
                        {{ $church->code ?: '—' }}
                    </p>
                </div>


                {{-- Email --}}

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Email Address
                    </p>

                    <p class="mt-2 break-all text-sm font-semibold text-slate-800">
                        {{ $church->email ?: '—' }}
                    </p>
                </div>


                {{-- Phone --}}

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Phone Number
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-800">
                        {{ $church->phone ?: '—' }}
                    </p>
                </div>


                {{-- City --}}

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        City
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-800">
                        {{ $church->city ?: '—' }}
                    </p>
                </div>


                {{-- State --}}

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        State
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-800">
                        {{ $church->state ?: '—' }}
                    </p>
                </div>


                {{-- Country --}}

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Country
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-800">
                        {{ $church->country ?: '—' }}
                    </p>
                </div>


                {{-- Timezone --}}

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Timezone
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-800">
                        {{ $church->timezone ?: '—' }}
                    </p>
                </div>


                {{-- Address --}}

                <div class="md:col-span-2 xl:col-span-3">

                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Address
                    </p>

                    <p class="mt-2 text-sm font-semibold leading-6 text-slate-800">
                        {{ $church->address ?: '—' }}
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- Account & Trial Information --}}
    {{-- ========================================================= --}}

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">

        {{-- Account Information --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h2 class="text-base font-bold text-slate-900">
                    Account Information
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Current account status and registration information.
                </p>

            </div>


            <div class="space-y-5 px-6 py-6">

                {{-- Account Status --}}

                <div class="flex items-center justify-between gap-4">

                    <span class="text-sm text-slate-500">
                        Account Status
                    </span>

                    <span
                        class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold {{ $churchStatus['wrapper'] }}"
                    >
                        {{ $churchStatus['label'] }}
                    </span>

                </div>


                {{-- Created --}}

                <div class="flex items-center justify-between gap-4">

                    <span class="text-sm text-slate-500">
                        Created
                    </span>

                    <span class="text-right text-sm font-semibold text-slate-800">

                        @if ($church->created_at)
                            {{ \Carbon\Carbon::parse($church->created_at)->format('d M Y, h:i A') }}
                        @else
                            —
                        @endif

                    </span>

                </div>


                {{-- Last Updated --}}

                <div class="flex items-center justify-between gap-4">

                    <span class="text-sm text-slate-500">
                        Last Updated
                    </span>

                    <span class="text-right text-sm font-semibold text-slate-800">

                        @if ($church->updated_at)
                            {{ \Carbon\Carbon::parse($church->updated_at)->format('d M Y, h:i A') }}
                        @else
                            —
                        @endif

                    </span>

                </div>

            </div>

        </div>


        {{-- Trial Information --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h2 class="text-base font-bold text-slate-900">
                    Trial Information
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Current trial period for this church.
                </p>

            </div>


            <div class="px-6 py-6">

                <div class="space-y-5">

                    {{-- Trial Started --}}

                    <div class="flex items-center justify-between gap-4">

                        <span class="text-sm text-slate-500">
                            Trial Started
                        </span>

                        <span class="text-right text-sm font-semibold text-slate-800">

                            @if ($church->trial_started_at)
                                {{ \Carbon\Carbon::parse($church->trial_started_at)->format('d M Y, h:i A') }}
                            @else
                                —
                            @endif

                        </span>

                    </div>


                    {{-- Trial Ends --}}

                    <div class="flex items-center justify-between gap-4">

                        <span class="text-sm text-slate-500">
                            Trial Ends
                        </span>

                        <span class="text-right text-sm font-semibold text-slate-800">

                            @if ($church->trial_ends_at)
                                {{ \Carbon\Carbon::parse($church->trial_ends_at)->format('d M Y, h:i A') }}
                            @else
                                —
                            @endif

                        </span>

                    </div>

                </div>


                {{-- Divider --}}

                <div class="my-6 border-t border-slate-200"></div>


                {{-- Extend Trial --}}

                <div>

                    <h3 class="text-sm font-bold text-slate-900">
                        Extend Trial
                    </h3>

                    <p class="mt-1 text-xs leading-5 text-slate-500">
                        Add additional days to the current trial period.
                    </p>


                    <form
                        method="POST"
                        action="{{ route('admin.churches.extend-trial', $church) }}"
                        class="mt-5"
                    >

                        @csrf
                        @method('PATCH')


                        <div class="flex flex-col gap-3 sm:flex-row sm:items-end">

                            <div class="w-full">

                                <label
                                    for="days"
                                    class="mb-2 block text-xs font-semibold text-slate-700"
                                >
                                    Extension Period
                                </label>

                                <select
                                    id="days"
                                    name="days"
                                    required
                                    class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                                >
                                    <option value="">
                                        Select extension
                                    </option>

                                    <option value="7">
                                        7 Days
                                    </option>

                                    <option value="14">
                                        14 Days
                                    </option>

                                    <option value="30">
                                        30 Days
                                    </option>

                                    <option value="60">
                                        60 Days
                                    </option>

                                    <option value="90">
                                        90 Days
                                    </option>

                                </select>


                                @error('days')
                                    <p class="mt-1 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                           <button
                                type="submit"
                                class="inline-flex shrink-0 cursor-pointer items-center justify-center rounded-lg bg-purple-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                            >
                                Extend Trial
                            </button>
                               
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- Subscription Information --}}
    {{-- ========================================================= --}}

    @php

        $subscription = $church->subscriptions
            ->sortByDesc('created_at')
            ->first();

    @endphp


    <div class="mt-6 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        {{-- Subscription Header --}}

        <div class="border-b border-slate-200 px-6 py-5">

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <h2 class="text-base font-bold text-slate-900">
                        Subscription Information
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Current subscription and plan details for this church.
                    </p>

                </div>


                @if ($subscription)

                    @php

                        $subscriptionStatusStyles = [
                            'active' => 'bg-green-50 text-green-700',
                            'trial' => 'bg-blue-50 text-blue-700',
                            'past_due' => 'bg-orange-50 text-orange-700',
                            'expired' => 'bg-red-50 text-red-700',
                            'cancelled' => 'bg-slate-100 text-slate-600',
                        ];

                        $subscriptionStatusClass =
                            $subscriptionStatusStyles[$subscription->status]
                            ?? 'bg-slate-100 text-slate-600';

                    @endphp


                    <span
                        class="inline-flex w-fit items-center rounded-full px-3 py-1 text-xs font-bold {{ $subscriptionStatusClass }}"
                    >
                        {{ ucfirst(str_replace('_', ' ', $subscription->status)) }}
                    </span>

                @endif

            </div>

        </div>


        @if ($subscription)

            <div class="px-6 py-6">

                {{-- Plan Overview --}}

                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

                    {{-- Current Plan --}}

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Current Plan
                        </p>

                        <p class="mt-2 text-base font-bold text-slate-900">
                            {{ $subscription->plan?->name ?? '—' }}
                        </p>

                        @if ($subscription->plan?->description)

                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                {{ $subscription->plan->description }}
                            </p>

                        @endif

                    </div>


                    {{-- Plan Price --}}

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Plan Price
                        </p>

                        <p class="mt-2 text-base font-bold text-slate-900">
                            ₦{{ number_format($subscription->plan?->price ?? 0, 2) }}
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            {{ ucfirst($subscription->plan?->billing_cycle ?? '—') }}
                        </p>

                    </div>


                    {{-- Member Limit --}}

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Member Limit
                        </p>

                        <p class="mt-2 text-base font-bold text-slate-900">

                            @if ($subscription->plan?->member_limit)
                                {{ number_format($subscription->plan->member_limit) }}
                            @else
                                Unlimited
                            @endif

                        </p>

                    </div>

                </div>


                {{-- Divider --}}

                <div class="my-6 border-t border-slate-200"></div>


                {{-- Subscription Dates --}}

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">

                    {{-- Started --}}

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Started
                        </p>

                        <p class="mt-2 text-sm font-semibold text-slate-800">

                            @if ($subscription->starts_at)
                                {{ \Carbon\Carbon::parse($subscription->starts_at)->format('d M Y, h:i A') }}
                            @else
                                —
                            @endif

                        </p>

                    </div>


                    {{-- Ends --}}

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Ends
                        </p>

                        <p class="mt-2 text-sm font-semibold text-slate-800">

                            @if ($subscription->ends_at)
                                {{ \Carbon\Carbon::parse($subscription->ends_at)->format('d M Y, h:i A') }}
                            @else
                                —
                            @endif

                        </p>

                    </div>


                    {{-- Trial Ends --}}

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Trial Ends
                        </p>

                        <p class="mt-2 text-sm font-semibold text-slate-800">

                            @if ($subscription->trial_ends_at)
                                {{ \Carbon\Carbon::parse($subscription->trial_ends_at)->format('d M Y, h:i A') }}
                            @else
                                —
                            @endif

                        </p>

                    </div>


                    {{-- Cancelled --}}

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Cancelled
                        </p>

                        <p class="mt-2 text-sm font-semibold text-slate-800">

                            @if ($subscription->cancelled_at)
                                {{ \Carbon\Carbon::parse($subscription->cancelled_at)->format('d M Y, h:i A') }}
                            @else
                                Not cancelled
                            @endif

                        </p>

                    </div>

                </div>

            </div>

        @else

            {{-- No Subscription --}}

            <div class="px-6 py-10 text-center">

                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 text-slate-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z"
                        />
                    </svg>

                </div>


                <p class="mt-4 text-sm font-semibold text-slate-800">
                    No subscription found
                </p>

                <p class="mt-1 text-xs text-slate-500">
                    This church does not currently have a subscription record.
                </p>

            </div>

        @endif

    </div>

@endsection