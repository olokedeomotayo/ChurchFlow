@extends('layouts.church')

@section('title', 'Import Attendance')

@section('content')

<div class="w-full space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                Import Attendance
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Import attendance records from a CSV file.
            </p>
        </div>

        <a
            href="{{ route('church.attendance.index') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 cursor-pointer"
        >
            <svg
                class="h-4 w-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M10 19l-7-7m0 0l7-7m-7 7h18"
                />
            </svg>

            Back to Attendance
        </a>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 p-4">
            <div class="flex items-start gap-3">
                <svg
                    class="mt-0.5 h-5 w-5 flex-shrink-0 text-red-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4m0 4h.01M10.29 3.86l-7.82 13a2 2 0 001.71 3.14h15.64a2 2 0 001.71-3.14l-7.82-13a2 2 0 00-3.42 0z"
                    />
                </svg>

                <div>
                    <h3 class="text-sm font-semibold text-red-800">
                        Please correct the following errors:
                    </h3>

                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Success Message --}}
    @if (session('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 p-4">
            <div class="flex items-center gap-3">
                <svg
                    class="h-5 w-5 text-green-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 13l4 4L19 7"
                    />
                </svg>

                <p class="text-sm font-medium text-green-800">
                    {{ session('success') }}
                </p>
            </div>
        </div>
    @endif

    {{-- Import Warnings --}}
@if (session('import_warnings'))
    <div class="rounded-lg border border-amber-200 bg-amber-50 p-4">
        <div class="flex items-start gap-3">

            <svg
                class="mt-0.5 h-5 w-5 flex-shrink-0 text-amber-600"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 9v2m0 4h.01M10.29 3.86l-7.82 13a2 2 0 001.71 3.14h15.64a2 2 0 001.71-3.14l-7.82-13a2 2 0 00-3.42 0z"
                />
            </svg>

            <div>
                <h3 class="text-sm font-semibold text-amber-900">
                    Import Warnings
                </h3>

                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-amber-800">
                    @foreach (session('import_warnings') as $warning)
                        <li>{{ $warning }}</li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
@endif

    {{-- Import Card --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">
            <h2 class="text-lg font-semibold text-slate-900">
                Upload Attendance CSV
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Upload a CSV file containing your church attendance records.
            </p>
        </div>

        <form
            action="{{ route('church.attendance.import.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6 p-6"
        >
            @csrf

            {{-- File Upload --}}
            <div>
                <label
                    for="file"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Attendance CSV File
                </label>

                <label
                    for="file"
                    class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center transition hover:border-purple-400 hover:bg-purple-50"
                >
                    <svg
                        class="h-10 w-10 text-slate-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v9"
                        />
                    </svg>

                    <span class="mt-3 text-sm font-semibold text-slate-700">
                        Click to choose your CSV file
                    </span>

                    <span class="mt-1 text-xs text-slate-500">
                        CSV or TXT file, maximum 5 MB
                    </span>

                    <span
                        id="file-name"
                        class="mt-3 hidden text-sm font-medium text-purple-700"
                    ></span>

                    <input
                        id="file"
                        name="file"
                        type="file"
                        accept=".csv,.txt,text/csv,text/plain"
                        class="hidden"
                        required
                    >
                </label>

                @error('file')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Required Format --}}
            <div class="rounded-lg border border-blue-200 bg-blue-50 p-5">

                <div class="flex items-start gap-3">

                    <svg
                        class="mt-0.5 h-5 w-5 flex-shrink-0 text-blue-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"
                        />
                    </svg>

                    <div class="min-w-0">
                        <h3 class="text-sm font-semibold text-blue-900">
                            Required CSV Format
                        </h3>

                        <p class="mt-1 text-sm text-blue-800">
                            Your CSV file must contain these columns in the header:
                        </p>

                        <div class="mt-3 overflow-x-auto rounded-lg bg-white">
                            <code class="block min-w-max px-4 py-3 text-xs text-slate-700">
                                service_id,attendance_date,men,women,teenagers,children,guests,notes
                            </code>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Field Explanation --}}
            <div>
                <h3 class="mb-3 text-sm font-semibold text-slate-900">
                    Import Fields
                </h3>

                <div class="overflow-x-auto rounded-lg border border-slate-200">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">

                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-slate-700">
                                    Field
                                </th>

                                <th class="px-4 py-3 text-left font-semibold text-slate-700">
                                    Description
                                </th>

                                <th class="px-4 py-3 text-left font-semibold text-slate-700">
                                    Example
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200 bg-white">

                            <tr>
                                <td class="px-4 py-3 font-medium text-slate-900">
                                    service_id
                                </td>
                                <td class="px-4 py-3 text-slate-600">
                                    ID of the service
                                </td>
                                <td class="px-4 py-3 text-slate-500">
                                    1
                                </td>
                            </tr>

                            <tr>
                                <td class="px-4 py-3 font-medium text-slate-900">
                                    attendance_date
                                </td>
                                <td class="px-4 py-3 text-slate-600">
                                    Date of the attendance
                                </td>
                                <td class="px-4 py-3 text-slate-500">
                                    2026-09-20
                                </td>
                            </tr>

                            <tr>
                                <td class="px-4 py-3 font-medium text-slate-900">
                                    men
                                </td>
                                <td class="px-4 py-3 text-slate-600">
                                    Number of men
                                </td>
                                <td class="px-4 py-3 text-slate-500">
                                    85
                                </td>
                            </tr>

                            <tr>
                                <td class="px-4 py-3 font-medium text-slate-900">
                                    women
                                </td>
                                <td class="px-4 py-3 text-slate-600">
                                    Number of women
                                </td>
                                <td class="px-4 py-3 text-slate-500">
                                    110
                                </td>
                            </tr>

                            <tr>
                                <td class="px-4 py-3 font-medium text-slate-900">
                                    teenagers
                                </td>
                                <td class="px-4 py-3 text-slate-600">
                                    Number of teenagers
                                </td>
                                <td class="px-4 py-3 text-slate-500">
                                    35
                                </td>
                            </tr>

                            <tr>
                                <td class="px-4 py-3 font-medium text-slate-900">
                                    children
                                </td>
                                <td class="px-4 py-3 text-slate-600">
                                    Number of children
                                </td>
                                <td class="px-4 py-3 text-slate-500">
                                    60
                                </td>
                            </tr>

                            <tr>
                                <td class="px-4 py-3 font-medium text-slate-900">
                                    guests
                                </td>
                                <td class="px-4 py-3 text-slate-600">
                                    Guests / First Timers
                                </td>
                                <td class="px-4 py-3 text-slate-500">
                                    12
                                </td>
                            </tr>

                            <tr>
                                <td class="px-4 py-3 font-medium text-slate-900">
                                    notes
                                </td>
                                <td class="px-4 py-3 text-slate-600">
                                    Optional notes
                                </td>
                                <td class="px-4 py-3 text-slate-500">
                                    Sunday Service
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Download Template --}}
            <div class="flex flex-col gap-3 rounded-lg border border-slate-200 bg-slate-50 p-4 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <p class="text-sm font-semibold text-slate-800">
                        Need the correct CSV format?
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Download the official Attendance import template.
                    </p>
                </div>

                <a
                    href="{{ route('church.attendance.template') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-purple-200 bg-white px-4 py-2.5 text-sm font-semibold text-purple-700 transition hover:bg-purple-50 cursor-pointer"
                >
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z"
                        />
                    </svg>

                    Download Template
                </a>

            </div>

            {{-- Actions --}}
            <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('church.attendance.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 cursor-pointer"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700 cursor-pointer"
                >
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-3 3m0 0l-3-3m3 3V4"
                        />
                    </svg>

                    Import Attendance
                </button>

            </div>

        </form>
    </div>

</div>

{{-- File Name Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('file');
        const fileName = document.getElementById('file-name');

        if (!fileInput || !fileName) {
            return;
        }

        fileInput.addEventListener('change', function () {
            if (this.files && this.files.length > 0) {
                fileName.textContent = this.files[0].name;
                fileName.classList.remove('hidden');
            } else {
                fileName.textContent = '';
                fileName.classList.add('hidden');
            }
        });
    });
</script>

@endsection