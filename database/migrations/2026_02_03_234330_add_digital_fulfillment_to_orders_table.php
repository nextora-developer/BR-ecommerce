<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->json('pin_codes')->nullable()->after('tracking_number');
            $table->text('fulfillment_note')->nullable()->after('pin_codes');
            $table->dateTime('digital_fulfilled_at')->nullable()->after('fulfillment_note');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['pin_codes', 'fulfillment_note', 'digital_fulfilled_at']);
        });
    }
};
