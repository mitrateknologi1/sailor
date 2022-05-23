<form id="{{ $form_id }}" action="#" method="POST" enctype="multipart/form-data">
    @csrf
    @if (isset($method) && $method == 'PUT')
        @method('PUT')
    @endif
    <div class="row g-4 mb-3">
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
                    'label' => 'Nama Ibu (Tanggal Lahir)',
                    'id' => 'nama-ibu',
                    'name' => 'nama_ibu',
                    'class' => 'select2',
                    'attribute' => 'disabled',
                    'wajib' => '<sup class="text-danger">*</sup>',
                ])
            @endcomponent
        </div>
        <div class="col-sm-12 col-lg">
            @component('dashboard.components.formElements.input',
                [
                    'label' => 'Pemeriksaan Ke',
                    'type' => 'text',
                    'id' => 'pemeriksaan_ke',
                    'name' => 'pemeriksaan_ke',
                    'class' => 'numerik',
                    'wajib' => '<sup class="text-danger">*</sup>',
                    'attribute' => 'readonly',
                    'placeholder' => 'Pemeriksaan Ke',
                ])
            @endcomponent
        </div>
    </div>
    <div class="row g-4">
        <div class="col-sm-12 col-lg-6">
            @component('dashboard.components.formElements.input',
                [
                    'label' => 'Tanggal Haid Terakhir (31-12-2022)',
                    'type' => 'text',
                    'id' => 'tanggal_haid_terakhir',
                    'name' => 'tanggal_haid_terakhir',
                    'class' => 'tanggal_haid',
                    'wajib' => '<sup class="text-danger">*</sup>',
                    'placeholder' => 'Masukkan Tanggal Haid Terakhir',
                ])
            @endcomponent
        </div>
        <div class="col-sm-12 col-lg-6">
            @component('dashboard.components.formElements.input',
                [
                    'label' => 'Kehamilan Ke',
                    'type' => 'text',
                    'id' => 'kehamilan_ke',
                    'name' => 'kehamilan_ke',
                    'class' => 'numerik',
                    'wajib' => '<sup class="text-danger">*</sup>',
                    'placeholder' => 'Masukkan Kehamilan Ke',
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
        <div class="col-sm-12 col-lg-6">
            @component('dashboard.components.formElements.input',
                [
                    'label' => 'Tekanan Darah Sistolik',
                    'type' => 'text',
                    'id' => 'tekanan_darah_sistolik',
                    'name' => 'tekanan_darah_sistolik',
                    'class' => 'numerik',
                    'wajib' => '<sup class="text-danger">*</sup>',
                    'placeholder' => 'Masukkan Tekanan Darah Sistolik',
                ])
            @endcomponent
        </div>
        <div class="col-sm-12 col-lg-6">
            @component('dashboard.components.formElements.input',
                [
                    'label' => 'Tekanan Darah Diastolik',
                    'type' => 'text',
                    'id' => 'tekanan_darah_diastolik',
                    'name' => 'tekanan_darah_diastolik',
                    'class' => 'numerik',
                    'wajib' => '<sup class="text-danger">*</sup>',
                    'placeholder' => 'Masukkan Tekanan Darah Diastolik',
                ])
            @endcomponent
        </div>
        <div class="col-sm-12 col-lg-6">
            @component('dashboard.components.formElements.input',
                [
                    'label' => 'Lengan Atas',
                    'type' => 'text',
                    'id' => 'lengan_atas',
                    'name' => 'lengan_atas',
                    'class' => 'numerik',
                    'wajib' => '<sup class="text-danger">*</sup>',
                    'placeholder' => 'Masukkan Lengan Atas',
                ])
            @endcomponent
        </div>
        <div class="col-sm-12 col-lg-6">
            @component('dashboard.components.formElements.input',
                [
                    'label' => 'Tinggi Fundus (Dalam Cm)',
                    'type' => 'text',
                    'id' => 'tinggi_fundus',
                    'name' => 'tinggi_fundus',
                    'class' => 'numerik',
                    'wajib' => '<sup class="text-danger">*</sup>',
                    'placeholder' => 'Masukkan Tinggi Fundus (Dalam Cm)',
                ])
            @endcomponent
        </div>
        <div class="col-sm-12 col-lg-6">
            @component('dashboard.components.formElements.input',
                [
                    'label' => 'Hemoglobin Darah',
                    'type' => 'text',
                    'id' => 'hemoglobin_darah',
                    'name' => 'hemoglobin_darah',
                    'class' => 'numerik',
                    'wajib' => '<sup class="text-danger">*</sup>',
                    'placeholder' => 'Masukkan Hemoglobin Darah',
                ])
            @endcomponent
        </div>
        <div class="col-sm-12 col-lg-6">
            @component('dashboard.components.formElements.input',
                [
                    'label' => 'Denyut Jantung Janin (Dalam Menit)',
                    'type' => 'text',
                    'id' => 'denyut_jantung',
                    'name' => 'denyut_jantung',
                    'class' => 'numerik',
                    'wajib' => '<sup class="text-danger">*</sup>',
                    'placeholder' => 'Masukkan Denyut Jantung Janin (Dalam Menit)',
                ])
            @endcomponent
        </div>
        <div class="col-sm-12 col-lg-6">
            @component('dashboard.components.formElements.select',
                [
                    'label' => 'Vaksin Tetanus (Sebelum Hamil)',
                    'id' => 'vaksin_tetanus_sebelum_hamil',
                    'name' => 'vaksin_tetanus_sebelum_hamil',
                    'class' => 'select2',
                    'wajib' => '<sup class="text-danger">*</sup>',
                ])
                @slot('options')
                    <option value="Sudah">Sudah</option>
                    <option value="Belum">Belum</option>
                @endslot
            @endcomponent
        </div>
        <div class="col-sm-12 col-lg-6">
            @component('dashboard.components.formElements.select',
                [
                    'label' => 'Vaksin Tetanus (Sesudah Hamil)',
                    'id' => 'vaksin_tetanus_sesudah_hamil',
                    'name' => 'vaksin_tetanus_sesudah_hamil',
                    'class' => 'select2',
                    'wajib' => '<sup class="text-danger">*</sup>',
                ])
                @slot('options')
                    <option value="Sudah">Sudah</option>
                    <option value="Belum">Belum</option>
                @endslot
            @endcomponent
        </div>
        <div class="col-sm-12 col-lg-4">
            @component('dashboard.components.formElements.select',
                [
                    'label' => 'Posisi Janin',
                    'id' => 'posisi_janin',
                    'name' => 'posisi_janin',
                    'class' => 'select2',
                    'wajib' => '<sup class="text-danger">*</sup>',
                ])
                @slot('options')
                    <option value="Normal">Normal</option>
                    <option value="Sungsang">Sungsang</option>
                @endslot
            @endcomponent
        </div>
        <div class="col-sm-12 col-lg-4">
            @component('dashboard.components.formElements.select',
                [
                    'label' => 'Minum 90 Tablet Tambah Darah',
                    'id' => 'minum_tablet',
                    'name' => 'minum_tablet',
                    'class' => 'select2',
                    'wajib' => '<sup class="text-danger">*</sup>',
                ])
                @slot('options')
                    <option value="Sudah">Sudah</option>
                    <option value="Belum">Belum</option>
                @endslot
            @endcomponent
        </div>
        <div class="col-sm-12 col-lg-4">
            @component('dashboard.components.formElements.select',
                [
                    'label' => 'Konseling',
                    'id' => 'konseling',
                    'name' => 'konseling',
                    'class' => 'select2',
                    'wajib' => '<sup class="text-danger">*</sup>',
                ])
                @slot('options')
                    <option value="Sudah">Sudah</option>
                    <option value="Belum">Belum</option>
                @endslot
            @endcomponent
        </div>
        @if (Auth::user()->role == 'admin' && $method == 'POST')
            <div class="col-sm-12 col-md-12">
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
        <div class="col-12 text-end">
            @component('dashboard.components.buttons.process',
                [
                    'id' => 'proses-anc',
                    'type' => 'submit',
                ])
            @endcomponent
        </div>
    </div>
    <div class="modal fade" id="modal-hasil" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body custom_scroll p-lg-4 pb-3">
                    <div class="d-flex w-100 justify-content-between">
                        <div>
                            <h5>Hasil Antenatal Care</h5>
                            <p class="text-muted mb-0" id="tanggal-proses"> - </p>
                        </div>
                        <button type="button" class="btn-close float-end" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="card fieldset border border-dark my-4">
                        <span class="fieldset-tile text-dark ml-5 bg-white">Info Ibu:</span>
                        <div class="card-body p-0 py-1 px-1">
                            <ul class="list-unstyled mb-0">
                                <li class="justify-content-between mb-2">
                                    <label><i class="fa-solid fa-child"></i> Nama Ibu:</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-nama-ibu"> - </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Pemeriksaan Ke:</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-pemeriksaan-ke"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Kehamilan Ke:</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-kehamilan-ke"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="bi bi-calendar2-event-fill"></i> Tanggal Lahir</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-tanggal-lahir"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="bi bi-calendar2-event-fill"></i> Tanggal Haid Terakhir</label>
                                    <span class="badge bg-info float-end text-uppercase"
                                        id="modal-tanggal-haid-terakhir"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="bi bi-calendar2-event-fill"></i> Usia Kehamilan :</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-usia-kehamilan"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="bi bi-calendar2-event-fill"></i> Tanggal Perkiraan Lahir :</label>
                                    <span class="badge bg-info float-end text-uppercase"
                                        id="modal-tanggal-perkiraan-lahir"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-ruler-combined"></i> Tinggi / Berat Badan :</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-tinggi-berat-badan">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pump-medical"></i> Sistolik / Diastolik :</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-sistolik-diastolik">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-hand-paper"></i> Lengan Atas :</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-lengan-atas">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-ruler-vertical"></i> Tinggi Fundus (Cm) :</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-tinggi-fundus">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-heart"></i> Hemoglobin Darah :</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-hemoglobin-darah">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-heartbeat"></i> Denyut Jantung Janin :</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-denyut-jantung">
                                        -
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card fieldset border border-dark my-4">
                        <span class="fieldset-tile text-dark ml-5 bg-white">Hasil :</span>
                        <div class="card-body p-0 py-1 px-1">
                            <ul class="list-unstyled mb-0">
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Badan:</label>
                                    <span class="badge float-end text-uppercase" id="modal-kategori-tinggi-badan"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Tekanan Darah:</label>
                                    <span class="badge float-end text-uppercase" id="modal-kategori-tekanan-darah"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Lengan Atas:</label>
                                    <span class="badge float-end text-uppercase" id="modal-kategori-lengan-atas"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Denyut Jantung:</label>
                                    <span class="badge float-end text-uppercase" id="modal-kategori-denyut-jantung"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Hemoglobin Darah:</label>
                                    <span class="badge float-end text-uppercase" id="modal-kategori-hemoglobin-darah">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Vaksin Tetanus Sebelum Hamil:</label>
                                    <span class="badge float-end text-uppercase"
                                        id="modal-vaksin-tetanus-sebelum-hamil">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Vaksin Tetanus Sesudah Hamil:</label>
                                    <span class="badge float-end text-uppercase"
                                        id="modal-vaksin-tetanus-sesudah-hamil">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Posisi Janin:</label>
                                    <span class="badge float-end text-uppercase" id="modal-posisi-janin">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Minum 90 Tablet Tambah darah:</label>
                                    <span class="badge float-end text-uppercase" id="modal-minum-tablet">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Konseling:</label>
                                    <span class="badge float-end text-uppercase" id="modal-konseling">
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
                                    'class' => 'text-white text-uppercase w-100 simpan',
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
                    '{{ $dataEdit->anggotaKeluarga->kartuKeluarga->id }}').change();
                $('#pemeriksaan_ke').val("{{ $dataEdit->pemeriksaan_ke }}");

                $('#tanggal_haid_terakhir').val(
                        "{{ date('d-m-Y', strtotime($dataEdit->pemeriksaanAnc->tanggal_haid_terakhir)) }}")
                    .change();
                $('#kehamilan_ke').val("{{ $dataEdit->pemeriksaanAnc->kehamilan_ke }}");
                $('#tinggi_badan').val("{{ $dataEdit->pemeriksaanAnc->tinggi_badan }}");
                $('#berat_badan').val("{{ $dataEdit->pemeriksaanAnc->berat_badan }}");
                $('#tekanan_darah_sistolik').val("{{ $dataEdit->pemeriksaanAnc->tekanan_darah_sistolik }}");
                $('#tekanan_darah_diastolik').val("{{ $dataEdit->pemeriksaanAnc->tekanan_darah_diastolik }}");
                $('#lengan_atas').val("{{ $dataEdit->pemeriksaanAnc->lengan_atas }}");
                $('#tinggi_fundus').val("{{ $dataEdit->pemeriksaanAnc->tinggi_fundus }}");
                $('#hemoglobin_darah').val("{{ $dataEdit->pemeriksaanAnc->hemoglobin_darah }}");
                $('#denyut_jantung').val("{{ $dataEdit->pemeriksaanAnc->denyut_jantung_janin }}");

                $('#vaksin_tetanus_sebelum_hamil').val(
                    '{{ $dataEdit->vaksin_tetanus_sebelum_hamil }}').change();
                $('#vaksin_tetanus_sesudah_hamil').val('{{ $dataEdit->vaksin_tetanus_sesudah_hamil }}')
                    .change();
                $('#posisi_janin').val('{{ $dataEdit->posisi_janin }}')
                    .change();
                $('#minum_tablet').val('{{ $dataEdit->minum_tablet }}')
                    .change();
                $('#konseling').val('{{ $dataEdit->konseling }}')
                    .change();
            });
        </script>
    @endif
    <script>
        $('.tanggal').mask('00-00-0000');
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

            $('#nama-ibu').change(function() {
                changeIbu()
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
                                $('#tanggal-proses').text('Tanggal : ' + moment().format('LL'))
                                $('#modal-nama-ibu').text(data.nama_ibu);
                                $('#modal-tanggal-lahir').text(moment(data.tanggal_lahir)
                                    .format('LL'));
                                $('#modal-usia').text(data.usia_tahun);
                                $('#modal-status').text(data.status);
                                $('#modal-tanggal-haid-terakhir').text(data
                                    .tanggal_haid_terakhir_sebut);
                                $('#modal-pemeriksaan-ke').text(data
                                    .pemeriksaan_ke);
                                $('#modal-kehamilan-ke').text(data
                                    .kehamilan_ke);
                                $('#modal-tanggal-perkiraan-lahir').text(data
                                    .tanggal_perkiraan_lahir_sebut);
                                $('#modal-kategori-tinggi-badan').text(data
                                    .kategori_tinggi_badan);
                                $('#modal-kategori-tekanan-darah').text(data
                                    .kategori_tekanan_darah);
                                $('#modal-kategori-lengan-atas').text(data
                                    .kategori_lengan_atas);
                                $('#modal-kategori-denyut-jantung').text(data
                                    .kategori_denyut_jantung);
                                $('#modal-kategori-hemoglobin-darah').text(data
                                    .kategori_hemoglobin_darah);
                                $('#modal-tinggi-berat-badan').text(data
                                    .tinggi_badan + " Cm / " + data
                                    .berat_badan + " Kg");
                                $('#modal-sistolik-diastolik').text(data
                                    .tekanan_darah_sistolik + " / " + data
                                    .tekanan_darah_diastolik);
                                $('#modal-usia-kehamilan').text(data
                                    .usia_kehamilan + ' Minggu Lagi');
                                $('#modal-lengan-atas').text(data
                                    .lengan_atas);
                                $('#modal-tinggi-fundus').text(data
                                    .tinggi_fundus);
                                $('#modal-hemoglobin-darah').text(data
                                    .hemoglobin_darah);
                                $('#modal-denyut-jantung').text(data
                                    .denyut_jantung);
                                $('#modal-vaksin-tetanus-sebelum-hamil').text(data
                                    .vaksin_tetanus_sebelum_hamil);
                                $('#modal-vaksin-tetanus-sesudah-hamil').text(data
                                    .vaksin_tetanus_sesudah_hamil);
                                $('#modal-posisi-janin').text(data
                                    .posisi_janin);
                                $('#modal-minum-tablet').text(data
                                    .minum_tablet);
                                $('#modal-konseling').text(data
                                    .konseling);

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

                                if (data.kategori_tinggi_badan == 'Resiko Tinggi') {
                                    $('#modal-kategori-tinggi-badan').addClass('bg-danger');
                                } else {
                                    $('#modal-kategori-tinggi-badan').addClass('bg-success');
                                }

                                if (data.kategori_tekanan_darah == 'Hipotensi') {
                                    $('#modal-kategori-tekanan-darah').addClass('bg-primary');
                                } else if (data.kategori_tekanan_darah == 'Normal') {
                                    $('#modal-kategori-tekanan-darah').addClass('bg-success');
                                } else if (data.kategori_tekanan_darah == 'Prahipertensi') {
                                    $('#modal-kategori-tekanan-darah').addClass('bg-warning');
                                } else {
                                    $('#modal-kategori-tekanan-darah').addClass('bg-danger');
                                }

                                if (data.kategori_lengan_atas == 'Kurang Gizi (BBLR)') {
                                    $('#modal-kategori-lengan-atas').addClass('bg-danger');
                                } else {
                                    $('#modal-kategori-lengan-atas').addClass('bg-success');
                                }

                                if (data.kategori_denyut_jantung == 'Normal') {
                                    $('#modal-kategori-denyut-jantung').addClass('bg-success');
                                } else {
                                    $('#modal-kategori-denyut-jantung').addClass('bg-danger');
                                }

                                if (data.kategori_hemoglobin_darah == 'Normal') {
                                    $('#modal-kategori-hemoglobin-darah').addClass(
                                        'bg-success');
                                } else {
                                    $('#modal-kategori-hemoglobin-darah').addClass('bg-danger');
                                }

                                if (data.vaksin_tetanus_sebelum_hamil == 'Sudah') {
                                    $('#modal-vaksin-tetanus-sebelum-hamil').addClass(
                                        'bg-success');
                                } else {
                                    $('#modal-vaksin-tetanus-sebelum-hamil').addClass(
                                        'bg-danger');
                                }

                                if (data.vaksin_tetanus_sesudah_hamil == 'Sudah') {
                                    $('#modal-vaksin-tetanus-sesudah-hamil').addClass(
                                        'bg-success');
                                } else {
                                    $('#modal-vaksin-tetanus-sesudah-hamil').addClass(
                                        'bg-danger');
                                }

                                if (data.posisi_janin == 'Normal') {
                                    $('#modal-posisi-janin').addClass('bg-success');
                                } else {
                                    $('#modal-posisi-janin').addClass('bg-danger');
                                }

                                if (data.minum_tablet == 'Sudah') {
                                    $('#modal-minum-tablet').addClass('bg-success');
                                } else {
                                    $('#modal-minum-tablet').addClass('bg-danger');
                                }

                                if (data.konseling == 'Sudah') {
                                    $('#modal-konseling').addClass('bg-success');
                                } else {
                                    $('#modal-konseling').addClass('bg-danger');
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

        function changeKepalaKeluarga() {
            if ('{{ Auth::user()->role }}' != 'keluarga') {
                var id = $('#nama-kepala-keluarga').val();
            } else {
                var id = '{{ Auth::user()->profil->kartu_keluarga_id }}';
            }
            var id_edit = "{{ isset($dataEdit) ? $dataEdit->anggota_keluarga_id : '' }}";
            var selected = '';
            $('#nama-ibu').html('');
            $('#nama-ibu').append('<option value="" selected hidden>- Pilih Salah Satu -</option>')
            $.get("{{ url('get-ibu') }}", {
                id: id,
                method: "{{ $method }}",
                id_edit: id_edit
            }, function(result) {
                $.each(result.anggota_keluarga, function(key, val) {
                    var tanggal_lahir = moment(val.tanggal_lahir).format('LL');
                    selected = '';
                    if (val.id == "{{ isset($dataEdit) ? $dataEdit->anggota_keluarga_id : '' }}") {
                        selected = 'selected';
                    }
                    $('#nama-ibu').append(
                        `<option value="${val.id}" ${selected}>${val.nama_lengkap} (${tanggal_lahir})</option>`
                    );
                })

                if ("{{ $method }}" == 'PUT') {
                    selected = '';

                    if (result.anggota_keluarga_hapus) {
                        if (result.anggota_keluarga_hapus.id ==
                            "{{ isset($dataEdit) ? $dataEdit->anggota_keluarga_id : '' }}") {
                            selected = 'selected';
                        }

                        $('#nama-ibu').append(
                            `<option value="${result.anggota_keluarga_hapus.id}" ${selected}>${result.anggota_keluarga_hapus.nama_lengkap} (${result.anggota_keluarga_hapus.tanggal_lahir})</option>`
                        );

                    }
                }
                $('#nama-ibu').removeAttr('disabled');
            });
        }

        function changeIbu() {
            var id = $('#nama-ibu').val();
            $.get("{{ url('anc-cek-pemeriksaan') }}", {
                method: "{{ $method }}",
                idIbu: id,
                idEdit: "{{ $dataEdit->id ?? '' }}"
            }, function(result) {
                $('#pemeriksaan_ke').val(result);
            });

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
    </script>
@endpush
