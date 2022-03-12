@extends('dashboard.layouts.main')

@section('title')
    Pertumbuhan Anak
@endsection

@push('style')
    <style>
        @media screen and (max-width:600px) {
            .dataTables_filter {
                margin-top: 10px;
            }   
        }

        .dataTables_filter {
            display: inline !important;
            float: right;
        }
        
        .dataTables_filter.col-sm {
            margin-top: 10px;
        }

        .dt-buttons {
            display: inline !important;
            margin-left: 10px !important
        }
        
        .dataTables_length {
            display: inline !important;        
        }

        .paginate_button {
            font-size: 12px !important;
        }

        .dataTables_paginate {
            margin-top: 10px !important;
        }
    </style>  
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
                    <div class="card-header bg-light-secondary d-flex justify-content-between align-items-center border-bottom-0 pt-3 pb-0">
                        <h5 class="card-title mb-0">Data Pertumbuhan Anak</h5>
                        @component('dashboard.components.buttons.add',[
                            'id' => 'catatan-pertumbuhan-anak',
                            'class' => '',
                            'url' => '#',
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
                                            'Status',
                                            'Tanggal Catatan',
                                            'Nama Anak',
                                            'Jenis Kelamin',
                                            'Tanggal Lahir',
                                            'Usia',
                                            'BB (Kg)',
                                            'ZScore',
                                            'Kategori Gizi',
                                            'Aksi'
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
    <script src="{{asset('assets/dashboard')}}/datatables/dataTables.buttons.min.js"></script>
    <script src="{{asset('assets/dashboard')}}/datatables/jszip.min.js"></script>
    <script src="{{asset('assets/dashboard')}}/datatables/vfs_fonts.js"></script>
    <script src="{{asset('assets/dashboard')}}/datatables/buttons.html5.min.js"></script>
    <script src="{{asset('assets/dashboard')}}/datatables/buttons.print.min.js"></script>
    <script>
        $('#m-link-tumbuh-kembang').addClass('active');
        $('#menu-tumbuh-kembang').addClass('collapse show')
        $('#ms-link-pertumbuhan-anak').addClass('active')    
    
        $(function() {
            $('#table-pertumbuhan-anak').addClass('nowrap').dataTable({
                responsive:true,
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
                                search: 'none' // 'none',    'applied', 'removed'
                            }
                        }
                    }
                ],  
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],         
            })
        })
    </script>
@endpush
