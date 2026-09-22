@extends('layouts.church')

@section('title', $service->name)

@section('content')

<div class="w-full space-y-6">

    {{-- HEADER --}}
    <div>
        <a href="{{ route('church.services.index') }}"
           class="inline-flex cursor-pointer items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-purple-600">
            <span>←</span>
            <span>Back to Services</span>
        </a>

        <div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

            <div>
                <div class="flex flex-wrap items-center gap-3">

                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                        {{ $service->name }}
                    </h1>

                    @if($service->status === 'scheduled')
                        <span class="rounded-full bg-purple-50 px-3 py-1 text-xs font-semibold text-purple-700">
                            Scheduled
                        </span>
                    @elseif($service->status === 'completed')
                        <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                            Completed
                        </span>
                    @else
                        <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                            Cancelled
                        </span>
                    @endif

                </div>

                <p class="mt-1 text-sm text-slate-500">
                    Service details and attendance information.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">

                @can('services.update')
                    <a href="{{ route('church.services.edit', $service) }}"
                       class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
                        Edit
                    </a>
                @endcan

            </div>
        </div>
    </div>


    {{-- OVERVIEW --}}
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

        {{-- SERVICE DATE --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">
                Service Date
            </p>

            <p class="mt-2 text-lg font-bold text-slate-900">
                {{ $service->service_date->format('d M Y') }}
            </p>
        </div>

        {{-- START TIME --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">
                Start Time
            </p>

            <p class="mt-2 text-lg font-bold text-slate-900">
                {{ $service->start_time?->format('g:i A') ?? 'Not set' }}
            </p>
        </div>

        {{-- END TIME --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">
                End Time
            </p>

            <p class="mt-2 text-lg font-bold text-slate-900">
                {{ $service->end_time?->format('g:i A') ?? 'Not set' }}
            </p>
        </div>

    </div>


    {{-- SERVICE DETAILS --}}
    <div class="grid gap-6 lg:grid-cols-3">

        {{-- SERVICE INFORMATION --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm lg:col-span-2">

            <div class="border-b border-slate-200 px-6 py-5">
                <h2 class="text-base font-semibold text-slate-900">
                    Service Information
                </h2>
            </div>

            <div class="p-6">

                @if($service->description)

                    <div>
                        <h3 class="text-sm font-semibold text-slate-700">
                            Description
                        </h3>

                        <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-600">
                            {{ $service->description }}
                        </p>
                    </div>

                @else

                    <p class="text-sm text-slate-500">
                        No description has been added for this service.
                    </p>

                @endif

            </div>

        </div>


        {{-- QUICK ACTIONS --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

            <h2 class="text-base font-semibold text-slate-900">
                Quick Actions
            </h2>

            <div class="mt-5 space-y-3">

                @can('services.update')
                    <a href="{{ route('church.services.edit', $service) }}"
                       class="flex cursor-pointer items-center justify-between rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                        <span>Edit Service</span>
                        <span>→</span>
                    </a>
                @endcan

                @can('attendance.view')
                    <a href="{{ route('church.attendance.index', ['service_id' => $service->id]) }}"
                       class="flex cursor-pointer items-center justify-between rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                        <span>View Attendance</span>
                        <span>→</span>
                    </a>
                @endcan

                <a href="{{ route('church.services.index') }}"
                   class="flex cursor-pointer items-center justify-between rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                    <span>All Services</span>
                    <span>→</span>
                </a>

            </div>

        </div>

    </div>


    {{-- ATTENDANCE --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="flex flex-col gap-3 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="text-base font-semibold text-slate-900">
                    Attendance
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Numerical attendance records for this service.
                </p>
            </div>

            @can('attendance.create')
                <a href="{{ route('church.attendance.create', ['service_id' => $service->id]) }}"
                   class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700">
                    Record Attendance
                </a>
            @endcan

        </div>

        <div class="px-6 py-10 text-center">

            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-purple-50 text-purple-600">

                <svg class="h-6 w-6"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M17 20h5v-2a4 4 0 00-4-4h-1
                             M9 20H4v-2a4 4 0 014-4h1
                             M12 12a4 4 0 100-8 4 4 0 000 8z"/>
                </svg>

            </div>

            <p class="mt-4 text-sm font-semibold text-slate-900">
                Attendance is recorded by category
            </p>

            <p class="mx-auto mt-1 max-w-xl text-sm leading-6 text-slate-500">
                Record the number of men, women, teenagers, children,
                and guests or first timers who attended this service.
            </p>

            @can('attendance.view')
                <div class="mt-5">
                    <a href="{{ route('church.attendance.index', ['service_id' => $service->id]) }}"
                       class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                        View Attendance Records
                    </a>
                </div>
            @endcan

        </div>

    </div>


    {{-- DELETE --}}
    @can('services.delete')
        <div class="flex justify-end">

            <button
                type="button"
                onclick="if (confirm('Are you sure you want to delete this service? This may also remove its associated attendance records.')) { document.getElementById('delete-service-form').submit(); }"
                class="cursor-pointer text-sm font-medium text-red-600 transition hover:text-red-700"
            >
                Delete Service
            </button>

        </div>

        <form id="delete-service-form"
              method="POST"
              action="{{ route('church.services.destroy', $service) }}"
              class="hidden">

            @csrf
            @method('DELETE')

        </form>
    @endcan

</div>

@endsection