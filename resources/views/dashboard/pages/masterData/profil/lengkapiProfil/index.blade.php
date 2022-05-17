<!doctype html>
<html class="no-js " lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 admin template and web Application ui kit.">
    <meta name="keyword"
        content="LUNO, Bootstrap 5, ReactJs, Angular, Laravel, VueJs, ASP .Net, Admin Dashboard, Admin Theme, HRMS, Projects">
    <title>:: LUNO ::</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon"> <!-- Favicon-->

    <!-- project css file  -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/css/luno.style.min.css">
</head>

<body id="layout-1" data-luno="theme-blue">

    <!-- start: body area -->
    <div class="wrapper">

        <!-- start: page body -->
        <div class="page-body auth px-xl-4 px-sm-2 px-0 py-lg-2 py-1">
            <div class="container-fluid">
                <div class="row">
                    <div class="col d-flex justify-content-center align-items-center">
                        <div class="card shadow-sm w-100 p-4 p-md-5" style="max-width: 32rem;">
                            <!-- Form -->
                            <form class="row g-3">
                                <div class="col-12 text-center mb-4">
                                    <img src="{{ asset('assets/dashboard') }}/images/auth-404.svg"
                                        class="w240 mb-4" alt="" />
                                    <h1 class="display-1">404</h1>
                                    <h5>Profil akun ini belum ada</h5>
                                    <span class="text-muted">Silahkan hubungi admin untuk melengkapi profil
                                        anda</span>
                                </div>
                                <div class="col-12 text-center">
                                    <a href="{{ url('logout') }}" title=""
                                        class="btn btn-lg btn-block btn-dark lift text-uppercase">LOGOUT</a>
                                </div>
                            </form>
                            <!-- End Form -->
                        </div>
                    </div>
                </div> <!-- End Row -->

            </div>
        </div>

    </div>

    <!-- Jquery Core Js -->
    <script src="{{ asset('assets/dashboard') }}/bundles/libscripts.bundle.js"></script>


    <!-- Jquery Page Js -->

</body>

</html>
