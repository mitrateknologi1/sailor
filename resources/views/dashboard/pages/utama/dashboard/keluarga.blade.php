@extends('dashboard.layouts.main')

@section('title')
    Dashboard
@endsection

@push('style')
    <style>

    </style>
@endpush

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row g-3">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="alert alert-info rounded-4">
                <div class="card-body p-0">
                    <i class="fa-solid fa-people-roof position-absolute top-0 end-0 mt-3 me-3"></i>
                    <div class="mb-2 text-uppercase">Anggota Keluarga</div>
                    <small>Untuk melihat dan menambahkan anggota keluarga baru</small>
                </div>
                <div class="progress mt-2" style="height: 1px;">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="mt-2 text-center">
                    <a href="{{ url('anggota-keluarga/' . Auth::user()->profil->kartu_keluarga_id) }} "><span
                            class="badge shadow rounded-pill bg-info  mb-2">Anggota
                            Keluarga</span></a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="alert alert-primary rounded-4">
                <div class="card-body p-0">
                    <svg class="position-absolute top-0 end-0 mt-3 me-3 text-primary" xmlns="http://www.w3.org/2000/svg"
                        width="18" fill="currentColor" class="bi bi-ui-checks" viewBox="0 0 16 16">
                        <path
                            d="M7 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zM2 1a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2zm0 8a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2H2zm.854-3.646a.5.5 0 0 1-.708 0l-1-1a.5.5 0 1 1 .708-.708l.646.647 1.646-1.647a.5.5 0 1 1 .708.708l-2 2zm0 8a.5.5 0 0 1-.708 0l-1-1a.5.5 0 0 1 .708-.708l.646.647 1.646-1.647a.5.5 0 0 1 .708.708l-2 2zM7 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zm0-5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z">
                        </path>
                    </svg>
                    <div class="mb-2 text-uppercase">Deteksi Stunting</div>
                    <small>Peruntukan untuk Ibu yang akan melahirkan dan BALITA</small>
                </div>
                <div class="progress mt-2" style="height: 1px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="mt-2 text-center">
                    <a href="{{ url('/stunting-anak') }} "><span
                            class="badge shadow rounded-pill bg-primary  mb-2">Stunting Anak</span></a>
                    <a href="{{ url('/deteksi-ibu-melahirkan-stunting') }}"><span
                            class="badge shadow rounded-pill bg-primary">Ibu Melahirkan Stunting</span></a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="alert alert-success rounded-4">
                <div class="card-body p-0">
                    <svg class="position-absolute top-0 end-0 mt-3 me-3 text-success" xmlns="http://www.w3.org/2000/svg"
                        width="18" fill="currentColor" class="bi bi-person-hearts" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M11.5 1.246c.832-.855 2.913.642 0 2.566-2.913-1.924-.832-3.421 0-2.566ZM9 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h10s1 0 1-1-1-4-6-4-6 3-6 4Zm13.5-8.09c1.387-1.425 4.855 1.07 0 4.277-4.854-3.207-1.387-5.702 0-4.276ZM15 2.165c.555-.57 1.942.428 0 1.711-1.942-1.283-.555-2.281 0-1.71Z">
                        </path>
                    </svg>

                    <div class="mb-2 text-uppercase">Moms Care</div>
                    <small>Peruntukan untuk Ibu yang akan melahirkan</small>
                </div>
                <div class="progress mt-2" style="height: 1px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="mt-2 text-center">
                    <a href="{{ url('/perkiraan-melahirkan') }}"><span
                            class="badge shadow rounded-pill bg-success  mb-2">Perkiraan Lahir</span></a>
                    <a href="{{ url('/deteksi-dini') }}"><span class="badge shadow rounded-pill bg-success">Deteksi
                            Dini</span></a>
                    <a href="{{ url('/anc') }}"><span class="badge shadow rounded-pill bg-success">ANC</span></a>
                </div>

            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="alert alert-danger rounded-4">
                <div class="card-body p-0">
                    <svg class="position-absolute top-0 end-0 mt-3 me-3 text-danger" xmlns="http://www.w3.org/2000/svg"
                        width="18" fill="currentColor" class="bi bi-graph-up-arrow" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M0 0h1v15h15v1H0V0Zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5Z">
                        </path>
                    </svg>
                    <div class="mb-2 text-uppercase">Tumbuh Kembang</div>
                    <small>Diperuntukan untuk BALITA & anak yang berusia Remaja</small>
                </div>
                <div class="progress mt-2" style="height: 1px;">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="mt-2 text-center">
                    <a href="{{ url('/pertumbuhan-anak') }}"><span
                            class="badge shadow rounded-pill bg-danger  mb-2">Pertumbuhan</span></a>
                    <a href="{{ url('/perkembangan-anak') }}"><span
                            class="badge shadow rounded-pill bg-danger">Perkembangan</span></a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $('#m-link-dashboard').addClass('active');

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
                    items: 4,
                    nav: true,
                    loop: false
                },
                1400: {
                    items: 4,
                    nav: true,
                    loop: false
                }
            }
        })
    </script>
@endpush
