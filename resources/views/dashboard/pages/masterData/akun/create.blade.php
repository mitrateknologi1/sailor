@extends('dashboard.layouts.main')

@section('title')
    Tambah Akun
@endsection

@push('style')

@endpush

@section('breadcrumb')
<div class="col">
    <ol class="breadcrumb bg-transparent mb-0">
        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Akun</li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Akun</li>
    </ol>
</div>
@endsection

@section('content')    
    <section>
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12">
                <div class="card p-0">
                    <div class="card-body">
                        @component('dashboard.components.forms.masterData.akun')
                            @slot('form_id', 'form_add_user')
                            @slot('action', route('user.store'))
                            @slot('method', 'POST')
                            @slot('back_url', route('user.index'))
                        @endcomponent
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $('#m-link-akun').addClass('active');
    </script>
@endpush
