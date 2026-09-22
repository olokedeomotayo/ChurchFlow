@extends('layouts.church')

@section('title', 'Edit Attendance')

@section('content')

<div class="max-w-4xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Edit Attendance
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Update the attendance count for this service.
            </p>
        </div>

        <a
            href="{{ route('church.attendance.index') }}"
            class="inline-flex cursor-pointer items-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
        >
            ← Back to Attendance
        </a>

    </div>


    {{-- VALIDATION ERRORS --}}
    @if ($errors->any())

        <div class="rounded-lg border border-red-200 bg-red-50 p-4">

            <div class="font-semibold text-red-800">
                Please correct the following errors:
            </div>

            <ul class="mt-2 list-inside list-disc text-sm text-red-700">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    {{-- FORM --}}
    <form
        method="POST"
        action="{{ route('church.attendance.update', $attendance) }}"
        class="space-y-6"
    >

        @csrf
        @method('PUT')


        {{-- SERVICE INFORMATION --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

            <h2 class="text-lg font-semibold text-slate-900">
                Service Information
            </h2>

            <div class="mt-5 grid grid-cols-1 gap-6 md:grid-cols-2">

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
                        class="mt-2 w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                    >

                        <option value="">
                            Select a service
                        </option>

                        @foreach ($services as $service)

                            <option
                                value="{{ $service->id }}"
                                @selected(
                                    old(
                                        'service_id',
                                        $attendance->service_id
                                    ) == $service->id
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
                            $attendance->attendance_date?->format('Y-m-d')
                        ) }}"
                        required
                        class="mt-2 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
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
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex items-center justify-between">

                <div>

                    <h2 class="text-lg font-semibold text-slate-900">
                        Attendance Count
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Update the number of people in each category.
                    </p>

                </div>


                <div class="text-right">

                    <div class="text-xs font-medium uppercase text-slate-500">
                        Total
                    </div>

                    <div
                        id="attendance-total"
                        class="text-2xl font-bold text-purple-600"
                    >
                        {{ $attendance->total }}
                    </div>

                </div>

            </div>


            <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">

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
                        value="{{ old('men', $attendance->men) }}"
                        min="0"
                        step="1"
                        required
                        class="attendance-count mt-2 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
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
                        value="{{ old('women', $attendance->women) }}"
                        min="0"
                        step="1"
                        required
                        class="attendance-count mt-2 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
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
                        value="{{ old('teenagers', $attendance->teenagers) }}"
                        min="0"
                        step="1"
                        required
                        class="attendance-count mt-2 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
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
                        value="{{ old('children', $attendance->children) }}"
                        min="0"
                        step="1"
                        required
                        class="attendance-count mt-2 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
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
                        value="{{ old('guests', $attendance->guests) }}"
                        min="0"
                        step="1"
                        required
                        class="attendance-count mt-2 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                    >

                    @error('guests')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>


            {{-- TOTAL --}}
            <div class="mt-6 rounded-lg border border-slate-200 bg-slate-50 p-5">

                <div class="flex items-center justify-between">

                    <span class="font-medium text-slate-700">
                        Total Attendance
                    </span>

                    <span
                        id="attendance-total-large"
                        class="text-3xl font-bold text-slate-900"
                    >
                        {{ $attendance->total }}
                    </span>

                </div>

            </div>

        </div>


        {{-- NOTES --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

            <label
                for="notes"
                class="block text-sm font-medium text-slate-700"
            >
                Notes
            </label>

            <textarea
                id="notes"
                name="notes"
                rows="4"
                placeholder="Optional notes about this service..."
                class="mt-2 w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
            >{{ old('notes', $attendance->notes) }}</textarea>

            @error('notes')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- ACTIONS --}}
        <div class="flex items-center justify-end gap-3">

            <a
                href="{{ route('church.attendance.index') }}"
                class="inline-flex cursor-pointer items-center rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="inline-flex cursor-pointer items-center rounded-lg bg-purple-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-purple-700"
            >
                Update Attendance
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