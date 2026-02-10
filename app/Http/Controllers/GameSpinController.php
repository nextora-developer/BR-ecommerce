<?php

namespace App\Http\Controllers;

use App\Models\GameSpinPlay;
use App\Models\GameSpinReward;
use App\Services\PointsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameSpinController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // 前端显示用：只拿 active 的奖项（顺序）
        $rewards = GameSpinReward::where('is_active', true)
            ->orderBy('sort_order')
            ->get(['id', 'name', 'points']);

        // ✅ credits 模式：不再用 dailyLimit / remaining
        $credits = (int) ($user->spin_credits ?? 0);

        return view('games.spin', compact('rewards', 'credits'));
    }

    public function play(Request $request)
    {
        $user = $request->user();
        $today = now()->toDateString();

        // ✅ 1) 必须 Verified（按你系统字段改这里）
        if (!($user->is_verified ?? false)) {
            return response()->json([
                'ok' => false,
                'message' => 'Account not verified. Please verify first.',
            ], 403);
        }

        // ✅ 2) 必须有 spin credits（买一次 +1）
        if (($user->spin_credits ?? 0) <= 0) {
            return response()->json([
                'ok' => false,
                'message' => 'No spins available. Complete a purchase to earn a spin.',
            ], 403);
        }

        $result = DB::transaction(function () use ($request, $user, $today) {

            // 锁住 user，确保 credits 不会被并发扣成负数
            $u = $user->newQuery()->lockForUpdate()->find($user->id);

            if (!$u || !($u->is_verified ?? false)) {
                return ['ok' => false, 'message' => 'Account not verified.'];
            }

            if (($u->spin_credits ?? 0) <= 0) {
                return ['ok' => false, 'message' => 'No spins available.'];
            }

            // ✅ 扣 1 次
            $u->decrement('spin_credits', 1);

            // ====== 抽奖逻辑（保留） ======
            $rewards = GameSpinReward::where('is_active', true)->lockForUpdate()->get();

            if ($rewards->isEmpty()) {
                throw new \RuntimeException('Rewards not configured.');
            }

            $filtered = $rewards->filter(function ($r) use ($today) {
                if (is_null($r->daily_stock)) return true;

                $wonToday = GameSpinPlay::where('reward_id', $r->id)
                    ->where('played_on', $today)
                    ->count();

                return $wonToday < $r->daily_stock;
            })->values();

            $picked = $filtered->isEmpty()
                ? $rewards->sortBy('points')->first()
                : $this->weightedPick($filtered);

            // ✅ 记录 play
            $play = GameSpinPlay::create([
                'user_id' => $u->id,
                'reward_id' => $picked->id ?? null,
                'points_won' => (int) ($picked->points ?? 0),
                'ip' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 255),
                'played_on' => $today,
            ]);

            // ✅ 把 points 真正入账（写 point_transactions + points_balance）
            $wonPoints = (int) ($picked->points ?? 0);
            if ($wonPoints > 0) {
                app(PointsService::class)->creditSpin(
                    $u,
                    $wonPoints,
                    $play->id,
                    "Spin reward ({$picked->name}) (+{$wonPoints} pts)"
                );
            }

            // ✅ 给前端落点 index（sort_order 顺序）
            $orderedIds = GameSpinReward::where('is_active', true)
                ->orderBy('sort_order')
                ->pluck('id')
                ->map(fn($id) => (int)$id)
                ->values();

            $landingIndex = $orderedIds->search(fn($id) => $id === (int)$picked->id);
            $landingIndex = ($landingIndex === false) ? 0 : (int)$landingIndex;


            // refresh user 最新 credits / points_balance
            $u->refresh();

            return [
                'ok' => true,
                'reward' => [
                    'id' => $picked->id,
                    'name' => $picked->name,
                    'points' => (int) $picked->points,
                ],
                'landing_index' => $landingIndex, // ✅ 唯一可信
                'credits_left' => (int) $u->fresh()->spin_credits,
            ];
        });

        if (!($result['ok'] ?? false)) {
            return response()->json($result, 400);
        }

        return response()->json($result);
    }

    private function weightedPick($collection)
    {
        $total = $collection->sum('weight');
        $rand = random_int(1, max(1, $total));

        $running = 0;
        foreach ($collection as $item) {
            $running += (int) $item->weight;
            if ($rand <= $running) return $item;
        }
        return $collection->last();
    }
}
