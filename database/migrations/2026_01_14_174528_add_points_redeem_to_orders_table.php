<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('points_redeem')
                ->default(0)
                ->after('voucher_discount');

            $table->decimal('points_discount', 10, 2)
                ->default(0)
                ->after('points_redeem');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['points_redeem', 'points_discount']);
        });
    }
};
