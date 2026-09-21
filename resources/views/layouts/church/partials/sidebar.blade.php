<aside class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col bg-slate-950 text-white">

    {{-- =========================================================
         BRAND
    ========================================================== --}}

    <div class="flex h-16 shrink-0 items-center border-b border-slate-800 px-6">

        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-purple-600 text-lg font-bold">
            C
        </div>

        <div class="ml-3 min-w-0">

            <h1 class="truncate text-lg font-bold tracking-tight">
                ChurchFlow
            </h1>

            <p class="text-[10px] uppercase tracking-wider text-slate-400">
                Church Management
            </p>

        </div>

    </div>


    {{-- =========================================================
         CURRENT CHURCH
    ========================================================== --}}

    <div class="shrink-0 border-b border-slate-800 px-5 py-5">

        <p class="mb-1 text-[10px] font-semibold uppercase tracking-wider text-slate-500">
            Current Church
        </p>

        <h2 class="truncate text-sm font-semibold text-white">
            {{ $church?->name ?? 'Church' }}
        </h2>

        <p class="mt-1 text-[11px] text-slate-500">
            Church Account
        </p>

    </div>


    {{-- =========================================================
         NAVIGATION
    ========================================================== --}}

    <nav class="flex-1 overflow-y-auto px-3 py-5">

        {{-- =====================================================
             MAIN MENU
        ====================================================== --}}

        <p class="mb-3 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500">
            Main Menu
        </p>


        {{-- Dashboard --}}

        <a
            href="{{ route('church.dashboard') }}"
            class="mb-1 flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 transition
                {{ request()->routeIs('church.dashboard')
                    ? 'bg-purple-600 text-white'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
        >
            <span class="w-5 text-center text-sm">
                ▣
            </span>

            <span class="text-sm font-medium">
                Dashboard
            </span>
        </a>


        {{-- Members --}}

        @php
            $membersActive = request()->routeIs('church.members.*');
        @endphp

        <a
            href="{{ route('church.members.index') }}"
            class="group mb-1 flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                {{ $membersActive
                    ? 'bg-purple-600 text-white'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                }}"
        >
            <svg
                class="h-5 w-5 shrink-0
                    {{ $membersActive
                        ? 'text-white'
                        : 'text-slate-400 group-hover:text-white'
                    }}"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                />
            </svg>

            <span>
                Members
            </span>
        </a>


        {{-- Check-In --}}

        @php
            $checkinActive = request()->routeIs('church.checkin.*');
        @endphp

        <a
            href="{{ route('church.checkin.index') }}"
            class="group mb-1 flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                {{ $checkinActive
                    ? 'bg-purple-600 text-white'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                }}"
        >
            <span
                class="w-5 text-center text-sm
                    {{ $checkinActive
                        ? 'text-white'
                        : 'text-slate-400'
                    }}"
            >
                ✓
            </span>

            <span>
                Check-In
            </span>
        </a>


        {{-- Attendance --}}

        @php
            $attendanceActive = request()->routeIs('church.attendance.*');
        @endphp

        <a
            href="{{ route('church.attendance.index') }}"
            class="group mb-1 flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                {{ $attendanceActive
                    ? 'bg-purple-600 text-white'
                    : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                }}"
        >
            <span
                class="w-5 text-center text-sm
                    {{ $attendanceActive
                        ? 'text-white'
                        : 'text-slate-400'
                    }}"
            >
                ◷
            </span>

            <span>
                Attendance
            </span>
        </a>


        {{-- =====================================================
             SERVICES
        ====================================================== --}}

        <div class="pt-6">

            <p class="mb-3 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                Services
            </p>

            @php
                $servicesActive = request()->routeIs('church.services.*');
            @endphp

            <a
                href="{{ route('church.services.index') }}"
                class="group mb-1 flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                    {{ $servicesActive
                        ? 'bg-purple-600 text-white'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                    }}"
            >
                <span
                    class="w-5 text-center text-sm
                        {{ $servicesActive
                            ? 'text-white'
                            : 'text-slate-400'
                        }}"
                >
                    ◫
                </span>

                <span>
                    Services
                </span>
            </a>

        </div>


        {{-- =====================================================
             FINANCE
        ====================================================== --}}

        <div class="pt-6">

            <p class="mb-3 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                Finance
            </p>


            {{-- Income --}}

            @php
                $incomeActive = request()->routeIs('church.income.*');
            @endphp

            <a
                href="{{ route('church.income.index') }}"
                class="group mb-1 flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                    {{ $incomeActive
                        ? 'bg-purple-600 text-white'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                    }}"
            >
                <span
                    class="w-5 text-center text-sm
                        {{ $incomeActive
                            ? 'text-white'
                            : 'text-slate-400 group-hover:text-white'
                        }}"
                >
                    ↗
                </span>

                <span>
                    Income
                </span>
            </a>


            {{-- Expenses --}}

            @php
                $expensesActive = request()->routeIs('church.expenses.*');
            @endphp

            <a
                href="{{ route('church.expenses.index') }}"
                class="group mb-1 flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                    {{ $expensesActive
                        ? 'bg-purple-600 text-white'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                    }}"
            >
                <span
                    class="w-5 text-center text-sm
                        {{ $expensesActive
                            ? 'text-white'
                            : 'text-slate-400 group-hover:text-white'
                        }}"
                >
                    ↘
                </span>

                <span>
                    Expenses
                </span>
            </a>


            {{-- Billing --}}

            @php
                $billingActive = request()->routeIs('church.payments.*');
            @endphp

            <a
                href="{{ route('church.payments.index') }}"
                class="group mb-1 flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                    {{ $billingActive
                        ? 'bg-purple-600 text-white'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                    }}"
            >
                <span
                    class="w-5 text-center text-sm
                        {{ $billingActive
                            ? 'text-white'
                            : 'text-slate-400 group-hover:text-white'
                        }}"
                >
                    ₦
                </span>

                <span>
                    Billing
                </span>
            </a>


            {{-- Financial Settings --}}

            @php
                $financialSettingsActive = request()->routeIs('church.settings.financial.*');
            @endphp

            <a
                href="{{ route('church.settings.financial.edit') }}"
                class="group mb-1 flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                    {{ $financialSettingsActive
                        ? 'bg-purple-600 text-white'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                    }}"
            >
                <span
                    class="w-5 text-center text-sm
                        {{ $financialSettingsActive
                            ? 'text-white'
                            : 'text-slate-400 group-hover:text-white'
                        }}"
                >
                    ⚙
                </span>

                <span>
                    Financial Settings
                </span>
            </a>

        </div>


        {{-- =====================================================
             MANAGEMENT
        ====================================================== --}}

        <div class="pt-6">

            <p class="mb-3 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                Management
            </p>


            {{-- Groups & Departments --}}

            @php
                $groupsActive = request()->routeIs('church.groups.*');
            @endphp

            <a
                href="{{ route('church.groups.index') }}"
                class="group mb-1 flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 transition
                    {{ $groupsActive
                        ? 'bg-purple-600 text-white'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                    }}"
            >
                <svg
                    class="h-5 w-5 shrink-0
                        {{ $groupsActive
                            ? 'text-white'
                            : 'text-slate-400 group-hover:text-white'
                        }}"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 20h5v-2a4 4 0 00-4-4h-1
                           M9 20H4v-2a4 4 0 014-4h1
                           M12 12a4 4 0 100-8 4 4 0 000 8z
                           M17 8a3 3 0 100-6
                           M7 8a3 3 0 110-6"
                    />
                </svg>

                <span class="text-sm font-medium">
                    Groups & Departments
                </span>
            </a>


            {{-- Staff --}}

            <a
                href="#"
                class="mb-1 flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-slate-300 transition hover:bg-slate-800 hover:text-white"
            >
                <span class="w-5 text-center text-sm">
                    ♟
                </span>

                <span class="text-sm font-medium">
                    Staff
                </span>
            </a>


            {{-- Users & Roles --}}

            <a
                href="#"
                class="mb-1 flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-slate-300 transition hover:bg-slate-800 hover:text-white"
            >
                <span class="w-5 text-center text-sm">
                    ♙
                </span>

                <span class="text-sm font-medium">
                    Users & Roles
                </span>
            </a>

        </div>


        {{-- =====================================================
             REPORTS
        ====================================================== --}}

        @php
            $reportsActive = request()->routeIs('church.reports.*');
        @endphp

        <div class="pt-6">

            <p class="mb-3 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                Reports
            </p>

            <a
                href="{{ route('church.reports.index') }}"
                class="group mb-1 flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
                    {{ $reportsActive
                        ? 'bg-purple-600 text-white'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                    }}"
            >
                <span
                    class="w-5 text-center text-sm
                        {{ $reportsActive
                            ? 'text-white'
                            : 'text-slate-400 group-hover:text-white'
                        }}"
                >
                    ▤
                </span>

                <span>
                    Church Reports
                </span>
            </a>

        </div>


        {{-- =====================================================
             SETTINGS
        ====================================================== --}}

        <div class="pt-6">

            <p class="mb-3 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                Settings
            </p>

            <a
                href="#"
                class="mb-1 flex cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-slate-300 transition hover:bg-slate-800 hover:text-white"
            >
                <span class="w-5 text-center text-sm">
                    ⚙
                </span>

                <span class="text-sm font-medium">
                    Church Settings
                </span>
            </a>

        </div>

    </nav>


    {{-- =========================================================
         LOGOUT
    ========================================================== --}}

    <div class="shrink-0 border-t border-slate-800 p-4">

        <form
            method="POST"
            action="{{ route('logout') }}"
        >

            @csrf

            <button
                type="submit"
                class="flex w-full cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-slate-300 transition hover:bg-red-500/10 hover:text-red-400"
            >
                <span class="w-5 text-center text-sm">
                    ↪
                </span>

                <span class="text-sm font-medium">
                    Logout
                </span>
            </button>

        </form>

    </div>

</aside>