@extends('layout.app')

@section('title', 'Login')

@push('styles')
    <style>
        .login-image {
            height: 100vh;
            overflow: hidden;
        }

        .login-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .login__field {
            padding: 5px 10px;
            position: relative;
        }

        .login__icon {
            position: absolute;
            top: 18px;
            left: 21px;
            color: #D4A245;
        }

        .login__input {
            border-radius: 10px;
            border: 2px solid #D4A245;
            background: none;
            padding: 10px;
            padding-left: 35px;
            font-weight: 700;
            width: 100%;
            transition: .2s;
            outline: none;
        }

        .login__input::placeholder {
            color: #3d3d3d;
            font-weight: 400;
        }


        .btn-login {
            background: #c8a86b;
            border: none;
            color: white;
        }

        .btn-login:hover {
            background: #b9985b;
        }

        .input-group-text {
            background-color: transparent !important;
            border: none !important;
        }

        .text-muted {
            color: #815910 !important;
        }

        .container-fluid {
            padding: 0 !important;
        }

        /* DESKTOP / LAPTOP */
        @media (min-width: 770px) {

            body {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: flex-end;
                /* padding-right: 80px; */
                background: #f5f5f5;
            }

            .title {
                font-size: 60px;
            }

            .container {
                padding: 0 80px;
            }

            .sub {
                margin-top: -22px !important;
                font-size: 20px;
            }

            /* .card {
                                                                                                                                                                        display: none;
                                                                                                                                                                    } */

        }

        @media (max-width: 650px) {

            body {
                display: flex;
                align-items: end;
                justify-content: center;
                min-height: 100vh;
                padding: 20px;
                background-image: url('{{ asset('images/room.jpg') }}');
                background-size: contain;
                background-position: top;
                /* background-position: center; */
                background-repeat: no-repeat;
            }

            /* sembunyikan gambar kiri */
            .login-image {
                display: none !important;
            }

            .login-container {
                width: 100%;
                max-width: 420px;
                margin: auto;
            }

            .container {
                background: white;
                padding: 30px;
                border-radius: 15px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
                max-width: 400px;
                width: 100%;
            }



        }
    </style>
@endpush

@section('content')
    <div class="">
        <div class="row g-0">

            <!-- LEFT IMAGE -->
            <div class="col-md-6 login-image d-none d-md-block">
                <img src="{{ asset('images/room.jpg') }}" alt="">
            </div>

            <!-- LOGIN FORM -->
            <div class="col-md-6 container" style="margin: auto;">

                <div class="judul">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" width="100">
                    <h1 class="noto-rashi-hebrew-tulisan">StayHub</h1>
                    <p style="font-size: 13px;margin-top: -13px;font-weight: 600;">Smart Booking Management</p>
                </div>

                @if (session('error'))
                    <p style="color:red;text-align: center;">{{ session('error') }}</p>
                @endif

                <h3 class="title" style="font-family: 'EB Garamond', serif;">Welcome Back</h3>
                <p class="sub fw-semibold" style="margin-top: -13px;">Login to Aura Management Suite</p>

                <form method="POST" action="/login">
                    @csrf
                    <div class="mb-3">
                        <div class="login__field">
                            <i class="login__icon bi bi-person-fill"></i>
                            <input type="text" class="login__input" placeholder="Username" name="username" required style="text-decoration: none" autocomplete="off">
                        </div>
                        <div class="login__field">
                            <i class="login__icon bi bi-lock-fill"></i>
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
