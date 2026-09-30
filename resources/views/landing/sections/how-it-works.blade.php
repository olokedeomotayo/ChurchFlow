{{-- =========================================================
     HOW CHURCHFLOW WORKS
========================================================= --}}
<section class="relative overflow-hidden bg-white py-24 lg:py-32">

    <div class="mx-auto max-w-7xl px-6 lg:px-8">

        {{-- Heading --}}
        <div class="mx-auto max-w-3xl text-center">

            <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#b22962]">
                GET STARTED
            </p>

            <h2 class="mt-5 text-4xl font-black tracking-[-0.03em] text-[#211b30] sm:text-5xl lg:text-6xl">
                Up and running
                <span
                    class="bg-clip-text text-transparent"
                    style="background-image: linear-gradient(90deg, #7021a8, #b22962);"
                >
                    in minutes.
                </span>
            </h2>

            <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-[#817a89]">
                Getting your church onto ChurchFlow is simple.
                Create your account, set up your church and start managing.
            </p>

        </div>


        {{-- Steps --}}
        <div class="relative mt-16">

            {{-- Connecting Line --}}
            <div class="absolute left-[16.67%] right-[16.67%] top-10 hidden h-px bg-[#ddd7e2] lg:block"></div>

            <div class="relative grid gap-10 lg:grid-cols-3">

                {{-- Step 01 --}}
                <div class="text-center">

                    <div class="relative mx-auto flex h-20 w-20 items-center justify-center rounded-2xl border border-[#e1d9e6] bg-white shadow-lg shadow-purple-100">

                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl text-sm font-black text-white"
                            style="background: linear-gradient(135deg, #7021a8, #b22962);"
                        >
                            01
                        </div>

                    </div>

                    <p class="mt-7 text-xs font-bold uppercase tracking-[0.18em] text-[#9a94a2]">
                        CREATE
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-[#211b30]">
                        Create your account
                    </h3>

                    <p class="mx-auto mt-3 max-w-sm text-sm leading-6 text-[#817a89]">
                        Start your 30-day free trial and create your
                        ChurchFlow account in just a few steps.
                    </p>

                </div>


                {{-- Step 02 --}}
                <div class="text-center">

                    <div class="relative mx-auto flex h-20 w-20 items-center justify-center rounded-2xl border border-[#e1d9e6] bg-white shadow-lg shadow-purple-100">

                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl text-sm font-black text-white"
                            style="background: linear-gradient(135deg, #7f279d, #a52c7e);"
                        >
                            02
                        </div>

                    </div>

                    <p class="mt-7 text-xs font-bold uppercase tracking-[0.18em] text-[#9a94a2]">
                        CONFIGURE
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-[#211b30]">
                        Set up your church
                    </h3>

                    <p class="mx-auto mt-3 max-w-sm text-sm leading-6 text-[#817a89]">
                        Add your church information, configure your
                        team and organize the areas you want to manage.
                    </p>

                </div>


                {{-- Step 03 --}}
                <div class="text-center">

                    <div class="relative mx-auto flex h-20 w-20 items-center justify-center rounded-2xl border border-[#e1d9e6] bg-white shadow-lg shadow-purple-100">

                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-xl text-sm font-black text-white"
                            style="background: linear-gradient(135deg, #962b88, #b22962);"
                        >
                            03
                        </div>

                    </div>

                    <p class="mt-7 text-xs font-bold uppercase tracking-[0.18em] text-[#9a94a2]">
                        MANAGE
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-[#211b30]">
                        Run your church
                    </h3>

                    <p class="mx-auto mt-3 max-w-sm text-sm leading-6 text-[#817a89]">
                        Manage finances, members, attendance and reports
                        from one connected platform.
                    </p>

                </div>

            </div>

        </div>


        {{-- CTA --}}
        <div class="mt-16 text-center">

            <a
                href="{{ route('register') }}"
                class="inline-flex items-center rounded-xl px-7 py-4 text-sm font-bold text-white shadow-xl shadow-purple-200 transition duration-200 hover:-translate-y-1"
                style="background: linear-gradient(90deg, #7021a8, #b22962);"
            >
                Start Your 30-Day Free Trial
                <span class="ml-2 text-lg">→</span>
            </a>

            <p class="mt-4 text-xs text-[#9a94a2]">
                No credit card required.
            </p>

        </div>

    </div>
</section>