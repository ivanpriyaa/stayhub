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
                                <input type="text" name="search" class="form-control" placeholder="Cari villa/Customer..." value="{{ request('search') }}">
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
                                    <th width="120" style="background-color: #8a76526c;">Tanggal Booking</th>
                                    <th width="120" style="background-color: #8a76526c;">PIC</th>
                                    <th width="120" style="background-color: #8a76526c;"> Villa</th>
                                    <th width="120" style="background-color: #8a76526c;"> Customer</th>
                                    <th width="120" style="background-color: #8a76526c;"> Check-In</th>
                                    <th width="120" style="background-color: #8a76526c;"> Check-Out</th>
                                    <th width="120" style="background-color: #8a76526c;"> Harga</th>
                                    <th width="120" style="background-color: #8a76526c;text-align: center;">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($booking as $b)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($b->tglbooking)->translatedFormat('d F Y') }}</td>
                                        <td>{{ $b->pic }}
                                            @if ($b->pic == 'Agen')
                                                - {{ $b->nama_agen }}
                                            @endif
                                        </td>
                                        <td>{{ $b->villa->nama_villa }}</td>
                                        <td>{{ $b->customer->nama_customer }}</td>
                                        <td>{{ \Carbon\Carbon::parse($b->tglcekin)->translatedFormat('d F Y H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($b->tglcekout)->translatedFormat('d F Y H:i') }}</td>
                                        <td>Rp. {{ number_format($b->total_harga, 0, '.', '.') }}</td>
                                        <td style="text-align: center;">
                                            <a href="/booking/edit_booking/{{ $b->idbooking }}" class="btn btn-warning btn-sm mb-2">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <a href="/booking/delete_booking/{{ $b->idbooking }}" class="btn btn-danger btn-sm mb-2">
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
