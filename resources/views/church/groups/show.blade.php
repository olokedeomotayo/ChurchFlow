@extends('layouts.church')

@section('title', $group->name)

@section('content')

<div class="w-full space-y-6">

    {{-- ========================================================= --}}
    {{-- PAGE HEADER --}}
    {{-- ========================================================= --}}

    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

        <div>

            <a
                href="{{ route('church.groups.index') }}"
                class="inline-flex cursor-pointer items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-purple-600"
            >
                <span>←</span>
                <span>Back to Groups & Departments</span>
            </a>

            <div class="mt-4 flex flex-wrap items-center gap-3">

                <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                    {{ $group->name }}
                </h1>

                @if($group->type === 'department')

                    <span class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                        Department
                    </span>

                @else

                    <span class="inline-flex items-center rounded-full bg-purple-50 px-3 py-1 text-xs font-semibold text-purple-700">
                        Group
                    </span>

                @endif

                @if($group->status === 'active')

                    <span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                        Active
                    </span>

                @else

                    <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                        Inactive
                    </span>

                @endif

            </div>

            <p class="mt-2 max-w-3xl text-sm text-slate-500">
                {{ $group->description ?: 'No description has been added for this group or department.' }}
            </p>

        </div>


        {{-- Actions --}}

        <div class="flex shrink-0 items-center gap-3">

            <a
                href="{{ route('church.groups.edit', $group) }}"
                class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700"
            >
                Edit
            </a>

            <form
                method="POST"
                action="{{ route('church.groups.destroy', $group) }}"
                onsubmit="return confirm('Are you sure you want to delete this group or department? This action cannot be undone.');"
            >

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-red-200 bg-white px-4 py-2.5 text-sm font-semibold text-red-600 shadow-sm transition hover:bg-red-50"
                >
                    Delete
                </button>

            </form>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- OVERVIEW CARDS --}}
    {{-- ========================================================= --}}

    <div class="grid gap-5 md:grid-cols-3">

        {{-- Leader --}}

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex items-center gap-3">

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-purple-50 text-purple-600">

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                        />
                    </svg>

                </div>

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Leader
                    </p>

                    @if($group->leader)

                        <p class="mt-1 font-semibold text-slate-900">
                            {{ $group->leader->first_name }}
                            {{ $group->leader->middle_name ? $group->leader->middle_name . ' ' : '' }}
                            {{ $group->leader->last_name }}
                        </p>

                    @else

                        <p class="mt-1 text-sm text-slate-400">
                            Not assigned
                        </p>

                    @endif

                </div>

            </div>

        </div>


        {{-- Members --}}

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex items-center gap-3">

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600">

                    <svg
                        class="h-5 w-5"
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

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Members
                    </p>

                    <p class="mt-1 text-xl font-bold text-slate-900">
                        {{ $group->members->count() }}
                    </p>

                </div>

            </div>

        </div>


        {{-- Status --}}

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex items-center gap-3">

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-green-50 text-green-600">

                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                </div>

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Status
                    </p>

                    <p class="mt-1 font-semibold text-slate-900">
                        {{ ucfirst($group->status) }}
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- GROUP DETAILS --}}
    {{-- ========================================================= --}}

    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">

            <h2 class="text-base font-semibold text-slate-900">
                Group Details
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Basic information about this group or department.
            </p>

        </div>

        <div class="grid gap-6 p-6 sm:grid-cols-2 lg:grid-cols-4">

            <div>

                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                    Name
                </p>

                <p class="mt-2 text-sm font-medium text-slate-900">
                    {{ $group->name }}
                </p>

            </div>


            <div>

                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                    Type
                </p>

                <p class="mt-2 text-sm font-medium text-slate-900">
                    {{ ucfirst($group->type) }}
                </p>

            </div>


            <div>

                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                    Status
                </p>

                <p class="mt-2 text-sm font-medium text-slate-900">
                    {{ ucfirst($group->status) }}
                </p>

            </div>


            <div>

                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                    Created
                </p>

                <p class="mt-2 text-sm font-medium text-slate-900">
                    {{ $group->created_at?->format('d M Y') ?? '—' }}
                </p>

            </div>

        </div>

        @if($group->description)

            <div class="border-t border-slate-200 px-6 py-5">

                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                    Description
                </p>

                <p class="mt-2 max-w-4xl whitespace-pre-line text-sm leading-6 text-slate-600">
                    {{ $group->description }}
                </p>

            </div>

        @endif

    </div>


    {{-- ========================================================= --}}
    {{-- MEMBERS --}}
    {{-- ========================================================= --}}

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h2 class="text-base font-semibold text-slate-900">
                    Members
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Members assigned to {{ $group->name }}.
                </p>

            </div>

            <a
    href="{{ route('church.groups.members.edit', $group) }}"
    class="inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-purple-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-purple-700"
>
    <span class="text-lg leading-none">
        +
    </span>

    Add Members
</a>
                <span class="text-lg leading-none">
                    +
                </span>

                Add Members
            </button>

        </div>


        @if($group->members->count())

            <div class="overflow-x-auto">

                <table class="w-full text-left">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Member
                            </th>

                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Phone
                            </th>

                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Email
                            </th>

                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @foreach($group->members as $member)

                            <tr class="transition hover:bg-slate-50">

                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-purple-50 text-xs font-bold text-purple-600">
                                            {{ strtoupper(substr($member->first_name, 0, 1)) }}
                                        </div>

                                        <div>

                                            <p class="font-medium text-slate-900">
                                                {{ $member->first_name }}
                                                {{ $member->middle_name ? $member->middle_name . ' ' : '' }}
                                                {{ $member->last_name }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $member->phone ?: '—' }}
                                </td>


                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $member->email ?: '—' }}
                                </td>


                                <td class="px-6 py-4 text-right">

                                    <a
                                        href="{{ route('church.members.show', $member) }}"
                                        class="cursor-pointer text-sm font-medium text-purple-600 transition hover:text-purple-800"
                                    >
                                        View Member
                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="px-6 py-14 text-center">

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
                    No members yet
                </h3>

                <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                    There are currently no members assigned to this group or department.
                </p>

            </div>

        @endif

    </div>

</div>

@endsection