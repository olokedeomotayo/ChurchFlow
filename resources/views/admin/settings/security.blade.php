@extends('layouts.admin')

@section('title', 'Security Settings')

@section('page_title', 'Security Settings')

@section('page_description', 'Manage ChurchFlow authentication and platform security settings.')

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

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- Page Header --}}

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h2 class="text-xl font-bold text-slate-900">
                    Security Settings
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Manage authentication and security preferences for the ChurchFlow platform.
                </p>

            </div>


            <a
                href="{{ route('admin.settings.index') }}"
                class="inline-flex w-fit cursor-pointer items-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
            >
                ← Back to Settings
            </a>

        </div>


        {{-- Authentication Security --}}

        <div class="w-full overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h3 class="text-base font-bold text-slate-900">
                    Authentication Security
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Configure how users authenticate and access ChurchFlow.
                </p>

            </div>


            <form
                method="POST"
                action="{{ route('admin.settings.security.update') }}"
                class="space-y-6 p-6"
            >

                @csrf


                {{-- Two Factor Authentication --}}

                <div class="rounded-lg border border-slate-200 bg-slate-50 p-5">

                    <div class="flex items-start gap-4">

                        <div class="pt-0.5">

                            <input
                                type="checkbox"
                                id="two_factor_authentication"
                                name="two_factor_authentication"
                                value="1"
                                {{ ($settings['two_factor_authentication'] ?? '0') == '1' ? 'checked' : '' }}
                                class="h-4 w-4 cursor-pointer rounded border-slate-300 text-purple-600 focus:ring-purple-500"
                            >

                        </div>

                        <div>

                            <label
                                for="two_factor_authentication"
                                class="cursor-pointer text-sm font-semibold text-slate-900"
                            >
                                Enable Two-Factor Authentication
                            </label>

                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                Add an additional authentication layer to protect ChurchFlow accounts.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Login Protection --}}

                <div class="rounded-lg border border-slate-200 bg-slate-50 p-5">

                    <div class="flex items-start gap-4">

                        <div class="pt-0.5">

                            <input
                                type="checkbox"
                                id="login_protection"
                                name="login_protection"
                                value="1"
                                {{ ($settings['login_protection'] ?? '1') == '1' ? 'checked' : '' }}
                                class="h-4 w-4 cursor-pointer rounded border-slate-300 text-purple-600 focus:ring-purple-500"
                            >

                        </div>

                        <div>

                            <label
                                for="login_protection"
                                class="cursor-pointer text-sm font-semibold text-slate-900"
                            >
                                Enable Login Protection
                            </label>

                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                Protect accounts against repeated unsuccessful login attempts.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Session Timeout --}}

                <div>

                    <label
                        for="session_timeout"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Session Timeout
                    </label>

                    <select
                        id="session_timeout"
                        name="session_timeout"
                        class="w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                    >

                        <option value="30"
                            {{ ($settings['session_timeout'] ?? '60') == '30' ? 'selected' : '' }}>
                            30 Minutes
                        </option>

                        <option value="60"
                            {{ ($settings['session_timeout'] ?? '60') == '60' ? 'selected' : '' }}>
                            1 Hour
                        </option>

                        <option value="120"
                            {{ ($settings['session_timeout'] ?? '60') == '120' ? 'selected' : '' }}>
                            2 Hours
                        </option>

                        <option value="240"
                            {{ ($settings['session_timeout'] ?? '60') == '240' ? 'selected' : '' }}>
                            4 Hours
                        </option>

                        <option value="480"
                            {{ ($settings['session_timeout'] ?? '60') == '480' ? 'selected' : '' }}>
                            8 Hours
                        </option>

                    </select>

                    <p class="mt-1.5 text-xs text-slate-500">
                        The amount of inactivity before a user session expires.
                    </p>

                </div>


                {{-- Password Policy --}}

                <div>

                    <label
                        for="minimum_password_length"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Minimum Password Length
                    </label>

                    <input
                        type="number"
                        id="minimum_password_length"
                        name="minimum_password_length"
                        min="6"
                        max="32"
                        value="{{ old('minimum_password_length', $settings['minimum_password_length'] ?? '8') }}"
                        class="w-full cursor-text rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                    >

                    <p class="mt-1.5 text-xs text-slate-500">
                        Minimum number of characters required for user passwords.
                    </p>

                </div>


                {{-- Force Password Reset --}}

                <div class="rounded-lg border border-slate-200 bg-slate-50 p-5">

                    <div class="flex items-start gap-4">

                        <div class="pt-0.5">

                            <input
                                type="checkbox"
                                id="force_password_reset"
                                name="force_password_reset"
                                value="1"
                                {{ ($settings['force_password_reset'] ?? '0') == '1' ? 'checked' : '' }}
                                class="h-4 w-4 cursor-pointer rounded border-slate-300 text-purple-600 focus:ring-purple-500"
                            >

                        </div>

                        <div>

                            <label
                                for="force_password_reset"
                                class="cursor-pointer text-sm font-semibold text-slate-900"
                            >
                                Force Password Reset
                            </label>

                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                Require users to reset their passwords when this security policy is enabled.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Security Notice --}}

                <div class="rounded-lg border border-amber-200 bg-amber-50 px-5 py-4">

                    <div class="flex gap-3">

                        <div class="text-amber-600">
                            ⚠
                        </div>

                        <div>

                            <p class="text-sm font-semibold text-amber-900">
                                Security notice
                            </p>

                            <p class="mt-1 text-xs leading-5 text-amber-700">
                                Changes to these settings can affect how administrators, church users and other platform users access ChurchFlow.
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
                        Save Security Settings
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection