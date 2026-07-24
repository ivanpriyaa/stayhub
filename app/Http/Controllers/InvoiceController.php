<?php

namespace App\Http\Controllers;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show($nomor_invoice)
    {
        $invoice = Invoice::with(['booking.customer', 'booking.villa'])
            ->where('nomor_invoice', $nomor_invoice)
            ->firstOrFail();

        return view('invoice.show', compact('invoice'));
    }

    public function print($nomor_invoice)
    {
        $invoice = Invoice::with(['booking.customer', 'booking.villa'])
            ->where('nomor_invoice', $nomor_invoice)
            ->firstOrFail();

        return view('invoice', compact('invoice'));
    }
}
