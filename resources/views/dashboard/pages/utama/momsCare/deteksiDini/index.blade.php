@extends('dashboard.layouts.main')

@section('title')
    Deteksi Dini
@endsection

@section('breadcrumb')
<div class="col">
    <ol class="breadcrumb bg-transparent mb-0">
        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Moms Care</li>
        <li class="breadcrumb-item active" aria-current="page">Deteksi Dini</li>
    </ol>
</div>
@endsection

@section('content')
    <div class="row g-3 row-deck">

    </div>
@endsection

@section('script')
    <script>
        $('#m-link-moms-care').addClass('active');
        $('#menu-moms-care').addClass('collapse show')
        $('#ms-link-deteksi-dini').addClass('active')     
    </script>
@endsection
