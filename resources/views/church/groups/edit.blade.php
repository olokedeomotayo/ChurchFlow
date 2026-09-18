@extends('layouts.church')

@section('title', 'Edit Group / Department')

@section('content')

<div class="w-full">

    {{-- ========================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ========================================================= --}}

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <a
                href="{{ route('church.groups.index') }}"
                class="inline-flex cursor-pointer items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-purple-600"
            >
                <span>←</span>
                <span>Back to Groups & Departments</span>
            </a>

            <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900">
                Edit {{ $group->name }}
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Update the details of this group or department.
            </p>

        </div>

        <a
            href="{{ route('church.groups.show', $group) }}"
            class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50"
        >
            View Group
        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- FORM CARD --}}
    {{-- ========================================================= --}}

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        {{-- Card Header --}}

        <div class="border-b border-slate-200 px-6 py-5">

            <h2 class="text-base font-semibold text-slate-900">
                Group Information
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Update the basic information for this group or department.
            </p>

        </div>


        {{-- Form --}}

        <form
            method="POST"
            action="{{ route('church.groups.update', $group) }}"
        >

            @csrf
            @method('PUT')


            <div class="space-y-6 p-6">

                {{-- ================================================= --}}
                {{-- NAME --}}
                {{-- ================================================= --}}

                <div>

                    <label
                        for="name"
                        class="block text-sm font-medium text-slate-700"
                    >
                        Name <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $group->name) }}"
                        required
                        class="mt-2 block w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                    >

                    @error('name')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- TYPE + STATUS --}}
                {{-- ================================================= --}}

                <div class="grid gap-6 md:grid-cols-2">

                    {{-- Type --}}

                    <div>

                        <label
                            for="type"
                            class="block text-sm font-medium text-slate-700"
                        >
                            Type <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="type"
                            name="type"
                            required
                            class="mt-2 block w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        >

                            <option
                                value="group"
                                @selected(old('type', $group->type) === 'group')
                            >
                                Group
                            </option>

                            <option
                                value="department"
                                @selected(old('type', $group->type) === 'department')
                            >
                                Department
                            </option>

                        </select>

                        @error('type')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Status --}}

                    <div>

                        <label
                            for="status"
                            class="block text-sm font-medium text-slate-700"
                        >
                            Status <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="status"
                            name="status"
                            required
                            class="mt-2 block w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                        >

                            <option
                                value="active"
                                @selected(old('status', $group->status) === 'active')
                            >
                                Active
                            </option>

                            <option
                                value="inactive"
                                @selected(old('status', $group->status) === 'inactive')
                            >
                                Inactive
                            </option>

                        </select>

                        @error('status')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- LEADER --}}
                {{-- ================================================= --}}

                <div>

                    <label
                        for="leader_id"
                        class="block text-sm font-medium text-slate-700"
                    >
                        Leader
                    </label>

                    <select
                        id="leader_id"
                        name="leader_id"
                        class="mt-2 block w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                    >

                        <option value="">
                            No leader assigned
                        </option>

                        @foreach($members as $member)

                            <option
                                value="{{ $member->id }}"
                                @selected(old('leader_id', $group->leader_id) == $member->id)
                            >
                                {{ $member->first_name }}
                                {{ $member->middle_name ? $member->middle_name . ' ' : '' }}
                                {{ $member->last_name }}
                            </option>

                        @endforeach

                    </select>

                    <p class="mt-2 text-xs text-slate-500">
                        Select a member to serve as the leader of this group or department.
                    </p>

                    @error('leader_id')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- DESCRIPTION --}}
                {{-- ================================================= --}}

                <div>

                    <label
                        for="description"
                        class="block text-sm font-medium text-slate-700"
                    >
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        placeholder="Briefly describe this group or department..."
                        class="mt-2 block w-full resize-y rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20"
                    >{{ old('description', $group->description) }}</textarea>

                    @error('description')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- ACTION BAR --}}
            {{-- ================================================= --}}

            <div class="flex flex-col gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">

                {{-- Delete --}}

                <button
                    type="button"
                    onclick="if (confirm('Are you sure you want to delete this group or department? This action cannot be undone.')) { document.getElementById('delete-group-form').submit(); }"
                    class="cursor-pointer inline-flex items-center justify-center rounded-lg border border-red-200 bg-white px-4 py-2.5 text-sm font-medium text-red-600 shadow-sm transition hover:bg-red-50"
                >
                    Delete
                </button>


                {{-- Right Actions --}}

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
                        Save Changes
                    </button>

                </div>

            </div>

        </form>

    </div>


    {{-- ========================================================= --}}
    {{-- DELETE FORM --}}
    {{-- ========================================================= --}}

    <form
        id="delete-group-form"
        method="POST"
        action="{{ route('church.groups.destroy', $group) }}"
        class="hidden"
    >

        @csrf
        @method('DELETE')

    </form>

</div>

@endsection