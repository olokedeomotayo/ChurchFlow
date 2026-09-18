@extends('layouts.church')

@section('title', 'Members')

@section('page_title', 'Members')

@section('page_description', 'Manage and keep track of your church members.')

@section('content')

    <div class="w-full space-y-6">

        {{-- Page Header --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

            <div>
                <h2 class="text-xl font-bold text-slate-900">
                    Members
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Manage and keep track of your church members.
                </p>
            </div>


            {{-- Actions --}}
            <div class="flex flex-wrap items-center gap-3">

                {{-- Download Template --}}
                <a
                    href="{{ route('church.members.template') }}"
                    class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
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


                {{-- Import Members --}}
                <a
                    href="{{ route('church.members.import') }}"
                    class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
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

                </a>


                {{-- Export Members --}}
                <a
                    href="{{ route('church.members.export') }}"
                    class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
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
                            d="M12 16V4m0 0L8 8m4-4l4 4M5 20h14"
                        />
                    </svg>

                    Export Members

                </a>


                {{-- Add Member --}}
                <a
                    href="{{ route('church.members.create') }}"
                    class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-700 focus:ring-offset-2"
                >

                    <span class="text-lg leading-none">
                        +
                    </span>

                    Add Member

                </a>

            </div>

        </div>


        {{-- Success Message --}}
        @if (session('success'))

            <div class="rounded-xl border border-green-200 bg-green-50 px-5 py-4">

                <div class="flex items-center gap-3">

                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-green-100 text-sm font-bold text-green-600">
                        ✓
                    </span>

                    <p class="text-sm font-medium text-green-800">
                        {{ session('success') }}
                    </p>

                </div>

            </div>

        @endif


        {{-- Error Message --}}
        @if (session('error'))

            <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4">

                <div class="flex items-center gap-3">

                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-red-100 text-sm font-bold text-red-600">
                        !
                    </span>

                    <p class="text-sm font-medium text-red-800">
                        {{ session('error') }}
                    </p>

                </div>

            </div>

        @endif


        {{-- Member Statistics --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Total Members --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Total Members
                </p>

                <p class="mt-2 text-2xl font-bold text-slate-900">
                    {{ $members->total() }}
                </p>

            </div>


            {{-- Active --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Active
                </p>

                <p class="mt-2 text-2xl font-bold text-green-600">
                    {{ $members->where('membership_status', 'active')->count() }}
                </p>

            </div>


            {{-- Inactive --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Inactive
                </p>

                <p class="mt-2 text-2xl font-bold text-slate-500">
                    {{ $members->where('membership_status', 'inactive')->count() }}
                </p>

            </div>


            {{-- Suspended --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Suspended
                </p>

                <p class="mt-2 text-2xl font-bold text-red-600">
                    {{ $members->where('membership_status', 'suspended')->count() }}
                </p>

            </div>

        </div>


        {{-- Members Table --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            {{-- Table Header --}}
            <div class="border-b border-slate-200 px-6 py-5">

                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                    <div>

                        <h3 class="text-base font-bold text-slate-900">
                            Church Members
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            View and manage registered members.
                        </p>

                    </div>


                    {{-- Search --}}
                    <form
                        method="GET"
                        action="{{ route('church.members.index') }}"
                        class="w-full md:w-72"
                    >

                        <div class="relative">

                            <svg
                                class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 6.04 6.04a7.5 7.5 0 0 0 10.61 10.61Z"
                                />
                            </svg>

                            <input
                                type="search"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search members..."
                                class="w-full rounded-lg border border-slate-300 bg-white py-2.5 pl-9 pr-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                            >

                        </div>

                    </form>

                </div>

            </div>


            @if ($members->count())

                {{-- Responsive Table --}}
                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-slate-200">

                        <thead class="bg-slate-50">

                            <tr>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Member
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Member ID
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Phone
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Type
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Status
                                </th>

                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-200 bg-white">

                            @foreach ($members as $member)

                                <tr class="transition hover:bg-slate-50">

                                    {{-- Member --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        <div class="flex items-center gap-3">

                                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-purple-100 text-sm font-bold text-purple-700">
                                                {{ strtoupper(substr($member->first_name, 0, 1)) }}
                                            </div>

                                            <div>

                                                <p class="text-sm font-semibold text-slate-900">
                                                    {{ $member->first_name }}
                                                    {{ $member->middle_name }}
                                                    {{ $member->last_name }}
                                                </p>

                                                @if ($member->email)

                                                    <p class="mt-0.5 text-xs text-slate-500">
                                                        {{ $member->email }}
                                                    </p>

                                                @endif

                                            </div>

                                        </div>

                                    </td>


                                    {{-- Member ID --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        <span class="text-sm font-medium text-slate-700">
                                            {{ $member->member_id }}
                                        </span>

                                    </td>


                                    {{-- Phone --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">

                                        {{ $member->phone ?? '—' }}

                                    </td>


                                    {{-- Type --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        <span class="capitalize text-sm text-slate-600">
                                            {{ $member->membership_type ?? 'Member' }}
                                        </span>

                                    </td>


                                    {{-- Status --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        @if ($member->membership_status === 'active')

                                            <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                                                Active
                                            </span>

                                        @elseif ($member->membership_status === 'inactive')

                                            <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                                Inactive
                                            </span>

                                        @else

                                            <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">
                                                Suspended
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Action --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-right">

                                        <a
                                            href="#"
                                            class="inline-flex cursor-pointer items-center rounded-lg px-3 py-2 text-sm font-medium text-purple-600 transition hover:bg-purple-50 hover:text-purple-700"
                                        >
                                            View
                                        </a>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- Pagination --}}
                @if ($members->hasPages())

                    <div class="border-t border-slate-200 px-6 py-4">

                        {{ $members->links() }}

                    </div>

                @endif

            @else

                {{-- Empty State --}}
                <div class="px-6 py-16 text-center">

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-purple-50 text-purple-600">

                        <svg
                            class="h-7 w-7"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m7-8a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm7-3a4 4 0 0 1 0 8m4 3v-2a4 4 0 0 0-3-3.87"
                            />
                        </svg>

                    </div>

                    <h3 class="mt-4 text-base font-bold text-slate-900">
                        No members found
                    </h3>

                    <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                        You haven't added any church members yet.
                        Start by adding your first member.
                    </p>

                    <div class="mt-6">

                        <a
                            href="{{ route('church.members.create') }}"
                            class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700"
                        >
                            <span class="text-lg leading-none">+</span>
                            Add First Member
                        </a>

                    </div>

                </div>

            @endif

        </div>

    </div>

@endsection