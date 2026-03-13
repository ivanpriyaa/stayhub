@extends('layout.rangka')

@section('title', 'Booking - StayHub')

@section('content')
    <h1>Edit Booking</h1>

    <div class="row mt-4">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    @if (session('error'))
                        <p style="color:red;text-align: center;">{{ session('error') }}</p>
                    @endif

                    <form method="POST" action="/booking/update_booking/{{ $booking->idbooking }}">
                        @csrf
                        <div class="mb-3">
                            <label>Tanggal Booking</label>
                            <input type="date" name="tglbooking" class="form-control" value="{{ $booking->tglbooking }}">
                        </div>

                        <div class="mb-3">
                            <label>Nama Villa</label>
                            <select class="form-select" name="idvilla" aria-label="Pilih Brand" id="villaSelect">
                                <option disabled>Pilih Brand</option>
                                @foreach ($villa as $v)
                                    <option value="{{ $v->idvilla }}" {{ $booking->idvilla == $v->idvilla ? 'selected' : '' }}>
                                        {{ $v->nama_villa }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Harga</label>
                            <input type="text" name="harga" id="HargaVilla" class="form-control" value="{{ $booking->harga }}">
                        </div>


                        <div class="mb-3" id="custBaru">
                            <label>Nama Tamu</label>
                            <input type="text" name="nama_customer" id="namaCustomerBaru" class="form-control" value="{{ $booking->customer->nama_customer }}">
                            <input type="hidden" name="idcustomer" id="idCustomerHidden" value="{{ $booking->idcustomeer }}">

                        </div>

                        <div class="mb-3">
                            <label>No HP Tamu</label>
                            <input type="text" name="notelp_customer" id="noHpCustomer" class="form-control" value="{{ $booking->customer->notelp_customer }}">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Cek In</label>
                                    <input type="datetime-local" class="form-control" name="tglcekin" id="checkin" value="{{ \Carbon\Carbon::parse($booking->tglcekin)->format('Y-m-d\TH:i') }}" min="00:00" max="23:00" step="3600">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Cek Out</label>
                                    <input type="datetime-local" class="form-control" name="tglcekout" id="checkout" value="{{ \Carbon\Carbon::parse($booking->tglcekout)->format('Y-m-d\TH:i') }}" min="00:00" max="23:00" step="3600">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Total Harga</label>
                            <input type="text" name="total_harga" id="TotalHarga" class="form-control" value="Rp. {{ number_format($booking->total_harga, 0, '.', '.') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Note</label>
                            <textarea class="form-control" name="note" id="">{{ $booking->note }}</textarea>
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
    <script id="villaPriceScript">
        document.getElementById('villaSelect').addEventListener('change', function() {

            let selectedOption = this.options[this.selectedIndex];
            let harga = selectedOption.getAttribute('data-harga');

            document.getElementById('HargaVilla').value = harga;

            hitungTotalHarga(); // langsung hitung total
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

            let harga = parseFloat(document.getElementById('HargaVilla').value) || 0;
            let checkin = document.getElementById('checkin').value;
            let checkout = document.getElementById('checkout').value;

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
                    // isi otomatis No HP
                    $("#noHpCustomer").val(ui.item.no_hp);
                    $("#idCustomerHidden").val(ui.item.id); // simpan id customer
                    $("#namaCustomerBaru").val(ui.item.value);
                }
            });
        });
    </script>

@endsection
