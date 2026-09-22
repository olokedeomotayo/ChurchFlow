@extends('layouts.church')

@section('title', 'Record Attendance')

@section('content')

<div class="w-full space-y-6">

    {{-- PAGE HEADER --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Record Attendance
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Record the attendance count for a church service.
            </p>
        </div>

        <a
            href="{{ route('church.attendance.index') }}"
            class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50"
        >
            ← Back to Attendance
        </a>

    </div>


    {{-- VALIDATION ERRORS --}}
    @if ($errors->any())

        <div class="rounded-xl border border-red-200 bg-red-50 p-5">

            <div class="font-semibold text-red-800">
                Please correct the following errors:
            </div>

            <ul class="mt-2 list-inside list-disc text-sm text-red-700">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- FORM --}}
    <form
        method="POST"
        action="{{ route('church.attendance.store') }}"
        class="space-y-6"
    >

        @csrf


        {{-- SERVICE INFORMATION --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h2 class="text-base font-semibold text-slate-900">
                    Service Information
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Select the service and date for this attendance record.
                </p>

            </div>


            <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2">

                {{-- SERVICE --}}
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
                        required
                        class="mt-2 block w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                    >

                        <option value="">
                            Select a service
                        </option>

                        @foreach ($services as $service)

                            <option
                                value="{{ $service->id }}"
                                @selected(
                                    old('service_id') == $service->id
                                )
                            >
                                {{ $service->name }}

                                @if ($service->service_date)
                                    — {{ $service->service_date->format('d M Y') }}
                                @endif
                            </option>

                        @endforeach

                    </select>

                    @error('service_id')

                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- DATE --}}
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
                        value="{{ old(
                            'attendance_date',
                            now()->format('Y-m-d')
                        ) }}"
                        required
                        class="mt-2 block w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                    >

                    @error('attendance_date')

                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>

            </div>

        </div>


        {{-- ATTENDANCE COUNTS --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <h2 class="text-base font-semibold text-slate-900">
                        Attendance Count
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Enter the number of people in each category.
                    </p>

                </div>


                {{-- SMALL TOTAL --}}
                <div class="text-left sm:text-right">

                    <div class="text-xs font-medium uppercase tracking-wide text-slate-500">
                        Total
                    </div>

                    <div
                        id="attendance-total"
                        class="text-2xl font-bold text-purple-600"
                    >
                        0
                    </div>

                </div>

            </div>


            <div class="grid grid-cols-1 gap-5 p-6 sm:grid-cols-2 lg:grid-cols-3">

                {{-- MEN --}}
                <div>

                    <label
                        for="men"
                        class="block text-sm font-medium text-slate-700"
                    >
                        Men
                    </label>

                    <input
                        type="number"
                        id="men"
                        name="men"
                        value="{{ old('men', 0) }}"
                        min="0"
                        step="1"
                        required
                        class="attendance-count mt-2 block w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                    >

                    @error('men')

                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- WOMEN --}}
                <div>

                    <label
                        for="women"
                        class="block text-sm font-medium text-slate-700"
                    >
                        Women
                    </label>

                    <input
                        type="number"
                        id="women"
                        name="women"
                        value="{{ old('women', 0) }}"
                        min="0"
                        step="1"
                        required
                        class="attendance-count mt-2 block w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                    >

                    @error('women')

                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- TEENAGERS --}}
                <div>

                    <label
                        for="teenagers"
                        class="block text-sm font-medium text-slate-700"
                    >
                        Teenagers
                    </label>

                    <input
                        type="number"
                        id="teenagers"
                        name="teenagers"
                        value="{{ old('teenagers', 0) }}"
                        min="0"
                        step="1"
                        required
                        class="attendance-count mt-2 block w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                    >

                    @error('teenagers')

                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- CHILDREN --}}
                <div>

                    <label
                        for="children"
                        class="block text-sm font-medium text-slate-700"
                    >
                        Children
                    </label>

                    <input
                        type="number"
                        id="children"
                        name="children"
                        value="{{ old('children', 0) }}"
                        min="0"
                        step="1"
                        required
                        class="attendance-count mt-2 block w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                    >

                    @error('children')

                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- GUESTS --}}
                <div>

                    <label
                        for="guests"
                        class="block text-sm font-medium text-slate-700"
                    >
                        Guests / First Timers
                    </label>

                    <input
                        type="number"
                        id="guests"
                        name="guests"
                        value="{{ old('guests', 0) }}"
                        min="0"
                        step="1"
                        required
                        class="attendance-count mt-2 block w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                    >

                    @error('guests')

                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>

            </div>


            {{-- TOTAL --}}
            <div class="border-t border-slate-200 px-6 py-5">

                <div class="flex items-center justify-between rounded-lg border border-slate-200 bg-slate-50 p-5">

                    <span class="font-medium text-slate-700">
                        Total Attendance
                    </span>

                    <span
                        id="attendance-total-large"
                        class="text-3xl font-bold text-slate-900"
                    >
                        0
                    </span>

                </div>

            </div>

        </div>


        {{-- NOTES --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h2 class="text-base font-semibold text-slate-900">
                    Notes
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Add any optional notes about this service.
                </p>

            </div>


            <div class="p-6">

                <textarea
                    id="notes"
                    name="notes"
                    rows="4"
                    placeholder="Optional notes about this service..."
                    class="block w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                >{{ old('notes') }}</textarea>

                @error('notes')

                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>

                @enderror

            </div>

        </div>


        {{-- ACTIONS --}}
        <div class="flex items-center justify-end gap-3">

            <a
                href="{{ route('church.attendance.index') }}"
                class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-purple-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700"
            >
                Save Attendance
            </button>

        </div>

    </form>

</div>


{{-- AUTOMATIC TOTAL --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const fields = document.querySelectorAll(
            '.attendance-count'
        );

        const totalSmall = document.getElementById(
            'attendance-total'
        );

        const totalLarge = document.getElementById(
            'attendance-total-large'
        );

        function calculateTotal() {

            let total = 0;

            fields.forEach(function (field) {

                const value = parseInt(
                    field.value,
                    10
                );

                if (!isNaN(value) && value >= 0) {
                    total += value;
                }

            });

            totalSmall.textContent = total;
            totalLarge.textContent = total;
        }

        fields.forEach(function (field) {

            field.addEventListener(
                'input',
                calculateTotal
            );

        });

        calculateTotal();

    });
</script>

@endsection