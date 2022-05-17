@extends('dashboard.layouts.main')

@section('title')
    Ubah Pertumbuhan Anak
@endsection

@push('style')
@endpush

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tumbuh Kembang</li>
            <li class="breadcrumb-item active" aria-current="page">Pertumbuhan Anak</li>
            <li class="breadcrumb-item active" aria-current="page">Ubah Pertumbuhan Anak</li>
        </ol>
    </div>
@endsection

@section('content')
    <section>
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12">
                @if (isset($stuntingAnak) && $stuntingAnak->is_valid == 2)
                    <div role="alert" class="alert alert-danger mt-2">
                        <h6>Alasan data anda ditolak:</h6>
                        <p class="mb-0">{{ $stuntingAnak->alasan_ditolak }}</p>
                    </div>
                @endif
                <div class="card p-0">
                    {{-- <div class="card-header py-3 bg-transparent border-bottom-0">
                        <h6 class="card-title mb-0">Basic example</h6>
                    </div> --}}
                    <div class="card-body">
                        @component('dashboard.components.forms.utama.stunting_anak')
                            @slot('kartuKeluarga', $kartuKeluarga)
                            @slot('form_id', 'form_stunting_anak')
                            @slot('proses', url('proses-stunting-anak'))
                            @slot('dataEdit', $stuntingAnak)
                            @slot('action', url('stunting-anak/' . $stuntingAnak->id))
                            @slot('method', 'PUT')
                            @slot('back_url', url('stunting-anak'))
                        @endcomponent

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $('#m-link-deteksi-stunting').addClass('active');
        $('#menu-deteksi-stunting').addClass('collapse show')
        $('#ms-link-stunting-anak').addClass('active')
    </script>
@endpush
