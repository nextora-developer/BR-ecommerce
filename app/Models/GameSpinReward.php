<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameSpinReward extends Model
{
    protected $fillable = ['name','points','weight','daily_stock','is_active','sort_order'];
}
