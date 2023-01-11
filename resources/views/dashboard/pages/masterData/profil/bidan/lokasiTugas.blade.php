@extends('dashboard.layouts.main')

@section('title')
    Lokasi Tugas Bidan
@endsection

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil</li>
            <li class="breadcrumb-item active" aria-current="page">Bidan</li>
            <li class="breadcrumb-item active" aria-current="page">Lokasi Tugas</li>
        </ol>
    </div>
@endsection

@section('content')
    <section>
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12">
                <div class="card p-0">
                    <div class="card-body pt-0">
                        @component('dashboard.components.forms.masterData.lokasiTugas',
                            [
                                'user' => $bidan,
                                'provinsi' => $provinsi,
                                'kabupatenKota' => $kabupatenKota,
                                'kecamatan' => $kecamatan,
                                'desaKelurahan' => $desaKelurahan,
                                'form_id' => 'form_update_lokasi_tugas',
                                'action' => route('updateLokasiTugasBidan', $bidan->id),
                                'back_url' => route('bidan.index'),
                            ])
                        @endcomponent

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $('#m-link-profil').addClass('active');
        $('#menu-profil').addClass('collapse show')
        $('#ms-link-master-data-profil-bidan').addClass('active')
    </script>
@endpush
