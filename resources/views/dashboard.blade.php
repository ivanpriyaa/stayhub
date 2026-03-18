@extends('layout.rangka')

@section('title', 'Dashboard - StayHub')

@section('content')
    <h1>Dashboard</h1>

    <div class="row mt-4">
        <div class="col-md-4 mb-2">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <h5 class="card-title inria-sans-bold d-flex justify-content-between">
                        Total Booking
                        <span style="color:#8A7650;">
                            <i class="bi bi-building-up"></i>
                        </span>
                    </h5>

                    <div class="d-flex justify-content-between align-items-end">

                        <div style="font-size:30px;font-weight:700;">
                            {{ $booking }}
                        </div>

                        <div style="width:110px;height:35px;">
                            <canvas id="bookingChart"></canvas>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <h5 class="card-title inria-sans-bold d-flex justify-content-between">
                        Total Revenue
                        <span style="color:#8A7650;">
                            <i class="bi bi-cash-stack"></i>
                        </span>
                    </h5>

                    <div class="d-flex justify-content-between align-items-end">

                        <div style="font-size:30px;font-weight:700;">
                            Rp {{ format_uang($weeklyRevenue) }}
                        </div>

                        <div style="width:110px;height:35px;">
                            <canvas id="revenueChart"></canvas>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <h5 class="card-title inria-sans-bold d-flex justify-content-between">
                        Occupancy Rate
                        <span style="color:#8A7650;">
                            <i class="bi bi-percent"></i>
                        </span>
                    </h5>

                    <div class="d-flex justify-content-between align-items-end">

                        <div style="font-size:30px;font-weight:700;">
                            {{ $occupancyRate }}%
                        </div>

                        <div style="width:110px;height:35px;">
                            <canvas id="occupancyChart"></canvas>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-body">
                    <div class="calendar-header">

                        <div class="calendar-left d-flex gap-2">
                            <select id="monthSelect" class="form-select" style="width:45%;">
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

                            <select id="yearSelect" class="form-select" style="width:52%;">
                                @for ($i = 2020; $i <= 2035; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>

                            {{-- @if (isset($villae)) --}}
                            <select id="villaFilter" class="form-select">
                                <option value="all">Semua Villa</option>

                                @foreach ($villae as $villa)
                                    <option value="{{ strtolower($villa->nama_villa) }}">
                                        {{ $villa->nama_villa }}
                                    </option>
                                @endforeach

                            </select>
                            {{-- @endif --}}
                        </div>

                        <h3 id="calendarTitle"></h3>

                    </div>
                    <div id="calendar"></div>
                    <div class="modal fade" id="eventModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Booking</h5>
                                    <button class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <p><b>Villa :</b> <span id="modalVilla"></span></p>
                                    <p><b>Checkin :</b> <span id="modalStart"></span></p>
                                    <p><b>Checkout :</b> <span id="modalEnd"></span></p>
                                    <p><b>PIC :</b> <span id="modalPic"></span></p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let calendar;
        let holidays = [];

        function loadHolidays(year) {

            fetch('https://libur.deno.dev/api?year=' + year)
                .then(res => res.json())
                .then(data => {

                    if (data.length > 0) {

                        // holidays = data.map(item => {

                        //     let d = new Date(item.date);

                        //     let year = d.getFullYear();
                        //     let month = String(d.getMonth() + 1).padStart(2, '0');
                        //     let day = String(d.getDate()).padStart(2, '0');

                        //     return year + "-" + month + "-" + day;

                        // });
                        holidays = data.map(item => item.date);
                        calendar.render();

                    } else {

                        loadICS(year);

                    }

                })
                .catch(() => {

                    loadICS(year);

                });

        }

        function loadICS(year) {

            fetch('/holidays/tglindonesia.ics')
                .then(res => res.text())
                .then(data => {

                    let lines = data.split("\n");
                    holidays = [];

                    lines.forEach(line => {

                        if (line.startsWith("DTSTART")) {

                            let date = line.split(":")[1].trim();

                            let y = date.substring(0, 4);
                            let m = date.substring(4, 6);
                            let d = date.substring(6, 8);

                            if (y == year) {
                                holidays.push(y + "-" + m + "-" + d);
                            }

                        }

                    });

                    calendar.render();

                });

        }

        document.addEventListener('DOMContentLoaded', function() {
            let allEvents = @json($events ?? []);

            // loadHolidays(new Date().getFullYear());

            let calendarEl = document.getElementById('calendar');
            let isMobile = window.innerWidth < 768;

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 650,
                headerToolbar: false,
                locale: 'id',
                // dayHeaderFormat: {
                //     weekday: 'long'
                // },
                dayHeaderFormat: isMobile ? {
                        weekday: 'short'
                    } // Sen, Sel, Rab
                    :
                    {
                        weekday: 'long'
                    }, // Senin, Selasa, Rabu

                events: allEvents,

                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },

                eventContent: function(arg) {
                    let title = arg.event.title;
                    let time = arg.timeText;
                    let pic = arg.event.extendedProps.pic || '-';


                    let start = arg.event.start;
                    let end = arg.event.end;

                    let startTime = '';
                    let endTime = '';

                    if (start) {
                        startTime = start.toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    }

                    if (end) {
                        endTime = end.toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    }

                    if (window.innerWidth < 768) {
                        // ✅ MOBILE (lebih ringkas)
                        return {
                            html: `
                                <div style="font-size:10px; line-height:1.2">
                                    <div style="font-weight:600;">${title}</div>
                                    <div>${startTime}-${endTime}</div>
                                    <div style="color:#555;">PIC: ${pic}</div>
                                </div>
                            `
                        };
                    } else {
                        // ✅ DESKTOP (full)
                        return {
                            html: `
                                <div>
                                    ${title} | ${startTime} - ${endTime} <br>
                                    <small>PIC: ${pic}</small>
                                </div>
                            `
                        };
                    }

                    return {
                        html: title + " | " + startTime + " - " + endTime
                    };
                },

                eventDidMount: function(info) {

                    let villa = info.event.title.toLowerCase();

                    if (villa.includes('bromo 1')) {
                        info.el.style.backgroundColor = '#0f8300'; // biru
                        info.el.style.borderColor = '#0f8300';
                    }

                    if (villa.includes('bromo 2')) {
                        info.el.style.backgroundColor = '#4CAF50'; // hijau
                        info.el.style.borderColor = '#4CAF50';
                    }

                    if (villa.includes('topaz')) {
                        info.el.style.backgroundColor = '#2196F3'; // orange
                        info.el.style.borderColor = '#2196F3';
                    }

                    if (villa.includes('medan')) {
                        info.el.style.backgroundColor = '#FF9800'; // orange
                        info.el.style.borderColor = '#FF9800';
                    }
                },

                eventClick: function(info) {

                    document.getElementById("modalVilla").innerText = info.event.title;

                    document.getElementById("modalStart").innerText =
                        info.event.start.toLocaleString();

                    document.getElementById("modalEnd").innerText =
                        info.event.end ? info.event.end.toLocaleString() : "-";

                    document.getElementById("modalPic").innerText =
                        info.event.extendedProps.pic || "-";

                    let modal = new bootstrap.Modal(document.getElementById('eventModal'));
                    modal.show();

                },

                dayCellClassNames: function(info) {

                    let classes = [];
                    // let dateStr = info.date.toISOString().split('T')[0];
                    let dateStr = info.date.getFullYear() + '-' +
                        String(info.date.getMonth() + 1).padStart(2, '0') + '-' +
                        String(info.date.getDate()).padStart(2, '0');

                    if (holidays.includes(dateStr)) {
                        classes.push('holiday');
                    }

                    return classes;

                },

                dayCellDidMount: function(info) {

                    let today = new Date();
                    today.setHours(0, 0, 0, 0);

                    let dateStr = info.date.toISOString().split('T')[0];

                    // tanggal merah
                    if (holidays.includes(dateStr)) {
                        let number = info.el.querySelector('.fc-daygrid-day-number');
                        if (number) {
                            number.style.color = "red";
                            number.style.fontWeight = "bold";
                        }
                    }

                    // tanggal sebelum hari ini
                    if (info.date < today) {
                        info.el.style.backgroundColor = "#f5f5f5";
                        info.el.style.color = "#999";
                        info.el.style.cursor = "not-allowed";
                    }
                },

                dateClick: function(info) {
                    let today = new Date();
                    today.setHours(0, 0, 0, 0);
                    let tanggal = info.dateStr;
                    let clickedDate = new Date(info.dateStr);

                    if (clickedDate < today) {
                        return; // tidak melakukan apa-apa jika tanggal sebelum hari ini
                    }

                    // redirect ke halaman tambah booking
                    window.location.href = "/booking/tambah_booking?tanggal=" + tanggal +
                        "&from=calendar";
                },

                datesSet: function(info) {
                    document.getElementById("calendarTitle").innerText = info.view.title;
                }
            });



            calendar.render();

            document.getElementById("villaFilter").addEventListener("change", function() {

                let villa = this.value;

                let filtered = allEvents.filter(event => {

                    if (villa === "all") return true;

                    return event.villa && event.villa.toLowerCase() === villa;

                });

                calendar.removeAllEvents();
                calendar.addEventSource(filtered);

            });

            let yearNow = new Date().getFullYear();
            loadHolidays(yearNow);

            let today = new Date();
            let month = today.getMonth();
            let year = today.getFullYear();

            document.getElementById("monthSelect").value = month;
            document.getElementById("yearSelect").value = year;

            calendar.gotoDate(new Date(year, month, 1));

            document.getElementById("monthSelect").addEventListener("change", updateCalendar);
            document.getElementById("yearSelect").addEventListener("change", updateCalendar);

        });

        function updateCalendar() {

            let month = document.getElementById("monthSelect").value;
            let year = document.getElementById("yearSelect").value;

            let date = new Date(year, month, 1);

            calendar.gotoDate(date);

            loadHolidays(year);
        }
    </script>

    {{-- ====================
    Grafik Total Booking
    ==================== --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const ctx = document.getElementById('bookingChart');

            const labels = @json($labels);
            const data = @json($data);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        borderColor: '#8A7650',
                        backgroundColor: 'rgba(138,118,80,0.2)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: false
                        }
                    },
                    scales: {
                        x: {
                            display: false
                        },
                        y: {
                            display: false
                        }
                    }
                }
            });

        });
    </script>

    {{-- ====================
    Grafik Total Revenue
    ==================== --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const ctx = document.getElementById('revenueChart');

            const labels = @json($labels);
            const revenue = @json($revenueData);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        data: revenue,
                        borderColor: '#8A7650',
                        backgroundColor: 'rgba(138,118,80,0.2)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: false
                        }
                    },
                    scales: {
                        x: {
                            display: false
                        },
                        y: {
                            display: false
                        }
                    }
                }
            });

        });
    </script>

    {{-- ====================
    Grafik Occupancy Rate
    ==================== --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const ctx = document.getElementById('occupancyChart');

            const labels = @json($labels);
            const occupancy = @json($occupancyData);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        data: occupancy,
                        borderColor: '#8A7650',
                        backgroundColor: 'rgba(138,118,80,0.2)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: false
                        }
                    },
                    scales: {
                        x: {
                            display: false
                        },
                        y: {
                            display: false
                        }
                    }
                }
            });

        });
    </script>
@endsection
