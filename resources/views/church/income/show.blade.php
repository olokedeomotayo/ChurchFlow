@extends('layouts.church')

@section('title', 'Income Details')

@section('content')
<div class="mx-auto max-w-4xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Income Details
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                View the complete details of this income transaction.
            </p>
        </div>

        <a
            href="{{ route('church.income.index') }}"
            class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
        >
            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M10 19l-7-7m0 0l7-7m-7 7h18"
                />
            </svg>

            Back to Income
        </a>
    </div>

    {{-- Main Details Card --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        {{-- Amount Header --}}
        <div class="border-b border-slate-200 bg-gradient-to-r from-purple-50 to-white px-6 py-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Income Amount
                    </p>

                    <p class="mt-1 text-3xl font-bold text-purple-700">
                        ₦{{ number_format((float) $income->amount, 2) }}
                    </p>
                </div>

                <div>
                    <span class="inline-flex rounded-full bg-purple-100 px-3 py-1.5 text-sm font-semibold text-purple-700">
                        {{ $income->category }}
                    </span>
                </div>

            </div>
        </div>

        {{-- Details --}}
        <div class="px-6 py-6">

            <div class="grid grid-cols-1 gap-x-8 gap-y-6 md:grid-cols-2">

                {{-- Category --}}
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Category
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-900">
                        {{ $income->category }}
                    </p>
                </div>

                {{-- Source --}}
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Source
                    </p>

                    <p class="mt-1 text-sm text-slate-900">
                        {{ $income->source ?: '—' }}
                    </p>
                </div>

                {{-- Income Date --}}
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Income Date
                    </p>

                    <p class="mt-1 text-sm text-slate-900">
                        {{ $income->income_date?->format('d M Y') ?? '—' }}
                    </p>
                </div>

                {{-- Payment Method --}}
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Payment Method
                    </p>

                    <p class="mt-1 text-sm text-slate-900">
                        {{ $income->payment_method
                            ? ucwords(str_replace('_', ' ', $income->payment_method))
                            : '—'
                        }}
                    </p>
                </div>

                {{-- Reference --}}
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Reference
                    </p>

                    <p class="mt-1 text-sm text-slate-900">
                        {{ $income->reference ?: '—' }}
                    </p>
                </div>

                {{-- Member --}}
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Member
                    </p>

                    @if($income->member)
                        <p class="mt-1 text-sm font-medium text-slate-900">
                            {{ $income->member->first_name }}
                            {{ $income->member->middle_name ? $income->member->middle_name . ' ' : '' }}
                            {{ $income->member->last_name }}
                        </p>

                        @if($income->member->member_id)
                            <p class="mt-0.5 text-xs text-slate-500">
                                {{ $income->member->member_id }}
                            </p>
                        @endif
                    @else
                        <p class="mt-1 text-sm text-slate-500">
                            Not linked to a member
                        </p>
                    @endif
                </div>

            </div>

            {{-- Description --}}
            <div class="mt-8 border-t border-slate-200 pt-6">

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    Description
                </p>

                <div class="mt-2 rounded-lg bg-slate-50 p-4">
                    @if($income->description)
                        <p class="whitespace-pre-line text-sm leading-6 text-slate-700">
                            {{ $income->description }}
                        </p>
                    @else
                        <p class="text-sm text-slate-400">
                            No description provided.
                        </p>
                    @endif
                </div>

            </div>

            {{-- Record Information --}}
            <div class="mt-8 border-t border-slate-200 pt-6">

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Recorded
                        </p>

                        <p class="mt-1 text-sm text-slate-700">
                            {{ $income->created_at?->format('d M Y, h:i A') ?? '—' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Last Updated
                        </p>

                        <p class="mt-1 text-sm text-slate-700">
                            {{ $income->updated_at?->format('d M Y, h:i A') ?? '—' }}
                        </p>
                    </div>

                </div>

            </div>

        </div>

        {{-- Actions --}}
        <div class="flex flex-col gap-3 border-t border-slate-200 bg-slate-50 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

            <form
                method="POST"
                action="{{ route('church.income.destroy', $income) }}"
                onsubmit="return confirm('Are you sure you want to delete this income record?');"
            >
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-red-200 bg-white px-4 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50"
                >
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m-4 0h14"
                        />
                    </svg>

                    Delete Income
                </button>
            </form>

            <div class="flex flex-col gap-3 sm:flex-row">

                <a
                    href="{{ route('church.income.index') }}"
                    class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Back
                </a>

                <a
                    href="{{ route('church.income.edit', $income) }}"
                    class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700"
                >
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2.121 2.121 0 013 3L12 14l-4 1 1-4 7.5-7.5z"
                        />
                    </svg>

                    Edit Income
                </a>

            </div>

        </div>

    </div>

</div>
@endsection