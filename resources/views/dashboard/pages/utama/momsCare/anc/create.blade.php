@extends('dashboard.layouts.main')

@section('title')
    Tambah Antenatal Care
@endsection

@push('style')
@endpush

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Moms Care</li>
            <li class="breadcrumb-item active" aria-current="page">Antenatal Care</li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Antenatal Care</li>
        </ol>
    </div>
@endsection

@section('content')
    <section>
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12">
                <div class="card p-0">
                    {{-- <div class="card-header py-3 bg-transparent border-bottom-0">
                        <h6 class="card-title mb-0">Basic example</h6>
                    </div> --}}
                    <div class="card-body">
                        @component('dashboard.components.forms.utama.anc')
                            @slot('kartuKeluarga', $kartuKeluarga)
                            @slot('form_id', 'form_add_anc')
                            @slot('proses', url('proses-anc'))
                            @slot('action', url('anc'))
                            @slot('method', 'POST')
                            @slot('back_url', url('anc'))
                        @endcomponent

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $('#m-link-moms-care').addClass('active');
        $('#menu-moms-care').addClass('collapse show')
        $('#ms-link-anc').addClass('active')
    </script>
@endpush
