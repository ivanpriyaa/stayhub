<?php

namespace App\Http\Controllers;

use App\Models\Villa;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function katalogall(){
        $villas = Villa::latest()->get();
        return view('landingpage-katalogvilla',compact('villas'));
    }

    public function landingPage() {
    // Ambil 3 villa dengan booking terbanyak
    $bestVillas = Villa::withCount('booking')
                    ->with('mainImage')
                    ->orderByDesc('booking_count')
                    ->limit(3)
                    ->get();

    return view('landingpage-home', compact('bestVillas'));
}
}
