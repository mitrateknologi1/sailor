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
                                <div class="row mb-4">
                                    <div class="col-12 col-lg">
                                        @component('dashboard.components.formElements.select',
                                            [
                                                'label' => 'Profil',
                                                'id' => 'profil',
                                                'name' => 'profil',
                                                'class' => 'select2',
                                                'wajib' => '<sup class="text-danger">*</sup>',
                                            ])
                                            @slot('options')
                                                @foreach ($anggotaKeluarga as $row)
                                                    <option value="{{ $row->id }}"
                                                        {{ $profil->id == $row->id ? 'selected' : '' }}>{{ $row->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            @endslot
                                        @endcomponent
                                    </div>
                                </div>
                                {{-- </div> --}}
                                <div class="card fieldset border border-secondary mb-3">
                                    <span class="fieldset-tile text-secondary bg-white">Profil
                                        {{ ucwords(strtolower($profil->nama_lengkap)) }}</span>
                                    <div class="row p-2">
                                        <form id="perbarui-profil" action="#" method="POST" enctype="multipart/form-data"
                                            autocomplete="off">
                                            @csrf
                                            @method('PUT')
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
                                                ])
                                            @endcomponent
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card fieldset border border-secondary mb-3">
                                    <span class="fieldset-tile text-secondary bg-white">Akun</span>
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
                    $('#nama-lengkap').val(response.profil.nama_lengkap);
                    $('#nik').val(response.profil.nik);
                    if (response.profil.jenis_kelamin == 'LAKI-LAKI') {
                        $('#jenis-kelamin-laki-laki').prop('checked', 'checked');
                    } else {
                        $('#jenis-kelamin-perempuan').prop('checked', 'checked');
                    }
                    $('#tempat-lahir').val(response.profil.tempat_lahir);
                    $('#tanggal-lahir').val(moment(response.profil.tanggal_lahir).format('DD-MM-YYYY'));
                    $('#agama').val(response.profil.agama_id);
                }
            })
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
                            $("#overlay").fadeOut(100);
                            if ($.isEmptyObject(data.error)) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Data profil berhasil diperbarui.',
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
