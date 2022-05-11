@extends('dashboard.layouts.main')

@section('title')
    Randa Kabilasa
@endsection

@push('style')
    <style>

    </style>
@endpush

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Deteksi Stunting</li>
            <li class="breadcrumb-item active" aria-current="page">Stunting Anak</li>
        </ol>
    </div>
@endsection

@section('content')
    <section>
        <div class="row mb-4">
            <div class="col">
                <div class="card ">
                    <div
                        class="card-header bg-light-secondary d-flex justify-content-between align-items-center border-bottom-0 pt-3 pb-0">
                        <h5 class="card-title mb-0">Data Randa Kabilasa</h5>
                        @component('dashboard.components.buttons.add',
                            [
                                'id' => 'catatan-mencegah-malnutrisi',
                                'class' => '',
                                'url' => '/mencegah-malnutrisi/create',
                            ])
                        @endcomponent
                    </div>
                    <div class="card-body pt-2">
                        <div class="row mb-0">
                            @if (Auth::user()->role == 'bidan')
                                @component('dashboard.components.info.bidan.fiturUtama')
                                @endcomponent
                            @endif
                            <div class="col">
                                <div class="card fieldset border border-secondary mb-4">
                                    <span class="fieldset-tile text-secondary bg-white">Filter Data</span>
                                    <div class="row">
                                        @if (Auth::user()->role != 'penyuluh')
                                            <div class="col-lg-4 mt-2">
                                                @component('dashboard.components.formElements.select',
                                                    [
                                                        'label' => 'Status Validasi Asesmen Mencegah Malnutrisi',
                                                        'id' => 'status_mencegah_malnutrisi',
                                                        'name' => 'status_mencegah_malnutrisi',
                                                        'class' => 'filter',
                                                    ])
                                                    @slot('options')
                                                        <option value="Tervalidasi">Tervalidasi</option>
                                                        <option value="Belum Tervalidasi">Belum Divalidasi</option>
                                                    @endslot
                                                @endcomponent
                                            </div>
                                            <div class="col-lg-4 mt-2">
                                                @component('dashboard.components.formElements.select',
                                                    [
                                                        'label' => 'Status Validasi Asesmen Mencegah Pernikahan Dini',
                                                        'id' => 'status_mencegah_pernikahan_dini',
                                                        'name' => 'status_mencegah_pernikahan_dini',
                                                        'class' => 'filter',
                                                    ])
                                                    @slot('options')
                                                        <option value="Tervalidasi">Tervalidasi</option>
                                                        <option value="Belum Tervalidasi">Belum Divalidasi</option>
                                                    @endslot
                                                @endcomponent
                                            </div>
                                            <div class="col-lg-4 mt-2">
                                                @component('dashboard.components.formElements.select',
                                                    [
                                                        'label' => 'Status Validasi Asesmen Meningkatkan Life Skill',
                                                        'id' => 'status_meningkatkan_life_skill',
                                                        'name' => 'status_meningkatkan_life_skill',
                                                        'class' => 'filter',
                                                    ])
                                                    @slot('options')
                                                        <option value="Tervalidasi">Tervalidasi</option>
                                                        <option value="Belum Tervalidasi">Belum Divalidasi</option>
                                                    @endslot
                                                @endcomponent
                                            </div>
                                        @endif

                                        <div class="col-lg-4 mt-2">
                                            @component('dashboard.components.formElements.select',
                                                [
                                                    'label' => 'Status Asesmen',
                                                    'id' => 'status_asesmen',
                                                    'name' => 'status_asesmen',
                                                    'class' => 'filter',
                                                ])
                                                @slot('options')
                                                    <option value="belum asesmen pernikahan dini">Belum Asesmen Mencegah Pernikahan
                                                        Dini</option>
                                                    <option value="belum asesmen meningkatkan life skill">Belum Asesmen Meningkatkan
                                                        Life Skill</option>
                                                    <option value="belum asesmen pernikahan dini dan meningkatkan life skill">Belum
                                                        Asesmen Mencegah Pernikahan Dini dan Meningkatkan Life Skill
                                                    </option>
                                                    <option value="sudah asesmen">Sudah Melakukan Seluruh Asesmen</option>
                                                @endslot
                                            @endcomponent
                                        </div>
                                        <div class="col-lg-4 mt-2">
                                            @component('dashboard.components.formElements.select',
                                                [
                                                    'label' => 'Kategori HB',
                                                    'id' => 'kategori_hb',
                                                    'name' => 'kategori_hb',
                                                    'class' => 'filter',
                                                ])
                                                @slot('options')
                                                    <option value="Normal">Normal</option>
                                                    <option value="Terindikasi Anemia">Terindikasi Anemia</option>
                                                    <option value="Anemia">Anemia</option>
                                                @endslot
                                            @endcomponent
                                        </div>
                                        <div class="col-lg-4 mt-2">
                                            @component('dashboard.components.formElements.select',
                                                [
                                                    'label' => 'Kategori Lingkar Lengan Atas',
                                                    'id' => 'kategori_lingkar_lengan_atas',
                                                    'name' => 'kategori_lingkar_lengan_atas',
                                                    'class' => 'filter',
                                                ])
                                                @slot('options')
                                                    <option value="Kurang Gizi">Kurang Gizi</option>
                                                    <option value="Normal">Normal</option>
                                                @endslot
                                            @endcomponent
                                        </div>
                                        <div class="col-lg-4 mt-2">
                                            @component('dashboard.components.formElements.select',
                                                [
                                                    'label' => 'Kategori Indeks Masa Tubuh',
                                                    'id' => 'kategori_indeks_masa_tubuh',
                                                    'name' => 'kategori_indeks_masa_tubuh',
                                                    'class' => 'filter',
                                                ])
                                                @slot('options')
                                                    <option value="Sangat Kurus">Sangat Kurus</option>
                                                    <option value="Kurus">Kurus</option>
                                                    <option value="Normal">Normal</option>
                                                    <option value="Gemuk">Gemuk</option>
                                                    <option value="Sangat Gemuk">Sangat Gemuk</option>
                                                @endslot
                                            @endcomponent
                                        </div>
                                        <div class="col-lg-4 mt-2">
                                            @component('dashboard.components.formElements.select',
                                                [
                                                    'label' => 'Asesmen Mencegah Malnutrisi',
                                                    'id' => 'asesmen_mencegah_malnutrisi',
                                                    'name' => 'asesmen_mencegah_malnutrisi',
                                                    'class' => 'filter',
                                                ])
                                                @slot('options')
                                                    <option value="Berpartisipasi Mencegah Stunting">Berpartisipasi
                                                        Mencegah Stunting</option>
                                                    <option value="Tidak Berpartisipasi Mencegah Stunting">Tidak Berpartisipasi
                                                        Mencegah Stunting</option>
                                                @endslot
                                            @endcomponent
                                        </div>
                                        <div class="col-lg-4 mt-2">
                                            @component('dashboard.components.formElements.select',
                                                [
                                                    'label' => 'Asesmen Meningkatkan Life Skill',
                                                    'id' => 'asesmen_meningkatkan_life_skill',
                                                    'name' => 'asesmen_meningkatkan_life_skill',
                                                    'class' => 'filter',
                                                ])
                                                @slot('options')
                                                    <option value="Berpartisipasi Mencegah Stunting">Berpartisipasi
                                                        Mencegah Stunting</option>
                                                    <option value="Tidak Berpartisipasi Mencegah Stunting">Tidak Berpartisipasi
                                                        Mencegah Stunting</option>
                                                @endslot
                                            @endcomponent
                                        </div>
                                        <div class="col-lg-4 mt-2">
                                            @component('dashboard.components.formElements.select',
                                                [
                                                    'label' => 'Asesmen Mencegah Pernikahan Dini',
                                                    'id' => 'asesmen_mencegah_pernikahan_dini',
                                                    'name' => 'asesmen_mencegah_pernikahan_dini',
                                                    'class' => 'filter',
                                                ])
                                                @slot('options')
                                                    <option value="Berpartisipasi Mencegah Stunting">Berpartisipasi
                                                        Mencegah Stunting</option>
                                                    <option value="Tidak Berpartisipasi Mencegah Stunting">Tidak Berpartisipasi
                                                        Mencegah Stunting</option>
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
                                            'id' => 'table-data',
                                            'th' => [
                                                'No',
                                                'Tanggal Dibuat',
                                                'Status Validasi Asesmen Mencegah Malnutrisi',
                                                'Status Validasi Asesmen Mencegah Pernikahan Dini',
                                                'Status Validasi Asesmen Meningkatkan Life Skill',
                                                'Status Asesmen',
                                                'Nama Remaja',
                                                'Kategori HB',
                                                'Kategori Lingkar Lengan Atas',
                                                'Kategori Indeks Masa Tubuh',
                                                'Asesmen Mencegah Malnutrisi',
                                                'Asesmen Meningkatkan Life Skill',
                                                'Asesmen Mencegah Pernikahan Dini',
                                                'Desa /
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        Kelurahan',
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
                    <div class="d-flex w-100 justify-content-between mb-1">
                        <div>
                            <h5>Detail Randa Kabilasa</h5>
                            <p class="text-muted" id="tanggal-proses"> - </p>
                        </div>
                        <button type="button" class="btn-close float-end" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="alert kategori-alert alert-primary rounded-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar rounded no-thumbnail kategori-bg bg-primary text-light"><i
                                    class="fas fa-baby-carriage"></i></div>
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div class="h6 mb-0" id="modal-tanggal-perkiraan-melahirkan"
                                    style="margin-left: 5px"> - </div>
                            </div>
                        </div>
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
                                    <label><i class="bi bi-calendar2-event-fill"></i> Tanggal Lahir</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-tanggal-lahir"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="bi bi-calendar2-event-fill"></i> Tanggal Haid Terakhir</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-tanggal-haid-terakhir">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="bi bi-calendar2-event-fill"></i> Selisih Hari Lahir</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-selisih-hari"> -
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-sm-6 col-lg-4">
                            <button class="btn btn-outline-dark text-uppercase w-100" data-bs-dismiss="modal"
                                aria-label="Close"><i class="bi bi-x-circle"></i> Tutup</button>
                        </div>
                        <div class="col-sm-6 col-lg-8">
                            @component('dashboard.components.buttons.edit',
                                [
                                    'id' => 'modal-btn-ubah',
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
        $('#m-link-randa-kabilasa').addClass('active');
    </script>

    @if (Session::has('error'))
        <script>
            Swal.fire(
                'Terjadi Kesalahan!',
                'Daftar Soal Mencegah Malnutrisi Tidak Ada, Anda Tidak Bisa Melakukan Asesmen Randa Kabilasa, Silahkan Hubungi Admin Untuk Menambahkan Soal',
                'error'
            )
        </script>
    @endif

    @if (Session::has('error_life_skill'))
        <script>
            Swal.fire(
                'Terjadi Kesalahan!',
                'Daftar Soal Asesmen Meningkatkan Life Skill Tidak Ada, Anda Tidak Bisa Melakukan Asesmen Meningkatkan Life Skill, Silahkan Hubungi Admin Untuk Menambahkan Soal',
                'error'
            )
        </script>
    @endif

    <script>
        $(document).on('click', '#btn-delete', function() {
            let linkDelete = $(this).val();

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
                        url: linkDelete,
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
                url: "{{ url('perkiraan-melahirkan') }}" + '/' + id,
                success: function(data) {
                    $('#modal-lihat').modal('show');
                    $('#tanggal-proses').text('Tanggal : ' + moment().format('LL'))
                    $('#modal-nama-ibu').text(data.nama_ibu);
                    $('#modal-tanggal-lahir').text(moment(data.tanggal_lahir)
                        .format('LL'));
                    $('#modal-usia').text(data.usia_tahun);
                    $('#modal-tanggal-perkiraan-melahirkan').text("Randa Kabilasa : " +
                        data.tanggal_perkiraan_lahir);
                    $('#modal-tanggal-haid-terakhir').text(data
                        .tanggal_haid_terakhir);
                    $('#modal-selisih-hari').text(data
                        .selisih_hari);
                    if (("{{ Auth::user()->profil->id }}" == data.bidan_id) || (
                            "{{ Auth::user()->role }}" ==
                            "admin")) {
                        $('#modal-btn-ubah').attr('href', "{{ url('perkiraan-melahirkan') }}" + '/' +
                            id + '/edit');
                        $('#modal-btn-ubah').show();
                    } else {
                        $('#modal-btn-ubah').hide();
                    }
                },
            })
        })
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
                url: "{{ url('randa-kabilasa') }}",
                data: function(d) {
                    d.status_mencegah_malnutrisi = $('#status_mencegah_malnutrisi').val();
                    d.status_mencegah_pernikahan_dini = $('#status_mencegah_pernikahan_dini').val();
                    d.status_meningkatkan_life_skill = $('#status_meningkatkan_life_skill').val();
                    d.status_asesmen = $('#status_asesmen').val();
                    d.kategori_hb = $('#kategori_hb').val();
                    d.kategori_lingkar_lengan_atas = $('#kategori_lingkar_lengan_atas').val();
                    d.kategori_indeks_masa_tubuh = $('#kategori_indeks_masa_tubuh').val();
                    d.asesmen_mencegah_malnutrisi = $('#asesmen_mencegah_malnutrisi').val();
                    d.asesmen_meningkatkan_life_skill = $('#asesmen_meningkatkan_life_skill').val();
                    d.asesmen_mencegah_pernikahan_dini = $('#asesmen_mencegah_pernikahan_dini').val();
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
                    data: 'tanggal_dibuat',
                    name: 'tanggal_dibuat',
                    className: 'text-center',
                },
                {
                    data: 'status_mencegah_malnutrisi',
                    name: 'status_mencegah_malnutrisi',
                    className: 'text-center',
                },
                {
                    data: 'status_mencegah_pernikahan_dini',
                    name: 'status_mencegah_pernikahan_dini',
                    className: 'text-center',
                },
                {
                    data: 'status_meningkatkan_life_skill',
                    name: 'status_meningkatkan_life_skill',
                    className: 'text-center',
                },
                {
                    data: 'status_asesmen',
                    name: 'status_asesmen',
                    className: 'text-center',
                },
                {
                    data: 'nama_remaja',
                    name: 'nama_remaja',
                    className: 'text-center',
                },
                {
                    data: 'kategori_hb',
                    name: 'kategori_hb',
                    className: 'text-center',
                },
                {
                    data: 'kategori_lingkar_lengan_atas',
                    name: 'kategori_lingkar_lengan_atas',
                    className: 'text-center',
                },
                {
                    data: 'kategori_indeks_masa_tubuh',
                    name: 'kategori_indeks_masa_tubuh',
                    className: 'text-center',
                },
                {
                    data: 'kategori_mencegah_malnutrisi',
                    name: 'kategori_mencegah_malnutrisi',
                    className: 'text-center',
                },
                {
                    data: 'kategori_meningkatkan_life_skill',
                    name: 'kategori_meningkatkan_life_skill',
                    className: 'text-center',
                },
                {
                    data: 'kategori_mencegah_pernikahan_dini',
                    name: 'kategori_mencegah_pernikahan_dini',
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
            columnDefs: [],
        });
    </script>

    <script>
        $('.filter').change(function() {
            table.draw();
        })
    </script>
@endpush
