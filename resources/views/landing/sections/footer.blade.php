<footer class="bg-[#211b30] text-white">

    <div class="mx-auto max-w-7xl px-6 py-16 lg:px-8">


        {{-- Footer Main Content --}}

        <div class="grid gap-12 md:grid-cols-2 lg:grid-cols-4">


            {{-- Brand --}}

            <div>

                <a
                    href="{{ route('landing') }}"
                    class="inline-flex items-center gap-3"
                >

                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-[9px] bg-gradient-to-r from-[#7021a8] to-[#b22962] text-sm font-extrabold text-white shadow-lg shadow-[#7021a8]/20"
                    >
                        CF
                    </div>

                    <span class="text-xl font-extrabold">
                        Church<span class="text-[#b22962]">Flow</span>
                    </span>

                </a>


                <p
                    class="mt-5 max-w-sm text-sm leading-7 text-white/55"
                >
                    A modern platform for managing your church finances,
                    members, check-ins and operations from one place.
                </p>


                {{-- Contact Information --}}

                <div class="mt-6 space-y-3">

                    <a
                        href="tel:08120081213"
                        class="flex items-center gap-3 text-sm text-white/60 transition hover:text-white"
                    >

                        <span class="text-[#b22962]">
                            ☎
                        </span>

                        08120081213

                    </a>


                    <a
                        href="mailto:info@techcrossbreed.com.ng"
                        class="flex items-center gap-3 text-sm text-white/60 transition hover:text-white"
                    >

                        <span class="text-[#b22962]">
                            ✉
                        </span>

                        info@techcrossbreed.com.ng

                    </a>

                </div>


                {{-- Trial CTA --}}

                <a
                    href="{{ route('register') }}"
                    class="mt-6 inline-flex items-center rounded-[9px] bg-white/10 px-4 py-2.5 text-xs font-extrabold text-white transition hover:bg-white/15"
                >
                    Get Started →
                </a>

            </div>


            {{-- Product --}}

            <div>

                <h3 class="text-sm font-extrabold">
                    Product
                </h3>

                <ul
                    class="mt-5 space-y-3 text-sm text-white/55"
                >

                    <li>
                        <a
                            href="#features"
                            class="transition hover:text-white"
                        >
                            Features
                        </a>
                    </li>

                    <li>
                        <a
                            href="#benefits"
                            class="transition hover:text-white"
                        >
                            Benefits
                        </a>
                    </li>

                    <li>
                        <a
                            href="#pricing"
                            class="transition hover:text-white"
                        >
                            Pricing
                        </a>
                    </li>

                    <li>
                        <a
                            href="#faq"
                            class="transition hover:text-white"
                        >
                            FAQ
                        </a>
                    </li>

                </ul>

            </div>


            {{-- Company --}}

            <div>

                <h3 class="text-sm font-extrabold">
                    Company
                </h3>

                <ul
                    class="mt-5 space-y-3 text-sm text-white/55"
                >

                    <li>
                        <a
                            href="#about"
                            class="transition hover:text-white"
                        >
                            About ChurchFlow
                        </a>
                    </li>

                    <li>
                        <a
                            href="#contact"
                            class="transition hover:text-white"
                        >
                            Contact Us
                        </a>
                    </li>

                    <li>
                        <a
                            href="#faq"
                            class="transition hover:text-white"
                        >
                            Frequently Asked Questions
                        </a>
                    </li>

                </ul>

            </div>


            {{-- Account --}}

            <div>

                <h3 class="text-sm font-extrabold">
                    Account
                </h3>

                <ul
                    class="mt-5 space-y-3 text-sm text-white/55"
                >

                    <li>
                        <a
                            href="{{ route('login') }}"
                            class="transition hover:text-white"
                        >
                            Login
                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ route('register') }}"
                            class="transition hover:text-white"
                        >
                            Create Church Account
                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ route('register') }}"
                            class="transition hover:text-white"
                        >
                            Start 30-Day Trial
                        </a>
                    </li>

                </ul>

            </div>

        </div>


        {{-- Footer Bottom --}}

        <div
            class="mt-14 flex flex-col gap-5 border-t border-white/10 pt-8 md:flex-row md:items-center md:justify-between"
        >

            <div class="text-xs text-white/40">

                <p>
                    © {{ date('Y') }} ChurchFlow.
                    All rights reserved.
                </p>

                <p class="mt-2">

                    Designed & Developed by

                    <a
                        href="http://techcrossbreed.com.ng/"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="font-extrabold text-white/60 transition hover:text-[#b22962]"
                    >
                        Techcrossbreed
                    </a>

                </p>

            </div>


            {{-- Legal Links --}}

            <div
                class="flex flex-wrap gap-5 text-xs text-white/40"
            >

                <a
                    href="#"
                    class="transition hover:text-white"
                >
                    Privacy Policy
                </a>

                <a
                    href="#"
                    class="transition hover:text-white"
                >
                    Terms of Service
                </a>

            </div>

        </div>

    </div>

</footer>s