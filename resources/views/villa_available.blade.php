@extends('layout.rangka')

@section('title', 'Villa Availability - StayHub')

@section('content')
    <h1>Villa Availability</h1>

    <div class="card shadow-sm p-3">
        <div class="calendar-header">

            <div class="calendar-left d-flex gap-2">
                <select id="monthSelect" class="form-select" style="width:160px;">
                    <option value="0">Januari</option>
                    <option value="1">Februari</option>
                    <option value="2">Maret</option>
                    <option value="3">April</option>
                    <option value="4">Mei</option>
                    <option value="5">Juni</option>
                    <option value="6">Juli</option>
                    <option value="7">Agustus</option>
                    <option value="8">September</option>
                    <option value="9">Oktober</option>
                    <option value="10">November</option>
                    <option value="11">Desember</option>
                </select>

                <select id="yearSelect" class="form-select" style="width:120px;">
                    @for ($i = 2020; $i <= 2035; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>

                <select id="filterVilla" class="form-select">
                    <option value="">Pilih Villa</option>
                    @foreach ($villa as $v)
                        <option value="{{ $v->idvilla }}">{{ $v->nama_villa }}</option>
                    @endforeach
                </select>
            </div>

            <h3 id="calendarTitle"></h3>

        </div>
        <div id="calendar"></div>
        {{-- <div id="calendar"></div> --}}
    </div>

    <div class="row" id="bookingDetail">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/ical.js@1.5.0/build/ical.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/icalendar@6.1.11/index.global.min.js"></script>
    <script>
        let calendar;
        let holidays = [];
        let holidayDates = {};
        let bookings = @json($booking);
        let allBookings = [...bookings]; // simpan semua data asli


        function getVillaColor(nama) {
            let villa = nama.toLowerCase();

            if (villa.includes('bromo 1')) return '#0f8300'; // hijau tua
            if (villa.includes('bromo 2')) return '#4CAF50'; // hijau muda
            if (villa.includes('topaz')) return '#2196F3'; // biru
            if (villa.includes('medan')) return '#FF9800'; // oranye

            return '#999'; // default
        }

        bookings = bookings.map(b => {
            return {
                ...b,
                color: getVillaColor(b.villa.nama_villa)
            };
        });

        function loadHolidays(year) {
            holidayDates = {}; // <-- TAMBAH INI

            fetch('https://libur.deno.dev/api?year=' + year)
                .then(res => res.json())
                .then(data => {

                    if (data.length > 0) {

                        holidays = data.map(item => {
                            holidayDates[item.date] = item.name;
                            return {
                                title: item.name,
                                start: item.date,
                                display: "background",
                                backgroundColor: "#ffe6e6",
                                className: "holiday-event"
                            };
                        });

                        calendar.removeAllEvents();
                        renderEvents();

                    } else {
                        loadICS(year);
                    }

                })
                .catch(() => loadICS(year));
        }

        function loadICS(year) {
            fetch('/holidays/tglindonesia.ics')
                .then(res => res.text())
                .then(data => {

                    let lines = data.split("\n");
                    holidays = [];
                    holidayDates = {};

                    lines.forEach(line => {
                        if (line.startsWith("DTSTART")) {

                            let date = line.split(":")[1].trim();

                            let y = date.substring(0, 4);
                            let m = date.substring(4, 6);
                            let d = date.substring(6, 8);

                            if (y == year) {

                                let dateStr = y + "-" + m + "-" + d;

                                holidays.push({
                                    title: "Hari Libur",
                                    start: dateStr,
                                    display: "background",
                                    backgroundColor: "#ffe6e6",
                                    className: "holiday-event"
                                });

                                holidayDates[dateStr] = "Hari Libur";
                            }
                        }
                    });

                    calendar.removeAllEvents();
                    renderEvents();
                });
        }

        function renderEvents() {
            let events = [
                ...bookings.map(b => ({
                    title: b.villa.nama_villa,
                    start: b.tglcekin,
                    end: b.tglcekout,
                    color: getVillaColor(b.villa.nama_villa)
                })),
                ...holidays
            ];

            calendar.getEventSources().forEach(source => source.remove());

            calendar.addEventSource(events);
        }



        function formatDateLocal(date) {
            let y = date.getFullYear();
            let m = String(date.getMonth() + 1).padStart(2, '0');
            let d = String(date.getDate()).padStart(2, '0');
            return `${y}-${m}-${d}`;
        }

        function formatTanggalIndo(datetime) {
            let date = new Date(datetime);

            let tanggal = date.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });

            let jam = date.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });

            return `${tanggal}, ${jam}`;
        }
        document.addEventListener('DOMContentLoaded', function() {


            document.getElementById("filterVilla").addEventListener("change", function() {

                let selectedVillaId = this.value;
                console.log("Selected:", selectedVillaId);

                if (selectedVillaId === "") {
                    bookings = [...allBookings];
                } else {
                    bookings = allBookings.filter(b => b.idvilla == selectedVillaId);
                }

                renderEvents();
            });


            let calendarEl = document.getElementById('calendar');

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 650,
                headerToolbar: false,
                locale: 'id',
                displayEventTime: false, // ⬅️ TAMBAH INI


                dayHeaderFormat: {
                    weekday: 'long'
                },
                eventContent: function(arg) {

                    let isMobile = window.innerWidth < 768;

                    // ❗ kalau holiday & mobile → kosongkan
                    if (arg.event.classNames.includes('holiday-event') && isMobile) {
                        return {
                            html: ``
                        }; // ⬅️ hilang total
                    }

                    // ❗ kalau holiday (desktop)
                    if (arg.event.classNames.includes('holiday-event')) {
                        return {
                            html: `<div>${arg.event.title}</div>`
                        };
                    }

                    // ✅ booking
                    let start = arg.event.start;
                    let end = arg.event.end;

                    let jamMasuk = start ? start.toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    }) : '';

                    let jamKeluar = end ? end.toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    }) : '';

                    if (isMobile) {
                        return {
                            html: `
                <div style="
                    font-size:10px;
                    font-weight:600;
                    white-space:nowrap;
                    overflow:hidden;
                    text-overflow:ellipsis;
                ">
                    ${arg.event.title}
                </div>
                <div style="font-weight:600; font-size:10px;">
                     ${jamMasuk} - ${jamKeluar}
                </div>
            `
                        };
                    }

                    return {
                        html: `
            <div style="font-weight:600; font-size:12px;">
                ${arg.event.title} | ${jamMasuk} - ${jamKeluar}
            </div>
        `
                    };
                },


                dayCellDidMount: function(info) {

                    let dateStr = formatDateLocal(info.date);
                    if (holidayDates[dateStr]) {
                        let number = info.el.querySelector(".fc-daygrid-day-number");
                        if (number) {
                            number.style.color = "red";
                            number.style.fontWeight = "bold";
                        }
                    }
                },

                dateClick: function(info) {

                    let clickedDate = info.dateStr;

                    let holidayText = "";

                    if (holidayDates[clickedDate]) {
                        holidayText = `
                    <div class="px-3">
                        <div class="card rounded-3 p-3 mt-3" style="background-color: #fffafa;border: 0;border-left:5px solid red;padding: 5px;">
                            <div class="d-flex gap-2 align-items-center">
                                <span class="event-dot" style="background:red"></span>
                                <h3 class="jdl-cekv mb-0" style="font-weight:500; font-size:22px; color:#993131;""> ${holidayDates[clickedDate]}</h3>
                            </div>
                        </div>
                    </div>`;
                    }

                    let html = "";
                    let found = false;

                    bookings.forEach(function(b) {

                        let checkin = b.tglcekin.split(" ")[0];
                        let checkout = b.tglcekout.split(" ")[0];

                        if (clickedDate >= checkin && clickedDate <= checkout) {

                            found = true;

                            html += `
                        <div class="col-md-6 ">
                                <div class="card p-3 mt-3" style="background:#fffbf1;border:0;border-left: 5px solid ${b.color};">
                                    <div class="d-flex gap-2">
                                        <img class="img-cekv" src="/images/room.jpg" width="100">
                                        <div class="body">
                                            <h3 class="jdl-cekv">${b.villa.nama_villa}</h3>
                                            <p class="sub-cekv">${b.villa.alamat_villa}</p>
                                            <div class="d-flex gap-2">
                                                <i class="bi bi-calendar-minus icon-cekv" style="color:#28c795"></i>
                                                <p class="sewaa">${formatTanggalIndo(b.tglcekin)}</p>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <i class="bi bi-calendar-plus icon-cekv" style="color:#a11818"></i>
                                                <p class="sewaa">${formatTanggalIndo(b.tglcekout)}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        }
                    });

                    if (!found) {
                        html = `<h5 class="text-center mt-3">Tidak ada booking</h5>`;
                    }

                    document.getElementById('bookingDetail').innerHTML =
                        holidayText + html;
                },
                dayCellClassNames: function(info) {

                    let dateStr = formatDateLocal(info.date);
                    if (holidayDates[dateStr]) {
                        return ['holiday'];
                    }

                    return [];
                },

                datesSet: function(info) {
                    document.getElementById("calendarTitle").innerText = info.view.title;
                }
            });

            calendar.render();

            // load holiday
            let yearNow = new Date().getFullYear();
            loadHolidays(yearNow);

            // dropdown bulan & tahun
            let today = new Date();
            document.getElementById("monthSelect").value = today.getMonth();
            document.getElementById("yearSelect").value = today.getFullYear();

            calendar.gotoDate(new Date(today.getFullYear(), today.getMonth(), 1));

            document.getElementById("monthSelect").addEventListener("change", updateCalendar);
            document.getElementById("yearSelect").addEventListener("change", updateCalendar);

            // RESPONSIVE
            function updateHolidayTextVisibility() {
                let isMobile = window.innerWidth < 768;

                document.querySelectorAll(".holiday-event").forEach(el => {

                    let text = el.querySelector(".fc-event-title, .fc-event-main");

                    if (text) {
                        text.style.display = isMobile ? "none" : "";
                    }
                });
            }

            updateHolidayTextVisibility();
            window.addEventListener("resize", updateHolidayTextVisibility);
        });

        function updateCalendar() {
            let month = document.getElementById("monthSelect").value;
            let year = document.getElementById("yearSelect").value;

            calendar.gotoDate(new Date(year, month, 1));
            loadHolidays(year);
        }
    </script>


@endsection
