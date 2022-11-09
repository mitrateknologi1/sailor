@extends('dashboard.layouts.main')

@section('title')
    Tambah Anggota Keluarga
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
            <li class="breadcrumb-item active" aria-current="page">Tambah Anggota Keluarga</li>
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
                            <form id="insert-anggota-keluarga" action="#" method="POST" enctype="multipart/form-data"
                                autocomplete="off">
                                @csrf
                                @component('dashboard.components.forms.masterData.anggotaKeluarga',
                                    [
                                        'anggotaKeluarga' => isset($anggotaKeluarga) ? $anggotaKeluarga : null,
                                        'provinsi' => $provinsi,
                                        'kabupatenKotaDomisili' => isset($kabupatenKotaDomisili) ? $kabupatenKotaDomisili : null,
                                        'kecamatanDomisili' => isset($kecamatanDomisili) ? $kecamatanDomisili : null,
                                        'desaKelurahanDomisili' => isset($desaKelurahanDomisili) ? $desaKelurahanDomisili : null,
                                        'desaKelurahanKK' => isset($desaKelurahanKK) ? $desaKelurahanKK : null,
                                        'kecamatanKK' => isset($kecamatanKK) ? $kecamatanKK : null,
                                        'kabupatenKotaKK' => isset($kabupatenKotaKK) ? $kabupatenKotaKK : null,
                                        'provinsiKK' => isset($provinsiKK) ? $provinsiKK : null,
                                        'alamatKK' => isset($alamatKK) ? $alamatKK : null,
                                        'agama' => $agama,
                                        'pendidikan' => $pendidikan,
                                        'pekerjaan' => $pekerjaan,
                                        'golonganDarah' => $golonganDarah,
                                        'statusPerkawinan' => $statusPerkawinan,
                                        'statusHubungan' => $statusHubungan,
                                    ])
                                @endcomponent
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
                                            'id' => '',
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
        // if ('{{ isset($anggotaKeluarga) }}') {} else {
        //     $('#check-domisili').trigger('click')
        //     checkDomisili()
        // }


        if ("{{ Auth::user()->role }}" == "keluarga") {
            $('#m-link-anggota-keluarga').addClass('active');
        } else {
            $('#m-link-profil').addClass('active');
            $('#menu-profil').addClass('collapse show')
            $('#ms-link-master-data-profil-keluarga').addClass('active')
        }



        var alamatKK = '{{ $alamatKK }}'
        var provinsiKK = '{{ $provinsiKK }}'
        var kabupatenKotaKK = '{{ $kabupatenKotaKK }}'
        var kecamatanKK = '{{ $kecamatanKK }}'
        var desaKelurahanKK = '{{ $desaKelurahanKK }}';

        if ('{{ Auth::user()->role }}' == 'keluarga') {
            var textConfirm = 'Jika sudah sesuai, maka data akan dikirim untuk dilakukan Validasi'
            var confirmButtonText = 'Ya, Kirim Data'
            var titleResult = 'Data berhasil dikirim'
            var textResult = 'Data berhasil dikirim dan sedang menunggu proses Validasi.'
        } else {
            var textConfirm =
                'Jika sudah sesuai, maka data akan disimpan.'
            var confirmButtonText = 'Ya, Simpan'
            var titleResult = 'Berhasil!'
            var textResult = 'Data berhasil disimpan.'
        }

        $('#insert-anggota-keluarga').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            Swal.fire({
                icon: 'question',
                title: 'Apakah data sudah sesuai dengan kartu keluarga?',
                text: textConfirm,
                showCancelButton: true,
                confirmButtonText: confirmButtonText,
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.value) {
                    $('.error-text').text('');
                    $.ajax({
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        url: "{{ url('anggota-keluarga' . '/' . $kartu_keluarga_id) }}",
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            console.log(data);
                            $("#overlay").fadeOut(100);
                            if ($.isEmptyObject(data.error)) {
                                Swal.fire({
                                        icon: 'success',
                                        title: titleResult,
                                        text: textResult,
                                    })
                                    .then((result) => {
                                        window.location.href = "{{ url()->previous() }}";
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
                }
            })
        })

        const printErrorMsg = (msg) => {
            $.each(msg, function(key, value) {
                $('.' + key + '-error').text(value);
            });
        }

        $('#desa-kelurahan-domisili').change(function() {
            // console.log('test')
            changeKelurahanDomisili()
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
