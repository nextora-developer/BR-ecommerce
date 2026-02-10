<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameSpinRewardSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('game_spin_rewards')->delete();
        DB::statement('ALTER TABLE game_spin_rewards AUTO_INCREMENT = 1;');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('game_spin_rewards')->insert([
            ['name' => '0 Points',  'points' => 0,  'weight' => 45, 'daily_stock' => null, 'is_active' => 1, 'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '5 Points',  'points' => 5,  'weight' => 25, 'daily_stock' => null, 'is_active' => 1, 'sort_order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '10 Points', 'points' => 10, 'weight' => 18, 'daily_stock' => 300,  'is_active' => 1, 'sort_order' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '20 Points', 'points' => 20, 'weight' => 10, 'daily_stock' => 100,  'is_active' => 1, 'sort_order' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => '50 Points', 'points' => 50, 'weight' => 2,  'daily_stock' => 20,   'is_active' => 1, 'sort_order' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
