@extends('layouts.church')

@section('title', 'Add Member')

@section('page_title', 'Add Member')

@section('page_description', 'Add a new member to your church.')

@section('content')

    <div class="w-full space-y-6">

        {{-- Header --}}
        <div class="flex items-center gap-3">

            <a
                href="{{ route('church.members.index') }}"
                class="inline-flex h-9 w-9 cursor-pointer items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
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
                    Add New Member
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Add a member to {{ $church->name }}.
                </p>
            </div>

        </div>


        {{-- Validation Errors --}}
        @if ($errors->any())

            <div class="rounded-xl border border-red-200 bg-red-50 p-4">

                <p class="text-sm font-semibold text-red-800">
                    Please correct the following errors:
                </p>

                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif


        {{-- Form --}}
        <form
            method="POST"
            action="{{ route('church.members.store') }}"
            class="space-y-6"
        >

            @csrf


            {{-- Personal Information --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">

                    <h3 class="text-base font-bold text-slate-900">
                        Personal Information
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Basic information about the member.
                    </p>

                </div>


                <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-3">

                    {{-- First Name --}}
                    <div>

                        <label
                            for="first_name"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            First Name
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="first_name"
                            name="first_name"
                            value="{{ old('first_name') }}"
                            required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                            placeholder="John"
                        >

                    </div>


                    {{-- Middle Name --}}
                    <div>

                        <label
                            for="middle_name"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Middle Name
                        </label>

                        <input
                            type="text"
                            id="middle_name"
                            name="middle_name"
                            value="{{ old('middle_name') }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                            placeholder="Michael"
                        >

                    </div>


                    {{-- Last Name --}}
                    <div>

                        <label
                            for="last_name"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Last Name
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="last_name"
                            name="last_name"
                            value="{{ old('last_name') }}"
                            required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                            placeholder="Doe"
                        >

                    </div>


                    {{-- Date of Birth --}}
                    <div>

                        <label
                            for="date_of_birth"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Date of Birth
                        </label>

                        <input
                            type="date"
                            id="date_of_birth"
                            name="date_of_birth"
                            value="{{ old('date_of_birth') }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        >

                    </div>


                    {{-- Gender --}}
                    <div>

                        <label
                            for="gender"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Gender
                        </label>

                        <select
                            id="gender"
                            name="gender"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        >

                            <option value="">
                                Select gender
                            </option>

                            <option value="male" @selected(old('gender') === 'male')>
                                Male
                            </option>

                            <option value="female" @selected(old('gender') === 'female')>
                                Female
                            </option>

                            <option value="other" @selected(old('gender') === 'other')>
                                Other
                            </option>

                        </select>

                    </div>


                    {{-- Marital Status --}}
                    <div>

                        <label
                            for="marital_status"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Marital Status
                        </label>

                        <select
                            id="marital_status"
                            name="marital_status"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        >

                            <option value="">
                                Select status
                            </option>

                            <option value="single" @selected(old('marital_status') === 'single')>
                                Single
                            </option>

                            <option value="married" @selected(old('marital_status') === 'married')>
                                Married
                            </option>

                            <option value="widowed" @selected(old('marital_status') === 'widowed')>
                                Widowed
                            </option>

                            <option value="divorced" @selected(old('marital_status') === 'divorced')>
                                Divorced
                            </option>

                        </select>

                    </div>

                </div>

            </div>


            {{-- Contact Information --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">

                    <h3 class="text-base font-bold text-slate-900">
                        Contact Information
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        How the church can contact this member.
                    </p>

                </div>


                <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">

                    {{-- Email --}}
                    <div>

                        <label
                            for="email"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Email Address
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                            placeholder="john@example.com"
                        >

                    </div>


                    {{-- Phone --}}
                    <div>

                        <label
                            for="phone"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Phone Number
                        </label>

                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            value="{{ old('phone') }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                            placeholder="08012345678"
                        >

                    </div>


                    {{-- Address --}}
                    <div class="md:col-span-2">

                        <label
                            for="address"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Address
                        </label>

                        <textarea
                            id="address"
                            name="address"
                            rows="3"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                            placeholder="Member's residential address"
                        >{{ old('address') }}</textarea>

                    </div>

                </div>

            </div>


            {{-- Membership Information --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">

                    <h3 class="text-base font-bold text-slate-900">
                        Membership Information
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Information about the member's relationship with the church.
                    </p>

                </div>


                <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-3">

                    {{-- Joined Date --}}
                    <div>

                        <label
                            for="joined_at"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Date Joined
                        </label>

                        <input
                            type="date"
                            id="joined_at"
                            name="joined_at"
                            value="{{ old('joined_at') }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        >

                    </div>


                    {{-- Membership Type --}}
                    <div>

                        <label
                            for="membership_type"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Membership Type
                            <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="membership_type"
                            name="membership_type"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        >

                            <option value="member" @selected(old('membership_type', 'member') === 'member')>
                                Member
                            </option>

                            <option value="visitor" @selected(old('membership_type') === 'visitor')>
                                Visitor
                            </option>

                            <option value="worker" @selected(old('membership_type') === 'worker')>
                                Worker
                            </option>

                            <option value="leader" @selected(old('membership_type') === 'leader')>
                                Leader
                            </option>

                        </select>

                    </div>


                    {{-- Membership Status --}}
                    <div>

                        <label
                            for="membership_status"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Membership Status
                            <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="membership_status"
                            name="membership_status"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        >

                            <option value="active" @selected(old('membership_status', 'active') === 'active')>
                                Active
                            </option>

                            <option value="inactive" @selected(old('membership_status') === 'inactive')>
                                Inactive
                            </option>

                            <option value="suspended" @selected(old('membership_status') === 'suspended')>
                                Suspended
                            </option>

                        </select>

                    </div>

                </div>

            </div>


            {{-- Emergency Contact --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">

                    <h3 class="text-base font-bold text-slate-900">
                        Emergency Contact
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Optional emergency contact information.
                    </p>

                </div>


                <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-3">

                    {{-- Name --}}
                    <div>

                        <label
                            for="emergency_contact_name"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Contact Name
                        </label>

                        <input
                            type="text"
                            id="emergency_contact_name"
                            name="emergency_contact_name"
                            value="{{ old('emergency_contact_name') }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                            placeholder="Emergency contact"
                        >

                    </div>


                    {{-- Phone --}}
                    <div>

                        <label
                            for="emergency_contact_phone"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Contact Phone
                        </label>

                        <input
                            type="text"
                            id="emergency_contact_phone"
                            name="emergency_contact_phone"
                            value="{{ old('emergency_contact_phone') }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                            placeholder="08012345678"
                        >

                    </div>


                    {{-- Relationship --}}
                    <div>

                        <label
                            for="emergency_contact_relationship"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Relationship
                        </label>

                        <input
                            type="text"
                            id="emergency_contact_relationship"
                            name="emergency_contact_relationship"
                            value="{{ old('emergency_contact_relationship') }}"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                            placeholder="Spouse, parent, sibling..."
                        >

                    </div>

                </div>

            </div>


            {{-- Notes --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">

                    <h3 class="text-base font-bold text-slate-900">
                        Additional Notes
                    </h3>

                </div>

                <div class="p-6">

                    <textarea
                        name="notes"
                        rows="4"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        placeholder="Additional information about this member..."
                    >{{ old('notes') }}</textarea>

                </div>

            </div>


            {{-- Actions --}}
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('church.members.index') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Cancel
                </a>

               <button
                type="submit"
                class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-purple-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
            >
                <span>Save Member</span>
            </button>

            </div>

        </form>

    </div>

@endsection