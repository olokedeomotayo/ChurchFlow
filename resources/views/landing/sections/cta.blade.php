{{-- =========================================================
     FINAL CTA
========================================================= --}}
<section class="relative overflow-hidden bg-[#211b30] py-20 sm:py-24">

    <div class="absolute inset-0 opacity-30">
        <div class="absolute -left-32 -top-32 h-80 w-80 rounded-full bg-[#7021a8] blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 h-80 w-80 rounded-full bg-[#b22962] blur-3xl"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">

        <div class="grid gap-12 lg:grid-cols-2 lg:items-center">

            {{-- CTA Content --}}
            <div>

                <span class="inline-flex items-center rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-white/70">
                    Get Started with ChurchFlow
                </span>

                <h2 class="mt-6 text-4xl font-bold tracking-tight text-white sm:text-5xl">
                    Your church is growing.
                    <span class="text-[#d77aaa]">
                        Your systems should grow with it.
                    </span>
                </h2>

                <p class="mt-5 max-w-xl text-base leading-7 text-white/60">
                    Bring your church members, attendance, finances and
                    administration together in one organized platform.
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row">

                    <a
                        href="{{ route('register') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-6 py-3.5 text-sm font-semibold text-[#211b30] transition hover:-translate-y-0.5 hover:bg-[#f4f1f7]"
                    >
                        Start Your 30-Day Free Trial

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

                    <a
                        href="#contact"
                        class="inline-flex items-center justify-center rounded-xl border border-white/15 px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-white/5"
                    >
                        Talk to Us
                    </a>

                </div>

                <div class="mt-6 flex flex-wrap gap-x-6 gap-y-2 text-xs text-white/45">

                    <span>30-day free trial</span>
                    <span>No credit card required</span>
                    <span>Built for churches</span>

                </div>

            </div>


            {{-- Contact Card --}}
            <div id="contact" class="rounded-3xl bg-white p-7 shadow-2xl shadow-black/10 sm:p-8">

                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#7021a8]">
                        Talk to us
                    </p>

                    <h3 class="mt-3 text-2xl font-bold text-[#211b30]">
                        Have a question?
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-[#8b8595]">
                        Tell us what you need and we'll get back to you.
                    </p>
                </div>


                {{-- Success Message --}}
                @if(session('contact_success'))
                    <div class="mt-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                        {{ session('contact_success') }}
                    </div>
                @endif


                {{-- Validation Errors --}}
                @if($errors->any())
                    <div class="mt-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-600">

                        <p class="font-semibold">
                            Please correct the following:
                        </p>

                        <ul class="mt-2 list-disc space-y-1 pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                    </div>
                @endif


                {{-- Contact Form --}}
                <form
                    action="{{ route('contact.store') }}"
                    method="POST"
                    class="mt-6 space-y-4"
                >
                    @csrf

                    <div class="grid gap-4 sm:grid-cols-2">

                        <div>
                            <label
                                for="name"
                                class="mb-1.5 block text-xs font-semibold text-[#211b30]"
                            >
                                Name
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                placeholder="Your name"
                                class="w-full rounded-xl border border-[#ddd9e5] bg-[#faf9fb] px-4 py-3 text-sm text-[#211b30] outline-none transition placeholder:text-[#aaa5b0] focus:border-[#7021a8] focus:ring-2 focus:ring-[#7021a8]/10"
                            >
                        </div>


                        <div>
                            <label
                                for="church_name"
                                class="mb-1.5 block text-xs font-semibold text-[#211b30]"
                            >
                                Church
                            </label>

                            <input
                                type="text"
                                id="church_name"
                                name="church_name"
                                value="{{ old('church_name') }}"
                                required
                                placeholder="Church name"
                                class="w-full rounded-xl border border-[#ddd9e5] bg-[#faf9fb] px-4 py-3 text-sm text-[#211b30] outline-none transition placeholder:text-[#aaa5b0] focus:border-[#7021a8] focus:ring-2 focus:ring-[#7021a8]/10"
                            >
                        </div>

                    </div>


                    <div>
                        <label
                            for="email"
                            class="mb-1.5 block text-xs font-semibold text-[#211b30]"
                        >
                            Email
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            placeholder="you@church.com"
                            class="w-full rounded-xl border border-[#ddd9e5] bg-[#faf9fb] px-4 py-3 text-sm text-[#211b30] outline-none transition placeholder:text-[#aaa5b0] focus:border-[#7021a8] focus:ring-2 focus:ring-[#7021a8]/10"
                        >
                    </div>


                    <div>
                        <label
                            for="subject"
                            class="mb-1.5 block text-xs font-semibold text-[#211b30]"
                        >
                            Subject
                        </label>

                        <select
                            id="subject"
                            name="subject"
                            required
                            class="w-full rounded-xl border border-[#ddd9e5] bg-[#faf9fb] px-4 py-3 text-sm text-[#211b30] outline-none transition focus:border-[#7021a8] focus:ring-2 focus:ring-[#7021a8]/10"
                        >
                            <option value="">Select an option</option>

                            <option
                                value="demo"
                                {{ old('subject') === 'demo' ? 'selected' : '' }}
                            >
                                Product Demo
                            </option>

                            <option
                                value="pricing"
                                {{ old('subject') === 'pricing' ? 'selected' : '' }}
                            >
                                Pricing
                            </option>

                            <option
                                value="support"
                                {{ old('subject') === 'support' ? 'selected' : '' }}
                            >
                                Support
                            </option>

                            <option
                                value="other"
                                {{ old('subject') === 'other' ? 'selected' : '' }}
                            >
                                Something Else
                            </option>
                        </select>
                    </div>


                    <div>
                        <label
                            for="message"
                            class="mb-1.5 block text-xs font-semibold text-[#211b30]"
                        >
                            Message
                        </label>

                        <textarea
                            id="message"
                            name="message"
                            rows="4"
                            required
                            placeholder="How can we help?"
                            class="w-full resize-none rounded-xl border border-[#ddd9e5] bg-[#faf9fb] px-4 py-3 text-sm text-[#211b30] outline-none transition placeholder:text-[#aaa5b0] focus:border-[#7021a8] focus:ring-2 focus:ring-[#7021a8]/10"
                        >{{ old('message') }}</textarea>
                    </div>


                    <button
                        type="submit"
                        class="cf-gradient-button w-full rounded-xl px-5 py-3.5 text-sm font-semibold text-white shadow-lg shadow-[#7021a8]/15 transition hover:-translate-y-0.5"
                    >
                        Send Message
                    </button>

                </form>


                {{-- Direct Contact --}}
                <div class="mt-6 flex flex-col gap-2 border-t border-[#eeeaf1] pt-5 text-xs text-[#8b8595] sm:flex-row sm:items-center sm:justify-between">

                    <a
                        href="tel:08120081213"
                        class="font-medium transition hover:text-[#7021a8]"
                    >
                        08120081213
                    </a>

                    <a
                        href="mailto:info@techcrossbreed.com.ng"
                        class="font-medium transition hover:text-[#7021a8]"
                    >
                        info@techcrossbreed.com.ng
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>