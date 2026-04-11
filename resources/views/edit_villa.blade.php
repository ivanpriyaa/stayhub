@extends('layout.rangka')

@section('title', 'Customer - StayHub')

@section('content')
    <h1>Edit Villa</h1>

    <div class="row mt-4">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="/villa/update_villa/{{ $villa->idvilla }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label>Nama Villa</label>
                            <input type="text" name="nama_villa" class="form-control" value="{{ $villa->nama_villa }}">
                        </div>
                        <div class="mb-3">
                            <label>Harga Villa</label>
                            <input type="number" name="harga_villa" class="form-control" value="{{ $villa->harga_villa }}"
                                min="0">
                        </div>

                        <div class="mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat_villa" class="form-control">{{ $villa->alamat_villa }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label>Tambah Gambar Villa</label>
                            <input type="file" name="gambar_villa[]" class="form-control" multiple>
                            <small class="text-muted">Bisa pilih lebih dari satu gambar</small>
                        </div>

                        <button class="btn btn-ae">Simpan</button>
                        <a href="/villa" class="btn btn-secondary">Kembali</a>

                    </form>
                    {{-- <div class="mb-3 mt-3">
                        <label>Gallery Villa</label>
                        <div class="gallery-villa">
                            @forelse ($villa->images as $img)
                                <div class="image-wrapper">
                                    <img src="{{ asset('storage/' . $img->gambar) }}" class="img-thumbnail villa-img">

                                    <form action="/villa/delete_image/{{ $img->id }}" method="POST"
                                        class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn"
                                            onclick="return confirm('Hapus gambar ini?')">
                                            ✕
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <div class="image-wrapper">
                                    <img src="{{ asset('images/villa/default.jpg') }}" class="villa-img">
                                </div>
                            @endforelse
                        </div>
                    </div> --}}
                    <div class="mb-3 mt-3">
                        <label>Gallery Villa</label>
                        <div class="gallery-villa">
                            @forelse ($villa->images as $img)
                                <div class="image-wrapper">
                                    <img src="{{ asset('storage/' . $img->gambar) }}" class="villa-img">

                                    @if ($villa->gambar_villa == $img->gambar)
                                        <span class="thumb-badge">Thumbnail</span>
                                    @else
                                        <form action="{{ route('villa.set_thumbnail', $img->id) }}" method="POST"
                                            class="thumb-form">
                                            @csrf
                                            <button type="submit" class="thumb-btn">Jadikan Thumbnail</button>
                                        </form>
                                    @endif

                                    <form action="/villa/delete_image/{{ $img->id }}" method="POST"
                                        class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-btn"
                                            onclick="return confirm('Hapus gambar ini?')">✕</button>
                                    </form>
                                </div>
                            @empty
                                <div class="image-wrapper">
                                    <img src="{{ asset('images/villa/default.jpg') }}" class="villa-img">
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
