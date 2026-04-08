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
}
