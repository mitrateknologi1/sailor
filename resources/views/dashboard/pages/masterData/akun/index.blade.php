@extends('dashboard.layouts.main')

@section('title')
    Akun
@endsection

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Akun</li>
        </ol>
    </div>
@endsection

@section('content')
    <section>
        <div class="row mb-4">
            <div class="col">
                <div class="card ">
                    <div
                        class="card-header bg-transparent d-flex justify-content-between align-items-center border-bottom-0 pt-3 pb-0">
                        <h5 class="card-title mb-0">Data Akun</h5>
                        @if (Auth::user()->role == 'admin')
                            @component('dashboard.components.buttons.add',
                                [
                                    'id' => 'catatan-pertumbuhan-anak',
                                    'class' => '',
                                    'url' => route('user.create'),
                                ])
                            @endcomponent
                        @endif
                    </div>
                    <div class="card-body pt-2">
                        <div class="row mb-0">
                            @component('dashboard.components.info.masterData.akun')
                            @endcomponent
                            <div class="col">
                                <div class="card fieldset border border-secondary mb-4">
                                    <span class="fieldset-tile text-secondary bg-white">Filter Data</span>
                                    <div class="row">
                                        <div class="col-lg">
                                            @component('dashboard.components.formElements.select',
                                                [
                                                    'label' => 'Status',
                                                    'id' => 'status',
                                                    'name' => 'status',
                                                    'class' => 'filter',
                                                ])
                                                @slot('options')
                                                    <option value="aktif">Aktif</option>
                                                    <option value="tidak_aktif">Tidak Aktif</option>
                                                @endslot
                                            @endcomponent
                                        </div>
                                        <div class="col-lg">
                                            @component('dashboard.components.formElements.select',
                                                [
                                                    'label' => 'Role',
                                                    'id' => 'role',
                                                    'name' => 'role',
                                                    'class' => 'filter',
                                                ])
                                                @slot('options')
                                                    @if (Auth::user()->role == 'admin')
                                                        <option value="admin">Admin</option>
                                                        <option value="bidan">Bidan</option>
                                                        <option value="penyuluh">Penyuluh</option>
                                                    @endif
                                                    @if (in_array(Auth::user()->role, ['admin', 'bidan']))
                                                        <option value="kepala_keluarga">Kepala Keluarga</option>
                                                        <option value="remaja">Remaja</option>
                                                    @endif
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
                                            'id' => 'table-akun',
                                            'th' => ['No', 'Nama Profil', 'Nomor HP', 'Role', 'Status', 'Dibuat Tanggal', 'Aksi'],
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
        $('#m-link-akun').addClass('active');

        var table = $('#table-akun').removeAttr('width').DataTable({
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
                url: "{{ route('user.index') }}",
                data: function(d) {
                    d.status = $('#status').val();
                    d.role = $('#role').val();
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
                    data: 'nama_lengkap',
                    name: 'nama_lengkap',
                },
                {
                    data: 'nomor_hp',
                    name: 'nomor_hp',
                },
                {
                    data: 'role',
                    name: 'role'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                // {
                //     data: 'bidan',
                //     name: 'bidan',
                //     visible: '{{ Auth::user()->role == 'bidan' ? true : false }}'
                // },
                {
                    data: 'action',
                    name: 'action',
                    className: 'text-center',
                    orderable: true,
                    searchable: true
                },

            ],
            columnDefs: [{
                    targets: [2, 3, 4, 6],
                    className: 'text-center'
                },
                {
                    targets: 5,
                    visible: false,
                    className: 'text-center',
                    render: function(data) {
                        return moment(data).format('LL');
                    }
                },
            ],

        });

        $('.filter').change(function() {
            table.draw();
        })

        $(document).on('click', '#btn-delete', function() {
            let id = $(this).val();
            var _token = "{{ csrf_token() }}";
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data akun yang dipilih akan dihapus dan jika ditemukan data profil yang berkaitan maka data profil tersebut juga akan ikut dihapus",
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
                        url: "{{ url('user') }}" + '/' + id,
                        data: {
                            _token: _token
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
        })
    </script>
@endpush
