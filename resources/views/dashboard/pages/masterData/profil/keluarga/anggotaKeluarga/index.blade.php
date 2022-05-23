@extends('dashboard.layouts.main')

@section('title')
    Anggota Keluarga ({{ $kartuKeluarga->nama_kepala_keluarga }})
@endsection

@section('tombol_kembali')
    <a href="{{ url('keluarga') }}" class="btn btn-sm btn-primary float-md-end"><i class="fa-solid fa-arrow-left"></i> Data
        Keluarga</a>
@endsection


@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil</li>
            <li class="breadcrumb-item active" aria-current="page">Keluarga</li>
            <li class="breadcrumb-item active" aria-current="page">Anggota Keluarga</li>
        </ol>
    </div>
@endsection

@section('content')
    <section>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div
                        class="card-header bg-transparent d-flex justify-content-between align-items-center border-bottom-0 pt-3 pb-0">
                        <h5 class="card-title mb-0">Data Anggota Keluarga ({{ $kartuKeluarga->nama_kepala_keluarga }})
                        </h5>
                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'bidan')
                            @component('dashboard.components.buttons.add',
                                [
                                    'id' => 'catatan-pertumbuhan-anak',
                                    'class' => '',
                                    'url' => url('anggota-keluarga' . '/' . $kartuKeluarga->id . '/create'),
                                ])
                            @endcomponent
                        @endif
                    </div>
                    <div class="card-body pt-2">
                        <div class="row mb-0">
                            @component('dashboard.components.info.masterData.anggotaKeluarga')
                            @endcomponent
                            <div class="col">
                                <div class="card fieldset border border-secondary mb-4">
                                    <span class="fieldset-tile text-secondary bg-white">Filter Data</span>
                                    <div class="row">
                                        @if (Auth::user()->role != 'penyuluh')
                                            <div class="col-lg">
                                                @component('dashboard.components.formElements.select',
                                                    [
                                                        'label' => 'Status',
                                                        'id' => 'status-filter',
                                                        'name' => 'status',
                                                        'class' => 'filter',
                                                    ])
                                                    @slot('options')
                                                        <option value="Tervalidasi">Tervalidasi</option>
                                                        <option value="Belum Tervalidasi">Belum Divalidasi</option>
                                                        <option value="Ditolak">Ditolak</option>
                                                    @endslot
                                                @endcomponent
                                            </div>
                                        @endif
                                        <div class="col-lg">
                                            @component('dashboard.components.formElements.select',
                                                [
                                                    'label' => 'Desa/Kelurahan Domisili',
                                                    'id' => 'desa-kelurahan-domisili',
                                                    'name' => 'desa-kelurahan-domisili',
                                                    'class' => 'select2 filter',
                                                ])
                                                @slot('options')
                                                    @foreach ($wilayahDomisili as $item)
                                                        <option value="{{ $item->desa_kelurahan_id }}">
                                                            {{ $item->desaKelurahan->nama }}
                                                        </option>
                                                    @endforeach
                                                @endslot
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="card fieldset border border-secondary">
                                    @component('dashboard.components.dataTables.index',
                                        [
                                            'id' => 'table-bidan',
                                            'th' => ['No', 'Dibuat Tanggal', 'Status', 'NIK', 'Nama Lengkap', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Agama', 'Pendidikan', 'Pekerjaan', 'Golongan Darah', 'Status Perkawinan', 'Tanggal Perkawinan', 'Status Dalam Keluarga', 'Kewarganegaraan', 'Nomor Paspor', 'Nomor KITAP', 'Nama Ayah', 'Nama Ibu', 'Alamat Domisili', 'Desa/Kelurahan Domisili', 'Kecamatan Domisili', 'Kabupaten Domisili', 'Provinsi Domisili', 'Bidan', 'Tanggal Divalidasi', 'Aksi'],
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
                    <div class="d-flex w-100 justify-content-between mb-1">
                        <div class="w-100">
                            <h5>Detail Keluarga</h5>
                        </div>

                        <button type="button" class="btn-close float-end" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p class="text-muted mb-0" id="">Dibuat: </p>
                            <p class="text-muted" id="modal-created-at">-</p>
                        </div>

                        <div class="col-6 float-end text-end" id="terakhir-diperbarui">
                            <p class="text-muted mb-0" id="">Terakhir Diperbarui: </p>
                            <p class="text-muted" id="modal-updated-at">-</p>
                        </div>
                    </div>

                    <div class="alert kategori-alert alert-primary rounded-4 mb-0">
                        <div class="d-flex align-items-center">
                            <div class="avatar rounded no-thumbnail kategori-bg bg-primary text-light mx-1"><i
                                    class="fa-solid fa-map-location-dot"></i></div>
                            <div class="d-flex w-100 justify-content-between align-items-center" style="font-size: 0.8em">
                                <div class="" id="">DOMISILI: </div>
                                <div class="float-end text-end" id="modal-domisili"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col mb-2">
                            <div class="card fieldset border border-dark">
                                <span class="fieldset-tile text-dark ml-5 bg-white">Info Kepala Keluarga:</span>
                                <div class="card-body p-0 py-1 px-1">
                                    <ul class="list-unstyled mb-0">
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-person fa-lg"></i> Nama Lengkap</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-nama-lengkap"> -
                                            </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-id-card"></i> NIK</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-nik"> - </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-venus-mars"></i> Jenis Kelamin</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-jenis-kelamin"> -
                                            </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-map-location-dot"></i> Tempat Lahir</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-tempat-lahir"> -
                                            </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="bi bi-calendar2-event-fill"></i> Tanggal Lahir</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-tanggal-lahir"> -
                                            </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-hands-praying"></i> Agama</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-agama"> - </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-graduation-cap"></i> Pendidikan</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-pendidikan"> -
                                            </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-briefcase"></i> Jenis Pekerjaan</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-jenis-pekerjaan">
                                                - </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-droplet"></i> Golongan Darah</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-golongan-darah">
                                                - </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-ring"></i> Status Perkawinan</label>
                                            <span class="badge bg-info float-end text-uppercase"
                                                id="modal-status-perkawinan"> - </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-calendar-day"></i> Tanggal Perkawinan</label>
                                            <span class="badge bg-info float-end text-uppercase"
                                                id="modal-tanggal-perkawinan"> - </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-people-roof"></i> Status Dalam Keluarga</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-status-hubungan">
                                                - </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-flag"></i> Kewarganegaraan</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-kewarganegaraan">
                                                - </span>
                                        </li>
                                        <li class="justify-content-between mb-2" id="li-nomor-paspor">
                                            <label><i class="fa-solid fa-passport"></i> Nomor Paspor</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-nomor-paspor"> -
                                            </span>
                                        </li>
                                        <li class="justify-content-between mb-2" id="li-nomor-kitap">
                                            <label><i class="fa-solid fa-passport"></i> Nomor KITAP</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-nomor-kitap"> -
                                            </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-person fa-lg"></i> Nama Ayah</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-nama-ayah"> -
                                            </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-person-dress fa-lg"></i> Nama Ibu</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-nama-ibu"> -
                                            </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-road"></i> Alamat Domisili</label>
                                            <span class="badge bg-info float-end text-uppercase"
                                                id="modal-alamat-domisili"> - </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-location-dot"></i> Desa/Kelurahan Domisili</label>
                                            <span class="badge bg-info float-end text-uppercase"
                                                id="modal-desa-kelurahan-domisili"> - </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-location-dot"></i> Kecamatan Domisili</label>
                                            <span class="badge bg-info float-end text-uppercase"
                                                id="modal-kecamatan-domisili"> - </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-location-dot"></i> Kabupaten/Kota Domisili</label>
                                            <span class="badge bg-info float-end text-uppercase"
                                                id="modal-kabupaten-kota-domisili"> - </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-location-dot"></i> Provinsi Domisili</label>
                                            <span class="badge bg-info float-end text-uppercase"
                                                id="modal-provinsi-domisili"> - </span>
                                        </li>
                                        <li class="justify-content-between mb-2 d-none" id="col-sk-domisili">
                                            <label><i class="fa-solid fa-file"></i> Surat Keterangan Domisili</label>
                                            <a href="#" id="file-surat-keterangan-domisili" target="_blank"><span
                                                    class="badge bg-success shadow float-end text-uppercase">Lihat</span></a>
                                            <span class="badge bg-info shadow float-end text-uppercase"
                                                id="modal-file-surat-keterangan-domisili">Tidak Ada</span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-phone"></i> Nomor HP</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-nomor-hp"> -
                                            </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-clipboard-question"></i> Status</label>
                                            <span class="badge bg-info float-end text-uppercase"
                                                id="modal-status-konfirmasi"> - </span>
                                        </li>
                                        <li class="justify-content-between mb-2" id="li-modal-tanggal-konfirmasi">
                                            <label><i class="bi bi-calendar2-event-fill"></i> Tanggal Konfirmasi</label>
                                            <span class="badge bg-info float-end text-uppercase"
                                                id="modal-tanggal-konfirmasi"> - </span>
                                        </li>
                                        <li class="justify-content-between mb-2" id="li-modal-oleh-bidan">
                                            <label><i class="fa-solid fa-stethoscope"></i> Oleh Bidan</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-oleh-bidan"> -
                                            </span>
                                        </li>
                                        <li class="justify-content-between">
                                            <label><i class="fa-solid fa-image"></i> Foto Profil</label>
                                            <span class="float-end" id="modal-foto-profil">
                                            </span>
                                        </li>

                                    </ul>
                                </div>
                            </div>
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
                                        'class' => 'bidan_id filter',
                                        'wajib' => '<sup class="text-danger">*</sup>',
                                    ])
                                @endcomponent
                            </div>
                        @endif
                        <div class="col-12 mt-3 d-none" id="col-alasan">
                            <label for="textareaInput" class="form-label">Alasan <sup
                                    class="text-danger">*</sup></label>
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
        $('#m-link-profil').addClass('active');
        $('#menu-profil').addClass('collapse show')
        $('#ms-link-master-data-profil-keluarga').addClass('active')

        var table = $('#table-bidan').removeAttr('width').DataTable({
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
                url: "{{ url('anggota-keluarga' . '/' . $kartuKeluarga->id) }}",
                data: function(d) {
                    d.statusValidasi = $('#status-filter').val();
                    d.desaKelurahanDomisili = $('#desa-kelurahan-domisili').val();
                    d.search = $('input[type="search"]').val();
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
                    data: 'created_at',
                    name: 'created_at',
                },
                {
                    data: 'status',
                    name: 'status',
                },
                {
                    data: 'nik',
                    name: 'nik',
                },
                {
                    data: 'nama_lengkap',
                    name: 'nama_lengkap',
                },
                {
                    data: 'jenis_kelamin',
                    name: 'jenis_kelamin',
                },
                {
                    data: 'tempat_lahir',
                    name: 'tempat_lahir',
                },
                {
                    data: 'tanggal_lahir',
                    name: 'tanggal_lahir',
                },
                {
                    data: 'agama',
                    name: 'agama',
                },
                {
                    data: 'pendidikan',
                    name: 'pendidikan',
                },
                {
                    data: 'pekerjaan',
                    name: 'pekerjaan',
                },
                {
                    data: 'golongan_darah',
                    name: 'golongan_darah',
                },
                {
                    data: 'status_perkawinan',
                    name: 'status_perkawinan',
                },
                {
                    data: 'tanggal_perkawinan',
                    name: 'tanggal_perkawinan',
                },
                {
                    data: 'status_hubungan_dalam_keluarga',
                    name: 'status_hubungan_dalam_keluarga',
                },
                {
                    data: 'kewarganegaraan',
                    name: 'kewarganegaraan',
                },
                {
                    data: 'no_paspor',
                    name: 'no_paspor',
                },
                {
                    data: 'no_kitap',
                    name: 'no_kitap',
                },
                {
                    data: 'nama_ayah',
                    name: 'nama_ayah',
                },
                {
                    data: 'nama_ibu',
                    name: 'nama_ibu',
                },
                {
                    data: 'alamat_domisili',
                    name: 'alamat_domisili',
                },
                {
                    data: 'desa_kelurahan_domisili',
                    name: 'desa_kelurahan_domisili',
                },
                {
                    data: 'kecamatan_domisili',
                    name: 'kecamatan_domisili',
                },
                {
                    data: 'kabupaten_kota_domisili',
                    name: 'kabupaten_kota_domisili',
                },
                {
                    data: 'provinsi_domisili',
                    name: 'provinsi_domisili',
                },
                {
                    data: 'bidan',
                    name: 'bidan',
                },
                {
                    data: 'tanggal_validasi',
                    name: 'tanggal_validasi'
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
                    targets: [3, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15, 16, 17, 18, 19, 20, 22, 23, 24],
                    visible: false,
                },
                {
                    targets: [1, 7],
                    render: function(data) {
                        return moment(data).format('LL');
                    }
                },
                {
                    targets: [1, 2, 7, 13, 14, 15, 16, 17, 25, 26],
                    className: 'text-center',
                },
            ],
        });

        $('.filter').change(function() {
            table.draw();
        })

        $(document).on('click', '#btn-delete', function() {
            let anggotaKeluarga = $(this).data('anggota-keluarga');
            let keluarga = $(this).data('kartu-keluarga');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data bidan yang dipilih akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('anggota-keluarga') }}" + '/' + keluarga + '/' +
                            anggotaKeluarga,
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            if (response.res == 'success') {
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
        });

        $(document).on('click', '#btn-lihat', function() {
            let anggotaKeluarga = $(this).data('anggota-keluarga');
            let keluarga = $(this).data('kartu-keluarga');
            $.ajax({
                type: "GET",
                url: "{{ url('anggota-keluarga') }}" + '/' + keluarga + '/' + anggotaKeluarga,
                success: function(data) {
                    $('#modal-lihat').modal('show');
                    $('#col-sk-domisili').addClass('d-none');
                    $('#modal-file-surat-keterangan-domisili').addClass('d-none')
                    $('#file-surat-keterangan-domisili').addClass('d-none')
                    $('#col-modal-btn-ubah').addClass('d-none');
                    $('#col-modal-btn-konfirmasi').addClass('d-none');
                    $('#li-modal-tanggal-konfirmasi').addClass('d-none');
                    $('#li-modal-oleh-bidan').addClass('d-none');
                    $('#form-konfirmasi').addClass('d-none');
                    $('#col-alasan').addClass('d-none');
                    $('#konfirmasi').val('');
                    $('#nama-bidan').val('');
                    $('#alasan').val('');


                    $('#modal-created-at').html(moment(data.created_at).format('LL'));
                    if (data.updated_at != null) {
                        $('#modal-updated-at').html(moment(data.updated_at).format('LL'));
                    } else {
                        $('#modal-updated-at').html(moment(data.created_at).format('LL'));
                    }
                    $('#modal-domisili').html(data.desa_kelurahan_domisili + ', ' + data
                        .kecamatan_domisili + ', ' + data.kabupaten_kota_domisili + ', ' + data
                        .provinsi_domisili)
                    $('#modal-nama-lengkap').html(data.nama_lengkap);
                    $('#modal-jenis-kelamin').html(data.jenis_kelamin);
                    $('#modal-nik').html(data.nik);
                    $('#modal-tempat-lahir').html(data.tempat_lahir);
                    $('#modal-tanggal-lahir').html(moment(data.tanggal_lahir).format('LL'));
                    $('#modal-agama').html(data.agama_);
                    $('#modal-pendidikan').html(data.pendidikan_);
                    $('#modal-jenis-pekerjaan').html(data.pekerjaan_);
                    $('#modal-golongan-darah').html(data.golongan_darah_);
                    $('#modal-status-perkawinan').html(data.status_perkawinan_);
                    if (data.tanggal_perkawinan != null) {
                        $('#modal-tanggal-perkawinan').html(moment(data.tanggal_perkawinan).format(
                            'LL'));
                    } else {
                        $('#modal-tanggal-perkawinan').html('-');
                    }
                    $('#modal-status-hubungan').html(data.status_hubungan_);
                    $('#modal-kewarganegaraan').html(data.kewarganegaraan);
                    $('#modal-nomor-paspor').html(data.no_paspor);
                    $('#modal-nomor-kitap').html(data.no_kitap);
                    $('#modal-nama-ayah').html(data.nama_ayah);
                    $('#modal-nama-ibu').html(data.nama_ibu);

                    $('#modal-alamat-domisili').html(data.alamat_domisili);
                    $('#modal-desa-kelurahan-domisili').html(data.desa_kelurahan_domisili);
                    $('#modal-kecamatan-domisili').html(data.kecamatan_domisili);
                    $('#modal-kabupaten-kota-domisili').html(data.kabupaten_kota_domisili);
                    $('#modal-provinsi-domisili').html(data.provinsi_domisili);

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

                        $('#modal-btn-konfirmasi').data('anggota-keluarga', anggotaKeluarga);
                        $('#modal-btn-konfirmasi').data('kartu-keluarga', keluarga);

                    } else {
                        $('#li-modal-tanggal-konfirmasi').removeClass('d-none');
                        $('#li-modal-oleh-bidan').removeClass('d-none');
                        if (data.is_valid == 1) {
                            $('#modal-status-konfirmasi').text('Tervalidasi');
                            if (('{{ Auth::user()->profil->nama_lengkap }}' == data.nama_bidan) ||
                                (
                                    '{{ Auth::user()->role }}' == 'admin')) {
                                $('#col-modal-btn-ubah').removeClass('d-none');
                                $('#modal-btn-ubah').attr('href',
                                    '{{ url('anggota-keluarga') }}' +
                                    '/' + keluarga + '/' + anggotaKeluarga + '/edit');
                            } else {
                                $('#col-modal-btn-ubah').addClass('d-none');
                            }
                        } else if (data.is_valid == 2) {
                            $('#modal-status-konfirmasi').text('Ditolak');
                        }
                        $('#modal-tanggal-konfirmasi').text(moment(data.tanggal_validasi).format(
                            'LL'));
                        $('#modal-tanggal-konfirmasi').html(moment(data.tanggal_validasi).format(
                            'LL'));
                        $('#modal-oleh-bidan').text(data.nama_bidan);
                    }


                    if (data.desa_kelurahan_nama != data.desa_kelurahan_domisili) {
                        $('#col-sk-domisili').removeClass('d-none');
                        if (data.surat_keterangan_domisili) {
                            $('#file-surat-keterangan-domisili').removeClass('d-none');
                            $('#file-surat-keterangan-domisili').attr('href',
                                '{{ asset('upload/surat_keterangan_domisili') }}/' + data
                                .surat_keterangan_domisili);
                        } else {
                            $('#modal-file-surat-keterangan-domisili').removeClass('d-none')
                        }
                    }

                    if (data.foto_profil != null) {
                        $('#modal-foto-profil').html(
                            '<div class="image-input shadow avatar xxl rounded-4" style="background-image: url(../upload/foto_profil/keluarga/' +
                            data.foto_profil + ')">')
                    } else {
                        $('#modal-foto-profil').html(
                            '<span class="badge bg-info text-uppercase shadow">Tidak Ada</span>'
                        )
                    }

                    if (data.nomor_hp != null) {
                        $('#modal-nomor-hp').html(data.nomor_hp);
                    } else {
                        $('#modal-nomor-hp').html('Tidak Ada');
                    }
                },
            })
        })

        $(document).on('click', '#modal-btn-konfirmasi', function() {
            let anggotaKeluarga = $(this).data('anggota-keluarga');
            let keluarga = $(this).data('kartu-keluarga');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Konfirmasi data anggota keluarga ini?",
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
                        url: "{{ url('anggota-keluarga/validasi') }}" + '/' + keluarga + '/' +
                            anggotaKeluarga,
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: anggotaKeluarga,
                            bidan_id: '{{ Auth::user()->role }}' == "admin" ? $("#nama-bidan")
                                .val() : '{{ Auth::user()->profil->id }}',
                            konfirmasi: $('#konfirmasi').val(),
                            alasan: $('#alasan').val()
                        },
                        success: function(response) {
                            if ($.isEmptyObject(response.error)) {
                                console.log(response);
                                if (response.res == 'success') {
                                    $('#modal-validasi-ubah').modal('hide');
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
                                // console.log(response.error)
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

        $('.select2').select2()
    </script>
@endpush
