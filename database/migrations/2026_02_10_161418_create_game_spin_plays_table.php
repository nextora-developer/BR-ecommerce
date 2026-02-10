<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('game_spin_plays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reward_id')->nullable()->constrained('game_spin_rewards')->nullOnDelete();

            $table->unsignedInteger('points_won')->default(0);
            $table->string('ip')->nullable();
            $table->string('user_agent', 255)->nullable();

            $table->date('played_on'); // 用于每日限制
            $table->timestamps();

            $table->index(['user_id', 'played_on']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_spin_plays');
    }
};
