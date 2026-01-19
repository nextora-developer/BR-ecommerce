<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminAgentController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q'));
        $status = trim((string) $request->get('status'));

        $agents = Agent::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where('agent_code', 'like', "%{$q}%")
                    ->orWhere('name', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%")
                    ->orWhere('region', 'like', "%{$q}%");
            })
            ->when($status !== '', fn($query) => $query->where('status', $status))
            ->orderByDesc('last_updated_at')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.agents.index', compact('agents', 'q', 'status'));
    }

    public function create()
    {
        $lastCode = Agent::orderByDesc('id')->value('agent_code');

        if ($lastCode && preg_match('/AG(\d+)/', $lastCode, $m)) {
            $nextNumber = (int) $m[1] + 1;
        } else {
            $nextNumber = 1;
        }

        $nextAgentCode = 'AG' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        return view('admin.agents.form', [
            'agent' => new Agent([
                'agent_code' => $nextAgentCode,
                'status' => 'active',
            ]),
            'isCreate' => true,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'agent_code' => ['required', 'string', 'unique:agents,agent_code,' . ($agent->id ?? 'NULL')],
            'name'   => ['required', 'string', 'max:255'],
            'phone'  => ['required', 'string', 'max:30'],
            'role'   => ['required', 'string'],
            'region' => ['nullable', 'string'],
            'status' => ['required', 'in:active,suspended,inactive'],
        ]);

        $data['agent_code'] = strtoupper($data['agent_code']);
        $data['last_updated_at'] = now();

        Agent::create($data);

        return redirect()
            ->route('admin.agents.index')
            ->with('success', 'Agent added successfully.');
    }

    public function edit(Agent $agent)
    {
        return view('admin.agents.form', compact('agent'));
    }

    public function update(Request $request, Agent $agent)
    {
        $data = $request->validate([
            'agent_code' => ['required', 'string', 'unique:agents,agent_code,' . ($agent->id ?? 'NULL')],
            'name'   => ['required', 'string', 'max:255'],
            'phone'  => ['required', 'string', 'max:30'],
            'role'   => ['required', 'string'],
            'region' => ['nullable', 'string'],
            'status' => ['required', 'in:active,suspended,inactive'],
        ]);

        $data['agent_code'] = strtoupper($data['agent_code']);

        $agent->update($data); // last_updated_at 会在 Model updating 自动刷新

        return redirect()
            ->route('admin.agents.index')
            ->with('success', 'Agent updated successfully.');
    }

    public function destroy(Agent $agent)
    {
        $agent->delete();

        return back()->with('success', 'Agent deleted.');
    }
}
