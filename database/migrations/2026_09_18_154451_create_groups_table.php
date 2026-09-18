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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();

            // Tenant / Church
            $table->foreignId('church_id')
                ->constrained('churches')
                ->cascadeOnDelete();

            // Group information
            $table->string('name');
            $table->text('description')->nullable();

            // group or department
            $table->string('type', 20)->default('group');

            // active or inactive
            $table->string('status', 20)->default('active');

            // Optional group leader
            $table->foreignId('leader_id')
                ->nullable()
                ->constrained('members')
                ->nullOnDelete();

            $table->timestamps();

            // Indexes
            $table->index(['church_id', 'type']);
            $table->index(['church_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};