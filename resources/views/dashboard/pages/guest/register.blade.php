<!doctype html>
<html class="no-js " lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 5 admin template and web Application ui kit.">
    <meta name="keyword"
        content="LUNO, Bootstrap 5, ReactJs, Angular, Laravel, VueJs, ASP .Net, Admin Dashboard, Admin Theme, HRMS, Projects">
    <title>SI GERCEP STUNTING | Registrasi</title>
    <link rel="shortcut icon" href="{{ asset('assets/favicon') }}/favicon.ico" type="image/x-icon" />


    <!-- plugin css file  -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/font-awesome/css/all.min.css">
    <!-- project css file  -->
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

        #file-kartu-keluarga {
            text-transform: lowercase !important;
        }

        #file-domisili {
            text-transform: lowercase !important;
        }

    </style>
</head>

<body class="layout-1" data-luno="theme-blue">
    <div id="overlay">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>

    <div class="row g-3 my-4 clearfix row-deck justify-content-center">
        <div class="col-lg-9 col-md-12 px-3">
            <div class="card">
                <div class="card-header py-3 pb-1 bg-transparent border-bottom-0">
                    <h5 class="card-title">{{ isset($kartuKeluarga) ? 'Registrasi Ulang' : 'Registrasi' }}</h5>
                    <small style="font-style: italic"><span class="text-danger">*</span> = wajib diisi</small>
                </div>
                <div class="card-body pt-0">
                    @if (isset($kartuKeluarga))
                        <div role="alert" class="alert alert-danger mt-2">
                            <h6>Alasan data anda ditolak:</h6>
                            <p class="mb-0">{{ $kartuKeluarga->alasan_ditolak }}</p>
                        </div>
                    @endif
                    <form id="form-registrasi" action="#" method="POST" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        @if (isset($kartuKeluarga))
                            @method('PUT')
                        @endif
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card fieldset border border-info p-4">
                                    <span class="fieldset-tile text-info bg-white">Input Kartu Keluarga</span>
                                    @component('dashboard.components.forms.masterData.kartuKeluarga')
                                        @slot('form_id', 'form_add_kepala_keluarga')
                                        @slot('kartuKeluarga', isset($kartuKeluarga) ? $kartuKeluarga : null)
                                        @slot('provinsi', $provinsi)
                                        @slot('kabupatenKota', $kabupatenKota)
                                        @slot('kecamatan', $kecamatan)
                                        @slot('desaKelurahan', $desaKelurahan)
                                        @slot('desaKelurahanKK', isset($desaKelurahanKK) ? $desaKelurahanKK : null)
                                        @slot('kecamatanKK', isset($kecamatanKK) ? $kecamatanKK : null)
                                        @slot('kabupatenKotaKK', isset($kabupatenKotaKK) ? $kabupatenKotaKK : null)
                                        @slot('provinsiKK', isset($provinsiKK) ? $provinsiKK : null)
                                        @slot('alamatKK', isset($alamatKK) ? $alamatKK : null)
                                        @slot('action', route('keluarga.store'))
                                        @slot('method', 'POST')
                                        @slot('back_url', route('keluarga.index'))
                                    @endcomponent
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card fieldset border border-info p-4">
                                    <span class="fieldset-tile text-info bg-white">Input Kepala Keluarga</span>
                                    @component('dashboard.components.forms.masterData.anggotaKeluarga')
                                        @slot('form_id', 'form_add_anggota_keluarga')
                                        @slot('anggotaKeluarga', isset($anggotaKeluarga) ? $anggotaKeluarga : null)
                                        @slot('provinsi', $provinsi)
                                        @slot('kabupatenKotaDomisili', isset($kabupatenKotaDomisili) ?
                                            $kabupatenKotaDomisili : null)
                                            @slot('kecamatanDomisili', isset($kecamatanDomisili) ? $kecamatanDomisili : null)
                                            @slot('desaKelurahanDomisili', isset($desaKelurahanDomisili) ?
                                                $desaKelurahanDomisili : null)
                                                @slot('desaKelurahanKK', isset($desaKelurahanKK) ? $desaKelurahanKK : null)
                                                @slot('kecamatanKK', isset($kecamatanKK) ? $kecamatanKK : null)
                                                @slot('kabupatenKotaKK', isset($kabupatenKotaKK) ? $kabupatenKotaKK : null)
                                                @slot('provinsiKK', isset($provinsiKK) ? $provinsiKK : null)
                                                @slot('agama', $agama)')
                                                @slot('pendidikan', $pendidikan)')
                                                @slot('pekerjaan', $pekerjaan)')
                                                @slot('golonganDarah', $golonganDarah)')
                                                @slot('statusPerkawinan', $statusPerkawinan)')
                                                @slot('statusHubungan', $statusHubungan)')
                                                @slot('action', route('bidan.store'))
                                                @slot('method', 'POST')
                                                @slot('back_url', route('bidan.index'))
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                @if (!isset($kartuKeluarga))
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card fieldset border border-info p-4">
                                                <span class="fieldset-tile text-info bg-white">Input Akun</span>
                                                <div class="row g-3">
                                                    <div class="col-lg-4 col-md-4">
                                                        @component('dashboard.components.formElements.input',
                                                            [
                                                                'label' => 'Nomor HP',
                                                                'type' => 'text',
                                                                'id' => 'nomor-hp',
                                                                'name' => 'nomor_hp',
                                                                'class' => 'angka',
                                                                'value' => $anggotaKeluarga->user->nomor_hp ?? null,
                                                                'wajib' => '<sup class="text-danger">*</sup>',
                                                            ])
                                                        @endcomponent
                                                        {{-- <small class="d-block" class="text-muted" style="font-style: italic;">Pastikan nomor HP yang anda masukkan aktif, untuk menerima sms notifikasi.</small> --}}
                                                    </div>
                                                    <div class="col-lg-4 col-md-4">
                                                        @component('dashboard.components.formElements.input',
                                                            [
                                                                'label' => 'Kata Sandi',
                                                                'type' => 'password',
                                                                'id' => 'kata-sandi',
                                                                'name' => 'kata_sandi',
                                                                'class' => '',
                                                                'wajib' => '<sup class="text-danger wajib-kata-sandi">*</sup>',
                                                            ])
                                                        @endcomponent
                                                    </div>
                                                    <div class="col-lg-4 col-md-4">
                                                        @component('dashboard.components.formElements.input',
                                                            [
                                                                'label' => 'Ulangi Kata Sandi',
                                                                'type' => 'password',
                                                                'id' => 'ulangi-kata-sandi',
                                                                'name' => 'ulangi_kata_sandi',
                                                                'class' => '',
                                                                'wajib' => '<sup class="text-danger wajib-kata-sandi">*</sup>',
                                                            ])
                                                        @endcomponent
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-12 mt-3 text-end">
                                    @component('dashboard.components.buttons.submit',
                                        [
                                            'id' => 'proses-pertumbuhan-anak',
                                            'type' => 'submit',
                                            'class' => 'text-white text-uppercase',
                                            'icon' => '<i class="fa-solid fa-paper-plane"></i>',
                                            'label' => 'Kirim Data',
                                        ])
                                    @endcomponent
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Jquery Core Js -->
            <script src="{{ asset('assets/dashboard') }}/bundles/libscripts.bundle.js"></script>
            <script src="{{ asset('assets/dashboard') }}/font-awesome/js/all.min.js"></script>
            <script src="{{ asset('assets/dashboard') }}/bundles/select2.bundle.js"></script>
            <script src="{{ asset('assets/dashboard') }}/bundles/sweetalert2.bundle.js"></script>
            <script src="{{ asset('assets/dashboard') }}/js/jquery.mask.min.js"></script>
            <script src="{{ asset('assets/dashboard') }}/js/moment/moment.min.js"></script>
            <script src="{{ asset('assets/dashboard') }}/js/moment/moment-with-locales.min.js"></script>


            @stack('script')
            <script>
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
                })

                $('#status-hubungan').val('1')
                $('#status-hubungan').prop('disabled', true)

                $('#form-registrasi').submit(function(e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    $('.error-text').text('');
                    Swal.fire({
                        title: 'Apakah data sudah sesuai dengan kartu keluarga?',
                        text: "Jika sudah sesuai, maka data akan dikirim untuk dilakukan Validasi.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Batal',
                        confirmButtonText: 'Ya, Kirim Data'
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: '{{ isset($kartuKeluarga) ? route('updateRegistrasi', $kartuKeluarga->id) : route('insertRegistrasi') }}',
                                type: 'POST',
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(data) {
                                    $("#overlay").fadeOut(100);
                                    if ($.isEmptyObject(data.error)) {
                                        Swal.fire(
                                            'Berhasil!',
                                            data.mes,
                                            'success',
                                        ).then((result) => {
                                            if (result.value) {
                                                window.location.href = "{{ url('/login') }}"
                                            }
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

                                }
                            })
                            const printErrorMsg = (msg) => {
                                $.each(msg, function(key, value) {
                                    $('.' + key + '-error').text(value);
                                });
                            }
                        }
                    })

                });

                // on key up copy nama-kepala-keluarga in nama-lengkap
                $('#nama-kepala-keluarga').keyup(function() {
                    $('#nama-lengkap').val($(this).val())
                })

                $('#nama-lengkap').keyup(function() {
                    $('#nama-kepala-keluarga').val($(this).val())
                })

                $('.select2').select2({
                    placeholder: "- Pilih Salah Satu -",
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
            {{-- @stack('script') --}}

        </body>

        </html>
