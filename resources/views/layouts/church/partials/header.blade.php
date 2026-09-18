<header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200 bg-white px-8">

    {{-- Page Information --}}
    <div>

        <h2 class="text-lg font-semibold text-slate-900">
            @yield('page_title', 'Church Dashboard')
        </h2>

        <p class="text-xs text-slate-500">
            @yield('page_description', 'Overview of your church')
        </p>

    </div>


    {{-- Right Side --}}
    <div class="flex items-center gap-6">

        {{-- Notifications --}}
        <button
            type="button"
            class="relative text-slate-500 transition hover:text-slate-800"
        >

            <span class="text-xl">
                ♢
            </span>

            <span class="absolute -right-2 -top-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[9px] text-white">
                0
            </span>

        </button>


        {{-- User --}}
        <div class="flex items-center gap-3">

            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-purple-100 font-semibold text-purple-700">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <div class="hidden md:block">

                <p class="text-sm font-semibold text-slate-900">
                    {{ $user->name }}
                </p>

                <p class="text-[11px] text-slate-500">
                    Church Owner
                </p>

            </div>

        </div>

    </div>

</header>