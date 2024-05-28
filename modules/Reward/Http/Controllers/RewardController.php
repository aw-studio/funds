<?php

namespace Funds\Reward\Http\Controllers;

use Funds\Reward\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;

class RewardController
{
    public function index()
    {
        return view('rewards::index', [
            'rewards' => Reward::all(),
        ]);
    }

    public function show(Reward $reward)
    {
        return view('rewards::show', [
            'reward' => $reward,
        ]);
    }

    public function create()
    {
        return view('rewards::create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'sometimes|nullable',
            'min_amount' => 'required|numeric',
        ]);

        $reward = new Reward($validated);
        $campaign = Context::get('campaign');

        $reward->campaign = $campaign;
        $reward->save();

        return redirect()->route('rewards.index');
    }
}
