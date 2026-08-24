<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();

            // Plan identity
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();

            // Pricing
            $table->decimal('price', 15, 2)->default(0);
            $table->string('billing_cycle', 20)->default('monthly');

            // Usage limits
            $table->unsignedInteger('member_limit')->nullable();

            // Plan availability
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Frequently queried fields
            $table->index('is_active');
            $table->index('billing_cycle');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};