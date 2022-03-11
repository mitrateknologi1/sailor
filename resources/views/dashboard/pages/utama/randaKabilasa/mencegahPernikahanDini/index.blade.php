@extends('dashboard.layouts.main')

@section('title')
    Mencegah Pernikahan Dini
@endsection

@section('breadcrumb')
<div class="col">
    <ol class="breadcrumb bg-transparent mb-0">
        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Randa Kabilasa</li>
        <li class="breadcrumb-item active" aria-current="page">Mencegah Pernikahan Dini</li>
    </ol>
</div>
@endsection

@section('content')
    <div class="row g-3 row-deck">

    </div>
@endsection

@section('script')
    <script>
        $('#m-link-randa-kabilasa').addClass('active');
        $('#menu-randa-kabilasa').addClass('collapse show')
        $('#ms-link-mencegah-pernikahan-dini').addClass('active')     
    </script>
@endsection
