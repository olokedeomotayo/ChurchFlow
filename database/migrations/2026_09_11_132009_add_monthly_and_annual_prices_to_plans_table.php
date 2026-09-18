<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {

            $table->decimal('monthly_price', 15, 2)
                ->default(0)
                ->after('description');

            $table->decimal('annual_price', 15, 2)
                ->default(0)
                ->after('monthly_price');

        });
    }

    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {

            $table->dropColumn([
                'monthly_price',
                'annual_price',
            ]);

        });
    }
};