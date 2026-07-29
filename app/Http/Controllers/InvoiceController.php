<?php

namespace App\Http\Controllers;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    public function print($nomor_invoice)
    {
        $invoice = Invoice::with(['booking.customer', 'booking.villa'])
            ->where('idbooking', $nomor_invoice)
            ->latest('id')
            ->firstOrFail();

        return view('invoice', compact('invoice'));
    }
}
