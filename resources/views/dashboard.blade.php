@extends('layout.rangka')

@section('title', 'Dashboard - StayHub')

@section('content')
<h1>Dashboard</h1>

<div class="row mt-4">
    <div class="col-md-4 mb-2">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title inria-sans-bold" style="display: flex;justify-content: space-between;">Total Booking<span style="color: #8A7650;"><i class="bi bi-cash-stack"></i></span></h5>
                <p class="card-text" style="font-size: 30px;font-weight: 700;">{{ $booking }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-2">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title inria-sans-bold" style="display: flex;justify-content: space-between;">Card title<span style="color: #8A7650;"><i class="bi bi-cash-stack"></i></span></h5>
                <p class="card-text" style="font-size: 30px;font-weight: 700;">Rp 1jt</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-2">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title inria-sans-bold" style="display: flex;justify-content: space-between;">Card title<span style="color: #8A7650;"><i class="bi bi-cash-stack"></i></span></h5>
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

    document.addEventListener('DOMContentLoaded', function() {

        let calendarEl = document.getElementById('calendar');

        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 650,
            headerToolbar: false,
            
            datesSet: function(info) {
                document.getElementById("calendarTitle").innerText = info.view.title;
            }
        });

        calendar.render();

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
    }
</script>
@endsection