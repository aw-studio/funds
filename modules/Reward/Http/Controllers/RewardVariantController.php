<?php

namespace Funds\Reward\Http\Controllers;

use Funds\Reward\Models\Reward;
use Funds\Reward\Models\RewardVariant;
use Illuminate\Http\Request;

class RewardVariantController
{
    public function store(Request $request, Reward $reward)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'description' => 'sometimes',
        ]);

        $reward->variants()->create($request->only('name', 'description'));

        flash('Variant created successfully', 'success');

        return redirect()->back();
    }

    public function destroy(Reward $reward, RewardVariant $variant)
    {
        $variant->delete();

        flash('Variant deleted', 'danger');

        return redirect()->back();
    }
}
