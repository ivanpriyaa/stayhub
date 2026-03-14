@extends('layout.rangka')

@section('title', 'Villa Availability - StayHub')

@section('content')
    <h1>Villa Availability</h1>

    <div class="card shadow-sm p-3">
        <div id="calendar"></div>
    </div>

    <div class="row" id="bookingDetail">
        {{-- @foreach ($booking as $b)
            <div class="col-md-6">
                <div class="card p-3 mt-3">
                    <div class="d-flex gap-4">
                        <img class="img-cekv" src="../images/room.jpg" alt="" width="100">
                        <div class="body">
                            <h3 class="jdl-cekv">Villa Bromo 1</h3>
                            <div class="d-flex gap-2" style="margin-top: -10px;">
                                <div class="d-flex gap-2">
                                    <i class="bi bi-calendar-minus" style="color: #28c795"></i>
                                    <p class="sewaa" style="font-weight: 500;font-size: 16px;color: #343434;margin-top: 2px;">{{ \Carbon\Carbon::parse($b->tglcekin)->translatedFormat('l, d F Y') }} - </p>
                                </div>
                                <div class="d-flex gap-2" style="margin-top: -0;">
                                    <i class="bi bi-calendar-plus" style="color: #a11818"></i>
                                    <p class="sewaa" style="font-weight: 500;font-size: 16px;color: #343434;margin-top: 2px;">{{ \Carbon\Carbon::parse($b->tglcekout)->translatedFormat('l, d F Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach --}}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    <script>
        let bookings = @json($booking);

        document.addEventListener('DOMContentLoaded', function() {

            let calendarEl = document.getElementById('calendar');

            let calendar = new FullCalendar.Calendar(calendarEl, {

                initialView: 'dayGridMonth',

                events: @json($events),

                dateClick: function(info) {

                    let clickedDate = info.dateStr;

                    let html = "";

                    let found = false;

                    bookings.forEach(function(b) {

                        let checkin = b.tglcekin.split(" ")[0];
                        let checkout = b.tglcekout.split(" ")[0];

                        if (clickedDate >= checkin && clickedDate <= checkout) {

                            found = true;

                            html += `
                    <div class="col-md-6">
                        <div class="card p-3 mt-3">
                            <div class="d-flex gap-4">

                                <img class="img-cekv" src="/images/room.jpg" width="100">

                                <div class="body">

                                    <h3 class="jdl-cekv">
                                        ${b.villa.nama_villa}
                                    </h3>
                                            <p class="sub-cekv">
                                                ${b.villa.alamat_villa}
                                            </p>

                                        <div class="d-flex gap-2">
                                            <i class="bi bi-calendar-minus" style="color:#28c795"></i>
                                            <p class="sewaa">
                                                ${b.tglcekin}
                                            </p>
                                        </div>

                                        <div class="d-flex gap-2">
                                            <i class="bi bi-calendar-plus" style="color:#a11818"></i>
                                            <p class="sewaa">
                                                ${b.tglcekout}
                                            </p>
                                        </div>


                                </div>

                            </div>
                        </div>
                    </div>
                    `;
                        }

                    });

                    if (!found) {
                        html = `<p class="mt-3">Tidak ada booking di tanggal ini</p>`;
                    }

                    document.getElementById('bookingDetail').innerHTML = html;

                }

            });

            calendar.render();

        });
    </script>
@endsection
