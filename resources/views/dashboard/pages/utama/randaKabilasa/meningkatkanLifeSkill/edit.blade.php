@extends('dashboard.layouts.main')

@section('title')
    Edit Meningkatkan Life Skill dan Potensi Diri
@endsection

@push('style')
@endpush

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Randa Kabilasa</li>
            <li class="breadcrumb-item active" aria-current="page">Meningkatkan Life Skill dan Potensi Diri</li>
        </ol>
    </div>
@endsection

@section('content')
    <section>
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12">
                @if (isset($randaKabilasa) && $randaKabilasa->is_valid_meningkatkan_life_skill == 2)
                    <div role="alert" class="alert alert-danger mt-2">
                        <h6>Alasan data anda ditolak:</h6>
                        <p class="mb-0">
                            {{ $randaKabilasa->alasan_ditolak_meningkatkan_life_skill }}
                        </p>
                    </div>
                @endif
                <div class="card p-0">
                    {{-- <div class="card-header py-3 bg-transparent border-bottom-0">
                        <h6 class="card-title mb-0">Basic example</h6>
                    </div> --}}
                    <div class="card-body">
                        @component('dashboard.components.forms.utama.meningkatkan_life_skill')
                            @slot('daftarSoal', $daftarSoal)
                            @slot('randaKabilasa', $randaKabilasa)
                            @slot('form_id', 'form_meningkatkan_life_skill')
                            @slot('proses', url('proses-meningkatkan-life-skill' . '/' . $randaKabilasa->id))
                            @slot('action', url('meningkatkan-life-skill/' . $randaKabilasa->id . '/' . $randaKabilasa->id))
                            @slot('method', 'PUT')
                            @slot('back_url', url('randa-kabilasa'))
                        @endcomponent

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $('#m-link-randa-kabilasa').addClass('active');
    </script>
@endpush
