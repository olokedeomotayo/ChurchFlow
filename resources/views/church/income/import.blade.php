@extends('layouts.church')

@section('title', 'Import Income')

@section('content')
<div class="mx-auto max-w-4xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Import Income
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Import multiple income records from a CSV file.
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

    {{-- Import Card --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 bg-slate-50 px-6 py-5">
            <h2 class="text-base font-semibold text-slate-900">
                Upload CSV File
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Select a CSV file containing your church income records.
            </p>
        </div>

        <form
            method="POST"
            action="{{ route('church.income.import.store') }}"
            enctype="multipart/form-data"
            class="space-y-6 p-6"
        >
            @csrf

            {{-- File Upload --}}
            <div>
                <label
                    for="file"
                    class="mb-2 block text-sm font-medium text-slate-700"
                >
                    CSV File <span class="text-red-500">*</span>
                </label>

                <label
                    for="file"
                    class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 px-6 py-10 text-center transition hover:border-purple-400 hover:bg-purple-50"
                >
                    <svg
                        class="h-10 w-10 text-slate-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 0115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                        />
                    </svg>

                    <span class="mt-3 text-sm font-semibold text-slate-700">
                        Click to select your CSV file
                    </span>

                    <span class="mt-1 text-xs text-slate-500">
                        CSV or TXT file, maximum 5MB
                    </span>

                    <span
                        id="selected-file"
                        class="mt-3 hidden rounded-lg bg-purple-100 px-3 py-1.5 text-xs font-semibold text-purple-700"
                    ></span>

                    <input
                        type="file"
                        id="file"
                        name="file"
                        accept=".csv,.txt"
                        required
                        class="hidden"
                        onchange="showSelectedFile(this)"
                    >
                </label>

                @error('file')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- CSV Format --}}
            <div class="rounded-lg border border-blue-200 bg-blue-50 p-5">

                <div class="flex items-start gap-3">

                    <svg
                        class="mt-0.5 h-5 w-5 shrink-0 text-blue-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"
                        />
                    </svg>

                    <div>
                        <h3 class="text-sm font-semibold text-blue-900">
                            CSV Format
                        </h3>

                        <p class="mt-1 text-sm leading-6 text-blue-800">
                            Your CSV file must contain these required columns:
                        </p>

                        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-blue-800">
                            <li><strong>Category</strong></li>
                            <li><strong>Amount</strong></li>
                            <li><strong>Income Date</strong></li>
                        </ul>

                        <p class="mt-3 text-sm text-blue-800">
                            Optional columns include:
                        </p>

                        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-blue-800">
                            <li><strong>Financial Account</strong></li>
                            <li><strong>Member ID</strong></li>
                            <li><strong>Source</strong></li>
                            <li><strong>Payment Method</strong></li>
                            <li><strong>Reference</strong></li>
                            <li><strong>Description</strong></li>
                        </ul>

                        <div class="mt-4 rounded-lg border border-blue-200 bg-white/60 p-3">
                            <p class="text-xs leading-5 text-blue-800">
                                <strong>Financial Account:</strong>
                                Enter the exact name of the financial account
                                where the income was received.
                            </p>

                            <p class="mt-2 text-xs leading-5 text-blue-800">
                                If the Financial Account column is left blank,
                                the income will be assigned to the church's
                                default active financial account.
                            </p>
                        </div>
                    </div>

                </div>

            </div>

            {{-- Active Account Information --}}
            @if(isset($accounts))

                @if($accounts->isNotEmpty())

                    <div class="rounded-lg border border-slate-200 bg-slate-50 p-5">

                        <h3 class="text-sm font-semibold text-slate-900">
                            Available Financial Accounts
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Use these exact account names in your CSV file.
                        </p>

                        <div class="mt-4 grid grid-cols-1 gap-2 sm:grid-cols-2">

                            @foreach($accounts as $account)
                                <div class="flex items-center justify-between rounded-lg border border-slate-200 bg-white px-3 py-2.5">

                                    <span class="text-sm font-medium text-slate-700">
                                        {{ $account->name }}
                                    </span>

                                    @if($account->is_default)
                                        <span class="ml-2 inline-flex shrink-0 rounded-full bg-purple-100 px-2 py-0.5 text-xs font-semibold text-purple-700">
                                            Default
                                        </span>
                                    @endif

                                </div>
                            @endforeach

                        </div>

                    </div>

                @else

                    <div class="rounded-lg border border-amber-200 bg-amber-50 p-5">

                        <div class="flex items-start gap-3">

                            <svg
                                class="mt-0.5 h-5 w-5 shrink-0 text-amber-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v2m0 4h.01M12 20a8 8 0 100-16 8 8 0 000 16z"
                                />
                            </svg>

                            <div>
                                <h3 class="text-sm font-semibold text-amber-900">
                                    No Active Financial Account
                                </h3>

                                <p class="mt-1 text-sm leading-6 text-amber-800">
                                    You need at least one active financial account
                                    before importing income records.
                                </p>

                                <a
                                    href="{{ route('church.settings.financial-accounts.create') }}"
                                    class="mt-3 inline-flex cursor-pointer items-center rounded-lg bg-amber-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-amber-700"
                                >
                                    Create Financial Account
                                </a>
                            </div>

                        </div>

                    </div>

                @endif

            @endif

            {{-- Template --}}
            <div class="rounded-lg border border-purple-200 bg-purple-50 p-5">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h3 class="text-sm font-semibold text-purple-900">
                            Need the correct CSV format?
                        </h3>

                        <p class="mt-1 text-sm text-purple-700">
                            Download our template and fill it with your income records.
                        </p>
                    </div>

                    <a
                        href="{{ route('church.income.template') }}"
                        class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-purple-300 bg-white px-4 py-2.5 text-sm font-semibold text-purple-700 transition hover:bg-purple-100"
                    >
                        <svg
                            class="mr-2 h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                            />
                        </svg>

                        Download Template
                    </a>

                </div>

            </div>

            {{-- Actions --}}
            <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('church.income.index') }}"
                    class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    @disabled(isset($accounts) && $accounts->isEmpty())
                    class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    <svg
                        class="mr-2 h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 0115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v8"
                        />
                    </svg>

                    Import Income
                </button>

            </div>

        </form>

    </div>

</div>

<script>
    function showSelectedFile(input) {
        const selectedFile = document.getElementById('selected-file');

        if (input.files && input.files.length > 0) {
            selectedFile.textContent = input.files[0].name;
            selectedFile.classList.remove('hidden');
        } else {
            selectedFile.textContent = '';
            selectedFile.classList.add('hidden');
        }
    }
</script>
@endsection