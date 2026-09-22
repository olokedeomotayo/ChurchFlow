@extends('layouts.church')

@section('title', 'Edit User')

@section('page-title', 'Edit User')

@section('content')
    <div class="mx-auto max-w-3xl space-y-6">

        {{-- Header --}}
        <div>
            <div class="flex items-center gap-3">
                <a
                    href="{{ route('church.users.index') }}"
                    class="cursor-pointer text-sm font-medium text-slate-500 hover:text-slate-700"
                >
                    ← Users
                </a>

                <span class="text-slate-300">/</span>

                <span class="text-sm text-slate-500">
                    Edit User
                </span>
            </div>

            <h1 class="mt-4 text-2xl font-semibold text-slate-900">
                Edit User
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Update the user's account information and role.
            </p>
        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3">
                <div class="text-sm font-semibold text-red-800">
                    Please correct the following:
                </div>

                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form
            method="POST"
            action="{{ route('church.users.update', $churchUser) }}"
            class="space-y-6"
        >
            @csrf
            @method('PUT')

            {{-- Account Details --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-4">
                    <h2 class="text-base font-semibold text-slate-900">
                        Account Details
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Update the user's basic account information.
                    </p>
                </div>

                <div class="space-y-5 p-6">

                    {{-- Name --}}
                    <div>
                        <label
                            for="name"
                            class="block text-sm font-medium text-slate-700"
                        >
                            Full Name
                        </label>

                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name', $churchUser->name) }}"
                            required
                            autofocus
                            class="mt-2 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                        >
                    </div>

                    {{-- Email --}}
                    <div>
                        <label
                            for="email"
                            class="block text-sm font-medium text-slate-700"
                        >
                            Email Address
                        </label>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email', $churchUser->email) }}"
                            required
                            class="mt-2 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                        >
                    </div>

                    {{-- Role --}}
                    <div>
                        <label
                            for="role"
                            class="block text-sm font-medium text-slate-700"
                        >
                            Role
                        </label>

                        @php
                            $currentRole = $churchUser->roles->first()?->name;
                        @endphp

                        <select
                            id="role"
                            name="role"
                            required
                            class="mt-2 block w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                        >
                            <option value="">
                                Select a role
                            </option>

                            @foreach ($roles as $role)
                                <option
                                    value="{{ $role->name }}"
                                    {{ old('role', $currentRole) === $role->name ? 'selected' : '' }}
                                >
                                    {{ ucwords(str_replace('_', ' ', $role->name)) }}
                                </option>
                            @endforeach
                        </select>

                        <p class="mt-2 text-xs text-slate-500">
                            The role determines what this user can access.
                        </p>
                    </div>

                </div>
            </div>

            {{-- Password --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-4">
                    <h2 class="text-base font-semibold text-slate-900">
                        Change Password
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Leave these fields empty if you do not want to change the password.
                    </p>
                </div>

                <div class="grid gap-5 p-6 sm:grid-cols-2">

                    {{-- Password --}}
                    <div>
                        <label
                            for="password"
                            class="block text-sm font-medium text-slate-700"
                        >
                            New Password
                        </label>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            autocomplete="new-password"
                            class="mt-2 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                        >

                        <p class="mt-2 text-xs text-slate-500">
                            Minimum 8 characters.
                        </p>
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label
                            for="password_confirmation"
                            class="block text-sm font-medium text-slate-700"
                        >
                            Confirm New Password
                        </label>

                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            autocomplete="new-password"
                            class="mt-2 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                        >
                    </div>

                </div>
            </div>

            {{-- Current User Notice --}}
            @if ($churchUser->id === $user->id)
                <div class="rounded-lg border border-indigo-200 bg-indigo-50 px-4 py-3">
                    <p class="text-sm text-indigo-700">
                        You are editing your own account.
                    </p>
                </div>
            @endif

            {{-- Actions --}}
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('church.users.index') }}"
                    class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-700"
                >
                    Update User
                </button>

            </div>

        </form>

    </div>
@endsection