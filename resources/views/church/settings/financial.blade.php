@extends('layouts.church')

@section('title', 'Financial Settings')

@section('page_title', 'Financial Settings')

@section('page_description', 'Manage your church financial starting position')

@section('content')

    <div class="w-full space-y-6">

        {{-- ============================================================= --}}
        {{-- SUCCESS MESSAGE --}}
        {{-- ============================================================= --}}

        @if (session('success'))
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif


        {{-- ============================================================= --}}
        {{-- VALIDATION ERRORS --}}
        {{-- ============================================================= --}}

        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">

                <p class="font-semibold">
                    Please correct the following:
                </p>

                <ul class="mt-2 list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif


        {{-- ============================================================= --}}
        {{-- PAGE INTRODUCTION --}}
        {{-- ============================================================= --}}

        <div>
            <h1 class="text-xl font-bold text-slate-900">
                Opening Balance
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Set the financial starting position for
                <span class="font-medium text-slate-700">
                    {{ $church?->name ?? 'your church' }}
                </span>.
            </p>
        </div>


        {{-- ============================================================= --}}
        {{-- OPENING BALANCE --}}
        {{-- ============================================================= --}}

        <div class="w-full rounded-xl border border-slate-200 bg-white shadow-sm">

            {{-- Card Header --}}
            <div class="border-b border-slate-200 px-6 py-5">

                <h2 class="text-sm font-semibold text-slate-900">
                    Financial Starting Position
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    This represents the amount available to your church
                    when you begin using ChurchFlow.
                </p>

            </div>


            {{-- Form --}}
            <form
                method="POST"
                action="{{ route('church.settings.financial.update') }}"
                class="space-y-6 p-6"
            >

                @csrf

                @method('PUT')


               {{-- Opening Balance --}}
<div>

    <label
        for="opening_balance"
        class="mb-2 block text-sm font-medium text-slate-700"
    >
        Opening Balance
    </label>

    <div class="flex w-full">

        <span
            class="flex items-center rounded-l-lg border border-r-0 border-slate-300 bg-slate-50 px-4 text-sm font-semibold text-slate-600"
        >
            ₦
        </span>

        <input
            type="number"
            name="opening_balance"
            id="opening_balance"
            value="{{ old('opening_balance', $financialSetting->opening_balance) }}"
            min="0"
            step="0.01"
            required
            class="w-full rounded-r-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
            placeholder="0.00"
        >

    </div>

    <p class="mt-1.5 text-xs text-slate-500">
        Enter the amount available at the beginning of the selected date.
    </p>

</div>

                {{-- ===================================================== --}}
                {{-- OPENING BALANCE DATE --}}
                {{-- ===================================================== --}}

                <div>

                    <label
                        for="opening_balance_date"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Opening Balance Date
                    </label>

                    <input
                        type="date"
                        name="opening_balance_date"
                        id="opening_balance_date"
                        value="{{ old('opening_balance_date', $financialSetting->opening_balance_date?->format('Y-m-d')) }}"
                        required
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-100"
                    >

                    <p class="mt-1.5 text-xs text-slate-500">
                        Income and expenses recorded on or after this date
                        will affect the church's current balance.
                    </p>

                </div>


                {{-- ===================================================== --}}
                {{-- BALANCE CALCULATION INFORMATION --}}
                {{-- ===================================================== --}}

                <div class="rounded-lg border border-purple-200 bg-purple-50 p-4">

                    <p class="text-sm font-semibold text-purple-900">
                        How ChurchFlow calculates your balance
                    </p>

                    <div class="mt-3 space-y-1 text-sm text-purple-800">

                        <p>
                            Opening Balance
                        </p>

                        <p>
                            + Income from the opening date
                        </p>

                        <p>
                            − Expenses from the opening date
                        </p>

                        <p class="font-semibold">
                            = Current Balance
                        </p>

                    </div>

                </div>


                {{-- ===================================================== --}}
                {{-- FORM ACTIONS --}}
                {{-- ===================================================== --}}

                <div class="flex flex-col gap-3 border-t border-slate-200 pt-5 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('church.dashboard') }}"
                        class="cursor-pointer rounded-lg border border-slate-300 px-5 py-2.5 text-center text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="cursor-pointer rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700"
                    >
                        Save Opening Balance
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection