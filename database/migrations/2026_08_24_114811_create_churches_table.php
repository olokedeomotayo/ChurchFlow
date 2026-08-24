<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('churches', function (Blueprint $table) {
            $table->id();

            // Church identity
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->string('slug')->unique();

            // Contact information
            $table->string('email')->nullable();
            $table->string('phone', 30)->nullable();
            $table->text('address')->nullable();

            // Location
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country', 100)->default('Nigeria');
            $table->string('timezone', 100)->default('Africa/Lagos');

            // Church lifecycle
            $table->string('status', 20)->default('active');

            // Trial information
            $table->timestamp('trial_started_at')->nullable();
            $table->timestamp('trial_ends_at')->nullable();

            // Laravel timestamps
            $table->timestamps();

            // Soft deletion
            $table->softDeletes();

            // Frequently queried fields
            $table->index('status');
            $table->index('trial_ends_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('churches');
    }
};