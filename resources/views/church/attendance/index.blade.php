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
                Record and track attendance across your church services.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">

            <a
                href="{{ route('church.attendance.template') }}"
                class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
            >
                Template
            </a>

            <a
                href="{{ route('church.attendance.import') }}"
                class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
            >
                Import
            </a>

            <a
                href="{{ route('church.attendance.export') }}"
                class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
            >
                Export
            </a>

            <a
                href="{{ route('church.attendance.create') }}"
                class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700"
            >
                <span class="text-lg leading-none">+</span>
                Record Attendance
            </a>

        </div>

    </div>


    {{-- SUMMARY CARDS --}}
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
                All recorded attendance
            </p>

        </div>


        {{-- Total Records --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

            <p class="text-sm font-medium text-slate-500">
                Attendance Records
            </p>

            <p class="mt-2 text-2xl font-bold text-purple-600">
                {{ number_format($totalServices) }}
            </p>

            <p class="mt-1 text-xs text-slate-500">
                Service attendance records
            </p>

        </div>


        {{-- Average --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

            <p class="text-sm font-medium text-slate-500">
                Average Attendance
            </p>

            <p class="mt-2 text-2xl font-bold text-green-600">
                {{ number_format($averageAttendance, 1) }}
            </p>

            <p class="mt-1 text-xs text-slate-500">
                Per attendance record
            </p>

        </div>


        {{-- Highest --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

            <p class="text-sm font-medium text-slate-500">
                Highest Attendance
            </p>

            @if($highestAttendance)

                <p class="mt-2 text-2xl font-bold text-slate-900">
                    {{ number_format($highestAttendance->total) }}
                </p>

                <p class="mt-1 truncate text-xs text-slate-500">
                    {{ $highestAttendance->service?->name ?? 'Service' }}
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
                Filter attendance records by service or date.
            </p>

        </div>


        <form
            method="GET"
            action="{{ route('church.attendance.index') }}"
        >

            <div class="grid gap-4 p-6 md:grid-cols-3 md:items-end">

                {{-- Service --}}
                <div>

                    <label
                        for="service_id"
                        class="block text-sm font-medium text-slate-700"
                    >
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

                            <option
                                value="{{ $service->id }}"
                                @selected(
                                    (string) request('service_id')
                                    ===
                                    (string) $service->id
                                )
                            >
                                {{ $service->name }}
                                @if($service->service_date)
                                    — {{ $service->service_date->format('d M Y') }}
                                @endif
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Date --}}
                <div>

                    <label
                        for="attendance_date"
                        class="block text-sm font-medium text-slate-700"
                    >
                        Attendance Date
                    </label>

                    <input
                        type="date"
                        id="attendance_date"
                        name="attendance_date"
                        value="{{ request('attendance_date') }}"
                        class="mt-2 block w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                    >

                </div>


                {{-- Actions --}}
                <div class="flex items-center gap-3">

                    <button
                        type="submit"
                        class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700"
                    >
                        Apply Filter
                    </button>

                    @if(
                        request()->filled('service_id')
                        ||
                        request()->filled('attendance_date')
                    )

                        <a
                            href="{{ route('church.attendance.index') }}"
                            class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                        >
                            Clear
                        </a>

                    @endif

                </div>

            </div>

        </form>

    </div>


    {{-- ATTENDANCE RECORDS --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="flex flex-col gap-3 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h2 class="text-base font-semibold text-slate-900">
                    Attendance Records
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Numerical attendance recorded for each church service.
                </p>

            </div>

        </div>


        @if($attendance->count())

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

                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Men
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Women
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Teenagers
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Children
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Guests
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Total
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100 bg-white">

                        @foreach($attendance as $record)

                            <tr class="transition hover:bg-slate-50">

                                {{-- SERVICE --}}
                                <td class="whitespace-nowrap px-6 py-4">

                                    <p class="text-sm font-semibold text-slate-900">
                                        {{ $record->service?->name ?? 'Unknown Service' }}
                                    </p>

                                </td>


                                {{-- DATE --}}
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">

                                    {{ $record->attendance_date?->format('d M Y') }}

                                </td>


                                {{-- MEN --}}
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-slate-700">

                                    {{ number_format($record->men) }}

                                </td>


                                {{-- WOMEN --}}
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-slate-700">

                                    {{ number_format($record->women) }}

                                </td>


                                {{-- TEENAGERS --}}
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-slate-700">

                                    {{ number_format($record->teenagers) }}

                                </td>


                                {{-- CHILDREN --}}
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-slate-700">

                                    {{ number_format($record->children) }}

                                </td>


                                {{-- GUESTS --}}
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm text-slate-700">

                                    {{ number_format($record->guests) }}

                                </td>


                                {{-- TOTAL --}}
                                <td class="whitespace-nowrap px-6 py-4 text-right">

                                    <span class="text-sm font-bold text-purple-600">
                                        {{ number_format($record->total) }}
                                    </span>

                                </td>


                                {{-- ACTIONS --}}
                                <td class="whitespace-nowrap px-6 py-4 text-right">

                                    <div class="flex items-center justify-end gap-2">

                                        <a
                                            href="{{ route('church.attendance.edit', $record) }}"
                                            class="inline-flex cursor-pointer items-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-medium text-slate-700 transition hover:bg-slate-50"
                                        >
                                            Edit
                                        </a>


                                        <form
                                            method="POST"
                                            action="{{ route('church.attendance.destroy', $record) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this attendance record?');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="inline-flex cursor-pointer items-center rounded-lg border border-red-200 bg-white px-3 py-2 text-xs font-medium text-red-600 transition hover:bg-red-50"
                                            >
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- PAGINATION --}}
            @if($attendance->hasPages())

                <div class="border-t border-slate-200 px-6 py-4">

                    {{ $attendance->links() }}

                </div>

            @endif


        @else

            {{-- EMPTY STATE --}}
            <div class="px-6 py-16 text-center">

                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-purple-50 text-purple-600">

                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 17v-2a4 4 0 014-4h1a4 4 0 014 4v2
                               M9 17H5a2 2 0 01-2-2v-1a4 4 0 014-4h1
                               M12 11a4 4 0 100-8 4 4 0 000 8z"
                        />

                    </svg>

                </div>


                <h3 class="mt-4 text-sm font-semibold text-slate-900">
                    No attendance records
                </h3>


                <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                    Start recording service attendance to see your church attendance history here.
                </p>


                <a
                    href="{{ route('church.attendance.create') }}"
                    class="mt-5 inline-flex cursor-pointer items-center gap-2 rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700"
                >
                    Record Attendance
                </a>

            </div>

        @endif

    </div>

</div>

@endsection