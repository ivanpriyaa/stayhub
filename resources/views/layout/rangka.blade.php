<!DOCTYPE html>
<html lang="en">

@include('layout.head')

<body>

    <div class="d-flex">

        <!-- Sidebar -->
        <div class="sidebar d-none d-md-block">
            <h4 class="inria-serif-bold logo mb-0" style="text-align: center;">StayHub</h4>
            <h4 class="itim-regular tagline" style="text-align: center;">Smart Booking Management</h4>
            <ul class="nav flex-column p-2">
                <li class="nav-item mb-1">
                    <a href="{{ url('/dashboard') }}" class="nav-link inria-sans-regular"><i class="bi bi-house-door"></i></span> Home</a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ url('/customer') }}" class="nav-link inria-sans-regular"><i class="bi bi-people"></i></span> Customer</a>
                </li>
                <li class="nav-item mb-1">
                    <a href="#" class="nav-link inria-sans-regular"><i class="bi bi-buildings"></i></span> Villa Inventory</a>
                </li>
                <li class="nav-item mb-1">
                    <a href="#" class="nav-link inria-sans-regular"><i class="bi bi-person"></i></span> Users</a>
                </li>
                <li class="nav-item mb-1">
                    <form id="logout-form" method="POST" action="{{ route('logout') }}">
                        @csrf
                    </form>
                    <a href="#" class="nav-link inria-sans-regular" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-left"></i> Logout
                    </a>
                </li>
            </ul>
        </div>

        <!-- Konten -->
        <div class="content flex-grow-1 p-3">
            <!-- Tombol sidebar mobile -->
            <button class="btn d-md-none mb-3" id="toggleSidebar" style="background-color: #8A7650;color: #fff;">☰ Menu</button>

            @yield('content')
        </div>

    </div>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>

    <!-- Script untuk toggle sidebar di mobile -->
    <script>
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.querySelector('.sidebar');

        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('d-none');
        });
    </script>
</body>

</html>