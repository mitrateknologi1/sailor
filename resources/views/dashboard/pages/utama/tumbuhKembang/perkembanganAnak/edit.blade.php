@extends('dashboard.layouts.main')

@section('title')
    Ubah Perkembangan Anak
@endsection

@push('style')
@endpush

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tumbuh Kembang</li>
            <li class="breadcrumb-item active" aria-current="page">Perkembangan Anak</li>
            <li class="breadcrumb-item active" aria-current="page">Ubah Perkembangan Anak</li>
        </ol>
    </div>
@endsection

@section('content')
    <section>
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12">
                @if (isset($anak) && $anak->is_valid == 2)
                    <div role="alert" class="alert alert-danger mt-2">
                        <h6>Alasan data anda ditolak:</h6>
                        <p class="mb-0">{{ $anak->alasan_ditolak }}</p>
                    </div>
                @endif
                <div class="card p-0">
                    <div class="card-body">
                        @component('dashboard.components.forms.utama.perkembangan_anak')
                            @slot('kartuKeluarga', $kartuKeluarga)
                            @slot('anak', $anak)
                            @slot('form_id', 'form_edit_perkembangan_anak')
                            @slot('proses', route('proses-perkembangan-anak'))
                            @slot('action', route('perkembangan-anak.update', $anak->id))
                            @slot('method', 'PUT')
                            @slot('back_url', route('perkembangan-anak.index'))
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
        $('#ms-link-perkembangan-anak').addClass('active')
    </script>
@endpush
