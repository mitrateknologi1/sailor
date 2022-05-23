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
                                <div class="card fieldset border border-secondary mb-3">
                                    <span class="fieldset-tile text-secondary bg-white">Profil</span>
                                    <div class="row p-2">
                                        <form id="perbarui-profil" action="#" method="POST" enctype="multipart/form-data"
                                            autocomplete="off">
                                            @csrf
                                            @method('PUT')
                                            @component('dashboard.components.forms.personal.profil',
                                                [
                                                    'user' => $user,
                                                    'profil' => $profil,
                                                    'agama' => $agama,
                                                    'provinsi' => $provinsi,
                                                    'kabupatenKota' => $kabupatenKota,
                                                    'kecamatan' => $kecamatan,
                                                    'desaKelurahan' => $desaKelurahan,
                                                    'foto_profil' => $foto_profil,
                                                    'titleSubmit' => 'Perbarui',
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
        $('#nomor-hp').keyup(function() {
            $('#nomor-hp-akun').val($(this).val())
        })

        $('#nomor-hp-akun').keyup(function() {
            $('#nomor-hp').val($(this).val())
        })

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
