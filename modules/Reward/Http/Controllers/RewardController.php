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

    public function edit(Reward $reward)
    {
        return view('rewards::edit', [
            'reward' => $reward,
        ]);
    }

    public function update(Request $request, Reward $reward)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'min_amount' => 'required|numeric',
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $reward->addMediaFromRequest('image')->toMediaCollection('image');
        }

        $reward->update($validated);

        flash(__('Reward updated.'), 'success');

        return redirect()->back();
    }

    public function destroy(Reward $reward)
    {
        try {
            $reward->delete();
        } catch (\Exception $e) {
            flash(__('Unable to delete reward.'), 'error');

            return redirect()->back();
        }

        flash(__('Reward deleted.'), 'info');

        return redirect()->route('rewards.index');
    }
}
