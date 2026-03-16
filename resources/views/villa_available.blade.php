@extends('layout.rangka')

@section('title', 'Villa Availability - StayHub')

@section('content')
    <h1>Villa Availability</h1>

    <div class="card shadow-sm p-3">
        <div id="calendar"></div>
    </div>

    <div class="row" id="bookingDetail">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/ical.js@1.5.0/build/ical.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/icalendar@6.1.11/index.global.min.js"></script>
    <script>
        let bookings = @json($booking);
        let holidayDates = {};

        let colors = [
            "#7cf3b0",
            "#64cfff",
            "#b69aff",
            "#ffa8f5",
            "#ffa776"
        ];

        // warna booking
        bookings = bookings.map((b, i) => {
            return {
                ...b,
                color: colors[i % colors.length]
            };
        });

        document.addEventListener('DOMContentLoaded', function() {

            fetch('/holidays/indonesia.ics')
                .then(res => res.text())
                .then(data => {

                    let jcalData = ICAL.parse(data);
                    let comp = new ICAL.Component(jcalData);
                    let vevents = comp.getAllSubcomponents("vevent");

                    let holidays = vevents.map(v => {

                        let event = new ICAL.Event(v);
                        let date = event.startDate.toJSDate();

                        let dateStr =
                            date.getFullYear() + "-" +
                            String(date.getMonth() + 1).padStart(2, "0") + "-" +
                            String(date.getDate()).padStart(2, "0");

                        holidayDates[dateStr] = event.summary;

                        return {
                            title: event.summary,
                            start: date,
                            allDay: true,
                            display: "background",
                            backgroundColor: "#ffe6e6",
                            className: "holiday-event"
                        };

                    });

                    initCalendar(holidays);

                });

        });

        function initCalendar(holidays) {

            let calendarEl = document.getElementById('calendar');

            let calendar = new FullCalendar.Calendar(calendarEl, {

                initialView: 'dayGridMonth',

                events: [

                    ...bookings.map(b => ({
                        title: b.villa.nama_villa,
                        start: b.tglcekin,
                        end: b.tglcekout,
                        color: b.color
                    })),

                    ...holidays

                ],

                dayCellDidMount: function(info) {

                    let date =
                        info.date.getFullYear() + "-" +
                        String(info.date.getMonth() + 1).padStart(2, "0") + "-" +
                        String(info.date.getDate()).padStart(2, "0");

                    if (holidayDates[date]) {

                        let number = info.el.querySelector(".fc-daygrid-day-number");

                        if (number) {
                            number.style.color = "red";
                            number.style.fontWeight = "700";
                        }

                    }

                },

                dateClick: function(info) {

                    let clickedDate = info.dateStr;

                    let holidayText = "";

                    if (holidayDates[clickedDate]) {
                        holidayText = `
                        <div class="px-3">
<div class="card  rounded-3 p-3 mt-3" style="background-color: #ffeeee;border: 0;padding: 5px;">
    <div class="d-flex gap-2 align-items-center">
        <span class="event-dot" style="background:red"></span>
        <h3 class="jdl-cekv mb-0" style="font-weight:500; font-size:22px; color:#993131;""> ${holidayDates[clickedDate]}</h3>
    </div>
</div>
</div>
`;
                    }

                    let html = "";
                    let found = false;
                    bookings.forEach(function(b, i) {

                        let checkin = b.tglcekin.split(" ")[0];
                        let checkout = b.tglcekout.split(" ")[0];

                        if (clickedDate >= checkin && clickedDate <= checkout) {

                            found = true;
                            // let bgColor = displayIndex % 2 === 0 ? "#fff2d9" : "#fffcf6";
                            // displayIndex++;

                            html += `
                            <div class="col-md-6">
                                <div class="card p-3 mt-3" style="background:#fff8e9;border:0;border-left: 5px solid ${b.color};">
                                    <div class="d-flex gap-2">
                                        <img class="img-cekv" src="/images/room.jpg" width="100">
                                        <div class="body">
                                            <h3 class="jdl-cekv">${b.villa.nama_villa}</h3>
                                            <p class="sub-cekv">${b.villa.alamat_villa}</p>
                                            <div class="d-flex gap-2">
                                                <i class="bi bi-calendar-minus" style="color:#28c795"></i>
                                                <p class="sewaa">${b.tglcekin}</p>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <i class="bi bi-calendar-plus" style="color:#a11818"></i>
                                                <p class="sewaa">${b.tglcekout}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;

                        }

                    });

                    if (!found) {
                        html = `<h4 class="mt-3 text-center">Tidak ada booking di tanggal ini</h4>`;
                    }

                    document.getElementById('bookingDetail').innerHTML =
                        holidayText + html;

                }

            });

            calendar.render();


            // RESPONSIVE
            function updateHolidayTextVisibility() {

                let isMobile = window.innerWidth < 768;

                document.querySelectorAll(".holiday-event .fc-event-title").forEach(function(el) {

                    if (isMobile) {
                        el.style.display = "none";
                    } else {
                        el.style.display = "";
                    }

                });

            }

            updateHolidayTextVisibility();

            window.addEventListener("resize", updateHolidayTextVisibility);

        }
    </script>


@endsection
