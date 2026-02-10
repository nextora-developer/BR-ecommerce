<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\ReferralLog;
use App\Services\PointsService;
use Illuminate\Support\Facades\DB;

class OrderObserver
{
    public function updated(Order $order): void
    {
        if ($order->wasChanged('status') && $order->status === 'completed') {

            DB::transaction(function () use ($order) {
                $fresh = Order::query()->lockForUpdate()->with('user')->find($order->id);
                if (!$fresh) return;

                // 已发过 spin 就不要再发
                if ($fresh->spin_rewarded) return;

                $this->handlePurchasePoints($fresh);
                $this->handleReferralPoints($fresh);
                $this->handleSpinCredit($fresh);

                // 最后才标记，确保上面成功才算完成
                $fresh->update(['spin_rewarded' => true]);
            });
        }
    }

    protected function handleReferralPoints(Order $order): void
    {
        $buyer = $order->user;

        if (!$buyer || !$buyer->referred_by) return;

        $log = ReferralLog::where('referrer_id', $buyer->referred_by)
            ->where('referred_user_id', $buyer->id)
            ->first();

        if (!$log) return;

        // 已奖励过就不跑了（一次性玩法）
        if ($log->rewarded) return;

        // RM 1 = 1 point（向下取整）
        $points = (int) floor($order->total);
        if ($points <= 0) return;

        app(PointsService::class)->creditReferral(
            $buyer->referrer,
            $log,
            $order,
            $points,
            'Referral first order completed (RM 1 = 1 point)'
        );
    }

    protected function handlePurchasePoints(Order $order): void
    {
        $buyer = $order->user;
        if (!$buyer) return;

        // RM1 = 1 point（向下取整）
        $points = (int) floor($order->total);
        if ($points <= 0) return;

        app(PointsService::class)->creditPurchase(
            $buyer,
            $order,
            $points,
            'Purchase cashback (RM 1 = 1 point)'
        );
    }

    protected function handleSpinCredit(Order $order): void
    {
        $buyer = $order->user;
        if (!$buyer) return;

        if (!$buyer->is_verified) return;

        // ✅ 买一次送一次（+1 credit）
        $buyer->increment('spin_credits', 1);
    }
}
