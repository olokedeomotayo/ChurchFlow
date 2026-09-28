<?php

namespace Database\Seeders;

use App\Models\Church;
use App\Models\FinancialAccount;
use App\Models\Group;
use App\Models\Member;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GraceAndMercyDemoSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            /*
            |--------------------------------------------------------------------------
            | Prevent Duplicate Demo Church
            |--------------------------------------------------------------------------
            */

            if (Church::where('name', 'Grace and Mercy Assembly')->exists()) {
                $this->command?->warn(
                    'Grace and Mercy Assembly already exists. Seeder stopped.'
                );

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Church
            |--------------------------------------------------------------------------
            */

            $church = Church::create([
                'code' => 'GMA-DEMO',
                'name' => 'Grace and Mercy Assembly',
                'slug' => 'grace-and-mercy-assembly',
                'email' => 'techcrossbreed@gmail.com',
                'phone' => '08012345678',
                'address' => '25 Grace Avenue, Lagos',
                'city' => 'Lagos',
                'state' => 'Lagos',
                'country' => 'Nigeria',
                'timezone' => 'Africa/Lagos',
                'status' => 'active',
                'trial_started_at' => now()->subMonths(6),
                'trial_ends_at' => now()->addDays(30),
            ]);


            /*
            |--------------------------------------------------------------------------
            | Church Admin
            |--------------------------------------------------------------------------
            */

            $admin = User::create([
                'church_id' => $church->id,
                'name' => 'Grace and Mercy Admin',
                'email' => 'techcrossbreed@gmail.com',
                'password' => Hash::make('1234567890'),
            ]);


            /*
            |--------------------------------------------------------------------------
            | Assign Existing Admin Role
            |--------------------------------------------------------------------------
            */

            if (method_exists($admin, 'assignRole')) {
                $roleNames = [
                    'church-admin',
                    'admin',
                    'church_admin',
                    'super-admin',
                ];

                foreach ($roleNames as $roleName) {
                    if (\Spatie\Permission\Models\Role::where('name', $roleName)->exists()) {
                        $admin->assignRole($roleName);
                        break;
                    }
                }
            }


            /*
            |--------------------------------------------------------------------------
            | Members
            |--------------------------------------------------------------------------
            */

            $members = [
                ['David', 'Adeyemi', 'Oluwaseun', 'M', 'Married'],
                ['Grace', 'Okafor', 'Chidinma', 'F', 'Single'],
                ['Michael', 'Adebayo', 'Emmanuel', 'M', 'Married'],
                ['Esther', 'Eze', 'Ngozi', 'F', 'Single'],
                ['Samuel', 'Ogunleye', 'Daniel', 'M', 'Married'],
                ['Deborah', 'Adekunle', 'Peace', 'F', 'Married'],
                ['Joshua', 'Balogun', 'Femi', 'M', 'Single'],
                ['Mercy', 'Nwosu', 'Ifeoma', 'F', 'Single'],
                ['Joseph', 'Olawale', 'Tobi', 'M', 'Married'],
                ['Ruth', 'Akinyemi', 'Temitope', 'F', 'Married'],
                ['Daniel', 'Okoye', 'Chukwuemeka', 'M', 'Single'],
                ['Hannah', 'Afolabi', 'Oluwatoyin', 'F', 'Single'],
                ['Peter', 'Eze', 'Ikenna', 'M', 'Married'],
                ['Mary', 'Oladipo', 'Funmilayo', 'F', 'Married'],
                ['Paul', 'Adeola', 'Ayomide', 'M', 'Single'],
                ['Elizabeth', 'Ibrahim', 'Zainab', 'F', 'Single'],
                ['John', 'Ojo', 'Oluwafemi', 'M', 'Married'],
                ['Rebecca', 'Oyeniyi', 'Abisola', 'F', 'Married'],
                ['Andrew', 'Ibekwe', 'Chinedu', 'M', 'Single'],
                ['Sarah', 'Bamidele', 'Oluwakemi', 'F', 'Single'],
                ['Timothy', 'Adewale', 'Opeyemi', 'M', 'Married'],
                ['Joy', 'Uche', 'Adaeze', 'F', 'Single'],
                ['Stephen', 'Fashola', 'Kayode', 'M', 'Married'],
                ['Faith', 'Ogunbiyi', 'Oluwadamilola', 'F', 'Single'],
                ['Matthew', 'Onyeka', 'Emeka', 'M', 'Married'],
                ['Naomi', 'Ajayi', 'Folake', 'F', 'Married'],
                ['Isaac', 'Lawal', 'Ridwan', 'M', 'Single'],
                ['Priscilla', 'Ezeani', 'Amaka', 'F', 'Single'],
                ['Benjamin', 'Akinola', 'Oluwatobi', 'M', 'Married'],
                ['Victoria', 'Nwachukwu', 'Chiamaka', 'F', 'Married'],
                ['Caleb', 'Ogunyemi', 'Olamide', 'M', 'Single'],
                ['Lydia', 'Adegbite', 'Yetunde', 'F', 'Single'],
                ['Nathan', 'Ogunleye', 'Ebenezer', 'M', 'Married'],
                ['Comfort', 'Okoro', 'Nneka', 'F', 'Married'],
                ['Emmanuel', 'Ajiboye', 'Oluwasegun', 'M', 'Single'],
                ['Jennifer', 'Eze', 'Chisom', 'F', 'Single'],
                ['Gabriel', 'Akinwande', 'Damilare', 'M', 'Married'],
                ['Blessing', 'Adewusi', 'Oluwatosin', 'F', 'Single'],
                ['Chris', 'Olowu', 'Chukwudi', 'M', 'Single'],
                ['Abigail', 'Adeyinka', 'Folashade', 'F', 'Married'],
                ['Anthony', 'Nnamani', 'Ifeanyi', 'M', 'Married'],
                ['Dorcas', 'Akinyode', 'Oluwatoyin', 'F', 'Single'],
                ['Simon', 'Oladimeji', 'Ayodeji', 'M', 'Single'],
                ['Patience', 'Okeke', 'Ngozi', 'F', 'Married'],
                ['Jonathan', 'Ogunjobi', 'Adebayo', 'M', 'Married'],
                ['Susan', 'Bello', 'Aisha', 'F', 'Single'],
                ['Felix', 'Ogunlade', 'Oluwaseyi', 'M', 'Single'],
                ['Caroline', 'Adepoju', 'Morenike', 'F', 'Married'],
                ['Martin', 'Eze', 'Chibueze', 'M', 'Married'],
                ['Helen', 'Ogunyemi', 'Bukola', 'F', 'Single'],
            ];

            foreach ($members as $index => $memberData) {

                [$firstName, $lastName, $middleName, $gender, $maritalStatus] = $memberData;

                $memberNumber = str_pad(
                    (string) ($index + 1),
                    3,
                    '0',
                    STR_PAD_LEFT
                );

                Member::create([
                    'church_id' => $church->id,
                    'member_id' => 'GMA-' . $memberNumber,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'middle_name' => $middleName,
                    'email' => strtolower(
                        $firstName . '.' . $lastName . $memberNumber . '@gmail.com'
                    ),
                    'phone' => '080' . str_pad(
                        (string) (10000000 + $index),
                        8,
                        '0',
                        STR_PAD_LEFT
                    ),
                    'address' => ($index + 1) . ' Grace Avenue, Lagos',
                    'date_of_birth' => now()
                        ->subYears(22 + ($index % 35))
                        ->subDays($index * 17)
                        ->toDateString(),
                    'gender' => $gender,
                    'marital_status' => $maritalStatus,
                    'joined_at' => now()
                        ->subMonths(1 + ($index % 6))
                        ->subDays($index * 2)
                        ->toDateString(),
                    'membership_status' => 'active',
                    'membership_type' => $index % 5 === 0
                        ? 'youth'
                        : 'member',
                    'emergency_contact_name' => 'Demo Contact ' . $memberNumber,
                    'emergency_contact_phone' => '081' . str_pad(
                        (string) (10000000 + $index),
                        8,
                        '0',
                        STR_PAD_LEFT
                    ),
                    'emergency_contact_relationship' => 'Family',
                    'notes' => 'Grace and Mercy Assembly demo member.',
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Groups
            |--------------------------------------------------------------------------
            */

            $groupDefinitions = [
                ['Choir', 'Music and worship ministry.', 'ministry'],
                ['Ushering Unit', 'Church hospitality and ushering team.', 'ministry'],
                ['Youth Fellowship', 'Youth fellowship and activities.', 'fellowship'],
                ['Men\'s Fellowship', 'Men\'s fellowship and activities.', 'fellowship'],
                ['Women\'s Fellowship', 'Women\'s fellowship and activities.', 'fellowship'],
                ['Media Team', 'Media, technical and communication team.', 'ministry'],
            ];

            foreach ($groupDefinitions as [$name, $description, $type]) {

                Group::create([
                    'church_id' => $church->id,
                    'name' => $name,
                    'description' => $description,
                    'type' => $type,
                    'status' => 'active',
                    'leader_id' => null,
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Financial Accounts
            |--------------------------------------------------------------------------
            */

            $accounts = [
                [
                    'name' => 'Main Bank',
                    'type' => 'bank',
                    'provider_name' => 'Demo Bank',
                    'account_number' => '0123456789',
                    'opening_balance' => 1500000,
                    'opening_balance_date' => '2026-04-01',
                    'currency' => 'NGN',
                    'is_default' => true,
                    'is_active' => true,
                    'notes' => 'Primary church operating account.',
                ],
                [
                    'name' => 'Building Fund',
                    'type' => 'bank',
                    'provider_name' => 'Demo Bank',
                    'account_number' => '9876543210',
                    'opening_balance' => 750000,
                    'opening_balance_date' => '2026-04-01',
                    'currency' => 'NGN',
                    'is_default' => false,
                    'is_active' => true,
                    'notes' => 'Church building and development fund.',
                ],
                [
                    'name' => 'Church Cash',
                    'type' => 'cash',
                    'provider_name' => null,
                    'account_number' => null,
                    'opening_balance' => 150000,
                    'opening_balance_date' => '2026-04-01',
                    'currency' => 'NGN',
                    'is_default' => false,
                    'is_active' => true,
                    'notes' => 'Physical church cash account.',
                ],
                [
                    'name' => 'POS Account',
                    'type' => 'pos',
                    'provider_name' => 'Demo POS',
                    'account_number' => 'POS-001',
                    'opening_balance' => 100000,
                    'opening_balance_date' => '2026-04-01',
                    'currency' => 'NGN',
                    'is_default' => false,
                    'is_active' => true,
                    'notes' => 'POS collections account.',
                ],
            ];

            foreach ($accounts as $account) {
                FinancialAccount::create([
                    'church_id' => $church->id,
                    ...$account,
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Subscription
            |--------------------------------------------------------------------------
            */

            $plan = Plan::find(1);

            if ($plan) {

                Subscription::create([
                    'church_id' => $church->id,
                    'plan_id' => $plan->id,
                    'status' => 'trial',
                    'billing_cycle' => 'monthly',
                    'starts_at' => now()->subMonths(6),
                    'ends_at' => null,
                    'trial_ends_at' => now()->addDays(30),
                    'cancelled_at' => null,
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Output
            |--------------------------------------------------------------------------
            */

            $this->command?->info(
                'Grace and Mercy Assembly demo foundation created successfully.'
            );

            $this->command?->info('Church ID: ' . $church->id);
            $this->command?->info('Admin: techcrossbreed@gmail.com');
            $this->command?->info('Members created: ' . count($members));
            $this->command?->info('Groups created: ' . count($groupDefinitions));
            $this->command?->info('Financial accounts created: 4');
            $this->command?->info(
                'Subscription: ' . ($plan ? 'created' : 'not created - no plan found')
            );

            $this->command?->line('');
            $this->command?->line('Financial Accounts:');
            $this->command?->line('Main Bank — ₦1,500,000');
            $this->command?->line('Building Fund — ₦750,000');
            $this->command?->line('Church Cash — ₦150,000');
            $this->command?->line('POS Account — ₦100,000');
        });
    }
}