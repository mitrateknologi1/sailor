@extends('dashboard.layouts.main')

@section('title')
    Randa Kabilasa
@endsection

@push('style')
@endpush

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Randa Kabilasa</li>
        </ol>
    </div>
@endsection

@section('content')
    <section>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div
                        class="card-header bg-light-secondary d-flex justify-content-between align-items-center border-bottom-0 pt-3 pb-0">
                        <h5 class="card-title mb-2">Data Randa Kabilasa</h5>
                        @if (Auth::user()->role != 'penyuluh')
                            @component('dashboard.components.buttons.add',
                                [
                                    'id' => 'btn-tambah',
                                    'class' => '',
                                    'url' => url('mencegah-malnutrisi/create'),
                                ])
                            @endcomponent
                        @endif
                    </div>
                    <div class="card-body py-3">
                        <div class="row g-3">
                            <div class="col-lg-12 mt-0">
                                {{-- <div class="card fieldset border  p-lg-3 pt-4"> --}}
                                <div class="owl-carousel owl-theme owl-loaded owl-drag" id="anggota-keluarga-list">
                                    <div class="owl-stage-outer">
                                        <div class="owl-stage"
                                            style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1084px;">
                                            @foreach ($randaKabilasa as $item)
                                                @php
                                                    $datetime1 = date_create($item->created_at);
                                                    $datetime2 = date_create($item->anggotaKeluarga->tanggal_lahir);
                                                    $interval = date_diff($datetime1, $datetime2);
                                                    $usia = $interval->format('%y Tahun %m Bulan %d Hari');
                                                @endphp
                                                {{-- @if ($item->is_valid == 1) --}}
                                                <div class="owl-item active" style="width: 206.8px; margin-right: 10px;">
                                                    <div class="item card ribbon fieldset border border-info">
                                                        <div class="card-body p-0">
                                                            <div class="row justify-content-center">
                                                                <div class="avatar xl rounded-circle no-thumbnail mb-3">
                                                                    <img src="{{ isset($item->anggotaKeluarga) && $item->anggotaKeluarga->foto_profil != null? asset('upload/foto_profil/keluarga/' . $item->anggotaKeluarga->foto_profil): asset('assets/dashboard/images/avatar.png') }}"
                                                                        alt="Avatar"
                                                                        class="rounded-circle avatar xl shadow img-thumbnail">
                                                                </div>
                                                            </div>
                                                            <small
                                                                class="text-muted">{{ Carbon\Carbon::parse($item->created_at)->translatedFormat('j F Y') }}
                                                            </small>
                                                            <div class="d-flex">
                                                                <p>{{ $item->anggotaKeluarga->nama_lengkap }}</p>
                                                            </div>
                                                            <ul class="list-group list-group-custom text-center">
                                                                <li class="list-group-item p-2 py-1 text-muted">
                                                                    <span>{{ $usia }}</span>
                                                                </li>
                                                                <li class="list-group-item p-2 text-muted">
                                                                    <span>
                                                                        <div class="d-flex">
                                                                            <span>Assessmen Mencegah Malnutrisi</span>
                                                                            <p style="margin-left: auto; order: 2"><a
                                                                                    href="{{ url('/mencegah-malnutrisi/' . $item->mencegahMalnutrisi->id) }}"
                                                                                    data-toggle="tooltip"
                                                                                    data-placement="top" title="Lihat"><i
                                                                                        class="fa-solid shadow fa-circle-info"></i></a>
                                                                            </p>
                                                                        </div>
                                                                    </span>
                                                                    @if ($item->kategori_mencegah_malnutrisi == 'Berpartisipasi Mencegah Stunting')
                                                                        <span class="badge bg-success">Berpartisipasi
                                                                            Mencegah Stunting</span>
                                                                    @else
                                                                        <span class="badge bg-danger">Tidak
                                                                            Berpartisipasi Mencegah Stunting</span>
                                                                    @endif
                                                                    @if ($item->is_valid_mencegah_malnutrisi == 1)
                                                                        <span class="badge bg-success">Tervalidasi</span>
                                                                    @elseif($item->is_valid_mencegah_malnutrisi == 2)
                                                                        <span class="badge bg-danger">Ditolak</span>
                                                                    @else
                                                                        <span class="badge bg-warning">Belum
                                                                            Divalidasi</span>
                                                                    @endif
                                                                    @if ($item->is_valid_mencegah_malnutrisi == 2)
                                                                        <div class="row justify-content-center mt-3">
                                                                            <div class="col-lg-12 text-center">
                                                                                <a
                                                                                    href="{{ url('mencegah-malnutrisi') . '/' . $item->mencegahMalnutrisi->id . '/edit' }}">
                                                                                    <span
                                                                                        class="btn btn-sm btn-outline-danger shadow-sm"><i
                                                                                            class="fas fa-edit"></i>
                                                                                        Perbarui
                                                                                        Data</span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </li>
                                                                <li class="list-group-item p-2 py-1 text-muted">
                                                                    <span>
                                                                        <div class="d-flex">
                                                                            <span>Assessmen Mencegah Pernikahan Dini</span>
                                                                            <p style="margin-left: auto; order: 2"><a
                                                                                    href="{{ url('/mencegah-pernikahan-dini/' . $item->id . '/' . $item->id) }}"
                                                                                    data-toggle="tooltip"
                                                                                    data-placement="top" title="Lihat"><i
                                                                                        class="fa-solid shadow fa-circle-info"></i></a>
                                                                            </p>
                                                                        </div>

                                                                        @if ($item->is_mencegah_pernikahan_dini == 0)
                                                                            <br>
                                                                            <a class="btn btn-sm btn-primary"
                                                                                href="{{ url('mencegah-pernikahan-dini/' . $item->id . '/create') }}"><i
                                                                                    class="bi bi-plus-circle bi-lg"></i>
                                                                                Tambah</a>
                                                                        @else
                                                                            <br>
                                                                            @if ($item->kategori_mencegah_pernikahan_dini == 'Berpartisipasi Mencegah Stunting')
                                                                                <span
                                                                                    class="badge bg-success">Berpartisipasi
                                                                                    Mencegah Stunting</span>
                                                                            @else
                                                                                <span class="badge bg-danger">Tidak
                                                                                    Berpartisipasi Mencegah Stunting</span>
                                                                            @endif
                                                                            @if ($item->is_valid_mencegah_pernikahan_dini == 1)
                                                                                <span
                                                                                    class="badge bg-success">Tervalidasi</span>
                                                                            @elseif($item->is_valid_mencegah_pernikahan_dini == 2)
                                                                                <span class="badge bg-danger">Ditolak</span>
                                                                            @else
                                                                                <span class="badge bg-warning">Belum
                                                                                    Divalidasi</span>
                                                                            @endif
                                                                        @endif
                                                                        @if ($item->is_valid_mencegah_pernikahan_dini == 2)
                                                                            <div class="row justify-content-center mt-3">
                                                                                <div class="col-lg-12 text-center">
                                                                                    <a
                                                                                        href="{{ url('mencegah-pernikahan-dini') . '/' . $item->id . '/' . $item->id . '/edit' }}">
                                                                                        <span
                                                                                            class="btn btn-sm btn-outline-danger shadow-sm"><i
                                                                                                class="fas fa-edit"></i>
                                                                                            Perbarui
                                                                                            Data</span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        @endif

                                                                    </span>
                                                                </li>
                                                                <li class="list-group-item p-2 py-1 text-muted">
                                                                    <span>
                                                                        <div class="d-flex">
                                                                            <span>Assessmen Meningkatkan Life Skill</span>
                                                                            <p style="margin-left: auto; order: 2"><a
                                                                                    href="{{ url('/meningkatkan-life-skill/' . $item->id . '/' . $item->id) }}"
                                                                                    data-toggle="tooltip"
                                                                                    data-placement="top" title="Lihat"><i
                                                                                        class="fa-solid shadow fa-circle-info"></i></a>
                                                                            </p>
                                                                        </div>

                                                                        @if ($item->is_meningkatkan_life_skill == 0)
                                                                            <br>
                                                                            <a class="btn btn-sm btn-primary"
                                                                                href="{{ url('meningkatkan-life-skill/' . $item->id . '/create') }}"><i
                                                                                    class="bi bi-plus-circle bi-lg"></i>
                                                                                Tambah</a>
                                                                        @else
                                                                            @if ($item->kategori_meningkatkan_life_skill == 'Berpartisipasi Mencegah Stunting')
                                                                                <span
                                                                                    class="badge bg-success">Berpartisipasi
                                                                                    Mencegah Stunting</span>
                                                                            @else
                                                                                <span class="badge bg-danger">Tidak
                                                                                    Berpartisipasi Mencegah Stunting</span>
                                                                            @endif
                                                                            @if ($item->is_valid_meningkatkan_life_skill == 1)
                                                                                <span
                                                                                    class="badge bg-success">Tervalidasi</span>
                                                                            @elseif($item->is_valid_meningkatkan_life_skill == 2)
                                                                                <span class="badge bg-danger">Ditolak</span>
                                                                            @else
                                                                                <span class="badge bg-warning">Belum
                                                                                    Divalidasi</span>
                                                                            @endif
                                                                        @endif
                                                                        @if ($item->is_valid_meningkatkan_life_skill == 2)
                                                                            <div class="row justify-content-center mt-3">
                                                                                <div class="col-lg-12 text-center">
                                                                                    <a
                                                                                        href="{{ url('meningkatkan-life-skill') . '/' . $item->id . '/' . $item->id . '/edit' }}">
                                                                                        <span
                                                                                            class="btn btn-sm btn-outline-danger shadow-sm"><i
                                                                                                class="fas fa-edit"></i>
                                                                                            Perbarui
                                                                                            Data</span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                                <li class="list-group-item p-2 py-1 text-muted"><i
                                                                        class="fa-solid fa-stethoscope"></i>
                                                                    <span>{{ $item->bidan ? $item->bidan->nama_lengkap : '-' }}</span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- @endif --}}
                                            @endforeach
                                            <div class="owl-item active"
                                                style="width: 206.8px; margin-right: 10px; height: 328.5px;">
                                                <div class="row align-items-center justify-content-center"
                                                    style="height: 326px;">
                                                    <div class="col-12">
                                                        <a href="{{ url('mencegah-malnutrisi/create') }}"
                                                            class="text-center text-muted">
                                                            <h1><i class="bi bi-plus-circle bi-lg"></i></h1>
                                                            <h6>Tambah</h6>
                                                        </a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $('#anggota-keluarga-list').owlCarousel({
            loop: true,
            margin: 10,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 2,
                    nav: false
                },
                1000: {
                    items: 3,
                    nav: true,
                    loop: false
                },
                1400: {
                    items: 3,
                    nav: true,
                    loop: false
                }
            }
        })

        $('#m-link-randa-kabilasa').addClass('active');
    </script>
@endpush
