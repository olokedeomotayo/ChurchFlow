<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::updateOrCreate(
            ['slug' => 'free-trial'],
            [
                'name' => 'Free Trial',
                'description' => '30-day free trial for newly onboarded churches.',
                'price' => 0.00,
                'billing_cycle' => 'monthly',
                'member_limit' => null,
                'is_active' => true,
            ]
        );
    }
}