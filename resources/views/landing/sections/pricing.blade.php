<section
    id="pricing"
    class="bg-[#f4f1f7] py-24"
>

    <div class="mx-auto max-w-7xl px-6 lg:px-8">

        {{-- Heading --}}

        <div class="mx-auto max-w-3xl text-center">

            <p
                class="text-sm font-extrabold uppercase tracking-[0.2em] text-[#7021a8]"
            >
                Simple Pricing
            </p>

            <h2
                class="mt-4 text-4xl font-extrabold tracking-tight text-[#211b30] sm:text-5xl"
            >
                Simple plans. No surprises.
            </h2>

            <p
                class="mt-5 text-lg text-[#8b8595]"
            >
                Every plan includes a 30-day free trial.
                Choose the plan that fits your church.
            </p>

        </div>


        {{-- Pricing Cards --}}

        <div
            class="mx-auto mt-16 grid max-w-6xl gap-5 lg:grid-cols-3"
        >


            {{-- STARTER --}}

            <div
                class="rounded-[20px] border border-[#ddd9e5] bg-white p-8 transition duration-300 hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(45,20,70,.08)]"
            >

                <h3 class="text-xl font-extrabold text-[#211b30]">
                    Starter
                </h3>


                <div class="mt-5">

                    <span
                        class="text-4xl font-extrabold tracking-tight text-[#7021a8] sm:text-5xl"
                    >
                        ₦20,000
                    </span>

                    <span class="ml-1 text-sm text-[#8b8595]">
                        /month
                    </span>

                </div>


                <p
                    class="mt-4 text-sm font-medium leading-6 text-[#8b8595]"
                >
                    A simple starting point for churches
                    building better systems.
                </p>


                <div
                    class="mt-6 rounded-[9px] bg-[#f4f1f7] px-4 py-3 text-sm font-bold text-[#7021a8]"
                >
                    Up to 250 Members
                </div>


                <a
                    href="{{ route('register') }}"
                    class="mt-6 block rounded-[9px] bg-[#f4f1f7] px-5 py-3.5 text-center text-sm font-extrabold text-[#7021a8] transition hover:bg-[#7021a8] hover:text-white"
                >
                    Get Started →
                </a>

            </div>


            {{-- GROWTH --}}

            <div
                class="relative rounded-[20px] border-2 border-[#7021a8] bg-white p-8 shadow-[0_20px_50px_rgba(112,33,168,.14)]"
            >

                {{-- Most Popular Badge --}}

                <span
                    class="absolute -top-4 left-1/2 -translate-x-1/2 whitespace-nowrap rounded-full bg-gradient-to-r from-[#7021a8] to-[#b22962] px-5 py-2 text-xs font-extrabold text-white shadow-lg shadow-[#7021a8]/20"
                >
                    Most Popular
                </span>


                <h3 class="text-xl font-extrabold text-[#211b30]">
                    Growth
                </h3>


                <div class="mt-5">

                    <span
                        class="bg-gradient-to-r from-[#7021a8] to-[#b22962] bg-clip-text text-4xl font-extrabold tracking-tight text-transparent sm:text-5xl"
                    >
                        ₦50,000
                    </span>

                    <span class="ml-1 text-sm text-[#8b8595]">
                        /month
                    </span>

                </div>


                <p
                    class="mt-4 text-sm font-medium leading-6 text-[#8b8595]"
                >
                    For growing churches that need
                    deeper visibility and control.
                </p>


                <div
                    class="mt-6 rounded-[9px] bg-[#f4f1f7] px-4 py-3 text-sm font-bold text-[#7021a8]"
                >
                    Up to 1,000 Members
                </div>


                <a
                    href="{{ route('register') }}"
                    class="cf-gradient-button mt-6 block rounded-[9px] px-5 py-3.5 text-center text-sm font-extrabold text-white"
                >
                    Get Started →
                </a>

            </div>


            {{-- ENTERPRISE --}}

            <div
                class="rounded-[20px] border border-[#ddd9e5] bg-white p-8 transition duration-300 hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(45,20,70,.08)]"
            >

                <h3 class="text-xl font-extrabold text-[#211b30]">
                    Enterprise
                </h3>


                <div class="mt-5">

                    <span
                        class="text-4xl font-extrabold tracking-tight text-[#b22962] sm:text-5xl"
                    >
                        ₦200,000
                    </span>

                    <span class="ml-1 text-sm text-[#8b8595]">
                        /month
                    </span>

                </div>


                <p
                    class="mt-4 text-sm font-medium leading-6 text-[#8b8595]"
                >
                    For large churches and organizations
                    with advanced requirements.
                </p>


                <div
                    class="mt-6 rounded-[9px] bg-[#f4f1f7] px-4 py-3 text-sm font-bold text-[#b22962]"
                >
                    Up to 5,000 Members
                </div>


                <a
                    href="{{ route('register') }}"
                    class="mt-6 block rounded-[9px] bg-[#f4f1f7] px-5 py-3.5 text-center text-sm font-extrabold text-[#b22962] transition hover:bg-[#b22962] hover:text-white"
                >
                    Get Started →
                </a>

            </div>

        </div>


        {{-- Bottom Note --}}

        <div class="mx-auto mt-10 max-w-2xl text-center">

            <p class="text-sm leading-6 text-[#8b8595]">

                Every plan starts with a

                <span class="font-extrabold text-[#7021a8]">
                    30-day free trial
                </span>

                so your church can experience ChurchFlow
                before committing.

            </p>

        </div>

    </div>

</section>