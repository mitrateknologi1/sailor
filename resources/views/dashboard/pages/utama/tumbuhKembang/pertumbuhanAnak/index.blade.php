@extends('dashboard.layouts.main')

@section('title')
    Pertumbuhan Anak
@endsection

@push('style')
  

@endpush

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tumbuh Kembang</li>
            <li class="breadcrumb-item active" aria-current="page">Pertumbuhan Anak</li>
        </ol>
    </div>
@endsection

@section('content')
    <section>
        <div class="row mb-4">
            <div class="col">
                <div class="card ">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center border-bottom-0 pt-3 pb-0">
                        <h5 class="card-title mb-0">Data Pertumbuhan Anak</h5>
                        @component('dashboard.components.buttons.add',[
                            'id' => 'catatan-pertumbuhan-anak',
                            'class' => '',
                            'url' => route('pertumbuhan-anak.create'),
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
                                                'id' => 'status-filter',
                                                'name' => 'status',
                                                'class' => 'filter',
                                                ])
                                                @slot('options')
                                                    <option value="1">Tervalidasi</option>
                                                    <option value="0">Belum Divalidasi</option>
                                                @endslot
                                            @endcomponent
                                        </div>
                                        <div class="col-lg">
                                            @component('dashboard.components.formElements.select', [
                                                'label' => 'Kategori Gizi',
                                                'id' => 'kategori-gizi-filter',
                                                'name' => 'kategori_gizi',
                                                'class' => 'filter',
                                                ])
                                                @slot('options')
                                                    <option value="Gizi Buruk">Gizi Buruk</option>
                                                    <option value="Gizi Kurang">Gizi Kurang</option>
                                                    <option value="Gizi Baik">Gizi Baik</option>
                                                    <option value="Gizi Lebih">Gizi Lebih</option>
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
                                                'Dibuat Tanggal',
                                                'Status',
                                                'Nama Anak',
                                                'Nama Ayah',
                                                'Nama Ibu',
                                                'Jenis Kelamin',
                                                'Tanggal Lahir',
                                                'Usia',
                                                'BB (Kg)',
                                                'Kategori Gizi',
                                                'Desa / Kelurahan',
                                                'Bidan',
                                                'Tanggal Divalidasi',
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
                            <h5>Detail Pertumbuhan Anak</h5>
                            <p class="text-muted" id="tanggal-proses"> - </p>
                        </div>
                        <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="alert kategori-alert rounded-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar rounded no-thumbnail kategori-bg text-light"><i id="kategori-emot" class=""></i></div>
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div class="h6 mb-0" id="modal-kategori" style="margin-left: 5px"> - </div>
                                <div class="float-end" id="modal-zscore"><span class="badge kategori-bg"> - </span></div>
                            </div>
                        </div>
                    </div>
                    <div class="card fieldset border border-dark my-4">
                        <span class="fieldset-tile text-dark ml-5 bg-white">Info Anak:</span>
                        <div class="card-body p-0 py-1 px-1">
                            <ul class="list-unstyled mb-0">
                                <li class="justify-content-between mb-2">
                                    <label><i class="fa-solid fa-child"></i> Nama Anak:</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-nama-anak"> - </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fa-solid fa-person fa-lg"></i> Nama Ayah:</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-nama-ayah"> - </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fa-solid fa-person-dress fa-lg"></i> Nama Ibu:</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-nama-ibu"> - </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fa-solid fa-venus-mars"></i> Jenis Kelamin</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-jenis-kelamin"> - </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="bi bi-calendar2-event-fill"></i> Tanggal Lahir</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-tanggal-lahir"> - </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fa-solid fa-cake-candles"></i> Usia</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-usia"> - </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fa-solid fa-weight-scale"></i> Berat Badan</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-berat-badan"> - </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fa-solid fa-map-location-dot"></i> Desa/Kelurahan</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-desa-kelurahan"> - </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="bi bi-calendar2-event-fill"></i> Tanggal diperiksa/validasi</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-diperiksa-divalidasi"> - </span>
                                </li>
                                <li class="justify-content-between">
                                    <label><i class="fa-solid fa-stethoscope"></i> Oleh Bidan</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-nama-bidan"> - </span>
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
        $('#m-link-tumbuh-kembang').addClass('active');
        $('#menu-tumbuh-kembang').addClass('collapse show')
        $('#ms-link-pertumbuhan-anak').addClass('active')

        var table = $('#table-pertumbuhan-anak').DataTable({
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
                url: "{{ route('pertumbuhan-anak.index') }}",
                data: function(d){
                    d.status = $('#status-filter').val();       
                    d.kategori = $('#kategori-gizi-filter').val();             
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
                    className: 'text-center',
                },
                {
                    data: 'status',
                    name: 'status',
                    className: 'text-center',
                },
                {
                    data: 'nama_anak',
                    name: 'nama_anak'
                },
                {
                    data: 'nama_ayah',
                    name: 'nama_ayah'
                },
                {
                    data: 'nama_ibu',
                    name: 'nama_ibu'
                },
                {
                    data: 'jenis_kelamin',
                    name: 'jenis_kelamin'
                },
                {
                    data: 'tanggal_lahir',
                    name: 'tanggal_lahir',
                    className: 'text-center',
                },
                {
                    data: 'usia',
                    name: 'usia',
                    className: 'text-center',
                },
                {
                    data: 'berat_badan',
                    name: 'berat_badan',
                    className: 'text-center',
                },
                {
                    data: 'hasil',
                    name: 'hasil',
                    className: 'text-center',
                },
                {
                    data: 'desa_kelurahan',
                    name: 'desa_kelurahan'
                },
                {
                    data: 'bidan',
                    name: 'bidan'
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
            columnDefs: [
                {
                    targets: [1,7,13],
                    render: function(data) {
                        return moment(data).format('LL');
                    }
                },
                {
                    targets: [4,5,6,7,8,9,13],
                    visible: false,
                },
            ],        
        });
        
        $('#status-filter').change(function () {
            table.draw();     
            console.log($('#status-filter').val())       
        })

        $('#kategori-gizi-filter').change(function () {
            table.draw();     
            console.log($('#kategori-gizi-filter').val())       
        })

        
        function modalLihat(id){
            var pertumbuhan_anak = id;
            $.ajax({
                type: "GET",
                url: "{{url('pertumbuhan-anak')}}" + '/' + pertumbuhan_anak,
                success: function (data) {
                    $('#modal-lihat').modal('show');
                    $('#tanggal-proses').text('Dibuat Tanggal: ' + moment(data.tanggal_proses).format('LL'));
                    $('#modal-nama-anak').text(data.nama_anak);
                    $('#modal-nama-ayah').text(data.nama_ayah);
                    $('#modal-nama-ibu').text(data.nama_ibu);
                    $('#modal-tanggal-lahir').text(moment(data.tanggal_lahir).format('LL'));
                    $('#modal-usia').text(data.usia_tahun);
                    $('#modal-jenis-kelamin').text(data.jenis_kelamin);
                    $('#modal-berat-badan').text(data.berat_badan + ' Kg');
                    $('#modal-kategori').text(data.kategori);
                    $('#modal-zscore').text('ZScore : '+ data.zscore);
                    $('#modal-desa-kelurahan').text(data.desa_kelurahan);
                    $('#modal-diperiksa-divalidasi').text(moment(data.tanggal_validasi).format('LL'));
                    $('#modal-nama-bidan').text(data.bidan);
                    $('#modal-btn-ubah').attr('href', '{{url('pertumbuhan-anak')}}' + '/' + pertumbuhan_anak + '/edit');
                    
                    var kategoriBg = ['bg-danger', 'bg-warning', 'bg-info', 'bg-success', 'bg-primary'];
                    var kategoriAlert = ['alert-danger', 'alert-warning', 'alert-info', 'alert-success', 'alert-primary'];
                    var kategoriEmot = ['fa-solid fa-face-frown', 'fa-solid fa-face-meh', 'fa-solid fa-face-smile', 'fa-solid fa-face-surprise'];
                    $.each(kategoriBg, function(i, v){
                        $('.kategori-bg').removeClass(v);
                    });
                    $.each(kategoriAlert, function(i, v){
                        $('.kategori-alert').removeClass(v);
                    });
                    $.each(kategoriEmot, function(i, v){
                        $('.kategori-emot').removeClass(v);
                    });

                    if(data.kategori == 'Gizi Buruk'){
                        $('.kategori-bg').addClass('bg-danger');
                        $('.kategori-alert').addClass('alert-danger');
                        $('#kategori-emot').addClass('fa-solid fa-face-frown');
                    } else if(data.kategori == 'Gizi Kurang'){
                        $('.kategori-bg').addClass('bg-warning');
                        $('.kategori-alert').addClass('alert-warning');
                        $('#kategori-emot').addClass('fa-solid fa-face-meh');
                    } else if(data.kategori == 'Gizi Baik'){
                        $('.kategori-bg').addClass('bg-success');
                        $('.kategori-alert').addClass('alert-success');
                        $('#kategori-emot').addClass('fa-solid fa-face-smile');
                    } else if(data.kategori == 'Gizi Lebih'){
                        $('.kategori-bg').addClass('bg-primary');
                        $('.kategori-alert').addClass('alert-primary');
                        $('#kategori-emot').addClass('fa-solid fa-face-surprise');
                    }

                    if(('{{Auth::user()->profil->nama_lengkap}}' == data.bidan) || ('{{Auth::user()->role}}' == 'admin')){
                        $('#col-modal-btn-ubah').show();
                    } else {
                        $('#col-modal-btn-ubah').hide();
                    }
             
                },
            })

        }

        function hapus(id) {
            var _token = "{{csrf_token()}}";
            Swal.fire({
                title : 'Apakah anda yakin?',
                text : "Data pertumbuhan anak yang dipilih akan dihapus!",
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
                        url: "{{url('pertumbuhan-anak')}}" + '/' + id,
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
    </script>
@endpush
