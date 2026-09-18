@extends('layouts.admin')

@section('title', 'System Information')

@section('page_title', 'System Information')

@section('page_description', 'View ChurchFlow application and environment information.')

@section('content')

    <div class="w-full space-y-6">

        {{-- Page Header --}}

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h2 class="text-xl font-bold text-slate-900">
                    System Information
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    View important information about the ChurchFlow application and environment.
                </p>

            </div>

            <a
                href="{{ route('admin.settings.index') }}"
                class="inline-flex w-fit cursor-pointer items-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
            >
                ← Back to Settings
            </a>

        </div>


        {{-- Application Information --}}

        <div class="w-full overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h3 class="text-base font-bold text-slate-900">
                    Application Information
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    General information about the ChurchFlow installation.
                </p>

            </div>


            <div class="divide-y divide-slate-200">

                {{-- Application Name --}}

                <div class="flex flex-col gap-2 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <p class="text-sm font-semibold text-slate-700">
                            Application
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            Platform name
                        </p>

                    </div>

                    <span class="text-sm font-medium text-slate-900">
                        {{ config('app.name', 'ChurchFlow') }}
                    </span>

                </div>


                {{-- Application URL --}}

                <div class="flex flex-col gap-2 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <p class="text-sm font-semibold text-slate-700">
                            Application URL
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            Current application address
                        </p>

                    </div>

                    <span class="break-all text-sm font-medium text-slate-900">
                        {{ config('app.url') }}
                    </span>

                </div>


                {{-- Environment --}}

                <div class="flex flex-col gap-2 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <p class="text-sm font-semibold text-slate-700">
                            Environment
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            Current application environment
                        </p>

                    </div>

                    <span
                        class="inline-flex w-fit rounded-full px-3 py-1 text-xs font-semibold
                        {{ app()->environment('production')
                            ? 'bg-green-100 text-green-700'
                            : 'bg-amber-100 text-amber-700' }}"
                    >
                        {{ app()->environment() }}
                    </span>

                </div>


                {{-- Debug Mode --}}

                <div class="flex flex-col gap-2 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <p class="text-sm font-semibold text-slate-700">
                            Debug Mode
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            Application debugging status
                        </p>

                    </div>

                    @if (config('app.debug'))

                        <span class="inline-flex w-fit rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                            Enabled
                        </span>

                    @else

                        <span class="inline-flex w-fit rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                            Disabled
                        </span>

                    @endif

                </div>


                {{-- Laravel Version --}}

                <div class="flex flex-col gap-2 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <p class="text-sm font-semibold text-slate-700">
                            Laravel Version
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            Framework version
                        </p>

                    </div>

                    <span class="text-sm font-medium text-slate-900">
                        {{ app()->version() }}
                    </span>

                </div>


                {{-- PHP Version --}}

                <div class="flex flex-col gap-2 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <p class="text-sm font-semibold text-slate-700">
                            PHP Version
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            PHP runtime version
                        </p>

                    </div>

                    <span class="text-sm font-medium text-slate-900">
                        {{ PHP_VERSION }}
                    </span>

                </div>


                {{-- Database --}}

                <div class="flex flex-col gap-2 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <p class="text-sm font-semibold text-slate-700">
                            Database
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            Active database connection
                        </p>

                    </div>

                    <span class="inline-flex w-fit rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold uppercase text-blue-700">
                        {{ config('database.default') }}
                    </span>

                </div>


                {{-- Timezone --}}

                <div class="flex flex-col gap-2 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <p class="text-sm font-semibold text-slate-700">
                            Application Timezone
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            Default timezone configured for ChurchFlow
                        </p>

                    </div>

                    <span class="text-sm font-medium text-slate-900">
                        {{ config('app.timezone') }}
                    </span>

                </div>

            </div>

        </div>


        {{-- System Status --}}

        <div class="w-full overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h3 class="text-base font-bold text-slate-900">
                    System Status
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Current ChurchFlow application status.
                </p>

            </div>


            <div class="space-y-4 p-6">

                {{-- Application Status --}}

                <div class="flex flex-col gap-3 rounded-lg border border-green-200 bg-green-50 px-4 py-4 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <p class="text-sm font-semibold text-green-800">
                            Application Status
                        </p>

                        <p class="mt-1 text-xs text-green-700">
                            ChurchFlow is running normally.
                        </p>

                    </div>

                    <span class="inline-flex w-fit rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                        Operational
                    </span>

                </div>


                {{-- Environment Status --}}

                <div class="flex flex-col gap-3 rounded-lg border border-slate-200 bg-slate-50 px-4 py-4 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <p class="text-sm font-semibold text-slate-800">
                            Environment
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            Current environment configuration.
                        </p>

                    </div>

                    <span class="inline-flex w-fit rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold capitalize text-slate-700">
                        {{ app()->environment() }}
                    </span>

                </div>


                {{-- Debug Status --}}

                <div class="flex flex-col gap-3 rounded-lg border px-4 py-4 sm:flex-row sm:items-center sm:justify-between
                    {{ config('app.debug')
                        ? 'border-red-200 bg-red-50'
                        : 'border-green-200 bg-green-50' }}"
                >

                    <div>

                        <p class="text-sm font-semibold
                            {{ config('app.debug')
                                ? 'text-red-800'
                                : 'text-green-800' }}"
                        >
                            Debug Mode
                        </p>

                        <p class="mt-1 text-xs
                            {{ config('app.debug')
                                ? 'text-red-700'
                                : 'text-green-700' }}"
                        >
                            Debug mode should normally be disabled in production.
                        </p>

                    </div>

                    @if (config('app.debug'))

                        <span class="inline-flex w-fit rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                            Enabled
                        </span>

                    @else

                        <span class="inline-flex w-fit rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                            Disabled
                        </span>

                    @endif

                </div>

            </div>

        </div>


        {{-- Platform Notice --}}

        <div class="rounded-lg border border-blue-200 bg-blue-50 px-5 py-4">

            <div class="flex gap-3">

                <div class="text-blue-600">
                    ℹ
                </div>

                <div>

                    <p class="text-sm font-semibold text-blue-900">
                        System information
                    </p>

                    <p class="mt-1 text-xs leading-5 text-blue-700">
                        This page provides read-only information about the current ChurchFlow installation and environment.
                    </p>

                </div>

            </div>

        </div>

    </div>

@endsection