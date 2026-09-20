@extends('layouts.church')

@section('title', 'Attendance')

@section('content')

<div class="w-full space-y-6">

    {{-- PAGE HEADER --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Attendance
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                View and track member attendance across your church services.
            </p>
        </div>

        <a href="{{ route('church.checkin.index') }}"
           class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700">
            <span class="text-lg leading-none">+</span>
            Check In Member
        </a>
    </div>

    {{-- SUMMARY --}}
<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

    {{-- Total Attendance --}}
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <p class="text-sm font-medium text-slate-500">
            Total Attendance
        </p>

        <p class="mt-2 text-2xl font-bold text-slate-900">
            {{ number_format($totalAttendance) }}
        </p>

        <p class="mt-1 text-xs text-slate-500">
            All recorded check-ins
        </p>
    </div>

    {{-- Total Services --}}
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <p class="text-sm font-medium text-slate-500">
            Total Services
        </p>

        <p class="mt-2 text-2xl font-bold text-purple-600">
            {{ number_format($totalServices) }}
        </p>

        <p class="mt-1 text-xs text-slate-500">
            Services created
        </p>
    </div>

    {{-- Average Attendance --}}
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <p class="text-sm font-medium text-slate-500">
            Average Attendance
        </p>

        <p class="mt-2 text-2xl font-bold text-green-600">
            {{ number_format($averageAttendance, 1) }}
        </p>

        <p class="mt-1 text-xs text-slate-500">
            Per service
        </p>
    </div>

    {{-- Highest Attendance --}}
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

        <p class="text-sm font-medium text-slate-500">
            Highest Attendance
        </p>

        @if($highestAttendanceService)

            <p class="mt-2 text-2xl font-bold text-slate-900">
                {{ number_format($highestAttendanceService->attendances_count) }}
            </p>

            <p class="mt-1 truncate text-xs text-slate-500">
                {{ $highestAttendanceService->name }}
            </p>

        @else

            <p class="mt-2 text-2xl font-bold text-slate-400">
                0
            </p>

            <p class="mt-1 text-xs text-slate-500">
                No attendance yet
            </p>

        @endif

    </div>

</div>

    {{-- FILTER --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">
            <h2 class="text-base font-semibold text-slate-900">
                Filter Attendance
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Filter attendance records by service.
            </p>
        </div>

        <form method="GET"
              action="{{ route('church.attendance.index') }}">

            <div class="flex flex-col gap-4 p-6 sm:flex-row sm:items-end">

                <div class="w-full sm:max-w-md">
                    <label for="service_id"
                           class="block text-sm font-medium text-slate-700">
                        Service
                    </label>

                    <select
                        id="service_id"
                        name="service_id"
                        class="mt-2 block w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                    >
                        <option value="">
                            All Services
                        </option>

                        @foreach($services as $service)
                            <option value="{{ $service->id }}"
                                @selected((string) request('service_id') === (string) $service->id)>
                                {{ $service->name }}
                                — {{ $service->service_date->format('d M Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-3">

                    <button type="submit"
                            class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700">
                        Apply Filter
                    </button>

                    @if(request()->filled('service_id'))
                        <a href="{{ route('church.attendance.index') }}"
                           class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                            Clear
                        </a>
                    @endif

                </div>

            </div>

        </form>

    </div>

    {{-- SERVICE ATTENDANCE BREAKDOWN --}}
<div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

    <div class="border-b border-slate-200 px-6 py-5">
        <h2 class="text-base font-semibold text-slate-900">
            Attendance by Service
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Attendance recorded for each church service.
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
                            Status
                        </th>

                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Attendance
                        </th>

                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Action
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 bg-white">

                    @foreach($services as $service)

                        <tr class="transition hover:bg-slate-50">

                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-slate-900">
                                    {{ $service->name }}
                                </p>
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                {{ $service->service_date->format('d M Y') }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4">

                                @if($service->status === 'scheduled')

                                    <span class="rounded-full bg-purple-50 px-2.5 py-1 text-xs font-semibold text-purple-700">
                                        Scheduled
                                    </span>

                                @elseif($service->status === 'completed')

                                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                        Completed
                                    </span>

                                @else

                                    <span class="rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700">
                                        Cancelled
                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-4 text-right">

                                <span class="text-sm font-bold text-slate-900">
                                    {{ number_format($service->attendances_count) }}
                                </span>

                            </td>

                            <td class="px-6 py-4 text-right">

                                <a
                                    href="{{ route('church.services.show', $service) }}"
                                    class="inline-flex cursor-pointer items-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-50"
                                >
                                    View
                                </a>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="px-6 py-12 text-center">
            <p class="text-sm text-slate-500">
                No services have been created yet.
            </p>
        </div>

    @endif

</div>

    {{-- ATTENDANCE TABLE --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">
            <h2 class="text-base font-semibold text-slate-900">
                Attendance Records
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Members who have checked in for church services.
            </p>
        </div>

        @if($attendance->count())

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-slate-200">

                    <thead class="bg-slate-50">
                        <tr>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Member
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Service
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Date
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Check-In Time
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Status
                            </th>

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 bg-white">

                        @foreach($attendance as $record)

                            <tr class="transition hover:bg-slate-50">

                                {{-- MEMBER --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-purple-50 text-sm font-bold text-purple-600">
                                            {{ strtoupper(substr($record->member->first_name, 0, 1)) }}
                                        </div>

                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">
                                                {{ $record->member->first_name }}
                                                @if($record->member->middle_name)
                                                    {{ $record->member->middle_name }}
                                                @endif
                                                {{ $record->member->last_name }}
                                            </p>

                                            @if($record->member->phone)
                                                <p class="mt-1 text-xs text-slate-500">
                                                    {{ $record->member->phone }}
                                                </p>
                                            @endif
                                        </div>

                                    </div>

                                </td>

                                {{-- SERVICE --}}
                                <td class="whitespace-nowrap px-6 py-4">
                                    <p class="text-sm font-medium text-slate-900">
                                        {{ $record->service->name }}
                                    </p>
                                </td>

                                {{-- DATE --}}
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                    {{ $record->service->service_date->format('d M Y') }}
                                </td>

                                {{-- CHECK-IN --}}
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                    {{ $record->checked_in_at?->format('d M Y, g:i A') ?? '—' }}
                                </td>

                                {{-- STATUS --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    @if($record->status === 'present')

                                        <span class="inline-flex rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                            Present
                                        </span>

                                    @elseif($record->status === 'absent')

                                        <span class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700">
                                            Absent
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                            {{ ucfirst($record->status) }}
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            @if($attendance->hasPages())
                <div class="border-t border-slate-200 px-6 py-4">
                    {{ $attendance->links() }}
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
                              d="M17 20h5v-2a4 4 0 00-4-4h-1
                                 M9 20H4v-2a4 4 0 014-4h1
                                 M12 12a4 4 0 100-8 4 4 0 000 8z"/>

                    </svg>

                </div>

                <h3 class="mt-4 text-sm font-semibold text-slate-900">
                    No attendance records
                </h3>

                <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                    Attendance records will appear here when members are checked into a service.
                </p>

                <a href="{{ route('church.checkin.index') }}"
                   class="mt-5 inline-flex cursor-pointer items-center gap-2 rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700">
                    Check In Member
                </a>

            </div>

        @endif

    </div>

</div>

@endsection