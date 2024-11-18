<?php

namespace Funds\Donation\Http\Controllers;

use Funds\Donation\Models\Donation;
use Illuminate\Http\Request;

class DonationReceiptController
{
    public function __invoke(Request $request, Donation $donation)
    {
        $pdf = $donation->receiptPdf();

        return $pdf->stream('donation-receipt.pdf');
    }
}
