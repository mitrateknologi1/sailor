<form id="{{ $form_id }}" action="#" method="POST" enctype="multipart/form-data">
    @csrf
    @if (isset($method) && $method == 'PUT')
        @method('PUT')
    @endif
    <div class="row g-4">
        <div class="col-sm-12 col-md-6 col-lg">
            @component('dashboard.components.formElements.select', [
                'label' => 'Nama Kepala Keluarga / Nomor KK',
                'id' => 'nama-kepala-keluarga',
                'name' => 'nama_kepala_keluarga',
                'class' => 'select2',
                'wajib' => '<sup class="text-danger">*</sup>',
                ])
                @slot('options')
                    {{-- @if (Auth::user()->role != 'keluarga') --}}
                    @foreach ($kartuKeluarga as $kk)
                        <option value="{{ $kk->id }}"
                            {{ isset($anak) && $anak->anggotaKeluarga->kartuKeluarga->id == $kk->id ? 'selected' : '' }}>
                            {{ $kk->nama_kepala_keluarga }} / {{ $kk->nomor_kk }}</option>
                    @endforeach
                    {{-- @endif --}}
                @endslot
            @endcomponent
        </div>
        <div class="col-sm-12 col-md-6 col-lg">
            @component('dashboard.components.formElements.select', [
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
            <div class="col-sm-12 col-md-6 col-lg">
                @component('dashboard.components.formElements.select', [
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
                            <h5>Hasil Perkembangan Anak</h5>
                            <p class="text-muted" id="tanggal-proses"> - </p>
                        </div>
                        <button type="button" class="btn-close float-end" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="card fieldset border border-primary mb-4">
                        <span class="fieldset-tile text-primary bg-white">Motorik Kasar:</span>
                        <p class="text-primary mb-0" id="modal-motorik-kasar" style="text-align: justify">-</p>
                    </div>
                    <div class="card fieldset border border-secondary">
                        <span class="fieldset-tile text-secondary bg-white">Motorik Halus:</span>
                        <p class="text-secondary mb-0 " id="modal-motorik-halus" style="text-align: justify">-</p>
                    </div>
                    <div class="card fieldset border border-dark my-4">
                        <span class="fieldset-tile text-dark ml-5 bg-white">Info Anak:</span>
                        <div class="card-body p-0 py-1 px-1">
                            <ul class="list-unstyled mb-0">
                                <li class="justify-content-between mb-2">
                                    <label><i class="fa-solid fa-child"></i> Nama Anak:</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-nama-anak"> - </span>
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
                                <li class="justify-content-between">
                                    <label><i class="fa-solid fa-venus-mars"></i> Jenis Kelamin</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-jenis-kelamin"> -
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
    <script>
        if ('{{ $method }}' == 'PUT') {
            Swal.fire({
                title: 'Perhatian!',
                text: 'Apabila mengubah data, maka jumlah usia anak tidak lagi berpatokan dari tanggal sekarang dengan tanggal lahir anak. Tetapi jumlah usia anak terhitung dari tanggal data ini dibuat dengan tanggal lahir anak.',
                icon: 'warning',
            })
        }

        $(function() {

            if ($('#nama-kepala-keluarga').val() != '') {
                changeKepalaKeluarga()
            }

            $('#nama-kepala-keluarga').change(function() {
                changeKepalaKeluarga()
            })

            $('#nama-anak').change(function() {
                changeAnak()
            })

            $('#{{ $form_id }}').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                const formatYmd = date => date.toISOString().slice(0, 10);
                if ('{{ $method }}' == 'POST') {
                    formData.append('tanggal_proses', formatYmd(new Date()));
                } else {
                    formData.append('tanggal_proses',
                        '{{ isset($anak) ? $anak->created_at->format('Y-m-d') : null }}');
                }
                // formData.append('method', '{{ $method }}');

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
                                    if (response.res == 'success') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Data berhasil disimpan',
                                            text: 'Data akan dilihat oleh Penyuluh BKKBN dan Dinas P2KB',
                                            showConfirmButton: false,
                                            timer: 2000,
                                        }).then((result) => {
                                            window.location.href =
                                                "{{ $back_url }}";
                                        })
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Terjadi kesalahan',
                                            text: 'Data gagal disimpan',
                                            // showConfirmButton: false,
                                            // timer: 1500
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
                            if ($.isEmptyObject(data.error)) {
                                $('#modal-hasil').modal('show');
                                if ('{{ $method }}' == 'POST') {
                                    $('#tanggal-proses').text('Tanggal: ' + moment(data
                                        .tanggal_proses).format('LL'))
                                } else {
                                    $('#tanggal-proses').text('Dibuat Tanggal: ' + moment(data
                                        .tanggal_proses).format('LL'))
                                }
                                $('#modal-motorik-kasar').text(data.motorik_kasar);
                                $('#modal-motorik-halus').text(data.motorik_halus);
                                $('#modal-nama-anak').text(data.nama_anak);
                                $('#modal-tanggal-lahir').text(moment(data.tanggal_lahir)
                                    .format('LL'));
                                $('#modal-usia').text(data.usia_tahun);
                                $('#modal-jenis-kelamin').text(data.jenis_kelamin);
                                console.log(data)
                            } else {
                                Swal.fire(
                                    'Terjadi Kesalahan!',
                                    'Periksa kembali data yang anda masukkan',
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
                var id = '{{ Auth::user()->profil->id }}';
            }
            var rentang_umur = 'semua_umur';
            var id_anak = "{{ isset($anak) ? $anak->anggotaKeluarga->id : '' }}";
            var selected = '';
            $('#nama-anak').html('');
            $('#nama-anak').append('<option value="" selected hidden>- Pilih Salah Satu -</option>')
            changeAnak()
            $('#nama-bidan').html('');
            changeAnak()
            $('#nama-bidan').attr('disabled', true);
            $.get("{{ route('getAnak') }}", {
                id: id,
                rentang_umur: rentang_umur,
                method: "{{ $method }}",
                id_anak: id_anak
            }, function(result) {
                $.each(result.anggota_keluarga, function(key, val) {
                    var tanggal_lahir = moment(val.tanggal_lahir).format('LL');
                    selected = '';
                    if (val.id == "{{ isset($anak) ? $anak->anggotaKeluarga->id : '' }}") {
                        selected = 'selected';
                    }
                    $('#nama-anak').append(
                        `<option value="${val.id}" ${selected}>${val.nama_lengkap} (${tanggal_lahir})</option>`
                    );
                })

                if ("{{ $method }}" == 'PUT') {
                    selected = '';

                    if (result.anggota_keluarga_hapus) {
                        if (result.anggota_keluarga_hapus.id ==
                            "{{ isset($anak) ? $anak->anggotaKeluarga->id : '' }}") {
                            selected = 'selected';
                        }

                        $('#nama-anak').append(
                            `<option value="${result.anggota_keluarga_hapus.id}" ${selected}>${result.anggota_keluarga_hapus.nama_lengkap} (${moment(result.anggota_keluarga_hapus.tanggal_lahir).format('LL')})</option>`
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
