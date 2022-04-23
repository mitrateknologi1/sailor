@extends('dashboard.layouts.main')

@section('title')
    Anggota Keluarga
@endsection

@push('style')
    <style>
        
    </style>
@endpush

@section('breadcrumb')
<div class="col">
    <ol class="breadcrumb bg-transparent mb-0">
        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Anggota Keluarga</li>
    </ol>
</div>
@endsection

@section('content')
<section>
    <div class="row mb-4">
        <div class="col">
            <div class="card">
                <div class="card-header bg-light-secondary d-flex justify-content-between align-items-center border-bottom-0 pt-3 pb-0">
                    <h5 class="card-title mb-2">Data Anggota Keluarga</h5>
                    @component('dashboard.components.buttons.add', [
                        'id' => 'catatan-pertumbuhan-anak',
                        'class' => '',
                        'url' => url('anggota-keluarga' . '/' . Auth::user()->profil->kartu_keluarga_id .'/create'),
                        ])
                    @endcomponent
                </div>
                <div class="card-body py-3">
                    <div class="row g-3">
                        <div class="col-lg-12 mt-0">
                            {{-- <div class="card fieldset border  p-lg-3 pt-4"> --}}
                                <div class="owl-carousel owl-theme owl-loaded owl-drag" id="anggota-keluarga-list">
                                    <div class="owl-stage-outer">
                                        <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1084px;">
                                            @foreach ($keluarga as $item)
                                                {{-- @if ($item->is_valid == 1) --}}
                                                <div class="owl-item active" style="width: 206.8px; margin-right: 10px;">
                                                    <div class="item card ribbon fieldset border border-info">
                                                        @if ($item->status_hubungan_dalam_keluarga == 1)
                                                            <div class="option-10 position-absolute text-light">
                                                                <i class="fa fa-star"></i>
                                                            </div>
                                                        @endif
                                                        <div class="card-body p-0">
                                                            <div class="row justify-content-center">
                                                                <div class="avatar xl rounded-circle no-thumbnail mb-3">
                                                                    <img src="{{ isset($item) && $item->foto_profil != NULL ? asset('upload/foto_profil/keluarga/'.$item->foto_profil) : asset('assets/dashboard/images/avatar.png') }}" alt="Avatar" class="rounded-circle avatar xl shadow img-thumbnail">
                                                                </div>
                                                            </div>
                                                            <small class="text-muted">{{ $item->statusHubunganDalamKeluarga->status_hubungan}} </small>
                                                            <div class="d-flex">
                                                                <p>{{ $item->nama_lengkap }}</p>
                                                                <p style="margin-left: auto; order: 2"><a href=""><i class="fa-solid shadow fa-circle-info"></i></a></p>
                                                            </div>
                                                            <ul class="list-group list-group-custom text-center">
                                                                <li class="list-group-item p-2 py-1 text-muted"><span>{{ ucfirst(strtolower($item->jenis_kelamin)) }}</span></li>
                                                                <li class="list-group-item p-2 py-1 text-muted"><span>{{  Carbon\Carbon::parse($item->tanggal_lahir)->translatedFormat('j F Y') }}</span></li>
                                                                <li class="list-group-item p-2 py-1 text-muted">
                                                                    <span>
                                                                        {{ \Carbon\Carbon::parse($item->tanggal_lahir)->diff(\Carbon\Carbon::now())->format('%y Tahun, %m Bulan'); }}
                                                                    </span>
                                                                </li>
                                                                <li class="list-group-item p-2 py-1 text-muted">
                                                                    <span>
                                                                        {{ ucfirst(strtolower($item->wilayahDomisili->desaKelurahan->nama)) }}
                                                                    </span>
                                                                </li>
                                                                <li class="list-group-item p-2 py-1 text-muted">
                                                                    <span>
                                                                        @if ($item->is_valid == 1)
                                                                            <span class="badge rounded-pill bg-success">Tervalidasi</span>
                                                                        @elseif($item->is_valid == 2)
                                                                            <span class="badge rounded-pill bg-danger">Ditolak</span>
                                                                        @else
                                                                            <span class="badge rounded-pill bg-warning">Belum Divalidasi</span>
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                                {{-- <li class="list-group-item p-2 py-1 text-muted"><span> {{  $item->bidan ? $item->bidan->nama_lengkap :  '-' }}</span></li> --}}
                                                            </ul>
                                                            @if ($item->is_valid == 2)
                                                                <div class="row justify-content-center mt-3">
                                                                    <div class="col-lg-12 text-center">
                                                                        <a href="{{ url('anggota-keluarga/' . $item->kartu_keluarga_id .'/'.$item->id).'/edit' }}">
                                                                            <span class="btn btn-sm btn-outline-info shadow-sm"><i class="fas fa-edit"></i> Perbarui Data</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                    
                                                {{-- @endif --}}
                                            @endforeach
                                            <div class="owl-item active" style="width: 206.8px; margin-right: 10px; height: 328.5px;">
                                                <div class="row align-items-center justify-content-center" style="height: 326px;">
                                                    <div class="col-12">
                                                        <a href="{{ url('anggota-keluarga' . '/' . Auth::user()->profil->kartu_keluarga_id .'/create') }}" class="text-center text-muted">
                                                            <h1><i class="bi bi-plus-circle bi-lg"></i></h1>
                                                            <h6>Tambah Anggota</h6>
                                                        </a>
                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {{-- </div> --}}
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
        $('#m-link-anggota-keluarga').addClass('active');

        $('#anggota-keluarga-list').owlCarousel({
            loop:true,
            margin:10,
            responsiveClass:true,
            responsive:{
                0:{
                    items:1,
                    nav:true
                },
                600:{
                    items:2,
                    nav:false
                },
                1000:{
                    items:4,
                    nav:true,
                    loop:false
                },
                1400:{
                    items:4,
                    nav:true,
                    loop:false
                }
            }
        })

    </script>
@endpush
