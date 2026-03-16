<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Facades\Http;

class DashboardControllers extends Controller
{
    public function dashboard()
    {
        $booking = Booking::count();

        $events = Booking::with('villa')->get()->map(function ($b) {
            return [
                'title' => optional($b->villa)->nama_villa . ' - ' . optional($b->customer)->nama_customer,
                'start' => $b->tglcekin,
                'end' => $b->tglcekout,
                'color' => '#8A7650'
            ];
        });

        return view('dashboard', compact('booking','events'));
    }
}