@extends('dashboard.layouts.main')

@section('title')
    Tambah Penyuluh
@endsection

@push('style')
@endpush

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil</li>
            <li class="breadcrumb-item active" aria-current="page">Penyuluh</li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Penyuluh</li>
        </ol>
    </div>
@endsection

@section('content')
    <section>
        <div class="row justify-content-center mb-4">
            <div class="col-lg-12 col-md-12">
                <div class="card p-0">
                    <div class="card-body">
                        @component('dashboard.components.forms.masterData.penyuluh')
                            @slot('form_id', 'form_add_penyuluh')
                            @slot('users', $users)
                            @slot('provinsi', $provinsi)
                            @slot('agama', $agama)
                            @slot('action', route('penyuluh.store'))
                            @slot('method', 'POST')
                            @slot('back_url', route('penyuluh.index'))
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
        $('#ms-link-master-data-profil-penyuluh').addClass('active')

        $('#nomor-hp').attr('disabled', true);
    </script>
@endpush
