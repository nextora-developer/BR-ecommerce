<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('point_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // earn / spend / adjust
            $table->string('type', 20);

            // referral / order / admin / etc
            $table->string('source', 30)->nullable();

            // 关联来源（可选）
            $table->foreignId('referral_log_id')->nullable()->constrained('referral_logs')->nullOnDelete();
            $table->foreignId('order_id')->nullable()->constrained('orders')->nullOnDelete();

            // 正数记录（spend 也记录正数，方向用 type 控制）
            $table->unsignedBigInteger('points');

            // 备注
            $table->string('note')->nullable();

            $table->timestamps();

            // 防重复发：同一个 referral_log 只发一次
            $table->unique(['source', 'referral_log_id'], 'ptx_unique_source_referral');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('point_transactions');
    }
};
