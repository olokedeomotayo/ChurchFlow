@extends('layouts.church')

@section('title', 'Import Services')

@section('content')

<div class="w-full space-y-6">

    {{-- PAGE HEADER --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Import Services
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Import multiple church services from a CSV file.
            </p>
        </div>

        <a href="{{ route('church.services.index') }}"
           class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">

            <svg class="h-4 w-4"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>

            Back to Services

        </a>

    </div>

    {{-- ERRORS --}}
    @if($errors->any())

        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-4 text-sm text-red-700">

            <p class="font-semibold">
                Please correct the following:
            </p>

            <ul class="mt-2 list-disc space-y-1 pl-5">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif

    {{-- IMPORT CARD --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">

            <h2 class="text-base font-semibold text-slate-900">
                Upload Services CSV
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Upload a properly formatted CSV file containing your church services.
            </p>

        </div>

        <div class="p-6">

            <form
                method="POST"
                action="{{ route('church.services.import.store') }}"
                enctype="multipart/form-data"
                class="space-y-6"
            >

                @csrf

                {{-- FILE --}}
                <div>

                    <label for="file"
                           class="mb-2 block text-sm font-medium text-slate-700">
                        CSV File
                    </label>

                    <input
                        id="file"
                        name="file"
                        type="file"
                        accept=".csv,.txt,text/csv"
                        required
                        class="block w-full cursor-pointer rounded-lg border border-slate-300 bg-white text-sm text-slate-700 shadow-sm file:mr-4 file:cursor-pointer file:border-0 file:bg-slate-100 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-200 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-200"
                    >

                    <p class="mt-2 text-xs text-slate-500">
                        Maximum file size: 10 MB. CSV or TXT format only.
                    </p>

                </div>

                {{-- ACTIONS --}}
                <div class="flex flex-wrap items-center gap-3">

                    <button
                        type="submit"
                        class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700"
                    >

                        <svg class="h-4 w-4"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>

                        Import Services

                    </button>

                    <a
                        href="{{ route('church.services.import.template') }}"
                        class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                    >

                        <svg class="h-4 w-4"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 10v6m0 0l-3-3m3 3l3-3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2h-4.586a1 1 0 00-.707.293l-2.414 2.414A1 1 0 019.586 7H5a2 2 0 00-2 2v9a2 2 0 002 2z"/>
                        </svg>

                        Download Template

                    </a>

                </div>

            </form>

        </div>

    </div>

    {{-- CSV FORMAT --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">

            <h2 class="text-base font-semibold text-slate-900">
                CSV Format
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Your CSV file should contain the following columns.
            </p>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Column
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Required
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Example
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    <tr>

                        <td class="px-6 py-4 text-sm font-medium text-slate-900">
                            Service Name
                        </td>

                        <td class="px-6 py-4 text-sm text-green-600">
                            Yes
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-600">
                            Celebration Service
                        </td>

                    </tr>

                    <tr>

                        <td class="px-6 py-4 text-sm font-medium text-slate-900">
                            Description
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-500">
                            No
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-600">
                            Weekly Sunday Celebration Service.
                        </td>

                    </tr>

                    <tr>

                        <td class="px-6 py-4 text-sm font-medium text-slate-900">
                            Service Date
                        </td>

                        <td class="px-6 py-4 text-sm text-green-600">
                            Yes
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-600">
                            2026-10-04
                        </td>

                    </tr>

                    <tr>

                        <td class="px-6 py-4 text-sm font-medium text-slate-900">
                            Start Time
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-500">
                            No
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-600">
                            08:00
                        </td>

                    </tr>

                    <tr>

                        <td class="px-6 py-4 text-sm font-medium text-slate-900">
                            End Time
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-500">
                            No
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-600">
                            11:00
                        </td>

                    </tr>

                    <tr>

                        <td class="px-6 py-4 text-sm font-medium text-slate-900">
                            Status
                        </td>

                        <td class="px-6 py-4 text-sm text-green-600">
                            Yes
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-600">
                            scheduled
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

    {{-- IMPORT RULES --}}
    <div class="rounded-xl border border-blue-200 bg-blue-50 px-6 py-5">

        <h3 class="text-sm font-semibold text-blue-900">
            Import Rules
        </h3>

        <ul class="mt-3 list-disc space-y-2 pl-5 text-sm text-blue-800">

            <li>
                The CSV must contain the required column names exactly as shown above.
            </li>

            <li>
                Service dates should use the format
                <strong>YYYY-MM-DD</strong>.
            </li>

            <li>
                Times should use the 24-hour format
                <strong>HH:MM</strong>.
            </li>

            <li>
                Status must be
                <strong>scheduled</strong>,
                <strong>completed</strong>,
                or
                <strong>cancelled</strong>.
            </li>

            <li>
                Existing services with the same service name and date will be skipped.
            </li>

            <li>
                Services are automatically assigned to your current church.
            </li>

            <li>
                You do not need to include a Church ID in the CSV.
            </li>

        </ul>

    </div>

</div>

@endsection