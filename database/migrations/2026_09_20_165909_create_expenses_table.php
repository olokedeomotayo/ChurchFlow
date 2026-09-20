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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('church_id')
                ->constrained('churches')
                ->cascadeOnDelete();

            $table->string('category', 100);

            $table->string('description')
                ->nullable();

            $table->decimal('amount', 15, 2);

            $table->date('expense_date');

            $table->string('payment_method', 50)
                ->nullable();

            $table->string('reference', 100)
                ->nullable();

            $table->string('vendor')
                ->nullable();

            $table->text('notes')
                ->nullable();

            $table->foreignId('member_id')
                ->nullable()
                ->constrained('members')
                ->nullOnDelete();

            $table->timestamps();

            $table->index([
                'church_id',
                'expense_date',
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
        Schema::dropIfExists('expenses');
    }
};