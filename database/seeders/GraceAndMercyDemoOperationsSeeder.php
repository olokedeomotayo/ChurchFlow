<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Church;
use App\Models\Expense;
use App\Models\FinancialAccount;
use App\Models\Income;
use App\Models\Member;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class GraceAndMercyDemoOperationsSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $church = Church::where('name', 'Grace and Mercy Assembly')->first();

            if (! $church) {
                $this->command->error(
                    'Grace and Mercy Assembly was not found. Run GraceAndMercyDemoSeeder first.'
                );

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Prevent accidental duplication
            |--------------------------------------------------------------------------
            */

            if (
                Service::where('church_id', $church->id)->exists()
                || Income::where('church_id', $church->id)->exists()
                || Expense::where('church_id', $church->id)->exists()
            ) {
                $this->command->warn(
                    'Operational demo data already exists for Grace and Mercy Assembly.'
                );

                $this->command->warn(
                    'No new operational records were created.'
                );

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Financial Accounts
            |--------------------------------------------------------------------------
            */

            $accounts = FinancialAccount::where('church_id', $church->id)
                ->get()
                ->keyBy('name');

            $mainBank = $accounts->get('Main Bank');
            $buildingFund = $accounts->get('Building Fund');
            $churchCash = $accounts->get('Church Cash');
            $posAccount = $accounts->get('POS Account');

            if (! $mainBank || ! $buildingFund || ! $churchCash || ! $posAccount) {
                $this->command->error(
                    'The four demo financial accounts were not found.'
                );

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Members
            |--------------------------------------------------------------------------
            */

            $members = Member::where('church_id', $church->id)
                ->where('membership_status', 'active')
                ->get();

            if ($members->isEmpty()) {
                $this->command->error(
                    'No active members were found for Grace and Mercy Assembly.'
                );

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Demo Period
            |--------------------------------------------------------------------------
            |
            | Six months:
            | April 2026 - September 2026
            |
            */

            $startDate = Carbon::create(2026, 4, 1);
            $endDate = Carbon::create(2026, 9, 30);

            /*
            |--------------------------------------------------------------------------
            | SERVICES
            |--------------------------------------------------------------------------
            |
            | Weekly:
            | - Sunday Worship Service
            | - Wednesday Bible Study
            |
            */

            $serviceRecords = [];

            for (
                $date = $startDate->copy();
                $date->lte($endDate);
                $date->addDay()
            ) {
                /*
                |--------------------------------------------------------------------------
                | Sunday Worship Service
                |--------------------------------------------------------------------------
                */

                if ($date->dayOfWeek === Carbon::SUNDAY) {
                    $serviceRecords[] = Service::create([
                        'church_id' => $church->id,
                        'name' => 'Sunday Worship Service',
                        'description' => 'Main Sunday worship and fellowship service.',
                        'service_date' => $date->toDateString(),
                        'start_time' => '08:00',
                        'end_time' => '11:00',
                        'status' => 'completed',
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Wednesday Bible Study
                |--------------------------------------------------------------------------
                */

                if ($date->dayOfWeek === Carbon::WEDNESDAY) {
                    $serviceRecords[] = Service::create([
                        'church_id' => $church->id,
                        'name' => 'Wednesday Bible Study',
                        'description' => 'Midweek Bible study and discipleship service.',
                        'service_date' => $date->toDateString(),
                        'start_time' => '17:30',
                        'end_time' => '19:30',
                        'status' => 'completed',
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | ATTENDANCE
            |--------------------------------------------------------------------------
            |
            | Attendance numbers vary slightly from service to service to make
            | the demo data look realistic.
            |--------------------------------------------------------------------------
            */

            foreach ($serviceRecords as $index => $service) {
                $isSunday = $service->name === 'Sunday Worship Service';

                if ($isSunday) {
                    $men = 75 + (($index * 7) % 36);
                    $women = 95 + (($index * 9) % 46);
                    $teenagers = 28 + (($index * 5) % 21);
                    $children = 32 + (($index * 6) % 24);
                    $guests = 5 + (($index * 3) % 11);
                } else {
                    $men = 38 + (($index * 4) % 20);
                    $women = 48 + (($index * 5) % 22);
                    $teenagers = 14 + (($index * 3) % 12);
                    $children = 16 + (($index * 2) % 10);
                    $guests = 2 + (($index * 2) % 6);
                }

                Attendance::create([
                    'church_id' => $church->id,
                    'service_id' => $service->id,
                    'attendance_date' => $service->service_date,
                    'men' => $men,
                    'women' => $women,
                    'teenagers' => $teenagers,
                    'children' => $children,
                    'guests' => $guests,
                    'notes' => $isSunday
                        ? 'Regular Sunday attendance record.'
                        : 'Regular midweek attendance record.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | INCOME
            |--------------------------------------------------------------------------
            |
            | Three income categories:
            | - Offerings
            | - Tithe
            | - Donations
            |--------------------------------------------------------------------------
            */

            $incomeCounter = 1;

            for (
                $month = $startDate->copy()->startOfMonth();
                $month->lte($endDate);
                $month->addMonth()
            ) {
                /*
                |--------------------------------------------------------------------------
                | Offerings
                |--------------------------------------------------------------------------
                */

                for ($week = 0; $week < 4; $week++) {
                    $incomeDate = $month->copy()->addDays(
                        min(6 + ($week * 7), $month->daysInMonth - 1)
                    );

                    Income::create([
                        'church_id' => $church->id,
                        'category' => 'Offerings',
                        'source' => 'Sunday Worship Service',
                        'amount' => 145000 + ($week * 17500) + (($month->month - 4) * 5000),
                        'income_date' => $incomeDate->toDateString(),
                        'payment_method' => $week % 3 === 0
                            ? 'Cash'
                            : ($week % 3 === 1 ? 'Bank Transfer' : 'POS'),
                        'reference' => 'GMA-OFF-' . str_pad($incomeCounter++, 4, '0', STR_PAD_LEFT),
                        'description' => 'Sunday worship offering.',
                        'member_id' => $members->random()->id,
                        'financial_account_id' => $week % 3 === 0
                            ? $churchCash->id
                            : ($week % 3 === 1 ? $mainBank->id : $posAccount->id),
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Tithes
                |--------------------------------------------------------------------------
                */

                for ($week = 0; $week < 4; $week++) {
                    $incomeDate = $month->copy()->addDays(
                        min(8 + ($week * 6), $month->daysInMonth - 1)
                    );

                    Income::create([
                        'church_id' => $church->id,
                        'category' => 'Tithe',
                        'source' => 'Members',
                        'amount' => 210000 + ($week * 22500) + (($month->month - 4) * 7500),
                        'income_date' => $incomeDate->toDateString(),
                        'payment_method' => $week % 2 === 0
                            ? 'Bank Transfer'
                            : 'Cash',
                        'reference' => 'GMA-TIT-' . str_pad($incomeCounter++, 4, '0', STR_PAD_LEFT),
                        'description' => 'Members tithe contribution.',
                        'member_id' => $members->random()->id,
                        'financial_account_id' => $week % 2 === 0
                            ? $mainBank->id
                            : $churchCash->id,
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Donations
                |--------------------------------------------------------------------------
                */

                Income::create([
                    'church_id' => $church->id,
                    'category' => 'Donations',
                    'source' => 'Members and Friends',
                    'amount' => 180000 + (($month->month - 4) * 30000),
                    'income_date' => $month->copy()->addDays(18)->toDateString(),
                    'payment_method' => 'Bank Transfer',
                    'reference' => 'GMA-DON-' . str_pad($incomeCounter++, 4, '0', STR_PAD_LEFT),
                    'description' => 'General church donation.',
                    'member_id' => $members->random()->id,
                    'financial_account_id' => $mainBank->id,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Building Fund Donation
                |--------------------------------------------------------------------------
                */

                Income::create([
                    'church_id' => $church->id,
                    'category' => 'Donations',
                    'source' => 'Building Fund',
                    'amount' => 75000 + (($month->month - 4) * 15000),
                    'income_date' => $month->copy()->addDays(24)->toDateString(),
                    'payment_method' => 'Bank Transfer',
                    'reference' => 'GMA-BLD-' . str_pad($incomeCounter++, 4, '0', STR_PAD_LEFT),
                    'description' => 'Building fund donation.',
                    'member_id' => $members->random()->id,
                    'financial_account_id' => $buildingFund->id,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | EXPENSES
            |--------------------------------------------------------------------------
            |
            | Categories:
            | PHCN, Waste, Petrol, Diesel, Salary, Church Dues, Welfare
            |--------------------------------------------------------------------------
            */

            $expenseCounter = 1;

            for (
                $month = $startDate->copy()->startOfMonth();
                $month->lte($endDate);
                $month->addMonth()
            ) {
                $monthNumber = $month->month - 4;

                /*
                |--------------------------------------------------------------------------
                | PHCN
                |--------------------------------------------------------------------------
                */

                Expense::create([
                    'church_id' => $church->id,
                    'category' => 'PHCN',
                    'description' => 'Monthly electricity bill.',
                    'amount' => 85000 + ($monthNumber * 5000),
                    'expense_date' => $month->copy()->addDays(4)->toDateString(),
                    'payment_method' => 'Bank Transfer',
                    'reference' => 'GMA-EXP-' . str_pad($expenseCounter++, 4, '0', STR_PAD_LEFT),
                    'vendor' => 'Ikeja Electric / PHCN',
                    'notes' => 'Monthly electricity expense.',
                    'member_id' => null,
                    'financial_account_id' => $mainBank->id,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Waste
                |--------------------------------------------------------------------------
                */

                Expense::create([
                    'church_id' => $church->id,
                    'category' => 'Waste',
                    'description' => 'Monthly waste collection.',
                    'amount' => 25000 + ($monthNumber * 1500),
                    'expense_date' => $month->copy()->addDays(6)->toDateString(),
                    'payment_method' => 'Cash',
                    'reference' => 'GMA-EXP-' . str_pad($expenseCounter++, 4, '0', STR_PAD_LEFT),
                    'vendor' => 'Lagos Waste Management',
                    'notes' => 'Monthly church waste management.',
                    'member_id' => null,
                    'financial_account_id' => $churchCash->id,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Petrol
                |--------------------------------------------------------------------------
                */

                Expense::create([
                    'church_id' => $church->id,
                    'category' => 'Petrol',
                    'description' => 'Petrol for church generator and vehicles.',
                    'amount' => 60000 + ($monthNumber * 4000),
                    'expense_date' => $month->copy()->addDays(9)->toDateString(),
                    'payment_method' => 'POS',
                    'reference' => 'GMA-EXP-' . str_pad($expenseCounter++, 4, '0', STR_PAD_LEFT),
                    'vendor' => 'Local Fuel Station',
                    'notes' => 'Monthly petrol purchase.',
                    'member_id' => null,
                    'financial_account_id' => $posAccount->id,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Diesel
                |--------------------------------------------------------------------------
                */

                Expense::create([
                    'church_id' => $church->id,
                    'category' => 'Diesel',
                    'description' => 'Diesel for church generator.',
                    'amount' => 95000 + ($monthNumber * 6000),
                    'expense_date' => $month->copy()->addDays(12)->toDateString(),
                    'payment_method' => 'Bank Transfer',
                    'reference' => 'GMA-EXP-' . str_pad($expenseCounter++, 4, '0', STR_PAD_LEFT),
                    'vendor' => 'Church Fuel Supplier',
                    'notes' => 'Diesel supply for power generation.',
                    'member_id' => null,
                    'financial_account_id' => $mainBank->id,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Salary
                |--------------------------------------------------------------------------
                */

                Expense::create([
                    'church_id' => $church->id,
                    'category' => 'Salary',
                    'description' => 'Monthly staff salary payment.',
                    'amount' => 350000 + ($monthNumber * 10000),
                    'expense_date' => $month->copy()->addDays(24)->toDateString(),
                    'payment_method' => 'Bank Transfer',
                    'reference' => 'GMA-SAL-' . str_pad($expenseCounter++, 4, '0', STR_PAD_LEFT),
                    'vendor' => 'Grace and Mercy Assembly Payroll',
                    'notes' => 'Monthly staff payroll.',
                    'member_id' => null,
                    'financial_account_id' => $mainBank->id,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Church Dues
                |--------------------------------------------------------------------------
                */

                Expense::create([
                    'church_id' => $church->id,
                    'category' => 'Church Dues',
                    'description' => 'Denominational and association dues.',
                    'amount' => 45000 + ($monthNumber * 2500),
                    'expense_date' => $month->copy()->addDays(20)->toDateString(),
                    'payment_method' => 'Bank Transfer',
                    'reference' => 'GMA-DUE-' . str_pad($expenseCounter++, 4, '0', STR_PAD_LEFT),
                    'vendor' => 'Church Association',
                    'notes' => 'Monthly church dues.',
                    'member_id' => null,
                    'financial_account_id' => $mainBank->id,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Welfare
                |--------------------------------------------------------------------------
                */

                Expense::create([
                    'church_id' => $church->id,
                    'category' => 'Welfare',
                    'description' => 'Member welfare support.',
                    'amount' => 70000 + ($monthNumber * 5000),
                    'expense_date' => $month->copy()->addDays(26)->toDateString(),
                    'payment_method' => 'Cash',
                    'reference' => 'GMA-WEL-' . str_pad($expenseCounter++, 4, '0', STR_PAD_LEFT),
                    'vendor' => 'Church Welfare Ministry',
                    'notes' => 'Welfare support for church members.',
                    'member_id' => $members->random()->id,
                    'financial_account_id' => $churchCash->id,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Additional Building Fund Expense
            |--------------------------------------------------------------------------
            */

            Expense::create([
                'church_id' => $church->id,
                'category' => 'Welfare',
                'description' => 'Building maintenance and support expense.',
                'amount' => 125000,
                'expense_date' => '2026-07-15',
                'payment_method' => 'Bank Transfer',
                'reference' => 'GMA-BLD-EXP-001',
                'vendor' => 'Building Maintenance Contractor',
                'notes' => 'Maintenance expense related to church building.',
                'member_id' => null,
                'financial_account_id' => $buildingFund->id,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Summary
            |--------------------------------------------------------------------------
            */

            $this->command->info(
                'Grace and Mercy Assembly operational demo data created successfully.'
            );

            $this->command->info(
                'Services created: ' . Service::where('church_id', $church->id)->count()
            );

            $this->command->info(
                'Attendance records created: ' . Attendance::where('church_id', $church->id)->count()
            );

            $this->command->info(
                'Income records created: ' . Income::where('church_id', $church->id)->count()
            );

            $this->command->info(
                'Expense records created: ' . Expense::where('church_id', $church->id)->count()
            );

            $this->command->info(
                'Demo period: April 2026 - September 2026'
            );
        });
    }
}