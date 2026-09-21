@extends('layouts.church')

@section('title', 'Audit Logs')
@section('page_title', 'Audit Logs')
@section('page_description', 'Track important activities and changes within your church account')

@section('content')

    <div class="w-full space-y-6">

        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <div>
            <h1 class="text-xl font-bold text-slate-900">
                Audit Logs
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Review important activities and changes made within
                {{ $church?->name ?? 'your church' }}.
            </p>
        </div>


        {{-- =====================================================
             FILTERS
        ====================================================== --}}

        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-4">

                <h2 class="text-sm font-semibold text-slate-900">
                    Filter Activity
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Search and filter your church activity history.
                </p>

            </div>


            <form
                method="GET"
                action="{{ route('church.audit-logs.index') }}"
                class="grid grid-cols-1 gap-4 p-6 md:grid-cols-2 xl:grid-cols-4"
            >

                {{-- Search --}}

                <div class="xl:col-span-2">

                    <label
                        for="search"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Search
                    </label>

                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ request('search') }}"
                        placeholder="Search activity, description, module or IP..."
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                    >

                </div>


                {{-- Action --}}

                <div>

                    <label
                        for="action"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Action
                    </label>

                    <select
                        name="action"
                        id="action"
                        class="w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                    >

                        <option value="">
                            All Actions
                        </option>

                        @foreach ($actions as $action)
                            <option
                                value="{{ $action }}"
                                @selected(request('action') === $action)
                            >
                                {{ ucfirst($action) }}
                            </option>
                        @endforeach

                    </select>

                </div>


                {{-- Date --}}

                <div>

                    <label
                        for="date"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Date
                    </label>

                    <input
                        type="date"
                        name="date"
                        id="date"
                        value="{{ request('date') }}"
                        class="w-full cursor-pointer rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                    >

                </div>


                {{-- Buttons --}}

                <div class="flex items-end gap-3 md:col-span-2 xl:col-span-4">

                    <button
                        type="submit"
                        class="cursor-pointer rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700"
                    >
                        Apply Filters
                    </button>

                    <a
                        href="{{ route('church.audit-logs.index') }}"
                        class="cursor-pointer rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                    >
                        Clear
                    </a>

                </div>

            </form>

        </div>


        {{-- =====================================================
             AUDIT LOG TABLE
        ====================================================== --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="flex flex-col gap-2 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <h2 class="text-sm font-semibold text-slate-900">
                        Activity History
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        {{ $logs->total() }}
                        {{ $logs->total() === 1 ? 'activity' : 'activities' }}
                        recorded
                    </p>

                </div>

            </div>


            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-slate-200">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="whitespace-nowrap px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Date & Time
                            </th>

                            <th class="whitespace-nowrap px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                User
                            </th>

                            <th class="whitespace-nowrap px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Action
                            </th>

                            <th class="whitespace-nowrap px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Module
                            </th>

                            <th class="whitespace-nowrap px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Description
                            </th>

                            <th class="whitespace-nowrap px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                                IP Address
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100 bg-white">

                        @forelse ($logs as $log)

                            <tr class="transition hover:bg-slate-50">

                                {{-- Date --}}

                                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">

                                    {{ $log->created_at?->format('d M Y') }}

                                    <div class="mt-0.5 text-xs text-slate-400">
                                        {{ $log->created_at?->format('h:i A') }}
                                    </div>

                                </td>


                                {{-- User --}}

                                <td class="whitespace-nowrap px-6 py-4">

                                    <div class="text-sm font-medium text-slate-900">
                                        {{ $log->user?->name ?? 'System' }}
                                    </div>

                                    @if ($log->user?->email)
                                        <div class="mt-0.5 text-xs text-slate-400">
                                            {{ $log->user->email }}
                                        </div>
                                    @endif

                                </td>


                                {{-- Action --}}

                                <td class="whitespace-nowrap px-6 py-4">

                                    <span
                                        class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold
                                            @if (in_array($log->action, ['created', 'create']))
                                                bg-green-100 text-green-700
                                            @elseif (in_array($log->action, ['updated', 'update']))
                                                bg-blue-100 text-blue-700
                                            @elseif (in_array($log->action, ['deleted', 'delete']))
                                                bg-red-100 text-red-700
                                            @elseif (in_array($log->action, ['login']))
                                                bg-purple-100 text-purple-700
                                            @else
                                                bg-slate-100 text-slate-700
                                            @endif
                                        "
                                    >
                                        {{ ucfirst($log->action) }}
                                    </span>

                                </td>


                                {{-- Module --}}

                                <td class="whitespace-nowrap px-6 py-4">

                                    @php
                                        $module = $log->subject_type
                                            ? class_basename($log->subject_type)
                                            : 'System';
                                    @endphp

                                    <span class="text-sm font-medium text-slate-700">
                                        {{ $module }}
                                    </span>

                                </td>


                                {{-- Description --}}

                                <td class="max-w-md px-6 py-4">

                                    <p class="text-sm text-slate-600">
                                        {{ $log->description ?: 'No description provided.' }}
                                    </p>

                                </td>


                                {{-- IP Address --}}

                                <td class="whitespace-nowrap px-6 py-4">

                                    <span class="font-mono text-xs text-slate-500">
                                        {{ $log->ip_address ?: '-' }}
                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="px-6 py-12 text-center"
                                >

                                    <div class="mx-auto max-w-md">

                                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-xl text-slate-400">
                                            ◷
                                        </div>

                                        <h3 class="mt-4 text-sm font-semibold text-slate-900">
                                            No audit activity found
                                        </h3>

                                        <p class="mt-1 text-sm text-slate-500">
                                            Important actions performed within your church account
                                            will appear here.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- =================================================
                 PAGINATION
            ================================================== --}}

            @if ($logs->hasPages())

                <div class="border-t border-slate-200 px-6 py-4">

                    {{ $logs->links() }}

                </div>

            @endif

        </div>

    </div>

@endsection