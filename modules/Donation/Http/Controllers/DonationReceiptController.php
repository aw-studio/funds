<?php

namespace Funds\Donation\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Funds\Donation\Models\Donation;
use Illuminate\Http\Request;

class DonationReceiptController
{
    public function __invoke(Request $request, Donation $donation)
    {
        $pdf = Pdf::loadView('donations::pdf.donation-receipt', [
            'donation' => $donation,
        ]);

        return $pdf->stream('donation-receipt.pdf');
    }
}
