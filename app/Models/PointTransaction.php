<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'source',
        'referral_log_id',
        'order_id',
        'points',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function referralLog()
    {
        return $this->belongsTo(ReferralLog::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
