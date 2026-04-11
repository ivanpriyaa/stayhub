<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>StayHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inria+Sans:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Inria+Serif:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Itim&family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Noto+Rashi+Hebrew:wght@100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href='https://unpkg.com/boxicons@latest/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/stylelanding.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
</head>

<body>
    {{-- NAV --}}
    <nav class="navbar sticky-top nave">
        <div class="container-fluid">
            <a class="navbar-brand josefin-sans-tulisan" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Logo StayHub" width="30" height="30"
                    class="d-inline-block align-text-top">
                Stay<span style="color: #FEBD22;">Hub</span>
            </a>
        </div>
    </nav>
    <br>
    <div class="container">
        <div class="row">
            @foreach ($villas as $villa)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('images/' . $villa->gambar) }}" class="card-img-top">

                        <div class="card-body">
                            <h5>{{ $villa->nama_villa }}</h5>
                            <p>📍 {{ $villa->lokasi }}</p>
                            <p class="text-primary fw-bold">
                                Rp {{ number_format($villa->harga, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="card-footer bg-white border-0">
                            <a href="#" class="btn btn-primary w-100">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="container-fluid" style="background-color: #322F2A">
        <div class="container">
            <div class="row">
                <div class="col"></div>
                <div class="col"></div>
            </div>
            <div class="row">
                <div class="col">
                    <h3 class="logo-footer" style="color: white;display: flex;align-items: center;"><span><img
                                src="images/logo.png" width="50" alt="stayhub"></span> StayHub</h3>
                    <p class="text-footer" style="color: #959493;">A Join venture is an application to collect fees
                        from an agreed plan</p>
                </div>
                <div class="col"></div>
            </div>
            <hr style="color: #959493">
            <div class="row">
                <div class="copyright">
                    <p style="color: #959493;text-align: center"><i class="bi bi-c-circle"></i> Copyright 2026 Ipong.
                        All right reserved</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        new Swiper(".destinasiSwiper", {
            slidesPerView: 2, // HP 2 kolom
            spaceBetween: 15,
            loop: true,
            grabCursor: true,

            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },

            breakpoints: {
                768: {
                    slidesPerView: 3
                },
                1024: {
                    slidesPerView: 4
                }
            }
        });
    </script>

    <script>
        new Swiper(".villaSwiper", {
            slidesPerView: 2, // HP = 2 card
            spaceBetween: 15,
            loop: true,
            grabCursor: true,

            //   autoplay: {
            //     delay: 2500,
            //     disableOnInteraction: false,
            //   },

            breakpoints: {
                768: {
                    slidesPerView: 3
                },
                1024: {
                    slidesPerView: 3
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>
