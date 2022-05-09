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
                        @if (Auth::user()->role != 'penyuluh')
                            @component('dashboard.components.buttons.add',
                                [
                                    'id' => 'catatan-perkiraan-melahirkan',
                                    'class' => '',
                                    'url' => '/perkiraan-melahirkan/create',
                                ])
                            @endcomponent
                        @endif
                    </div>
                    <div class="card-body pt-2">
                        <div class="row mb-0">
                            @if (Auth::user()->role == 'bidan')
                                @component('dashboard.components.info.bidan.fiturUtama')
                                @endcomponent
                            @endif             
                            @if (Auth::user()->role != 'penyuluh')
                                <div class="col">
                                    <div class="card fieldset border border-secondary mb-4">
                                        <span class="fieldset-tile text-secondary bg-white">Filter Data</span>
                                        <div class="row">
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
                                        </div>
                                    </div>
                                </div>
                            @endif

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
                                                'Nama Ibu',
                                                'Tanggal Haid Terakhir',
                                                'Tanggal
                                                                                                                                                    Perkiraan Lahir',
                                                'Usia Kehamilan',
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
                    <div class="d-flex w-100 justify-content-between mb-1">
                        <div>
                            <h5>Detail Perkiraan Melahirkan</h5>
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
                                <li class="justify-content-between mb-2">
                                    <label><i class="bi bi-calendar2-event-fill"></i> Tanggal diperiksa/validasi</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-diperiksa-divalidasi"> -
                                    </span>
                                </li>
                                <li class="justify-content-between">
                                    <label><i class="fa-solid fa-map-location-dot"></i> Oleh Bidan</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-nama-bidan"> - </span>
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
                        <div class="col-sm-6 col-lg-4">
                            <button class="btn btn-outline-dark text-uppercase w-100" data-bs-dismiss="modal"
                                aria-label="Close"><i class="bi bi-x-circle"></i> Tutup</button>
                        </div>
                        {{-- <div class="col-sm-6 col-lg-8">
                            @component('dashboard.components.buttons.edit', [
    'id' => 'modal-btn-ubah',
])
                            @endcomponent
                        </div> --}}
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
                    $('#modal-tanggal-perkiraan-melahirkan').text("Perkiraan Melahirkan : " +
                        data.tanggal_perkiraan_lahir);
                    $('#modal-tanggal-haid-terakhir').text(data
                        .tanggal_haid_terakhir);
                    $('#modal-diperiksa-divalidasi').text(data.tanggal_validasi);
                    $('#modal-nama-bidan').text(data.bidan);
                    $('#modal-selisih-hari').text(data
                        .selisih_hari);

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
                        url: "{{ url('perkiraan-melahirkan/validasi') }}" + '/' + id,
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
                url: "{{ url('perkiraan-melahirkan') }}",
                data: function(d) {
                    d.statusValidasi = $('#status-validasi').val();
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
                    data: 'status',
                    name: 'status',
                    className: 'text-center',
                },
                {
                    data: 'nama_ibu',
                    name: 'nama_ibu',
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
                    data: 'usia_kehamilan',
                    name: 'usia_kehamilan',
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
