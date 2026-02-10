<?php

namespace App\Services;

use App\Models\PointTransaction;
use App\Models\ReferralLog;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PointsService
{
    public function creditReferral(
        User $referrer,
        ReferralLog $log,
        Order $order,
        int $points,
        string $note
    ): bool {
        return DB::transaction(function () use ($referrer, $log, $order, $points, $note) {

            if ($log->rewarded) {
                return false;
            }

            $lockedUser = User::whereKey($referrer->id)
                ->lockForUpdate()
                ->first();

            PointTransaction::create([
                'user_id'         => $lockedUser->id,
                'type'            => 'earn',
                'source'          => 'referral',
                'referral_log_id' => $log->id,
                'order_id'        => $order->id,
                'points'          => $points,
                'note'            => $note,
            ]);

            $lockedUser->increment('points_balance', $points);

            $log->update([
                'rewarded'      => true,
                'reward_type'   => 'points',
                'reward_amount' => $points,
                'order_id'      => $order->id,
            ]);

            return true;
        });
    }

    // public function creditPurchase(
    //     User $buyer,
    //     Order $order,
    //     int $points,
    //     string $note = 'Purchase cashback (RM 1 = 1 point)'
    // ): bool {
    //     return DB::transaction(function () use ($buyer, $order, $points, $note) {

    //         $exists = PointTransaction::where('source', 'purchase')
    //             ->where('order_id', $order->id)
    //             ->where('user_id', $buyer->id)
    //             ->exists();

    //         if ($exists) return false;

    //         $lockedBuyer = User::whereKey($buyer->id)->lockForUpdate()->first();

    //         PointTransaction::create([
    //             'user_id'  => $lockedBuyer->id,
    //             'type'     => 'earn',
    //             'source'   => 'purchase',
    //             'order_id' => $order->id,
    //             'points'   => $points,
    //             'note'     => $note,
    //         ]);

    //         $lockedBuyer->increment('points_balance', $points);

    //         return true;
    //     });
    // }

    public function creditPurchase(
        User $buyer,
        Order $order,
        $pointsOrNote = null,
        ?string $note = null
    ): bool {

        $defaultNote = 'Purchase cashback (RM 1 = 1 point, based on subtotal)';

        // ✅ 永远基于 subtotal
        $points = (int) floor((float) $order->subtotal);
        if ($points <= 0) return false;

        // ✅ 旧调用如果传了数字，直接忽略它（不再用它当 note）
        if (is_numeric($pointsOrNote)) {
            $note = $note ?: $defaultNote;
        } else {
            // 新调用：第三个参数是 note（string）
            $note = (string) ($pointsOrNote ?: ($note ?: $defaultNote));
        }

        return DB::transaction(function () use ($buyer, $order, $points, $note) {

            $exists = PointTransaction::where('source', 'purchase')
                ->where('order_id', $order->id)
                ->where('user_id', $buyer->id)
                ->exists();

            if ($exists) return false;

            $lockedBuyer = User::whereKey($buyer->id)->lockForUpdate()->first();

            PointTransaction::create([
                'user_id'  => $lockedBuyer->id,
                'type'     => 'earn',
                'source'   => 'purchase',
                'order_id' => $order->id,
                'points'   => $points,
                'note'     => $note, // ✅ 不会再出现 40
            ]);

            $lockedBuyer->increment('points_balance', $points);

            return true;
        });
    }



    public static function grantBirthdayPointsIfEligible($user, int $points = 50): bool
    {
        if (!$user || empty($user->birth_date)) return false;

        $today = Carbon::today();
        $bday  = Carbon::parse($user->birth_date);

        // ✅ 生日当天（只比月日）
        if ($today->format('m-d') !== $bday->format('m-d')) {
            return false;
        }

        $year = $today->year;
        $note = "Birthday reward {$year} (+{$points} pts)";

        // ✅ 同一年只能领一次
        $exists = PointTransaction::where('user_id', $user->id)
            ->where('type', 'earn')
            ->where('source', 'birthday')
            ->where('note', $note)
            ->exists();

        if ($exists) return false;

        DB::transaction(function () use ($user, $points, $note) {
            PointTransaction::create([
                'user_id'         => $user->id,
                'type'            => 'earn',
                'source'              => 'birthday',
                'referral_log_id' => null,
                'order_id'        => null,
                'points'          => $points,
                'note'            => $note,
            ]);

            // 如果你有 points_balance 缓存
            if (isset($user->points_balance)) {
                $user->increment('points_balance', $points);
            }
        });

        return true;
    }

    public function creditSpin(User $user, int $points, ?int $spinPlayId = null, ?string $note = null): bool
    {
        if ($points <= 0) return false;
        $note = $note ?: "Spin reward (+{$points} pts)";

        return DB::transaction(function () use ($user, $points, $spinPlayId, $note) {

            if ($spinPlayId) {
                $exists = PointTransaction::where('source', 'spin')
                    ->where('user_id', $user->id)
                    ->where('spin_play_id', $spinPlayId)
                    ->exists();

                if ($exists) return false;
            }

            $lockedUser = User::whereKey($user->id)->lockForUpdate()->first();

            PointTransaction::create([
                'user_id'      => $lockedUser->id,
                'type'         => 'earn',
                'source'       => 'spin',
                'order_id'     => null,
                'spin_play_id' => $spinPlayId,
                'points'       => $points,
                'note'         => $note, // ✅ 给用户看的，不含ID
            ]);

            $lockedUser->increment('points_balance', $points);

            return true;
        });
    }
}
