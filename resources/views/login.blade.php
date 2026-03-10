@extends('layout.app')

@section('title','Login')

@section('content')

<div style="display: flex;justify-content: center;height: 100vh;align-items: center;">
    <div >
        <div class="judul">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" width="100">
                <h1 class="noto-rashi-hebrew-tulisan">StayHub</h1>
                <p style="font-size: 13px;margin-top: -13px;font-weight: 600;">Smart Booking Management</p>
        </div>

        @if(session('error'))
        <p style="color:red;text-align: center;">{{ session('error') }}</p>
        @endif

        <div class="card">
            <div class="card-body">
                <form method="POST" action="/login">
                    @csrf

                    <label class="form-label">Username</label>
                    <input class="form-control" type="username" name="username" required>
                    <br>
                    <label>Password</label>
                    <input class="form-control" type="password" name="password" required>
                    <br>
                    <button type="submit" class="btn tombole" style="width: 100%;">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection