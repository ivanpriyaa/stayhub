@extends('layout.rangka')

@section('title', 'Dashboard - StayHub')

@section('content')

    <div class="judul-capt d-flex justify-content-between align-items-center">
        <h1>PIC</h1>
        <a href="/PIC/tambah_pic" class="btn btn-ae">Tambah PIC</a>
    </div>

    <div class="row mt-4">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="judul-table d-flex justify-content-between align-items-center">
                        <h5>All PIC</h5>
                        <form action="/PIC" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari PIC..." value="{{ request('search') }}">
                                <button class="btn btn-ae" type="submit">
                                    Cari
                                </button>
                                <a href="/PIC" class="btn btn-ae">Reset</a>
                            </div>
                        </form>
                    </div>
                    <br>
                    <div class="table-responsive-md">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="120" style="background-color: #8a76526c;">PIC</th>
                                    <th width="120" style="background-color: #8a76526c;">Nama Agen</th>
                                    <th width="120" style="background-color: #8a76526c;text-align: center;">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($pic as $c)
                                    <tr>
                                        <td>{{ $c->pic }}</td>
                                        <td>{{ $c->nama_agen }}</td>
                                        {{-- <td>{{ $c->password }}</td> --}}
                                        <td style="text-align: center;">
                                            <a href="/PIC/edit_pic/{{ $c->idpic }}" class="btn btn-warning btn-sm mb-2">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <a href="/PIC/delete_pic/{{ $c->idpic }}" class="btn btn-danger btn-sm mb-2">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $pic->appends(request()->query())->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
