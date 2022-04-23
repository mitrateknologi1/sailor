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
                        'url' => route('bidan.create'),
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
                                    'id' => 'table-bidan',
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
                                        'Dibuat Tanggal',
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
<div class="modal fade" id="modal-lihat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body custom_scroll p-lg-4 pb-3">
                <div class="d-flex w-100 justify-content-between mb-1">
                    <div class="w-100">
                        <h5>Detail Bidan</h5>
                    </div>
                    
                    <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="row">
                    <div class="col-6"> 
                        <p class="text-muted mb-0" id="">Dibuat: </p>
                        <p class="text-muted" id="modal-created-at">-</p>
                    </div>
                    <div class="col-6 float-end text-end">
                        <p class="text-muted mb-0" id="">Terakhir Diperbarui: </p>
                        <p class="text-muted" id="modal-updated-at">-</p>
                    </div>
                </div>

                <div class="alert kategori-alert alert-primary rounded-4 mb-0">
                    <div class="d-flex align-items-center">
                        <div class="avatar rounded no-thumbnail kategori-bg bg-primary text-light mx-1"><i class="fa-solid fa-map-location-dot"></i></div>
                        <div class="d-flex w-100 justify-content-between align-items-center" style="font-size: 0.9em">
                            <div class="" style="" id="">Lokasi Tugas:</div>
                            <div class="float-end" id="modal-lokasi-tugas"></div>
                        </div>
                    </div>
                </div>
                <div class="card fieldset border border-dark my-4">
                    <span class="fieldset-tile text-dark ml-5 bg-white">Info Bidan:</span>
                    <div class="card-body p-0 py-1 px-1">
                        <ul class="list-unstyled mb-0">
                            <li class="justify-content-between mb-2">
                                <label><i class="fa-solid fa-person fa-lg"></i> Nama Lengkap</label>
                                <span class="badge bg-info float-end text-uppercase" id="modal-nama-lengkap"> - </span>
                            </li>
                            <li class="justify-content-between mb-2">
                                <label><i class="fa-solid fa-id-card"></i> NIK</label>
                                <span class="badge bg-info float-end text-uppercase" id="modal-nik"> - </span>
                            </li>
                            <li class="justify-content-between mb-2">
                                <label><i class="fa-solid fa-venus-mars"></i> Jenis Kelamin</label>
                                <span class="badge bg-info float-end text-uppercase" id="modal-jenis-kelamin"> - </span>
                            </li>
                            <li class="justify-content-between mb-2">
                                <label><i class="fa-solid fa-map-location-dot"></i> Tempat Lahir</label>
                                <span class="badge bg-info float-end text-uppercase" id="modal-tempat-lahir"> - </span>
                            </li>
                            <li class="justify-content-between mb-2">
                                <label><i class="bi bi-calendar2-event-fill"></i> Tanggal Lahir</label>
                                <span class="badge bg-info float-end text-uppercase" id="modal-tanggal-lahir"> - </span>
                            </li>
                            <li class="justify-content-between mb-2">
                                <label><i class="fa-solid fa-hands-praying"></i> Agama</label>
                                <span class="badge bg-info float-end text-uppercase" id="modal-agama"> - </span>
                            </li>
                            <li class="justify-content-between mb-2">
                                <label><i class="fa-solid fa-id-card"></i> 7 Angka Terakhir STR</label>
                                <span class="badge bg-info float-end text-uppercase" id="modal-str"> - </span>
                            </li>
                            <li class="justify-content-between mb-2">
                                <label><i class="fa-solid fa-phone"></i> Nomor HP</label>
                                <span class="badge bg-info float-end text-uppercase" id="modal-nomor-hp"> - </span>
                            </li>
                            <li class="justify-content-between mb-2">
                                <label><i class="fa-solid fa-at"></i> Email</label>
                                <span class="badge bg-info float-end text-uppercase" id="modal-email"> - </span>
                            </li>
                            <li class="justify-content-between mb-2">
                                <label><i class="fa-solid fa-road"></i> Alamat</label>
                                <span class="badge bg-info float-end text-uppercase" id="modal-alamat"> - </span>
                            </li>
                            <li class="justify-content-between mb-2">
                                <label><i class="fa-solid fa-location-dot"></i> Desa/Kelurahan</label>
                                <span class="badge bg-info float-end text-uppercase" id="modal-desa-kelurahan"> - </span>
                            </li>
                            <li class="justify-content-between mb-2">
                                <label><i class="fa-solid fa-location-dot"></i> Kecamatan</label>
                                <span class="badge bg-info float-end text-uppercase" id="modal-kecamatan"> - </span>
                            </li>
                            <li class="justify-content-between mb-2">
                                <label><i class="fa-solid fa-location-dot"></i> Kabupaten/Kota</label>
                                <span class="badge bg-info float-end text-uppercase" id="modal-kabupaten-kota"> - </span>
                            </li>
                            <li class="justify-content-between mb-2">
                                <label><i class="fa-solid fa-location-dot"></i> Provinsi</label>
                                <span class="badge bg-info float-end text-uppercase" id="modal-provinsi"> - </span>
                            </li>
                            <li class="justify-content-between">
                                <label><i class="fa-solid fa-image"></i> Foto Profil</label>
                                <span class="float-end" id="modal-foto-profil">

                                </span>
                                
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col">
                        <button class="btn btn-outline-dark text-uppercase w-100" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-circle"></i>  Tutup</button>
                    </div>
                    <div class="col-sm-6 col-lg-8" id="col-modal-btn-ubah">
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
        $('#m-link-profil').addClass('active');
        $('#menu-profil').addClass('collapse show')
        $('#ms-link-master-data-profil-bidan').addClass('active') 
        
        var table = $('#table-bidan').removeAttr('width').DataTable({
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
                    data: 'tujuh_angka_terakhir_str',
                    name: 'tujuh_angka_terakhir_str',
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
                    targets: [3,4,5,6,7,9,10,11,12,13,14,15],
                    visible: false,
                },
                {
                    targets: [5,15],
                    visible: false,
                    render: function(data) {
                        return moment(data).format('LL');
                    }
                },
                {
                    targets: 16,
                    className: 'text-center',
                    render: function (data, type, full, meta) {
                        return "<div style='white-space: normal;width: 180px;'>" + data + "</div>";
                    }
                },
            ],        
        });

        function hapus(id) {
            var _token = "{{csrf_token()}}";
            Swal.fire({
                title : 'Apakah anda yakin?',
                text : "Data bidan yang dipilih akan dihapus!",
                icon : 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{url('bidan')}}" + '/' + id,
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
        }

        function modalLihat(id){
            $('#modal-lihat').modal('show');

            var bidan = id;
            $.ajax({
                type: "GET",
                url: "{{url('bidan')}}" + '/' + bidan,
                success: function (data) {
                    $('#modal-lihat').modal('show');
                    $('#modal-created-at').html(moment(data.created_at).format('LL'));
                    if(data.updated_at != null){
                        $('#modal-updated-at').html(moment(data.updated_at).format('LL'));
                    } else{
                        $('#modal-updated-at').html(moment(data.created_at).format('LL'));
                    }
                    if(data.lokasiTugas != ""){
                        $('#modal-lokasi-tugas').html(data.lokasiTugas);
                    } else{
                        $('#modal-lokasi-tugas').html('<span class="badge rounded-pill bg-danger">Belum Ada Lokasi Tugas</span>');
                    }
                    $('#modal-nama-bidan').html(data.nama_lengkap);
                    $('#modal-nik').html(data.nik);
                    $('#modal-jenis-kelamin').html(data.jenis_kelamin);
                    $('#modal-tempat-lahir').html(data.tempat_lahir);
                    $('#modal-tanggal-lahir').html(moment(data.tanggal_lahir).format('LL'));
                    $('#modal-agama').html(data.agama_);
                    $('#modal-str').html(data.tujuh_angka_terakhir_str);
                    $('#modal-nomor-hp').html(data.nomor_hp);
                    $('#modal-email').html(data.email);
                    $('#modal-alamat').html(data.alamat);
                    $('#modal-desa-kelurahan').html(data.desa_kelurahan_nama);
                    $('#modal-kecamatan').html(data.kecamatan_nama);
                    $('#modal-kabupaten-kota').html(data.kabupaten_kota_nama);
                    $('#modal-provinsi').html(data.provinsi_nama);
                    if(data.foto_profil != null){
                        $('#modal-foto-profil').html('<div class="image-input avatar xxl rounded-4" style="background-image: url(upload/foto_profil/bidan/'+data.foto_profil+')">')
                    } else{
                        $('#modal-foto-profil').html('<span class="badge bg-info text-uppercase">-</span>')
                    }
                    $('#modal-btn-ubah').attr('href', '{{url('bidan')}}' + '/' + bidan + '/edit');
                },
            })

        }
    </script>
@endpush
