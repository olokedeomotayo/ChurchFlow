<section
    class="bg-[#f4f1f7] py-24"
>

    <div class="mx-auto max-w-7xl px-6 lg:px-8">

        <div class="grid gap-14 lg:grid-cols-2 lg:items-center">


            {{-- Heading --}}

            <div>

                <p
                    class="text-sm font-extrabold uppercase tracking-[0.18em] text-[#7021a8]"
                >
                    Security & Accountability
                </p>

                <h2
                    class="mt-4 text-4xl font-extrabold leading-tight tracking-tight text-[#211b30] sm:text-5xl"
                >
                    Your church data deserves
                    <span
                        class="bg-gradient-to-r from-[#7021a8] to-[#b22962] bg-clip-text text-transparent"
                    >
                        serious protection.
                    </span>
                </h2>

                <p
                    class="mt-6 max-w-xl text-lg leading-8 text-[#8b8595]"
                >
                    ChurchFlow is designed with controlled access,
                    accountability and responsible management of
                    church information in mind.
                </p>


                {{-- Trust Statement --}}

                <div
                    class="mt-8 flex items-start gap-4 rounded-[14px] border border-[#ddd9e5] bg-white p-5 shadow-sm"
                >

                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[9px] bg-[#f4f1f7] text-[#7021a8]"
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
                                d="M12 3l8 4v5c0 5-3.5 8.5-8 9-4.5-.5-8-4-8-9V7l8-4z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12l2 2 4-4"
                            />

                        </svg>

                    </div>

                    <div>

                        <p
                            class="font-extrabold text-[#211b30]"
                        >
                            Built for responsible access
                        </p>

                        <p
                            class="mt-1 text-sm leading-6 text-[#8b8595]"
                        >
                            Keep sensitive church information accessible
                            to the right people and accountable to your team.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Security Features --}}

            <div class="grid gap-4 sm:grid-cols-2">

                @foreach([
                    [
                        'title' => 'Secure Authentication',
                        'text' => 'Protected account access for authorized users.'
                    ],
                    [
                        'title' => 'Role-Based Permissions',
                        'text' => 'Control what each team member can access.'
                    ],
                    [
                        'title' => 'Activity Logs',
                        'text' => 'Keep a record of important actions within the system.'
                    ],
                    [
                        'title' => 'Protected Financial Access',
                        'text' => 'Help restrict sensitive financial information to authorized users.'
                    ],
                    [
                        'title' => 'Data Backups',
                        'text' => 'Support reliable data protection and recovery processes.'
                    ],
                    [
                        'title' => 'Controlled Administration',
                        'text' => 'Give church administrators greater control over their organization.'
                    ]
                ] as $security)

                    <div
                        class="group rounded-[14px] border border-[#ddd9e5] bg-white p-5 shadow-[0_8px_25px_rgba(45,20,70,.04)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_15px_35px_rgba(45,20,70,.09)]"
                    >

                        <div class="flex items-start gap-4">

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[9px] bg-[#f4f1f7] text-[#7021a8] transition group-hover:bg-[#7021a8] group-hover:text-white"
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
                                        d="M5 13l4 4L19 7"
                                    />

                                </svg>

                            </div>

                            <div>

                                <h3
                                    class="font-extrabold text-[#211b30]"
                                >
                                    {{ $security['title'] }}
                                </h3>

                                <p
                                    class="mt-1.5 text-xs leading-5 text-[#8b8595]"
                                >
                                    {{ $security['text'] }}
                                </p>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</section>