<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Villa;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardControllers extends Controller
{
    public function dashboard()
    {
        // $booking = Booking::count();
        // $booking = Booking::where('created_at', '>=', Carbon::now()->subDays(7))->count();
        $booking = Booking::whereBetween('tglcekin', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();

        $weeklyRevenue = Booking::whereBetween('tglcekin', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->sum('total_harga');

        $totalVilla = Villa::count();

        $daysInWeek = 7;

        $totalCapacity = $totalVilla * $daysInWeek;

        $bookedDays = Booking::whereBetween('tglcekin', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();

        $occupancyRate = $totalCapacity > 0
            ? round(($bookedDays / $totalCapacity) * 100)
            : 0;

        // DATA EVENT CALENDAR
        $events = Booking::with('villa', 'customer')->get()->map(function ($b) {
            return [
                'title' => optional($b->villa)->nama_villa . ' - ' . optional($b->customer)->nama_customer,
                'start' => $b->tglcekin,
                'end' => $b->tglcekout,
                'pic' => $b->pic == 'agen' ? $b->nama_pic : $b->pic,
                'villa' => optional($b->villa)->nama_villa,
                'color' => '#8A7650'
            ];
        });

        // =========================
        // DATA GRAFIK 7 HARI
        // =========================

        $weekBookings = Booking::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('COUNT(*) as total')
        )
            ->where('created_at', '>=', Carbon::now()->subDays(6))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = Carbon::now()->subDays($i)->format('Y-m-d');

            $labels[] = Carbon::now()->subDays($i)->translatedFormat('D');

            $found = $weekBookings->firstWhere('tanggal', $date);

            $data[] = $found ? $found->total : 0;
        }

        // =========================
        // DATA GRAFIK REVENUE 7 HARI
        // =========================

        $weekRevenue = Booking::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('SUM(total_harga) as total')
        )
            ->where('created_at', '>=', Carbon::now()->subDays(6))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $revenueData = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = Carbon::now()->subDays($i)->format('Y-m-d');

            $found = $weekRevenue->firstWhere('tanggal', $date);

            $revenueData[] = $found ? $found->total : 0;
        }

        // =========================
        // DATA GRAFIK OCCUPANCY 7 HARI
        // =========================

        $totalVilla = Villa::count();

        $occupancyData = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = Carbon::now()->subDays($i)->format('Y-m-d');

            $booked = Booking::whereDate('tglcekin', $date)->count();

            $rate = $totalVilla > 0 ? round(($booked / $totalVilla) * 100) : 0;

            $occupancyData[] = $rate;
        }

        $villae = Villa::all();

        return view('dashboard', compact(
            'booking',
            'weeklyRevenue',
            'events',
            'villae',
            'labels',
            'data',
            'revenueData',
            'occupancyRate',
            'occupancyData'
        ));
    }
}
