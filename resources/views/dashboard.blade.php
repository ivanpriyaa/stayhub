@extends('layout.rangka')

@section('title', 'Dashboard - StayHub')

@section('content')
    <h1>Dashboard</h1>

    <div class="row mt-4">
        <div class="col-md-4 mb-2">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title inria-sans-bold" style="display: flex;justify-content: space-between;">Total
                        Booking<span style="color: #8A7650;"><i class="bi bi-cash-stack"></i></span></h5>
                    <p class="card-text" style="font-size: 30px;font-weight: 700;">{{ $booking }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title inria-sans-bold" style="display: flex;justify-content: space-between;">Card
                        title<span style="color: #8A7650;"><i class="bi bi-cash-stack"></i></span></h5>
                    <p class="card-text" style="font-size: 30px;font-weight: 700;">Rp 1jt</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title inria-sans-bold" style="display: flex;justify-content: space-between;">Card
                        title<span style="color: #8A7650;"><i class="bi bi-cash-stack"></i></span></h5>
                    <p class="card-text" style="font-size: 30px;font-weight: 700;">Rp 1jt</p>
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
                        </div>

                        <h3 id="calendarTitle"></h3>

                    </div>
                    <div id="calendar"></div>
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
            let events = @json($events ?? []);

            // loadHolidays(new Date().getFullYear());

            let calendarEl = document.getElementById('calendar');

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 650,
                headerToolbar: false,
                locale: 'id',
                dayHeaderFormat: {
                    weekday: 'long'
                },

                events: events,

                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },

                eventContent: function(arg) {
                    let title = arg.event.title;
                    let time = arg.timeText;

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

                    return {
                        html: title + " | " + startTime + " - " + endTime
                    };
                },

                eventDidMount: function(info) {

                    let villa = info.event.title.toLowerCase();

                    if (villa.includes('bromo 1')) {
                        info.el.style.backgroundColor = '#0f8300'; // hijau tua
                        info.el.style.borderColor = '#0f8300';
                    }

                    if (villa.includes('bromo 2')) {
                        info.el.style.backgroundColor = '#4CAF50'; // hijau muda
                        info.el.style.borderColor = '#4CAF50';
                    }

                    if (villa.includes('topaz')) {
                        info.el.style.backgroundColor = '#2196F3'; // biru
                        info.el.style.borderColor = '#2196F3';
                    }

                    if (villa.includes('medan')) {
                        info.el.style.backgroundColor = '#FF9800'; // orange
                        info.el.style.borderColor = '#FF9800';
                    }
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
@endsection
