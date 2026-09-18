@extends('layouts.admin')

@section('title', 'Email Settings')

@section('page_title', 'Email Settings')

@section('page_description', 'Configure ChurchFlow email and notification settings.')

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
                    Email Settings
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Configure the sender information used by ChurchFlow.
                </p>

            </div>


            <a
                href="{{ route('admin.settings.index') }}"
                class="inline-flex w-fit cursor-pointer items-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
            >
                ← Back to Settings
            </a>

        </div>


        {{-- Email Configuration --}}

        <div class="w-full overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h3 class="text-base font-bold text-slate-900">
                    Email Configuration
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Configure the name and email address used when ChurchFlow sends emails.
                </p>

            </div>


            <form
                method="POST"
                action="{{ route('admin.settings.email.update') }}"
                class="space-y-6 p-6"
            >

                @csrf


                {{-- Mail From Name --}}

                <div>

                    <label
                        for="mail_from_name"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Sender Name
                    </label>

                    <input
                        type="text"
                        id="mail_from_name"
                        name="mail_from_name"
                        value="{{ old('mail_from_name', $settings['mail_from_name'] ?? 'ChurchFlow') }}"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        placeholder="ChurchFlow"
                    >

                    <p class="mt-1.5 text-xs text-slate-500">
                        The name recipients will see when they receive an email from ChurchFlow.
                    </p>

                </div>


                {{-- Mail From Address --}}

                <div>

                    <label
                        for="mail_from_address"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Sender Email Address
                    </label>

                    <input
                        type="email"
                        id="mail_from_address"
                        name="mail_from_address"
                        value="{{ old('mail_from_address', $settings['mail_from_address'] ?? 'info@techcrossbreed.com.ng') }}"
                        class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        placeholder="info@example.com"
                    >

                    <p class="mt-1.5 text-xs text-slate-500">
                        The email address ChurchFlow will use as the sender.
                    </p>

                </div>


                {{-- Information Notice --}}

                <div class="rounded-lg border border-blue-200 bg-blue-50 px-5 py-4">

                    <div class="flex gap-3">

                        <div class="text-blue-600">
                            ℹ
                        </div>

                        <div>

                            <p class="text-sm font-semibold text-blue-900">
                                Email delivery
                            </p>

                            <p class="mt-1 text-xs leading-5 text-blue-700">
                                These settings control the sender information. Actual email delivery will depend on the mail service configured for the application.
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
                        Save Email Settings
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection