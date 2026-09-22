@extends('layouts.church')

@section('title', 'Edit Role')

@section('page-title', 'Edit Role')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">

        {{-- Header --}}
        <div>
            <div class="flex items-center gap-3">
                <a
                    href="{{ route('church.roles.index') }}"
                    class="cursor-pointer text-sm font-medium text-slate-500 hover:text-slate-700"
                >
                    ← Roles
                </a>

                <span class="text-slate-300">/</span>

                <span class="text-sm text-slate-500">
                    Edit Role
                </span>
            </div>

            <h1 class="mt-4 text-2xl font-semibold text-slate-900">
                Edit Role
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Update the role name and permissions.
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
            action="{{ route('church.roles.update', $role) }}"
            class="space-y-6"
        >
            @csrf
            @method('PUT')

            {{-- Role Details --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-4">
                    <h2 class="text-base font-semibold text-slate-900">
                        Role Details
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Update the name of this church role.
                    </p>
                </div>

                <div class="p-6">
                    <label
                        for="name"
                        class="block text-sm font-medium text-slate-700"
                    >
                        Role Name
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name', $role->name) }}"
                        required
                        autofocus
                        class="mt-2 block w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                    >

                    <p class="mt-2 text-xs text-slate-500">
                        Example: Treasurer, Secretary, Accountant, Media Team.
                    </p>
                </div>
            </div>

            {{-- Permissions --}}
            <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-200 px-6 py-4">
                    <h2 class="text-base font-semibold text-slate-900">
                        Permissions
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Select the permissions this role should have.
                    </p>
                </div>

                <div class="p-6">

                    @if ($permissions->isEmpty())
                        <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 p-6 text-center">
                            <p class="text-sm text-slate-500">
                                No permissions have been created yet.
                            </p>
                        </div>
                    @else
                        @php
                            $selectedPermissions = old(
                                'permissions',
                                $role->permissions->pluck('name')->toArray()
                            );
                        @endphp

                        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($permissions as $permission)
                                <label
                                    class="flex cursor-pointer items-start gap-3 rounded-lg border border-slate-200 p-3 transition hover:border-indigo-300 hover:bg-indigo-50/50"
                                >
                                    <input
                                        type="checkbox"
                                        name="permissions[]"
                                        value="{{ $permission->name }}"
                                        {{ in_array($permission->name, $selectedPermissions, true) ? 'checked' : '' }}
                                        class="mt-0.5 h-4 w-4 cursor-pointer rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                                    >

                                    <div>
                                        <div class="text-sm font-medium text-slate-800">
                                            {{ ucwords(str_replace(['.', '_', '-'], ' ', $permission->name)) }}
                                        </div>

                                        <div class="mt-0.5 text-xs text-slate-400">
                                            {{ $permission->name }}
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('church.roles.index') }}"
                    class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-700"
                >
                    Update Role
                </button>

            </div>

        </form>

    </div>
@endsection