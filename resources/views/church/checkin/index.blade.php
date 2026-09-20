@extends('layouts.church')

@section('title', 'Check-In')

@section('content')

<div class="w-full space-y-6">

    {{-- PAGE HEADER --}}
    <div>
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                    Check-In
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Check church members into a service quickly and securely.
                </p>
            </div>

            <a href="{{ route('church.groups.index') }}"
               class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
                Manage Groups
            </a>
        </div>
    </div>

    {{-- ALERTS --}}
    @if(session('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <p class="font-semibold">Please correct the following:</p>

            <ul class="mt-2 list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- SELECT SERVICE --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">
            <h2 class="text-base font-semibold text-slate-900">
                Select Service
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Select the service you are taking attendance for.
            </p>
        </div>

        <div class="p-6">

            @if($services->count())

                <form method="GET"
                      action="{{ route('church.checkin.index') }}"
                      class="grid gap-4 md:grid-cols-[1fr_auto]">

                    <div>
                        <label for="service_id"
                               class="block text-sm font-medium text-slate-700">
                            Service
                        </label>

                        <select
                            id="service_id"
                            name="service_id"
                            onchange="this.form.submit()"
                            class="mt-2 block w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        >
                            <option value="">
                                Select a service
                            </option>

                            @foreach($services as $service)
                                <option value="{{ $service->id }}"
                                    @selected($selectedService?->id === $service->id)>
                                    {{ $service->name }}
                                    — {{ $service->service_date->format('d M Y') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit"
                                class="inline-flex w-full cursor-pointer items-center justify-center rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700 md:w-auto">
                            Select Service
                        </button>
                    </div>

                </form>

            @else

                <div class="rounded-xl border border-dashed border-slate-300 px-6 py-12 text-center">

                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-purple-50 text-purple-600">
                        <svg class="h-6 w-6"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>

                    <h3 class="mt-4 text-sm font-semibold text-slate-900">
                        No services available
                    </h3>

                    <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                        Create a service before you begin checking members in.
                    </p>

                </div>

            @endif

        </div>
    </div>

    {{-- CHECK-IN FORM --}}
    @if($selectedService)

        <div class="grid gap-6 lg:grid-cols-3">

            {{-- SERVICE SUMMARY --}}
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

                <div class="flex items-center justify-between">
                    <h2 class="text-base font-semibold text-slate-900">
                        Current Service
                    </h2>

                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                        {{ ucfirst($selectedService->status) }}
                    </span>
                </div>

                <div class="mt-6">

                    <p class="text-xl font-bold text-slate-900">
                        {{ $selectedService->name }}
                    </p>

                    <div class="mt-4 space-y-3 text-sm">

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-slate-500">Date</span>
                            <span class="font-medium text-slate-900">
                                {{ $selectedService->service_date->format('d M Y') }}
                            </span>
                        </div>

                        @if($selectedService->start_time)
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-slate-500">Start</span>
                                <span class="font-medium text-slate-900">
                                    {{ $selectedService->start_time->format('g:i A') }}
                                </span>
                            </div>
                        @endif

                        @if($selectedService->end_time)
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-slate-500">End</span>
                                <span class="font-medium text-slate-900">
                                    {{ $selectedService->end_time->format('g:i A') }}
                                </span>
                            </div>
                        @endif

                    </div>

                </div>
            </div>

            {{-- CHECK-IN --}}
            <div class="lg:col-span-2 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-5">
                    <h2 class="text-base font-semibold text-slate-900">
                        Check In Member
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Search and select a member to check them into this service.
                    </p>
                </div>

                <form method="POST"
                      action="{{ route('church.checkin.store') }}">

                    @csrf

                    <input type="hidden"
                           name="service_id"
                           value="{{ $selectedService->id }}">

                    <div class="p-6">

                        <label for="member_id"
                               class="block text-sm font-medium text-slate-700">
                            Member <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="member_id"
                            name="member_id"
                            required
                            class="mt-2 block w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        >
                            <option value="">
                                Select a member
                            </option>

                            @foreach(auth()->user()->church->members()->orderBy('first_name')->orderBy('last_name')->get() as $member)
                                <option value="{{ $member->id }}">
                                    {{ $member->first_name }}
                                    @if($member->middle_name)
                                        {{ $member->middle_name }}
                                    @endif
                                    {{ $member->last_name }}
                                    @if($member->phone)
                                        — {{ $member->phone }}
                                    @endif
                                </option>
                            @endforeach
                        </select>

                        @error('member_id')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                        <div class="mt-6 rounded-lg border border-purple-100 bg-purple-50 px-4 py-3">
                            <p class="text-sm text-purple-800">
                                <span class="font-semibold">Tip:</span>
                                Select the member and click Check In. A member can only be checked in once for this service.
                            </p>
                        </div>

                    </div>

                    <div class="flex justify-end border-t border-slate-200 bg-slate-50 px-6 py-4">

                        <button type="submit"
                                class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-purple-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700">

                            <svg class="h-5 w-5"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M5 13l4 4L19 7"/>
                            </svg>

                            Check In
                        </button>

                    </div>

                </form>

            </div>

        </div>

    @endif

</div>

@endsection