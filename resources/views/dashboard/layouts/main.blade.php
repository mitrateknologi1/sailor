<!doctype html>
<html class="no-js " lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 admin template and web Application ui kit.">
    <meta name="keyword"
        content="LUNO, Bootstrap 5, ReactJs, Angular, Laravel, VueJs, ASP .Net, Admin Dashboard, Admin Theme, HRMS, Projects">
    <title>SI GERCEP STUNTING | @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('assets/favicon') }}/favicon.ico" type="image/x-icon" />


    <!-- plugin css file  -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/css/daterangepicker.min.css">
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/css/dataTables.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/datatables/buttons.dataTables.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/css/select2.min.css">

    <!-- project css file  -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/css/luno.style.min.css">
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/css/bootstrap-datepicker.css">

    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
    <link rel="stylesheet"
        href="https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css" />

    <style>
        /* .dropdown-menu.datepicker td,
        .dropdown-menu.datepicker th {
            width: 28px;
            height: 28px;
        } */

        .dropdown-menu {
            position: absolute;
            z-index: 1000;
            display: none;
            min-width: 10rem;
            padding: .5rem 0;
            margin: 0;
            font-size: 1rem;
            color: #212529;
            text-align: left;
            list-style: none;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(25, 26, 28, .15);
            border-radius: .25rem;
            z-index: 999999 !important;
        }

        @media only screen and (max-width: 567px) {
            .pulse-ring {
                left: -2px !important;
            }
        }

        .select2+.select2-container .select2-selection {
            border-radius: 1.5rem;
        }

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

        @keyframes sp-anime {
            100% {
                transform: rotate(360deg);
            }
        }

        @media screen and (max-width:600px) {
            .dataTables_filter {
                margin-top: 10px;
            }
        }

        .dataTables_filter {
            display: inline !important;
            float: right !important;
        }

        .dataTables_filter.col-sm {
            margin-top: 10px;
        }

        .dt-buttons {
            display: inline !important;

            margin-left: 10px !important;
            float: left !important;
            ;

        }

        .dt-button-collection {
            margin-top: 10px !important;
            margin-bottom: 10px !important;
        }

        .buttons-columnVisibility {
            margin-bottom: 5px;
            background-color: rgba(var(--danger-rgb), 0.15);
            color: var(--danger-color);
            border-color: transparent;
            display: inline-block;
            font-weight: 400;
            line-height: 1.5;
            ont-size: 14px;
            border-radius: 2rem;
            padding: .25rem .5rem;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            user-select: none;
            border: 0.1px solid grey;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .buttons-columnVisibility:hover {
            background-color: rgba(var(--primary-rgb), 0.15);
            color: var(--primary-color);
            border: 0.1px solid transparent;
        }

        .dt-button-collection .active {
            margin-bottom: 5px;
            background-color: rgba(var(--primary-rgb), 0.15);
            color: var(--primary-color);
            border-color: transparent;
            display: inline-block;
            font-weight: 400;
            line-height: 1.5;
            ont-size: 14px;
            border-radius: 2rem;
            padding: .25rem .5rem;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            border-top-color: transparent;
            border-right-color: transparent;
            border-bottom-color: transparent;
            border-left-color: transparent;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .dataTables_length {
            display: inline !important;
            margin-bottom: 5px !important;
            float: left;
        }

        .paginate_button {
            font-size: 12px !important;
        }

        .dataTables_paginate {
            margin-top: 10px !important;
        }

        /* untuk input foto */
        .file-input input {
            height: 25px !important;
        }

    </style>
    @stack('style')

</head>

<body class="layout-1" data-luno="theme-blue">
    <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>

    @include('dashboard.layouts.sidebar')
    <!-- start: body area -->
    <div class="wrapper">
        @include('dashboard.layouts.header')
        <!-- start: page toolbar -->
        {{-- @if (Auth::user()->role != 'keluarga') --}}
        <div class="page-toolbar px-xl-0 px-sm-2 px-0 py-3">
            <div class="container-fluid">
                <div class="row align-items-center">
                    @yield('breadcrumb')
                </div>
                @if (Auth::user()->role != 'keluarga')
                    <div class="row align-items-center mt-3">
                        <div class="col-12">
                            <h4 class="color-900 mt-2 mb-0">@yield('title') @yield('tombol_kembali')</h4>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        {{-- @else
            <div class="mt-4">

            </div>
        @endif --}}

        <!-- start: page body -->
        <div class="page-body px-xl-0 px-sm-2 px-0 py-lg-1 pb-3 mt-0">
            <div class="container-fluid pb-3">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Modal: Setting -->
    <div class="modal fade" id="SettingsModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-vertical right-side modal-dialog-scrollable">
            <div class="modal-content">

                <div class="px-xl-4 modal-header">
                    <h5 class="modal-title">Theme Setting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="px-xl-4 modal-body custom_scroll">
                    <!-- start: Light/dark -->
                    <div class="card fieldset border setting-mode mb-4">
                        <span class="fieldset-tile bg-card">Light/Dark & Contrast Layout</span>
                        <div class="c_radio d-flex text-center">
                            <label class="m-1 theme-switch" for="theme-switch">
                                <input type="checkbox" id="theme-switch" />
                                <span class="card p-2">
                                    <img class="img-fluid"
                                        src="{{ asset('assets/dashboard') }}/images/dark-version.svg"
                                        alt="Dark Mode" />
                                </span>
                            </label>
                            <label class="m-1 theme-dark" for="theme-dark">
                                <input type="checkbox" id="theme-dark" />
                                <span class="card p-2">
                                    <img class="img-fluid"
                                        src="{{ asset('assets/dashboard') }}/images/dark-theme.svg"
                                        alt="Theme Dark Mode" />
                                </span>
                            </label>
                            <label class="m-1 theme-high-contrast" for="theme-high-contrast">
                                <input type="checkbox" id="theme-high-contrast" />
                                <span class="card p-2">
                                    <img class="img-fluid"
                                        src="{{ asset('assets/dashboard') }}/images/high-version.svg"
                                        alt="High Contrast" />
                                </span>
                            </label>
                            <label class="m-1 theme-rtl" for="theme-rtl">
                                <input type="checkbox" id="theme-rtl" />
                                <span class="card p-2">
                                    <img class="img-fluid"
                                        src="{{ asset('assets/dashboard') }}/images/rtl-version.svg"
                                        alt="RTL Mode!" />
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="{{ asset('assets/dashboard') }}/bundles/libscripts.bundle.js"></script>

    <!-- Plugin Js -->
    {{-- <script src="{{ asset('assets/dashboard') }}/bundles/apexcharts.bundle.js"></script> --}}
    <script src="{{ asset('assets/dashboard') }}/font-awesome/js/all.min.js"></script>
    <script src="{{ asset('assets/dashboard') }}/bundles/daterangepicker.bundle.js"></script>
    <script src="{{ asset('assets/dashboard') }}/bundles/dataTables.bundle.js"></script>
    <script src="{{ asset('assets/dashboard') }}/bundles/select2.bundle.js"></script>
    <script src="{{ asset('assets/dashboard') }}/bundles/sweetalert2.bundle.js"></script>
    <script src="{{ asset('assets/dashboard') }}/bundles/owlcarousel.bundle.js"></script>
    <script src="{{ asset('assets/dashboard') }}/js/bootstrap-datepicker.js"></script>
    <script src="{{ asset('assets/dashboard') }}/js/jquery.mask.min.js"></script>
    <script src="{{ asset('assets/dashboard') }}/js/moment/moment.min.js"></script>
    <script src="{{ asset('assets/dashboard') }}/js/moment/moment-with-locales.min.js"></script>

    <script src="{{ asset('assets/dashboard') }}/datatables/dataTables.buttons.min.js"></script>
    <script src="{{ asset('assets/dashboard') }}/datatables/jszip.min.js"></script>
    <script src="{{ asset('assets/dashboard') }}/datatables/vfs_fonts.js"></script>
    <script src="{{ asset('assets/dashboard') }}/datatables/buttons.html5.min.js"></script>
    <script src="{{ asset('assets/dashboard') }}/datatables/buttons.print.min.js"></script>
    <script src="{{ asset('assets/dashboard') }}/datatables/buttons.colVis.min.js"></script>

    <!-- Jquery Page Js -->
    {{-- <script src="{{ asset('assets/dashboard') }}/js/page/dashboard.js"></script> --}}

    {{-- Leaflet --}}
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-ajax/2.1.0/leaflet.ajax.js"
        integrity="sha512-eYE5o0mD7FFys0tVot8r4AnRXzVVXhjVpzNK+AcHkg4zNLvUAaCOJyLFKjmfpJMj6L/tuCzMN7LULBvNDhy5pA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>

    <script>
        $('.tanggal_haid').datepicker({
            format: "dd-mm-yyyy",
            language: "id",
            endDate: '0',
        });


        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

        $(function() {
            $('.modal').modal({
                backdrop: 'static',
                keyboard: false
            })
            moment.locale('id');
            $('.tanggal').mask('00-00-0000');
            $('.rupiah').mask('000.000.000.000.000', {
                reverse: true
            })
            $('.waktu').mask('00:00');
            $('.angka').mask('00000000000000000000');
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end
                    .format('YYYY-MM-DD'));
            });
        })

        // project data table
        $('.myDataTable')
            .addClass('nowrap')
            .dataTable({
                responsive: true,
                searching: true,
                paging: true,
                ordering: true,
                info: false,
            });


        $('.select2').select2({
            placeholder: "- Pilih Salah Satu -",
        })

        $('.btn-close').click(function() {
            $('.modal').modal('hide');
        })

        var overlay = $('#overlay').hide();

        $(document)
            .ajaxStart(function() {
                overlay.show();
            })
            .ajaxStop(function() {
                overlay.hide();
            });

        $('.numerik').on('input', function(e) {
            this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
        });
    </script>

    @stack('script')

</body>

</html>
