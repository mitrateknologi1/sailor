@extends('dashboard.layouts.main')

@section('title')
    Ubah Anggota Keluarga
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
            <li class="breadcrumb-item active" aria-current="page">Ubah Anggota Keluarga</li>
        </ol>
    </div>
@endsection

@section('content')
    <section>
        <div class="row justify-content-center mb-4">
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-12">
                        @if (isset($anggotaKeluarga) && $anggotaKeluarga->is_valid == 2)
                            <div role="alert" class="alert alert-danger mt-2">
                                <h6>Alasan data anda ditolak:</h6>
                                <p class="mb-0">{{ $anggotaKeluarga->alasan_ditolak }}</p>
                            </div>
                        @endif
                        <div class="card p-4 pt-3">
                            <form id="update-anggota-keluarga" action="#" method="POST" enctype="multipart/form-data"
                                autocomplete="off">
                                @csrf
                                @method('PUT')
                                @component('dashboard.components.forms.masterData.anggotaKeluarga')
                                    @slot('anggotaKeluarga', isset($anggotaKeluarga) ? $anggotaKeluarga : null)
                                    @slot('provinsi', $provinsi)
                                    @slot('kabupatenKotaDomisili', isset($kabupatenKotaDomisili) ? $kabupatenKotaDomisili :
                                        null)
                                        @slot('kecamatanDomisili', isset($kecamatanDomisili) ? $kecamatanDomisili : null)
                                        @slot('desaKelurahanDomisili', isset($desaKelurahanDomisili) ? $desaKelurahanDomisili :
                                            null)
                                            @slot('desaKelurahanKK', isset($desaKelurahanKK) ? $desaKelurahanKK : null)
                                            @slot('kecamatanKK', isset($kecamatanKK) ? $kecamatanKK : null)
                                            @slot('kabupatenKotaKK', isset($kabupatenKotaKK) ? $kabupatenKotaKK : null)
                                            @slot('provinsiKK', isset($provinsiKK) ? $provinsiKK : null)
                                            @slot('alamatKK', isset($alamatKK) ? $alamatKK : null)
                                            @slot('agama', $agama)')
                                            @slot('pendidikan', $pendidikan)')
                                            @slot('pekerjaan', $pekerjaan)')
                                            @slot('golonganDarah', $golonganDarah)')
                                            @slot('statusPerkawinan', $statusPerkawinan)')
                                            @slot('statusHubungan', $statusHubungan)')
                                        @endcomponent
                                        <div class="col-12 mt-3 text-end">
                                            @component('dashboard.components.buttons.submit', [
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

                if ('{{ $anggotaKeluarga->status_hubungan_dalam_keluarga_id }}' == 1) {
                    $('#status-hubungan').attr('disabled', true);
                }

                $('#update-anggota-keluarga').submit(function(e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    Swal.fire({
                        title: 'Perbarui Data?',
                        text: "Apakah anda yakin ingin memperbarui data ini?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Batal',
                        confirmButtonText: 'Ya, Perbarui'
                    }).then((result) => {
                        if (result.value) {
                            $('.error-text').text('');
                            $.ajax({
                                type: "POST",
                                url: "{{ url('anggota-keluarga' . '/' . $keluarga->id . '/' . $anggotaKeluarga->id) }}",
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
                                                text: 'Data berhasil diperbarui.',
                                                showConfirmButton: false,
                                                timer: 3000,
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
            </script>
        @endpush
