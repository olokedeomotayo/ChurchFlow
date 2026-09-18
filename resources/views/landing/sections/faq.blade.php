<section
    id="faq"
    class="bg-white py-24"
>

    <div class="mx-auto max-w-4xl px-6 lg:px-8">


        {{-- Section Heading --}}

        <div class="mx-auto max-w-3xl text-center">

            <p
                class="text-sm font-extrabold uppercase tracking-[0.18em] text-[#7021a8]"
            >
                FAQ
            </p>

            <h2
                class="mt-4 text-4xl font-extrabold tracking-tight text-[#211b30] sm:text-5xl"
            >
                Frequently asked questions.
            </h2>

            <p
                class="mt-5 text-lg leading-8 text-[#8b8595]"
            >
                Everything you need to know about getting started
                with ChurchFlow.
            </p>

        </div>


        {{-- FAQ List --}}

        <div class="mt-14 space-y-3">

            @foreach([
                [
                    'q' => 'How long is the free trial?',
                    'a' => 'Every new church account starts with a 30-day trial period. You can explore ChurchFlow, set up your church and begin using the platform before choosing a subscription plan.'
                ],
                [
                    'q' => 'Do I need a credit card to start?',
                    'a' => 'No. You can create your ChurchFlow account and start your 30-day trial without entering payment details.'
                ],
                [
                    'q' => 'Can multiple people manage our church?',
                    'a' => 'Yes. Church administrators can invite authorized team members and assign appropriate roles and permissions based on their responsibilities.'
                ],
                [
                    'q' => 'Can we manage church finances?',
                    'a' => 'Yes. ChurchFlow provides tools for recording income, expenses, giving and other financial activities while helping leadership understand the church’s financial position.'
                ],
                [
                    'q' => 'Can members check in for services?',
                    'a' => 'Yes. The Check-In and Attendance module is designed to make service attendance easier to record, organize and understand.'
                ],
                [
                    'q' => 'What happens after the trial?',
                    'a' => 'After the 30-day trial, your church can select the subscription plan that best fits its needs and continue using ChurchFlow.'
                ]
            ] as $faq)

                <details
                    class="group rounded-[14px] border border-[#ddd9e5] bg-[#f4f1f7] px-6 transition duration-300 open:bg-white open:shadow-[0_10px_30px_rgba(45,20,70,.06)]"
                >

                    <summary
                        class="flex cursor-pointer list-none items-center justify-between gap-6 py-6 text-sm font-extrabold text-[#211b30] marker:hidden"
                    >

                        <span>
                            {{ $faq['q'] }}
                        </span>


                        <span
                            class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white text-lg font-medium text-[#7021a8] shadow-sm transition duration-300 group-open:rotate-45 group-open:bg-[#7021a8] group-open:text-white"
                        >
                            +
                        </span>

                    </summary>


                    <div class="pb-6 pr-12">

                        <p
                            class="text-sm leading-7 text-[#8b8595]"
                        >
                            {{ $faq['a'] }}
                        </p>

                    </div>

                </details>

            @endforeach

        </div>


        {{-- FAQ CTA --}}

        <div
            class="mt-12 rounded-[20px] border border-[#ddd9e5] bg-[#f4f1f7] p-7 text-center"
        >

            <p
                class="font-extrabold text-[#211b30]"
            >
                Still have questions?
            </p>

            <p
                class="mt-2 text-sm text-[#8b8595]"
            >
                We're happy to help you understand how ChurchFlow
                can work for your church.
            </p>

            <a
                href="{{ route('register') }}"
                class="cf-gradient-button mt-5 inline-flex rounded-[9px] px-6 py-3 text-sm font-extrabold text-white"
            >
                Get Started →
            </a>

        </div>

    </div>

</section>