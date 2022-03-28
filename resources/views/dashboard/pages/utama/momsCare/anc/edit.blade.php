@extends('dashboard.layouts.main')

@section('title')
    Edit Perkiraan Melahirkan
@endsection

@push('style')
@endpush

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Moms Care</li>
            <li class="breadcrumb-item active" aria-current="page">Perkiraan Melahirkan</li>
            <li class="breadcrumb-item active" aria-current="page">Edit Perkiraan Melahirkan</li>
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
                        @component('dashboard.components.forms.utama.perkiraan_melahirkan')
                            @slot('kartuKeluarga', $kartuKeluarga)
                            @slot('form_id', 'form_perkiraan_melahirkan')
                            @slot('proses', url('proses-perkiraan-melahirkan'))
                            @slot('dataEdit', $perkiraanMelahirkan)
                            @slot('action', url('perkiraan-melahirkan/' . $perkiraanMelahirkan->id))
                            @slot('method', 'PUT')
                            @slot('back_url', url('perkiraan-melahirkan'))
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
