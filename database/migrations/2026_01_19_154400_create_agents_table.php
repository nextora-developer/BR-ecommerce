<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();

            // AG0005 这种
            $table->string('agent_code', 20)->unique();

            $table->string('name', 255);
            $table->string('phone', 30)->index();    
            $table->string('region', 100)->nullable(); 
            $table->string('role', 50)->default('Agent');

            $table->string('status', 30)->default('active')->index();

            $table->timestamp('last_updated_at')->nullable()->index();

            $table->timestamps(); // created_at, updated_at

            // 可选：如果你想“删除=隐藏”而不是硬删
            // $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
