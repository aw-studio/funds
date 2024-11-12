<?php

namespace Funds\Donation\Http\Controllers;

use Funds\Donation\Models\Donor;
use Illuminate\Http\Request;

class DonorController
{
    public function edit(Donor $donor)
    {
        if (request()->has('previous')) {
            session(['previous' => request('previous')]);
        }

        return view('donation::donor.edit', [
            'donor' => $donor,
            'cancelRoute' => request()->has('previous') ? request('previous') : route('donations.index'),
        ]);
    }

    public function update(Request $request, Donor $donor)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        $donor->name = $request->name;
        $donor->email = $request->email;
        $donor->save();

        flash('Donor updated', 'success');

        if ($previous = session('previous')) {
            session()->forget('previous');

            return redirect($previous);
        }

        return redirect()->back();
    }
}
