@extends('layouts.admin')

@section('title', 'Subscription Settings')

@section('page_title', 'Subscription Settings')

@section('page_description', 'Configure ChurchFlow trials, billing behaviour and subscription defaults.')

@section('content')

    <div class="w-full space-y-6">

        {{-- Page Header --}}

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h2 class="text-xl font-bold text-slate-900">
                    Subscription Settings
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Configure how ChurchFlow manages trials, subscriptions and billing.
                </p>

            </div>

            <a
                href="{{ route('admin.settings.index') }}"
                class="inline-flex w-fit cursor-pointer items-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
            >
                ← Back to Settings
            </a>

        </div>


        {{-- Subscription Configuration --}}

        <div class="w-full overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h3 class="text-base font-bold text-slate-900">
                    Subscription Configuration
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Configure the default rules used when managing church subscriptions.
                </p>

            </div>


            <form
                method="POST"
                action="{{ route('admin.settings.subscription.update') }}"
                class="space-y-6 p-6"
            >

                @csrf


                {{-- Trial Period --}}

                <div>

                    <label
                        for="trial_period"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Trial Period
                    </label>

                    <div class="flex items-center gap-3">

                        <input
                            type="number"
                            id="trial_period"
                            name="trial_period"
                            value="{{ old('trial_period', $settings['trial_period'] ?? 30) }}"
                            min="0"
                            max="365"
                            required
                            class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        >

                        <span class="shrink-0 text-sm text-slate-500">
                            days
                        </span>

                    </div>

                    <p class="mt-1.5 text-xs text-slate-500">
                        Number of days a newly onboarded church remains in trial mode.
                    </p>

                </div>


                {{-- Grace Period --}}

                <div>

                    <label
                        for="grace_period"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Grace Period
                    </label>

                    <div class="flex items-center gap-3">

                        <input
                            type="number"
                            id="grace_period"
                            name="grace_period"
                            value="{{ old('grace_period', $settings['grace_period'] ?? 0) }}"
                            min="0"
                            max="90"
                            required
                            class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        >

                        <span class="shrink-0 text-sm text-slate-500">
                            days
                        </span>

                    </div>

                    <p class="mt-1.5 text-xs text-slate-500">
                        Number of additional days a church may retain access after subscription expiry.
                    </p>

                </div>


                {{-- Automatic Renewal --}}

                <div class="rounded-lg border border-slate-200 bg-slate-50 p-5">

                    <div class="flex items-start gap-4">

                        <div class="pt-0.5">

                            <input
                                type="checkbox"
                                id="automatic_renewal"
                                name="automatic_renewal"
                                value="1"
                                {{ old(
                                    'automatic_renewal',
                                    $settings['automatic_renewal'] ?? '0'
                                ) == '1' ? 'checked' : '' }}
                                class="h-4 w-4 cursor-pointer rounded border-slate-300 text-purple-600 focus:ring-purple-500"
                            >

                        </div>

                        <div>

                            <label
                                for="automatic_renewal"
                                class="cursor-pointer text-sm font-semibold text-slate-900"
                            >
                                Enable automatic renewal
                            </label>

                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                Allow eligible subscriptions to be renewed automatically when supported by the payment provider.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Subscription Behaviour Notice --}}

                <div class="rounded-lg border border-blue-200 bg-blue-50 px-5 py-4">

                    <div class="flex gap-3">

                        <div class="text-blue-600">
                            ℹ
                        </div>

                        <div>

                            <p class="text-sm font-semibold text-blue-900">
                                Subscription management
                            </p>

                            <p class="mt-1 text-xs leading-5 text-blue-700">
                                These settings define the default subscription behaviour for ChurchFlow.
                                Individual church subscriptions can still be managed from the
                                Subscriptions section.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Save Button --}}

                <div class="flex items-center justify-end border-t border-slate-200 pt-6">

                    <button
                        type="submit"
                        class="inline-flex cursor-pointer items-center rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                    >
                        Save Subscription Settings
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection