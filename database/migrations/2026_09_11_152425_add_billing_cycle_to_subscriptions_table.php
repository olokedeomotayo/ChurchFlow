<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('billing_cycle', 20)
                ->default('monthly')
                ->after('status');

            $table->index('billing_cycle');
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropIndex(['billing_cycle']);
            $table->dropColumn('billing_cycle');
        });
    }
};