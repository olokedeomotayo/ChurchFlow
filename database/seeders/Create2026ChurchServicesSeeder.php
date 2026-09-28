<?php

namespace Database\Seeders;

use App\Models\Church;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class Create2026ChurchServicesSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Configuration
        |--------------------------------------------------------------------------
        */

        $churchId = 11;

        $startDate = Carbon::create(2026, 1, 1);
        $endDate = Carbon::create(2026, 12, 31);
        $today = Carbon::today();

        /*
        |--------------------------------------------------------------------------
        | Verify Church
        |--------------------------------------------------------------------------
        */

        $church = Church::find($churchId);

        if (! $church) {
            $this->command->error(
                "Church with ID {$churchId} was not found."
            );

            return;
        }

        $created = 0;
        $skipped = 0;

        /*
        |--------------------------------------------------------------------------
        | Create Services
        |--------------------------------------------------------------------------
        */

        for (
            $date = $startDate->copy();
            $date->lte($endDate);
            $date->addDay()
        ) {
            /*
            |--------------------------------------------------------------------------
            | Determine Service
            |--------------------------------------------------------------------------
            */

            $serviceName = null;
            $description = null;
            $startTime = null;
            $endTime = null;

            // Tuesday - Bible Study
            if ($date->dayOfWeek === Carbon::TUESDAY) {
                $serviceName = 'Bible Study';
                $description = 'Weekly Bible Study and discipleship service.';
                $startTime = '18:00';
                $endTime = '19:30';
            }

            // Sunday - Celebration Service
            elseif ($date->dayOfWeek === Carbon::SUNDAY) {
                $serviceName = 'Celebration Service';
                $description = 'Weekly Sunday Celebration Service.';
                $startTime = '08:00';
                $endTime = '11:00';
            }

            /*
            |--------------------------------------------------------------------------
            | Skip Other Days
            |--------------------------------------------------------------------------
            */

            if (! $serviceName) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Determine Status
            |--------------------------------------------------------------------------
            */

            $status = $date->lte($today)
                ? 'completed'
                : 'scheduled';

            /*
            |--------------------------------------------------------------------------
            | Prevent Duplicates
            |--------------------------------------------------------------------------
            */

            $exists = Service::where('church_id', $churchId)
                ->whereDate('service_date', $date->toDateString())
                ->where('name', $serviceName)
                ->exists();

            if ($exists) {
                $skipped++;

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Create Service
            |--------------------------------------------------------------------------
            */

            Service::create([
                'church_id' => $churchId,
                'name' => $serviceName,
                'description' => $description,
                'service_date' => $date->toDateString(),
                'start_time' => $startTime,
                'end_time' => $endTime,
                'status' => $status,
            ]);

            $created++;
        }

        /*
        |--------------------------------------------------------------------------
        | Summary
        |--------------------------------------------------------------------------
        */

        $this->command->info(
            "Church: {$church->name} (ID: {$churchId})"
        );

        $this->command->info(
            "Services created: {$created}"
        );

        $this->command->info(
            "Existing services skipped: {$skipped}"
        );

        $this->command->info(
            "Completed through: {$today->format('d M Y')}"
        );

        $this->command->info(
            "Future services scheduled through: 31 Dec 2026"
        );
    }
}