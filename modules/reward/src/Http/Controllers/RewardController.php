<?php

namespace Funds\Reward\Http\Controllers;

use Funds\Reward\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Str;

class RewardController
{
    public function index()
    {
        return view('rewards::index', [
            'rewards' => Reward::query()
                ->where('campaign_id', Context::get('campaign')->id)
                ->withCount('variants')
                ->get(),
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

        $baseSlug = Str::slug($validated['name']);
        $validated['slug'] = $baseSlug;

        // Ensure slug is unique
        $counter = 1;
        while (Reward::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $reward = new Reward($validated);
        $campaign = Context::get('campaign');

        $reward->campaign = $campaign;
        $reward->save();

        return redirect()->route('rewards.edit', $reward);
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
            'shipping_type' => 'nullable|string',
            'packaging_instructions' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'expected_delivery' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $baseSlug = Str::slug($validated['name']);
        $validated['slug'] = $baseSlug;

        // Ensure slug is unique
        $counter = 1;
        while (Reward::where('slug', $validated['slug'])->where('id', '!=', $reward->id)->exists()) {
            $validated['slug'] = "{$baseSlug}-{$counter}";
            $counter++;
        }

        if ($request->input('image_delete')) {
            $reward->clearMediaCollection('image');
        }

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $reward->addMediaFromRequest('image')->toMediaCollection('image');
        }

        $reward->update([
            ...$validated,
            'is_active' => $request->boolean('is_active'),
        ]);

        flash(__('Reward updated.'), 'success');

        return redirect()->back();
    }

    public function destroy(Reward $reward)
    {
        try {
            $reward->delete();
        } catch (\Exception) {
            flash(__('Unable to delete reward.'), 'error');

            return redirect()->back();
        }

        flash(__('Reward deleted.'), 'info');

        return redirect()->route('rewards.index');
    }
}
