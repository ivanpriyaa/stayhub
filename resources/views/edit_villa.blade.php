@extends('layout.rangka')

@section('title', 'Customer - StayHub')

@section('content')
<h1>Edit Customer</h1>

<div class="row mt-4">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="/villa/update_villa/{{ $villa->idvilla }}">
                    @csrf

                    <div class="mb-3">
                        <label>Nama Villa</label>
                        <input type="text" name="nama_villa" class="form-control" value="{{ $villa->nama_villa }}">
                    </div>

                    <div class="mb-3">
                        <label>Alamat</label>
                        <textarea name="alamat_villa" class="form-control">{{ $villa->alamat_villa }}</textarea>
                    </div>

                    <button class="btn btn-ae">Simpan</button>
                    <a href="/villa" class="btn btn-secondary">Kembali</a>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection