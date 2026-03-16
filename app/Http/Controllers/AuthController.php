<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Username atau password salah');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function dashboard()
    {
        $booking = Booking::count();

        $events = Booking::with('villa')->get()->map(function ($b) {
            return [
                'title' => optional($b->villa)->nama_villa ?? 'Villa',
                'start' => $b->tglcekin,
                'end' => $b->tglcekout,
                'color' => '#8A7650'
            ];
        });

        return view('dashboard', compact('booking','events'));
    }
}
