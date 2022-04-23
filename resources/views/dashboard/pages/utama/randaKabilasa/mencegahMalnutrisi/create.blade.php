@extends('dashboard.layouts.main')

@section('title')
    Tambah Randa Kabilasa
@endsection

@push('style')
@endpush

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Randa Kabilasa</li>
            <li class="breadcrumb-item active" aria-current="page">Mencegah Malnutrisi</li>
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
                        @component('dashboard.components.forms.utama.mencegah_malnutrisi')
                            @slot('kartuKeluarga', $kartuKeluarga)
                            @slot('daftarSoal', $daftarSoal)
                            @slot('form_id', 'form_add_pertumbuhan_anak')
                            @slot('proses', url('proses-mencegah-malnutrisi'))
                            @slot('action', url('mencegah-malnutrisi'))
                            @slot('method', 'POST')
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
