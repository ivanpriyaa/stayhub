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
                        <div class="mb-3">
                            <label>Tanggal Booking</label>
                            <input type="date" name="tglbooking" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Nama Villa</label>
                            <select class="form-select" name="idvilla" aria-label="Pilih Brand">
                                <option disabled selected>Pilih Villa</option>
                                @foreach ($villa as $v)
                                    <option value="{{ $v->idvilla }}">
                                        {{ $v->nama_villa }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3" id="custBaru">
                            <label>Nama Tamu <span style="color: gray;">(Jika Customer belum terdaftar)</span></label>
                            <input type="text" name="nama_customer" id="namaCustomerBaru" class="form-control">
                            <input type="hidden" name="idcustomer" id="idCustomerHidden">

                        </div>

                        <div class="mb-3">
                            <label>No HP Tamu</label>
                            <input type="text" name="notelp_customer" id="noHpCustomer" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Cek In</label>
                                    <input type="datetime-local" class="form-control" name="tglcekin" id="checkin" value="{{ date('Y-m-d\T14:00') }}" min="00:00" max="23:00" step="3600">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Cek Out</label>
                                    <input type="datetime-local" class="form-control" name="tglcekout" id="checkout" value="{{ date('Y-m-d\T12:00', strtotime('+1 day')) }}" min="00:00" max="23:00" step="3600">
                                    {{-- <select class="form-select" aria-label="Default select example">
                                        <option value="00.00">00.00</option>
                                        <option value="01.00">01.00</option>
                                        <option value="02.00">02.00</option>
                                        <option value="03.00">03.00</option>
                                        <option value="04.00">04.00</option>
                                        <option value="05.00">05.00</option>
                                        <option value="06.00">06.00</option>
                                        <option value="07.00">07.00</option>
                                        <option value="08.00">08.00</option>
                                        <option value="09.00">09.00</option>
                                        <option value="10.00">10.00</option>
                                        <option value="11.00">11.00</option>
                                        <option value="12.00" selected>12.00</option>
                                        <option value="13.00">13.00</option>
                                        <option value="14.00">14.00</option>
                                        <option value="15.00">15.00</option>
                                        <option value="16.00">16.00</option>
                                        <option value="17.00">17.00</option>
                                        <option value="18.00">18.00</option>
                                        <option value="19.00">19.00</option>
                                        <option value="20.00">20.00</option>
                                        <option value="21.00">21.00</option>
                                        <option value="22.00">22.00</option>
                                        <option value="23.00">23.00</option>
                                    </select> --}}
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Note</label>
                            <textarea class="form-control" name="note" id=""></textarea>
                        </div>

                        <button class="btn btn-ae" type="submit">Simpan</button>
                        <a href="/customer" class="btn btn-secondary">Kembali</a>

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
