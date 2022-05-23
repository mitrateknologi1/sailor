<form id="{{ $form_id }}" action="#" method="POST" enctype="multipart/form-data">
    @csrf
    @if (isset($method) && $method == 'PUT')
        @method('PUT')
    @endif
    <div class="row g-4">
        @if (Auth::user()->is_remaja != 1)
            <div class="col-sm-12 col-lg">
                @component('dashboard.components.formElements.input',
                    [
                        'label' => 'Nama Kepala Keluarga / Nomor KK',
                        'type' => 'text',
                        'id' => 'nama-kepala-keluarga',
                        'name' => 'nama_kepala_keluarga',
                        'class' => '',
                        'wajib' => '<sup class="text-danger">*</sup>',
                        'placeholder' => 'Nama Kepala Keluarga / Nomor KK',
                        'attribute' => 'readonly',
                        'value' => $randaKabilasa->anggotaKeluarga->kartuKeluarga->nama_kepala_keluarga . ' / ' . $randaKabilasa->anggotaKeluarga->kartuKeluarga->nomor_kk,
                    ])
                @endcomponent
            </div>
        @endif
        <div class="col-sm-12 col-lg">
            @component('dashboard.components.formElements.input',
                [
                    'label' => 'Nama Remaja (Tanggal Lahir)',
                    'type' => 'text',
                    'id' => 'nama-remaja',
                    'name' => 'nama_remaja',
                    'class' => '',
                    'wajib' => '<sup class="text-danger">*</sup>',
                    'placeholder' => 'Nama Remaja',
                    'attribute' => 'readonly',
                    'value' => $randaKabilasa->anggotaKeluarga->nama_lengkap . ' (' . Carbon\Carbon::parse($randaKabilasa->anggotaKeluarga->tanggal_lahir)->translatedFormat('d F Y') . ')',
                ])
            @endcomponent
        </div>
        <div class="col-sm-12 col-lg-12">
            <h6 class="card-title mb-0">Pertanyaan</h6>
            <div class="card my-3 p-0">
                <div class="card-body">
                    <p>1. Apakah anda berencana menikah di usia kurang dari 20 tahun ?</p>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">Ya</label>
                        <input class="form-check-input" type="radio" id="jawaban-1" name="jawaban_1[]" value="Ya"
                            onchange="changeJawaban1()"
                            @if ($randaKabilasa->mencegahPernikahanDini) @if ($randaKabilasa->mencegahPernikahanDini->jawaban_1 == 'Ya')
                                checked @endif
                            @endif
                        >
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">Tidak</label>
                        <input class="form-check-input" type="radio" id="jawaban-1" name="jawaban_1[]" value="Tidak"
                            onchange="changeJawaban1()"
                            @if ($randaKabilasa->mencegahPernikahanDini) @if ($randaKabilasa->mencegahPernikahanDini->jawaban_1 == 'Tidak')
                                checked @endif
                            @endif
                        >
                    </div>
                    <p class="text-danger jawaban_1-error my-0"></p>
                </div>
            </div>

            <div class="card my-3 p-0">
                <div class="card-body">
                    <p>2. Apakah anda berencana menikah di usia 21-35 tahun ?</p>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">Ya</label>
                        <input class="form-check-input" type="radio" id="jawaban-2" name="jawaban_2[]" value="Ya"
                            onchange="changeJawaban2()"
                            @if ($randaKabilasa->mencegahPernikahanDini) @if ($randaKabilasa->mencegahPernikahanDini->jawaban_2 == 'Ya')
                                checked @endif
                            @endif
                        >
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">Tidak</label>
                        <input class="form-check-input" type="radio" id="jawaban-2" name="jawaban_2[]" value="Tidak"
                            onchange="changeJawaban2()"
                            @if ($randaKabilasa->mencegahPernikahanDini) @if ($randaKabilasa->mencegahPernikahanDini->jawaban_2 == 'Tidak')
                                checked @endif
                            @endif
                        >
                    </div>
                    <p class="text-danger jawaban_2-error my-0"></p>
                </div>
            </div>

            <div class="card my-3 p-0">
                <div class="card-body">
                    <p>3. Jika anda perempuan, apakah anda berencana menikah di usia lebih dari 35 tahun ? (Jawab Tidak
                        bila anda
                        laki-laki)</p>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">Ya</label>
                        <input class="form-check-input" type="radio" id="jawaban-3" name="jawaban_3[]" value="Ya"
                            @if ($randaKabilasa->mencegahPernikahanDini) @if ($randaKabilasa->mencegahPernikahanDini->jawaban_3 == 'Ya')
                                checked @endif
                            @endif
                        >
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">Tidak</label>
                        <input class="form-check-input" type="radio" id="jawaban-3" name="jawaban_3[]" value="Tidak"
                            @if ($randaKabilasa->mencegahPernikahanDini) @if ($randaKabilasa->mencegahPernikahanDini->jawaban_3 == 'Tidak')
                                checked @endif
                            @endif
                        >
                    </div>
                    <p class="text-danger jawaban_3-error my-0"></p>
                </div>
            </div>
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
                            <h5>Hasil Meningkatkan Life Skill & Potensi Diri</h5>
                            <p class="text-muted" id="tanggal-proses"> - </p>
                        </div>
                        <button type="button" class="btn-close float-end" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="alert kategori-alert rounded-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar rounded no-thumbnail kategori-bg text-light"><i id="kategori-emot"
                                    class=""></i></div>
                            <div class="w-100 align-items-center">
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

            });
        </script>
    @endif
    <script>
        function changeJawaban1() {
            var jawaban1 = $('#jawaban-1:checked').val();
            var jenisKelamin = '{{ $randaKabilasa->anggotaKeluarga->jenis_kelamin }}';
            if (jawaban1 == 'Ya') {
                $("#jawaban-2[value='Tidak']").prop("checked", "true");
                $("#jawaban-3[value='Tidak']").prop("checked", "true");
                $('#jawaban-2').attr('readonly', 'readonly');
                $('#jawaban-3').attr('readonly', 'readonly');
                $("#jawaban-2").attr('disabled', 'disabled');
                $("#jawaban-3").attr('disabled', 'disabled');
            } else {
                $('#jawaban-2').removeAttr('readonly');
                $('#jawaban-3').removeAttr('readonly');
                $("#jawaban-2").removeAttr('disabled');
                $("#jawaban-3").removeAttr('disabled');
                if (jenisKelamin == "LAKI-LAKI") {
                    $("#jawaban-3[value='Tidak']").prop("checked", "true");
                    $("#jawaban-3").attr('disabled', 'disabled');
                }
            }
        }

        function changeJawaban2() {
            var jawaban2 = $('#jawaban-2:checked').val();
            if (jawaban2 == 'Ya') {
                $("#jawaban-3[value='Tidak']").prop("checked", "true");
                $('#jawaban-3').attr('readonly', 'readonly');
                $("#jawaban-3").attr('disabled', 'disabled');
            } else {
                $('#jawaban-3').removeAttr('readonly');
                $("#jawaban-3").removeAttr('disabled');
            }
        }

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

        $(function() {
            $('.modal').modal({
                backdrop: 'static',
                keyboard: false
            })

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
                                    console.log(response);
                                    if (response.status == 'success') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: titleResult,
                                            text: textResult,
                                        }).then((result) => {
                                            // set location
                                            window.location.href =
                                                "{{ $back_url }}";
                                        })
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Terjadi kesalahan',
                                            text: 'Data gagal disimpan',
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
                                $('#modal-usia').text(data.usia_tahun);
                                $('#modal-kategori').text(data.kategori);
                                $('#modal-total-skor').text("Skor : " + data.total_skor);
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

                                if (data.kategori ==
                                    'Tidak Berpartisipasi Mencegah Stunting') {
                                    $('.kategori-bg').addClass('bg-danger');
                                    $('.kategori-alert').addClass('alert-danger');
                                    $('#kategori-emot').addClass('fa-solid fa-face-frown');
                                } else {
                                    $('.kategori-bg').addClass('bg-primary');
                                    $('.kategori-alert').addClass('alert-primary');
                                    $('#kategori-emot').addClass('fa-solid fa-face-surprise');
                                }
                            } else {
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
    </script>
@endpush
