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
                            <input type="date" name="tglbooking" class="form-control" value="{{ $tanggal ?? '' }}"
                                required>
                        </div>

                        @php
                            $groupVilla = $villa->groupBy(function ($item) {
                                return explode(' ', $item->nama_villa)[0];
                            });
                        @endphp

                        <div class="mb-3">
                            <label>Nama Villa</label>
                            <select class="form-select" id="villaSelect">
                                <option disabled selected>Pilih Villa</option>

                                @foreach ($groupVilla as $nama => $items)
                                    <option value="{{ strtolower($nama) }}" data-count="{{ $items->count() }}">
                                        {{ $nama }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        @foreach ($groupVilla as $nama => $items)
                            @if ($items->count() > 1)
                                <div class="mb-3 villa-unit" id="unit-{{ strtolower($nama) }}" style="display:none;">
                                    <label>Pilih Unit {{ $nama }}</label><br>

                                    @foreach ($items as $v)
                                        <input type="radio" name="idvilla" value="{{ $v->idvilla }}"
                                            data-harga="{{ $v->harga_villa }}">
                                        {{ $v->nama_villa }} <br>
                                    @endforeach

                                </div>
                            @else
                                @foreach ($items as $v)
                                    <input type="hidden" id="single-{{ strtolower($nama) }}" value="{{ $v->idvilla }}"
                                        data-harga="{{ $v->harga_villa }}">
                                @endforeach
                            @endif
                        @endforeach

                        <input type="hidden" name="idvilla" id="idvillaHidden">

                        <div class="mb-3">
                            <label>Harga</label>
                            <input type="text" name="harga" id="HargaVilla" class="form-control" required
                                @if (Auth::user()->role === 'agen') readonly @endif>
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
                                    <input type="datetime-local" class="form-control" name="tglcekin" id="checkin"
                                        value="{{ $tanggal ? $tanggal . 'T14:00' : date('Y-m-d\T14:00') }}" min="00:00"
                                        max="23:00" step="60" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Cek Out</label>
                                    <input type="datetime-local" class="form-control" name="tglcekout" id="checkout"
                                        value="{{ $tanggal ? date('Y-m-d\T12:00', strtotime($tanggal . ' +1 day')) : date('Y-m-d\T12:00', strtotime('+1 day')) }}"
                                        min="00:00" max="23:00" step="60" required>

                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Total Harga</label>
                            <input type="text" name="total_harga" id="TotalHarga" class="form-control" required>
                        </div>

                        <div class="mb-3">
                        <label>Metode Pembayaran</label>

                        <select name="metode_pembayaran" id="metodePembayaran" class="form-select">
                            <option value="Lunas">Lunas</option>
                            <option value="DP">DP</option>
                        </select>
                    </div>

                    <div class="mb-3" id="dpField" style="display:none;">
                        <label>Nominal DP</label>
                        <input
                            type="number"
                            class="form-control"
                            name="nominal_dibayar"
                            min="0">
                    </div>

                        {{-- <div class="mb-3">
                            <label for="pic">PIC</label>
                            <select name="pic" id="pic" class="form-control">
                                <option value="" disabled selected>-- Pilih PIC --</option>
                                <option value="Biru Jawi">Biru Jawi</option>
                                <option value="Bapak">Bapak</option>
                                <option value="Agen">Agen</option>
                            </select>
                        </div> --}}

                        <input type="hidden" name="pic" value="{{ Auth::user()->nama_user }}">
                        <input type="hidden" name="status" value="TerBooking">

                        <div class="mb-3" id="formAgen" style="display:none;">
                            <label for="nama_agen">Nama Agen</label>
                            <input type="text" name="nama_agen" class="form-control" placeholder="Masukkan nama agen">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Note</label>
                            <textarea class="form-control" name="note" id=""></textarea>
                        </div>

                        <button class="btn btn-ae" type="submit">Simpan</button>
                        @if (request('from'))
                            <a href="/dashboard" class="btn btn-secondary">Kembali</a>
                        @else
                            <a href="/booking" class="btn btn-secondary">Kembali</a>
                        @endif

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
        let selectedVillaFromURL = "{{ $villaSelected ?? '' }}";
        let selectedUnitFromURL = "{{ $villaUnitSelected ?? '' }}";
    </script>
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
    <script id="villaPriceScript">
        document.getElementById('villaSelect').addEventListener('change', function() {
            let selectedOption = this.options[this.selectedIndex];
            let villa = this.value;

            // sembunyikan semua unit dulu
            document.querySelectorAll(".villa-unit").forEach(el => el.style.display = "none");

            // tampilkan unit kalau ada
            let target = document.getElementById("unit-" + villa);
            if (target) target.style.display = "block";

            // ambil harga
            let harga = selectedOption.getAttribute('data-harga');

            // kalau option tidak punya data-harga (villa single), ambil dari hidden input
            if (!harga) {
                let single = document.getElementById("single-" + villa);
                if (single) {
                    harga = parseInt(single.getAttribute('data-harga'));
                    let checkin =
                        document.getElementById('checkin').value;
                    let date = new Date(checkin);
                    let day = date.getDay();
                    if(day === 0 || day === 6){
                        harga += 50000;
                    }
                    document.getElementById('idvillaHidden').value = single.value; // set id villa
                }
            }

            document.getElementById('HargaVilla').value = harga || '';
            hitungTotalHarga();
        });
        // document.querySelectorAll('input[name="idvilla"]').forEach(radio => {
        //     radio.addEventListener('change', function() {
        //         let harga = this.getAttribute('data-harga');
        //         document.getElementById('HargaVilla').value = harga;
        //         document.getElementById('idvillaHidden').value = this.value; // penting
        //         hitungTotalHarga();
        //     });
        // });
        document.querySelectorAll('input[name="idvilla"]').forEach(radio => {
            radio.addEventListener('change', function() {
                let harga = parseInt(this.getAttribute('data-harga'));
                let checkin =
                    document.getElementById('checkin').value;
                let date = new Date(checkin);
                let day = date.getDay();
                // Sabtu / Minggu
                if(day === 0 || day === 6){
                    harga += 50000;
                    // atau:
                    // harga = harga * 1.5;

                }
                document.getElementById('HargaVilla').value = harga;
                document.getElementById('idvillaHidden').value =
                    this.value;
                hitungTotalHarga();
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            if (selectedVillaFromURL) {

                let select = document.getElementById("villaSelect");

                // set value dropdown
                select.value = selectedVillaFromURL;

                // trigger change supaya jalan semua logic (harga, unit, dll)
                select.dispatchEvent(new Event('change'));

                // 🔥 kasih delay biar radio muncul dulu
                setTimeout(() => {

                    let radios = document.querySelectorAll('input[name="idvilla"]');

                    radios.forEach(radio => {

                        let labelText = radio.nextSibling.textContent.trim().toLowerCase();

                        if (labelText === selectedUnitFromURL) {

                            radio.checked = true;

                            // trigger event biar harga ikut update
                            radio.dispatchEvent(new Event('change'));
                        }

                    });

                }, 200);
            }

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

        document.getElementById("metodePembayaran").addEventListener("change", function () {

            const dpField = document.getElementById("dpField");
            const nominal = document.querySelector('input[name="nominal_dibayar"]');

            if (this.value === "DP") {
                dpField.style.display = "block";
            } else {
                dpField.style.display = "none";
                nominal.value = "";
            }

        });
    </script>

@endsection
