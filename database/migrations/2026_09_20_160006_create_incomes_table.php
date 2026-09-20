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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('church_id')
                ->constrained('churches')
                ->cascadeOnDelete();

            $table->string('category');
            $table->string('source')->nullable();

            $table->decimal('amount', 15, 2);

            $table->date('income_date');

            $table->string('payment_method')->nullable();

            $table->string('reference')->nullable();

            $table->text('description')->nullable();

            $table->foreignId('member_id')
                ->nullable()
                ->constrained('members')
                ->nullOnDelete();

            $table->timestamps();

            $table->index([
                'church_id',
                'income_date',
            ]);

            $table->index([
                'church_id',
                'category',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};