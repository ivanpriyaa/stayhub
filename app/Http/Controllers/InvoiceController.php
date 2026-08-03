<?php

namespace App\Http\Controllers;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    public function print($nomor_invoice)
    {
        $invoice = Invoice::with(['booking.customer', 'booking.villa', 'booking.invoices'])
            ->where('idbooking', $nomor_invoice)
            // ->latest('id')
            ->firstOrFail();
        $invoices = Invoice::where('idbooking', $nomor_invoice)
        ->orderBy('created_at', 'asc')
        ->get();

        return view('invoice', compact('invoice', 'invoices'));
    }
}
