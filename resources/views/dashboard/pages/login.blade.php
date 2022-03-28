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
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/font-awesome/css/all.min.css">

    <style>
        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100000;
            width: 100%;
            height: 100%;
            display: none;
            background: rgba(0, 0, 0, 0.6);
        }

        .cv-spinner {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px #ddd solid;
            border-top: 4px #2e93e6 solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }
    </style>
</head>

<body id="layout-1" data-luno="theme-blue">
    <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>
    <!-- start: body area -->
    <div class="wrapper">
        <!-- start: page body -->
        <div class="page-body auth px-xl-4 px-sm-2 px-0 py-lg-2 py-1">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-8 d-flex justify-content-center align-items-center">
                        
                            <div class="card shadow-sm w-100 p-4 p-md-5 px-md-3" style="max-width: 35rem;">
                                <div class="justify-content-center text-center">
                                    <h1>MASUK</h1>
                                    <span class="text-muted text-center">Pilih ingin masuk sebagai Keluarga/Bidan/Penyuluh BKKBN</span>
                                </div>
                                <div class="card-header justify-content-center py-4">
                                    <ul class="nav nav-tabs tab-page-toolbar rounded d-inline-flex" role="tablist">
                                        <li class="nav-item" id="keluarga"><a class="nav-link border-0" data-bs-toggle="tab" id="nav-link-keluarga" href="#nav2-home-icon" role="tab"><i class="fa-solid fa-people-roof"></i> Keluarga</a></li>
                                        <li class="nav-item" id="bidan"><a class="nav-link border-0 active"  data-bs-toggle="tab" id="nav-link-bidan" href="#nav-bidan" role="tab"><i class="fa-solid fa-user-doctor"></i> Bidan</a></li>
                                        <li class="nav-item" id="penyuluh"><a class="nav-link border-0" data-bs-toggle="tab" id="nav-link-penyuluh" href="#nav-penyuluh" role="tab"><i class="fa-solid fa-people-group"></i> Penyuluh</a></li>
                                        <li class="nav-item" id="admin"><a class="nav-link border-0" data-bs-toggle="tab" id="nav-link-admin" href="#nav-admin" role="tab"><i class="fa-solid fa-user-shield"></i> Admin</a></li>
                                    </ul>
                                </div>
                                <div class="card-body py-0">
                                    <div class="tab-content">
                                        <div class="tab-pane fade" id="nav2-home-icon" role="tabpanel">
                                            <div class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently</div>
                                        </div>
                                        <div class="tab-pane fade show active" id="nav-bidan" role="tabpanel">
                                            <form class="row g-3 w-100 justify-content-center form-login" action="/cekLogin" method="POST">
                                                <input type="hidden" id="role" class="form-control form-control" name="role" value="bidan">
                                                @csrf
                                                @if (session()->has('loginError'))
                                                <div class="alert alert-danger">
                                                    {{ session('loginError') }}
                                                </div>
                                                @endif
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nomor HP</label>
                                                        <input type="text" id="nomor-hp" name="nomor_hp" class="form-control form-control-lg angka" placeholder="0812.........">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-2">
                                                        <div class="form-label">
                                                            <span class="d-flex justify-content-between align-items-center">
                                                                Kata Sandi
                                                                <a class="text-primary" href="auth-password-reset.html">Lupa Kata Sandi?</a>
                                                            </span>
                                                        </div>
                                                        <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="***************">
                                                    </div>
                                                </div>
                                                <div class="col-12 text-center mt-4">
                                                    <button type="submit" class="btn btn-lg btn-outline-primary lift text-uppercase" href="index.html" title=""><i class="bi bi-box-arrow-in-right"></i> MASUK</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="nav-penyuluh" role="tabpanel">
                                            <form class="row g-3 w-100 justify-content-center form-login" action="/cekLogin" method="POST">
                                                <input type="hidden" id="role" class="form-control form-control" name="role" value="penyuluh">
                                                @csrf
                                                @if (session()->has('loginError'))
                                                <div class="alert alert-danger">
                                                    {{ session('loginError') }}
                                                </div>
                                                @endif
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nomor HP</label>
                                                        <input type="text" id="nomor-hp" name="nomor_hp" class="form-control form-control-lg angka" placeholder="0812.........">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-2">
                                                        <div class="form-label">
                                                            <span class="d-flex justify-content-between align-items-center">
                                                                Kata Sandi
                                                                <a class="text-primary" href="auth-password-reset.html">Lupa Kata Sandi?</a>
                                                            </span>
                                                        </div>
                                                        <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="***************">
                                                    </div>
                                                </div>
                                                <div class="col-12 text-center mt-4">
                                                    <button type="submit" class="btn btn-lg btn-outline-primary lift text-uppercase" href="index.html" title=""><i class="bi bi-box-arrow-in-right"></i> MASUK</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="nav-admin" role="tabpanel">
                                            <form class="row g-3 w-100 justify-content-center form-login" action="/cekLogin" method="POST">
                                                <input type="hidden" id="role" class="form-control form-control" name="role" value="admin">
                                                @csrf
                                                @if (session()->has('loginError'))
                                                <div class="alert alert-danger">
                                                    {{ session('loginError') }}
                                                </div>
                                                @endif
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nomor HP</label>
                                                        <input type="text" id="nomor-hp" name="nomor_hp" class="form-control form-control-lg angka" placeholder="0812.........">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="mb-2">
                                                        <div class="form-label">
                                                            <span class="d-flex justify-content-between align-items-center">
                                                                Kata Sandi
                                                                <a class="text-primary" href="auth-password-reset.html">Lupa Kata Sandi?</a>
                                                            </span>
                                                        </div>
                                                        <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="***************">
                                                    </div>
                                                </div>
                                                <div class="col-12 text-center mt-4">
                                                    <button type="submit" class="btn btn-lg btn-outline-primary lift text-uppercase" href="index.html" title=""><i class="bi bi-box-arrow-in-right"></i> MASUK</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12 text-center mt-4">
                                    <span class="text-muted">Belum Punya Akun? <a href="auth-signup.html">Daftar disini</a></span>
                                </div>
                            </div>
                    </div>
                </div> <!-- End Row -->
            </div>
        </div>

    </div>

<!-- Jquery Core Js -->
<script src="{{ asset('assets/dashboard')}}/font-awesome/js/all.min.js"></script>
<script src="{{ asset('assets/dashboard')}}/bundles/sweetalert2.bundle.js"></script>
<script src="{{ asset('assets/dashboard')}}/bundles/libscripts.bundle.js"></script>
<script src="{{asset('assets/dashboard')}}/js/jquery.mask.min.js"></script>

<!-- Jquery Page Js -->

<script>
    $('.angka').mask('00000000000000000000');
    // if nav-item change
    $('.nav-item').click(function(){
        $('.nav-item').removeClass('active');
        $(this).addClass('active');

    });

    document.getElementById("nomor-hp").focus();

    $('.form-login').submit(function(e){
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();
        $.ajax({
            url: url,
            type: 'POST',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            data: data,
            success: function(response){
                if(response.res == 'berhasil'){
                    window.location.href = "{{url('/dashboard')}}";
                }  
                if (response.res == 'tidak_aktif'){
                    Swal.fire(
                        'Tidak dapat masuk!',
                        response.mes,
                        'error'
                    )
                }  
                if (response.res == 'gagal'){
                    Swal.fire(
                        'Terjadi Kesalahan!',
                        response.mes,
                        'error'
                    )
                }
            }
        });
    });

    var overlay = $('#overlay').hide();
    $(document)
        .ajaxStart(function() {
            overlay.show();
        })
        .ajaxStop(function() {
            overlay.hide();
        });
    
    
</script>

</body>
</html>