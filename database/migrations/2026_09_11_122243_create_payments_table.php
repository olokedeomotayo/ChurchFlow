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
        Schema::create('payments', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relationships
            |--------------------------------------------------------------------------
            */

            $table->foreignId('church_id')
                ->constrained('churches')
                ->cascadeOnDelete();

            $table->foreignId('subscription_id')
                ->nullable()
                ->constrained('subscriptions')
                ->nullOnDelete();

            $table->foreignId('plan_id')
                ->nullable()
                ->constrained('plans')
                ->nullOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Payment Identification
            |--------------------------------------------------------------------------
            */

            $table->string('reference')->unique();

            $table->string('gateway')
                ->default('paystack');

            $table->string('gateway_transaction_id')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Payment Details
            |--------------------------------------------------------------------------
            */

            $table->decimal('amount', 15, 2);

            $table->string('currency', 10)
                ->default('NGN');

            $table->string('status', 30)
                ->default('pending');

            $table->string('payment_method')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Payment Dates
            |--------------------------------------------------------------------------
            */

            $table->timestamp('paid_at')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Gateway Response / Metadata
            |--------------------------------------------------------------------------
            */

            $table->json('gateway_response')
                ->nullable();

            $table->json('metadata')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('church_id');
            $table->index('subscription_id');
            $table->index('plan_id');
            $table->index('status');
            $table->index('gateway');
            $table->index('paid_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};