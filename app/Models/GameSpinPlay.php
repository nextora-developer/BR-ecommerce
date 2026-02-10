<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameSpinPlay extends Model
{
    protected $fillable = [
        'user_id','reward_id','points_won','ip','user_agent','played_on'
    ];
}
