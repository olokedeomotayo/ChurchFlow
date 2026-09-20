@extends('layouts.church')

@section('title', 'Edit Service')

@section('page_title', 'Edit Service')

@section('page_description', 'Update the details of this church service.')

@section('content')

    <div class="w-full space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div class="flex items-center gap-3">

                <a
                    href="{{ route('church.services.show', $service) }}"
                    class="inline-flex h-9 w-9 shrink-0 cursor-pointer items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                    aria-label="Back to Service"
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
                        Edit Service
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Update {{ $service->name }}
                    </p>
                </div>

            </div>

        </div>

        {{-- Form --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">
                <h3 class="text-base font-bold text-slate-900">
                    Service Information
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Update the service details below.
                </p>
            </div>

            <form
                method="POST"
                action="{{ route('church.services.update', $service) }}"
                class="p-6"
            >

                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    {{-- Service Name --}}
                    <div class="md:col-span-2">

                        <label
                            for="name"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Service Name
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $service->name) }}"
                            required
                            class="block w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                            placeholder="e.g. Sunday Worship Service"
                        >

                        @error('name')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Service Date --}}
                    <div>

                        <label
                            for="service_date"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Service Date
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="date"
                            id="service_date"
                            name="service_date"
                            value="{{ old('service_date', $service->service_date?->format('Y-m-d')) }}"
                            required
                            class="block w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        >

                        @error('service_date')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Status --}}
                    <div>

                        <label
                            for="status"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Status
                            <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="status"
                            name="status"
                            required
                            class="block w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        >
                            <option
                                value="scheduled"
                                {{ old('status', $service->status) === 'scheduled' ? 'selected' : '' }}
                            >
                                Scheduled
                            </option>

                            <option
                                value="completed"
                                {{ old('status', $service->status) === 'completed' ? 'selected' : '' }}
                            >
                                Completed
                            </option>

                            <option
                                value="cancelled"
                                {{ old('status', $service->status) === 'cancelled' ? 'selected' : '' }}
                            >
                                Cancelled
                            </option>
                        </select>

                        @error('status')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Start Time --}}
                    <div>

                        <label
                            for="start_time"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Start Time
                        </label>

                        <input
                            type="time"
                            id="start_time"
                            name="start_time"
                            value="{{ old('start_time', $service->start_time?->format('H:i')) }}"
                            class="block w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        >

                        @error('start_time')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- End Time --}}
                    <div>

                        <label
                            for="end_time"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            End Time
                        </label>

                        <input
                            type="time"
                            id="end_time"
                            name="end_time"
                            value="{{ old('end_time', $service->end_time?->format('H:i')) }}"
                            class="block w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        >

                        @error('end_time')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Description --}}
                    <div class="md:col-span-2">

                        <label
                            for="description"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Description
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            class="block w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                            placeholder="Enter a description for this service..."
                        >{{ old('description', $service->description) }}</textarea>

                        @error('description')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

                {{-- Actions --}}
                <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('church.services.show', $service) }}"
                        class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
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
                                d="M5 13l4 4L19 7"
                            />
                        </svg>

                        Update Service

                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection