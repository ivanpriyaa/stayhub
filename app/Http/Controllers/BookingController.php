<?php

namespace App\Http\Controllers;

use App\Models\Booking;
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

    public function tambah_booking() {
        return view('tambah_booking');
    }
}
