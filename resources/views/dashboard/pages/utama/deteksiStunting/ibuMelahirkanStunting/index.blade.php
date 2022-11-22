@extends('dashboard.layouts.main')

@section('title')
    Deteksi Ibu Melahirkan Stunting
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
            <li class="breadcrumb-item active" aria-current="page">Deteksi Ibu Melahirkan Stunting</li>
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
                        <h5 class="card-title mb-0">Data Ibu Melahirkan Stunting</h5>
                        @if (Auth::user()->role != 'penyuluh')
                            @component('dashboard.components.buttons.add',
                                [
                                    'url' => url('deteksi-ibu-melahirkan-stunting/create'),
                                ])
                            @endcomponent
                        @endif
                    </div>
                    <div class="card-body pt-2">
                        <div class="row mb-0">
                            @component('dashboard.components.info.fiturUtama')
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
                                        @endif
                                        <div class="col-lg">
                                            @component('dashboard.components.formElements.select',
                                                [
                                                    'label' => 'Kategori',
                                                    'id' => 'kategori',
                                                    'name' => 'kategori',
                                                    'class' => 'filter',
                                                ])
                                                @slot('options')
                                                    <option value="beresiko">Beresiko Melahirkan Stunting</option>
                                                    <option value="tidak_beresiko">Tidak Beresiko Melahirkan Stunting</option>
                                                @endslot
                                            @endcomponent
                                        </div>
                                    </div>
                                    @component('dashboard.components.filter.wilayah',
                                        [
                                            'fitur' => 'ibuMelahirkanStunting',
                                        ])
                                    @endcomponent
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
                                                'Status',
                                                'Nomor Kartu Keluarga',
                                                'Nama Ibu',
                                                'Kategori',
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
@endsection

@push('script')
    <script>
        $('#m-link-deteksi-stunting').addClass('active');
        $('#menu-deteksi-stunting').addClass('collapse show')
        $('#ms-link-ibu-melahirkan-stunting').addClass('active')
    </script>

    @if (Session::has('error'))
        <script>
            console.log('ada');
            Swal.fire(
                'Terjadi Kesalahan!',
                'Daftar Soal Deteksi Ibu Melahirkan Stunting Tidak Ada, Anda Tidak Bisa Menambahkan/Mengubah Deteksi Ibu Melahirkan Stunting, Silahkan Hubungi Admin Untuk Menambahkan Soal',
                'error'
            )
        </script>
    @endif

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
                        url: "{{ url('deteksi-ibu-melahirkan-stunting') }}" + '/' + id,
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
                    },
                    customizeData: function(data) {
                        for (var i = 0; i < data.body.length; i++) {
                            for (var j = 0; j < data.body[i].length; j++) {
                                data.body[i][j] = '\u200C' + data.body[i][j];
                            }
                        }
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
                url: "{{ url('deteksi-ibu-melahirkan-stunting') }}",
                data: function(d) {
                    d.statusValidasi = $('#status-validasi').val();
                    d.kategori = $('#kategori').val();
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
                    data: 'nomor_kk',
                    name: 'nomor_kk',
                    className: 'text-center',
                },
                {
                    data: 'nama_ibu',
                    name: 'nama_ibu',
                    className: 'text-center',
                },
                {
                    data: 'kategori',
                    name: 'kategori',
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
        });
    </script>

    <script>
        $('.filter').change(function() {
            table.draw();
        })
    </script>
@endpush
