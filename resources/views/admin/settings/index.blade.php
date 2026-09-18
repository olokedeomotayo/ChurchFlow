@extends('layouts.admin')

@section('title', 'System Settings')

@section('page_title', 'System Settings')

@section('page_description', 'Manage ChurchFlow platform settings and configuration.')

@section('content')

    <div class="w-full space-y-6">

        {{-- Page Header --}}

        <div>

            <h1 class="text-2xl font-bold text-slate-900">
                System Settings
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Manage your ChurchFlow platform configuration.
            </p>

        </div>


        {{-- Settings Cards --}}

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">


            {{-- Platform Settings --}}

            <a
                href="{{ route('admin.settings.platform') }}"
                class="group cursor-pointer rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-purple-200 hover:shadow-md"
            >

                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-purple-50 text-lg text-purple-600">
                    ⚙
                </div>

                <h2 class="mt-5 text-base font-bold text-slate-900">
                    Platform Settings
                </h2>

                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Configure ChurchFlow name, contact information and general platform preferences.
                </p>

                <div class="mt-5 text-sm font-semibold text-purple-600 transition group-hover:text-purple-700">
                    Manage Settings →
                </div>

            </a>


            {{-- Subscription Settings --}}

            <a
                href="{{ route('admin.settings.subscription') }}"
                class="group cursor-pointer rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-purple-200 hover:shadow-md"
            >

                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-green-50 text-lg text-green-600">
                    ◉
                </div>

                <h2 class="mt-5 text-base font-bold text-slate-900">
                    Subscription Settings
                </h2>

                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Configure trials, billing behaviour and subscription defaults.
                </p>

                <div class="mt-5 text-sm font-semibold text-purple-600 transition group-hover:text-purple-700">
                    Manage Settings →
                </div>

            </a>


            {{-- Payment Settings --}}

            <a
                href="{{ route('admin.settings.payment') }}"
                class="group cursor-pointer rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-purple-200 hover:shadow-md"
            >

                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-blue-50 text-lg text-blue-600">
                    ₦
                </div>

                <h2 class="mt-5 text-base font-bold text-slate-900">
                    Payment Settings
                </h2>

                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Configure Paystack and other payment-related settings.
                </p>

                <div class="mt-5 text-sm font-semibold text-purple-600 transition group-hover:text-purple-700">
                    Manage Settings →
                </div>

            </a>


            {{-- Email Settings --}}

            <a
                href="{{ route('admin.settings.email') }}"
                class="group cursor-pointer rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-purple-200 hover:shadow-md"
            >

                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-amber-50 text-lg text-amber-600">
                    ✉
                </div>

                <h2 class="mt-5 text-base font-bold text-slate-900">
                    Email Settings
                </h2>

                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Configure platform email and notification preferences.
                </p>

                <div class="mt-5 text-sm font-semibold text-purple-600 transition group-hover:text-purple-700">
                    Manage Settings →
                </div>

            </a>


            {{-- Security Settings --}}

            <a
                href="{{ route('admin.settings.security') }}"
                class="group cursor-pointer rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-purple-200 hover:shadow-md"
            >

                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-red-50 text-lg text-red-600">
                    🔒
                </div>

                <h2 class="mt-5 text-base font-bold text-slate-900">
                    Security
                </h2>

                <p class="mt-2 text-sm leading-6 text-slate-500">
                    Manage authentication and platform security preferences.
                </p>

                <div class="mt-5 text-sm font-semibold text-purple-600 transition group-hover:text-purple-700">
                    Manage Settings →
                </div>

            </a>


            {{-- System Information --}}

            <a
                href="{{ route('admin.settings.system-information') }}"
                class="group cursor-pointer rounded-xl border border-slate-200 bg-slate-50 p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-purple-200 hover:shadow-md"
            >

                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-slate-200 text-lg text-slate-600">
                    ℹ
                </div>

                <h2 class="mt-5 text-base font-bold text-slate-900">
                    System Information
                </h2>

                <p class="mt-2 text-sm leading-6 text-slate-500">
                    View ChurchFlow application and environment information.
                </p>

                <div class="mt-5 text-sm font-semibold text-purple-600 transition group-hover:text-purple-700">
                    View Information →
                </div>

            </a>


        </div>

    </div>

@endsection