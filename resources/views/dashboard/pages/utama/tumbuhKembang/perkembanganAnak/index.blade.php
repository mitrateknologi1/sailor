@extends('dashboard.layouts.main')

@section('title')
    Perkembangan Anak
@endsection

@push('style')
    <style>

    </style>
@endpush

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tumbuh Kembang</li>
            <li class="breadcrumb-item active" aria-current="page">Perkembangan Anak</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row g-3 row-deck">

    </div>
@endsection

@push('script')
    <script>
        $('#m-link-tumbuh-kembang').addClass('active');
        $('#menu-tumbuh-kembang').addClass('collapse show')
        $('#ms-link-perkembangan-anak').addClass('active')
    </script>
@endpush
