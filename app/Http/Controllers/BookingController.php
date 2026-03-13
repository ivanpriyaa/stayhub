<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Villa;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function booking(Request $request)
    {
        $search = $request->search;

        $search = $request->search;

        $booking = Booking::join('villa', 'booking.idvilla', '=', 'villa.idvilla')
            ->when($search, function ($query, $search) {
                return $query->where('villa.nama_villa', 'like', "%$search%")
                    ->orWhere('villa.alamat_villa', 'like', "%$search%");
            })
            ->select('booking.*', 'villa.nama_villa', 'villa.alamat_villa')
            ->paginate(10);

        return view('booking', compact('booking'));
    }

    public function tambah_booking()
    {
        $customer = Customer::orderBy('idcustomer', 'asc')->get();
        $villa = Villa::orderBy('idvilla', 'asc')->get();

        return view('tambah_booking', compact('customer', 'villa'));
    }

    public function search(Request $request)
    {
        $term = $request->get('term');

        $customers = Customer::where('nama_customer', 'like', '%' . $term . '%')
            ->limit(10)
            ->get(['idcustomer', 'nama_customer', 'notelp_customer']);  // kolom sesuai database

        $result = [];
        foreach ($customers as $c) {
            $result[] = [
                'id' => $c->idcustomer,          // untuk hidden input
                'label' => $c->nama_customer,
                'value' => $c->nama_customer,
                'no_hp' => $c->notelp_customer, // ini key yang nanti dipakai di JS
            ];
        }

        return response()->json($result);
    }

    public function store(Request $request)
    {

        // dd($request);
        $request->validate([
            'tglbooking' => 'required|date',
            'idvilla' => 'required',
            'nama_customer' => 'required|string|max:255',
            'notelp_customer' => 'required|string|max:20',
            'tglcekin' => 'required',
            'idcustomer' => 'nullable|string|max:255',
            'tglcekout' => 'required|after:tglcekin',
            'note' => 'nullable|string',
        ]);

        // Cek apakah customer sudah ada
        $customer = Customer::where('idcustomer', $request->idcustomer)->first();
        $booking = Booking::where('idcustomer', $request->idbooking)->first();

        // dd($customer);
        if (!$customer) {
            // Buat ID customer otomatis (misal format CUS0001)
            $cr = Customer::latest('idcustomer')->first();
            if ($cr) {
                $ambil = substr($cr->idcustomer, 3); // ambil angka setelah CUS
                $nomor = (int) $ambil + 1;
            } else {
                $nomor = 1;
            }
            $kode = 'CUS' . str_pad($nomor, 4, "0", STR_PAD_LEFT);

            // Simpan customer baru
            $customer = Customer::create([
                'idcustomer' => $kode,
                'nama_customer' => $request->nama_customer,
                'notelp_customer' => $request->notelp_customer,
            ]);
        }

        $book = Booking::latest('idbooking')->first();

        if (!$book) {
            $code = 'BOK0001';
        } else {

            $get = substr($book->idbooking, 3);
            $no = (int) $get + 1;

            $code = 'BOK' . str_pad($no, 4, "0", STR_PAD_LEFT);
        }

        // Simpan booking
        Booking::create([
            'idbooking' => $code,
            'tglbooking' => $request->tglbooking,
            'idvilla' => $request->idvilla,
            'idcustomer' => $customer->idcustomer,
            'tglcekin' => $request->tglcekin,
            'tglcekout' => $request->tglcekout,
            'pic' => "hmm", // sesuaikan jika ada field pic
            'note' => $request->note,
        ]);

        return redirect('/booking')->with('success', 'Booking berhasil disimpan!');
    }
}
