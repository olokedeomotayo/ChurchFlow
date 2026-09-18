@extends('layouts.admin')

@section('title', 'Change Subscription Plan')

@section('page_title', 'Change Subscription Plan')

@section('page_description', 'Update the subscription plan for this church.')

@section('content')

    <div class="w-full space-y-6">

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

                <p class="mt-1 text-sm text-slate-500">
                    Select a new subscription plan.
                </p>

            </div>

            <a
                href="{{ route('admin.subscriptions.show', $subscription) }}"
                class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
            >
                ← Back to Subscription
            </a>

        </div>


        {{-- ========================================================= --}}
        {{-- Current Plan --}}
        {{-- ========================================================= --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h2 class="text-base font-bold text-slate-900">
                    Current Plan
                </h2>

            </div>

            <div class="px-6 py-6">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <p class="text-lg font-bold text-slate-900">
                            {{ $subscription->plan?->name ?? 'No Plan' }}
                        </p>

                        @if ($subscription->plan?->description)

                            <p class="mt-1 text-sm text-slate-500">
                                {{ $subscription->plan->description }}
                            </p>

                        @endif

                    </div>

                    @if ($subscription->plan)

                        <div class="text-left sm:text-right">

                            <p class="text-lg font-bold text-purple-600">
                                ₦{{ number_format((float) $subscription->plan->price, 2) }}
                            </p>

                            <p class="text-xs capitalize text-slate-500">
                                {{ $subscription->plan->billing_cycle }}
                            </p>

                        </div>

                    @endif

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- Available Plans --}}
        {{-- ========================================================= --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h2 class="text-base font-bold text-slate-900">
                    Available Plans
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Choose an active plan for this subscription.
                </p>

            </div>


            <form
                method="POST"
                action="{{ route('admin.subscriptions.update-plan', $subscription) }}"
                class="px-6 py-6"
            >

                @csrf
                @method('PATCH')


                <div class="space-y-4">

                    @forelse ($plans as $plan)

                        <label
                            class="block cursor-pointer rounded-xl border border-slate-200 p-5 transition hover:border-purple-300 hover:bg-purple-50"
                        >

                            <div class="flex items-start gap-4">

                                <input
                                    type="radio"
                                    name="plan_id"
                                    value="{{ $plan->id }}"
                                    @checked($subscription->plan_id == $plan->id)
                                    class="mt-1 h-4 w-4 cursor-pointer border-slate-300 text-purple-600 focus:ring-purple-500"
                                >

                                <div class="min-w-0 flex-1">

                                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                                        <div>

                                            <h3 class="text-sm font-bold text-slate-900">
                                                {{ $plan->name }}
                                            </h3>

                                            @if ($plan->description)

                                                <p class="mt-1 text-sm text-slate-500">
                                                    {{ $plan->description }}
                                                </p>

                                            @endif

                                        </div>


                                        <div class="sm:text-right">

                                            <p class="text-base font-bold text-purple-600">
                                                ₦{{ number_format((float) $plan->price, 2) }}
                                            </p>

                                            <p class="text-xs capitalize text-slate-500">
                                                {{ $plan->billing_cycle }}
                                            </p>

                                        </div>

                                    </div>


                                    <div class="mt-4 flex flex-wrap gap-4 text-xs text-slate-500">

                                        <span>
                                            <strong class="text-slate-700">
                                                Member Limit:
                                            </strong>

                                            {{ $plan->member_limit ? number_format($plan->member_limit) : 'Unlimited' }}
                                        </span>

                                        <span>
                                            <strong class="text-slate-700">
                                                Status:
                                            </strong>

                                            Active
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </label>

                    @empty

                        <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center">

                            <p class="text-sm font-semibold text-slate-700">
                                No active plans available.
                            </p>

                            <p class="mt-1 text-sm text-slate-500">
                                Create or activate a subscription plan before continuing.
                            </p>

                        </div>

                    @endforelse

                </div>


                {{-- ================================================= --}}
                {{-- Validation Error --}}
                {{-- ================================================= --}}

                @error('plan_id')

                    <p class="mt-4 text-sm font-medium text-red-600">
                        {{ $message }}
                    </p>

                @enderror


                {{-- ================================================= --}}
                {{-- Actions --}}
                {{-- ================================================= --}}

                @if ($plans->count())

                    <div class="mt-6 flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('admin.subscriptions.show', $subscription) }}"
                            class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-purple-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                        >
                            Update Subscription Plan
                        </button>

                    </div>

                @endif

            </form>

        </div>

    </div>

@endsection