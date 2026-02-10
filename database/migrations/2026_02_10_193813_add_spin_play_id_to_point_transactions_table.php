<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('point_transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('spin_play_id')->nullable()->index()->after('order_item_id');
            // 可选：更强防重复（同用户+同play只能一次）
            $table->unique(['user_id', 'source', 'spin_play_id'], 'ptx_spin_unique');
        });
    }

    public function down(): void
    {
        Schema::table('point_transactions', function (Blueprint $table) {
            $table->dropUnique('ptx_spin_unique');
            $table->dropColumn('spin_play_id');
        });
    }
};
