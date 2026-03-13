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
        $query = Booking::with(['villa', 'customer']);
        $tanggal = $request->tgl;


        if ($request->input('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {

                // Cari di tabel villa
                $q->whereHas('villa', function ($villa) use ($search) {
                    $villa->where('nama_villa', 'like', "%$search%")
                        ->orWhere('alamat_villa', 'like', "%$search%");
                })

                    // Cari di tabel customer
                    ->orWhereHas('customer', function ($customer) use ($search) {
                        $customer->where('nama_customer', 'like', "%$search%")
                            ->orWhere('notelp_customer', 'like', "%$search%")
                            ->orWhere('alamat_customer', 'like', "%$search%");
                    });
            });
        }

        if (!empty($tanggal)) {
            $query->whereDate('tglbooking', '=', $tanggal);
        }

        $booking = $query->orderBy('tglbooking', 'desc')->paginate(50);

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
        $total_harga = preg_replace('/[^0-9]/', '', $request->total_harga);
        // dd($request, $total_harga);
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
            'harga' => $request->harga,
            'total_harga' => $total_harga,
            'pic' => $request->pic,
            'nama_agen' => $request->nama_agen,
            'note' => $request->note,
        ]);

        return redirect('/booking')->with('success', 'Booking berhasil disimpan!');
    }
    public function edit_booking($id)
    {
        $booking = Booking::find($id);
        $villa = Villa::orderBy('idvilla', 'asc')->get();

        return view('edit_booking', compact('booking', 'villa'));
    }

    public function update_booking(Request $request, $id)
    {
        $total_harga = preg_replace('/[^0-9]/', '', $request->total_harga);
        // dd($request, $total_harga);

        $request->validate([
            'tglbooking' => 'required|date',
            'idvilla' => 'nullable',
            'nama_customer' => 'required|string|max:255',
            'notelp_customer' => 'required|string|max:20',
            'tglcekin' => 'required',
            'idcustomer' => 'nullable|string|max:255',
            'tglcekout' => 'required|after:tglcekin',
            'note' => 'nullable|string',
            'nama_agen' => 'nullable'
        ]);

        // Cari booking yang akan diedit
        $booking = Booking::where('idbooking', $id)->firstOrFail();

        // Cek apakah customer sudah ada
        $customer = Customer::where('idcustomer', $request->idcustomer)->first();

        if (!$customer) {

            // Generate ID customer baru
            $cr = Customer::latest('idcustomer')->first();

            if ($cr) {
                $ambil = substr($cr->idcustomer, 3);
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
        // Update booking
        $data = [
            'tglbooking' => $request->tglbooking,
            'idcustomer' => $customer->idcustomer,
            'harga' => $request->harga,
            'total_harga' => $total_harga,
            'tglcekin' => $request->tglcekin,
            'tglcekout' => $request->tglcekout,
            'note' => $request->note,
            'pic' => $request->pic,
            'nama_agen' => $request->nama_agen
        ];

        if ($request->idvilla) {
            $data['idvilla'] = $request->idvilla;
        }

        $booking->update($data);

        return redirect('/booking')->with('success', 'Booking berhasil diperbarui!');
    }

    public function destroy_booking($id)
    {
        $booking = Booking::find($id);
        $booking->delete();

        return redirect('/booking');
    }
}
