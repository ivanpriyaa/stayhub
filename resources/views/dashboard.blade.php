@extends('layout.rangka')

@section('title', 'Dashboard - StayHub')

@section('content')
    <h1>Dashboard</h1>

    <div class="row mt-4">
        <div class="col-md-4 mb-2">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title inria-sans-bold" style="display: flex;justify-content: space-between;">Total Booking<span style="color: #8A7650;"><i class="bi bi-cash-stack"></i></span></h5>
                    <p class="card-text" style="font-size: 30px;font-weight: 700;">{{ $booking }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title inria-sans-bold" style="display: flex;justify-content: space-between;">Card title<span style="color: #8A7650;"><i class="bi bi-cash-stack"></i></span></h5>
                    <p class="card-text" style="font-size: 30px;font-weight: 700;">Rp 1jt</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title inria-sans-bold" style="display: flex;justify-content: space-between;">Card title<span style="color: #8A7650;"><i class="bi bi-cash-stack"></i></span></h5>
                    <p class="card-text" style="font-size: 30px;font-weight: 700;">Rp 1jt</p>
                </div>
            </div>
        </div>
    </div>

@endsection
