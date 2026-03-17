@extends('layout.rangka')

@section('title', 'Villa - StayHub')

@section('content')
    <div class="judul-capt d-flex justify-content-between align-items-center">
        <h1>Edit PIC</h1>
    </div>

    <div class="row mt-4">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="/PIC/update_pic/{{ $pic->idpic }}">
                        @csrf

                        <div class="mb-3">
                            <label for="pic">PIC</label>
                            <select name="pic" id="pic" class="form-select">
                                <option value="" disabled selected>-- Pilih PIC --</option>
                                <option value="Biru Jawi" {{ $pic->pic == 'Biru Jawi' ? 'selected' : '' }}>Biru Jawi</option>
                                <option value="Bapak" {{ $pic->pic == 'Bapak' ? 'selected' : '' }}>Bapak</option>
                                <option value="Agen" {{ $pic->pic == 'Agen' ? 'selected' : '' }}>Agen</option>
                            </select>
                        </div>

                        <div class="mb-3" id="formAgen" style="display:none;">
                            <label for="nama_agen">Nama Agen</label>
                            <input type="text" name="nama_agen" class="form-control" placeholder="Masukkan nama agen" value="{{ $pic->nama_agen }}">
                        </div>

                        <button class="btn btn-ae">Simpan</button>
                        <a href="/PIC" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleAgen() {

            let pic = document.getElementById("pic").value;
            let formAgen = document.getElementById("formAgen");
            let inputAgen = document.querySelector('input[name="nama_agen"]');

            if (pic === "Agen") {
                formAgen.style.display = "block";
                inputAgen.disabled = false;
            } else {
                formAgen.style.display = "none";
                inputAgen.value = ""; // hapus isi
                inputAgen.disabled = true; // supaya tidak terkirim
            }

        }

        document.getElementById("pic").addEventListener("change", toggleAgen);
        document.addEventListener("DOMContentLoaded", toggleAgen);
    </script>
@endsection
