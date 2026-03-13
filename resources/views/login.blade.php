@extends('layout.app')

@section('title', 'Login')

@section('content')
<div class="logine">

    <!-- LEFT IMAGE -->
    <div class="col-md-6 login-image">
        <img src="{{ asset('images/room.jpg') }}" alt="">
    </div>

    <!-- LOGIN FORM -->
    <div class="col-md-6 formlogin" style="margin: auto;">
        <div class="kotake">
            <div class="judul">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" width="100">
                <h1 class="noto-rashi-hebrew-tulisan">StayHub</h1>
                <p style="font-size: 13px;margin-top: -13px;font-weight: 600;">Smart Booking Management</p>
            </div>

            @if (session('error'))
            <p style="color:red;text-align: center;">{{ session('error') }}</p>
            @endif

            <form method="POST" action="/login">
                @csrf
                <div class="mb-3">
                    <div class="login__field">
                        <i class="login__icon bi bi-person-fill" style="left: 21px;"></i>
                        <input type="text" class="login__input form-cont" placeholder="Username" name="username" required style="text-decoration: none" autocomplete="off">
                    </div>
                    <div class="login__field">
                        <i class="login__icon bi bi-lock-fill" style="left: 21px;"></i>
                        <input type="password" id="password" class="login__input" class="form-control" placeholder="Password" name="password">
                        <span class="login__icon" onclick="togglePassword()" style="cursor:pointer; display: flex; justify-content: end; right: 22px;">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </span>

                    </div>
                </div>

                <button type="submit" class="btn tombole w-100" style="border-radius: 25px;">
                    Login
                </button>
            </form>
        </div>
    </div>
</div>
{{-- <div style="display: flex;justify-content: center;height: 100vh;align-items: center;">
        <div>
            <div class="judul">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" width="100">
<h1 class="noto-rashi-hebrew-tulisan">StayHub</h1>
<p style="font-size: 13px;margin-top: -13px;font-weight: 600;">Smart Booking Management</p>
</div>

@if (session('error'))
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
            <div class="input-group">
                <input class="form-control" type="password" name="password" id="password" required>
                <span class="input-group-text" onclick="togglePassword()" style="cursor:pointer;">
                    <i class="bi bi-eye" id="toggleIcon"></i>
                </span>
            </div>
            <br>
            <button type="submit" class="btn tombole" style="width: 100%;">Login</button>
        </form>
    </div>
</div>
</div>
</div> --}}

<script>
    function togglePassword() {
        const password = document.getElementById("password");
        const icon = document.getElementById("toggleIcon");

        if (password.type === "password") {
            password.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        } else {
            password.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }
    }
</script>
@endsection