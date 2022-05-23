<form id="{{ $form_id }}" action="#" method="POST" enctype="multipart/form-data">
    @csrf
    @if (isset($method) && $method == 'PUT')
        @method('PUT')
    @endif
    <div class="row g-4">
        @if (Auth::user()->role != 'keluarga')
            <div class="col-sm-12 col-lg">
                @component('dashboard.components.formElements.select',
                    [
                        'label' => 'Nama Kepala Keluarga / Nomor KK',
                        'id' => 'nama-kepala-keluarga',
                        'name' => 'nama_kepala_keluarga',
                        'class' => 'select2',
                        'wajib' => '<sup class="text-danger">*</sup>',
                    ])
                    @slot('options')
                        @foreach ($kartuKeluarga as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_kepala_keluarga }} / {{ $item->nomor_kk }}
                            </option>
                        @endforeach
                    @endslot
                @endcomponent
            </div>
        @endif
        <div class="col-sm-12 col-lg">
            @component('dashboard.components.formElements.select',
                [
                    'label' => 'Nama Anak (Tanggal Lahir)',
                    'id' => 'nama-anak',
                    'name' => 'nama_anak',
                    'class' => 'select2',
                    'attribute' => 'disabled',
                    'wajib' => '<sup class="text-danger">*</sup>',
                ])
            @endcomponent
        </div>
        @if (Auth::user()->role == 'admin' && $method == 'POST')
            <div class="col-sm-12 col-lg">
                @component('dashboard.components.formElements.select',
                    [
                        'label' => 'Bidan sesuai lokasi anak',
                        'id' => 'nama-bidan',
                        'name' => 'nama_bidan',
                        'class' => 'select2',
                        'attribute' => 'disabled',
                        'wajib' => '<sup class="text-danger">*</sup>',
                    ])
                @endcomponent
            </div>
        @endif
        <div class="col-sm-12 col-lg-12">
            @component('dashboard.components.formElements.input',
                [
                    'label' => 'Lingkar Lengan Atas',
                    'type' => 'text',
                    'id' => 'lingkar_lengan_atas',
                    'name' => 'lingkar_lengan_atas',
                    'class' => 'numerik',
                    'wajib' => '<sup class="text-danger">*</sup>',
                    'placeholder' => 'Masukkan Lingkar Lengan Atas',
                ])
            @endcomponent
        </div>
        <div class="col-sm-12 col-lg-6">
            @component('dashboard.components.formElements.input',
                [
                    'label' => 'Tinggi Badan (Cm)',
                    'type' => 'text',
                    'id' => 'tinggi_badan',
                    'name' => 'tinggi_badan',
                    'class' => 'numerik',
                    'wajib' => '<sup class="text-danger">*</sup>',
                    'placeholder' => 'Masukkan Tinggi Badan',
                ])
            @endcomponent
        </div>
        <div class="col-sm-12 col-lg-6">
            @component('dashboard.components.formElements.input',
                [
                    'label' => 'Berat Badan (Kg)',
                    'type' => 'text',
                    'id' => 'berat_badan',
                    'name' => 'berat_badan',
                    'class' => 'numerik',
                    'wajib' => '<sup class="text-danger">*</sup>',
                    'placeholder' => 'Masukkan Berat Badan',
                ])
            @endcomponent
        </div>
        <div class="col-sm-12 col-lg-12">
            <p class="card-title mb-0 fw-normal">Hemoglobin</p>
            @foreach ($daftarSoal as $soal)
                @php
                    $checkedYa = '';
                    $checkedTidak = '';
                @endphp
                @if (isset($method) && $method == 'PUT')
                    @php
                        $jawabanSoal = \App\Models\JawabanMencegahMalnutrisi::where('mencegah_malnutrisi_id', $dataEdit->id)
                            ->where('soal_id', $soal->id)
                            ->first();
                        if ($jawabanSoal) {
                            if ($jawabanSoal->jawaban == 'Ya') {
                                $checkedYa = 'checked';
                            } else {
                                $checkedTidak = 'checked';
                            }
                        }
                    @endphp
                @endif
                <input type="text" value="{{ $soal->id }}" hidden name="soal_id[]">
                <div class="card p-0 my-3">
                    <div class="card-body">
                        <p>{{ $loop->iteration }}. {{ $soal->soal }}</p>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">Ya</label>
                            <input class="form-check-input" type="radio" id="jawaban-{{ $loop->iteration }}"
                                name="jawaban-{{ $loop->iteration }}[]" value="Ya" {{ $checkedYa }}>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">Tidak</label>
                            <input class="form-check-input" type="radio" id="jawaban-{{ $loop->iteration }}"
                                name="jawaban-{{ $loop->iteration }}[]" value="Tidak" {{ $checkedTidak }}>
                        </div>
                        <p class="text-danger jawaban-{{ $loop->iteration }}-error my-0"></p>
                    </div>
                </div>
            @endforeach


        </div>
        <div class="col-12 text-end">
            @component('dashboard.components.buttons.process',
                [
                    'id' => 'proses-pertumbuhan-anak',
                    'type' => 'submit',
                ])
            @endcomponent
        </div>
    </div>
    <div class="modal fade" id="modal-hasil" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body custom_scroll p-lg-4 pb-3">
                    <div class="d-flex w-100 justify-content-between mb-1">
                        <div>
                            <h5>Hasil Mencegah Malnutrisi</h5>
                            <p class="text-muted" id="tanggal-proses"> - </p>
                        </div>
                        <button type="button" class="btn-close float-end" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="alert kategori-alert rounded-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar rounded no-thumbnail kategori-bg text-light"><i id="kategori-emot"
                                    class=""></i></div>
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div class="h6 mb-0" id="modal-kategori" style="margin-left: 5px"> - </div>
                            </div>
                        </div>
                    </div>
                    <div class="card fieldset border border-dark my-4">
                        <span class="fieldset-tile text-dark ml-5 bg-white">Info Remaja:</span>
                        <div class="card-body p-0 py-1 px-1">
                            <ul class="list-unstyled mb-0">
                                <li class="justify-content-between mb-2">
                                    <label><i class="fa-solid fa-child"></i> Nama Remaja:</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-nama-remaja"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="bi bi-calendar2-event-fill"></i> Tanggal Lahir</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-tanggal-lahir"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fa-solid fa-cake-candles"></i> Usia</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-usia"> - </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-hand-paper"></i> Lingkar Lengan Atas :</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-lingkar-lengan-atas">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-ruler-combined"></i> Tinggi / Berat Badan :</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-tinggi-berat-badan">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-heart"></i> Hasil Deteksi Hemoglobin :</label>
                                    <span class="hasil-bg badge bg-info float-end text-uppercase"
                                        id="modal-deteksi-hemoglobin">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-hand-paper"></i> Kategori Lingkar Lengan Atas :</label>
                                    <span class="hasil-bg badge bg-info float-end text-uppercase"
                                        id="modal-kategori-lingkar-lengan-atas">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-child"></i> Indeks Masa Tubuh :</label>
                                    <span class="hasil-bg badge bg-info float-end text-uppercase"
                                        id="modal-indeks-masa-tubuh">
                                        -
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-sm-6 col-lg-4">
                            <button class="btn btn-outline-dark text-uppercase w-100" data-bs-dismiss="modal"
                                aria-label="Close"><i class="bi bi-x-circle"></i> Batal</button>
                        </div>
                        <div class="col-sm-6 col-lg-8">
                            {{-- <a href="#" class="btn btn-info text-white text-uppercase w-100" id="simpan-pertumbuhan-anak"><i class="fa-solid fa-floppy-disk"></i> Simpan</a> --}}
                            @component('dashboard.components.buttons.submit',
                                [
                                    'id' => 'proses-pertumbuhan-anak',
                                    'type' => 'submit',
                                    'class' => 'text-white text-uppercase w-100',
                                    'label' => 'Simpan',
                                ])
                            @endcomponent
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>


@push('script')
    @if (isset($method) && $method == 'PUT')
        <script>
            $(document).ready(function() {
                $('#nama-kepala-keluarga').val(
                    '{{ $dataEdit->randaKabilasa->anggotaKeluarga->kartuKeluarga->id }}').change();
                $('#lingkar_lengan_atas').val('{{ $dataEdit->lingkar_lengan_atas }}').change();
                $('#tinggi_badan').val('{{ $dataEdit->tinggi_badan }}').change();
                $('#berat_badan').val('{{ $dataEdit->berat_badan }}').change();
            });
        </script>
    @endif
    <script>
        $(function() {
            $('.modal').modal({
                backdrop: 'static',
                keyboard: false
            })
            if ($('#nama-kepala-keluarga').val() != '') {
                changeKepalaKeluarga()
            }

            $('#nama-kepala-keluarga').change(function() {
                changeKepalaKeluarga()
            })

            $('#nama-anak').change(function() {
                changeAnak()
            })

            if ('{{ Auth::user()->role }}' == 'keluarga') {
                var textConfirm = 'Jika sudah sesuai, maka data akan dikirim untuk dilakukan Validasi'
                var confirmButtonText = 'Ya, Kirim Data'
                var titleResult = 'Data berhasil dikirim'
                var textResult = 'Data berhasil dikirim dan sedang menunggu proses Validasi.'
            } else {
                var textConfirm =
                    'Jika sudah sesuai, maka data akan disimpan dan dapat oleh Penyuluh BKKBN dan Dinas P2KB'
                var confirmButtonText = 'Ya, Simpan'
                var titleResult = 'Data berhasil disimpan'
                var textResult = 'Data berhasil disimpan dan dapat dilihat oleh Penyuluh BKKBN dan Dinas P2KB.'
            }

            $('#{{ $form_id }}').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                if ($('#modal-hasil').hasClass('show')) {
                    Swal.fire({
                        icon: 'question',
                        title: 'Apakah data sudah sesuai?',
                        text: textConfirm,
                        showCancelButton: true,
                        confirmButtonText: confirmButtonText,
                        cancelButtonText: 'Batal',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: "{{ $action }}",
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                data: formData,
                                cache: false,
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    if (response.status == 'success') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: titleResult,
                                            text: textResult,
                                            showConfirmButton: false,
                                            timer: 2000,
                                        }).then((result) => {
                                            // set location
                                            window.location.href =
                                                "{{ $back_url }}";
                                        })
                                    } else if (response.res ==
                                        'sudah_ada_tapi_belum_divalidasi') {
                                        Swal.fire(
                                            'Terjadi kesalahan',
                                            response.mes,
                                            'error',
                                        )
                                        $('#modal-hasil').modal('hide')
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Terjadi kesalahan',
                                            text: 'Data gagal disimpan',
                                            showConfirmButton: false,
                                            timer: 1500
                                        })
                                    }

                                },
                                error: function(response) {
                                    alert(response.responseJSON.message)
                                },

                            });
                        }
                    })

                } else {
                    $("#overlay").fadeIn(100);
                    $('.error-text').text('');
                    $.ajax({
                        type: "POST",
                        url: "{{ $proses }}",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            console.log(data);
                            $("#overlay").fadeOut(100);
                            if ($.isEmptyObject(data.error)) {
                                $('#modal-hasil').modal('show');
                                $('#tanggal-proses').text('Tanggal : ' + moment().format('LL'))
                                $('#modal-nama-remaja').text(data.nama_anak);
                                $('#modal-tanggal-lahir').text(moment(data.tanggal_lahir)
                                    .format('LL'));
                                $('#modal-lingkar-lengan-atas').text(data.lingkar_lengan_atas);
                                $('#modal-tinggi-berat-badan').text(data.tinggi_badan +
                                    ' cm / ' +
                                    data.berat_badan + ' kg');
                                $('#modal-deteksi-hemoglobin').text(data.kategori_hemoglobin);
                                $('#modal-kategori-lingkar-lengan-atas').text(data
                                    .kategori_lingkar_lengan_atas);
                                $('#modal-indeks-masa-tubuh').text(data
                                    .kategori_imt);
                                $('#modal-usia').text(data.usia_tahun);
                                $('#modal-kategori').text(data.kategori_mencegah_malnutrisi);
                                var kategoriBg = ['bg-danger', 'bg-warning', 'bg-info',
                                    'bg-success', 'bg-primary'
                                ];
                                var kategoriAlert = ['alert-danger', 'alert-warning',
                                    'alert-info', 'alert-success', 'alert-primary'
                                ];
                                var kategoriEmot = ['fa-solid fa-face-frown',
                                    'fa-solid fa-face-meh', 'fa-solid fa-face-smile',
                                    'fa-solid fa-face-surprise'
                                ];
                                $.each(kategoriBg, function(i, v) {
                                    $('.kategori-bg').removeClass(v);
                                });
                                $.each(kategoriAlert, function(i, v) {
                                    $('.kategori-alert').removeClass(v);
                                });
                                $.each(kategoriEmot, function(i, v) {
                                    $('.kategori-emot').removeClass(v);
                                });
                                $.each(kategoriBg, function(i, v) {
                                    $('.hasil-bg').removeClass(v);
                                })

                                if (data.kategori_mencegah_malnutrisi ==
                                    'Tidak Berpartisipasi Mencegah Stunting') {
                                    $('.kategori-bg').addClass('bg-danger');
                                    $('.kategori-alert').addClass('alert-danger');
                                    $('#kategori-emot').addClass('fa-solid fa-face-frown');
                                } else {
                                    $('.kategori-bg').addClass('bg-success');
                                    $('.kategori-alert').addClass('alert-success');
                                    $('#kategori-emot').addClass('fa-solid fa-face-smile');
                                }

                                if (data.kategori_hemoglobin == 'Terindikasi Anemia') {
                                    $('#modal-deteksi-hemoglobin').addClass('bg-warning');
                                } else if (data.kategori_hemoglobin == 'Anemia') {
                                    $('#modal-deteksi-hemoglobin').addClass('bg-danger');
                                } else {
                                    $('#modal-deteksi-hemoglobin').addClass('bg-success');
                                }

                                if (data.kategori_lingkar_lengan_atas == 'Kurang Gizi') {
                                    $('#modal-kategori-lingkar-lengan-atas').addClass(
                                        'bg-danger');
                                } else {
                                    $('#modal-kategori-lingkar-lengan-atas').addClass(
                                        'bg-success');
                                }

                                if (data.kategori_imt == 'Sangat Kurus') {
                                    $('#modal-indeks-masa-tubuh').addClass('bg-danger');
                                } else if (data.kategori_imt == 'Kurus') {
                                    $('#modal-indeks-masa-tubuh').addClass('bg-warning');
                                } else if (data.kategori_imt == 'Normal') {
                                    $('#modal-indeks-masa-tubuh').addClass('bg-success');
                                } else if (data.kategori_imt == 'Gemuk') {
                                    $('#modal-indeks-masa-tubuh').addClass('bg-warning');
                                } else {
                                    $('#modal-indeks-masa-tubuh').addClass('bg-danger');
                                }
                            } else {
                                console.log(data);
                                Swal.fire(
                                    'Terjadi Kesalahan!',
                                    'Periksa Kembali Inputan Anda!',
                                    'error'
                                )
                                printErrorMsg(data.error);
                            }
                        }
                    });

                }

            });

            const printErrorMsg = (msg) => {
                $.each(msg, function(key, value) {
                    $('.' + key + '-error').text(value);
                });
            }
        });

        function changeKepalaKeluarga() {
            if ('{{ Auth::user()->role }}' != 'keluarga') {
                var id = $('#nama-kepala-keluarga').val();
            } else {
                var id = '{{ Auth::user()->profil->kartu_keluarga_id }}';
            }
            var rentang_umur = 'remaja';
            var id_anak = "{{ isset($dataEdit) ? $dataEdit->randaKabilasa->anggota_keluarga_id : '' }}";
            var selected = '';
            $('#nama-anak').html('');
            $('#nama-anak').append('<option value="" selected hidden>- Pilih Salah Satu -</option>')
            $.get("{{ route('getAnak') }}", {
                id: id,
                rentang_umur: rentang_umur,
                method: "{{ $method }}",
                id_anak: id_anak
            }, function(result) {
                console.log(result);
                $.each(result.anggota_keluarga, function(key, val) {
                    var tanggal_lahir = moment(val.tanggal_lahir).format('LL');
                    selected = '';
                    if (val.id ==
                        "{{ isset($dataEdit) ? $dataEdit->randaKabilasa->anggota_keluarga_id : '' }}") {
                        selected = 'selected';
                    }
                    if (1 == "{{ Auth::user()->is_remaja }}") {
                        $('#nama-anak').append(
                            `<option value="${val.id}" selected>${val.nama_lengkap} (${tanggal_lahir})</option>`
                        );
                    } else {
                        $('#nama-anak').append(
                            `<option value="${val.id}" ${selected}>${val.nama_lengkap} (${tanggal_lahir})</option>`
                        );
                    }


                })

                if ("{{ $method }}" == 'PUT') {
                    selected = '';

                    if (result.anggota_keluarga_hapus) {
                        if (result.anggota_keluarga_hapus.id ==
                            "{{ isset($dataEdit) ? $dataEdit->randaKabilasa->anggota_keluarga_id : '' }}") {
                            selected = 'selected';
                        }

                        $('#nama-anak').append(
                            `<option value="${result.anggota_keluarga_hapus.id}" ${selected}>${result.anggota_keluarga_hapus.nama_lengkap} (${result.anggota_keluarga_hapus.tanggal_lahir})</option>`
                        );

                    }
                }
                $('#nama-anak').removeAttr('disabled');
            });
        }


        function changeAnak() {
            if ('{{ Auth::user()->role }}' == 'admin') {
                var id = $('#nama-anak').val();
                $('#nama-bidan').html('');
                $('#nama-bidan').append('<option value="" selected hidden>- Pilih Salah Satu -</option>')
                $.get("{{ route('getBidan') }}", {
                    id: id,
                }, function(result) {
                    $.each(result, function(key, val) {
                        $('#nama-bidan').append(`<option value="${val.id}">${val.nama_lengkap}</option>`);
                    })
                    $('#nama-bidan').removeAttr('disabled');
                });
            }
        }
    </script>
@endpush
