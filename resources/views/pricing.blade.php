<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pricing — ChurchFlow</title>

    <meta
        name="description"
        content="Choose the ChurchFlow plan that fits your church. Start with a 30-day free trial."
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="bg-[#f4f1f7] text-[#211b30] antialiased">

    {{-- Header --}}
    @include('landing.sections.header')


    <main class="pt-20">

        {{-- Pricing Hero --}}
        <section class="relative overflow-hidden bg-[#f4f1f7] py-20 sm:py-24">

            <div class="mx-auto max-w-7xl px-6 lg:px-8">

                <div class="mx-auto max-w-3xl text-center">

                    <span class="inline-flex items-center rounded-full border border-[#ddd9e5] bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-[#7021a8]">
                        ChurchFlow Pricing
                    </span>

                    <h1 class="mt-6 text-4xl font-bold tracking-tight text-[#211b30] sm:text-5xl">
                        Choose the plan that fits
                        <span class="text-[#b22962]">your church.</span>
                    </h1>

                    <p class="mx-auto mt-5 max-w-2xl text-lg leading-8 text-[#8b8595]">
                        Start with a 30-day free trial and choose the plan that
                        matches your church's size and needs.
                    </p>

                    <div class="mt-6 flex flex-wrap justify-center gap-3 text-xs font-medium text-[#8b8595]">
                        <span class="rounded-full bg-white px-4 py-2">
                            30-day free trial
                        </span>

                        <span class="rounded-full bg-white px-4 py-2">
                            No credit card required
                        </span>

                        <span class="rounded-full bg-white px-4 py-2">
                            Upgrade as you grow
                        </span>
                    </div>

                </div>


                {{-- Pricing Cards --}}
                <div class="mx-auto mt-14 grid max-w-6xl gap-6 lg:grid-cols-3">

                    {{-- Starter --}}
                    <div class="rounded-3xl border border-[#ddd9e5] bg-white p-8 shadow-sm">

                        <p class="text-sm font-semibold text-[#7021a8]">
                            Starter
                        </p>

                        <p class="mt-2 text-sm leading-6 text-[#8b8595]">
                            For churches getting started with better
                            administration.
                        </p>

                        <div class="mt-7">
                            <span class="text-4xl font-bold text-[#211b30]">
                                ₦20,000
                            </span>

                            <span class="text-sm text-[#8b8595]">
                                /month
                            </span>
                        </div>

                        <p class="mt-2 text-xs text-[#8b8595]">
                            Up to 250 members
                        </p>

                        <a
                            href="{{ route('register') }}"
                            class="mt-8 block rounded-xl border border-[#ddd9e5] bg-white px-5 py-3.5 text-center text-sm font-semibold text-[#211b30] transition hover:border-[#7021a8] hover:text-[#7021a8]"
                        >
                            Get Started
                        </a>

                    </div>


                    {{-- Growth --}}
                    <div class="relative rounded-3xl bg-gradient-to-br from-[#7021a8] to-[#b22962] p-[1px] shadow-xl shadow-[#7021a8]/15">

                        <div class="h-full rounded-[23px] bg-white p-8">

                            <div class="flex items-center justify-between">

                                <p class="text-sm font-semibold text-[#7021a8]">
                                    Growth
                                </p>

                                <span class="rounded-full bg-[#7021a8]/10 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-[#7021a8]">
                                    Most Popular
                                </span>

                            </div>

                            <p class="mt-2 text-sm leading-6 text-[#8b8595]">
                                For growing churches that need more visibility
                                and control.
                            </p>

                            <div class="mt-7">
                                <span class="text-4xl font-bold text-[#211b30]">
                                    ₦50,000
                                </span>

                                <span class="text-sm text-[#8b8595]">
                                    /month
                                </span>
                            </div>

                            <p class="mt-2 text-xs text-[#8b8595]">
                                Up to 1,000 members
                            </p>

                            <a
                                href="{{ route('register') }}"
                                class="cf-gradient-button mt-8 block rounded-xl px-5 py-3.5 text-center text-sm font-semibold text-white shadow-md shadow-[#7021a8]/15 transition hover:-translate-y-0.5"
                            >
                                Get Started
                            </a>

                        </div>

                    </div>


                    {{-- Enterprise --}}
                    <div class="rounded-3xl bg-[#211b30] p-8 text-white shadow-sm">

                        <p class="text-sm font-semibold text-white">
                            Enterprise
                        </p>

                        <p class="mt-2 text-sm leading-6 text-white/60">
                            For larger churches that need a broader
                            administrative capacity.
                        </p>

                        <div class="mt-7">
                            <span class="text-4xl font-bold">
                                ₦200,000
                            </span>

                            <span class="text-sm text-white/50">
                                /month
                            </span>
                        </div>

                        <p class="mt-2 text-xs text-white/50">
                            Up to 5,000 members
                        </p>

                        <a
                            href="{{ route('register') }}"
                            class="mt-8 block rounded-xl bg-white px-5 py-3.5 text-center text-sm font-semibold text-[#211b30] transition hover:bg-[#f4f1f7]"
                        >
                            Get Started
                        </a>

                    </div>

                </div>

            </div>

        </section>


        {{-- Pricing Note --}}
        <section class="border-t border-[#ddd9e5] bg-white py-16">

            <div class="mx-auto max-w-3xl px-6 text-center lg:px-8">

                <h2 class="text-2xl font-bold text-[#211b30]">
                    Need help choosing a plan?
                </h2>

                <p class="mt-3 text-sm leading-7 text-[#8b8595]">
                    Tell us about your church and we'll help you understand
                    which ChurchFlow plan fits your current needs.
                </p>

                <a
                    href="{{ route('landing') }}#contact"
                    class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-[#7021a8] transition hover:text-[#b22962]"
                >
                    Talk to our team

                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 12h14M13 6l6 6-6 6"
                        />
                    </svg>
                </a>

            </div>

        </section>

    </main>


    {{-- Footer --}}
    @include('landing.sections.footer')

</body>

</html>