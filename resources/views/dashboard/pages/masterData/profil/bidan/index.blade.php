@extends('dashboard.layouts.main')

@section('title')
    Bidan
@endsection

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil</li>
            <li class="breadcrumb-item active" aria-current="page">Bidan</li>
        </ol>
    </div>
@endsection

@section('content')
<section>      
    <div class="row mb-4">
        <div class="col">
            <div class="card ">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center border-bottom-0 pt-3 pb-0">
                    <h5 class="card-title mb-0">Data Bidan</h5>
                    @component('dashboard.components.buttons.add',[
                        'id' => 'catatan-pertumbuhan-anak',
                        'class' => '',
                        'url' => '/bidan/create',
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
                                            'label' => 'Kategori Gizi',
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
                                    'id' => 'table-pertumbuhan-anak',
                                    'th' => [
                                        'No',
                                        'NIK',
                                        'Nama Lengkap',
                                        'Jenis Kelamin',
                                        'Tempat Lahir',
                                        'Tanggal Lahir',
                                        'Agama',
                                        '7 Angka Terakhir STR',
                                        'Nomor HP',
                                        'Email',
                                        'Alamat',
                                        'Desa/Kelurahan',
                                        'Kecamatan',
                                        'Kabupaten/Kota',
                                        'Provinsi',
                                        'Didaftar Tanggal',
                                        'Lokasi Tugas',
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
        $('#m-link-profil').addClass('active');
        $('#menu-profil').addClass('collapse show')
        $('#ms-link-master-data-profil-bidan').addClass('active') 
        
        $(function() {
            $('#table-pertumbuhan-anak').addClass('nowrap').dataTable({
                processing: true,
                serverSide: true,
                dom: 'lBfrtip',
                buttons : [
                    {
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
                    url: "{{ route('bidan.index') }}",
                    data: function(d){
                        // d.role = $('#role-filter').val();                    
                        // d.search = $('input[type="search"]').val();
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
                        data: 'nik',
                        name: 'nik',
                        className: 'text-center',
                    },
                    {
                        data: 'nama_lengkap',
                        name: 'nama_lengkap'
                    },
                    {
                        data: 'jenis_kelamin',
                        name: 'jenis_kelamin'
                    },
                    {
                        data: 'tempat_lahir',
                        name: 'tempat_lahir'
                    },
                    {
                        data: 'tanggal_lahir',
                        name: 'tanggal_lahir'
                    },
                    {
                        data: 'agama',
                        name: 'agama',
                        className: 'text-center',
                    },
                    {
                        data: '7_angka_terakhir_str',
                        name: '7_angka_terakhir_str',
                        className: 'text-center',
                    },
                    {
                        data: 'nomor_hp',
                        name: 'nomor_hp',
                        className: 'text-center',
                    },
                    {
                        data: 'email',
                        name: 'email',
                        className: 'text-center',
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'desa_kelurahan',
                        name: 'desa_kelurahan'
                    },
                    {
                        data: 'kecamatan',
                        name: 'kecamatan'
                    },
                    {
                        data: 'kabupaten_kota',
                        name: 'kabupaten_kota'
                    },
                    {
                        data: 'provinsi',
                        name: 'provinsi'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'lokasi_tugas',
                        name: 'lokasi_tugas'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: 'text-center',
                        orderable: true,
                        searchable: true
                    },
                    
                ],  
                columnDefs: [
                    {
                        targets: 1,
                        visible: false,
                    },
                    // {
                    //     targets: 3,
                    //     visible: false,
                    // },
                    {
                        targets: 4,
                        visible: false,
                    },
                    {
                        targets: 5,
                        visible: false,
                        render: function(data) {
                            return moment(data).format('LL');
                        }
                    },
                    {
                        targets: 5,
                        visible: false,
                    },
                    {
                        targets: 6,
                        visible: false,
                    },
                    {
                        targets: 7,
                        visible: false,
                    },
                    {
                        targets: 9,
                        visible: false,
                    },
                    {
                        targets: 10,
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
                        targets: 15,
                        visible: false,
                        render: function(data) {
                            return moment(data).format('LL');
                        }
                    },
                    // {
                    //     targets: 6,
                    //     visible: false,
                    // },
                    // {
                    //     targets: 7,
                    //     render: function(data) {
                    //         return moment(data).format('LL');
                    //     },
                    //     visible: false,

                    // },
                    // {
                    //     targets: 8,
                    //     visible: false,
                    // },
                    // {
                    //     targets: 9,
                    //     visible: false,
                    // },
                    // {
                    //     targets: 13,
                    //     render: function(data) {
                    //         return moment(data).format('LL');
                    //     },
                    //     visible: false,
                    // },
                ],        
            });

        })
    </script>
@endpush
