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

        if (!$log || $log->rewarded) return;

        app(PointsService::class)->creditReferral(
            $buyer->referrer,
            $log,
            $order,
            'Referral first order completed'
        );
    }

    protected function handlePurchasePoints(Order $order): void
    {
        $buyer = $order->user;
        if (!$buyer) return;

        app(PointsService::class)->creditPurchase(
            $buyer,
            $order,
            'Product reward points'
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
