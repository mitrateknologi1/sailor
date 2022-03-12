@extends('dashboard.layouts.main')

@section('title')
    Deteksi Ibu Melahirkan Stunting
@endsection

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Wilayah</a></li>
            <li class="breadcrumb-item active" aria-current="page">Prov. Sulawesi Tengah</li>
            <li class="breadcrumb-item active" aria-current="page">Kab. Parigi Moutong</li>
            <li class="breadcrumb-item active" aria-current="page">Kec. Parigi</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row g-3 row-deck">

    </div>
@endsection

@push('script')
    <script>
        $('#m-link-wilayah').addClass('active');
    </script>
@endpush
