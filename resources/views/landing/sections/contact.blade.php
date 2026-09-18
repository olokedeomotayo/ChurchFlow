<section
    id="contact"
    class="bg-[#f4f1f7] py-24"
>

    <div class="mx-auto max-w-7xl px-6 lg:px-8">

        <div class="grid gap-12 lg:grid-cols-2 lg:gap-20">


            {{-- Contact Information --}}

            <div class="flex flex-col justify-center">

                <p
                    class="text-sm font-extrabold uppercase tracking-[0.18em] text-[#7021a8]"
                >
                    Contact Us
                </p>

                <h2
                    class="mt-4 text-4xl font-extrabold leading-tight tracking-tight text-[#211b30] sm:text-5xl"
                >
                    Have questions?
                    <span
                        class="bg-gradient-to-r from-[#7021a8] to-[#b22962] bg-clip-text text-transparent"
                    >
                        Let's talk.
                    </span>
                </h2>

                <p
                    class="mt-6 max-w-xl text-lg leading-8 text-[#8b8595]"
                >
                    Want a demo, have questions about pricing or need help
                    deciding which plan is right for your church?
                    Send us a message and our team will get back to you.
                </p>


                {{-- Contact Points --}}

                <div class="mt-10 space-y-5">


                    {{-- Demo --}}

                    <div class="flex items-start gap-4">

                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-[9px] bg-white text-[#7021a8] shadow-sm"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 10l4.55-2.28A1 1 0 0121 8.62v6.76a1 1 0 01-1.45.9L15 14"
                                />

                                <rect
                                    x="3"
                                    y="6"
                                    width="12"
                                    height="12"
                                    rx="2"
                                />

                            </svg>

                        </div>

                        <div>

                            <p class="font-extrabold text-[#211b30]">
                                Request a Demo
                            </p>

                            <p class="mt-1 text-sm leading-6 text-[#8b8595]">
                                See how ChurchFlow can work for your church.
                            </p>

                        </div>

                    </div>


                    {{-- Pricing --}}

                    <div class="flex items-start gap-4">

                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-[9px] bg-white text-[#b22962] shadow-sm"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 2v20"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H7"
                                />

                            </svg>

                        </div>

                        <div>

                            <p class="font-extrabold text-[#211b30]">
                                Need Help Choosing a Plan?
                            </p>

                            <p class="mt-1 text-sm leading-6 text-[#8b8595]">
                                We'll help you find the right option
                                for your church.
                            </p>

                        </div>

                    </div>


                    {{-- Trial --}}

                    <div class="flex items-start gap-4">

                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-[9px] bg-white text-[#7021a8] shadow-sm"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
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

                        <div>

                            <p class="font-extrabold text-[#211b30]">
                                30-Day Free Trial
                            </p>

                            <p class="mt-1 text-sm leading-6 text-[#8b8595]">
                                Start exploring ChurchFlow without
                                a credit card.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- CTA --}}

                <div class="mt-10">

                    <a
                        href="{{ route('register') }}"
                        class="cf-gradient-button inline-flex items-center rounded-[9px] px-6 py-3.5 text-sm font-extrabold text-white"
                    >
                        Get Started →
                    </a>

                </div>

            </div>


            {{-- Contact Form --}}

            <div
                class="rounded-[20px] border border-[#ddd9e5] bg-white p-7 shadow-[0_20px_50px_rgba(45,20,70,.08)] sm:p-9"
            >

                <div class="mb-7">

                    <h3
                        class="text-2xl font-extrabold text-[#211b30]"
                    >
                        Send us a message
                    </h3>

                    <p
                        class="mt-2 text-sm leading-6 text-[#8b8595]"
                    >
                        Fill in the form below and we'll get back
                        to you as soon as possible.
                    </p>

                </div>

                @if (session('contact_success'))

                    <div
                        class="mb-6 rounded-[12px] border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-700"
                    >
                        {{ session('contact_success') }}
                    </div>

                @endif

                @if ($errors->any())

                    <div
                        class="mb-6 rounded-[12px] border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                    >

                        <p class="font-extrabold">
                            Please check the following:
                        </p>

                        <ul class="mt-2 list-disc space-y-1 pl-5">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif

                <form
                    action="{{ route('contact.store') }}"
                    method="POST"
                >

                    @csrf


                    <div class="grid gap-5">


                        {{-- Name --}}

                        <div>

                            <label
                                for="contact_name"
                                class="text-sm font-extrabold text-[#332c40]"
                            >
                                Your Name
                            </label>

                            <input
                                id="contact_name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Enter your name"
                                class="mt-2 h-12 w-full rounded-[9px] border border-[#ddd9e5] bg-white px-4 text-sm text-[#211d32] outline-none transition focus:border-[#7021a8] focus:ring-4 focus:ring-[#7021a8]/5"
                                required
                            >

                        </div>


                        {{-- Church Name --}}

                        <div>

                            <label
                                for="church_name"
                                class="text-sm font-extrabold text-[#332c40]"
                            >
                                Church Name
                            </label>

                            <input
                                id="church_name"
                                type="text"
                                name="church_name"
                                value="{{ old('church_name') }}"
                                placeholder="Enter your church name"
                                class="mt-2 h-12 w-full rounded-[9px] border border-[#ddd9e5] bg-white px-4 text-sm text-[#211d32] outline-none transition focus:border-[#7021a8] focus:ring-4 focus:ring-[#7021a8]/5"
                                required
                            >

                        </div>


                        {{-- Email + Phone --}}

                        <div class="grid gap-5 sm:grid-cols-2">


                            <div>

                                <label
                                    for="contact_email"
                                    class="text-sm font-extrabold text-[#332c40]"
                                >
                                    Email Address
                                </label>

                                <input
                                    id="contact_email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="you@example.com"
                                    class="mt-2 h-12 w-full rounded-[9px] border border-[#ddd9e5] bg-white px-4 text-sm text-[#211d32] outline-none transition focus:border-[#7021a8] focus:ring-4 focus:ring-[#7021a8]/5"
                                    required
                                >

                            </div>


                            <div>

                                <label
                                    for="contact_phone"
                                    class="text-sm font-extrabold text-[#332c40]"
                                >
                                    Phone Number
                                </label>

                                <input
                                    id="contact_phone"
                                    type="tel"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    placeholder="+234..."
                                    class="mt-2 h-12 w-full rounded-[9px] border border-[#ddd9e5] bg-white px-4 text-sm text-[#211d32] outline-none transition focus:border-[#7021a8] focus:ring-4 focus:ring-[#7021a8]/5"
                                >

                            </div>

                        </div>


                        {{-- Subject --}}

                        <div>

                            <label
                                for="contact_subject"
                                class="text-sm font-extrabold text-[#332c40]"
                            >
                                What can we help with?
                            </label>

                            <select
                                id="contact_subject"
                                name="subject"
                                class="mt-2 h-12 w-full rounded-[9px] border border-[#ddd9e5] bg-white px-4 text-sm text-[#211d32] outline-none transition focus:border-[#7021a8] focus:ring-4 focus:ring-[#7021a8]/5"
                                required
                            >

                                <option value="">
                                    Select an option
                                </option>

                                <option value="demo">
                                    Request a Demo
                                </option>

                                <option value="pricing">
                                    Pricing Question
                                </option>

                                <option value="support">
                                    Product Question
                                </option>

                                <option value="other">
                                    Something Else
                                </option>

                            </select>

                        </div>


                        {{-- Message --}}

                        <div>

                            <label
                                for="contact_message"
                                class="text-sm font-extrabold text-[#332c40]"
                            >
                                Message
                            </label>

                            <textarea
                                id="contact_message"
                                name="message"
                                rows="5"
                                placeholder="Tell us how we can help..."
                                class="mt-2 w-full rounded-[9px] border border-[#ddd9e5] bg-white px-4 py-3 text-sm leading-6 text-[#211d32] outline-none transition focus:border-[#7021a8] focus:ring-4 focus:ring-[#7021a8]/5"
                                required
                            >{{ old('message') }}</textarea>

                        </div>


                        {{-- Submit --}}

                        <button
                            type="submit"
                            class="cf-gradient-button w-full rounded-[9px] px-6 py-3.5 text-sm font-extrabold text-white"
                        >
                            Send Message →
                        </button>


                        <p
                            class="text-center text-[11px] leading-5 text-[#aaa4b2]"
                        >
                            We'll only use your information to respond
                            to your enquiry.
                        </p>

                    </div>

                </form>

            </div>

        </div>

    </div>

</section>