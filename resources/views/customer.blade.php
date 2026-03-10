@extends('layout.rangka')

@section('title', 'Customer - StayHub')

@section('content')
<div class="judul-capt">
    <h1>Customer</h1>
    <a href="/customer/tambah_customer" class="btn btn-ae mb-3">Tambah Customer</a>
</div>

<div class="row mt-4">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5>All</h5>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="background-color: #8a76526c;">Nama</th>
                        <th style="background-color: #8a76526c;">Telepon</th>
                        <th style="background-color: #8a76526c;">Alamat</th>
                        <th style="background-color: #8a76526c;">Action</th>
                    </tr>
                </thead>

                @foreach($customer as $c)
                <tbody>
                    <tr>
                        <td>{{ $c->nama_customer }}</td>
                        <td>{{ $c->notelp_customer }}</td>
                        <td>{{ $c->alamat_customer }}</td>
                        <td>
                            <a href="/customer/edit_customer/{{ $c->idcustomer }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <a href="/customer/delete_customer/{{ $c->idcustomer }}" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>

                @endforeach

            </table>
        </div>
    </div>
</div>

@endsection