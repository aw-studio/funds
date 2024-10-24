<?php

namespace Funds\Donation\Http\Controllers;

use Funds\Donation\Models\Donation;
use Illuminate\Http\Request;

class DonationReceiptAddressController
{
    public function edit(Request $request, Donation $donation)
    {
        return view('donation::receipt-address.edit', [
            'donation' => $donation,
        ]);
    }

    public function update(Request $request, Donation $donation)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'postal_code' => 'required|string',
            'city' => 'required|string',
            'country' => 'required|string',
        ]);

        $donation->receipt_address = [
            'name' => $request->name,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'city' => $request->city,
            'country' => $request->country,
        ];
        $donation->save();

        flash('Donation receipt address updated');

        return redirect()->route('donations.show', $donation);
    }
}
