@extends('dashboard.layouts.main')

@section('title')
    Antenatal Care
@endsection

@push('style')
    <style>

    </style>
@endpush

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb mb-0 bg-transparent">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Moms Care</li>
            <li class="breadcrumb-item active" aria-current="page">Antenatal Care</li>
        </ol>
    </div>
@endsection

@section('content')
    <section>
        <div class="row mb-4">
            <div class="col">
                <div class="card">
                    <div
                        class="card-header bg-light-secondary d-flex justify-content-between align-items-center border-bottom-0 pt-3 pb-0">
                        <h5 class="card-title mb-0">Data Antenatal Care</h5>
                        @if (Auth::user()->role != 'penyuluh')
                            @component('dashboard.components.buttons.add',
                                [
                                    'id' => 'catatan-anc',
                                    'class' => '',
                                    'url' => '/anc/create',
                                ])
                            @endcomponent
                        @endif
                    </div>
                    <div class="card-body pt-2">
                        <div class="row mb-0">
                            @component('dashboard.components.info.fiturUtama')
                            @endcomponent
                            <div class="col">
                                <div class="card fieldset border-secondary mb-4 border">
                                    <span class="fieldset-tile text-secondary bg-white">Filter Data</span>
                                    @if (Auth::user()->role != 'penyuluh')
                                        <div class="row">
                                            <div class="col-lg-12 mt-2">
                                                @component('dashboard.components.formElements.select',
                                                    [
                                                        'label' => 'Status',
                                                        'id' => 'status-validasi',
                                                        'name' => 'status',
                                                        'class' => 'filter',
                                                    ])
                                                    @slot('options')
                                                        <option value="Tervalidasi">Tervalidasi</option>
                                                        <option value="Belum Tervalidasi">Belum Divalidasi</option>
                                                    @endslot
                                                @endcomponent
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-lg-4 mt-2">
                                            @component('dashboard.components.formElements.select',
                                                [
                                                    'label' => 'Kategori Badan',
                                                    'id' => 'kategori_badan',
                                                    'name' => 'kategori_badan',
                                                    'class' => 'filter',
                                                ])
                                                @slot('options')
                                                    <option value="Resiko Tinggi">Resiko Tinggi</option>
                                                    <option value="Normal">Normal</option>
                                                @endslot
                                            @endcomponent
                                        </div>
                                        <div class="col-lg-4 mt-2">
                                            @component('dashboard.components.formElements.select',
                                                [
                                                    'label' => 'Kategori Tekanan Darah',
                                                    'id' => 'kategori_tekanan_darah',
                                                    'name' => 'kategori_tekanan_darah',
                                                    'class' => 'filter',
                                                ])
                                                @slot('options')
                                                    <option value="Hipotensi">Hipotensi</option>
                                                    <option value="Normal">Normal</option>
                                                    <option value="Prahipertensi">Prahipertensi</option>
                                                    <option value="Hipertensi">Hipertensi</option>
                                                @endslot
                                            @endcomponent
                                        </div>
                                        <div class="col-lg-4 mt-2">
                                            @component('dashboard.components.formElements.select',
                                                [
                                                    'label' => 'Kategori Lengan Atas',
                                                    'id' => 'kategori_lengan_atas',
                                                    'name' => 'kategori_lengan_atas',
                                                    'class' => 'filter',
                                                ])
                                                @slot('options')
                                                    <option value="Kurang Gizi (BBLR)">Kurang Gizi (BBLR)</option>
                                                    <option value="Normal">Normal</option>
                                                @endslot
                                            @endcomponent
                                        </div>
                                        <div class="col-lg-4 mt-2">
                                            @component('dashboard.components.formElements.select',
                                                [
                                                    'label' => 'Kategori Denyut Jantung',
                                                    'id' => 'kategori_denyut_jantung',
                                                    'name' => 'kategori_denyut_jantung',
                                                    'class' => 'filter',
                                                ])
                                                @slot('options')
                                                    <option value="Normal">Normal</option>
                                                    <option value="Tidak Normal">Tidak Normal</option>
                                                @endslot
                                            @endcomponent
                                        </div>
                                        <div class="col-lg-4 mt-2">
                                            @component('dashboard.components.formElements.select',
                                                [
                                                    'label' => 'Kategori Hemoglobin Darah',
                                                    'id' => 'kategori_hemoglobin_darah',
                                                    'name' => 'kategori_hemoglobin_darah',
                                                    'class' => 'filter',
                                                ])
                                                @slot('options')
                                                    <option value="Normal">Normal</option>
                                                    <option value="Anemia">Anemia</option>
                                                @endslot
                                            @endcomponent
                                        </div>
                                        <div class="col-lg-4 mt-2">
                                            @component('dashboard.components.formElements.select',
                                                [
                                                    'label' => 'Vaksin Tetanus Sebelum Hamil',
                                                    'id' => 'kategori_vaksin_sebelum_hamil',
                                                    'name' => 'kategori_vaksin_sebelum_hamil',
                                                    'class' => 'filter',
                                                ])
                                                @slot('options')
                                                    <option value="Sudah">Sudah</option>
                                                    <option value="Belum">Belum</option>
                                                @endslot
                                            @endcomponent
                                        </div>
                                        <div class="col-lg-4 mt-2">
                                            @component('dashboard.components.formElements.select',
                                                [
                                                    'label' => 'Vaksin Tetanus Sesudah Hamil',
                                                    'id' => 'kategori_vaksin_sesudah_hamil',
                                                    'name' => 'kategori_vaksin_sesudah_hamil',
                                                    'class' => 'filter',
                                                ])
                                                @slot('options')
                                                    <option value="Sudah">Sudah</option>
                                                    <option value="Belum">Belum</option>
                                                @endslot
                                            @endcomponent
                                        </div>
                                        <div class="col-lg-4 mt-2">
                                            @component('dashboard.components.formElements.select',
                                                [
                                                    'label' => 'Posisi Janin',
                                                    'id' => 'kategori_posisi_janin',
                                                    'name' => 'kategori_posisi_janin',
                                                    'class' => 'filter',
                                                ])
                                                @slot('options')
                                                    <option value="Normal">Normal</option>
                                                    <option value="Sungsang">Sungsang</option>
                                                @endslot
                                            @endcomponent
                                        </div>
                                        <div class="col-lg-4 mt-2">
                                            @component('dashboard.components.formElements.select',
                                                [
                                                    'label' => 'Minum 90 Tablet Penambah Darah',
                                                    'id' => 'kategori_minum_tablet',
                                                    'name' => 'kategori_minum_tablet',
                                                    'class' => 'filter',
                                                ])
                                                @slot('options')
                                                    <option value="Sudah">Sudah</option>
                                                    <option value="Belum">Belum</option>
                                                @endslot
                                            @endcomponent
                                        </div>
                                        <div class="col-lg-4 mt-2">
                                            @component('dashboard.components.formElements.select',
                                                [
                                                    'label' => 'Konseling',
                                                    'id' => 'kategori_konseling',
                                                    'name' => 'kategori_konseling',
                                                    'class' => 'filter',
                                                ])
                                                @slot('options')
                                                    <option value="Sudah">Sudah</option>
                                                    <option value="Belum">Belum</option>
                                                @endslot
                                            @endcomponent
                                        </div>
                                    </div>
                                    @component('dashboard.components.filter.wilayah',
                                        [
                                            'fitur' => 'anc',
                                        ])
                                    @endcomponent
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="card fieldset border-secondary border">
                                    @component('dashboard.components.dataTables.index',
                                        [
                                            'id' => 'table-data',
                                            'th' => [
                                                'No',
                                                'Dibuat Tanggal',
                                                'Status',
                                                'Nama Ibu',
                                                'Pemeriksaan Ke',
                                                'Tanggal Haid
                                                                                                                                                                                                                                                                Terakhir',
                                                'Kehamilan Ke',
                                                'Usia Kehamilan',
                                                'Tanggal Perkiraan Lahir',
                                                'Tinggi/Berat
                                                                                                                                                                                                                                                                Badan',
                                                'Tekanan Darah',
                                                'Lengan Atas',
                                                'Tinggi Fundus',
                                                'Hemoglobin Darah',
                                                'Denyut
                                                                                                                                                                                                                                                                Jantung',
                                                'Kategori Badan',
                                                'Kategori Tekanan Darah',
                                                'Kategori Lengan Atas',
                                                'Kategori
                                                                                                                                                                                                                                                                Denyut Jantung',
                                                'Kategori
                                                                                                                                                                                                                                                                Hemoglobin Darah',
                                                'Vaksin Tetanus Sebelum Hamil',
                                                'Vaksin Tetanus Sesudah Hamil',
                                                'Posisi
                                                                                                                                                                                                                                                                Janin',
                                                'Minum 90 Tablet Tambah Darah',
                                                'Konseling',
                                                'Desa / Kelurahan',
                                                'Bidan',
                                                'Tanggal Validasi',
                                                'Aksi',
                                            ],
                                        ])
                                    @endcomponent
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modal-lihat" tabindex="-1" aria-hidden="true">
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
                                    <span class="badge bg-info float-end text-uppercase" id="modal-tanggal-haid-terakhir"> -
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
                                        id="modal-tanggal-perkiraan-lahir">
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
                                    <span class="badge float-end text-uppercase kategori-bg"
                                        id="modal-kategori-tinggi-badan"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Tekanan Darah:</label>
                                    <span class="badge float-end text-uppercase kategori-bg"
                                        id="modal-kategori-tekanan-darah"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Lengan Atas:</label>
                                    <span class="badge float-end text-uppercase kategori-bg"
                                        id="modal-kategori-lengan-atas"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Denyut Jantung:</label>
                                    <span class="badge float-end text-uppercase kategori-bg"
                                        id="modal-kategori-denyut-jantung"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Hemoglobin Darah:</label>
                                    <span class="badge float-end text-uppercase kategori-bg"
                                        id="modal-kategori-hemoglobin-darah">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Vaksin Tetanus Sebelum Hamil:</label>
                                    <span class="badge float-end text-uppercase kategori-bg"
                                        id="modal-vaksin-tetanus-sebelum-hamil">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Vaksin Tetanus Sesudah Hamil:</label>
                                    <span class="badge float-end text-uppercase kategori-bg"
                                        id="modal-vaksin-tetanus-sesudah-hamil">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Posisi Janin:</label>
                                    <span class="badge float-end text-uppercase kategori-bg" id="modal-posisi-janin">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Minum 90 Tablet Tambah darah:</label>
                                    <span class="badge float-end text-uppercase kategori-bg" id="modal-minum-tablet">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Konseling:</label>
                                    <span class="badge float-end text-uppercase kategori-bg" id="modal-konseling">
                                        -
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row g-3 align-items-end" id="form-konfirmasi">
                        <div class="col-lg col-sm-12" id="pilih-konfirmasi">
                            @component('dashboard.components.formElements.select',
                                [
                                    'label' => 'Konfirmasi',
                                    'id' => 'konfirmasi',
                                    'name' => 'konfirmasi',
                                    'class' => 'kosong',
                                    'wajib' => '<sup class="text-danger">*</sup>',
                                ])
                                @slot('options')
                                    <option value="1">Validasi</option>
                                    <option value="2">Tolak</option>
                                @endslot
                            @endcomponent
                        </div>
                        @if (Auth::user()->role == 'admin')
                            <div class="col-lg col-sm-12" id="pilih-bidan">
                                @component('dashboard.components.formElements.select',
                                    [
                                        'label' => 'Bidan sesuai lokasi domisili kepala keluarga',
                                        'id' => 'nama-bidan',
                                        'name' => 'bidan_id',
                                        'class' => 'bidan_id',
                                        'wajib' => '<sup class="text-danger">*</sup>',
                                    ])
                                @endcomponent
                            </div>
                        @endif
                        <div class="col-12 mt-3 d-none" id="col-alasan">
                            <label for="textareaInput" class="form-label">Alasan <sup class="text-danger">*</sup></label>
                            <textarea name="alasan" id="alasan" cols="30" rows="5" class="form-control alasan"></textarea>
                            <span class="text-danger error-text alasan-error"></span>
                        </div>
                    </div>
                    <div class="row g-2 mt-3">
                        <div class="col">
                            <button class="btn btn-outline-dark text-uppercase w-100" data-bs-dismiss="modal"
                                aria-label="Close"><i class="bi bi-x-circle"></i> Tutup</button>
                        </div>
                        <div class="col-sm-12 col-lg-8" id="col-modal-btn-ubah">
                            @component('dashboard.components.buttons.edit',
                                [
                                    'id' => 'modal-btn-ubah',
                                ])
                            @endcomponent
                        </div>
                        <div class="col-sm-12 col-lg-8" id="col-modal-btn-konfirmasi">
                            @component('dashboard.components.buttons.konfirmasi',
                                [
                                    'id' => 'modal-btn-konfirmasi',
                                ])
                            @endcomponent
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $('#m-link-moms-care').addClass('active');
        $('#menu-moms-care').addClass('collapse show')
        $('#ms-link-anc').addClass('active')
    </script>

    <script>
        $(document).on('click', '#btn-delete', function() {
            let id = $(this).val();

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda akan menghapus data ini ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ url('anc') }}" + '/' + id,
                        type: 'DELETE',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire(
                                    'Terhapus!',
                                    'Data berhasil dihapus.',
                                    'success'
                                ).then(function() {
                                    table.draw();
                                })
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    'Data gagal dihapus.',
                                    'error'
                                )
                            }
                        }
                    })
                }
            })
        })

        $(document).on('click', '#btn-lihat', function() {
            let id = $(this).val();
            $.ajax({
                type: "GET",
                url: "{{ url('anc') }}" + '/' + id,
                success: function(data) {
                    $('#col-modal-btn-ubah').addClass('d-none');
                    $('#col-modal-btn-konfirmasi').addClass('d-none');
                    $('#li-modal-tanggal-konfirmasi').addClass('d-none');
                    $('#li-modal-oleh-bidan').addClass('d-none');
                    $('#form-konfirmasi').addClass('d-none');
                    $('#col-alasan').addClass('d-none');
                    $('#konfirmasi').val('');
                    $('#nama-bidan').val('');
                    $('#alasan').val('');

                    $('#modal-lihat').modal('show');
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

                    if (data.is_valid == 0) {
                        $('#modal-status-konfirmasi').text('Belum Divalidasi');
                        $('#col-modal-btn-konfirmasi').removeClass('d-none');
                        $('#form-konfirmasi').removeClass('d-none');
                        $('#konfirmasi').change(function() {
                            if ($('#konfirmasi').val() == 1) {
                                $('#col-alasan').addClass('d-none');
                            } else {
                                $('#col-alasan').removeClass('d-none');
                            }
                            $('#alasan').val('');
                        })
                        if ('{{ Auth::user()->role }}' == 'admin') {
                            $.each(data.bidan_konfirmasi, function(key, val) {
                                $('#nama-bidan').html('')
                                $('#nama-bidan').append(
                                    '<option value="" selected hidden>- Pilih Salah Satu -</option>'
                                )
                                $('#nama-bidan').append(
                                    `<option value="${val.id}">${val.nama_lengkap}</option>`
                                );
                            })
                        } else if ('{{ Auth::user()->role }}' == 'bidan') {
                            $('#pilih-bidan').addClass('d-none');
                        }

                        $('#modal-btn-konfirmasi').val(id)

                    } else {
                        $('#li-modal-tanggal-konfirmasi').removeClass('d-none');
                        $('#li-modal-oleh-bidan').removeClass('d-none');
                        if (data.is_valid == 1) {
                            $('#modal-status-konfirmasi').text('Tervalidasi');
                            if (('{{ Auth::user()->profil->nama_lengkap }}' == data.bidan) || (
                                    '{{ Auth::user()->role }}' == 'admin')) {
                                $('#col-modal-btn-ubah').removeClass('d-none');
                                $('#modal-btn-ubah').attr('href', '{{ url('pertumbuhan-anak') }}' +
                                    '/' + id + '/edit');
                            } else {
                                $('#col-modal-btn-ubah').addClass('d-none');
                            }
                        } else if (data.is_valid == 2) {
                            $('#modal-status-konfirmasi').text('Ditolak');
                        }
                        $('#modal-tanggal-konfirmasi').text(moment(data.tanggal_validasi).format('LL'));
                        $('#modal-oleh-bidan').text(data.bidan);
                    }

                    if (('{{ Auth::user()->profil->nama_lengkap }}' == data.bidan) || (
                            '{{ Auth::user()->role }}' == 'admin')) {
                        $('#col-modal-btn-ubah').show();
                    } else {
                        $('#col-modal-btn-ubah').hide();
                    }

                    if (("{{ Auth::user()->profil->id }}" == data.bidan_id) || (
                            "{{ Auth::user()->role }}" ==
                            "admin")) {
                        $('#modal-btn-ubah').attr('href', "{{ url('anc') }}" + '/' +
                            id + '/edit');
                        $('#modal-btn-ubah').show();
                    } else {
                        $('#modal-btn-ubah').hide();
                    }

                },
            })
        })

        $(document).on('click', '#modal-btn-konfirmasi', function() {
            let id = $(this).val();
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Konfirmasi data perkiraan melahirkan ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, Konfirmasi'
            }).then((result) => {
                if (result.value) {
                    $('.error-text').text('');
                    $.ajax({
                        type: "PUT",
                        url: "{{ url('anc/validasi') }}" + '/' + id,
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id,
                            bidan_id: '{{ Auth::user()->role }}' == "admin" ? $("#nama-bidan")
                                .val() : '{{ Auth::user()->profil->id }}',
                            konfirmasi: $('#konfirmasi').val(),
                            alasan: $('#alasan').val()
                        },
                        success: function(response) {
                            if ($.isEmptyObject(response.error)) {
                                if (response.res == 'success') {
                                    if (response.konfirmasi == 1) {
                                        Swal.fire(
                                            'Berhasil!',
                                            'Data berhasil divalidasi.',
                                            'success'
                                        ).then(function() {
                                            table.draw();
                                            $('#modal-lihat').modal('hide');
                                        })
                                    } else {
                                        Swal.fire(
                                            'Berhasil!',
                                            'Data berhasil ditolak.',
                                            'success'
                                        ).then(function() {
                                            table.draw();
                                            $('#modal-lihat').modal('hide');

                                        })
                                    }
                                }
                            } else {
                                $('#overlay').hide();
                                printErrorMsg(response.error);

                                Swal.fire(
                                    'Terjadi Kesalahan!',
                                    'Periksa kembali data yang anda masukkan',
                                    'error'
                                )
                            }
                        }
                    })
                }
            })
        })

        const printErrorMsg = (msg) => {
            $.each(msg, function(key, value) {
                $('.' + key + '-error').text(value);
            });
        }
    </script>

    <script>
        var table = $('#table-data').DataTable({
            processing: true,
            serverSide: true,
            dom: 'lBfrtip',
            buttons: [{
                    extend: 'excel',
                    className: 'btn btn-sm btn-light-success px-2 btn-export-table d-inline ml-3 font-weight',
                    text: '<i class="bi bi-file-earmark-arrow-down"></i> Ekspor Data',
                    exportOptions: {
                        modifier: {
                            order: 'index', // 'current', 'applied', 'index',  'original'
                            page: 'all', // 'all',     'current'
                            search: 'applied' // 'none',    'applied', 'removed'
                        },
                        columns: ':visible'
                    }
                },
                {
                    extend: 'colvis',
                    className: 'btn btn-sm btn-light-success px-2 btn-export-table d-inline ml-3 font-weight',
                    text: '<i class="bi bi-eye-fill"></i> Tampil/Sembunyi Kolom',
                }
            ],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            ajax: {
                url: "{{ url('anc') }}",
                data: function(d) {
                    d.statusValidasi = $('#status-validasi').val();
                    d.kategori_badan = $('#kategori_badan').val();
                    d.kategori_tekanan_darah = $('#kategori_tekanan_darah').val();
                    d.kategori_lengan_atas = $('#kategori_lengan_atas').val();
                    d.kategori_denyut_jantung = $('#kategori_denyut_jantung').val();
                    d.kategori_hemoglobin_darah = $('#kategori_hemoglobin_darah').val();
                    d.kategori_vaksin_sebelum_hamil = $('#kategori_vaksin_sebelum_hamil').val();
                    d.kategori_vaksin_sesudah_hamil = $('#kategori_vaksin_sesudah_hamil').val();
                    d.kategori_posisi_janin = $('#kategori_posisi_janin').val();
                    d.kategori_minum_tablet = $('#kategori_minum_tablet').val();
                    d.kategori_konseling = $('#kategori_konseling').val();
                    d.search = $('input[type="search"]').val();
                    d.provinsi = $('#provinsi_filter').val();
                    d.kabupaten = $('#kabupaten_filter').val();
                    d.kecamatan = $('#kecamatan_filter').val();
                    d.desa = $('#desa_filter').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'tanggal_dibuat',
                    name: 'tanggal_dibuat',
                    className: 'text-center',
                },
                {
                    data: 'status',
                    name: 'status',
                    className: 'text-center',
                },
                {
                    data: 'nama_ibu',
                    name: 'nama_ibu'
                },
                {
                    data: 'pemeriksaan_ke',
                    name: 'pemeriksaan_ke',
                    className: 'text-center',
                },
                {
                    data: 'tanggal_haid_terakhir',
                    name: 'tanggal_haid_terakhir',
                    className: 'text-center',
                },
                {
                    data: 'kehamilan_ke',
                    name: 'kehamilan_ke',
                    className: 'text-center',
                },
                {
                    data: 'usia_kehamilan',
                    name: 'usia_kehamilan',
                    className: 'text-center',
                },
                {
                    data: 'tanggal_perkiraan_lahir',
                    name: 'tanggal_perkiraan_lahir',
                    className: 'text-center',
                },
                {
                    data: 'tinggi_berat_badan',
                    name: 'tinggi_berat_badan',
                    className: 'text-center',
                },
                {
                    data: 'tekanan_darah',
                    name: 'tekanan_darah',
                    className: 'text-center',
                },
                {
                    data: 'lengan_atas',
                    name: 'lengan_atas',
                    className: 'text-center',
                },
                {
                    data: 'tinggi_fundus',
                    name: 'tinggi_fundus',
                    className: 'text-center',
                },
                {
                    data: 'hemoglobin_darah',
                    name: 'hemoglobin_darah',
                    className: 'text-center',
                },
                {
                    data: 'denyut_jantung_janin',
                    name: 'denyut_jantung_janin',
                    className: 'text-center',
                },
                {
                    data: 'kategori_badan',
                    name: 'kategori_badan',
                    className: 'text-center',
                },
                {
                    data: 'kategori_tekanan_darah',
                    name: 'kategori_tekanan_darah',
                    className: 'text-center',
                },
                {
                    data: 'kategori_lengan_atas',
                    name: 'kategori_lengan_atas',
                    className: 'text-center',
                },
                {
                    data: 'kategori_denyut_jantung',
                    name: 'kategori_denyut_jantung',
                    className: 'text-center',
                },
                {
                    data: 'kategori_hemoglobin_darah',
                    name: 'kategori_hemoglobin_darah',
                    className: 'text-center',
                },
                {
                    data: 'vaksin_tetanus_sebelum_hamil',
                    name: 'vaksin_tetanus_sebelum_hamil',
                    className: 'text-center',
                },
                {
                    data: 'vaksin_tetanus_sesudah_hamil',
                    name: 'vaksin_tetanus_sesudah_hamil',
                    className: 'text-center',
                },
                {
                    data: 'posisi_janin',
                    name: 'posisi_janin',
                    className: 'text-center',
                },
                {
                    data: 'minum_tablet',
                    name: 'minum_tablet',
                    className: 'text-center',
                },
                {
                    data: 'konseling',
                    name: 'konseling',
                    className: 'text-center',
                },
                {
                    data: 'desa_kelurahan',
                    name: 'desa_kelurahan',
                    className: 'text-center',
                },
                {
                    data: 'bidan',
                    name: 'bidan',
                    className: 'text-center',
                },
                {
                    data: 'tanggal_validasi',
                    name: 'tanggal_validasi',
                    className: 'text-center',
                },
                {
                    data: 'action',
                    name: 'action',
                    className: 'text-center',
                    orderable: true,
                    searchable: true
                },

            ],
            columnDefs: [{
                    targets: 9,
                    visible: false,
                },
                {
                    targets: 10,
                    visible: false,
                },
                {
                    targets: 11,
                    visible: false,
                },
                {
                    targets: 12,
                    visible: false,
                },
                {
                    targets: 13,
                    visible: false,
                },
                {
                    targets: 14,
                    visible: false,
                },
                {
                    targets: 18,
                    visible: false,
                },
                {
                    targets: 20,
                    visible: false,
                },
                {
                    targets: 21,
                    visible: false,
                },
                {
                    targets: 22,
                    visible: false,
                },
                {
                    targets: 24,
                    visible: false,
                },
            ],
        });
    </script>

    <script>
        $('.filter').change(function() {
            table.draw();
        })
    </script>
@endpush
