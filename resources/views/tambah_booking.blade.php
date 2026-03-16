@extends('layout.rangka')

@section('title', 'Booking - StayHub')

@section('content')
<h1>Tambah Booking</h1>

<div class="row mt-4">
    <div class="col">
        <div class="card">
            <div class="card-body">
                @if (session('error'))
                <p style="color:red;text-align: center;">{{ session('error') }}</p>
                @endif

                <form method="POST" action="/booking/store">
                    @csrf
                    <input type="text" name="from" value="{{ request('from') }}" hidden>
                    <div class="mb-3">
                        <label>Tanggal Booking</label>
                        <input type="date" name="tglbooking" class="form-control" value="{{ $tanggal ?? '' }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Nama Villa</label>
                        <select class="form-select" name="villa" id="villaSelect" required>
                            <option disabled selected>Pilih Villa</option>
                            <option value="bromo">Bromo</option>
                            @foreach ($villa as $v)
                            @if($v->idvilla >= 'VIL003')
                            <option value="{{ $v->idvilla }}" data-harga="{{ $v->harga_villa }}">
                                {{ $v->nama_villa }}
                            </option>
                            @endif
                            @endforeach

                        </select>
                    </div>

                    <div class="mb-3" id="bromoUnit" style="display:none;">
                        <label>Pilih Unit Bromo</label><br>
                        @foreach ($villa as $v)
                        @if($v->idvilla <= 'VIL002')
                        <input type="radio" name="idvilla" value="{{ $v->idvilla }}" data-harga="{{ $v->harga_villa }}">
                        {{ $v->nama_villa }}
                        @endif
                        @endforeach
                        <!-- <input type="radio" name="idvilla" value="{{ $v->idvilla }}" data-harga="{{ $v->harga_villa }}">
                        Bromo 1

                        <input type="radio" name="idvilla" value="{{ $v->idvilla }}" data-harga="{{ $v->harga_villa }}">
                        Bromo 2 -->
                    </div>

                    <input type="hidden" name="idvilla" id="idvillaHidden">

                    <div class="mb-3">
                        <label>Harga</label>
                        <input type="text" name="harga" id="HargaVilla" class="form-control" required>
                    </div>

                    <div class="mb-3" id="custBaru">
                        <label>Nama Tamu</label>
                        <input type="text" name="nama_customer" id="namaCustomerBaru" class="form-control" required>
                        <input type="hidden" name="idcustomer" id="idCustomerHidden">
                    </div>

                    <div class="mb-3">
                        <label>No HP Tamu</label>
                        <input type="text" name="notelp_customer" id="noHpCustomer" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Cek In</label>
                                <input type="datetime-local" class="form-control" name="tglcekin" id="checkin" value="{{ $tanggal ? $tanggal.'T14:00' : date('Y-m-d\T14:00') }}" min="00:00" max="23:00" step="3600" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Cek Out</label>
                                <input type="datetime-local" class="form-control" name="tglcekout" id="checkout" value="{{ $tanggal ? date('Y-m-d\T12:00', strtotime($tanggal.' +1 day')) : date('Y-m-d\T12:00', strtotime('+1 day')) }}" min="00:00" max="23:00" step="3600" required>

                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Total Harga</label>
                        <input type="text" name="total_harga" id="TotalHarga" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="pic">PIC</label>
                        <select name="pic" id="pic" class="form-control">
                            <option value="" disabled selected>-- Pilih PIC --</option>
                            <option value="Biru Jawi">Biru Jawi</option>
                            <option value="Bapak">Bapak</option>
                            <option value="Agen">Agen</option>
                        </select>
                    </div>

                    <div class="mb-3" id="formAgen" style="display:none;">
                        <label for="nama_agen">Nama Agen</label>
                        <input type="text" name="nama_agen" class="form-control" placeholder="Masukkan nama agen">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Note</label>
                        <textarea class="form-control" name="note" id=""></textarea>
                    </div>

                    <button class="btn btn-ae" type="submit">Simpan</button>
                    <a href="/booking" class="btn btn-secondary">Kembali</a>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery UI -->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<!-- Script autocomplete -->
{{-- PIC --}}
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
<script>
    document.getElementById("villaSelect").addEventListener("change", function() {

        let bromoUnit = document.getElementById("bromoUnit");
        let hidden = document.getElementById("idvillaHidden");
        let radioBromo = document.querySelectorAll('input[name="idvilla"]');

        if (this.value === "bromo") {
            bromoUnit.style.display = "block";
            hidden.disabled = true; // supaya tidak ikut terkirim
        } else {
            bromoUnit.style.display = "none";
            hidden.disabled = false;
            hidden.value = this.value;

            radioBromo.forEach(function(radio) {
                radio.checked = false;
            });
        }

    });
</script>
<script id="villaPriceScript">
    document.getElementById('villaSelect').addEventListener('change', function() {

        let selectedOption = this.options[this.selectedIndex];
        let harga = selectedOption.getAttribute('data-harga');
        let bromoUnit = document.getElementById('bromoUnit');

        if (this.value === "bromo") {
            bromoUnit.style.display = "block";
            document.getElementById('HargaVilla').value = "";
        } else {
            bromoUnit.style.display = "none";
            document.getElementById('HargaVilla').value = harga;
        }

        // document.getElementById('HargaVilla').value = harga;

        hitungTotalHarga(); // langsung hitung total
    });
    document.querySelectorAll('input[name="idvilla"]').forEach(function(radio) {

        radio.addEventListener('change', function() {

            let harga = this.getAttribute('data-harga');

            document.getElementById('HargaVilla').value = harga;

            hitungTotalHarga();

        });

    });
</script>
<script id="totalPriceScript">
    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function getAngka(rupiah) {
        return rupiah.replace(/[^0-9]/g, "");
    }

    function hitungTotalHarga() {

        let harga = parseFloat(getAngka(document.getElementById('HargaVilla').value)) || 0;
        let checkin = document.getElementById('checkin').value;
        let checkout = document.getElementById('checkout').value;
        console.log(harga);
        if (checkin && checkout) {

            let tglCheckin = new Date(checkin);
            let tglCheckout = new Date(checkout);

            console.log(tglCheckin);
            console.log(tglCheckout);

            let hari;
            let ms = (tglCheckout - tglCheckin);
            let jam = Math.ceil(ms / 3600000);
            if (jam < 24) {
                hari = 1;
            } else {
                hari = Math.ceil(jam / 24);
            }
            console.log(hari);

            if (hari > 0) {
                let total = harga * hari;
                document.getElementById('TotalHarga').value = formatRupiah(total);
            }

        }
    }

    /* event trigger */
    document.getElementById('HargaVilla').addEventListener('input', hitungTotalHarga);
    document.getElementById('checkin').addEventListener('change', hitungTotalHarga);
    document.getElementById('checkout').addEventListener('change', hitungTotalHarga);
</script>
<script>
    $(document).ready(function() {
        $("#namaCustomerBaru").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('customers.search') }}",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {
                $("#noHpCustomer").val(ui.item.no_hp);
                $("#idCustomerHidden").val(ui.item.id); // simpan id customer
                $("#namaCustomerBaru").val(ui.item.value);
            }
        });
    });
</script>

@endsection