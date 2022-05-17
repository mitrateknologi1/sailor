@extends('dashboard.layouts.main')

@section('title')
    Tambah Keluarga
@endsection

@push('style')
    <style>
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
@endpush

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil</li>
            <li class="breadcrumb-item active" aria-current="page">Keluarga</li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Keluarga</li>
        </ol>
    </div>
@endsection

@section('content')
    <section>
        <div class="row justify-content-center mb-4">
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card p-4 pt-3">
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
                                                    @slot('kecamatanDomisili', isset($kecamatanDomisili) ? $kecamatanDomisili :
                                                        null)
                                                        @slot('desaKelurahanDomisili', isset($desaKelurahanDomisili) ?
                                                            $desaKelurahanDomisili : null)
                                                            @slot('desaKelurahanKK', isset($desaKelurahanKK) ? $desaKelurahanKK : null)
                                                            @slot('kecamatanKK', isset($kecamatanKK) ? $kecamatanKK : null)
                                                            @slot('kabupatenKotaKK', isset($kabupatenKotaKK) ? $kabupatenKotaKK : null)
                                                            @slot('provinsiKK', isset($provinsiKK) ? $provinsiKK : null)
                                                            @slot('agama', $agama)
                                                            @slot('pendidikan', $pendidikan)
                                                            @slot('pekerjaan', $pekerjaan)
                                                            @slot('golonganDarah', $golonganDarah)
                                                            @slot('statusPerkawinan', $statusPerkawinan)
                                                            @slot('statusHubungan', $statusHubungan)
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
                                            @if (Auth::user()->role == 'admin')
                                                <div class="col-12 col-lg mt-3">
                                                    @component('dashboard.components.formElements.select',
                                                        [
                                                            'label' => 'Bidan sesuai lokasi domisili',
                                                            'id' => 'nama-bidan',
                                                            'name' => 'nama_bidan',
                                                            'class' => 'select2',
                                                            'attribute' => 'disabled',
                                                            'wajib' => '<sup class="text-danger">*</sup>',
                                                        ])
                                                    @endcomponent
                                                </div>
                                            @endif

                                            <div class="col-12 mt-3 text-end">
                                                @component('dashboard.components.buttons.submit',
                                                    [
                                                        'id' => 'proses-pertumbuhan-anak',
                                                        'type' => 'submit',
                                                        'class' => 'text-white text-uppercase',
                                                        'label' => 'Simpan',
                                                    ])
                                                @endcomponent
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endsection


            @push('script')
                <script>
                    $('#m-link-profil').addClass('active');
                    $('#menu-profil').addClass('collapse show')
                    $('#ms-link-master-data-profil-keluarga').addClass('active')

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
                            title: 'Apakah data sudah benar dan sesuai dengan kartu keluarga?',
                            text: "Jika sudah sesuai, maka data akan disimpan.",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            cancelButtonText: 'Batal',
                            confirmButtonText: 'Ya, Simpan'
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
                                                'Data berhasil disimpan.',
                                                'success',
                                            ).then((result) => {
                                                if (result.value) {
                                                    window.location.href =
                                                        "{{ url()->previous() }}";
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

                    $('#desa-kelurahan-domisili').change(function() {
                        if ($('#desa-kelurahan-domisili').val() != '') {
                            changeKelurahanDomisili()
                        }
                    })

                    function changeKelurahanDomisili() {
                        if ('{{ Auth::user()->role }}' == 'admin') {
                            var id = $('#desa-kelurahan-domisili').val();
                            $('#nama-bidan').html('');
                            $('#nama-bidan').append('<option value="" selected hidden>- Pilih Salah Satu -</option>')
                            $.get("{{ route('getBidanAnggotaKeluarga') }}", {
                                lokasi_id: id,
                            }, function(result) {
                                console.log(result)
                                $.each(result, function(key, val) {
                                    $('#nama-bidan').append(`<option value="${val.id}">${val.nama_lengkap}</option>`);
                                })
                                $('#nama-bidan').removeAttr('disabled');
                            });
                        }
                    }
                </script>
            @endpush
