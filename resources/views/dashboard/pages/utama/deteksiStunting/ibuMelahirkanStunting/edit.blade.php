@extends('dashboard.layouts.main')

@section('title')
    Edit Deteksi Ibu Melahirkan Stunting
@endsection

@push('style')
@endpush

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Deteksi Stunting</li>
            <li class="breadcrumb-item active" aria-current="page">Deteksi Ibu Melahirkan Stunting</li>
        </ol>
    </div>
@endsection

@section('content')
    <section>
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12">
                <div class="card fieldset border border-secondary bg-white p-0">
                    {{-- <div class="card-header py-3 bg-transparent border-bottom-0">
                        <h6 class="card-title mb-0">Basic example</h6>
                    </div> --}}
                    <div class="card-body">
                        @component('dashboard.components.forms.utama.deteksi_ibu_melahirkan_stunting')
                            @slot('kartuKeluarga', $kartuKeluarga)
                            @slot('daftarSoal', $daftarSoal)
                            @slot('dataEdit', $deteksiIbuMelahirkanStunting)
                            @slot('form_id', 'form_deteksi_ibu_melahirkan_stunting')
                            @slot('proses', url('proses-deteksi-ibu-melahirkan-stunting'))
                            @slot('action', url('deteksi-ibu-melahirkan-stunting/' . $deteksiIbuMelahirkanStunting->id))
                            @slot('method', 'PUT')
                            @slot('back_url', url('deteksi-ibu-melahirkan-stunting'))
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
        $('#ms-link-ibu-melahirkan-stunting').addClass('active')
    </script>
@endpush
