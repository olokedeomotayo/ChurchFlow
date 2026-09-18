<section class="px-6 py-16 lg:px-8">

    <div
        class="relative mx-auto max-w-7xl overflow-hidden rounded-[24px] bg-gradient-to-r from-[#7021a8] to-[#b22962] px-8 py-20 text-center text-white shadow-[0_25px_60px_rgba(112,33,168,.20)] lg:px-16"
    >

        {{-- Background Glow --}}

        <div
            class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-white/10 blur-3xl"
        ></div>

        <div
            class="pointer-events-none absolute -bottom-32 -left-24 h-80 w-80 rounded-full bg-white/10 blur-3xl"
        ></div>


        {{-- Content --}}

        <div class="relative">

            <p
                class="text-sm font-extrabold uppercase tracking-[0.2em] text-white/80"
            >
                Get Started With ChurchFlow
            </p>


            <h2
                class="mx-auto mt-4 max-w-3xl text-4xl font-extrabold tracking-tight sm:text-5xl"
            >
                Ready to manage your church better?
            </h2>


            <p
                class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-white/80"
            >
                Bring your finances, members, check-ins and church
                operations together in one powerful platform.
            </p>


            {{-- CTA --}}

            <a
                href="{{ route('register') }}"
                class="mt-9 inline-flex items-center rounded-[9px] bg-white px-7 py-4 text-sm font-extrabold text-[#7021a8] shadow-xl transition duration-300 hover:-translate-y-0.5 hover:bg-[#f4f1f7]"
            >
                Get Started →
            </a>


            {{-- Trial Message --}}

            <p
                class="mt-5 text-sm font-medium text-white/70"
            >
                30-day free trial · No credit card required
            </p>

        </div>

    </div>

</section>