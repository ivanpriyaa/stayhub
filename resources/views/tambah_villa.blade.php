@extends('layout.rangka')

@section('title', 'Villa - StayHub')

@section('content')
    <div class="judul-capt d-flex justify-content-between align-items-center">
        <h1>Villa</h1>
    </div>

    <div class="row mt-4">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="/villa/store">
                        @csrf

                        <div class="mb-3">
                            <label>Nama Villa</label>
                            <input type="text" name="nama_villa" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Harga Villa</label>
                            <input type="number" name="harga_villa" class="form-control" min="0">
                        </div>

                        <div class="mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat_villa" class="form-control"></textarea>
                        </div>

                        <button class="btn btn-ae">Simpan</button>
                        <a href="/villa" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
