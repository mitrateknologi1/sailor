<!doctype html>
<html class="no-js " lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 admin template and web Application ui kit.">
    <meta name="keyword"
        content="LUNO, Bootstrap 5, ReactJs, Angular, Laravel, VueJs, ASP .Net, Admin Dashboard, Admin Theme, HRMS, Projects">
    <title>MOMS CARE TERINTEGRASI | Lengkapi Profil</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon"> <!-- Favicon-->

    <!-- project css file  -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/css/luno.style.min.css">

    <style>
        .select2+.select2-container .select2-selection {
            border-radius: 1.5rem;
        }

        input {
            text-transform: uppercase;
        }

        #email {
            text-transform: lowercase !important;
        }

    </style>
</head>

<body id="layout-1" data-luno="theme-blue">

    <!-- start: body area -->
    <div class="wrapper">

        <!-- start: page body -->
        <div class="page-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col w-100 d-flex justify-content-center align-items-center">
                        <div class="card shadow-sm p-4 my-4" style="max-width: 50em;">
                            <div class="card-header p-0">
                                <div>
                                    <h6 class="card-title">Lengkapi Profil Anda</h6>
                                    <small class="text-muted">Anda belum memiliki profil, lengkapi profil anda
                                        terlebih dahulu untuk dapat masuk ke dashboard.</small>
                                </div>

                            </div>
                            <hr>
                            <!-- Form -->
                            <form id="tambah-profil" action="#" method="POST" enctype="multipart/form-data"
                                autocomplete="off" class="mt-2">
                                @component('dashboard.components.forms.personal.profil',
                                    [
                                        'user' => $user,
                                        'agama' => $agama,
                                        'provinsi' => $provinsi,
                                    ])
                                @endcomponent
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


    <script>
        $('#kabupaten-kota').attr('disabled', true)
        $('#kecamatan').attr('disabled', true)
        $('#desa-kelurahan').attr('disabled', true)

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

        $('#tambah-profil').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                icon: 'question',
                title: 'Simpan Data Profil?',
                // text: 'Apakah data yang anda masukkan sudah sesuai dengan data diri anda?',
                showCancelButton: true,
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData(this);
                    $('.error-text').text('');
                    $.ajax({
                        type: "POST",
                        url: "{{ route('tambahProfil') }}",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            $("#overlay").fadeOut(100);
                            if ($.isEmptyObject(data.error)) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Data profil berhasil diperbarui.',
                                }).then((result) => {
                                    window.location.href = "{{ url('/dashboard') }}";
                                })
                            } else {
                                Swal.fire(
                                    'Terjadi Kesalahan!',
                                    'Periksa kembali data yang anda masukkan',
                                    'error'
                                )
                                printErrorMsg(data.error);
                            }
                        },
                        error: function(data) {
                            alert(data.responseJSON.message)
                        },

                    });
                    const printErrorMsg = (msg) => {
                        $.each(msg, function(key, value) {
                            $('.' + key + '-error').text(value);
                        });
                    }
                }
            })
        })
    </script>

    @stack('script')

</body>

</html>
