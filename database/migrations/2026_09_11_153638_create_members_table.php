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
        Schema::create('members', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Church
            |--------------------------------------------------------------------------
            */

            $table->foreignId('church_id')
                ->constrained('churches')
                ->restrictOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Member Identity
            |--------------------------------------------------------------------------
            */

            $table->string('member_id')->unique();

            $table->string('first_name');

            $table->string('last_name');

            $table->string('middle_name')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Contact Information
            |--------------------------------------------------------------------------
            */

            $table->string('email')->nullable();

            $table->string('phone')->nullable();

            $table->text('address')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Personal Information
            |--------------------------------------------------------------------------
            */

            $table->date('date_of_birth')->nullable();

            $table->string('gender', 20)->nullable();

            $table->string('marital_status', 30)->nullable();


            /*
            |--------------------------------------------------------------------------
            | Church Information
            |--------------------------------------------------------------------------
            */

            $table->date('joined_at')->nullable();

            $table->string('membership_status', 30)
                ->default('active');

            $table->string('membership_type', 30)
                ->default('member');


            /*
            |--------------------------------------------------------------------------
            | Emergency Contact
            |--------------------------------------------------------------------------
            */

            $table->string('emergency_contact_name')->nullable();

            $table->string('emergency_contact_phone')->nullable();

            $table->string('emergency_contact_relationship')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Additional Information
            |--------------------------------------------------------------------------
            */

            $table->text('notes')->nullable();


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

            $table->index([
                'church_id',
                'membership_status',
            ]);

            $table->index('phone');

            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};