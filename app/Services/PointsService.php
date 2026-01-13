<?php

namespace App\Services;

use App\Models\PointTransaction;
use App\Models\ReferralLog;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PointsService
{

    public function creditReferralByOrder(User $referrer, ReferralLog $log, \App\Models\Order $order, int $points, string $note): bool
    {
        return DB::transaction(function () use ($referrer, $log, $order, $points, $note) {

            // ✅ 防重复：同一张订单只发一次
            $exists = PointTransaction::where('source', 'referral')
                ->where('order_id', $order->id)
                ->exists();

            if ($exists) return false;

            $lockedUser = User::whereKey($referrer->id)->lockForUpdate()->first();

            PointTransaction::create([
                'user_id' => $lockedUser->id,
                'type' => 'earn',
                'source' => 'referral',
                'referral_log_id' => $log->id,
                'order_id' => $order->id,   // ✅ 关键：以后每笔都带 order_id
                'points' => $points,
                'note' => $note,
            ]);

            $lockedUser->increment('points_balance', $points);

            return true;
        });
    }
}
