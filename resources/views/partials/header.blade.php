{{-- ADMIN HEADER --}}

<header
    class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 sticky top-0 z-30"
>

    {{-- Page Information --}}

    <div>

        <h2 class="text-lg font-semibold text-slate-900">
            @yield('page_title', 'Dashboard')
        </h2>

        <p class="text-xs text-slate-500">
            @yield('page_description', 'Platform overview and activity')
        </p>

    </div>


    {{-- Header Actions --}}

    <div class="flex items-center gap-6">


        {{-- Notifications --}}

        <button
            type="button"
            class="relative text-slate-500 hover:text-slate-800"
        >

            <span class="text-xl">
                ♢
            </span>

            <span
                class="absolute -top-1 -right-2 w-4 h-4 rounded-full bg-red-500 text-white text-[9px] flex items-center justify-center"
            >
                0
            </span>

        </button>


        {{-- User --}}

        @php
            $user = auth()->user();
        @endphp

        <div class="flex items-center gap-3">

            <div
                class="w-9 h-9 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center font-semibold"
            >
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <div class="hidden md:block">

                <p class="text-sm font-semibold text-slate-900">
                    {{ $user->name }}
                </p>

                <p class="text-[11px] text-slate-500">
                    Super Administrator
                </p>

            </div>

        </div>

    </div>

</header>