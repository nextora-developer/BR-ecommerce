<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
        'agent_code',
        'name',
        'phone',
        'region',
        'role',
        'status',
        'last_updated_at',
    ];

    protected $casts = [
        'last_updated_at' => 'datetime',
    ];

    protected static function booted()
    {
        // 任何更新都刷新 last_updated_at（对应你列表的 Last Updated）
        static::updating(function ($agent) {
            $agent->last_updated_at = now();
        });
    }

    // 统一 status 显示用（可选）
    public function getStatusLabelAttribute(): string
    {
        return ucfirst((string) $this->status);
    }
}
