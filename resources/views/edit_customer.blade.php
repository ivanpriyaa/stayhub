@extends('layout.rangka')

@section('title', 'Customer - StayHub')

@section('content')
<h1>Edit Customer</h1>

<div class="row mt-4">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="/customer/update_customer/{{ $customer->idcustomer }}">
                    @csrf

                    <div class="mb-3">
                        <label>Nama Customer</label>
                        <input type="text" name="nama_customer" class="form-control" value="{{ $customer->nama_customer }}">
                    </div>

                    <div class="mb-3">
                        <label>Telepon</label>
                        <input type="text" name="notelp_customer" class="form-control" value="{{ $customer->notelp_customer }}">
                    </div>

                    <div class="mb-3">
                        <label>Alamat</label>
                        <textarea name="alamat_customer" class="form-control">{{ $customer->alamat_customer }}</textarea>
                    </div>

                    <button class="btn btn-ae">Simpan</button>
                    <a href="/customer" class="btn btn-secondary">Kembali</a>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection