<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameSpinReward;
use Illuminate\Http\Request;

class AdminGameSpinRewardController extends Controller
{
    public function index(Request $request)
    {
        $q = GameSpinReward::query();

        if ($request->filled('keyword')) {
            $kw = trim((string) $request->keyword);
            $q->where(function ($x) use ($kw) {
                $x->where('name', 'like', "%{$kw}%")
                    ->orWhere('points', $kw);
            });
        }

        if ($request->has('active') && $request->active !== '') {
            $q->where('is_active', (int) $request->active);
        }

        $rewards = $q->orderBy('sort_order')->get();

        return view('admin.spin-rewards.index', compact('rewards'));
    }


    public function edit(GameSpinReward $spin_reward)
    {
        return view('admin.spin-rewards.edit', ['reward' => $spin_reward]);
    }

    public function update(Request $request, GameSpinReward $spin_reward)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:50'],
            'points'      => ['required', 'integer', 'min:0'],
            'weight'      => ['required', 'integer', 'min:0'],
            'daily_stock' => ['nullable', 'integer', 'min:1'],
            'sort_order'  => ['required', 'integer', 'min:1'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        // checkbox: unchecked won't send -> default false
        $data['is_active'] = (bool) ($request->input('is_active', false));

        // 防炸：至少一个 active reward weight > 0
        // （允许当前 reward weight=0，但总和不能全 0）
        $spin_reward->fill($data);

        $active = GameSpinReward::where('id', '!=', $spin_reward->id)
            ->where('is_active', 1)->sum('weight');

        $totalAfter = $active + ($spin_reward->is_active ? (int)$spin_reward->weight : 0);
        if ($totalAfter <= 0) {
            return back()->withErrors('At least one active reward must have weight > 0.')->withInput();
        }

        $spin_reward->save();

        return redirect()
            ->route('admin.spin-rewards.index')
            ->with('success', 'Spin reward updated.');
    }
}
