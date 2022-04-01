@extends('dashboard.layouts.main')

@section('title')
    Tambah Bidan
@endsection

@push('style')
@endpush

@section('breadcrumb')
<div class="col">
    <ol class="breadcrumb bg-transparent mb-0">
        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Profil</li>
        <li class="breadcrumb-item active" aria-current="page">Bidan</li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Bidan</li>
    </ol>
</div>
@endsection

@section('content')    
    <section>
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12">
                <div class="card p-0">
                    <div class="card-body">
                        @component('dashboard.components.forms.masterData.bidan')
                            {{-- @slot('kartuKeluarga', $kartuKeluarga)
                            @slot('bidan', $bidan) --}}
                            @slot('form_id', 'form_add_pertumbuhan_anak')
                            @slot('proses', route('proses-pertumbuhan-anak'))'))                                
                            @slot('action', route('pertumbuhan-anak.store'))
                            @slot('method', 'POST')
                            @slot('back_url', route('pertumbuhan-anak.index'))
                        @endcomponent
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $('#m-link-tumbuh-kembang').addClass('active');
        $('#menu-tumbuh-kembang').addClass('collapse show')
        $('#ms-link-pertumbuhan-anak').addClass('active') 
        
        
    </script>
@endpush
