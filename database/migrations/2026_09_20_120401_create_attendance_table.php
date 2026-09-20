<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();

            $table->foreignId('church_id')
                ->constrained('churches')
                ->cascadeOnDelete();

            $table->foreignId('service_id')
                ->constrained('services')
                ->cascadeOnDelete();

            $table->foreignId('member_id')
                ->constrained('members')
                ->cascadeOnDelete();

            $table->dateTime('checked_in_at')->nullable();
            $table->dateTime('checked_out_at')->nullable();

            $table->string('status', 20)->default('present');

            $table->timestamps();

            // Prevent the same member from being checked in twice
            // for the same service within the same church.
            $table->unique(
                ['church_id', 'service_id', 'member_id'],
                'attendance_unique_member_service'
            );

            $table->index(['church_id', 'service_id']);
            $table->index(['church_id', 'member_id']);
            $table->index(['church_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};