@extends('dashboard.layouts.main')

@section('title')
    Ubah Admin
@endsection

@push('style')

@endpush

@section('breadcrumb')
<div class="col">
    <ol class="breadcrumb bg-transparent mb-0">
        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Profil</li>
        <li class="breadcrumb-item active" aria-current="page">Admin</li>
        <li class="breadcrumb-item active" aria-current="page">Ubah Admin</li>
    </ol>
</div>
@endsection

@section('content')    
    <section>
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12">
                <div class="card p-0">
                    <div class="card-body">
                        @component('dashboard.components.forms.masterData.admin')
                            @slot('form_id', 'form_edit_admin')
                            @slot('users', $users)
                            @slot('admin', $admin)
                            @slot('provinsi', $provinsi)
                            @slot('kabupatenKota', $kabupatenKota)
                            @slot('kecamatan', $kecamatan)
                            @slot('desaKelurahan', $desaKelurahan)
                            @slot('agama', $agama)
                            @slot('action', route('admin.update', $admin->id))
                            @slot('method', 'PUT')
                            @slot('back_url', route('admin.index'))
                        @endcomponent
                        
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
        $('#ms-link-master-data-profil-admin').addClass('active') 
    </script>
@endpush
