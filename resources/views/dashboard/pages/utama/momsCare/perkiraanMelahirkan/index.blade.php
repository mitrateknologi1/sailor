@extends('dashboard.layouts.main')

@section('title')
    Perkiraan Melahirkan
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
                        <h5 class="card-title mb-0">Data Perkiraan Melahirkan</h5>
                        @component('dashboard.components.buttons.add', [
                            'id' => 'catatan-perkiraan-melahirkan',
                            'class' => '',
                            'url' => '/perkiraan-melahirkan/create',
                            ])
                        @endcomponent
                    </div>
                    <div class="card-body pt-2">
                        <div class="row mb-0">
                            <div class="col">
                                <div class="card fieldset border border-secondary mb-4">
                                    <span class="fieldset-tile text-secondary bg-white">Filter Data</span>
                                    <div class="row">
                                        <div class="col-lg">
                                            @component('dashboard.components.formElements.select', [
                                                'label' => 'Status',
                                                'id' => 'status',
                                                'name' => 'status',
                                                'class' => 'filter',
                                                ])
                                                @slot('options')
                                                    <option value="1">Aktif</option>
                                                    <option value="0">Tidak Aktif</option>
                                                @endslot
                                            @endcomponent
                                        </div>
                                        <div class="col-lg">
                                            @component('dashboard.components.formElements.select', [
                                                'label' => 'Kategori Tinggi',
                                                'id' => 'kategori-gizi',
                                                'name' => 'kategori_gizi',
                                                'class' => 'filter',
                                                ])
                                                @slot('options')
                                                    <option>Mustard</option>
                                                    <option>Ketchup</option>
                                                    <option>Relish</option>
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
                                    @component('dashboard.components.dataTables.index', [
                                        'id' => 'table-data',
                                        'th' => [
                                        'No',
                                        'Nama Ibu',
                                        'Dibuat Tanggal',
                                        'Tanggal Haid Terakhir',
                                        'Tanggal Perkiraan
                                        Lahir',
                                        'Selisih Hari',
                                        'Kategori',
                                        'Status',
                                        'Tanggal Validasi',
                                        'Bidan',
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
                            <h5>Detail Perkiraan Melahirkan</h5>
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
                                <div class="h6 mb-0" id="modal-status" style="margin-left: 5px"> - </div>
                                <div class="float-end" id="modal-tanggal-perkiraan-lahir"><span
                                        class="badge kategori-bg"> -
                                    </span>
                                </div>
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
                            @component('dashboard.components.buttons.edit', [
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
        $('#m-link-moms-care').addClass('active');
        $('#menu-moms-care').addClass('collapse show')
        $('#ms-link-perkiraan-melahirkan').addClass('active')
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
                        url: "{{ url('perkiraan-melahirkan') }}" + '/' + id,
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
                    $('#modal-status').text(data.status);
                    $('#modal-tanggal-haid-terakhir').text(data
                        .tanggal_haid_terakhir);
                    $('#modal-selisih-hari').text(data
                        .selisih_hari);
                    $('#modal-tanggal-perkiraan-lahir').text("Tanggal Lahir : " +
                        data
                        .tanggal_perkiraan_lahir);
                    $('#modal-btn-ubah').attr('href', "{{ url('perkiraan-melahirkan') }}" + '/' +
                        id + '/edit');
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

                    if (data.status == 'Belum Lahir') {
                        $('.kategori-bg').addClass('bg-primary');
                        $('.kategori-alert').addClass('alert-primary');
                        $('#kategori-emot').addClass('fas fa-baby-carriage');
                        $('.simpan').removeClass('d-none');
                    } else {
                        $('.simpan').addClass('d-none');
                        $('.kategori-bg').addClass('bg-success');
                        $('.kategori-alert').addClass('alert-success');
                        $('#kategori-emot').addClass('fas fa-baby-carriage');
                    }

                },
            })
        })
    </script>

    <script>
        var table = $('#table-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('perkiraan-melahirkan') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_ibu',
                    name: 'nama_ibu'
                },
                {
                    data: 'tanggal_dibuat',
                    name: 'tanggal_dibuat',
                    className: 'text-center',
                },
                {
                    data: 'tanggal_haid_terakhir',
                    name: 'tanggal_haid_terakhir',
                    className: 'text-center',
                },
                {
                    data: 'tanggal_perkiraan_lahir',
                    name: 'tanggal_perkiraan_lahir',
                    className: 'text-center',
                },
                {
                    data: 'selisih_hari',
                    name: 'selisih_hari',
                    className: 'text-center',
                },
                {
                    data: 'kategori',
                    name: 'kategori',
                    class: 'text-center'
                },
                {
                    data: 'status',
                    name: 'status',
                    class: 'text-center'
                },
                {
                    data: 'tanggal_validasi',
                    name: 'tanggal_validasi',
                    className: 'text-center',
                },
                {
                    data: 'bidan',
                    name: 'bidan'
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
@endpush
