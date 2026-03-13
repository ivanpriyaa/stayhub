@extends('layout.rangka')

@section('title', 'Villa - StayHub')

@section('content')
    <div class="judul-capt d-flex justify-content-between align-items-center">
        <h1>Villa</h1>
        <a href="/villa/tambah_villa" class="btn btn-ae">Tambah Villa</a>
    </div>

    <div class="row mt-4">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="judul-table d-flex justify-content-between align-items-center">
                        <h5>All Villa</h5>
                        <form action="/villa" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari villa..." value="{{ request('search') }}">
                                <button class="btn btn-ae" type="submit">
                                    Cari
                                </button>
                                <a href="/villa" class="btn btn-ae">Reset</a>
                            </div>
                        </form>
                    </div>
                    <br>
                    <div class="table-responsive-md">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="120" style="background-color: #8a76526c;">Nama</th>
                                    <th width="120" style="background-color: #8a76526c;">Harga</th>
                                    <th width="120" style="background-color: #8a76526c;">Alamat</th>
                                    <th width="120" style="background-color: #8a76526c;text-align: center;">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($villa as $v)
                                    <tr>
                                        <td>{{ $v->nama_villa }}</td>
                                        <td>Rp. {{ number_format($v->harga_villa, 0, '.', '.') }}</td>
                                        <td>{{ $v->alamat_villa }}</td>
                                        <td style="text-align: center;">
                                            <a href="/villa/edit_villa/{{ $v->idvilla }}" class="btn btn-warning btn-sm mb-2">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $villa->appends(request()->query())->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
