@extends('dashboard.layouts.main')

@section('title')
    Ubah Profil & Akun
@endsection

@push('style')
@endpush

@section('content')
    <section>
        <div class="row justify-content-center mb-4">
            <div class="col-lg-12 col-md-12">
                <div class="card p-0">
                    <div class="card-body pt-3">
                        <div class="row mb-0">
                            <div class="col-lg-8">
                                {{-- <div class="card fieldset border border-secondary mb-3">
                                    <span class="fieldset-tile text-secondary bg-white">Pilih Profil</span> --}}
                                {{-- </div> --}}
                                <div class="card fieldset border border-secondary mb-3">
                                    <span class="fieldset-tile text-secondary bg-white">Profil</span>
                                    @if (Auth::user()->is_remaja == 0)
                                        <div class="row mb-2">
                                            <div class="col-12 col-lg">
                                                @component('dashboard.components.formElements.select',
                                                    [
                                                        'label' => 'Pilih Profil',
                                                        'id' => 'profil',
                                                        'name' => 'profil',
                                                        'class' => 'select2',
                                                        'wajib' => '<sup class="text-danger">*</sup>',
                                                    ])
                                                    @slot('options')
                                                        @foreach ($anggotaKeluarga as $row)
                                                            <option value="{{ $row->id }}"
                                                                {{ $profil->id == $row->id ? 'selected' : '' }}>
                                                                {{ $row->nama_lengkap }}
                                                            </option>
                                                        @endforeach
                                                    @endslot
                                                @endcomponent
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row p-2">
                                        <form id="perbarui-profil" action="#" method="POST" enctype="multipart/form-data"
                                            autocomplete="off">
                                            @csrf
                                            @method('PUT')
                                            <div id="profil-render">
                                                @component('dashboard.components.forms.personal.profilKeluarga',
                                                    [
                                                        'profil' => isset($profil) ? $profil : null,
                                                        'provinsi' => $provinsi,
                                                        'agama' => $agama,
                                                        'pendidikan' => $pendidikan,
                                                        'pekerjaan' => $pekerjaan,
                                                        'golonganDarah' => $golonganDarah,
                                                        'statusPerkawinan' => $statusPerkawinan,
                                                        'statusHubungan' => $statusHubungan,
                                                        'kabupatenKotaDomisili' => isset($kabupatenKotaDomisili) ? $kabupatenKotaDomisili : null,
                                                        'kecamatanDomisili' => isset($kecamatanDomisili) ? $kecamatanDomisili : null,
                                                        'desaKelurahanDomisili' => isset($desaKelurahanDomisili) ? $desaKelurahanDomisili : null,
                                                        'desaKelurahanKK' => isset($desaKelurahanKK) ? $desaKelurahanKK : null,
                                                        'kecamatanKK' => isset($kecamatanKK) ? $kecamatanKK : null,
                                                        'kabupatenKotaKK' => isset($kabupatenKotaKK) ? $kabupatenKotaKK : null,
                                                        'provinsiKK' => isset($provinsiKK) ? $provinsiKK : null,
                                                        'alamatKK' => isset($alamatKK) ? $alamatKK : null,
                                                        'titleSubmit' => 'Perbarui',
                                                    ])
                                                @endcomponent
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card fieldset border border-secondary mb-3">
                                    <span class="fieldset-tile text-secondary bg-white">Akun
                                        {{ $user->is_remaja == 0 ? 'Kepala Keluarga' : '' }}</span>
                                    <div class="row p-2">
                                        <form id="perbarui-akun" action="#" method="POST" enctype="multipart/form-data"
                                            autocomplete="off">
                                            @csrf
                                            @method('PUT')
                                            @component('dashboard.components.forms.personal.akun',
                                                [
                                                    'user' => $user,
                                                    'titleSubmit' => 'Perbarui',
                                                ])
                                            @endcomponent
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        info()
        konfigurasi()
        $('#profil').on('change', function() {
            // alert($('#profil').val());
            // ajax get
            $.ajax({
                url: '{{ route('profilAnggotaKeluarga') }}',
                type: 'GET',
                data: {
                    id: $('#profil').val(),
                },
                success: function(response) {
                    $('#profil-render').html('')
                    $('#profil-render').html(response);
                    // $("#divFotoProfil").load("#divFotoProfil");
                    $('.avatar-wrapper').addClass('avatar-wrapper');

                    $('.select2').select2({
                        placeholder: "- Pilih Salah Satu -",
                    })
                    // if ('{{ $profil->status_hubungan_dalam_keluarga_id }}' == 1) {
                    $('#status-hubungan').attr('disabled', true);
                    // } else {
                    //     $('#status-hubungan').attr('disabled', false);
                    // }

                    inisialisasi()
                    info()
                    konfigurasi()

                }
            })


        });

        function konfigurasi() {
            $('.ubah-profil').attr('disabled', true);
            $('#status-hubungan').attr('disabled', true);


        }

        function info() {
            $('#info-ubah-1').html(
                '<span class="text-muted">Perubahan domisili dapat dilakukan minimal 3 bulan sekali.</span>')
            $('#info-ubah-1').addClass('mb-2')
            $('.info-ubah').addClass('text-muted')
            $('.info-ubah').css('font-style', 'italic');
            $('#info-ubah-2').html(
                '<span class="text-muted">Perubahan data di atas hanya dapat dilakukan oleh bidan / admin. Silahkan hubungi bidan terdekat apabila ingin mengubahnya.</span>'
            )
        }

        $(document).on('change', '#foto-profil', function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.avatar-wrapper').css('background-image', 'url(' + e.target.result + ')');
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

        $('#perbarui-profil').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                icon: 'question',
                title: 'Perbarui Data Profil?',
                text: 'Apakah anda yakin ingin memperbarui data profil ini?',
                showCancelButton: true,
                confirmButtonText: 'Ya, Perbarui',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData(this);
                    // append formData
                    formData.append('profil', $('#profil').val());
                    $('.error-text').text('');
                    $.ajax({
                        type: "POST",
                        url: "{{ route('perbaruiProfil') }}",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            console.log(data)
                            $("#overlay").fadeOut(100);
                            if ($.isEmptyObject(data.error)) {
                                if (data.belum_tiga_bulan) {
                                    Swal.fire(
                                        'Belum bisa mengubah domisili',
                                        'Perubahan domisili hanya dapat dilakukan minimal 3 bulan sekali. Perubahan terakhir anda di tanggal ' +
                                        data.terakhir_diubah +
                                        '. Domisili dapat diubah kembali pada tanggal ' +
                                        data.dapat_diubah +
                                        '.',
                                        'error'
                                    ).then((result) => {
                                        $('#profil').trigger('change');
                                    })
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: 'Data profil berhasil diperbarui.',
                                    }).then((result) => {
                                        window.location.href =
                                            "{{ url()->current() }}";
                                    })

                                }
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

        $('#perbarui-akun').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                icon: 'question',
                title: 'Perbarui Data Akun?',
                text: 'Apakah anda yakin ingin memperbarui data akun ini?',
                showCancelButton: true,
                confirmButtonText: 'Ya, Perbarui',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData(this);
                    $('.error-text').text('');
                    $.ajax({
                        type: "POST",
                        url: "{{ route('perbaruiAkun') }}",
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
                                    text: 'Data akun berhasil diperbarui.',
                                }).then((result) => {
                                    window.location.href = "{{ url()->current() }}";
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
@endpush
