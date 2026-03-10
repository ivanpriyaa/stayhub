<?php

namespace App\Http\Controllers;

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
        $credentials = $request->only('username','password');

        if(Auth::attempt($credentials)){
            return redirect()->route('dashboard');
        }

        return back()->with('error','Username atau password salah');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}