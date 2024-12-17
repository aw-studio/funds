<?php

namespace Funds\Order\Http\Controllers;

use Funds\Donation\Models\Donation;
use Funds\Order\Models\Order;
use Illuminate\Http\Request;

class OrderController
{
    public function edit(Request $request, Order $order)
    {
        return view('order::edit', [
            'order' => $order,
            'rewards' => $order->donation->campaign->rewards()->with('variants')->get(),
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'reward' => 'required|numeric',
            'reward_variant' => 'sometimes|numeric',
            'note' => 'sometimes|nullable|string',
        ]);

        $order->note = $request->note;
        $order->reward_id = $request->reward;

        if ($request->reward_variant) {
            $order->reward_variant_id = $request->reward_variant;
        }

        $order->save();

        flash('Order updated successfully');

        return redirect()->back();
    }

    public function create(Request $request)
    {
        if ($request->donation) {
            $donation = Donation::find($request->donation);
            if (! $donation) {
                flash('Donation not found', 'error');

                return redirect()->back();
            }
        }

        $rewards = $donation->campaign->rewards()->with('variants')->get();

        return view('order::create', [
            'rewards' => $rewards,
            'donationId' => $request->donation,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'donation_id' => 'required|numeric',
            'reward' => 'required|numeric',
            'reward_variant' => 'sometimes|numeric',
            'note' => 'sometimes|nullable|string',
            'name' => 'required|string',
            'street' => 'required|string',
            'address_addition' => 'nullable|string',
            'postal_code' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
        ]);

        $donation = Donation::findOrFail($request->donation_id);

        if ($donation->order) {
            flash('Donation already has an order');

            return redirect()->back();
        }

        $order = new Order;
        $order->note = $request->note;
        $order->reward_id = $request->reward;
        $order->donation_id = $request->donation_id;
        $order->campaign_id = $donation->campaign_id;

        if ($request->reward_variant) {
            $order->reward_variant_id = $request->reward_variant;
        }

        $order->shipping_address = [
            'name' => request('name'),
            'street' => request('street'),
            'address_addition' => request('address_addition'),
            'postal_code' => request('postal_code'),
            'city' => request('city'),
            'country' => request('country'),
        ];

        $order->save();

        flash('Order created successfully');

        return redirect()->route('donation.show', $donation);
    }
}
