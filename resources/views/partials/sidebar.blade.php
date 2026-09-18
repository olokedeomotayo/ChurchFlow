{{-- ========================================================= --}}
{{-- ADMIN SIDEBAR --}}
{{-- ========================================================= --}}

<aside class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col bg-slate-950 text-white">

    {{-- ========================================================= --}}
    {{-- Logo --}}
    {{-- ========================================================= --}}

    <div class="flex h-16 shrink-0 items-center border-b border-slate-800 px-6">

        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-purple-600 text-lg font-bold">
            C
        </div>

        <div class="ml-3">

            <h1 class="text-lg font-bold tracking-tight">
                ChurchFlow
            </h1>

            <p class="text-[10px] uppercase tracking-wider text-slate-400">
                Church Management
            </p>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- Navigation --}}
    {{-- ========================================================= --}}

    <nav class="flex-1 overflow-y-auto px-3 py-5">

        {{-- ===================================================== --}}
        {{-- Main Menu --}}
        {{-- ===================================================== --}}

        <p class="mb-3 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500">
            Main Menu
        </p>


        {{-- Dashboard --}}

        <a
            href="{{ route('dashboard') }}"
            class="flex items-center gap-3 rounded-lg px-3 py-2.5 transition
                {{ request()->routeIs('dashboard')
                    ? 'bg-purple-600 text-white'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
        >

            <span class="w-5 text-center">
                ▣
            </span>

            <span class="text-sm font-medium">
                Dashboard
            </span>

        </a>


        {{-- Churches --}}

        <a
            href="{{ route('admin.churches.index') }}"
            class="flex items-center gap-3 rounded-lg px-3 py-2.5 transition
                {{ request()->routeIs('admin.churches.*')
                    ? 'bg-purple-600 text-white'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
        >

            <span class="w-5 text-center">
                ♜
            </span>

            <span class="text-sm font-medium">
                Churches
            </span>

        </a>


        {{-- Members --}}

        <a
            href="#"
            class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-slate-300 transition hover:bg-slate-800 hover:text-white"
        >

            <span class="w-5 text-center">
                ♙
            </span>

            <span class="text-sm font-medium">
                Members
            </span>

        </a>

        


        {{-- Check-In --}}

        <a
            href="#"
            class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-slate-300 transition hover:bg-slate-800 hover:text-white"
        >

            <span class="w-5 text-center">
                ✓
            </span>

            <span class="text-sm font-medium">
                Check-In
            </span>

        </a>


        {{-- Finance --}}

        <a
            href="#"
            class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-slate-300 transition hover:bg-slate-800 hover:text-white"
        >

            <span class="w-5 text-center">
                ₦
            </span>

            <span class="text-sm font-medium">
                Finance
            </span>

        </a>


        {{-- Reports --}}

        <a
            href="#"
            class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-slate-300 transition hover:bg-slate-800 hover:text-white"
        >

            <span class="w-5 text-center">
                ▤
            </span>

            <span class="text-sm font-medium">
                Reports
            </span>

        </a>


        {{-- ===================================================== --}}
        {{-- Billing & Subscriptions --}}
        {{-- ===================================================== --}}

        <div class="mt-6 border-t border-slate-800 pt-5">

            <p class="mb-3 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                Billing & Subscriptions
            </p>


            {{-- Plans --}}

            <a
                href="{{ route('admin.plans.index') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 transition
                    {{ request()->routeIs('admin.plans.*')
                        ? 'bg-purple-600 text-white'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >

                <span class="w-5 text-center">
                    ◈
                </span>

                <span class="text-sm font-medium">
                    Plans
                </span>

            </a>


            {{-- Subscriptions --}}

            <a
                href="{{ route('admin.subscriptions.index') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 transition
                    {{ request()->routeIs('admin.subscriptions.*')
                        ? 'bg-purple-600 text-white'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
            >

                <span class="w-5 text-center">
                    ◉
                </span>

                <span class="text-sm font-medium">
                    Subscriptions
                </span>

            </a>

        </div>


        {{-- ===================================================== --}}
        {{-- System --}}
        {{-- ===================================================== --}}

        <div class="mt-6 border-t border-slate-800 pt-5">

            <p class="mb-3 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                System
            </p>


            {{-- Settings --}}

            <a
                href="#"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-slate-300 transition hover:bg-slate-800 hover:text-white"
            >

                <span class="w-5 text-center">
                    ⚙
                </span>

                <span class="text-sm font-medium">
                    Settings
                </span>

            </a>

        </div>

    </nav>


    {{-- ========================================================= --}}
    {{-- Logout --}}
    {{-- ========================================================= --}}

    <div class="shrink-0 border-t border-slate-800 p-4">

        <form
            method="POST"
            action="{{ route('logout') }}"
        >

            @csrf

            <button
                type="submit"
                class="flex w-full cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-slate-300 transition hover:bg-red-500/10 hover:text-red-400"
            >

                <span class="w-5 text-center">
                    ↪
                </span>

                <span class="text-sm font-medium">
                    Logout
                </span>

            </button>

        </form>

    </div>

</aside>