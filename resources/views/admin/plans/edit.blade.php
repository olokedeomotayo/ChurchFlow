@extends('layouts.admin')

@section('title', 'Edit Subscription Plan')

@section('page_title', 'Edit Subscription Plan')

@section('page_description', 'Update the pricing, limits and availability of this ChurchFlow subscription plan.')

@section('content')

    <div class="w-full">

        <form
            method="POST"
            action="{{ route('admin.plans.update', $plan) }}"
        >

            @csrf
            @method('PUT')


            {{-- =========================================================
                 PLAN INFORMATION
            ========================================================== --}}

            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">

                    <h2 class="text-base font-bold text-slate-900">
                        Plan Information
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Update the basic information for this subscription plan.
                    </p>

                </div>


                <div class="grid grid-cols-1 gap-6 px-6 py-6 lg:grid-cols-2">


                    {{-- Plan Name --}}

                    <div>

                        <label
                            for="name"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Plan Name
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $plan->name) }}"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                        >

                        @error('name')
                            <p class="mt-2 text-xs font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Slug --}}

                    <div>

                        <label
                            for="slug"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Slug
                        </label>

                        <input
                            type="text"
                            id="slug"
                            name="slug"
                            value="{{ old('slug', $plan->slug) }}"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                        >

                        <p class="mt-2 text-xs text-slate-400">
                            Use lowercase letters, numbers and hyphens.
                        </p>

                        @error('slug')
                            <p class="mt-2 text-xs font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Description --}}

                    <div class="lg:col-span-2">

                        <label
                            for="description"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Description
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                        >{{ old('description', $plan->description) }}</textarea>

                        @error('description')
                            <p class="mt-2 text-xs font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

            </div>


            {{-- =========================================================
                 PRICING & LIMITS
            ========================================================== --}}

            <div class="mt-6 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">

                    <h2 class="text-base font-bold text-slate-900">
                        Pricing & Limits
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Update the monthly and annual pricing and usage limits.
                    </p>

                </div>


                <div class="grid grid-cols-1 gap-6 px-6 py-6 md:grid-cols-3">


                    {{-- =================================================
                         MONTHLY PRICE
                    ================================================== --}}

                    <div>

                        <label
                            for="monthly_price"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Monthly Price (₦)
                        </label>

                        <div class="relative">

                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-medium text-slate-500">
                                ₦
                            </span>

                            <input
                                type="number"
                                id="monthly_price"
                                name="monthly_price"
                                value="{{ old('monthly_price', $plan->monthly_price) }}"
                                min="0"
                                step="0.01"
                                required
                                class="w-full rounded-lg border border-slate-300 bg-white py-3 pl-9 pr-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                            >

                        </div>

                        <p class="mt-2 text-xs text-slate-400">
                            Amount charged when Monthly billing is selected.
                        </p>

                        @error('monthly_price')
                            <p class="mt-2 text-xs font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- =================================================
                         ANNUAL PRICE
                    ================================================== --}}

                    <div>

                        <label
                            for="annual_price"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Annual Price (₦)
                        </label>

                        <div class="relative">

                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-medium text-slate-500">
                                ₦
                            </span>

                            <input
                                type="number"
                                id="annual_price"
                                name="annual_price"
                                value="{{ old('annual_price', $plan->annual_price) }}"
                                min="0"
                                step="0.01"
                                required
                                class="w-full rounded-lg border border-slate-300 bg-white py-3 pl-9 pr-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                            >

                        </div>

                        <p class="mt-2 text-xs text-slate-400">
                            Amount charged when Annual billing is selected.
                        </p>

                        @error('annual_price')
                            <p class="mt-2 text-xs font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- =================================================
                         MEMBER LIMIT
                    ================================================== --}}

                    <div>

                        <label
                            for="member_limit"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Member Limit
                        </label>

                        <input
                            type="number"
                            id="member_limit"
                            name="member_limit"
                            value="{{ old('member_limit', $plan->member_limit) }}"
                            min="1"
                            placeholder="Unlimited"
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                        >

                        <p class="mt-2 text-xs text-slate-400">
                            Leave empty for unlimited members.
                        </p>

                        @error('member_limit')
                            <p class="mt-2 text-xs font-medium text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>


                {{-- Billing Information --}}

                <div class="border-t border-slate-100 bg-slate-50 px-6 py-4">

                    <div class="flex items-start gap-3">

                        <div class="mt-0.5 text-purple-600">
                            ℹ
                        </div>

                        <div>

                            <p class="text-sm font-semibold text-slate-700">
                                Billing flexibility
                            </p>

                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                Churches can choose either Monthly or Annual billing when
                                subscribing to this plan.
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================================================
                 PLAN STATUS
            ========================================================== --}}

            <div class="mt-6 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">

                    <h2 class="text-base font-bold text-slate-900">
                        Plan Status
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Control whether this plan is available for churches.
                    </p>

                </div>


                <div class="px-6 py-6">

                    <label class="flex cursor-pointer items-start gap-4">

                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            @checked(old('is_active', $plan->is_active))
                            class="mt-1 h-4 w-4 cursor-pointer rounded border-slate-300 text-purple-600 focus:ring-purple-500"
                        >

                        <span>

                            <span class="block text-sm font-semibold text-slate-800">
                                Active Plan
                            </span>

                            <span class="mt-1 block text-sm text-slate-500">
                                Make this plan available for new church subscriptions.
                            </span>

                        </span>

                    </label>

                    @error('is_active')
                        <p class="mt-2 text-xs font-medium text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>


            {{-- =========================================================
                 EXISTING SUBSCRIPTIONS WARNING
            ========================================================== --}}

            @if ($plan->subscriptions_count ?? $plan->subscriptions()->exists())

                <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 px-6 py-5">

                    <div class="flex gap-3">

                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-amber-100 text-sm font-bold text-amber-700">
                            !
                        </div>

                        <div>

                            <h3 class="text-sm font-bold text-amber-900">
                                This plan has existing subscriptions
                            </h3>

                            <p class="mt-1 text-sm leading-6 text-amber-800">
                                Changes to this plan may affect churches currently subscribed
                                to it. Review active subscriptions before making major pricing
                                or limit changes.
                            </p>

                        </div>

                    </div>

                </div>

            @endif


            {{-- =========================================================
                 FORM ACTIONS
            ========================================================== --}}

            <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">

                <a
                    href="{{ route('admin.plans.index') }}"
                    class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-purple-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                >
                    Update Plan
                </button>

            </div>

        </form>

    </div>

@endsection