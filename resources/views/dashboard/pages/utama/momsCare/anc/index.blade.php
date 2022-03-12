@extends('dashboard.layouts.main')

@section('title')
    ANC (Antenatal Care)
@endsection

@push('style')
    <style>
        
    </style>
@endpush

@section('breadcrumb')
<div class="col">
    <ol class="breadcrumb bg-transparent mb-0">
        <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Moms Care</li>
        <li class="breadcrumb-item active" aria-current="page">ANC (Antenatal Care)</li>
    </ol>
</div>
@endsection

@section('content')
    <div class="row g-3 row-deck">

    </div>
@endsection

@push('script')
    <script>
        $('#m-link-moms-care').addClass('active');
        $('#menu-moms-care').addClass('collapse show')
        $('#ms-link-anc').addClass('active')     
    </script>
@endpush
