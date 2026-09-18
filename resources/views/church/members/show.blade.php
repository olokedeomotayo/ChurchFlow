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