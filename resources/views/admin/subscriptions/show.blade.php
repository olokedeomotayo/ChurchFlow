@extends('layouts.admin')

@section('title', 'Subscription Details')

@section('page_title', 'Subscription Details')

@section('page_description', 'View subscription, church and plan information.')

@section('content')

    <div class="w-full space-y-6">


        {{-- ========================================================= --}}
        {{-- Flash Messages --}}
        {{-- ========================================================= --}}

        @if (session('success'))

            <div class="rounded-xl border border-green-200 bg-green-50 px-5 py-4">

                <div class="flex items-center gap-3">

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-green-100 text-sm font-bold text-green-700">
                        ✓
                    </div>

                    <p class="text-sm font-semibold text-green-700">
                        {{ session('success') }}
                    </p>

                </div>

            </div>

        @endif


        @if (session('error'))

            <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4">

                <div class="flex items-center gap-3">

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-100 text-sm font-bold text-red-700">
                        !
                    </div>

                    <p class="text-sm font-semibold text-red-700">
                        {{ session('error') }}
                    </p>

                </div>

            </div>

        @endif


        {{-- ========================================================= --}}
        {{-- Header --}}
        {{-- ========================================================= --}}

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <p class="text-sm text-slate-500">
                    Subscription #{{ $subscription->id }}
                </p>

                <h2 class="mt-1 text-xl font-bold text-slate-900">
                    {{ $subscription->church?->name ?? 'Unknown Church' }}
                </h2>

            </div>


            <a
                href="{{ route('admin.subscriptions.index') }}"
                class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
            >
                ← Back to Subscriptions
            </a>

        </div>


        {{-- ========================================================= --}}
        {{-- Subscription Actions --}}
        {{-- ========================================================= --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h2 class="text-base font-bold text-slate-900">
                    Subscription Actions
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Manage the subscription status, trial period and billing plan.
                </p>

            </div>


            <div class="flex flex-wrap gap-3 px-6 py-6">


                {{-- ================================================= --}}
                {{-- Activate --}}
                {{-- ================================================= --}}

                @if ($subscription->status !== 'active')

                    <form
                        method="POST"
                        action="{{ route('admin.subscriptions.activate', $subscription) }}"
                    >

                        @csrf
                        @method('PATCH')

                        <button
                            type="submit"
                            class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-green-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                        >
                            Activate Subscription
                        </button>

                    </form>

                @endif


                {{-- ================================================= --}}
                {{-- Extend Trial --}}
                {{-- ================================================= --}}

                @if ($subscription->status === 'trial')

                    <form
                        method="POST"
                        action="{{ route('admin.subscriptions.extend-trial', $subscription) }}"
                    >

                        @csrf
                        @method('PATCH')

                        <button
                            type="submit"
                            class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-purple-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                        >
                            Extend Trial
                        </button>

                    </form>

                @endif


                {{-- ================================================= --}}
                {{-- Change Plan --}}
                {{-- ================================================= --}}

                <a
                    href="{{ route('admin.subscriptions.change-plan', $subscription) }}"
                    class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-purple-300 hover:bg-purple-50 hover:text-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                >
                    Change Plan
                </a>


                {{-- ================================================= --}}
                {{-- Renew --}}
                {{-- ================================================= --}}

                @if (
                    in_array(
                        $subscription->status,
                        ['expired', 'cancelled']
                    )
                )

                    <form
                        method="POST"
                        action="{{ route('admin.subscriptions.renew', $subscription) }}"
                    >

                        @csrf
                        @method('PATCH')

                        <button
                            type="submit"
                            class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        >
                            Renew Subscription
                        </button>

                    </form>

                @endif


                {{-- ================================================= --}}
                {{-- Cancel --}}
                {{-- ================================================= --}}

                @if ($subscription->status !== 'cancelled')

                    <form
                        method="POST"
                        action="{{ route('admin.subscriptions.cancel', $subscription) }}"
                    >

                        @csrf
                        @method('PATCH')

                        <button
                            type="submit"
                            class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-red-200 bg-red-50 px-5 py-3 text-sm font-semibold text-red-700 shadow-sm transition hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                        >
                            Cancel Subscription
                        </button>

                    </form>

                @endif

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- Subscription Overview --}}
        {{-- ========================================================= --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h2 class="text-base font-bold text-slate-900">
                    Subscription Overview
                </h2>

            </div>


            <div class="grid grid-cols-1 gap-6 px-6 py-6 md:grid-cols-2 xl:grid-cols-4">


                {{-- Status --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                        Status
                    </p>

                    <div class="mt-3">

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

                    </div>

                </div>


                {{-- Plan --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                        Plan
                    </p>

                    <p class="mt-3 text-sm font-bold text-slate-900">
                        {{ $subscription->plan?->name ?? '—' }}
                    </p>

                </div>


                {{-- Started --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                        Started
                    </p>

                    <p class="mt-3 text-sm font-semibold text-slate-800">

                        @if ($subscription->starts_at)

                            {{ \Illuminate\Support\Carbon::parse($subscription->starts_at)->format('d M Y, h:i A') }}

                        @else

                            —

                        @endif

                    </p>

                </div>


                {{-- Ends --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                        Ends
                    </p>

                    <p class="mt-3 text-sm font-semibold text-slate-800">

                        @if ($subscription->ends_at)

                            {{ \Illuminate\Support\Carbon::parse($subscription->ends_at)->format('d M Y, h:i A') }}

                        @else

                            —

                        @endif

                    </p>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- Church Information --}}
        {{-- ========================================================= --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h2 class="text-base font-bold text-slate-900">
                    Church Information
                </h2>

            </div>


            <div class="grid grid-cols-1 gap-6 px-6 py-6 md:grid-cols-2 xl:grid-cols-3">


                {{-- Church Name --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                        Church Name
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-900">
                        {{ $subscription->church?->name ?? '—' }}
                    </p>

                </div>


                {{-- Church Code --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                        Church Code
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-800">
                        {{ $subscription->church?->code ?? '—' }}
                    </p>

                </div>


                {{-- Email --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                        Email
                    </p>

                    <p class="mt-2 break-all text-sm font-semibold text-slate-800">
                        {{ $subscription->church?->email ?? '—' }}
                    </p>

                </div>


                {{-- Phone --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                        Phone
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-800">
                        {{ $subscription->church?->phone ?? '—' }}
                    </p>

                </div>


                {{-- Location --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                        Location
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-800">
                        {{ $subscription->church?->city ?? '—' }},
                        {{ $subscription->church?->state ?? '—' }}
                    </p>

                </div>


                {{-- Country --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                        Country
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-800">
                        {{ $subscription->church?->country ?? '—' }}
                    </p>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- Plan Information --}}
        {{-- ========================================================= --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h2 class="text-base font-bold text-slate-900">
                    Plan Information
                </h2>

            </div>


            <div class="grid grid-cols-1 gap-6 px-6 py-6 md:grid-cols-2 xl:grid-cols-4">


                {{-- Plan Name --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                        Plan Name
                    </p>

                    <p class="mt-2 text-sm font-bold text-slate-900">
                        {{ $subscription->plan?->name ?? '—' }}
                    </p>

                </div>


                {{-- Price --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                        Price
                    </p>

                    <p class="mt-2 text-sm font-bold text-slate-900">

                        @if ($subscription->plan)

                            ₦{{ number_format((float) $subscription->plan->price, 2) }}

                        @else

                            —

                        @endif

                    </p>

                </div>


                {{-- Billing Cycle --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                        Billing Cycle
                    </p>

                    <p class="mt-2 text-sm font-semibold capitalize text-slate-800">
                        {{ $subscription->plan?->billing_cycle ?? '—' }}
                    </p>

                </div>


                {{-- Member Limit --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                        Member Limit
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-800">

                        @if ($subscription->plan?->member_limit)

                            {{ number_format($subscription->plan->member_limit) }}

                        @else

                            Unlimited

                        @endif

                    </p>

                </div>

            </div>


            {{-- Description --}}

            @if ($subscription->plan?->description)

                <div class="border-t border-slate-200 px-6 py-5">

                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                        Description
                    </p>

                    <p class="mt-2 max-w-4xl text-sm leading-6 text-slate-600">
                        {{ $subscription->plan->description }}
                    </p>

                </div>

            @endif

        </div>


        {{-- ========================================================= --}}
        {{-- Trial & Cancellation --}}
        {{-- ========================================================= --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h2 class="text-base font-bold text-slate-900">
                    Trial & Cancellation Information
                </h2>

            </div>


            <div class="grid grid-cols-1 gap-6 px-6 py-6 md:grid-cols-2">


                {{-- Trial Ends --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                        Trial Ends
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-800">

                        @if ($subscription->trial_ends_at)

                            {{ \Illuminate\Support\Carbon::parse($subscription->trial_ends_at)->format('d M Y, h:i A') }}

                        @else

                            —

                        @endif

                    </p>

                </div>


                {{-- Cancelled At --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                        Cancelled At
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-800">

                        @if ($subscription->cancelled_at)

                            {{ \Illuminate\Support\Carbon::parse($subscription->cancelled_at)->format('d M Y, h:i A') }}

                        @else

                            —

                        @endif

                    </p>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- Record Information --}}
        {{-- ========================================================= --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h2 class="text-base font-bold text-slate-900">
                    Record Information
                </h2>

            </div>


            <div class="grid grid-cols-1 gap-6 px-6 py-6 md:grid-cols-2">


                {{-- Created --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                        Created
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-800">

                        @if ($subscription->created_at)

                            {{ \Illuminate\Support\Carbon::parse($subscription->created_at)->format('d M Y, h:i A') }}

                        @else

                            —

                        @endif

                    </p>

                </div>


                {{-- Updated --}}

                <div>

                    <p class="text-xs font-bold uppercase tracking-wide text-slate-500">
                        Last Updated
                    </p>

                    <p class="mt-2 text-sm font-semibold text-slate-800">

                        @if ($subscription->updated_at)

                            {{ \Illuminate\Support\Carbon::parse($subscription->updated_at)->format('d M Y, h:i A') }}

                        @else

                            —

                        @endif

                    </p>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- Footer --}}
        {{-- ========================================================= --}}

        <div class="flex justify-end pt-2">

            <a
                href="{{ route('admin.subscriptions.index') }}"
                class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
            >
                ← Back to Subscriptions
            </a>

        </div>

    </div>

@endsection