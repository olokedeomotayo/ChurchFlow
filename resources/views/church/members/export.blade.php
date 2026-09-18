@extends('layouts.church')

@section('title', 'Export Members')

@section('page_title', 'Export Members')

@section('page_description', 'Export your church members and download their records as a CSV file.')

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
                        Export Members
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Download your church member records as a CSV file.
                    </p>

                </div>

            </div>

        </div>


        {{-- Export Information --}}
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
                        About Member Export
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-purple-800">
                        Export your church members to a CSV file for reporting,
                        record keeping, backup, or use in another system.
                    </p>

                    <ul class="mt-3 space-y-1.5 text-sm text-purple-800">

                        <li>
                            • Only members belonging to your church will be exported.
                        </li>

                        <li>
                            • All available member information will be included.
                        </li>

                        <li>
                            • The exported file can also be used as a backup.
                        </li>

                        <li>
                            • The file will be downloaded automatically.
                        </li>

                    </ul>

                </div>

            </div>

        </div>


        {{-- Export Card --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h3 class="text-base font-bold text-slate-900">
                    Export Member Records
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Generate a CSV file containing your church member records.
                </p>

            </div>


            <div class="p-6">

                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                    {{-- Summary --}}
                    <div class="flex items-center gap-4">

                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-purple-100 text-purple-600">

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
                                    d="M12 4v12m0 0l-4-4m4 4l4-4M5 20h14"
                                />
                            </svg>

                        </div>

                        <div>

                            <p class="text-sm font-semibold text-slate-900">
                                Ready to export?
                            </p>

                            <p class="mt-1 text-sm text-slate-500">
                                Download all your church member records in CSV format.
                            </p>

                        </div>

                    </div>


                    {{-- Export Button --}}
                    <a
                        href="{{ route('church.members.export') }}"
                        class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg bg-purple-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 lg:w-auto"
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
                                d="M12 4v12m0 0l-4-4m4 4l4-4M5 20h14"
                            />
                        </svg>

                        Export Members

                    </a>

                </div>

            </div>

        </div>


        {{-- Export Fields --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

            <h3 class="text-sm font-bold text-slate-900">
                Information Included
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                The exported CSV contains the following member information.
            </p>


            <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">

                @foreach ([
                    'Personal Information',
                    'Contact Information',
                    'Membership Information',
                    'Emergency Contact',
                ] as $field)

                    <div class="rounded-lg bg-slate-50 px-4 py-3">

                        <p class="text-sm font-medium text-slate-700">
                            {{ $field }}
                        </p>

                    </div>

                @endforeach

            </div>

        </div>


        {{-- Actions --}}
        <div class="flex justify-start">

            <a
                href="{{ route('church.members.index') }}"
                class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 sm:w-auto"
            >
                Cancel
            </a>

        </div>

    </div>

@endsection