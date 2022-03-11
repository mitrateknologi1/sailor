@extends('dashboard.layouts.main')

@section('title')
    Deteksi Stunting Anak
@endsection

@section('breadcrumb')
<div class="col">
    <ol class="breadcrumb bg-transparent mb-0">
        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Deteksi Stunting</li>
        <li class="breadcrumb-item active" aria-current="page">Stunting Anak</li>
    </ol>
</div>
@endsection

@section('content')
    <div class="row g-3 row-deck">

    </div>
@endsection

@section('script')
    <script>
        $('#m-link-deteksi-stunting').addClass('active');
        $('#menu-deteksi-stunting').addClass('collapse show')
        $('#ms-link-stunting-anak').addClass('active')     
    </script>
@endsection
