<section
    class="bg-[#f4f1f7] py-24"
>

    <div class="mx-auto max-w-7xl px-6 lg:px-8">


        {{-- Section Heading --}}

        <div class="mx-auto max-w-3xl text-center">

            <p
                class="text-sm font-extrabold uppercase tracking-[0.18em] text-[#7021a8]"
            >
                Get Started
            </p>

            <h2
                class="mt-4 text-4xl font-extrabold leading-tight tracking-tight text-[#211b30] sm:text-5xl"
            >
                Start managing your church in four simple steps.
            </h2>

            <p
                class="mt-6 text-lg leading-8 text-[#8b8595]"
            >
                Getting started with ChurchFlow is simple. Create your
                church account, complete your setup and start managing
                your church from one place.
            </p>

        </div>


        {{-- Steps --}}

        <div
            class="relative mt-16 grid gap-8 md:grid-cols-2 lg:grid-cols-4"
        >


            {{-- Connecting Line --}}

            <div
                class="absolute left-[12%] right-[12%] top-8 hidden h-px bg-gradient-to-r from-[#7021a8]/20 via-[#7021a8] to-[#b22962]/20 lg:block"
            ></div>


            {{-- Step 01 --}}

            <div class="relative text-center">

                <div
                    class="relative mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-white text-lg font-extrabold text-[#7021a8] shadow-[0_10px_30px_rgba(45,20,70,.10)] ring-8 ring-[#f4f1f7]"
                >
                    01
                </div>

                <h3
                    class="mt-7 text-xl font-extrabold text-[#211b30]"
                >
                    Create Your Account
                </h3>

                <p
                    class="mt-3 text-sm leading-7 text-[#8b8595]"
                >
                    Register your church and provide the basic
                    information we need.
                </p>

            </div>


            {{-- Step 02 --}}

            <div class="relative text-center">

                <div
                    class="relative mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-white text-lg font-extrabold text-[#b22962] shadow-[0_10px_30px_rgba(45,20,70,.10)] ring-8 ring-[#f4f1f7]"
                >
                    02
                </div>

                <h3
                    class="mt-7 text-xl font-extrabold text-[#211b30]"
                >
                    Set Up Your Church
                </h3>

                <p
                    class="mt-3 text-sm leading-7 text-[#8b8595]"
                >
                    Configure your church profile, departments,
                    roles and settings.
                </p>

            </div>


            {{-- Step 03 --}}

            <div class="relative text-center">

                <div
                    class="relative mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-white text-lg font-extrabold text-[#7021a8] shadow-[0_10px_30px_rgba(45,20,70,.10)] ring-8 ring-[#f4f1f7]"
                >
                    03
                </div>

                <h3
                    class="mt-7 text-xl font-extrabold text-[#211b30]"
                >
                    Invite Your Team
                </h3>

                <p
                    class="mt-3 text-sm leading-7 text-[#8b8595]"
                >
                    Give authorized team members access to
                    the areas they need.
                </p>

            </div>


            {{-- Step 04 --}}

            <div class="relative text-center">

                <div
                    class="relative mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-r from-[#7021a8] to-[#b22962] text-lg font-extrabold text-white shadow-[0_10px_30px_rgba(45,20,70,.18)] ring-8 ring-[#f4f1f7]"
                >
                    04
                </div>

                <h3
                    class="mt-7 text-xl font-extrabold text-[#211b30]"
                >
                    Start Managing
                </h3>

                <p
                    class="mt-3 text-sm leading-7 text-[#8b8595]"
                >
                    Begin managing finances, members, check-ins
                    and reports.
                </p>

            </div>


        </div>


        {{-- Trial Message --}}

        <div
            class="mx-auto mt-16 max-w-3xl rounded-[20px] border border-[#ddd9e5] bg-white p-6 shadow-[0_10px_30px_rgba(45,20,70,.06)]"
        >

            <div
                class="flex flex-col items-center gap-4 text-center sm:flex-row sm:text-left"
            >

                <div
                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-[9px] bg-[#f4f1f7] text-[#7021a8]"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <circle
                            cx="12"
                            cy="12"
                            r="9"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 7v5l3 2"
                        />

                    </svg>

                </div>

                <div class="flex-1">

                    <p class="font-extrabold text-[#211b30]">
                        Your first 30 days are on us.
                    </p>

                    <p class="mt-1 text-sm leading-6 text-[#8b8595]">
                        Explore ChurchFlow, set up your church and
                        experience the platform before choosing a subscription plan.
                    </p>

                </div>

                <a
                    href="{{ route('register') }}"
                    class="cf-gradient-button shrink-0 rounded-[9px] px-5 py-3 text-sm font-extrabold text-white"
                >
                    Start Free Trial →
                </a>

            </div>

        </div>

    </div>

</section>