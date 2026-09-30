<!-- Contact Section -->
<section id="contact" class="relative overflow-hidden bg-[#f4f1f7] py-24 sm:py-28">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">

        <!-- Section Header -->
        <div class="max-w-3xl">
            <span class="inline-flex items-center rounded-full border border-[#ddd9e5] bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-[#7021a8]">
                Talk to ChurchFlow
            </span>

            <h2 class="mt-6 text-4xl font-bold tracking-tight text-[#211b30] sm:text-5xl">
                Have a question?
                <span class="text-[#b22962]">Let's talk.</span>
            </h2>

            <p class="mt-5 max-w-2xl text-lg leading-8 text-[#8b8595]">
                Whether you want a product demo, need help choosing a plan,
                or simply want to learn more about ChurchFlow, our team is ready
                to help.
            </p>
        </div>

        <div class="mt-14 grid gap-10 lg:grid-cols-5">

            <!-- Contact Information -->
            <div class="lg:col-span-2">

                <div class="rounded-3xl bg-[#211b30] p-8 text-white sm:p-10">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-white/60">
                        Get in touch
                    </p>

                    <h3 class="mt-4 text-2xl font-bold">
                        Let's make church administration simpler.
                    </h3>

                    <p class="mt-4 text-sm leading-7 text-white/65">
                        Tell us what you need and we'll help you understand how
                        ChurchFlow can fit into your church's workflow.
                    </p>

                    <div class="mt-8 space-y-5">

                        <!-- Phone -->
                        <a
                            href="tel:08120081213"
                            class="group flex items-center gap-4"
                        >
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white/10 transition group-hover:bg-white/15">
                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M3 5a2 2 0 012-2h3.28a2 2 0 011.94 1.515l.7 2.8a2 2 0 01-.45 1.85L9.2 10.44a16.05 16.05 0 006.36 6.36l1.275-1.27a2 2 0 011.85-.45l2.8.7A2 2 0 0123 17.72V21a2 2 0 01-2 2C10.61 23 1 13.39 1 3a2 2 0 012-2z"/>
                                </svg>
                            </div>

                            <div>
                                <p class="text-xs text-white/45">Phone</p>
                                <p class="mt-1 text-sm font-medium">
                                    08120081213
                                </p>
                            </div>
                        </a>

                        <!-- Email -->
                        <a
                            href="mailto:info@techcrossbreed.com.ng"
                            class="group flex items-center gap-4"
                        >
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white/10 transition group-hover:bg-white/15">
                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M3 8l9 6 9-6M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"/>
                                </svg>
                            </div>

                            <div>
                                <p class="text-xs text-white/45">Email</p>
                                <p class="mt-1 text-sm font-medium">
                                    info@techcrossbreed.com.ng
                                </p>
                            </div>
                        </a>

                    </div>

                    <div class="mt-10 border-t border-white/10 pt-8">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-white/45">
                            Available for
                        </p>

                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="rounded-full bg-white/10 px-3 py-1.5 text-xs text-white/70">
                                Product Demo
                            </span>

                            <span class="rounded-full bg-white/10 px-3 py-1.5 text-xs text-white/70">
                                Pricing
                            </span>

                            <span class="rounded-full bg-white/10 px-3 py-1.5 text-xs text-white/70">
                                Support
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Contact Form -->
            <div class="lg:col-span-3">

                <div class="rounded-3xl border border-[#ddd9e5] bg-white p-8 shadow-sm sm:p-10">

                    @if(session('contact_success'))
                        <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">
                            {{ session('contact_success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4">
                            <p class="text-sm font-semibold text-red-700">
                                Please correct the following:
                            </p>

                            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-600">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-8">
                        <p class="text-sm font-semibold uppercase tracking-[0.16em] text-[#7021a8]">
                            Contact form
                        </p>

                        <h3 class="mt-3 text-2xl font-bold text-[#211b30]">
                            Tell us how we can help.
                        </h3>
                    </div>

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid gap-6 sm:grid-cols-2">

                            <!-- Name -->
                            <div>
                                <label for="name" class="mb-2 block text-sm font-semibold text-[#211b30]">
                                    Your Name
                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    placeholder="John Doe"
                                    class="w-full rounded-xl border border-[#ddd9e5] bg-[#faf9fb] px-4 py-3.5 text-sm text-[#211b30] outline-none transition placeholder:text-[#aaa5b0] focus:border-[#7021a8] focus:ring-2 focus:ring-[#7021a8]/10"
                                >
                            </div>

                            <!-- Church -->
                            <div>
                                <label for="church_name" class="mb-2 block text-sm font-semibold text-[#211b30]">
                                    Church Name
                                </label>

                                <input
                                    type="text"
                                    id="church_name"
                                    name="church_name"
                                    value="{{ old('church_name') }}"
                                    required
                                    placeholder="Your Church Name"
                                    class="w-full rounded-xl border border-[#ddd9e5] bg-[#faf9fb] px-4 py-3.5 text-sm text-[#211b30] outline-none transition placeholder:text-[#aaa5b0] focus:border-[#7021a8] focus:ring-2 focus:ring-[#7021a8]/10"
                                >
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="mb-2 block text-sm font-semibold text-[#211b30]">
                                    Email Address
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    placeholder="you@church.com"
                                    class="w-full rounded-xl border border-[#ddd9e5] bg-[#faf9fb] px-4 py-3.5 text-sm text-[#211b30] outline-none transition placeholder:text-[#aaa5b0] focus:border-[#7021a8] focus:ring-2 focus:ring-[#7021a8]/10"
                                >
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="mb-2 block text-sm font-semibold text-[#211b30]">
                                    Phone Number
                                    <span class="font-normal text-[#aaa5b0]">(Optional)</span>
                                </label>

                                <input
                                    type="text"
                                    id="phone"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    placeholder="0812 008 1213"
                                    class="w-full rounded-xl border border-[#ddd9e5] bg-[#faf9fb] px-4 py-3.5 text-sm text-[#211b30] outline-none transition placeholder:text-[#aaa5b0] focus:border-[#7021a8] focus:ring-2 focus:ring-[#7021a8]/10"
                                >
                            </div>

                        </div>

                        <!-- Subject -->
                        <div>
                            <label for="subject" class="mb-2 block text-sm font-semibold text-[#211b30]">
                                What can we help with?
                            </label>

                            <select
                                id="subject"
                                name="subject"
                                required
                                class="w-full rounded-xl border border-[#ddd9e5] bg-[#faf9fb] px-4 py-3.5 text-sm text-[#211b30] outline-none transition focus:border-[#7021a8] focus:ring-2 focus:ring-[#7021a8]/10"
                            >
                                <option value="">Select an option</option>
                                <option value="demo" {{ old('subject') === 'demo' ? 'selected' : '' }}>
                                    I want a product demo
                                </option>
                                <option value="pricing" {{ old('subject') === 'pricing' ? 'selected' : '' }}>
                                    I have a pricing question
                                </option>
                                <option value="support" {{ old('subject') === 'support' ? 'selected' : '' }}>
                                    I need support
                                </option>
                                <option value="other" {{ old('subject') === 'other' ? 'selected' : '' }}>
                                    Something else
                                </option>
                            </select>
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="mb-2 block text-sm font-semibold text-[#211b30]">
                                Message
                            </label>

                            <textarea
                                id="message"
                                name="message"
                                rows="6"
                                required
                                placeholder="Tell us a little about what you need..."
                                class="w-full resize-none rounded-xl border border-[#ddd9e5] bg-[#faf9fb] px-4 py-3.5 text-sm text-[#211b30] outline-none transition placeholder:text-[#aaa5b0] focus:border-[#7021a8] focus:ring-2 focus:ring-[#7021a8]/10"
                            >{{ old('message') }}</textarea>
                        </div>

                        <!-- Submit -->
                        <div class="flex flex-col gap-4 pt-2 sm:flex-row sm:items-center sm:justify-between">

                            <p class="max-w-sm text-xs leading-5 text-[#8b8595]">
                                By submitting this form, you agree to be contacted
                                regarding your enquiry.
                            </p>

                            <button
                                type="submit"
                                class="cf-gradient-button inline-flex items-center justify-center gap-2 rounded-xl px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-[#7021a8]/15 transition hover:-translate-y-0.5"
                            >
                                Send Message

                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 12h14M13 6l6 6-6 6"/>
                                </svg>
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>
</section>