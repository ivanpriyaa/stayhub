<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>StayHub</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
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
            <a class="navbar-brand josefin-sans-tulisan" href="#">
                <img src="{{ asset('images/logo.png') }}" alt="Logo StayHub" width="30" height="30"
                    class="d-inline-block align-text-top">
                Stay<span style="color: #FEBD22;">Hub</span>
            </a>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="heade">
                <div class="banner">
                    <div class="col banner-kiri">
                        <h3>Best Place to Find Comfortable Villas</h3>
                        <p class="inter-tulisan">The Smartest Way to Discover, Book, and Experience Unrivaled Comfort in
                            Handpicked Premium Villas.</p>
                    </div>
                    <div class="col banner-kanan inter-tulisan">
                        <div class="kotak">
                            <p style="color: #322F2A;font-weight: 700">Booking Villas</p>
                            <p style="margin-top: -15px;font-size: small">Let's start ordering your place to stay</p>
                            <div class="mb-3">
                                <label class="form-label" style="color: #322F2A;font-weight: 600">Location</label>
                                <input type="text" class="form-control" name="location"
                                    placeholder="Masukkan Lokasi">
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" style="color: #322F2A;font-weight: 600">Cek In</label>
                                        <input type="date" class="form-control" name="cekin"
                                            placeholder="Masukkan Lokasi">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" style="color: #322F2A;font-weight: 600">Cek
                                            Out</label>
                                        <input type="date" class="form-control" name="cekout"
                                            placeholder="Masukkan Lokasi">
                                    </div>
                                </div>
                            </div>
                            <button class="btn tombole" type="submit">Check</button>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col bestt">
                <p style="color: #FEBD22;font-weight: 700;margin-top:10%;">HOT OFFER</p>
                <h3 style="color: #322F2A;">Best offer of the month</h3>
                <p class="explore" style="width: 60%">Explore our best offer for your stay while you're on vacation with
                    family or business trip</p>
            </div>
            <div class="col beste d-flex justify-content-end align-items-center">
                <a href="/landingpage-katalogvilla" style="color: #FEBD22;font-weight: 600;margin-top:10%;">VIEW ALL</a>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <div class="swiper bestVillaSwiper">
            <div class="swiper-wrapper">

                @foreach ($bestVillas as $villa)
                    <div class="swiper-slide">
                        <div class="card carde">
                            {{-- <img src="{{ asset('images/villa/' . $villa->gambar_villa) }}" class="card-img-top"> --}}
                            {{-- <img src="{{ asset('storage/' . $villa->mainImage->image) }}" class="card-img-top"> --}}
                            {{-- <img src="{{ $villa->mainImage ? asset('storage/' . $villa->mainImage->image) : asset('images/default.jpg') }}"
                                class="card-img-top"> --}}
                            {{-- <img src="{{ $villa->mainImage ? asset('storage/' . $villa->mainImage->image) : asset('images/villa/default.jpg.png') }}"
                                class="card-img-top"> --}}
                            @php
                                $img =
                                    $villa->gambar_villa && $villa->gambar_villa != 'villa/default.jpg'
                                        ? asset('storage/' . $villa->gambar_villa)
                                        : asset('images/villa/default.jpg');
                            @endphp
                            <img src="{{ $img }}" class="card-img-top">
                            {{-- <img src="{{ $villa->gambar_villa && $villa->gambar_villa != ''
                                ? asset('storage/' . $villa->gambar_villa)
                                : asset('images/villa/default.jpg') }}"
                                class="card-img-top"> --}}
                            <div class="card-body cardb">
                                <h5 class="card-title">{{ $villa->nama_villa }}</h5>
                                <p><i class="bi bi-geo-alt" style="color:#FEBD22"></i> {{ $villa->alamat_villa }}</p>
                                <p class="bedroom"><i class="bx bx-bed"></i> {{ $villa->jumlah_kamar_tidur }} rooms</p>
                                <div class="hrga">
                                    <p class="hargaa">Rp. {{ number_format($villa->harga_villa, 0, ',', '.') }}</p>
                                    <p style="color:#959493;">
                                        <i class="bi bi-moon-stars"></i> 1/days
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <br>
    <div class="container-fluid" style="background-color: white;padding-bottom: 60px;">
        <div class="container">
            <div class="row">
                <div class="col rekom-destinasi" style="margin-top: 5%;">
                    <p style="color: #FEBD22;font-weight: 700;">RECOMMENDED DESTINATION</p>
                    <h3 style="color: #322F2A;font-size: 700;">Best destination</h3>
                </div>
            </div>
            <div class="swiper destinasiSwiper">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="img-box">
                            <img src="images/destinasi/jkt.jpg">
                            <div class="text-overlay">Jakarta</div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="img-box">
                            <img src="images/destinasi/sby.jpg">
                            <div class="text-overlay">Surabaya</div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="img-box">
                            <img src="images/destinasi/gunung-bromo.jpg">
                            <div class="text-overlay">Bromo</div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="img-box">
                            <img src="images/destinasi/medan.jpg">
                            <div class="text-overlay">Medan</div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="img-box">
                            <img src="images/destinasi/bali.jpg">
                            <div class="text-overlay">Bali</div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="img-box">
                            <img src="images/destinasi/jogja.jpg">
                            <div class="text-overlay">Jogja</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <center>
                    <p style="color: #FEBD22;font-weight: 700;">FAQS</p>
                    <h3 style="color: #322F2A;font-size: 700;">Frequently ask question</h3>
                    <p>Everything you need to know right here at your fingertips. Ask questions, browse around for
                        answers, or submit your feature request</p>
                </center>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card cardfaqs">

                        <div class="card-header faqs">

                            <button class="btn w-100 d-flex justify-content-between align-items-center collapsed"
                                data-bs-toggle="collapse" data-bs-target="#cardContent"
                                style="text-decoration:none; color:black;">

                                Featured
                                <i class="bi bi-chevron-down icon-arrow"></i>

                            </button>

                        </div>

                        <div id="cardContent" class="collapse">
                            <div class="card-body cardfaqe">
                                <h5 class="card-title">Special title treatment</h5>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col">
                    <div class="card cardfaqs">

                        <div class="card-header faqs">

                            <button class="btn w-100 d-flex justify-content-between align-items-center collapsed"
                                data-bs-toggle="collapse" data-bs-target="#cardContent2"
                                style="text-decoration:none; color:black;">

                                Featured
                                <i class="bi bi-chevron-down icon-arrow"></i>

                            </button>

                        </div>

                        <div id="cardContent2" class="collapse">
                            <div class="card-body cardfaqe">
                                <h5 class="card-title">Special title treatment</h5>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <div class="card cardfaqs">

                        <div class="card-header faqs">

                            <button class="btn w-100 d-flex justify-content-between align-items-center collapsed"
                                data-bs-toggle="collapse" data-bs-target="#cardContent3"
                                style="text-decoration:none; color:black;">

                                Featured
                                <i class="bi bi-chevron-down icon-arrow"></i>

                            </button>

                        </div>

                        <div id="cardContent3" class="collapse">
                            <div class="card-body cardfaqe">
                                <h5 class="card-title">Special title treatment</h5>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col">
                    <div class="card cardfaqs">

                        <div class="card-header faqs">

                            <button class="btn w-100 d-flex justify-content-between align-items-center collapsed"
                                data-bs-toggle="collapse" data-bs-target="#cardContent4"
                                style="text-decoration:none; color:black;">

                                Featured
                                <i class="bi bi-chevron-down icon-arrow"></i>

                            </button>

                        </div>

                        <div id="cardContent4" class="collapse">
                            <div class="card-body cardfaqe">
                                <h5 class="card-title">Special title treatment</h5>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <br>
            <div style="height: 20px"></div>
        </div>
    </div>
    <br>
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
        new Swiper(".bestVillaSwiper", {
            slidesPerView: 1,
            spaceBetween: 15,
            loop: true,
            grabCursor: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            breakpoints: {
                768: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 3
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
