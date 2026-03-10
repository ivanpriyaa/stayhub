@extends('layout.rangka')

@section('title', 'Customer - StayHub')

@section('content')
<h1>Tambah Customer</h1>

<div class="row mt-4">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="/customer/store">
                    @csrf

                    <div class="mb-3">
                        <label>Nama Customer</label>
                        <input type="text" name="nama_customer" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Telepon</label>
                        <input type="text" name="notelp_customer" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Alamat</label>
                        <textarea name="alamat_customer" class="form-control"></textarea>
                    </div>

                    <button class="btn btn-primary">Simpan</button>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection