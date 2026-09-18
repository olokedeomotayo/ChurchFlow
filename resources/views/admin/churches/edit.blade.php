@extends('layouts.admin')

@section('title', 'Edit Church')

@section('page_title', 'Edit Church')

@section('page_description', 'Update church account information')


@section('content')

    {{-- Back Navigation --}}

    <div class="mb-6">

        <a
            href="{{ route('admin.churches.show', $church) }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-purple-600"
        >
            <span class="text-base">←</span>

            Back to Church Details
        </a>

    </div>


    {{-- Page Container --}}

    <div class="w-full">


        {{-- Main Form Card --}}

        <div class="w-full overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">


            {{-- Header --}}

            <div class="border-b border-slate-200 px-6 py-6 lg:px-8">

                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                    <div>

                        <h1 class="text-xl font-bold text-slate-900">
                            Edit Church Information
                        </h1>

                        <p class="mt-1 text-sm text-slate-500">
                            Update the information and account status for
                            <span class="font-semibold text-slate-700">
                                {{ $church->name }}
                            </span>.
                        </p>

                    </div>


                    {{-- Church Code --}}

                    <div class="w-fit rounded-lg bg-slate-50 px-4 py-2">

                        <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                            Church Code
                        </p>

                        <p class="mt-0.5 text-sm font-bold text-slate-700">
                            {{ $church->code }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- Validation Errors --}}

            @if ($errors->any())

                <div class="mx-6 mt-6 rounded-lg border border-red-200 bg-red-50 p-4 lg:mx-8">

                    <div class="flex items-start gap-3">

                        <div class="mt-0.5 text-red-600">
                            ⚠
                        </div>

                        <div>

                            <p class="text-sm font-semibold text-red-700">
                                Please correct the following errors:
                            </p>

                            <ul class="mt-2 list-disc space-y-1 pl-5 text-xs text-red-600">

                                @foreach ($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    </div>

                </div>

            @endif


            {{-- Success Message --}}

            @if (session('success'))

                <div class="mx-6 mt-6 rounded-lg border border-green-200 bg-green-50 p-4 lg:mx-8">

                    <p class="text-sm font-semibold text-green-700">
                        {{ session('success') }}
                    </p>

                </div>

            @endif


            {{-- Form --}}

            <form
                method="POST"
                action="{{ route('admin.churches.update', $church) }}"
                class="px-6 py-8 lg:px-8"
            >

                @csrf

                @method('PUT')


                {{-- ========================= --}}
                {{-- Basic Information --}}
                {{-- ========================= --}}

                <div class="mb-6">

                    <h2 class="text-sm font-bold text-slate-900">
                        Basic Information
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Basic identifying information for this church.
                    </p>

                </div>


                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">


                    {{-- Church Name --}}

                    <div>

                        <label
                            for="name"
                            class="mb-2 block text-xs font-semibold text-slate-700"
                        >
                            Church Name
                        </label>

                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name', $church->name) }}"
                            required
                            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                        >

                        @error('name')

                            <p class="mt-1 text-xs text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Church Code --}}

                    <div>

                        <label
                            for="church_code"
                            class="mb-2 block text-xs font-semibold text-slate-700"
                        >
                            Church Code
                        </label>

                        <input
                            id="church_code"
                            type="text"
                            value="{{ $church->code }}"
                            disabled
                            class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500"
                        >

                        <p class="mt-1 text-[11px] text-slate-400">
                            Church code cannot be changed.
                        </p>

                    </div>


                    {{-- Email --}}

                    <div>

                        <label
                            for="email"
                            class="mb-2 block text-xs font-semibold text-slate-700"
                        >
                            Email Address
                        </label>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email', $church->email) }}"
                            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                        >

                        @error('email')

                            <p class="mt-1 text-xs text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- Phone --}}

                    <div>

                        <label
                            for="phone"
                            class="mb-2 block text-xs font-semibold text-slate-700"
                        >
                            Phone Number
                        </label>

                        <input
                            id="phone"
                            name="phone"
                            type="text"
                            value="{{ old('phone', $church->phone) }}"
                            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                        >

                        @error('phone')

                            <p class="mt-1 text-xs text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- City --}}

                    <div>

                        <label
                            for="city"
                            class="mb-2 block text-xs font-semibold text-slate-700"
                        >
                            City
                        </label>

                        <input
                            id="city"
                            name="city"
                            type="text"
                            value="{{ old('city', $church->city) }}"
                            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                        >

                    </div>


                    {{-- State --}}

                    <div>

                        <label
                            for="state"
                            class="mb-2 block text-xs font-semibold text-slate-700"
                        >
                            State
                        </label>

                        <input
                            id="state"
                            name="state"
                            type="text"
                            value="{{ old('state', $church->state) }}"
                            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                        >

                    </div>


                    {{-- Country --}}

                    <div>

                        <label
                            for="country"
                            class="mb-2 block text-xs font-semibold text-slate-700"
                        >
                            Country
                        </label>

                        <input
                            id="country"
                            name="country"
                            type="text"
                            value="{{ old('country', $church->country) }}"
                            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                        >

                    </div>


                    {{-- Timezone --}}

                    <div>

                        <label
                            for="timezone"
                            class="mb-2 block text-xs font-semibold text-slate-700"
                        >
                            Timezone
                        </label>

                        <input
                            id="timezone"
                            name="timezone"
                            type="text"
                            value="{{ old('timezone', $church->timezone) }}"
                            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                        >

                    </div>


                    {{-- Address --}}

                    <div class="md:col-span-2 xl:col-span-3">

                        <label
                            for="address"
                            class="mb-2 block text-xs font-semibold text-slate-700"
                        >
                            Address
                        </label>

                        <textarea
                            id="address"
                            name="address"
                            rows="3"
                            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                        >{{ old('address', $church->address) }}</textarea>

                        @error('address')

                            <p class="mt-1 text-xs text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                </div>


                {{-- ========================= --}}
                {{-- Account Status --}}
                {{-- ========================= --}}

                <div class="mt-10 border-t border-slate-200 pt-8">

                    <div class="mb-6">

                        <h2 class="text-sm font-bold text-slate-900">
                            Account Status
                        </h2>

                        <p class="mt-1 text-xs text-slate-500">
                            Control the current status of this church account.
                        </p>

                    </div>


                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">


                        {{-- Status --}}

                        <div>

                            <label
                                for="status"
                                class="mb-2 block text-xs font-semibold text-slate-700"
                            >
                                Account Status
                            </label>

                            <select
                                id="status"
                                name="status"
                                required
                                class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                            >

                                @foreach ([
                                    'trial' => 'Trial',
                                    'active' => 'Active',
                                    'expired' => 'Expired',
                                    'suspended' => 'Suspended',
                                    'cancelled' => 'Cancelled',
                                ] as $value => $label)

                                    <option
                                        value="{{ $value }}"
                                        @selected(old('status', $church->status) === $value)
                                    >
                                        {{ $label }}
                                    </option>

                                @endforeach

                            </select>

                            @error('status')

                                <p class="mt-1 text-xs text-red-600">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- Current Status Info --}}

                        <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">

                            <p class="text-xs font-semibold text-slate-500">
                                Current Status
                            </p>

                            <p class="mt-1 text-sm font-bold text-slate-800">
                                {{ ucfirst($church->status) }}
                            </p>

                            <p class="mt-2 text-xs leading-5 text-slate-500">
                                Changing the status affects the church's access to the ChurchFlow platform.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- ========================= --}}
                {{-- Trial Information --}}
                {{-- ========================= --}}

                <div class="mt-10 border-t border-slate-200 pt-8">

                    <div class="mb-6">

                        <h2 class="text-sm font-bold text-slate-900">
                            Trial Information
                        </h2>

                        <p class="mt-1 text-xs text-slate-500">
                            Current trial dates for this church.
                        </p>

                    </div>


                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">


                        {{-- Trial Started --}}

                        <div>

                            <label
                                class="mb-2 block text-xs font-semibold text-slate-700"
                            >
                                Trial Started
                            </label>

                            <input
                                type="text"
                                value="{{ $church->trial_started_at?->format('d M Y, h:i A') ?? '—' }}"
                                disabled
                                class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500"
                            >

                        </div>


                        {{-- Trial Ends --}}

                        <div>

                            <label
                                class="mb-2 block text-xs font-semibold text-slate-700"
                            >
                                Trial Ends
                            </label>

                            <input
                                type="text"
                                value="{{ $church->trial_ends_at?->format('d M Y, h:i A') ?? '—' }}"
                                disabled
                                class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500"
                            >

                        </div>

                    </div>

                </div>


                {{-- ========================= --}}
                {{-- Actions --}}
                {{-- ========================= --}}

                <div class="mt-10 flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:items-center sm:justify-end">

                    <a
                        href="{{ route('admin.churches.show', $church) }}"
                        class="inline-flex items-center justify-center rounded-lg border border-slate-200 px-6 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-purple-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                    >
                        Save Changes
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection