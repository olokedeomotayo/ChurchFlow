@extends('layouts.church')

@section('title', 'Create Service')

@section('content')

<div class="w-full">

    <div class="mb-6">
        <a href="{{ route('church.services.index') }}"
           class="inline-flex cursor-pointer items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-purple-600">
            <span>←</span>
            <span>Back to Services</span>
        </a>

        <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900">
            Create Service
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Create a church service or gathering for attendance and check-in.
        </p>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">
            <h2 class="text-base font-semibold text-slate-900">
                Service Information
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Enter the details of the service you want to create.
            </p>
        </div>

        <form method="POST" action="{{ route('church.services.store') }}">
            @csrf

            <div class="space-y-6 p-6">

                {{-- NAME --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700">
                        Service Name <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="e.g. Sunday Worship Service"
                        required
                        class="mt-2 block w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                    >

                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- DATE / STATUS --}}
                <div class="grid gap-6 md:grid-cols-2">

                    <div>
                        <label for="service_date" class="block text-sm font-medium text-slate-700">
                            Service Date <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="date"
                            id="service_date"
                            name="service_date"
                            value="{{ old('service_date', now()->format('Y-m-d')) }}"
                            required
                            class="mt-2 block w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        >

                        @error('service_date')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-slate-700">
                            Status <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="status"
                            name="status"
                            required
                            class="mt-2 block w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        >
                            <option value="scheduled" @selected(old('status', 'scheduled') === 'scheduled')>
                                Scheduled
                            </option>

                            <option value="completed" @selected(old('status') === 'completed')>
                                Completed
                            </option>

                            <option value="cancelled" @selected(old('status') === 'cancelled')>
                                Cancelled
                            </option>
                        </select>

                        @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- TIME --}}
                <div class="grid gap-6 md:grid-cols-2">

                    <div>
                        <label for="start_time" class="block text-sm font-medium text-slate-700">
                            Start Time
                        </label>

                        <input
                            type="time"
                            id="start_time"
                            name="start_time"
                            value="{{ old('start_time') }}"
                            class="mt-2 block w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        >

                        @error('start_time')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_time" class="block text-sm font-medium text-slate-700">
                            End Time
                        </label>

                        <input
                            type="time"
                            id="end_time"
                            name="end_time"
                            value="{{ old('end_time') }}"
                            class="mt-2 block w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        >

                        @error('end_time')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- DESCRIPTION --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700">
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        placeholder="Describe this service or gathering..."
                        class="mt-2 block w-full resize-y rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- ACTIONS --}}
            <div class="flex flex-col gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4 sm:flex-row sm:items-center sm:justify-end">

                <a href="{{ route('church.services.index') }}"
                   class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
                    Cancel
                </a>

                <button
                    type="submit"
                    class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700"
                >
                    Create Service
                </button>

            </div>

        </form>

    </div>

</div>

@endsection