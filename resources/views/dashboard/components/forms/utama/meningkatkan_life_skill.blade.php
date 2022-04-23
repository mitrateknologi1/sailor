<form id="{{ $form_id }}" action="#" method="POST" enctype="multipart/form-data">
    @csrf
    @if (isset($method) && $method == 'PUT')
        @method('PUT')
    @endif
    <div class="row g-4">
        <div class="col-sm-12 col-lg-6">
            @component('dashboard.components.formElements.input', [
                'label' => 'Nama Kepala Keluarga / Nomor KK',
                'type' => 'text',
                'id' => 'nama-kepala-keluarga',
                'name' => 'nama_kepala_keluarga',
                'class' => '',
                'wajib' => '<sup class="text-danger">*</sup>',
                'placeholder' => 'Nama Kepala Keluarga / Nomor KK',
                'attribute' => 'readonly',
                'value' => $randaKabilasa->anggotaKeluarga->kartuKeluarga->nama_kepala_keluarga . ' / ' .
                $randaKabilasa->anggotaKeluarga->kartuKeluarga->nomor_kk,
                ])
            @endcomponent
        </div>
        <div class="col-sm-12 col-lg-6">
            @component('dashboard.components.formElements.input', [
                'label' => 'Nama Remaja (Tanggal Lahir)',
                'type' => 'text',
                'id' => 'nama-remaja',
                'name' => 'nama_remaja',
                'class' => '',
                'wajib' => '<sup class="text-danger">*</sup>',
                'placeholder' => 'Nama Remaja',
                'attribute' => 'readonly',
                'value' => $randaKabilasa->anggotaKeluarga->nama_lengkap . ' (' .
                Carbon\Carbon::parse($randaKabilasa->anggotaKeluarga->tanggal_lahir)->translatedFormat('d F Y') . ')',
                ])
            @endcomponent
        </div>
        <div class="col-sm-12 col-lg-12">
            <h6 class="card-title mb-0">Pertanyaan</h6>
            @foreach ($daftarSoal as $soal)
                @php
                    $checkedYa = '';
                    $checkedTidak = '';
                @endphp
                @if (isset($method) && $method == 'PUT')
                    @php
                        $jawabanSoal = \App\Models\JawabanMeningkatkanLifeSkill::where('randa_kabilasa_id', $randaKabilasa->id)
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
                <div class="card my-3 p-0">
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
            @component('dashboard.components.buttons.process', [
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
                            @component('dashboard.components.buttons.submit', [
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
                        icon: 'warning',
                        title: 'Apakah data sudah sesuai?',
                        text: 'Jika sudah sesuai, maka data akan disimpan dan dilihat oleh Penyuluh BKKBN dan Dinas P2KB',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Simpan',
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
                                            title: 'Data berhasil disimpan',
                                            text: 'Data akan dilihat oleh Penyuluh BKKBN dan Dinas P2KB',
                                            showConfirmButton: false,
                                            timer: 2000,
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
