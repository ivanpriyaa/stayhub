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
                            <div id="villaCheckboxContainer" class="mt-2"></div>
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
                                    <p><b>Status :</b> <span id="modalStatus"></span></p>
                                    <p><b>Jenis Pembayaran :</b> <span id="modalStatusPembayaran"></span></p>
                                    <p><b>Note :</b> <span id="modalNote"></span></p>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" id="btnInvoice" class="btn btn-warning" style="font-weight: 600;">
                                        <i class="bi bi-printer"></i> Print Invoice</button>
                                    <button type="button" id="btnTambahHari" class="btn btn-success">
                                        <i class="bi bi-calendar-plus"></i> Tambah Hari
                                    </button>
                                    <button type="button" id="btnLunas" class="btn d-none"
                                        style="background-color: #0dfd81;font-weight: 600;" style="font-weight: 600;"><i
                                            class="bi bi-cash"></i> Pelunasan</button>
                                    <button type="button" id="btnClose" class="btn btn-danger d-none"
                                        style="font-weight: 600;">Cancel Booking</button>
                                    <button type="button" id="btnCin" class="btn d-none"
                                        style="background-color: #0d6efd;color: white;font-weight: 600;"
                                        style="font-weight: 600;">Checkin</button>
                                    <button type="button" id="btnCout" class="btn d-none"
                                        style="background-color: #198754;color: white;font-weight: 600;"
                                        style="font-weight: 600;">Checkout</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="tambahHariModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-calendar-plus"></i>
                        Tambah Hari Sewa
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">

                    <p>
                        <b>Villa :</b>
                        <span id="tambahVilla"></span>
                    </p>

                    <p>
                        <b>Customer :</b>
                        <span id="tambahCustomer"></span>
                    </p>

                    <p>
                        <b>Check-Out Sekarang :</b>
                        <span id="tambahCheckoutLama"></span>
                    </p>

                    <hr>

                    <div class="mb-3">
                        <label class="form-label">
                            Tambah Berapa Hari?
                        </label>

                        <input type="number" id="jumlahTambahHari" class="form-control" min="1" max="30" value="1">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Check-Out Baru
                        </label>

                        <input type="text" id="tambahCheckoutBaru" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Harga Per Hari
                        </label>

                        <input type="text" id="tambahHargaHari" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Tambahan Harga
                        </label>

                        <input type="text" id="tambahHargaTambahan" class="form-control" readonly>
                    </div>

                    <div class="alert alert-info">
                        <strong>Total Harga Baru:</strong>
                        <span id="tambahTotalBaru"></span>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="button" id="btnSimpanTambahHari" class="btn btn-success">
                        <i class="bi bi-check-circle"></i>
                        Simpan
                    </button>

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

        document.addEventListener('DOMContentLoaded', function () {
            let allEvents = @json($events ?? []);

            // loadHolidays(new Date().getFullYear());

            let calendarEl = document.getElementById('calendar');
            let isMobile = window.innerWidth < 768;

            // ---- Palette warna gelap aman ----
            function generateSafeDarkColors(count) {
                const colors = [];
                while (colors.length < count) {
                    const r = Math.floor(Math.random() * 150);
                    const g = Math.floor(Math.random() * 150);
                    const b = Math.floor(Math.random() * 150);
                    let hex = "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1);
                    if (
                        (r > g + b) ||
                        (g > r + b) ||
                        (b > r + g) ||
                        hex.toLowerCase() === '#8a7650' ||
                        hex.toLowerCase() === '#dc3545' ||
                        hex.toLowerCase() === '#198754' ||
                        hex.toLowerCase() === '#0d6efd' ||
                        hex.toLowerCase() === '#fff'
                    ) continue;
                    colors.push(hex);
                }
                return colors;
            }

            // buat palette 30 warna gelap
            const darkPalette = generateSafeDarkColors(30);

            // fungsi hash sederhana supaya event sama dapat warna sama
            function stringToIndex(str, max) {
                let hash = 0;
                for (let i = 0; i < str.length; i++) {
                    hash = str.charCodeAt(i) + ((hash << 5) - hash);
                }
                return Math.abs(hash) % max;
            }

            function getStatusColor(status) {
                status = status.toLowerCase();

                if (status === 'booking' || status === 'terbooking') return '#eba134'; // coklat
                if (status === 'checkin') return '#0d6efd';
                if (status === 'selesai') return '#198754';
                if (status === 'cancel') return '#dc3545';

                return '#000';
            }

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

                eventContent: function (arg) {
                    let title = arg.event.title;
                    let time = arg.timeText;
                    let pic = arg.event.extendedProps.pic || '-';
                    let status = arg.event.extendedProps.status || '-';
                    let status_pembayaran = arg.event.extendedProps.status_pembayaran || '-';


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
                                                                                        <div style="font-weight:700;white-space: normal; word-break: break-word;">${title}</div>
                                                                                        <div>${startTime}-${endTime}</div>
                                                                                        <div>PIC : ${pic}</div>
                                                                                        <div>Status : </div>
                                                                                        <br>
                                                                                        <div style="display:flex;justify-content:center;align-items:center;">
                                                                                            <span style="
                                                                                                background:${getStatusColor(status)};
                                                                                                color:#fff;
                                                                                                padding:2px 6px;
                                                                                                border-radius:6px;
                                                                                                font-size:8px;
                                                                                                font-weight:600;
                                                                                            ">
                                                                                                ${status}
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                `
                        };
                    } else {
                        // ✅ DESKTOP (full)
                        return {
                            html: `
                                                                                    <div>
                                                                                        ${title} | ${startTime} - ${endTime} <br>
                                                                                        <small>
                                                                                            PIC : ${pic} |
                                                                                            Status : 
                                                                                                <span style="
                                                                                                    background:${getStatusColor(status)};
                                                                                                    color:#fff;
                                                                                                    padding:2px 6px;
                                                                                                    border-radius:6px;
                                                                                                    font-size:11px;
                                                                                                    font-weight:600;
                                                                                                ">${status}
                                                                                                </span>
                                                                                        </small>
                                                                                    </div>
                                                                                `
                        };
                    }

                    return {
                        html: title + " | " + startTime + " - " + endTime
                    };
                },

                eventDidMount: function (info) {

                    // pilih warna dari palette berdasarkan judul event
                    let villa = (info.event.extendedProps.villa || info.event.title).toLowerCase();

                    // jika belum ada warna, buatkan
                    if (!window.villaColors) window.villaColors = {};

                    if (!villaColors[villa]) {
                        let index = stringToIndex(villa, darkPalette.length);
                        villaColors[villa] = darkPalette[index];
                    }

                    let color = villaColors[villa];

                    info.el.style.backgroundColor = color;
                    info.el.style.borderColor = color;
                    info.el.style.color = '#ffffff';
                },

                eventClick: function (info) {
                    let pic = info.event.extendedProps.pic || "-";
                    let authPIC = "{{ auth()->user()->username }}";
                    let userRole = "{{ auth()->user()->role }}";
                    let status = info.event.extendedProps.status || "-";
                    let status_pembayaran = info.event.extendedProps.status_pembayaran || "-";

                    document.getElementById("modalVilla").innerText = info.event.title;
                    document.getElementById("modalStart").innerText = info.event.start.toLocaleString();
                    document.getElementById("modalEnd").innerText = info.event.end ? info.event.end.toLocaleString() : "-";
                    document.getElementById("modalPic").innerText = info.event.extendedProps.pic || "-";
                    document.getElementById("modalStatus").innerText = info.event.extendedProps.status || "-";
                    document.getElementById("modalStatusPembayaran").innerText = info.event.extendedProps.status_pembayaran || "-";
                    document.getElementById("modalNote").innerText = info.event.extendedProps.note || "-";

                    let btn = document.getElementById("btnClose");
                    let btncin = document.getElementById("btnCin");
                    let btncout = document.getElementById("btnCout");
                    let btnInvoice = document.getElementById("btnInvoice");
                    let btnLunas = document.getElementById("btnLunas");
                    let btnTambahHari = document.getElementById("btnTambahHari");

                    btn.dataset.id = info.event.id;
                    btncin.dataset.id = info.event.id;
                    btncout.dataset.id = info.event.id;
                    btnInvoice.dataset.id = info.event.id;
                    btnLunas.dataset.id = info.event.id;
                    btnTambahHari.dataset.id = info.event.id;

                    let picClean = pic.trim().toLowerCase();
                    let authClean = authPIC.trim().toLowerCase();
                    let statusClean = status.trim().toLowerCase();

                    if (picClean === authClean && statusClean !== "closing") {
                        btn.classList.remove("d-none"); // tampilkan
                    } else {
                        btn.classList.add("d-none"); // sembunyikan
                    }

                    if (userRole === "Admin" || userRole === "super admin") {
                        if (statusClean === "terbooking") {
                            btn.classList.remove("d-none");
                            btncout.classList.add("d-none");
                            if (status_pembayaran === "DP") {
                                btncin.classList.add("d-none");
                                btnLunas.classList.remove("d-none");
                            } else {
                                btnLunas.classList.add("d-none");
                                btncin.classList.remove("d-none");
                            }
                        }

                        if (statusClean === "checkin") {
                            btncin.classList.add("d-none");
                            btncout.classList.remove("d-none");
                            btn.classList.add("d-none");
                        }
                    }

                    if (statusClean === "cancel" || statusClean === "selesai") {
                        btn.classList.add("d-none");
                        btncin.classList.add("d-none");
                        btncout.classList.add("d-none");
                    }

                    let modal = new bootstrap.Modal(document.getElementById('eventModal'));
                    modal.show();

                },

                dayCellClassNames: function (info) {

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

                dayCellDidMount: function (info) {

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

                dateClick: function (info) {
                    let today = new Date();
                    today.setHours(0, 0, 0, 0);
                    let tanggal = info.dateStr;
                    let clickedDate = new Date(info.dateStr);

                    if (clickedDate < today) {
                        return; // tidak melakukan apa-apa jika tanggal sebelum hari ini
                    }

                    let selectedVilla = document.getElementById("villaFilter").value;

                    if (selectedVilla === "all") {
                        alert("Pilih villa terlebih dahulu sebelum menambah booking!");
                        return;
                    }

                    let villaGroup = selectedVilla.split(' ')[0];

                    // redirect ke halaman tambah booking
                    window.location.href = "/booking/tambah_booking?tanggal=" + tanggal +
                        "&villa=" + encodeURIComponent(selectedVilla.toLowerCase()) +
                        "&from=calendar";
                },

                datesSet: function (info) {
                    document.getElementById("calendarTitle").innerText = info.view.title;
                }
            });



            calendar.render();

            const allVilla = @json($villae);

            function renderVillaCheckbox(villas) {

                let container =
                    document.getElementById('villaCheckboxContainer');

                container.innerHTML = '';

                villas.forEach(villa => {

                    container.innerHTML += `
                                                                            <div class="form-check">
                                                                                <input 
                                                                                    class="form-check-input villa-checkbox"
                                                                                    type="checkbox"
                                                                                    value="${villa.nama_villa.toLowerCase()}"
                                                                                    checked
                                                                                >

                                                                                <label class="form-check-label">
                                                                                    ${villa.nama_villa}
                                                                                </label>
                                                                            </div>
                                                                        `;

                });

                addCheckboxEvent();

            }

            function addCheckboxEvent() {

                document.querySelectorAll('.villa-checkbox')
                    .forEach(checkbox => {

                        checkbox.addEventListener('change', filterCalendar);

                    });

            }

            function filterCalendar() {

                let checkedVilla = [];

                document.querySelectorAll('.villa-checkbox:checked')
                    .forEach(item => {

                        checkedVilla.push(item.value);

                    });

                let filtered = allEvents.filter(event => {

                    return checkedVilla.includes(
                        event.villa.toLowerCase()
                    );

                });

                calendar.removeAllEvents();

                calendar.addEventSource(filtered);

            }

            // pertama kali load
            renderVillaCheckbox(allVilla);

            document.getElementById("villaFilter")
                .addEventListener("change", function () {

                    let value = this.value.toLowerCase();

                    // semua villa
                    if (value === 'all') {

                        renderVillaCheckbox(allVilla);

                        return;
                    }

                    // filter berdasarkan group
                    let filteredVilla = allVilla.filter(villa => {

                        return villa.nama_villa
                            .toLowerCase()
                            .includes(value);

                    });

                    renderVillaCheckbox(filteredVilla);

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
        document.addEventListener("DOMContentLoaded", function () {

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
        document.addEventListener("DOMContentLoaded", function () {

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
        document.addEventListener("DOMContentLoaded", function () {

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
    <script>
        document.getElementById('btnClose').addEventListener('click', function () {

            const id = this.dataset.id;

            if (!id) {
                alert('ID booking tidak ditemukan');
                return;
            }

            if (!confirm('Yakin ingin cancel booking ini?')) return;

            fetch(`/booking/cancel/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
                .then(res => res.json())
                .then(data => {

                    if (data.success) {

                        alert(data.message);

                        let event = calendar.getEventById(id);

                        if (event) {
                            event.setExtendedProp('status', 'Cancel');

                            // optional: ubah warna jadi abu
                            event.setProp('backgroundColor', '#999');
                            event.setProp('borderColor', '#999');
                        }

                        // tutup modal
                        let modal = bootstrap.Modal.getInstance(document.getElementById('eventModal'));
                        modal.hide();
                    }

                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi error');
                });
        });
    </script>
    <script>
        document.getElementById('btnCin').addEventListener('click', function () {
            const id = this.dataset.id;
            if (!confirm('Checkin sekarang?')) return;
            fetch(`/booking/checkin/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        let event = calendar.getEventById(id);
                        if (event) {
                            event.setExtendedProp('status', 'Checkin');
                        }
                        bootstrap.Modal.getInstance(document.getElementById('eventModal')).hide();
                    }
                });
        });
    </script>
    <script>
        document.getElementById('btnCout').addEventListener('click', function () {

            const id = this.dataset.id;

            if (!confirm('Checkout sekarang?')) return;

            fetch(`/booking/checkout/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(res => res.json())
                .then(data => {

                    if (data.success) {

                        alert(data.message);

                        let event = calendar.getEventById(id);

                        if (event) {
                            event.setExtendedProp('status', 'Selesai');
                        }

                        bootstrap.Modal.getInstance(document.getElementById('eventModal')).hide();
                    }

                });

        });
    </script>
    <script>
        document.getElementById('btnInvoice').addEventListener('click', function () {

            let id = this.dataset.id;

            if (!id) {
                alert('Invoice tidak ditemukan!');
                return;
            }

            // window.open('/invoice/' + encodeURIComponent(invoice) + '/print', '_blank');
            // const id = this.dataset.id;
            window.open('/invoice/' + id + '/print', '_blank');

        });
    </script>
    <script>
        document.getElementById('btnLunas').addEventListener('click', function () {

            const id = this.dataset.id;

            if (!id) {
                alert("ID booking tidak ditemukan");
                return;
            }

            if (!confirm('Pelunasan sekarang?')) return;

            fetch(`/booking/pelunasan/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(res => res.json())
                .then(data => {

                    console.log("Response :", data);

                    if (!data.success) return;

                    let event = calendar.getEventById(id);

                    console.log("ID :", id);
                    console.log("Event :", event);

                    if (event) {
                        event.setExtendedProp('status_pembayaran', 'Lunas');
                    }

                    document.getElementById("modalStatusPembayaran").innerText = "Lunas";

                    const btnLunas = document.getElementById("btnLunas");
                    if (btnLunas) btnLunas.classList.add("d-none");

                    const btnCin = document.getElementById("btnCin");
                    if (btnCin) btnCin.classList.remove("d-none");

                    alert(data.message);

                })
                .catch(err => {
                    console.error(err);
                });

        });
    </script>
    <script>
        let selectedBooking = null;

        document.getElementById('btnTambahHari').addEventListener('click', function () {

            const id = this.dataset.id;

            if (!id) {
                alert('ID booking tidak ditemukan');
                return;
            }

            const event = calendar.getEventById(id);

            if (!event) {
                alert('Data booking tidak ditemukan');
                return;
            }

            selectedBooking = event;

            const props = event.extendedProps;

            const checkin = new Date(event.start);
            const checkout = new Date(event.end);

            // Hitung jumlah hari lama
            const diffTime = checkout - checkin;

            const hariLama = Math.ceil(
                diffTime / (1000 * 60 * 60 * 24)
            );

            if (hariLama <= 0) {
                alert('Tanggal booking tidak valid');
                return;
            }

            const totalHarga = Number(props.total_harga || 0);

            const hargaPerHari = totalHarga / hariLama;

            /*
            |--------------------------------------------------------------------------
            | Isi modal
            |--------------------------------------------------------------------------
            */

            document.getElementById('tambahVilla').innerText =
                event.title;

            document.getElementById('tambahCustomer').innerText =
                props.customer || '-';

            document.getElementById('tambahCheckoutLama').innerText =
                formatTanggal(checkout);

            document.getElementById('jumlahTambahHari').value = 1;

            document.getElementById('tambahHargaHari').value =
                formatRupiah(hargaPerHari);

            updateTambahHari();

            /*
            |--------------------------------------------------------------------------
            | Tutup modal detail
            |--------------------------------------------------------------------------
            */

            const detailModal =
                bootstrap.Modal.getInstance(
                    document.getElementById('eventModal')
                );

            if (detailModal) {
                detailModal.hide();
            }

            /*
            |--------------------------------------------------------------------------
            | Buka modal tambah hari
            |--------------------------------------------------------------------------
            */

            const tambahModal =
                new bootstrap.Modal(
                    document.getElementById('tambahHariModal')
                );

            tambahModal.show();
        });


        /*
        |--------------------------------------------------------------------------
        | Ketika jumlah hari berubah
        |--------------------------------------------------------------------------
        */

        document.getElementById('jumlahTambahHari')
            .addEventListener('input', updateTambahHari);


        function updateTambahHari() {

            if (!selectedBooking) {
                return;
            }

            const jumlahHari =
                parseInt(
                    document.getElementById('jumlahTambahHari').value
                ) || 1;

            const checkoutLama =
                new Date(selectedBooking.end);

            const checkin =
                new Date(selectedBooking.start);

            const totalHarga =
                Number(
                    selectedBooking.extendedProps.total_harga || 0
                );

            const hariLama =
                Math.ceil(
                    (checkoutLama - checkin) /
                    (1000 * 60 * 60 * 24)
                );

            if (hariLama <= 0) {
                return;
            }

            const hargaPerHari =
                totalHarga / hariLama;

            const hargaTambahan =
                hargaPerHari * jumlahHari;

            const checkoutBaru =
                new Date(checkoutLama);

            checkoutBaru.setDate(
                checkoutBaru.getDate() + jumlahHari
            );

            const totalBaru =
                totalHarga + hargaTambahan;


            document.getElementById('tambahCheckoutBaru')
                .value = formatTanggal(checkoutBaru);

            document.getElementById('tambahHargaHari')
                .value = formatRupiah(hargaPerHari);

            document.getElementById('tambahHargaTambahan')
                .value = formatRupiah(hargaTambahan);

            document.getElementById('tambahTotalBaru')
                .innerText = formatRupiah(totalBaru);
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan Tambah Hari
        |--------------------------------------------------------------------------
        */

        document.getElementById('btnSimpanTambahHari')
            .addEventListener('click', function () {

                if (!selectedBooking) {
                    alert('Booking belum dipilih');
                    return;
                }

                const id =
                    selectedBooking.id;

                const jumlahHari =
                    parseInt(
                        document.getElementById('jumlahTambahHari').value
                    );

                if (!jumlahHari || jumlahHari < 1) {
                    alert('Jumlah hari tidak valid');
                    return;
                }

                if (!confirm(
                    `Yakin ingin menambah ${jumlahHari} hari?`
                )) {
                    return;
                }

                fetch(`/booking/tambah-hari/${id}`, {

                    method: 'POST',

                    headers: {
                        'X-CSRF-TOKEN':
                            document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content,

                        'Content-Type':
                            'application/json',

                        'Accept':
                            'application/json'
                    },

                    body: JSON.stringify({
                        jumlah_hari: jumlahHari
                    })

                })
                    .then(res => res.json())

                    .then(data => {

                        if (!data.success) {
                            alert(
                                data.message ||
                                'Gagal menambahkan hari'
                            );

                            return;
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | Update event kalender
                        |--------------------------------------------------------------------------
                        */

                        const event =
                            calendar.getEventById(id);

                        if (event) {

                            event.setEnd(
                                new Date(
                                    data.data.tglcekout_baru
                                )
                            );

                            event.setExtendedProp(
                                'tglcekout',
                                data.data.tglcekout_baru
                            );

                            event.setExtendedProp(
                                'total_harga',
                                data.data.total_harga_baru
                            );

                            event.setExtendedProp(
                                'total_bayar',
                                data.data.total_bayar
                            );

                            event.setExtendedProp(
                                'status_pembayaran',
                                data.data.status_pembayaran
                            );
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | Tutup modal
                        |--------------------------------------------------------------------------
                        */

                        const modal =
                            bootstrap.Modal.getInstance(
                                document.getElementById(
                                    'tambahHariModal'
                                )
                            );

                        if (modal) {
                            modal.hide();
                        }

                        alert(data.message);

                        /*
                        |--------------------------------------------------------------------------
                        | Reset
                        |--------------------------------------------------------------------------
                        */

                        selectedBooking = null;

                    })

                    .catch(error => {

                        console.error(error);

                        alert(
                            'Terjadi kesalahan saat menambahkan hari.'
                        );

                    });

            });


        /*
        |--------------------------------------------------------------------------
        | Format Rupiah
        |--------------------------------------------------------------------------
        */

        function formatRupiah(value) {

            return 'Rp ' + Number(value || 0)
                .toLocaleString('id-ID');
        }


        /*
        |--------------------------------------------------------------------------
        | Format tanggal Indonesia
        |--------------------------------------------------------------------------
        */

        function formatTanggal(date) {

            return new Date(date).toLocaleDateString(
                'id-ID',
                {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric'
                }
            );
        }
    </script>
@endsection