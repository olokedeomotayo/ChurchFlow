<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            $table->foreignId('church_id')
                ->constrained('churches')
                ->cascadeOnDelete();

            $table->string('name');
            $table->text('description')->nullable();

            $table->date('service_date');

            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->string('status', 20)->default('scheduled');

            $table->timestamps();

            $table->index(['church_id', 'service_date']);
            $table->index(['church_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};