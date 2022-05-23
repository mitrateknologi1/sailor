<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SI GERCEP STUNTING</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    {{-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/landingPage') }}/media/favicon.png"> --}}
    <link rel="shortcut icon" href="{{ asset('assets/favicon') }}/favicon.ico" type="image/x-icon" />

    <link rel="stylesheet" href="{{ asset('assets/landingPage') }}/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/landingPage') }}/css/vendor/font-awesome.css">
    {{-- <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/font-awesome/css/all.min.css"> --}}

    <link rel="stylesheet" href="{{ asset('assets/landingPage') }}/css/vendor/slick.css">
    <link rel="stylesheet" href="{{ asset('assets/landingPage') }}/css/vendor/slick-theme.css">
    <link rel="stylesheet" href="{{ asset('assets/landingPage') }}/css/vendor/sal.css">
    <link rel="stylesheet" href="{{ asset('assets/landingPage') }}/css/vendor/magnific-popup.css">
    <link rel="stylesheet" href="{{ asset('assets/landingPage') }}/css/vendor/green-audio-player.min.css">
    <link rel="stylesheet" href="{{ asset('assets/landingPage') }}/css/vendor/odometer-theme-default.css">

    <!-- Site Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/landingPage') }}/css/app.css">
    <style>
        .my_switcher {
            top: 120px;
        }

        @media only screen and (min-width: 991px) and (max-width: 1200px) {
            .banner.banner-style-4 .banner-thumbnail {
                right: -300px;
                top: 430px;
            }
        }


        @media only screen and (min-width: 1200px) and (max-width: 2000px) {
            .banner.banner-style-4 .banner-thumbnail {
                right: -110px;
                top: 430px;
            }
        }

        @media only screen and (min-width: 1600px) and (max-width: 1720px) {
            .banner.banner-style-4 .banner-thumbnail {
                right: 15px;
                top: 530px
            }
        }


        @media only screen and (min-width: 1720px) and (max-width: 5599px) {
            .banner.banner-style-4 .banner-thumbnail {
                right: 70px;
                top: 500px
            }
        }

        @media (min-width: 1720px) {

            .container,
            .container-lg,
            .container-md,
            .container-sm,
            .container-xl,
            .container-xxl {
                width: 1300px;
                max-width: 1800px;
            }
        }

    </style>

</head>

<body class="sticky-header">
    <!--[if lte IE 9]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->
    <a href="#main-wrapper" id="backto-top" class="back-to-top">
        <i class="fa-solid fa-angles-up"></i>
    </a>

    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->

    <div class="my_switcher d-none d-lg-block">
        <ul>
            <li title="Light Mode">
                <a href="javascript:void(0)" class="setColor light" data-theme="light">
                    <i class="fal fa-lightbulb-on"></i>
                </a>
            </li>
            <li title="Dark Mode">
                <a href="javascript:void(0)" class="setColor dark" data-theme="dark">
                    <i class="fas fa-moon"></i>
                </a>
            </li>
        </ul>
    </div>

    <div id="main-wrapper" class="main-wrapper">

        <!--=====================================-->
        <!--=        Header Area Start       	=-->
        <!--=====================================-->
        <header class="header axil-header header-style-1">
            <div id="axil-sticky-placeholder"></div>
            <div class="axil-mainmenu">
                <div class="container">
                    <div class="header-navbar">
                        <div class="header-logo">
                            <a href="index-1.html"><img class="light-version-logo"
                                    src="{{ asset('assets/logo') }}/logo1.png" alt="logo" width="280em"></a>
                            <a href="index-1.html"><img class="dark-version-logo"
                                    src="{{ asset('assets/logo') }}/logo2.png" alt="logo" width="280em"></a>
                            <a href="index-1.html"><img class="sticky-logo"
                                    src="{{ asset('assets/logo') }}/logo1.png" alt="logo" width="280em"></a>
                        </div>
                        <div class="header-main-nav">
                            <!-- Start Mainmanu Nav -->
                            <nav class="mainmenu-nav" id="mobilemenu-popup">
                                <div class="d-block d-lg-none">
                                    <div class="mobile-nav-header">
                                        <div class="mobile-nav-logo">
                                            <a href="index-1.html">
                                                <img class="light-mode"
                                                    src="{{ asset('assets/logo') }}/logo1.png" alt="Site Logo">
                                                <img class="dark-mode"
                                                    src="{{ asset('assets/logo') }}/logo2.png" alt="Site Logo">
                                            </a>
                                        </div>
                                        <button class="mobile-menu-close" data-bs-dismiss="offcanvas"><i
                                                class="fas fa-times"></i></button>
                                    </div>
                                </div>

                                <ul class="mainmenu">
                                    {{-- if guest --}}
                                    @if (Auth::guest())
                                        <li><a href="{{ url('/login') }}"><i
                                                    class="fa-solid fa-arrow-right-to-bracket"></i> LOGIN</a></li>
                                    @else
                                        <li><a href="{{ url('/dashboard') }}"><i class="fa-solid fa-gauge-high"></i>
                                                DASHBOARD</a></li>
                                    @endif
                                </ul>
                            </nav>
                            <!-- End Mainmanu Nav -->
                        </div>
                        <div class="header-action">
                            <ul class="list-unstyled">
                                <li class="mobile-menu-btn sidemenu-btn d-lg-none d-block">
                                    <button class="btn-wrap" data-bs-toggle="offcanvas"
                                        data-bs-target="#mobilemenu-popup">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </button>
                                </li>
                                <li class="my_switcher d-block d-lg-none">
                                    <ul>
                                        <li title="Light Mode">
                                            <a href="javascript:void(0)" class="setColor light active"
                                                data-theme="light">
                                                <i class="fal fa-lightbulb-on"></i>
                                            </a>
                                        </li>
                                        <li title="Dark Mode">
                                            <a href="javascript:void(0)" class="setColor dark" data-theme="dark">
                                                <i class="fas fa-moon"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!--=====================================-->
        <!--=        Banner Area Start         =-->
        <!--=====================================-->
        <section class="banner banner-style-4 pb-2">
            <div class="container">
                <div class="banner-content">
                    <span class="subtitle" style="color: #c75c6f" data-sal="slide-down" data-sal-duration="1000"
                        data-sal-delay="100">DETEKSI STUNTING &#9679; MOMS CARE &#9679; TUMBUH
                        KEMBANG &#9679; RANDA KABILASA</span>
                    <h2 class="title mb-0" data-sal="slide-right" data-sal-duration="1000" data-sal-delay="100">SI
                        GERCEP <br> STUNTING</h2>
                    <h5 class="text-muted mb-5" data-sal="slide-right" data-sal-duration="1000" data-sal-delay="100">
                        (Sistem Informasi Gerakan Cepat Penurunan Stunting)</h5>
                    <div data-sal="slide-up" data-sal-duration="1000" data-sal-delay="200" class="mb-2">
                        @if (Auth::guest())
                            <a href="{{ url('login') }}" class="axil-btn btn-fill-primary"><i
                                    class="fa-solid fa-arrow-right-to-bracket"></i> LOGIN</a>
                        @else
                            <a href="{{ url('dashboard') }}" class="axil-btn btn-fill-primary"><i
                                    class="fa-solid fa-gauge-high"></i> DASHBOARD</a>
                        @endif
                    </div>
                </div>
                <div class="banner-thumbnail">
                    <div class="large-thumb" data-sal="slide-left" data-sal-duration="800" data-sal-delay="400">
                        <img class="paralax-image" src="{{ asset('assets/landingPage') }}/preview/peta.png"
                            alt="Shape" style="max-width: 50em">
                    </div>
                </div>
            </div>

            <ul class="list-unstyled shape-group-19">
                <li class="shape shape-1" data-sal="slide-down" data-sal-duration="500" data-sal-delay="100">
                    <img src="{{ asset('assets/landingPage') }}/media/others/bubble-29.png" alt="Bubble">
                </li>
                <li class="shape shape-2" data-sal="slide-left" data-sal-duration="500" data-sal-delay="200">
                    <img src="{{ asset('assets/landingPage') }}/media/others/line-7.png" alt="Bubble">
                </li>
            </ul>
        </section>
        <!--=====================================-->
        <!--=        Project Area Start         =-->
        <!--=====================================-->
        <section class="section section-padding bg-color-ship-gray">
            <div class="container">
                <div class="section-heading heading-light" data-sal="slide-down" data-sal-duration="1000"
                    data-sal-delay="100">
                    {{-- <span class="subtitle">Featured Case Study</span> --}}
                    <h2 class="title">Total Data Tiap Fitur</h2>
                    <p>DETEKSI STUNTING &#9679; MOMS CARE &#9679; TUMBUH
                        KEMBANG &#9679; RANDA KABILASA</p>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-6 " data-sal="slide-up" data-sal-duration="800" data-sal-delay="100">
                        <div class="counterup-progress active">
                            <div class="icon text-white">
                                <i class="fa-solid fa-children fa-xl"></i>
                            </div>
                            <div class="count-number h2">
                                <span class="number count odometer odometer-auto-theme"
                                    data-count="{{ $stuntingAnakCount }}">
                                </span>
                            </div>
                            <span class="text-muted mb-1">Deteksi Stunting</span>
                            <h6 class="title">Stunting Anak</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 " data-sal="slide-up" data-sal-duration="800" data-sal-delay="200">
                        <div class="counterup-progress">
                            <div class="icon text-white">
                                <i class="fa-solid fa-person-pregnant fa-xl"></i>
                            </div>
                            <div class="count-number h2">
                                <span class="number count odometer odometer-auto-theme"
                                    data-count="{{ $deteksiIbuMelahirkanStuntingCount }}">
                                </span>
                            </div>
                            <span class="text-muted mb-1">Deteksi Stunting</span>
                            <h6 class="title">Deteksi Ibu Melahirkan Stunting</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 " data-sal="slide-up" data-sal-duration="800" data-sal-delay="300">
                        <div class="counterup-progress">
                            <div class="icon text-white">
                                <i class="fa-solid fa-calendar-day fa-xl"></i>
                            </div>
                            <div class="count-number h2">
                                <span class="number count odometer odometer-auto-theme"
                                    data-count="{{ $perkiraanMelahirkanCount }}">
                                </span>
                            </div>
                            <span class="text-muted mb-1">Moms Care</span>
                            <h6 class="title">Perkiraan Melahirkan</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 " data-sal="slide-up" data-sal-duration="800" data-sal-delay="400">
                        <div class="counterup-progress">
                            <div class="icon text-white">
                                <i class="fa-solid fa-clipboard-list fa-xl"></i>
                            </div>
                            <div class="count-number h2">
                                <span class="number count odometer odometer-auto-theme"
                                    data-count="{{ $deteksiDiniCount }}">
                                </span>
                            </div>
                            <span class="text-muted mb-1">Moms Care</span>
                            <h6 class="title">Deteksi Dini</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 " data-sal="slide-up" data-sal-duration="800" data-sal-delay="400">
                        <div class="counterup-progress">
                            <div class="icon text-white">
                                <i class="fa-solid fa-stethoscope fa-xl"></i>
                            </div>
                            <div class="count-number h2">
                                <span class="number count odometer odometer-auto-theme"
                                    data-count="{{ $ancCount }}">
                                </span>
                            </div>
                            <span class="text-muted mb-1">Moms Care</span>
                            <h6 class="title">ANC</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6" data-sal="slide-up" data-sal-duration="800" data-sal-delay="400">
                        <div class="counterup-progress">
                            <div class="icon text-white">
                                <i class="fa-solid fa-child fa-xl"></i>
                            </div>
                            <div class="count-number h2">
                                <span class="number count odometer odometer-auto-theme"
                                    data-count="{{ $pertumbuhanAnakCount }}">
                                </span>
                            </div>
                            <span class="text-muted mb-1">Tumbuh Kembang</span>
                            <h6 class="title">Pertumbuhan Anak</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 " data-sal="slide-up" data-sal-duration="800" data-sal-delay="400">
                        <div class="counterup-progress">
                            <div class="icon text-white">
                                <i class="fa-solid fa-person-biking fa-xl"></i>
                            </div>
                            <div class="count-number h2">
                                <span class="number count odometer odometer-auto-theme"
                                    data-count="{{ $perkembanganAnakCount }}">
                                </span>
                            </div>
                            <span class="text-muted mb-1">Tumbuh Kembang</span>
                            <h6 class="title">Perkembangan Anak</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 " data-sal="slide-up" data-sal-duration="800" data-sal-delay="400">
                        <div class="counterup-progress">
                            <div class="icon text-white">
                                <i class="fa-solid fa-carrot fa-xl"></i>
                            </div>
                            <div class="count-number h2">
                                <span class="number count odometer odometer-auto-theme"
                                    data-count="{{ $mencegahMalnutrisi }}">
                                </span>
                            </div>
                            <span class="text-muted mb-1">Randa Kabilasa</span>
                            <h6 class="title">Mencegah Malnutirisi</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 " data-sal="slide-up" data-sal-duration="800" data-sal-delay="400">
                        <div class="counterup-progress">
                            <div class="icon text-white">
                                <i class="fa-solid fa-chess fa-xl"></i>
                            </div>
                            <div class="count-number h2">
                                <span class="number count odometer odometer-auto-theme"
                                    data-count="{{ $meningkatkanLifeSkillCount }}">
                                </span>
                            </div>
                            <span class="text-muted mb-1">Randa Kabilasa</span>
                            <h6 class="title">Meningkatkan Life Skill</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 " data-sal="slide-up" data-sal-duration="800" data-sal-delay="400">
                        <div class="counterup-progress">
                            <div class="icon text-white">
                                <i class="fa-solid fa-ring fa-xl"></i>
                            </div>
                            <div class="count-number h2">
                                <span class="number count odometer odometer-auto-theme"
                                    data-count="{{ $mencegahPernikahanDini }}">
                                </span>
                            </div>
                            <span class="text-muted mb-1">Randa Kabilasa</span>
                            <h6 class="title">Mencegah Pernikahan Dini</h6>
                        </div>
                    </div>

                </div>
            </div>
            <ul class="list-unstyled shape-group-10">
                <!-- <li class="shape shape-1"><img src="{{ asset('assets/landingPage') }}/media/others/line-9.png" alt="Circle"></li> -->
                <li class="shape shape-2"><img src="{{ asset('assets/landingPage') }}/media/others/bubble-42.png"
                        alt="Circle"></li>
                <li class="shape shape-3"><img src="{{ asset('assets/landingPage') }}/media/others/bubble-43.png"
                        alt="Circle"></li>
            </ul>
        </section>
        <!--=====================================-->
        <!--=        Testimonial Area Start      =-->
        <!--=====================================-->
        <section class="section section-padding py-5 pb--80 pb_lg--40 pb_md--20 pb_sm--0">
            <div class="container">
                <div class="section-heading heading-left mb-4" data-sal="slide-down" data-sal-duration="1000"
                    data-sal-delay="100">
                    <span class="subtitle">Preview</span>
                    <h3 class="title mb-0">Dashboard &amp; Peta</h3>
                </div>
                <div class="row row-45">
                    <div class="col-md-6" data-sal="slide-right" data-sal-duration="800">
                        <div class="project-grid project-style-2 mb-0">
                            <div class="thumbnail">
                                <img src="{{ asset('assets/landingPage') }}/preview/dashboard.png" alt="dashboard">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" data-sal="slide-left" data-sal-duration="800" data-sal-delay="200">
                        <div class="project-grid project-style-2 mb-0">
                            <div class="thumbnail">
                                <img src="{{ asset('assets/landingPage') }}/preview/peta.png" alt="dashboard">
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <!--=====================================-->
        <!--=        Footer Area Start       	=-->
        <!--=====================================-->
        <footer class="footer-area">
            <div class="container">
                <hr>
                <div class="row">
                    <div class="col-12 col-md-6 text-center aos-init aos-animate" data-sal="slide-right"
                        data-sal-duration="500" data-sal-delay="100">

                        <!-- Icon -->
                        <div class="icon text-danger mb-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <g fill="none" fill-rule="evenodd">
                                    <path d="M0 0h24v24H0z"></path>
                                    <path d="M18 2h2a3 3 0 013 3v14a3 3 0 01-3 3h-2V2z" fill="#335EEA" opacity=".3">
                                    </path>
                                    <path
                                        d="M5 2h12a3 3 0 013 3v14a3 3 0 01-3 3H5a1 1 0 01-1-1V3a1 1 0 011-1zm7 9a2 2 0 100-4 2 2 0 000 4zm-5 5.5c-.011.162.265.5.404.5h9.177c.418 0 .424-.378.418-.5-.163-3.067-2.348-4.5-5.008-4.5-2.623 0-4.775 1.517-4.99 4.5z"
                                        fill="#335EEA"></path>
                                </g>
                            </svg>
                        </div>

                        <!-- Heading -->
                        <h4 class="mb-3">
                            Kontak
                        </h4>

                        <!-- Text -->
                        <p class="text-muted mb-0 mb-md-0">
                        </p>
                        <ul class="list-unstyled text-muted mb-6 mb-md-8 mb-lg-0">
                            <li class="mb-1">
                                <span class="fe fe-mail"></span> p2kb@sultengprov.go.id
                            </li>
                            <li>
                                <i class="fe fe-globe"></i> disp2kb.sultengprov.go.id
                            </li>
                        </ul>
                        <p></p>

                    </div>
                    <div class="col-12 col-md-6 text-center aos-init aos-animate mb-4" data-sal="slide-left"
                        data-sal-duration="500" data-sal-delay="100">

                        <!-- Icon -->
                        <div class="icon text-danger mb-3">
                            <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <g fill="none" fill-rule="evenodd">
                                    <path d="M0 0h24v24H0z"></path>
                                    <path
                                        d="M12 21a9 9 0 110-18 9 9 0 010 18zm2.165-13.645l-4.554 3.007a.5.5 0 00-.224.388l-.327 5.448a.5.5 0 00.775.447l4.554-3.007a.5.5 0 00.224-.388l.327-5.448a.5.5 0 00-.775-.447z"
                                        fill="#335EEA"></path>
                                </g>
                            </svg>
                        </div>

                        <!-- Heading -->
                        <h4 class="mb-3">
                            Alamat
                        </h4>

                        <!-- Text -->
                        <p class="text-muted mb-0">
                            <i class="fe fe-map-pin"></i> Jl. R.A. Kartini No.100, Lolu Sel., Kec. Palu Sel., Kota
                            Palu, Sulawesi Tengah 94111
                        </p>

                    </div>
                </div> <!-- / .row -->
            </div>

            <div class="container">
                <div class="footer-bottom text-center" data-sal="slide-up" data-sal-duration="500"
                    data-sal-delay="100">
                    <div class="row">
                        <div class="col">
                            <div class="footer-copyright">
                                <span class="copyright-text">© @php
                                    echo date('Y');
                                @endphp . <a
                                        href="https://disp2kb.sultengprov.go.id/" target="_blank">Dinas Pengendalian
                                        Penduduk dan
                                        Keluarga Berencana Sulawesi Tengah</a>.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>




    </div>

    <!-- Jquery Js -->
    <script src="{{ asset('assets/landingPage') }}/js/vendor/jquery-3.6.0.min.js"></script>

    <script src="{{ asset('assets/landingPage') }}/js/vendor/bootstrap.min.js"></script>
    <script src="{{ asset('assets/landingPage') }}/js/vendor/isotope.pkgd.min.js"></script>
    <script src="{{ asset('assets/landingPage') }}/js/vendor/imagesloaded.pkgd.min.js"></script>
    <script src="{{ asset('assets/landingPage') }}/js/vendor/odometer.min.js"></script>
    <script src="{{ asset('assets/landingPage') }}/js/vendor/jquery-appear.js"></script>
    <script src="{{ asset('assets/landingPage') }}/js/vendor/slick.min.js"></script>
    <script src="{{ asset('assets/landingPage') }}/js/vendor/sal.js"></script>
    <script src="{{ asset('assets/landingPage') }}/js/vendor/jquery.magnific-popup.min.js"></script>
    <script src="{{ asset('assets/landingPage') }}/js/vendor/js.cookie.js"></script>
    <script src="{{ asset('assets/landingPage') }}/js/vendor/jquery.style.switcher.js"></script>
    <script src="{{ asset('assets/landingPage') }}/js/vendor/jquery.countdown.min.js"></script>
    <script src="{{ asset('assets/landingPage') }}/js/vendor/tilt.js"></script>
    <script src="{{ asset('assets/landingPage') }}/js/vendor/green-audio-player.min.js"></script>
    <script src="{{ asset('assets/landingPage') }}/js/vendor/jquery.nav.js"></script>

    <script src="{{ asset('assets/dashboard') }}/font-awesome/js/all.min.js"></script>
    <!-- Site Scripts -->
    <script src="{{ asset('assets/landingPage') }}/js/app.js"></script>
</body>

</html>
