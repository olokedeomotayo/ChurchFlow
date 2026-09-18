<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'Platform Admin') — {{ config('app.name', 'ChurchFlow') }}
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])

</head>


<body class="min-h-screen bg-slate-100 text-slate-800">

    <div class="min-h-screen">


        {{-- ========================================================= --}}
        {{-- Sidebar --}}
        {{-- ========================================================= --}}

        <aside
            class="fixed inset-y-0 left-0 z-40 hidden w-64 border-r border-slate-800 bg-slate-950 lg:block"
        >

            {{-- Logo --}}

            <div class="flex h-16 items-center border-b border-slate-800 px-6">

                <a
                    href="{{ route('dashboard') }}"
                    class="text-xl font-bold tracking-tight text-white"
                >
                    Church<span class="text-purple-400">Flow</span>
                </a>

            </div>


            {{-- Navigation --}}

            <nav class="px-4 py-6">

                {{-- Platform --}}

                <p class="mb-3 px-3 text-xs font-bold uppercase tracking-wider text-slate-500">
                    Platform
                </p>


                <div class="space-y-1">


                    {{-- Dashboard --}}

                    <a
                        href="{{ route('dashboard') }}"
                        class="flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('dashboard')
                            ? 'bg-purple-600 text-white'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 shrink-0"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1V10"
                            />
                        </svg>

                        <span>
                            Dashboard
                        </span>

                    </a>


                    {{-- Churches --}}

                    <a
                        href="{{ route('admin.churches.index') }}"
                        class="flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('admin.churches.*')
                            ? 'bg-purple-600 text-white'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 shrink-0"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 21h18M5 21V9l7-5 7 5v12M9 21v-6h6v6M12 4v5"
                            />
                        </svg>

                        <span>
                            Churches
                        </span>

                    </a>


                    {{-- Subscription Plans --}}

                    <a
                        href="{{ route('admin.plans.index') }}"
                        class="flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('admin.plans.*')
                            ? 'bg-purple-600 text-white'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 shrink-0"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 7h18M5 4h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2zM7 15h4"
                            />
                        </svg>

                        <span>
                            Subscription Plans
                        </span>

                    </a>


                    {{-- Subscriptions --}}

                    <a
                        href="{{ route('admin.subscriptions.index') }}"
                        class="flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('admin.subscriptions.*')
                            ? 'bg-purple-600 text-white'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 shrink-0"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 7h16M4 12h16M4 17h10"
                            />
                        </svg>

                        <span>
                            Subscriptions
                        </span>

                    </a>

                </div>


                {{-- System --}}

                <p class="mb-3 mt-8 px-3 text-xs font-bold uppercase tracking-wider text-slate-500">
                    System
                </p>


                <div class="space-y-1">


                    {{-- System Settings --}}

                    <a
                        href="{{ route('admin.settings.index') }}"
                        class="flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('admin.settings.*')
                            ? 'bg-purple-600 text-white'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 shrink-0"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 15.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19.4 15a1.7 1.7 0 00.34 1.88l.06.06-1.8 1.8-.06-.06a1.7 1.7 0 00-1.88-.34 1.7 1.7 0 00-1.03 1.56V22h-2.55v-.1a1.7 1.7 0 00-1.03-1.56 1.7 1.7 0 00-1.88.34l-.06.06-1.8-1.8.06-.06A1.7 1.7 0 008.1 15a1.7 1.7 0 00-1.56-1.03H6V11.4h.1A1.7 1.7 0 007.66 10a1.7 1.7 0 00-.34-1.88l-.06-.06 1.8-1.8.06.06A1.7 1.7 0 0011 6a1.7 1.7 0 001.03-1.56V4h2.55v.1A1.7 1.7 0 0015.6 5.66a1.7 1.7 0 001.88-.34l.06-.06 1.8 1.8-.06.06A1.7 1.7 0 0018.94 9a1.7 1.7 0 001.56 1.03h.1v2.55h-.1A1.7 1.7 0 0019.4 15z"
                            />
                        </svg>

                        <span>
                            System Settings
                        </span>

                    </a>

                </div>

            </nav>

        </aside>


        {{-- ========================================================= --}}
        {{-- Main Area --}}
        {{-- ========================================================= --}}

        <div class="min-h-screen lg:ml-64">


            {{-- ===================================================== --}}
            {{-- Top Navigation --}}
            {{-- ===================================================== --}}

            <header
                class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200 bg-white px-4 shadow-sm sm:px-6 lg:px-8"
            >

                {{-- Mobile Logo --}}

                <div class="lg:hidden">

                    <span class="text-lg font-bold text-slate-900">
                        Church<span class="text-purple-600">Flow</span>
                    </span>

                </div>


                {{-- Desktop Page Context --}}

                <div class="hidden lg:block">

                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Platform Administration
                    </p>

                </div>


                {{-- User Area --}}

                <div class="flex items-center gap-4">

                    <div class="hidden text-right sm:block">

                        <p class="text-sm font-semibold text-slate-800">
                            {{ auth()->user()->name ?? 'Administrator' }}
                        </p>

                        <p class="text-xs text-slate-500">
                            Platform Administrator
                        </p>

                    </div>


                    {{-- Avatar --}}

                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-full bg-purple-100 text-sm font-bold text-purple-700"
                    >
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>


                    {{-- Logout --}}

                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="cursor-pointer rounded-lg px-3 py-2 text-sm font-medium text-slate-500 transition hover:bg-slate-100 hover:text-slate-800"
                        >
                            Logout
                        </button>

                    </form>

                </div>

            </header>


            {{-- ========================================================= --}}
            {{-- Page Content --}}
            {{-- ========================================================= --}}

            <main class="w-full px-4 py-6 sm:px-6 lg:px-8">

                {{-- Page Heading --}}

                @hasSection('page_title')

                    <div class="mb-8">

                        <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                            @yield('page_title')
                        </h1>

                        @hasSection('page_description')

                            <p class="mt-1 text-sm text-slate-500">
                                @yield('page_description')
                            </p>

                        @endif

                    </div>

                @endif


                {{-- Content --}}

                <div class="w-full">

                    @yield('content')

                </div>

            </main>


            {{-- ========================================================= --}}
            {{-- Footer --}}
            {{-- ========================================================= --}}

            <footer class="border-t border-slate-200 bg-white px-4 py-5 sm:px-6 lg:px-8">

                <div class="flex flex-col gap-2 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between">

                    <p>
                        © {{ date('Y') }} ChurchFlow. All rights reserved.
                    </p>

                    <p>
                        Platform Administration
                    </p>

                </div>

            </footer>

        </div>

    </div>

</body>

</html>