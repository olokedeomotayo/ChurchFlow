@extends('layouts.church')

@section('title', 'Import Members')

@section('page_title', 'Import Members')

@section('page_description', 'Import multiple church members using a CSV file.')

@section('content')

    <div class="w-full space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div class="flex items-center gap-3">

                <a
                    href="{{ route('church.members.index') }}"
                    class="inline-flex h-9 w-9 shrink-0 cursor-pointer items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                    aria-label="Back to Members"
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
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>
                </a>

                <div>
                    <h2 class="text-xl font-bold text-slate-900">
                        Import Members
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Add multiple members to your church using a CSV file.
                    </p>
                </div>

            </div>

        </div>


        {{-- Instructions --}}
        <div class="rounded-xl border border-purple-200 bg-purple-50 p-6">

            <div class="flex gap-4">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-purple-100 text-purple-600">

                    <svg
                        class="h-5 w-5"
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

                </div>

                <div>

                    <h3 class="text-sm font-bold text-purple-900">
                        Before you import
                    </h3>

                    <ul class="mt-2 space-y-1.5 text-sm text-purple-800">

                        <li>
                            • Download the CSV template first.
                        </li>

                        <li>
                            • Keep the column headers unchanged.
                        </li>

                        <li>
                            • One row represents one member.
                        </li>

                        <li>
                            • Member IDs will be generated automatically.
                        </li>

                        <li>
                            • Review your data carefully before importing.
                        </li>

                    </ul>

                </div>

            </div>

        </div>


        {{-- Download Template --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                <div>

                    <h3 class="text-base font-bold text-slate-900">
                        Need the CSV template?
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Download the official ChurchFlow member import template
                        before preparing your members list.
                    </p>

                </div>

                <a
                    href="{{ route('church.members.template') }}"
                    class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 sm:w-auto"
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
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                    </svg>

                    Download Template

                </a>

            </div>

        </div>


        {{-- Upload Members --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h3 class="text-base font-bold text-slate-900">
                    Upload Members CSV
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Select the completed CSV file from your computer.
                </p>

            </div>


            <form
                method="POST"
                action="{{ route('church.members.import.store') }}"
                enctype="multipart/form-data"
                class="p-6"
            >

                @csrf


                {{-- File Upload --}}
                <div>

                    <label
                        for="file"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        CSV File
                        <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="file"
                        id="file"
                        name="file"
                        accept=".csv,text/csv"
                        required
                        class="block w-full cursor-pointer rounded-lg border border-slate-300 bg-white text-sm text-slate-600 file:mr-4 file:cursor-pointer file:border-0 file:bg-slate-100 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-200 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500/20"
                    >

                    <p class="mt-2 text-xs text-slate-500">
                        Accepted format: CSV. Maximum file size: 5MB.
                    </p>

                    @error('file')

                        <p class="mt-2 text-sm font-medium text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- Actions --}}
                <div class="mt-6 flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('church.members.index') }}"
                        class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 sm:w-auto"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg bg-purple-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 sm:w-auto"
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
                                d="M12 4v12m0 0l-3-3m3 3l3-3M5 20h14"
                            />
                        </svg>

                        Import Members

                    </button>

                </div>

            </form>

        </div>


        {{-- Supported Values --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

            <div>

                <h3 class="text-sm font-bold text-slate-900">
                    Supported Values
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Use these values when preparing your CSV file.
                </p>

            </div>


            <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

                {{-- Gender --}}
                <div class="rounded-lg bg-slate-50 p-4">

                    <p class="text-sm font-semibold text-slate-700">
                        Gender
                    </p>

                    <p class="mt-1 text-sm text-slate-500">
                        male, female, other
                    </p>

                </div>


                {{-- Marital Status --}}
                <div class="rounded-lg bg-slate-50 p-4">

                    <p class="text-sm font-semibold text-slate-700">
                        Marital Status
                    </p>

                    <p class="mt-1 text-sm text-slate-500">
                        single, married, widowed, divorced
                    </p>

                </div>


                {{-- Membership Type --}}
                <div class="rounded-lg bg-slate-50 p-4">

                    <p class="text-sm font-semibold text-slate-700">
                        Membership Type
                    </p>

                    <p class="mt-1 text-sm text-slate-500">
                        member, visitor, worker, leader
                    </p>

                </div>


                {{-- Membership Status --}}
                <div class="rounded-lg bg-slate-50 p-4">

                    <p class="text-sm font-semibold text-slate-700">
                        Membership Status
                    </p>

                    <p class="mt-1 text-sm text-slate-500">
                        active, inactive, suspended
                    </p>

                </div>

            </div>

        </div>

    </div>

@endsection