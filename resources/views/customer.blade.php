@extends('layout.rangka')

@section('title', 'Customer - StayHub')

@section('content')
<div class="judul-capt d-flex justify-content-between align-items-center">
    <h1>Customer</h1>
    <a href="/customer/tambah_customer" class="btn btn-ae">Tambah Customer</a>
</div>

<div class="row mt-4">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="judul-table d-flex justify-content-between align-items-center">
                    <h5>All Customer</h5>
                    <form action="/customer" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari customer..." value="{{ request('search') }}">
                            <button class="btn btn-ae" type="submit">
                                Cari
                            </button>
                        </div>
                    </form>
                </div>
                <br>
                <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="120" style="background-color: #8a76526c;">Nama</th>
                                <th width="120" style="background-color: #8a76526c;">Telepon</th>
                                <th width="120" style="background-color: #8a76526c;">Alamat</th>
                                <th width="120" style="background-color: #8a76526c;text-align: center;">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($customer as $c)
                            <tr>
                                <td>{{ $c->nama_customer }}</td>
                                <td>{{ $c->notelp_customer }}</td>
                                <td>{{ $c->alamat_customer }}</td>
                                <td style="text-align: center;">
                                    <a href="/customer/edit_customer/{{ $c->idcustomer }}" class="btn btn-warning btn-sm mb-2">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <a href="/customer/delete_customer/{{ $c->idcustomer }}" class="btn btn-danger btn-sm mb-2">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $customer->appends(request()->query())->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection