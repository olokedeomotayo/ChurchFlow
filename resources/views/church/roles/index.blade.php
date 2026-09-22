@extends('layouts.church')

@section('title', 'Roles')

@section('page-title', 'Roles')

@section('content')
    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">
                    Roles
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage the roles and permissions available to your church users.
                </p>
            </div>

            <a
                href="{{ route('church.roles.create') }}"
                class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-700"
            >
                + Create Role
            </a>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Roles --}}
        @if ($roles->isEmpty())
            <div class="rounded-xl border border-dashed border-slate-300 bg-white p-10 text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-500">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.5"
                            d="M12 4.5v15m7.5-7.5h-15"
                        />
                    </svg>
                </div>

                <h3 class="mt-4 text-sm font-semibold text-slate-900">
                    No roles found
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Create your first church role to manage user permissions.
                </p>

                <div class="mt-5">
                    <a
                        href="{{ route('church.roles.create') }}"
                        class="inline-flex cursor-pointer items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
                    >
                        Create Role
                    </a>
                </div>
            </div>
        @else
            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Role
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Type
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Users
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Permissions
                                </th>

                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @foreach ($roles as $role)
                                <tr class="hover:bg-slate-50">

                                    {{-- Role --}}
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="font-medium text-slate-900">
                                            {{ ucwords(str_replace('_', ' ', $role->name)) }}
                                        </div>

                                        <div class="mt-0.5 text-xs text-slate-400">
                                            {{ $role->name }}
                                        </div>
                                    </td>

                                    {{-- Type --}}
                                    <td class="whitespace-nowrap px-6 py-4">
                                        @if ($role->church_id === null)
                                            <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                                                System Role
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-medium text-indigo-700">
                                                Church Role
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Users --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                        {{ $role->users_count }}
                                    </td>

                                    {{-- Permissions --}}
                                    <td class="px-6 py-4">
                                        @if ($role->permissions->isEmpty())
                                            <span class="text-sm text-slate-400">
                                                No permissions
                                            </span>
                                        @else
                                            <div class="flex flex-wrap gap-1.5">
                                                @foreach ($role->permissions->take(4) as $permission)
                                                    <span class="inline-flex rounded-md bg-slate-100 px-2 py-1 text-xs text-slate-600">
                                                        {{ $permission->name }}
                                                    </span>
                                                @endforeach

                                                @if ($role->permissions->count() > 4)
                                                    <span class="inline-flex rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700">
                                                        +{{ $role->permissions->count() - 4 }} more
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </td>

                                    {{-- Actions --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-right">
                                        @if ($role->church_id === $church->id)
                                            <div class="flex items-center justify-end gap-2">

                                                <a
                                                    href="{{ route('church.roles.edit', $role) }}"
                                                    class="cursor-pointer rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-700 transition hover:bg-slate-50"
                                                >
                                                    Edit
                                                </a>

                                                @if ($role->users_count === 0)
                                                    <form
                                                        method="POST"
                                                        action="{{ route('church.roles.destroy', $role) }}"
                                                        onsubmit="return confirm('Are you sure you want to delete this role?');"
                                                    >
                                                        @csrf
                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            class="cursor-pointer rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 transition hover:bg-red-50"
                                                        >
                                                            Delete
                                                        </button>
                                                    </form>
                                                @endif

                                            </div>
                                        @else
                                            <span class="text-xs text-slate-400">
                                                System role
                                            </span>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        @endif

    </div>
@endsection