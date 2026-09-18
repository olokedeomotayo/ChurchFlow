@extends('layouts.admin')

@section('title', 'Churches')

@section('page_title', 'Churches')

@section('page_description', 'Manage churches registered on ChurchFlow')


@section('content')

    {{-- Page Header --}}

    <div class="mb-7">

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

            <div>

                <h1 class="text-2xl font-bold text-slate-900">
                    Churches
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    View and manage all churches onboarded to ChurchFlow.
                </p>

            </div>

        </div>

    </div>


    {{-- Summary Cards --}}

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">

        {{-- Total Churches --}}

        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">

            <p class="text-xs font-medium text-slate-500 uppercase">
                Total Churches
            </p>

            <p class="mt-2 text-3xl font-bold text-slate-900">
                {{ $churches->total() }}
            </p>

        </div>


        {{-- Showing --}}

        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">

            <p class="text-xs font-medium text-slate-500 uppercase">
                Showing
            </p>

            <p class="mt-2 text-3xl font-bold text-slate-900">
                {{ $churches->count() }}
            </p>

            <p class="mt-1 text-xs text-slate-500">
                On this page
            </p>

        </div>


        {{-- Trial Churches --}}

        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">

            <p class="text-xs font-medium text-slate-500 uppercase">
                Trial Churches
            </p>

            <p class="mt-2 text-3xl font-bold text-amber-600">
                {{ $churches->getCollection()->where('status', 'trial')->count() }}
            </p>

        </div>


        {{-- Active Churches --}}

        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">

            <p class="text-xs font-medium text-slate-500 uppercase">
                Active Churches
            </p>

            <p class="mt-2 text-3xl font-bold text-green-600">
                {{ $churches->getCollection()->where('status', 'active')->count() }}
            </p>

        </div>

    </div>


    {{-- Churches Table --}}

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">


        {{-- Table Header --}}

        <div class="px-6 py-5 border-b border-slate-200">

            <div>

                <h2 class="font-semibold text-slate-900">
                    Registered Churches
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Churches currently registered on the platform.
                </p>

            </div>

        </div>


        {{-- Table --}}

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                            Church
                        </th>

                        <th class="px-6 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                            Owner
                        </th>

                        <th class="px-6 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                            Plan
                        </th>

                        <th class="px-6 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                            Status
                        </th>

                        <th class="px-6 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                            Trial Ends
                        </th>

                        <th class="px-6 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                            Registered
                        </th>

                        <th class="px-6 py-3 text-right text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($churches as $church)

                        @php

                            $owner = $church->users->first();

                            $subscription = $church->subscriptions
                                ->sortByDesc('created_at')
                                ->first();

                            $plan = $subscription?->plan;

                        @endphp


                        <tr class="border-t border-slate-100 hover:bg-slate-50 transition">


                            {{-- Church --}}

                            <td class="px-6 py-4">

                                <div>

                                    <p class="text-sm font-semibold text-slate-900">
                                        {{ $church->name }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $church->code }}
                                    </p>

                                </div>

                            </td>


                            {{-- Owner --}}

                            <td class="px-6 py-4">

                                @if ($owner)

                                    <div>

                                        <p class="text-sm font-medium text-slate-800">
                                            {{ $owner->name }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-500">
                                            {{ $owner->email }}
                                        </p>

                                    </div>

                                @else

                                    <span class="text-sm text-slate-400">
                                        No owner
                                    </span>

                                @endif

                            </td>


                            {{-- Plan --}}

                            <td class="px-6 py-4">

                                <span class="text-sm text-slate-700">
                                    {{ $plan?->name ?? '—' }}
                                </span>

                            </td>


                            {{-- Status --}}

                            <td class="px-6 py-4">

                                @php

                                    $statusClasses = match ($church->status) {

                                        'trial' =>
                                            'bg-amber-100 text-amber-700',

                                        'active' =>
                                            'bg-green-100 text-green-700',

                                        'expired' =>
                                            'bg-red-100 text-red-700',

                                        'suspended' =>
                                            'bg-slate-200 text-slate-700',

                                        'cancelled' =>
                                            'bg-red-100 text-red-700',

                                        default =>
                                            'bg-slate-100 text-slate-600',

                                    };

                                @endphp


                                <span
                                    class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusClasses }}"
                                >
                                    {{ ucfirst($church->status) }}
                                </span>

                            </td>


                            {{-- Trial Ends --}}

                            <td class="px-6 py-4">

                                @if ($church->trial_ends_at)

                                    <div>

                                        <p class="text-sm text-slate-700">
                                            {{ $church->trial_ends_at->format('d M Y') }}
                                        </p>

                                        @if ($church->status === 'trial')

                                            @if ($church->trial_ends_at->isFuture())

                                                <p class="mt-1 text-xs text-amber-600">
                                                    {{ now()->diffInDays($church->trial_ends_at) }}
                                                    days remaining
                                                </p>

                                            @else

                                                <p class="mt-1 text-xs text-red-600">
                                                    Trial expired
                                                </p>

                                            @endif

                                        @endif

                                    </div>

                                @else

                                    <span class="text-sm text-slate-400">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- Registered --}}

                            <td class="px-6 py-4">

                                <span class="text-sm text-slate-600">
                                    {{ $church->created_at?->format('d M Y') ?? '—' }}
                                </span>

                            </td>


                            {{-- Action --}}

                            <td class="px-6 py-4 text-right">

                                <a
                                    href="{{ route('admin.churches.show', $church) }}"
                                    class="inline-flex items-center rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:border-purple-300 hover:text-purple-600 transition"
                                >
                                    View
                                </a>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="px-6 py-16 text-center"
                            >

                                <div class="text-sm font-medium text-slate-600">
                                    No churches found.
                                </div>

                                <p class="mt-1 text-xs text-slate-400">
                                    Churches registered on ChurchFlow will appear here.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}

        @if ($churches->hasPages())

            <div class="px-6 py-4 border-t border-slate-200">

                {{ $churches->links() }}

            </div>

        @endif

    </div>

@endsection