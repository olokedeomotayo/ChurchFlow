@extends('layouts.admin')

@section('title', 'Platform Settings')

@section('page_title', 'Platform Settings')

@section('page_description', 'Manage ChurchFlow platform information and general configuration.')

@section('content')

    <div class="w-full space-y-6">

        {{-- Success Message --}}

        @if (session('success'))

            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                {{ session('success') }}
            </div>

        @endif


        {{-- Validation Errors --}}

        @if ($errors->any())

            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3">

                <p class="text-sm font-semibold text-red-700">
                    Please correct the following errors:
                </p>

                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-600">

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- Page Header --}}

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h2 class="text-xl font-bold text-slate-900">
                    Platform Settings
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Manage your ChurchFlow platform information and preferences.
                </p>

            </div>


            <a
                href="{{ route('admin.settings.index') }}"
                class="inline-flex w-fit items-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
            >
                ← Back to Settings
            </a>

        </div>


        {{-- Platform Information --}}

        <div class="w-full overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h3 class="text-base font-bold text-slate-900">
                    Platform Information
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Basic information displayed across the ChurchFlow platform.
                </p>

            </div>


            <form
                method="POST"
                action="{{ route('admin.settings.platform.update') }}"
                class="space-y-6 p-6"
            >

                @csrf


                {{-- Platform Name --}}

                <div>

                    <label
                        for="platform_name"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Platform Name
                    </label>

                    <input
                        type="text"
                        id="platform_name"
                        name="platform_name"
                        value="{{ old('platform_name', $settings['platform_name'] ?? 'ChurchFlow') }}"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        placeholder="ChurchFlow"
                    >

                    <p class="mt-1.5 text-xs text-slate-500">
                        The name of your church management platform.
                    </p>

                </div>


                {{-- Support Email --}}

                <div>

                    <label
                        for="support_email"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Support Email
                    </label>

                    <input
                        type="email"
                        id="support_email"
                        name="support_email"
                        value="{{ old('support_email', $settings['support_email'] ?? 'info@techcrossbreed.com.ng') }}"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        placeholder="support@example.com"
                    >

                    <p class="mt-1.5 text-xs text-slate-500">
                        Email address churches can use to contact platform support.
                    </p>

                </div>


                {{-- Support Phone --}}

                <div>

                    <label
                        for="support_phone"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Support Phone
                    </label>

                    <input
                        type="text"
                        id="support_phone"
                        name="support_phone"
                        value="{{ old('support_phone', $settings['support_phone'] ?? '08120081213') }}"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        placeholder="08000000000"
                    >

                    <p class="mt-1.5 text-xs text-slate-500">
                        Primary phone number for platform support.
                    </p>

                </div>


                {{-- Platform Description --}}

                <div>

                    <label
                        for="platform_description"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Platform Description
                    </label>

                    <textarea
                        id="platform_description"
                        name="platform_description"
                        rows="4"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        placeholder="Describe your platform..."
                    >{{ old(
                        'platform_description',
                        $settings['platform_description'] ?? 'ChurchFlow is a modern church management platform designed to help churches manage their members, finances, attendance and operations.'
                    ) }}</textarea>

                </div>


                {{-- Currency & Timezone --}}

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    {{-- Currency --}}

                    <div>

                        <label
                            for="currency"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Default Currency
                        </label>

                        <select
                            id="currency"
                            name="currency"
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        >

                            <option
                                value="NGN"
                                {{ old('currency', $settings['currency'] ?? 'NGN') === 'NGN' ? 'selected' : '' }}
                            >
                                NGN — Nigerian Naira
                            </option>

                            <option
                                value="USD"
                                {{ old('currency', $settings['currency'] ?? 'NGN') === 'USD' ? 'selected' : '' }}
                            >
                                USD — US Dollar
                            </option>

                            <option
                                value="GBP"
                                {{ old('currency', $settings['currency'] ?? 'NGN') === 'GBP' ? 'selected' : '' }}
                            >
                                GBP — British Pound
                            </option>

                        </select>

                    </div>


                    {{-- Timezone --}}

                    <div>

                        <label
                            for="timezone"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Default Timezone
                        </label>

                        <select
                            id="timezone"
                            name="timezone"
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        >

                            <option
                                value="Africa/Lagos"
                                {{ old('timezone', $settings['timezone'] ?? 'Africa/Lagos') === 'Africa/Lagos' ? 'selected' : '' }}
                            >
                                Africa/Lagos
                            </option>

                            <option
                                value="UTC"
                                {{ old('timezone', $settings['timezone'] ?? 'Africa/Lagos') === 'UTC' ? 'selected' : '' }}
                            >
                                UTC
                            </option>

                        </select>

                    </div>

                </div>


                {{-- Save Button --}}

                <div class="flex items-center justify-end border-t border-slate-200 pt-6">

                    <button
                        type="submit"
                        class="inline-flex cursor-pointer items-center rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                    >
                        Save Platform Settings
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection