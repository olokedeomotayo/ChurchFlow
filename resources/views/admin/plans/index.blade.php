@extends('layouts.admin')

@section('title', 'Subscription Plans')
@section('page_title', 'Subscription Plans')
@section('page_description', 'Manage ChurchFlow subscription plans and pricing.')

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
    {{-- Header Actions --}}
    {{-- ========================================================= --}}

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-base font-bold text-slate-900">
                All Plans
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Create and manage the subscription plans available to churches.
            </p>
        </div>


        <a
            href="{{ route('admin.plans.create') }}"
            class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700"
        >
            <span class="text-lg leading-none">+</span>
            Create Plan
        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- Plans Table --}}
    {{-- ========================================================= --}}

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                            Plan
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                            Price
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                            Billing
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                            Member Limit
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                            Subscriptions
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wide text-slate-500">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse ($plans as $plan)

                        <tr class="transition hover:bg-slate-50">

                            {{-- Plan --}}

                            <td class="px-6 py-5">

                                <div>

                                    <p class="text-sm font-bold text-slate-900">
                                        {{ $plan->name }}
                                    </p>

                                    @if ($plan->description)

                                        <p class="mt-1 max-w-sm text-xs leading-5 text-slate-500">
                                            {{ $plan->description }}
                                        </p>

                                    @endif

                                </div>

                            </td>


                            {{-- Price --}}

                            <td class="whitespace-nowrap px-6 py-5">

                                <span class="text-sm font-bold text-slate-900">
                                    ₦{{ number_format((float) $plan->price, 2) }}
                                </span>

                            </td>


                            {{-- Billing --}}

                            <td class="whitespace-nowrap px-6 py-5">

                                <span class="text-sm font-medium capitalize text-slate-700">
                                    {{ $plan->billing_cycle }}
                                </span>

                            </td>


                            {{-- Member Limit --}}

                            <td class="whitespace-nowrap px-6 py-5">

                                @if ($plan->member_limit)
                                    <span class="text-sm font-medium text-slate-700">
                                        {{ number_format($plan->member_limit) }}
                                    </span>
                                @else
                                    <span class="text-sm font-medium text-slate-500">
                                        Unlimited
                                    </span>
                                @endif

                            </td>


                            {{-- Subscriptions --}}

                            <td class="whitespace-nowrap px-6 py-5">

                                <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700">
                                    {{ number_format($plan->subscriptions_count) }}
                                </span>

                            </td>


                            {{-- Status --}}

                            <td class="whitespace-nowrap px-6 py-5">

                                @if ($plan->is_active)

                                    <span class="inline-flex items-center gap-2 rounded-full bg-green-50 px-3 py-1 text-xs font-bold text-green-700">

                                        <span class="h-2 w-2 rounded-full bg-green-500"></span>

                                        Active

                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">

                                        <span class="h-2 w-2 rounded-full bg-slate-400"></span>

                                        Inactive

                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}

                            <td class="whitespace-nowrap px-6 py-5">

                                <div class="flex items-center justify-end gap-2">

                                    {{-- Edit --}}

                                    <a
                                        href="{{ route('admin.plans.edit', $plan) }}"
                                        class="inline-flex cursor-pointer items-center rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-50"
                                    >
                                        Edit
                                    </a>


                                    {{-- Activate --}}

                                    @if (!$plan->is_active)

                                        <form
                                            method="POST"
                                            action="{{ route('admin.plans.activate', $plan) }}"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="inline-flex cursor-pointer items-center rounded-lg border border-green-200 bg-green-50 px-3 py-2 text-xs font-semibold text-green-700 transition hover:bg-green-100"
                                            >
                                                Activate
                                            </button>

                                        </form>

                                    @endif


                                    {{-- Deactivate --}}

                                    @if ($plan->is_active)

                                        <form
                                            method="POST"
                                            action="{{ route('admin.plans.deactivate', $plan) }}"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="inline-flex cursor-pointer items-center rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-100"
                                            >
                                                Deactivate
                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="px-6 py-12 text-center"
                            >

                                <div class="mx-auto max-w-sm">

                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">

                                        <span class="text-xl text-slate-400">
                                            $
                                        </span>

                                    </div>

                                    <h3 class="mt-4 text-sm font-bold text-slate-900">
                                        No subscription plans
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Create your first subscription plan to get started.
                                    </p>

                                    <a
                                        href="{{ route('admin.plans.create') }}"
                                        class="mt-5 inline-flex cursor-pointer items-center rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700"
                                    >
                                        Create Plan
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endsection