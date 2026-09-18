@extends('layouts.church')

@section('title', 'Billing & Subscription')

@section('page_title', 'Billing & Subscription')

@section('page_description', 'Manage your ChurchFlow subscription and billing.')

@section('content')

    <div class="w-full space-y-8">

        {{-- Page Header --}}
        <div>
            <h2 class="text-xl font-bold text-slate-900">
                Billing & Subscription
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Choose the plan and billing cycle that works best for your church.
            </p>
        </div>


        {{-- Church Account --}}
        <div class="rounded-xl border border-purple-200 bg-purple-50 p-5">

            <p class="text-xs font-semibold uppercase tracking-wide text-purple-600">
                Church Account
            </p>

            <p class="mt-1 text-lg font-bold text-slate-900">
                {{ $church->name }}
            </p>

            <p class="mt-1 text-sm text-slate-600">
                Church Code: {{ $church->code }}
            </p>

        </div>


        {{-- Billing Cycle Selector --}}
        <div>

            <div class="flex justify-center">

                <div
                    class="inline-flex rounded-xl border border-slate-200 bg-slate-100 p-1 shadow-sm"
                >

                    <button
                        type="button"
                        id="monthlyButton"
                        onclick="setBillingCycle('monthly')"
                        class="rounded-lg bg-white px-6 py-2.5 text-sm font-semibold text-purple-700 shadow-sm transition"
                    >
                        Monthly
                    </button>

                    <button
                        type="button"
                        id="annualButton"
                        onclick="setBillingCycle('annual')"
                        class="rounded-lg px-6 py-2.5 text-sm font-semibold text-slate-500 transition hover:text-slate-700"
                    >
                        Annual
                    </button>

                </div>

            </div>


            {{-- Billing Description --}}

            <div class="mt-4 text-center">

                <p
                    id="monthlyDescription"
                    class="text-sm text-slate-500"
                >
                    Pay monthly and maintain flexible billing.
                </p>

                <p
                    id="annualDescription"
                    class="hidden text-sm text-slate-500"
                >
                    Pay annually and save compared with monthly billing.
                </p>

            </div>

        </div>


        {{-- Plans --}}

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">

            @forelse ($plans as $plan)

                @php

                    $monthlyPrice = (float) $plan->monthly_price;

                    $annualPrice = (float) $plan->annual_price;

                    $monthlyAnnualCost = $monthlyPrice * 12;

                    $annualSavings = $monthlyAnnualCost - $annualPrice;

                    $savingsPercentage = $monthlyAnnualCost > 0
                        ? ($annualSavings / $monthlyAnnualCost) * 100
                        : 0;

                @endphp


                <div
                    class="flex flex-col rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-purple-200 hover:shadow-md"
                >

                    {{-- Plan Header --}}

                    <div>

                        <div class="flex items-start justify-between gap-4">

                            <h3 class="text-lg font-bold text-slate-900">
                                {{ $plan->name }}
                            </h3>

                            <span
                                class="rounded-full bg-green-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-green-700"
                            >
                                Available
                            </span>

                        </div>


                        @if ($plan->description)

                            <p class="mt-2 text-sm leading-6 text-slate-500">
                                {{ $plan->description }}
                            </p>

                        @endif

                    </div>


                    {{-- Monthly Price --}}

                    <div
                        class="plan-monthly-price mt-6"
                    >

                        <div class="flex items-end gap-2">

                            <span class="text-3xl font-bold text-slate-900">
                                ₦{{ number_format($monthlyPrice, 2) }}
                            </span>

                            <span class="mb-1 text-sm text-slate-500">
                                / month
                            </span>

                        </div>

                    </div>


                    {{-- Annual Price --}}

                    <div
                        class="plan-annual-price mt-6 hidden"
                    >

                        <div class="flex items-end gap-2">

                            <span class="text-3xl font-bold text-slate-900">
                                ₦{{ number_format($annualPrice, 2) }}
                            </span>

                            <span class="mb-1 text-sm text-slate-500">
                                / year
                            </span>

                        </div>


                        @if ($annualSavings > 0)

                            <div class="mt-2">

                                <span
                                    class="inline-flex rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700"
                                >
                                    Save
                                    ₦{{ number_format($annualSavings, 2) }}

                                    @if ($savingsPercentage > 0)
                                        ({{ number_format($savingsPercentage, 0) }}%)
                                    @endif
                                </span>

                            </div>

                        @endif

                    </div>


                    {{-- Plan Details --}}

                    <div class="mt-6 space-y-3">

                        <div class="flex items-center gap-3 text-sm text-slate-600">
                            <span class="text-green-600">✓</span>
                            Church management
                        </div>

                        <div class="flex items-center gap-3 text-sm text-slate-600">
                            <span class="text-green-600">✓</span>
                            Members management
                        </div>

                        <div class="flex items-center gap-3 text-sm text-slate-600">
                            <span class="text-green-600">✓</span>
                            Financial management
                        </div>


                        @if ($plan->member_limit)

                            <div class="flex items-center gap-3 text-sm text-slate-600">

                                <span class="text-green-600">
                                    ✓
                                </span>

                                Up to
                                {{ number_format($plan->member_limit) }}
                                members

                            </div>

                        @else

                            <div class="flex items-center gap-3 text-sm text-slate-600">

                                <span class="text-green-600">
                                    ✓
                                </span>

                                Unlimited members

                            </div>

                        @endif

                    </div>


                    {{-- Subscribe --}}

                    <div class="mt-auto pt-8">

                        <form
                            method="POST"
                            action="{{ route('church.payments.initialize', $plan) }}"
                        >

                            @csrf


                            {{-- Billing Cycle --}}

                            <input
                                type="hidden"
                                name="billing_cycle"
                                value="monthly"
                                class="billing-cycle-input"
                            >


                            <button
                                type="submit"
                                class="subscribe-button inline-flex w-full cursor-pointer items-center justify-center rounded-lg bg-purple-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                            >
                                Subscribe Monthly
                            </button>

                        </form>

                    </div>

                </div>

            @empty

                <div class="col-span-full rounded-xl border border-slate-200 bg-white p-8 text-center">

                    <p class="text-sm font-semibold text-slate-700">
                        No subscription plans available.
                    </p>

                    <p class="mt-1 text-sm text-slate-500">
                        Please contact ChurchFlow support.
                    </p>

                </div>

            @endforelse

        </div>

    </div>


    {{-- ============================================================
         BILLING TOGGLE SCRIPT
    ============================================================= --}}

    <script>

        function setBillingCycle(cycle) {

            const monthlyButton =
                document.getElementById('monthlyButton');

            const annualButton =
                document.getElementById('annualButton');

            const monthlyDescription =
                document.getElementById('monthlyDescription');

            const annualDescription =
                document.getElementById('annualDescription');


            const monthlyPrices =
                document.querySelectorAll('.plan-monthly-price');

            const annualPrices =
                document.querySelectorAll('.plan-annual-price');


            const billingInputs =
                document.querySelectorAll('.billing-cycle-input');

            const subscribeButtons =
                document.querySelectorAll('.subscribe-button');


            /*
            |--------------------------------------------------------------------------
            | Monthly
            |--------------------------------------------------------------------------
            */

            if (cycle === 'monthly') {

                monthlyButton.classList.add(
                    'bg-white',
                    'text-purple-700',
                    'shadow-sm'
                );

                monthlyButton.classList.remove(
                    'text-slate-500'
                );


                annualButton.classList.remove(
                    'bg-white',
                    'text-purple-700',
                    'shadow-sm'
                );

                annualButton.classList.add(
                    'text-slate-500'
                );


                monthlyDescription.classList.remove(
                    'hidden'
                );

                annualDescription.classList.add(
                    'hidden'
                );


                monthlyPrices.forEach(function (element) {

                    element.classList.remove('hidden');

                });


                annualPrices.forEach(function (element) {

                    element.classList.add('hidden');

                });


                billingInputs.forEach(function (input) {

                    input.value = 'monthly';

                });


                subscribeButtons.forEach(function (button) {

                    button.textContent = 'Subscribe Monthly';

                });

            }


            /*
            |--------------------------------------------------------------------------
            | Annual
            |--------------------------------------------------------------------------
            */

            if (cycle === 'annual') {

                annualButton.classList.add(
                    'bg-white',
                    'text-purple-700',
                    'shadow-sm'
                );

                annualButton.classList.remove(
                    'text-slate-500'
                );


                monthlyButton.classList.remove(
                    'bg-white',
                    'text-purple-700',
                    'shadow-sm'
                );

                monthlyButton.classList.add(
                    'text-slate-500'
                );


                monthlyDescription.classList.add(
                    'hidden'
                );

                annualDescription.classList.remove(
                    'hidden'
                );


                monthlyPrices.forEach(function (element) {

                    element.classList.add('hidden');

                });


                annualPrices.forEach(function (element) {

                    element.classList.remove('hidden');

                });


                billingInputs.forEach(function (input) {

                    input.value = 'annual';

                });


                subscribeButtons.forEach(function (button) {

                    button.textContent = 'Subscribe Annually';

                });

            }

        }

    </script>

@endsection