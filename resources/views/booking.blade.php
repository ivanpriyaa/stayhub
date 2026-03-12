@extends('layout.rangka')

@section('title', 'Booking - StayHub')

@section('content')
<div class="judul-capt d-flex justify-content-between align-items-center">
    <h1>Booking</h1>
    <a href="/booking/tambah_booking" class="btn btn-ae">Tambah Booking</a>
</div>

<div class="row mt-4">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="judul-table d-flex justify-content-between align-items-center">
                    <h5>All Booking</h5>
                    <form action="/booking" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari villa..." value="{{ request('search') }}">
                            <button class="btn btn-ae" type="submit">
                                Cari
                            </button>
                            <a href="/booking" class="btn btn-ae">Reset</a>
                        </div>
                    </form>
                </div>
                <br>
                <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="120" style="background-color: #8a76526c;">Nama</th>
                                <th width="120" style="background-color: #8a76526c;">Alamat</th>
                                <th width="120" style="background-color: #8a76526c;text-align: center;">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($booking as $b)
                            <tr>
                                <td>{{ $b->nama_villa }}</td>
                                <td>{{ $b->alamat_villa }}</td>
                                <td style="text-align: center;">
                                    <a href="/villa/edit_villa/{{ $b->idbooking }}" class="btn btn-warning btn-sm mb-2">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <a href="/villa/delete_villa/{{ $b->idbooking }}" class="btn btn-danger btn-sm mb-2">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $booking->appends(request()->query())->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection