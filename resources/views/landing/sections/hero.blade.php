{{-- =========================================================
     HERO
========================================================= --}}
<section class="relative overflow-hidden bg-[#f4f1f7] pt-32 pb-20 lg:pt-40 lg:pb-28">

    {{-- Background Glow --}}
    <div class="pointer-events-none absolute -left-40 top-20 h-96 w-96 rounded-full bg-purple-300/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -right-40 top-40 h-96 w-96 rounded-full bg-pink-300/20 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-6 lg:px-8">

        {{-- Hero Content --}}
        <div class="mx-auto max-w-5xl text-center">

            {{-- Eyebrow --}}
            <div class="mb-7 inline-flex items-center gap-2 rounded-full border border-[#ddd9e5] bg-white px-4 py-2 shadow-sm">
                <span class="h-2 w-2 rounded-full bg-[#b22962]"></span>

                <span class="text-xs font-bold uppercase tracking-[0.18em] text-[#7021a8]">
                    Church Management Platform
                </span>
            </div>

            {{-- Main Heading --}}
            <h1 class="text-5xl font-black leading-[1.02] tracking-[-0.04em] text-[#211b30] sm:text-6xl lg:text-8xl">
                Run your church.
                <span class="block">
                    <span
                        class="bg-clip-text text-transparent"
                        style="background-image: linear-gradient(90deg, #7021a8, #b22962);"
                    >
                        Understand your numbers.
                    </span>
                </span>
            </h1>

            {{-- Supporting Text --}}
            <p class="mx-auto mt-7 max-w-2xl text-lg leading-8 text-[#746d7d] sm:text-xl">
                ChurchFlow brings your finances, members, attendance,
                giving and church operations together in one simple,
                powerful platform.
            </p>

            {{-- CTA --}}
            <div class="mt-9 flex flex-col items-center justify-center gap-3 sm:flex-row">

                <a
                    href="{{ route('register') }}"
                    class="inline-flex items-center justify-center rounded-xl px-7 py-4 text-sm font-bold text-white shadow-xl shadow-purple-200 transition duration-200 hover:-translate-y-1"
                    style="background: linear-gradient(90deg, #7021a8, #b22962);"
                >
                    Start Your 30-Day Free Trial
                    <span class="ml-2 text-lg">→</span>
                </a>

                <a
                    href="#features"
                    class="inline-flex items-center justify-center rounded-xl border border-[#d9d4e0] bg-white px-7 py-4 text-sm font-bold text-[#211b30] transition hover:border-[#b22962] hover:text-[#7021a8]"
                >
                    Explore ChurchFlow
                </a>

            </div>

            {{-- Trust Points --}}
            <div class="mt-7 flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-sm text-[#8b8595]">
                <span>✓ 30-day free trial</span>
                <span>✓ No credit card required</span>
                <span>✓ Easy onboarding</span>
            </div>
        </div>


        {{-- =====================================================
             PRODUCT PREVIEW
        ====================================================== --}}
        <div class="relative mx-auto mt-16 max-w-6xl">

            {{-- Glow --}}
            <div
                class="absolute inset-x-16 -bottom-8 h-40 rounded-full opacity-30 blur-3xl"
                style="background: linear-gradient(90deg, #7021a8, #b22962);"
            ></div>

            {{-- Browser Frame --}}
            <div class="relative overflow-hidden rounded-2xl border border-[#ddd9e5] bg-white shadow-[0_30px_80px_rgba(33,27,48,0.15)]">

                {{-- Browser Header --}}
                <div class="flex h-12 items-center justify-between border-b border-[#eeeaf1] bg-white px-5">

                    <div class="flex items-center gap-2">
                        <span class="h-2.5 w-2.5 rounded-full bg-[#ddd9e5]"></span>
                        <span class="h-2.5 w-2.5 rounded-full bg-[#ddd9e5]"></span>
                        <span class="h-2.5 w-2.5 rounded-full bg-[#ddd9e5]"></span>
                    </div>

                    <div class="hidden rounded-lg bg-[#f7f5f8] px-5 py-1.5 text-[10px] text-[#aaa4b1] sm:block">
                        app.churchflow.com
                    </div>

                    <div class="h-6 w-6 rounded-full bg-[#f0eaf5]"></div>
                </div>


                {{-- Dashboard --}}
                <div class="flex min-h-[520px] bg-[#f8f7fa]">

                    {{-- Sidebar --}}
                    <aside class="hidden w-56 shrink-0 border-r border-[#e8e4eb] bg-white p-4 md:block">

                        <div class="mb-8 flex items-center gap-2 px-2">
                            <div
                                class="flex h-8 w-8 items-center justify-center rounded-lg text-[10px] font-bold text-white"
                                style="background: linear-gradient(135deg, #7021a8, #b22962);"
                            >
                                CF
                            </div>

                            <span class="text-sm font-bold text-[#211b30]">
                                ChurchFlow
                            </span>
                        </div>

                        <div class="space-y-1">

                            <div class="rounded-lg bg-[#f3eaf8] px-3 py-2.5 text-xs font-semibold text-[#7021a8]">
                                Dashboard
                            </div>

                            <div class="px-3 py-2.5 text-xs text-[#817a89]">
                                Members
                            </div>

                            <div class="px-3 py-2.5 text-xs text-[#817a89]">
                                Attendance
                            </div>

                            <div class="px-3 py-2.5 text-xs text-[#817a89]">
                                Giving
                            </div>

                            <div class="px-3 py-2.5 text-xs text-[#817a89]">
                                Finances
                            </div>

                            <div class="px-3 py-2.5 text-xs text-[#817a89]">
                                Reports
                            </div>

                        </div>

                        <div class="mt-10 border-t border-[#eeeaf1] pt-4">
                            <div class="px-3 py-2.5 text-xs text-[#817a89]">
                                Settings
                            </div>
                        </div>

                    </aside>


                    {{-- Main Dashboard --}}
                    <div class="min-w-0 flex-1 p-5 sm:p-7">

                        {{-- Dashboard Header --}}
                        <div class="mb-6 flex items-center justify-between">

                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-wider text-[#9a94a2]">
                                    Overview
                                </p>

                                <h3 class="mt-1 text-xl font-bold text-[#211b30]">
                                    Good morning, Admin
                                </h3>
                            </div>

                            <div class="hidden rounded-lg border border-[#e5e1e8] bg-white px-3 py-2 text-xs text-[#817a89] sm:block">
                                September 2026
                            </div>

                        </div>


                        {{-- Stats --}}
                        <div class="grid grid-cols-2 gap-3 lg:grid-cols-4">

                            <div class="rounded-xl border border-[#e7e3ea] bg-white p-4">
                                <p class="text-[11px] text-[#96909e]">Total Income</p>
                                <p class="mt-2 text-xl font-bold text-[#211b30]">₦4.8M</p>
                                <p class="mt-1 text-[10px] font-medium text-[#7021a8]">
                                    Monthly
                                </p>
                            </div>

                            <div class="rounded-xl border border-[#e7e3ea] bg-white p-4">
                                <p class="text-[11px] text-[#96909e]">Expenses</p>
                                <p class="mt-2 text-xl font-bold text-[#211b30]">₦2.1M</p>
                                <p class="mt-1 text-[10px] font-medium text-[#b22962]">
                                    This month
                                </p>
                            </div>

                            <div class="rounded-xl border border-[#e7e3ea] bg-white p-4">
                                <p class="text-[11px] text-[#96909e]">Members</p>
                                <p class="mt-2 text-xl font-bold text-[#211b30]">1,284</p>
                                <p class="mt-1 text-[10px] font-medium text-[#7021a8]">
                                    Active members
                                </p>
                            </div>

                            <div class="rounded-xl border border-[#e7e3ea] bg-white p-4">
                                <p class="text-[11px] text-[#96909e]">Attendance</p>
                                <p class="mt-2 text-xl font-bold text-[#211b30]">76%</p>
                                <p class="mt-1 text-[10px] font-medium text-[#b22962]">
                                    This month
                                </p>
                            </div>

                        </div>


                        {{-- Charts / Activity --}}
                        <div class="mt-4 grid gap-4 lg:grid-cols-3">

                            {{-- Financial Chart --}}
                            <div class="rounded-xl border border-[#e7e3ea] bg-white p-5 lg:col-span-2">

                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs font-semibold text-[#211b30]">
                                            Financial Overview
                                        </p>
                                        <p class="mt-1 text-[10px] text-[#9a94a2]">
                                            Income vs expenses
                                        </p>
                                    </div>

                                    <span class="rounded-lg bg-[#f5eef8] px-2.5 py-1 text-[10px] font-semibold text-[#7021a8]">
                                        2026
                                    </span>
                                </div>

                                {{-- Chart --}}
                                <div class="relative mt-6 h-48">

                                    <div class="absolute inset-0 flex flex-col justify-between">
                                        <div class="border-t border-dashed border-[#eeeaf1]"></div>
                                        <div class="border-t border-dashed border-[#eeeaf1]"></div>
                                        <div class="border-t border-dashed border-[#eeeaf1]"></div>
                                        <div class="border-t border-dashed border-[#eeeaf1]"></div>
                                        <div class="border-t border-dashed border-[#eeeaf1]"></div>
                                    </div>

                                    {{-- Visual bars --}}
                                    <div class="absolute inset-x-3 bottom-0 flex h-44 items-end justify-between gap-2">

                                        <div class="flex h-full items-end gap-1">
                                            <div class="w-3 rounded-t bg-[#d8c0e6]" style="height:45%"></div>
                                            <div class="w-3 rounded-t bg-[#7021a8]" style="height:65%"></div>
                                        </div>

                                        <div class="flex h-full items-end gap-1">
                                            <div class="w-3 rounded-t bg-[#d8c0e6]" style="height:55%"></div>
                                            <div class="w-3 rounded-t bg-[#7021a8]" style="height:72%"></div>
                                        </div>

                                        <div class="flex h-full items-end gap-1">
                                            <div class="w-3 rounded-t bg-[#d8c0e6]" style="height:48%"></div>
                                            <div class="w-3 rounded-t bg-[#7021a8]" style="height:60%"></div>
                                        </div>

                                        <div class="flex h-full items-end gap-1">
                                            <div class="w-3 rounded-t bg-[#d8c0e6]" style="height:62%"></div>
                                            <div class="w-3 rounded-t bg-[#7021a8]" style="height:78%"></div>
                                        </div>

                                        <div class="flex h-full items-end gap-1">
                                            <div class="w-3 rounded-t bg-[#d8c0e6]" style="height:58%"></div>
                                            <div class="w-3 rounded-t bg-[#7021a8]" style="height:82%"></div>
                                        </div>

                                        <div class="flex h-full items-end gap-1">
                                            <div class="w-3 rounded-t bg-[#d8c0e6]" style="height:70%"></div>
                                            <div class="w-3 rounded-t bg-[#7021a8]" style="height:88%"></div>
                                        </div>

                                    </div>
                                </div>

                                <div class="mt-3 flex justify-between text-[9px] text-[#aaa4b1]">
                                    <span>Apr</span>
                                    <span>May</span>
                                    <span>Jun</span>
                                    <span>Jul</span>
                                    <span>Aug</span>
                                    <span>Sep</span>
                                </div>

                            </div>


                            {{-- Recent Activity --}}
                            <div class="rounded-xl border border-[#e7e3ea] bg-white p-5">

                                <p class="text-xs font-semibold text-[#211b30]">
                                    Recent Activity
                                </p>

                                <div class="mt-5 space-y-4">

                                    <div class="flex gap-3">
                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#f4eafa] text-xs text-[#7021a8]">
                                            ₦
                                        </div>

                                        <div>
                                            <p class="text-[11px] font-semibold text-[#211b30]">
                                                Giving received
                                            </p>

                                            <p class="text-[10px] text-[#99929f]">
                                                ₦250,000 · Today
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex gap-3">
                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#fbeaf2] text-xs text-[#b22962]">
                                            +
                                        </div>

                                        <div>
                                            <p class="text-[11px] font-semibold text-[#211b30]">
                                                New member added
                                            </p>

                                            <p class="text-[10px] text-[#99929f]">
                                                3 new members · Today
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex gap-3">
                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#f4eafa] text-xs text-[#7021a8]">
                                            ✓
                                        </div>

                                        <div>
                                            <p class="text-[11px] font-semibold text-[#211b30]">
                                                Attendance recorded
                                            </p>

                                            <p class="text-[10px] text-[#99929f]">
                                                Sunday Service · 76%
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex gap-3">
                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#fbeaf2] text-xs text-[#b22962]">
                                            ₦
                                        </div>

                                        <div>
                                            <p class="text-[11px] font-semibold text-[#211b30]">
                                                Expense recorded
                                            </p>

                                            <p class="text-[10px] text-[#99929f]">
                                                ₦85,000 · Yesterday
                                            </p>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

            {{-- Floating Product Badge --}}
            <div class="absolute -bottom-5 left-6 hidden rounded-xl border border-[#e4ddea] bg-white px-5 py-3 shadow-xl sm:block lg:left-10">
                <p class="text-[10px] font-medium text-[#99929f]">
                    Everything in one place
                </p>

                <p class="mt-0.5 text-sm font-bold text-[#211b30]">
                    Finance · Members · Attendance
                </p>
            </div>

        </div>


        {{-- Bottom Statement --}}
        <div class="mx-auto mt-16 max-w-3xl text-center">
            <p class="text-sm leading-7 text-[#817a89]">
                From Sunday attendance to monthly financial reports,
                <span class="font-semibold text-[#7021a8]">
                    ChurchFlow gives your team the visibility they need
                </span>
                to manage your church with confidence.
            </p>
        </div>

    </div>
</section>