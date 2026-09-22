<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendance', function (Blueprint $table) {
            $table->dropForeign(['member_id']);

            $table->dropUnique(
                'attendance_unique_member_service'
            );

            $table->dropIndex(
                ['church_id', 'member_id']
            );

            $table->dropColumn([
                'member_id',
                'checked_in_at',
                'checked_out_at',
                'status',
            ]);

            $table->date('attendance_date')
                ->after('service_id');

            $table->unsignedInteger('men')
                ->default(0)
                ->after('attendance_date');

            $table->unsignedInteger('women')
                ->default(0)
                ->after('men');

            $table->unsignedInteger('teenagers')
                ->default(0)
                ->after('women');

            $table->unsignedInteger('children')
                ->default(0)
                ->after('teenagers');

            $table->unsignedInteger('guests')
                ->default(0)
                ->after('children');

            $table->text('notes')
                ->nullable()
                ->after('guests');

            $table->unique(
                [
                    'church_id',
                    'service_id',
                    'attendance_date',
                ],
                'attendance_unique_church_service_date'
            );

            $table->index([
                'church_id',
                'attendance_date',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('attendance', function (Blueprint $table) {
            $table->dropUnique(
                'attendance_unique_church_service_date'
            );

            $table->dropIndex([
                'church_id',
                'attendance_date',
            ]);

            $table->dropColumn([
                'attendance_date',
                'men',
                'women',
                'teenagers',
                'children',
                'guests',
                'notes',
            ]);

            $table->foreignId('member_id')
                ->constrained('members')
                ->cascadeOnDelete();

            $table->dateTime('checked_in_at')
                ->nullable();

            $table->dateTime('checked_out_at')
                ->nullable();

            $table->string('status', 20)
                ->default('present');

            $table->unique(
                [
                    'church_id',
                    'service_id',
                    'member_id',
                ],
                'attendance_unique_member_service'
            );

            $table->index([
                'church_id',
                'member_id',
            ]);

            $table->index([
                'church_id',
                'status',
            ]);
        });
    }
};