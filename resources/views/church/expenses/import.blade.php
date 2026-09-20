@extends('layouts.church')

@section('content')

<div class="mx-auto max-w-4xl space-y-6">

    {{-- Header --}}
    <div>
        <a
            href="{{ route('church.expenses.index') }}"
            class="inline-flex cursor-pointer items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-purple-600"
        >
            ← Back to Expenses
        </a>

        <h1 class="mt-4 text-2xl font-bold text-slate-900">
            Import Expenses
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Import multiple expense records using a CSV file.
        </p>
    </div>


    {{-- Error Message --}}
    @if(session('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif


    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4">

            <p class="mb-2 text-sm font-semibold text-red-800">
                Please correct the following errors:
            </p>

            <ul class="list-inside list-disc space-y-1 text-sm text-red-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif


    {{-- Upload Card --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">

            <h2 class="font-semibold text-slate-900">
                Upload CSV File
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Select a CSV file containing your expense records.
            </p>

        </div>


        <form
            method="POST"
            action="{{ route('church.expenses.import.store') }}"
            enctype="multipart/form-data"
            class="space-y-6 p-6"
        >

            @csrf

            <div>

                <label
                    for="file"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    CSV File
                </label>

                <input
                    type="file"
                    id="file"
                    name="file"
                    accept=".csv,.txt"
                    required
                    class="block w-full cursor-pointer rounded-lg border border-slate-300 bg-white text-sm text-slate-600 file:mr-4 file:cursor-pointer file:border-0 file:bg-slate-100 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-200"
                >

                <p class="mt-2 text-xs text-slate-500">
                    Maximum file size: 5 MB. Accepted formats: CSV or TXT.
                </p>

            </div>


            {{-- Actions --}}
            <div class="flex flex-col gap-3 border-t border-slate-200 pt-5 sm:flex-row sm:items-center sm:justify-between">

                <a
                    href="{{ route('church.expenses.template') }}"
                    class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    ↓ Download Template
                </a>

                <div class="flex gap-3">

                    <a
                        href="{{ route('church.expenses.index') }}"
                        class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700"
                    >
                        Import Expenses
                    </button>

                </div>

            </div>

        </form>

    </div>


    {{-- CSV Format --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">

            <h2 class="font-semibold text-slate-900">
                CSV Format
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Your CSV file should contain the following columns.
            </p>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Column
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Required
                        </th>

                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Description
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100 text-sm">

                    <tr>
                        <td class="px-5 py-3 font-medium text-slate-900">
                            Member ID
                        </td>

                        <td class="px-5 py-3 text-slate-500">
                            No
                        </td>

                        <td class="px-5 py-3 text-slate-600">
                            Matches an existing member in this church.
                        </td>
                    </tr>

                    <tr>
                        <td class="px-5 py-3 font-medium text-slate-900">
                            Category
                        </td>

                        <td class="px-5 py-3 font-semibold text-red-600">
                            Yes
                        </td>

                        <td class="px-5 py-3 text-slate-600">
                            Expense category such as Utilities or Transport.
                        </td>
                    </tr>

                    <tr>
                        <td class="px-5 py-3 font-medium text-slate-900">
                            Description
                        </td>

                        <td class="px-5 py-3 text-slate-500">
                            No
                        </td>

                        <td class="px-5 py-3 text-slate-600">
                            Description of the expense.
                        </td>
                    </tr>

                    <tr>
                        <td class="px-5 py-3 font-medium text-slate-900">
                            Amount
                        </td>

                        <td class="px-5 py-3 font-semibold text-red-600">
                            Yes
                        </td>

                        <td class="px-5 py-3 text-slate-600">
                            Expense amount.
                        </td>
                    </tr>

                    <tr>
                        <td class="px-5 py-3 font-medium text-slate-900">
                            Expense Date
                        </td>

                        <td class="px-5 py-3 font-semibold text-red-600">
                            Yes
                        </td>

                        <td class="px-5 py-3 text-slate-600">
                            Date of the expense.
                        </td>
                    </tr>

                    <tr>
                        <td class="px-5 py-3 font-medium text-slate-900">
                            Payment Method
                        </td>

                        <td class="px-5 py-3 text-slate-500">
                            No
                        </td>

                        <td class="px-5 py-3 text-slate-600">
                            Cash, bank transfer, card, cheque, etc.
                        </td>
                    </tr>

                    <tr>
                        <td class="px-5 py-3 font-medium text-slate-900">
                            Reference
                        </td>

                        <td class="px-5 py-3 text-slate-500">
                            No
                        </td>

                        <td class="px-5 py-3 text-slate-600">
                            Payment or transaction reference.
                        </td>
                    </tr>

                    <tr>
                        <td class="px-5 py-3 font-medium text-slate-900">
                            Vendor
                        </td>

                        <td class="px-5 py-3 text-slate-500">
                            No
                        </td>

                        <td class="px-5 py-3 text-slate-600">
                            Vendor or person paid.
                        </td>
                    </tr>

                    <tr>
                        <td class="px-5 py-3 font-medium text-slate-900">
                            Notes
                        </td>

                        <td class="px-5 py-3 text-slate-500">
                            No
                        </td>

                        <td class="px-5 py-3 text-slate-600">
                            Additional information.
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>


    {{-- Important Note --}}
    <div class="rounded-xl border border-purple-200 bg-purple-50 p-5">

        <h3 class="text-sm font-semibold text-purple-900">
            Import Tips
        </h3>

        <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-purple-800">

            <li>
                Download the template first to ensure the column names are correct.
            </li>

            <li>
                Category, Amount, and Expense Date are required.
            </li>

            <li>
                Member ID is optional and must belong to this church.
            </li>

            <li>
                Invalid rows will be skipped during import.
            </li>

        </ul>

    </div>

</div>

@endsection