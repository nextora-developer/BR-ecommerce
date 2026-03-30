<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_open_amount')->default(false)->after('has_variants');
            $table->decimal('min_amount', 10, 2)->nullable()->after('is_open_amount');
            $table->decimal('max_amount', 10, 2)->nullable()->after('min_amount');
            $table->decimal('amount_step', 10, 2)->nullable()->after('max_amount');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'is_open_amount',
                'min_amount',
                'max_amount',
                'amount_step',
            ]);
        });
    }
};
