@extends('layouts.church')

@section('title', 'Add Group / Department')

@section('content')

<div class="w-full space-y-6">

    {{-- Header --}}

    <div>
        <a
            href="{{ route('church.groups.index') }}"
            class="inline-flex cursor-pointer items-center gap-2 text-sm font-medium text-slate-500 hover:text-purple-600"
        >
            ← Back to Groups & Departments
        </a>

        <h1 class="mt-4 text-2xl font-bold tracking-tight text-slate-900">
            Add Group / Department
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Create a new group or department for your church.
        </p>
    </div>


    {{-- Form --}}

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

        <form
            method="POST"
            action="{{ route('church.groups.store') }}"
        >

            @csrf

            <div class="space-y-6 p-6">

                {{-- Name --}}

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
                        value="{{ old('name') }}"
                        required
                        placeholder="e.g. Men's Fellowship"
                        class="mt-2 block w-full rounded-lg border-slate-300 px-4 py-2.5 text-sm shadow-sm focus:border-purple-500 focus:ring-purple-500"
                    >

                    @error('name')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Type + Status --}}

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
                            class="mt-2 block w-full rounded-lg border-slate-300 px-4 py-2.5 text-sm shadow-sm focus:border-purple-500 focus:ring-purple-500"
                        >

                            <option value="">
                                Select type
                            </option>

                            <option
                                value="group"
                                @selected(old('type') === 'group')
                            >
                                Group
                            </option>

                            <option
                                value="department"
                                @selected(old('type') === 'department')
                            >
                                Department
                            </option>

                        </select>

                        @error('type')
                            <p class="mt-1 text-sm text-red-600">
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
                            class="mt-2 block w-full rounded-lg border-slate-300 px-4 py-2.5 text-sm shadow-sm focus:border-purple-500 focus:ring-purple-500"
                        >

                            <option
                                value="active"
                                @selected(old('status', 'active') === 'active')
                            >
                                Active
                            </option>

                            <option
                                value="inactive"
                                @selected(old('status') === 'inactive')
                            >
                                Inactive
                            </option>

                        </select>

                        @error('status')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>


                {{-- Leader --}}

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
                        class="mt-2 block w-full rounded-lg border-slate-300 px-4 py-2.5 text-sm shadow-sm focus:border-purple-500 focus:ring-purple-500"
                    >

                        <option value="">
                            No leader assigned
                        </option>

                        @foreach($members as $member)

                            <option
                                value="{{ $member->id }}"
                                @selected(old('leader_id') == $member->id)
                            >
                                {{ $member->first_name }}
                                {{ $member->middle_name ? $member->middle_name . ' ' : '' }}
                                {{ $member->last_name }}
                            </option>

                        @endforeach

                    </select>

                    <p class="mt-1 text-xs text-slate-500">
                        You can assign a leader now or assign one later.
                    </p>

                    @error('leader_id')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Description --}}

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
                        class="mt-2 block w-full rounded-lg border-slate-300 px-4 py-3 text-sm shadow-sm focus:border-purple-500 focus:ring-purple-500"
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>


            {{-- Footer --}}

            <div class="flex items-center justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4">

                <a
                    href="{{ route('church.groups.index') }}"
                    class="cursor-pointer rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-100"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="cursor-pointer rounded-lg bg-purple-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700"
                >
                    Create Group / Department
                </button>

            </div>

        </form>

    </div>

</div>

@endsection