@extends('layouts.church')

@section('title', 'Groups & Departments')

@section('content')

<div class="w-full space-y-6">

    {{-- ========================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ========================================================= --}}

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Groups & Departments
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Manage your church groups, departments, leaders and members.
            </p>
        </div>

        <a
            href="{{ route('church.groups.create') }}"
            class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700"
        >
            <span class="text-lg leading-none">+</span>

            <span>
                Add Group / Department
            </span>
        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- FLASH MESSAGE --}}
    {{-- ========================================================= --}}

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


    {{-- ========================================================= --}}
    {{-- SUMMARY CARDS --}}
    {{-- ========================================================= --}}

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

        {{-- Total --}}

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total
                    </p>

                    <p class="mt-1 text-2xl font-bold text-slate-900">
                        {{ $groups->total() }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-purple-50 text-purple-600">
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
                               M12 12a4 4 0 100-8 4 4 0 000 8z
                               M17 8a3 3 0 100-6
                               M7 8a3 3 0 110-6"
                        />
                    </svg>
                </div>

            </div>

        </div>


        {{-- Groups --}}

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Groups
                    </p>

                    <p class="mt-1 text-2xl font-bold text-slate-900">
                        {{ $groups->getCollection()->where('type', 'group')->count() }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                    <span class="text-lg font-bold">
                        G
                    </span>
                </div>

            </div>

        </div>


        {{-- Departments --}}

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Departments
                    </p>

                    <p class="mt-1 text-2xl font-bold text-slate-900">
                        {{ $groups->getCollection()->where('type', 'department')->count() }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                    <span class="text-lg font-bold">
                        D
                    </span>
                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- GROUPS TABLE --}}
    {{-- ========================================================= --}}

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-4">

            <h2 class="text-base font-semibold text-slate-900">
                All Groups & Departments
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                View and manage your church groups and departments.
            </p>

        </div>


        @if($groups->count())

            <div class="overflow-x-auto">

                <table class="w-full text-left">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Name
                            </th>

                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Type
                            </th>

                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Leader
                            </th>

                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Members
                            </th>

                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Status
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @foreach($groups as $group)

                            <tr class="transition hover:bg-slate-50">

                                {{-- Name --}}

                                <td class="px-6 py-4">

                                    <a
                                        href="{{ route('church.groups.show', $group) }}"
                                        class="cursor-pointer font-semibold text-slate-900 hover:text-purple-600"
                                    >
                                        {{ $group->name }}
                                    </a>

                                    @if($group->description)

                                        <p class="mt-1 max-w-xs truncate text-xs text-slate-500">
                                            {{ $group->description }}
                                        </p>

                                    @endif

                                </td>


                                {{-- Type --}}

                                <td class="px-6 py-4">

                                    @if($group->type === 'department')

                                        <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700">
                                            Department
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-purple-50 px-2.5 py-1 text-xs font-semibold text-purple-700">
                                            Group
                                        </span>

                                    @endif

                                </td>


                                {{-- Leader --}}

                                <td class="px-6 py-4 text-sm text-slate-600">

                                    @if($group->leader)

                                        {{ $group->leader->first_name }}
                                        {{ $group->leader->last_name }}

                                    @else

                                        <span class="text-slate-400">
                                            Not assigned
                                        </span>

                                    @endif

                                </td>


                                {{-- Members --}}

                                <td class="px-6 py-4">

                                    <span class="text-sm font-semibold text-slate-700">
                                        {{ $group->members->count() }}
                                    </span>

                                </td>


                                {{-- Status --}}

                                <td class="px-6 py-4">

                                    @if($group->status === 'active')

                                        <span class="inline-flex rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                            Active
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                            Inactive
                                        </span>

                                    @endif

                                </td>


                                {{-- Actions --}}

                                <td class="px-6 py-4">

                                    <div class="flex items-center justify-end gap-3">

                                        <a
                                            href="{{ route('church.groups.show', $group) }}"
                                            class="cursor-pointer text-sm font-medium text-slate-600 hover:text-purple-600"
                                        >
                                            View
                                        </a>

                                        <a
                                            href="{{ route('church.groups.edit', $group) }}"
                                            class="cursor-pointer text-sm font-medium text-purple-600 hover:text-purple-800"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('church.groups.destroy', $group) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this group or department?');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="cursor-pointer text-sm font-medium text-red-600 hover:text-red-800"
                                            >
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}

            @if($groups->hasPages())

                <div class="border-t border-slate-200 px-6 py-4">
                    {{ $groups->links() }}
                </div>

            @endif

        @else

            {{-- Empty State --}}

            <div class="px-6 py-16 text-center">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-purple-50 text-purple-600">

                    <svg
                        class="h-7 w-7"
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

                <h3 class="mt-4 text-base font-semibold text-slate-900">
                    No groups or departments yet
                </h3>

                <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                    Create your first group or department to start organizing your church members.
                </p>

                <a
                    href="{{ route('church.groups.create') }}"
                    class="mt-5 inline-flex cursor-pointer items-center gap-2 rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-purple-700"
                >
                    <span>+</span>
                    Add Group / Department
                </a>

            </div>

        @endif

    </div>

</div>

@endsection