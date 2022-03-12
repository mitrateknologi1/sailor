@extends('dashboard.layouts.main')

@section('title')
    Meningkatkan Life Skill & Potensi Diri
@endsection

@push('style')
    <style>
        
    </style>
@endpush

@section('breadcrumb')
<div class="col">
    <ol class="breadcrumb bg-transparent mb-0">
        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Randa Kabilasa</li>
        <li class="breadcrumb-item active" aria-current="page">Meningkatkan Life Skill & Potensi Diri</li>
    </ol>
</div>
@endsection

@section('content')
    <div class="row g-3 row-deck">

    </div>
@endsection

@push('script')
    <script>
        $('#m-link-randa-kabilasa').addClass('active');
        $('#menu-randa-kabilasa').addClass('collapse show')
        $('#ms-link-meningkatkan-life-skill').addClass('active')     
    </script>
@endpush
