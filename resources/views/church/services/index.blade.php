@extends('layouts.church')

@section('title', 'Services')

@section('content')

<div class="w-full space-y-6">

    {{-- PAGE HEADER --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Services
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Create and manage your church services and gatherings.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">

            {{-- IMPORT --}}
            <a href="{{ route('church.services.import') }}"
               class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">

                <svg class="h-4 w-4"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M7 16V4m0 0L3 8m4-4l4 4M17 8v12m0 0l-4-4m4 4l4-4"/>
                </svg>

                Import
            </a>

            {{-- EXPORT --}}
            <a href="{{ route('church.services.export') }}"
               class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">

                <svg class="h-4 w-4"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14"/>
                </svg>

                Export
            </a>

            {{-- TEMPLATE --}}
            <a href="{{ route('church.services.import.template') }}"
               class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">

                <svg class="h-4 w-4"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414A1 1 0 0118 8.414V19a2 2 0 01-2 2z"/>
                </svg>

                Template
            </a>

            {{-- CREATE --}}
            <a href="{{ route('church.services.create') }}"
               class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700">

                <span class="text-lg leading-none">+</span>

                Create Service
            </a>

        </div>

    </div>

    {{-- ALERTS --}}
    @if(session('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    {{-- IMPORT ERRORS --}}
    @if(session('import_errors'))
        <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-4 text-sm text-amber-800">

            <p class="font-semibold">
                Some rows could not be imported:
            </p>

            <ul class="mt-2 list-disc space-y-1 pl-5">
                @foreach(session('import_errors') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif

    {{-- SUMMARY --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

        {{-- TOTAL --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

            <p class="text-sm font-medium text-slate-500">
                Total Services
            </p>

            <p class="mt-2 text-2xl font-bold text-slate-900">
                {{ $services->total() }}
            </p>

        </div>

        {{-- SCHEDULED --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

            <p class="text-sm font-medium text-slate-500">
                Scheduled
            </p>

            <p class="mt-2 text-2xl font-bold text-purple-600">
                {{ $services->getCollection()->where('status', 'scheduled')->count() }}
            </p>

        </div>

        {{-- COMPLETED --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

            <p class="text-sm font-medium text-slate-500">
                Completed
            </p>

            <p class="mt-2 text-2xl font-bold text-green-600">
                {{ $services->getCollection()->where('status', 'completed')->count() }}
            </p>

        </div>

    </div>

    {{-- SERVICES TABLE --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">

            <h2 class="text-base font-semibold text-slate-900">
                Service List
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                All services belonging to your church.
            </p>

        </div>

        @if($services->count())

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-slate-200">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Service
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Date
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Time
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Status
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100 bg-white">

                        @foreach($services as $service)

                            <tr class="transition hover:bg-slate-50">

                                {{-- SERVICE --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <div>

                                        <p class="text-sm font-semibold text-slate-900">
                                            {{ $service->name }}
                                        </p>

                                        @if($service->description)

                                            <p class="mt-1 max-w-md truncate text-xs text-slate-500">
                                                {{ $service->description }}
                                            </p>

                                        @endif

                                    </div>

                                </td>

                                {{-- DATE --}}
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">

                                    {{ $service->service_date->format('d M Y') }}

                                </td>

                                {{-- TIME --}}
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">

                                    @if($service->start_time)

                                        {{ $service->start_time->format('g:i A') }}

                                        @if($service->end_time)
                                            – {{ $service->end_time->format('g:i A') }}
                                        @endif

                                    @else

                                        <span class="text-slate-400">
                                            Not specified
                                        </span>

                                    @endif

                                </td>

                                {{-- STATUS --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    @if($service->status === 'scheduled')

                                        <span class="inline-flex rounded-full bg-purple-50 px-2.5 py-1 text-xs font-semibold text-purple-700">
                                            Scheduled
                                        </span>

                                    @elseif($service->status === 'completed')

                                        <span class="inline-flex rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                            Completed
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700">
                                            Cancelled
                                        </span>

                                    @endif

                                </td>

                                {{-- ACTIONS --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <div class="flex items-center justify-end gap-2">

                                        <a href="{{ route('church.services.show', $service) }}"
                                           class="inline-flex cursor-pointer items-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-50">
                                            View
                                        </a>

                                        <a href="{{ route('church.services.edit', $service) }}"
                                           class="inline-flex cursor-pointer items-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-50">
                                            Edit
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            {{-- PAGINATION --}}
            @if($services->hasPages())

                <div class="border-t border-slate-200 px-6 py-4">
                    {{ $services->links() }}
                </div>

            @endif

        @else

            {{-- EMPTY STATE --}}
            <div class="px-6 py-16 text-center">

                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-purple-50 text-purple-600">

                    <svg class="h-6 w-6"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>

                    </svg>

                </div>

                <h3 class="mt-4 text-sm font-semibold text-slate-900">
                    No services yet
                </h3>

                <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                    Create your first church service to start managing attendance.
                </p>

                <a href="{{ route('church.services.create') }}"
                   class="mt-5 inline-flex cursor-pointer items-center gap-2 rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700">

                    <span class="text-lg leading-none">+</span>

                    Create Service

                </a>

            </div>

        @endif

    </div>

</div>

@endsection