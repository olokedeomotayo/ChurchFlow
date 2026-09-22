<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('financial_accounts', function (Blueprint $table) {
            $table->id();

            // Church / tenant ownership
            $table->foreignId('church_id')
                ->constrained('churches')
                ->cascadeOnDelete();

            // Account details
            $table->string('name');
            $table->string('type', 30)->default('bank');

            $table->string('provider_name')->nullable();
            $table->string('account_number')->nullable();

            // Opening position
            $table->decimal('opening_balance', 15, 2)->default(0);
            $table->date('opening_balance_date')->nullable();

            // Account settings
            $table->string('currency', 3)->default('NGN');
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);

            $table->text('notes')->nullable();

            $table->timestamps();

            // Tenant indexes
            $table->index(['church_id', 'is_active']);
            $table->index(['church_id', 'is_default']);

            // Prevent duplicate account names within the same church
            $table->unique(
                ['church_id', 'name'],
                'financial_accounts_church_name_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_accounts');
    }
};