{{-- =========================================================
     HEADER
========================================================= --}}
<header
    class="fixed inset-x-0 top-0 z-50 border-b border-[#ddd9e5]/70 bg-[#f4f1f7]/90 backdrop-blur-xl"
>

    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-6 lg:px-8">

        {{-- Brand --}}
        <a
            href="{{ route('landing') }}"
            class="flex items-center gap-3"
            aria-label="ChurchFlow Home"
        >

            {{-- Church Icon --}}
            <div
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-[#7021a8] to-[#b22962] text-white shadow-lg shadow-[#7021a8]/15"
            >

                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                >
                    <path
                        d="M12 3L4 9V21H20V9L12 3Z"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linejoin="round"
                    />

                    <path
                        d="M12 3V21"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                    />

                    <path
                        d="M8 21V14H16V21"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linejoin="round"
                    />

                    <path
                        d="M9 9H15"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                    />
                </svg>

            </div>

            <span class="text-xl font-bold tracking-tight text-[#211b30]">
                Church<span class="text-[#b22962]">Flow</span>
            </span>

        </a>


        {{-- Desktop Navigation --}}
        <nav
            class="hidden items-center gap-8 lg:flex"
            aria-label="Main navigation"
        >

            <a
                href="{{ route('landing') }}#features"
                class="text-sm font-medium text-[#6f6878] transition hover:text-[#7021a8]"
            >
                Features
            </a>

            <a
                href="{{ route('landing') }}#dashboard"
                class="text-sm font-medium text-[#6f6878] transition hover:text-[#7021a8]"
            >
                Dashboard
            </a>

            <a
                href="{{ route('pricing') }}"
                class="text-sm font-medium text-[#6f6878] transition hover:text-[#7021a8]"
            >
                Pricing
            </a>

            <a
                href="{{ route('landing') }}#faq"
                class="text-sm font-medium text-[#6f6878] transition hover:text-[#7021a8]"
            >
                FAQ
            </a>

        </nav>


        {{-- Desktop Actions --}}
        <div class="hidden items-center gap-3 lg:flex">

            <a
                href="{{ route('login') }}"
                class="rounded-xl px-5 py-2.5 text-sm font-semibold text-[#211b30] transition hover:bg-white"
            >
                Login
            </a>

            <a
                href="{{ route('register') }}"
                class="cf-gradient-button rounded-xl px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-[#7021a8]/15 transition hover:-translate-y-0.5"
            >
                Get Started
            </a>

        </div>


        {{-- Mobile Menu Button --}}
        <button
            type="button"
            class="rounded-xl border border-[#ddd9e5] bg-white px-3 py-2 text-[#211b30] transition hover:bg-[#faf9fb] lg:hidden"
            onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
            aria-label="Toggle navigation menu"
            aria-controls="mobile-menu"
        >

            <svg
                class="h-5 w-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                />
            </svg>

        </button>

    </div>


    {{-- Mobile Navigation --}}
    <div
        id="mobile-menu"
        class="hidden border-t border-[#ddd9e5] bg-[#f4f1f7] lg:hidden"
    >

        <nav
            class="space-y-1 px-6 py-5"
            aria-label="Mobile navigation"
        >

            <a
                href="{{ route('landing') }}#features"
                class="block rounded-xl px-4 py-3 text-sm font-medium text-[#211b30] transition hover:bg-white"
            >
                Features
            </a>

            <a
                href="{{ route('landing') }}#dashboard"
                class="block rounded-xl px-4 py-3 text-sm font-medium text-[#211b30] transition hover:bg-white"
            >
                Dashboard
            </a>

            <a
                href="{{ route('pricing') }}"
                class="block rounded-xl px-4 py-3 text-sm font-medium text-[#211b30] transition hover:bg-white"
            >
                Pricing
            </a>

            <a
                href="{{ route('landing') }}#faq"
                class="block rounded-xl px-4 py-3 text-sm font-medium text-[#211b30] transition hover:bg-white"
            >
                FAQ
            </a>


            {{-- Mobile Actions --}}
            <div class="mt-4 grid grid-cols-2 gap-3">

                <a
                    href="{{ route('login') }}"
                    class="rounded-xl border border-[#ddd9e5] bg-white px-4 py-3 text-center text-sm font-semibold text-[#211b30] transition hover:bg-[#faf9fb]"
                >
                    Login
                </a>

                <a
                    href="{{ route('register') }}"
                    class="cf-gradient-button rounded-xl px-4 py-3 text-center text-sm font-semibold text-white shadow-md shadow-[#7021a8]/15 transition hover:-translate-y-0.5"
                >
                    Get Started
                </a>

            </div>

        </nav>

    </div>

</header>