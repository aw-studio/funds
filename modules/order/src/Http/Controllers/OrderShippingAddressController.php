<?php

namespace Funds\Order\Http\Controllers;

use Funds\Order\Models\Order;
use Illuminate\Http\Request;

class OrderShippingAddressController
{
    public function edit(Order $order)
    {
        return view('order::shipping-address.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'name' => 'required|string',
            'street' => 'required|string',
            'address_addition' => 'nullable|string',
            'postal_code' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
        ]);

        $order->shipping_address = [
            'name' => request('name'),
            'street' => request('street'),
            'address_addition' => request('address_addition'),
            'postal_code' => request('postal_code'),
            'city' => request('city'),
            'country' => request('country'),
        ];
        $order->save();

        return redirect()->route('donations.show', $order->donation_id);
    }
}
