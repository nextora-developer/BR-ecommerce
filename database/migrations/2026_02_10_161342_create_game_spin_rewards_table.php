<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('game_spin_rewards', function (Blueprint $table) {
            $table->id();
            $table->string('name');                // e.g. "10 Points"
            $table->unsignedInteger('points');     // 模拟 points
            $table->unsignedInteger('weight');     // 权重（越大越容易中）
            $table->unsignedInteger('daily_stock')->nullable(); // 每日库存（可选）
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_spin_rewards');
    }
};
