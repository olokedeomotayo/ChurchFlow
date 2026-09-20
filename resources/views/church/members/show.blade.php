@extends('layouts.church')

@section('title', 'Member Profile')

@section('page_title', 'Member Profile')

@section('page_description', 'View member information and membership details.')

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
                        {{ $member->first_name }} {{ $member->last_name }}
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Member ID: {{ $member->member_id }}
                    </p>
                </div>

            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3">

                <a
                    href="{{ route('church.members.edit', $member) }}"
                    class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
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
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 8.5-8.5z"
                        />
                    </svg>

                    Edit Member
                </a>

            </div>

        </div>

        {{-- Profile Summary --}}
        <div class="rounded-xl border border-purple-200 bg-purple-50 p-6">

            <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">

                <div class="flex items-center gap-4">

                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-purple-100 text-xl font-bold text-purple-700">
                        {{ strtoupper(substr($member->first_name, 0, 1)) }}{{ strtoupper(substr($member->last_name, 0, 1)) }}
                    </div>

                    <div>

                        <h3 class="text-xl font-bold text-slate-900">
                            {{ $member->first_name }}
                            {{ $member->middle_name }}
                            {{ $member->last_name }}
                        </h3>

                        <p class="mt-1 text-sm text-slate-600">
                            {{ ucfirst($member->membership_type ?? 'member') }}
                        </p>

                    </div>

                </div>

                {{-- Status --}}
                <div>

                    @php
                        $status = $member->membership_status ?? 'inactive';

                        $statusClasses = match ($status) {
                            'active' => 'bg-green-100 text-green-700',
                            'suspended' => 'bg-red-100 text-red-700',
                            default => 'bg-slate-100 text-slate-600',
                        };
                    @endphp

                    <span
                        class="inline-flex rounded-full px-3 py-1.5 text-xs font-semibold {{ $statusClasses }}"
                    >
                        {{ ucfirst($status) }}
                    </span>

                </div>

            </div>

        </div>

        {{-- Personal Information --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h3 class="text-base font-bold text-slate-900">
                    Personal Information
                </h3>

            </div>

            <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2 lg:grid-cols-3">

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        First Name
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-900">
                        {{ $member->first_name ?: '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Middle Name
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-900">
                        {{ $member->middle_name ?: '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Last Name
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-900">
                        {{ $member->last_name ?: '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Date of Birth
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-900">
                        {{ $member->date_of_birth?->format('d M Y') ?? '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Gender
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-900">
                        {{ $member->gender ? ucfirst($member->gender) : '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Marital Status
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-900">
                        {{ $member->marital_status ? ucfirst($member->marital_status) : '—' }}
                    </p>
                </div>

            </div>

        </div>

        {{-- Contact Information --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h3 class="text-base font-bold text-slate-900">
                    Contact Information
                </h3>

            </div>

            <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2">

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Email Address
                    </p>

                    @if ($member->email)

                        <a
                            href="mailto:{{ $member->email }}"
                            class="mt-1 inline-block cursor-pointer text-sm font-medium text-purple-600 hover:text-purple-700 hover:underline"
                        >
                            {{ $member->email }}
                        </a>

                    @else

                        <p class="mt-1 text-sm font-medium text-slate-900">
                            —
                        </p>

                    @endif
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Phone Number
                    </p>

                    @if ($member->phone)

                        <a
                            href="tel:{{ $member->phone }}"
                            class="mt-1 inline-block cursor-pointer text-sm font-medium text-purple-600 hover:text-purple-700 hover:underline"
                        >
                            {{ $member->phone }}
                        </a>

                    @else

                        <p class="mt-1 text-sm font-medium text-slate-900">
                            —
                        </p>

                    @endif
                </div>

                <div class="md:col-span-2">

                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Address
                    </p>

                    <p class="mt-1 whitespace-pre-line text-sm font-medium text-slate-900">
                        {{ $member->address ?: '—' }}
                    </p>

                </div>

            </div>

        </div>

        {{-- Membership Information --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h3 class="text-base font-bold text-slate-900">
                    Membership Information
                </h3>

            </div>

            <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2 lg:grid-cols-3">

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Member ID
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-900">
                        {{ $member->member_id }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Membership Type
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-900">
                        {{ ucfirst($member->membership_type ?? '—') }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Membership Status
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-900">
                        {{ ucfirst($member->membership_status ?? '—') }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Date Joined
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-900">
                        {{ $member->joined_at?->format('d M Y') ?? '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Created
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-900">
                        {{ $member->created_at?->format('d M Y, h:i A') ?? '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Last Updated
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-900">
                        {{ $member->updated_at?->format('d M Y, h:i A') ?? '—' }}
                    </p>
                </div>

            </div>

        </div>

        {{-- Attendance Summary --}}
        @php
            $attendanceCount = $attendanceHistory->count();

            $lastAttendance = $attendanceHistory->first();
        @endphp

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">

            {{-- Total Attendance --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Total Attendance
                        </p>

                        <p class="mt-2 text-2xl font-bold text-slate-900">
                            {{ $attendanceCount }}
                        </p>
                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-purple-100 text-purple-600">

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
                                d="M17 20h5v-2a4 4 0 00-4-4h-1m-4 6H3v-2a4 4 0 014-4h4a4 4 0 014 4v2zm-2-10a4 4 0 11-8 0 4 4 0 018 0zm6 2a3 3 0 10-2.83-4"
                            />
                        </svg>

                    </div>

                </div>

            </div>

            {{-- Last Attendance --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Last Attendance
                        </p>

                        <p class="mt-2 text-lg font-bold text-slate-900">
                            {{ $lastAttendance?->service?->name ?? '—' }}
                        </p>

                        @if ($lastAttendance?->checked_in_at)
                            <p class="mt-1 text-xs text-slate-500">
                                {{ $lastAttendance->checked_in_at->format('d M Y, h:i A') }}
                            </p>
                        @endif

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-green-100 text-green-600">

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
                                d="M5 13l4 4L19 7"
                            />
                        </svg>

                    </div>

                </div>

            </div>

            {{-- Membership Since --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Member Since
                        </p>

                        <p class="mt-2 text-lg font-bold text-slate-900">
                            {{ $member->joined_at?->format('d M Y') ?? '—' }}
                        </p>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-blue-100 text-blue-600">

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
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                            />
                        </svg>

                    </div>

                </div>

            </div>

        </div>

        {{-- Attendance History --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="flex flex-col gap-3 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h3 class="text-base font-bold text-slate-900">
                        Attendance History
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Services attended by this member.
                    </p>
                </div>

                <span class="inline-flex w-fit rounded-full bg-purple-100 px-3 py-1 text-xs font-semibold text-purple-700">
                    {{ $attendanceCount }} Record{{ $attendanceCount === 1 ? '' : 's' }}
                </span>

            </div>

            @if ($attendanceHistory->isNotEmpty())

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-slate-200">

                        <thead class="bg-slate-50">

                            <tr>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    Service
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    Date
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    Check-In
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    Check-Out
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    Status
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-100 bg-white">

                            @foreach ($attendanceHistory as $attendance)

                                <tr class="transition hover:bg-slate-50">

                                    <td class="whitespace-nowrap px-6 py-4">

                                        <p class="text-sm font-semibold text-slate-900">
                                            {{ $attendance->service?->name ?? 'Service' }}
                                        </p>

                                        @if ($attendance->service?->description)
                                            <p class="mt-1 max-w-xs truncate text-xs text-slate-500">
                                                {{ $attendance->service->description }}
                                            </p>
                                        @endif

                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">

                                        {{ $attendance->service?->service_date?->format('d M Y') ?? '—' }}

                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">

                                        {{ $attendance->checked_in_at?->format('h:i A') ?? '—' }}

                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">

                                        {{ $attendance->checked_out_at?->format('h:i A') ?? '—' }}

                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">

                                        @php
                                            $attendanceStatus = $attendance->status ?? 'present';

                                            $attendanceStatusClasses = match ($attendanceStatus) {
                                                'present' => 'bg-green-100 text-green-700',
                                                'absent' => 'bg-red-100 text-red-700',
                                                'late' => 'bg-amber-100 text-amber-700',
                                                default => 'bg-slate-100 text-slate-600',
                                            };
                                        @endphp

                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $attendanceStatusClasses }}">
                                            {{ ucfirst($attendanceStatus) }}
                                        </span>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="px-6 py-12 text-center">

                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">

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
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a3 3 0 016 0M9 5h6"
                            />
                        </svg>

                    </div>

                    <h4 class="mt-4 text-sm font-semibold text-slate-900">
                        No attendance records yet
                    </h4>

                    <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                        Attendance records for this member will appear here after they are checked in for a service.
                    </p>

                    <a
                        href="{{ route('church.checkin.index') }}"
                        class="mt-5 inline-flex cursor-pointer items-center justify-center rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700"
                    >
                        Go to Check-In
                    </a>

                </div>

            @endif

        </div>

        {{-- Emergency Contact --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h3 class="text-base font-bold text-slate-900">
                    Emergency Contact
                </h3>

            </div>

            <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2 lg:grid-cols-3">

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Contact Name
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-900">
                        {{ $member->emergency_contact_name ?: '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Contact Phone
                    </p>

                    @if ($member->emergency_contact_phone)

                        <a
                            href="tel:{{ $member->emergency_contact_phone }}"
                            class="mt-1 inline-block cursor-pointer text-sm font-medium text-purple-600 hover:text-purple-700 hover:underline"
                        >
                            {{ $member->emergency_contact_phone }}
                        </a>

                    @else

                        <p class="mt-1 text-sm font-medium text-slate-900">
                            —
                        </p>

                    @endif
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Relationship
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-900">
                        {{ $member->emergency_contact_relationship ?: '—' }}
                    </p>
                </div>

            </div>

        </div>

        {{-- Notes --}}
        @if ($member->notes)

            <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">

                    <h3 class="text-base font-bold text-slate-900">
                        Additional Notes
                    </h3>

                </div>

                <div class="p-6">

                    <p class="whitespace-pre-line text-sm leading-7 text-slate-600">
                        {{ $member->notes }}
                    </p>

                </div>

            </div>

        @endif

        {{-- Bottom Actions --}}
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

            <a
                href="{{ route('church.members.index') }}"
                class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
            >
                Back to Members
            </a>

            <a
                href="{{ route('church.members.edit', $member) }}"
                class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-purple-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
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
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 8.5-8.5z"
                    />
                </svg>

                Edit Member

            </a>

        </div>

    </div>

@endsection