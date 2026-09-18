@extends('layouts.church')

@section('title', 'Manage Group Members')

@section('content')

<div class="w-full space-y-6">

    {{-- ========================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ========================================================= --}}

    <div>

        <a
            href="{{ route('church.groups.show', $group) }}"
            class="inline-flex cursor-pointer items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-purple-600"
        >
            <span>←</span>
            <span>Back to {{ $group->name }}</span>
        </a>

        <h1 class="mt-4 text-2xl font-bold tracking-tight text-slate-900">
            Manage Members
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Add or remove members from
            <span class="font-medium text-slate-700">
                {{ $group->name }}
            </span>.
        </p>

    </div>


    {{-- ========================================================= --}}
    {{-- FORM CARD --}}
    {{-- ========================================================= --}}

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        {{-- Card Header --}}

        <div class="border-b border-slate-200 px-6 py-5">

            <div class="flex items-center justify-between gap-4">

                <div>

                    <h2 class="text-base font-semibold text-slate-900">
                        Church Members
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Select the members who should belong to this
                        {{ $group->type === 'department' ? 'department' : 'group' }}.
                    </p>

                </div>

                <div class="shrink-0 rounded-lg bg-purple-50 px-3 py-2 text-sm font-semibold text-purple-700">
                    {{ count($assignedMemberIds) }} Selected
                </div>

            </div>

        </div>


        {{-- Form --}}

        <form
            method="POST"
            action="{{ route('church.groups.members.update', $group) }}"
        >

            @csrf
            @method('PUT')


            <div class="p-6">

                @error('member_ids')

                    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        {{ $message }}
                    </div>

                @enderror


                @error('member_ids.*')

                    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        {{ $message }}
                    </div>

                @enderror


                {{-- ================================================= --}}
                {{-- SELECT ALL --}}
                {{-- ================================================= --}}

                @if($members->count())

                    <div class="mb-5 flex items-center justify-between border-b border-slate-200 pb-4">

                        <label class="inline-flex cursor-pointer items-center gap-3">

                            <input
                                type="checkbox"
                                id="select-all-members"
                                class="h-4 w-4 cursor-pointer rounded border-slate-300 text-purple-600 focus:ring-purple-500"
                            >

                            <span class="text-sm font-medium text-slate-700">
                                Select all members
                            </span>

                        </label>

                        <span class="text-sm text-slate-500">
                            {{ $members->count() }}
                            {{ $members->count() === 1 ? 'member' : 'members' }}
                        </span>

                    </div>


                    {{-- ================================================= --}}
                    {{-- MEMBER LIST --}}
                    {{-- ================================================= --}}

                    <div class="divide-y divide-slate-100 rounded-lg border border-slate-200">

                        @foreach($members as $member)

                            @php
                                $isAssigned = in_array($member->id, $assignedMemberIds);
                            @endphp

                            <label
                                for="member_{{ $member->id }}"
                                class="group flex cursor-pointer items-center gap-4 px-4 py-4 transition hover:bg-slate-50"
                            >

                                {{-- Checkbox --}}

                                <input
                                    type="checkbox"
                                    id="member_{{ $member->id }}"
                                    name="member_ids[]"
                                    value="{{ $member->id }}"
                                    @checked($isAssigned)
                                    class="member-checkbox h-4 w-4 cursor-pointer rounded border-slate-300 text-purple-600 focus:ring-purple-500"
                                >


                                {{-- Avatar --}}

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-purple-50 text-sm font-bold text-purple-600">

                                    {{ strtoupper(substr($member->first_name, 0, 1)) }}

                                </div>


                                {{-- Member Details --}}

                                <div class="min-w-0 flex-1">

                                    <p class="truncate text-sm font-semibold text-slate-900">

                                        {{ $member->first_name }}

                                        @if($member->middle_name)
                                            {{ $member->middle_name }}
                                        @endif

                                        {{ $member->last_name }}

                                    </p>

                                    <div class="mt-1 flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-500">

                                        @if($member->email)

                                            <span>
                                                {{ $member->email }}
                                            </span>

                                        @endif

                                        @if($member->phone)

                                            <span>
                                                {{ $member->phone }}
                                            </span>

                                        @endif

                                    </div>

                                </div>


                                {{-- Current Status --}}

                                @if($isAssigned)

                                    <span class="shrink-0 rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                        Assigned
                                    </span>

                                @endif

                            </label>

                        @endforeach

                    </div>

                @else

                    {{-- ================================================= --}}
                    {{-- NO MEMBERS --}}
                    {{-- ================================================= --}}

                    <div class="rounded-xl border border-dashed border-slate-300 px-6 py-14 text-center">

                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-500">

                            <svg
                                class="h-6 w-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 20h5v-2a4 4 0 00-4-4h-1
                                       M9 20H4v-2a4 4 0 014-4h1
                                       M12 12a4 4 0 100-8 4 4 0 000 8z"
                                />

                            </svg>

                        </div>

                        <h3 class="mt-4 text-sm font-semibold text-slate-900">
                            No church members found
                        </h3>

                        <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                            Add members to your church before assigning them to a group or department.
                        </p>

                        <a
                            href="{{ route('church.members.create') }}"
                            class="mt-5 inline-flex cursor-pointer items-center gap-2 rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700"
                        >
                            Add Member
                        </a>

                    </div>

                @endif

            </div>


            {{-- ================================================= --}}
            {{-- ACTION BAR --}}
            {{-- ================================================= --}}

            <div class="flex flex-col gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">

                <p class="text-xs text-slate-500">
                    Changes will replace the current member assignments.
                </p>

                <div class="flex items-center gap-3">

                    <a
                        href="{{ route('church.groups.show', $group) }}"
                        class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700"
                    >
                        Save Members
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


{{-- ========================================================= --}}
{{-- SELECT ALL SCRIPT --}}
{{-- ========================================================= --}}

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const selectAll = document.getElementById('select-all-members');

        const checkboxes = document.querySelectorAll('.member-checkbox');

        if (!selectAll) {
            return;
        }

        selectAll.addEventListener('change', function () {

            checkboxes.forEach(function (checkbox) {

                checkbox.checked = selectAll.checked;

            });

        });

        checkboxes.forEach(function (checkbox) {

            checkbox.addEventListener('change', function () {

                const checkedCount =
                    document.querySelectorAll('.member-checkbox:checked').length;

                selectAll.checked =
                    checkedCount === checkboxes.length;

                selectAll.indeterminate =
                    checkedCount > 0 &&
                    checkedCount < checkboxes.length;

            });

        });

        const initialChecked =
            document.querySelectorAll('.member-checkbox:checked').length;

        selectAll.checked =
            initialChecked === checkboxes.length;

        selectAll.indeterminate =
            initialChecked > 0 &&
            initialChecked < checkboxes.length;

    });

</script>

@endsection