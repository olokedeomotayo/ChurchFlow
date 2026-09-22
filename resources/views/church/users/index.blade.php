@extends('layouts.church')

@section('title', 'Users')

@section('page-title', 'Users')

@section('content')
    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">
                    Users
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage users and their roles within your church.
                </p>
            </div>

            <a
                href="{{ route('church.users.create') }}"
                class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-700"
            >
                + Add User
            </a>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- Users Table --}}
        @if ($users->isEmpty())
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
                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.37 9.37 0 0 0 2.625-.372M15 19.128v-2.25m0 2.25a9.38 9.38 0 0 1-6 0m6 0v-2.25m-6 2.25a9.38 9.38 0 0 1-2.625.372 9.37 9.37 0 0 1-2.625-.372m5.25 0v-2.25m0 0a3.375 3.375 0 1 0-6.75 0v2.25m6.75-2.25a3.375 3.375 0 1 1 6.75 0v2.25"
                        />
                    </svg>
                </div>

                <h3 class="mt-4 text-sm font-semibold text-slate-900">
                    No users found
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Add your first church user to get started.
                </p>

                <div class="mt-5">
                    <a
                        href="{{ route('church.users.create') }}"
                        class="inline-flex cursor-pointer items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700"
                    >
                        Add User
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
                                    User
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Email
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Role
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Joined
                                </th>

                                <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @foreach ($users as $churchUser)
                                <tr class="hover:bg-slate-50">

                                    {{-- User --}}
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="flex items-center gap-3">

                                            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-50 text-sm font-semibold text-indigo-700">
                                                {{ strtoupper(substr($churchUser->name, 0, 1)) }}
                                            </div>

                                            <div>
                                                <div class="font-medium text-slate-900">
                                                    {{ $churchUser->name }}
                                                </div>

                                                @if ($churchUser->id === $user->id)
                                                    <div class="mt-0.5 text-xs font-medium text-indigo-600">
                                                        You
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                    </td>

                                    {{-- Email --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                        {{ $churchUser->email }}
                                    </td>

                                    {{-- Role --}}
                                    <td class="px-6 py-4">

                                        @if ($churchUser->roles->isEmpty())
                                            <span class="text-sm text-slate-400">
                                                No role
                                            </span>
                                        @else
                                            <div class="flex flex-wrap gap-1.5">

                                                @foreach ($churchUser->roles as $role)
                                                    <span class="inline-flex rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-medium text-indigo-700">
                                                        {{ ucwords(str_replace('_', ' ', $role->name)) }}
                                                    </span>
                                                @endforeach

                                            </div>
                                        @endif

                                    </td>

                                    {{-- Joined --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">
                                        {{ $churchUser->created_at?->format('d M Y') }}
                                    </td>

                                    {{-- Actions --}}
                                    <td class="whitespace-nowrap px-6 py-4 text-right">

                                        <div class="flex items-center justify-end gap-2">

                                            <a
                                                href="{{ route('church.users.edit', $churchUser) }}"
                                                class="cursor-pointer rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-700 transition hover:bg-slate-50"
                                            >
                                                Edit
                                            </a>

                                            @if ($churchUser->id !== $user->id)
                                                <form
                                                    method="POST"
                                                    action="{{ route('church.users.destroy', $churchUser) }}"
                                                    onsubmit="return confirm('Are you sure you want to delete this user?');"
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

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($users->hasPages())
                    <div class="border-t border-slate-200 px-6 py-4">
                        {{ $users->links() }}
                    </div>
                @endif

            </div>
        @endif

    </div>
@endsection