<header
    class="fixed inset-x-0 top-0 z-50 border-b border-[#eeeaf2] bg-white/95 backdrop-blur-xl"
>

    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-6 lg:px-8">

        {{-- Logo --}}

        <a
            href="{{ route('landing') }}"
            class="flex items-center gap-3"
        >

            <img
                src="{{ asset('images/techcrossbreed-logo.png') }}"
                alt="ChurchFlow"
                class="h-11 w-11 object-contain"
            >

            <div class="text-xl font-extrabold tracking-tight">

                <span class="text-[#7021a8]">
                    Church
                </span>

                <span class="font-normal text-[#b22962]">
                    Flow
                </span>

            </div>

        </a>


        {{-- Desktop Navigation --}}

        <nav class="hidden items-center gap-8 lg:flex">

            <a
                href="#features"
                class="text-sm font-medium text-[#8b8595] transition hover:text-[#7021a8]"
            >
                Features
            </a>

            <a
                href="#benefits"
                class="text-sm font-medium text-[#8b8595] transition hover:text-[#7021a8]"
            >
                Benefits
            </a>

            <a
                href="#pricing"
                class="text-sm font-medium text-[#8b8595] transition hover:text-[#7021a8]"
            >
                Pricing
            </a>

            <a
                href="#faq"
                class="text-sm font-medium text-[#8b8595] transition hover:text-[#7021a8]"
            >
                FAQ
            </a>

        </nav>


        {{-- Desktop Actions --}}

        <div class="hidden items-center gap-5 lg:flex">

           <a
    href="/login"
    class="text-sm font-bold text-[#7021a8] transition hover:text-[#b22962]"
>
    Login
</a>

            <a
                href="{{ route('register') }}"
                class="cf-gradient-button rounded-[9px] px-5 py-3 text-sm font-extrabold text-white"
            >
                Start Free Trial →
            </a>

        </div>


        {{-- Mobile Menu Button --}}

        <button
            type="button"
            class="rounded-[9px] border border-[#ddd9e5] bg-white p-2.5 text-[#7021a8] transition hover:border-[#7021a8] lg:hidden"
            onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
            aria-label="Toggle navigation menu"
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16"
                />
            </svg>

        </button>

    </div>


    {{-- Mobile Navigation --}}

    <div
        id="mobile-menu"
        class="hidden border-t border-[#eeeaf2] bg-white lg:hidden"
    >

        <div class="space-y-1 px-6 py-5">

            <a
                href="#features"
                class="block rounded-[9px] px-4 py-3 text-sm font-semibold text-[#8b8595] transition hover:bg-[#f4f1f7] hover:text-[#7021a8]"
            >
                Features
            </a>

            <a
                href="#benefits"
                class="block rounded-[9px] px-4 py-3 text-sm font-semibold text-[#8b8595] transition hover:bg-[#f4f1f7] hover:text-[#7021a8]"
            >
                Benefits
            </a>

            <a
                href="#pricing"
                class="block rounded-[9px] px-4 py-3 text-sm font-semibold text-[#8b8595] transition hover:bg-[#f4f1f7] hover:text-[#7021a8]"
            >
                Pricing
            </a>

            <a
                href="#faq"
                class="block rounded-[9px] px-4 py-3 text-sm font-semibold text-[#8b8595] transition hover:bg-[#f4f1f7] hover:text-[#7021a8]"
            >
                FAQ
            </a>

            <div class="my-3 border-t border-[#eeeaf2]"></div>

            <a
                href="{{ route('login') }}"
                class="block rounded-[9px] px-4 py-3 text-sm font-bold text-[#7021a8] transition hover:bg-[#f4f1f7]"
            >
                Login
            </a>

            <a
                href="{{ route('register') }}"
                class="cf-gradient-button mt-2 block rounded-[9px] px-4 py-3 text-center text-sm font-extrabold text-white"
            >
                Start Free Trial →
            </a>

        </div>

    </div>

</header>