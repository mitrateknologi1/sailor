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
                    <svg class="position-absolute top-0 end-0 mt-3 me-3 text-info" xmlns="http://www.w3.org/2000/svg"
                        width="18" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
                        <path fill-rule="evenodd"
                            d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z">
                        </path>
                        <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"></path>
                    </svg>
                    <div class="mb-2 text-uppercase">Randa Kabilasa</div>
                </div>
                <div class="progress mt-2" style="height: 1px;">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="mt-2">
                    <div class="d-flex flex-wrap justify-content-between small">Total Data: <span
                            class="fw-bold">{{ $randaKabilasaTotal }}</span></div>
                </div>
                @if (Auth::user()->role != 'penyuluh')
                    <div class="">
                        <a href="{{ url('randa-kabilasa') }}"><span
                                class="badge shadow rounded-pill bg-info  mb-2">Asesmen
                                Mencegah
                                Malnutrisi</span></a>
                        <div class="d-flex flex-wrap justify-content-between small">Divalidasi: <span
                                class="fw-bold">{{ $randaKabilasaMencegahMalnutrisiValidasi }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Ditolak: <span
                                class="fw-bold">{{ $randaKabilasaMencegahMalnutrisiDitolak }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Belum Divalidasi: <span
                                class="fw-bold">{{ $randaKabilasaMencegahMalnutrisiBelumValidasi }}</span></div>
                    </div>
                    @if ($randaKabilasaMencegahMalnutrisiBelumValidasi > 0)
                        <div class="text-center">
                            @component('dashboard.components.buttons.validasi',
                                [
                                    'url' => url('randa-kabilasa'),
                                ])
                            @endcomponent
                        </div>
                    @endif
                    <div class="progress mt-2" style="height: 1px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="100"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ url('randa-kabilasa') }}"><span
                                class="badge shadow rounded-pill bg-info  mb-2">Asesmen
                                Meningkatkan Life
                                Skill</span></a>
                        <div class="d-flex flex-wrap justify-content-between small">Divalidasi: <span
                                class="fw-bold">{{ $randaKabilasaMeningkatkanLifeSkillValidasi }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Ditolak: <span
                                class="fw-bold">{{ $randaKabilasaMeningkatkanLifeSkillDitolak }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Belum Divalidasi: <span
                                class="fw-bold">{{ $randaKabilasaMeningkatkanLifeSkillBelumValidasi }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Belum Melakukan Asesmen: <span
                                class="fw-bold">{{ $randaKabilasaMeningkatkanLifeSkillBelumAsesmen }}</span></div>
                    </div>
                    @if ($randaKabilasaMeningkatkanLifeSkillBelumValidasi > 0)
                        <div class="text-center">
                            @component('dashboard.components.buttons.validasi',
                                [
                                    'url' => url('randa-kabilasa'),
                                ])
                            @endcomponent
                        </div>
                    @endif
                    <div class="progress mt-2" style="height: 1px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="100"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ url('randa-kabilasa') }}"><span
                                class="badge shadow rounded-pill bg-info  mb-2">Asesmen
                                Mencegah Pernikahan
                                Dini</span></a>
                        <div class="d-flex flex-wrap justify-content-between small">Divalidasi: <span
                                class="fw-bold">{{ $randaKabilasaMencegahPernikahanDiniValidasi }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Ditolak: <span
                                class="fw-bold">{{ $randaKabilasaMencegahPernikahanDiniDitolak }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Belum Divalidasi: <span
                                class="fw-bold">{{ $randaKabilasaMencegahPernikahanDiniBelumValidasi }}</span>
                        </div>
                        <div class="d-flex flex-wrap justify-content-between small">Belum Melakukan Asesmen: <span
                                class="fw-bold">{{ $randaKabilasaMencegahPernikahanDiniBelumAsesmen }}</span>
                        </div>
                    </div>
                    @if ($randaKabilasaMencegahPernikahanDiniBelumValidasi > 0)
                        <div class="text-center">
                            @component('dashboard.components.buttons.validasi',
                                [
                                    'url' => url('randa-kabilasa'),
                                ])
                            @endcomponent
                        </div>
                    @endif
                @endif
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
                </div>
                <div class="progress mt-2" style="height: 1px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="mt-2">
                    <a href="{{ url('perkiraan-melahirkan') }}"><span
                            class="badge shadow rounded-pill bg-success  mb-2">Perkiraan Melahirkan</span></a>
                    @if (Auth::user()->role != 'penyuluh')
                        <div class="d-flex flex-wrap justify-content-between small">Divalidasi: <span
                                class="fw-bold">{{ $perkiraanMelahirkanValidasi }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Ditolak: <span
                                class="fw-bold">{{ $perkiraanMelahirkanDitolak }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Belum Divalidasi: <span
                                class="fw-bold">{{ $perkiraanMelahirkanBelumValidasi }}</span></div>
                    @endif
                    <div class="d-flex flex-wrap justify-content-between small">Total Data: <span
                            class="fw-bold">{{ $perkiraanMelahirkanTotal }}</span></div>
                </div>
                @if ($perkiraanMelahirkanBelumValidasi > 0)
                    <div class="text-center">
                        @component('dashboard.components.buttons.validasi',
                            [
                                'url' => url('perkiraan-melahirkan'),
                            ])
                        @endcomponent
                    </div>
                @endif
                <div class="progress mt-2" style="height: 1px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="mt-2">
                    <a href="{{ url('deteksi-dini') }}"><span class="badge shadow rounded-pill bg-success  mb-2">Deteksi
                            Dini</span></a>
                    @if (Auth::user()->role != 'penyuluh')
                        <div class="d-flex flex-wrap justify-content-between small">Divalidasi: <span
                                class="fw-bold">{{ $deteksiDiniValidasi }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Ditolak: <span
                                class="fw-bold">{{ $deteksiDiniDitolak }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Belum Divalidasi: <span
                                class="fw-bold">{{ $deteksiDiniBelumValidasi }}</span></div>
                    @endif
                    <div class="d-flex flex-wrap justify-content-between small">Total Data: <span
                            class="fw-bold">{{ $deteksiDiniTotal }}</span></div>
                </div>
                @if ($deteksiDiniBelumValidasi > 0)
                    <div class="text-center">
                        @component('dashboard.components.buttons.validasi',
                            [
                                'url' => url('deteksi-dini'),
                            ])
                        @endcomponent
                    </div>
                @endif
                <div class="progress mt-2" style="height: 1px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="mt-2">
                    <a href="{{ url('anc') }}"><span class="badge shadow rounded-pill bg-success  mb-2">ANC</span></a>
                    @if (Auth::user()->role != 'penyuluh')
                        <div class="d-flex flex-wrap justify-content-between small">Divalidasi: <span
                                class="fw-bold">{{ $ancValidasi }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Ditolak: <span
                                class="fw-bold">{{ $ancDitolak }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Belum Divalidasi: <span
                                class="fw-bold">{{ $ancBelumValidasi }}</span></div>
                    @endif
                    <div class="d-flex flex-wrap justify-content-between small">Total Data: <span
                            class="fw-bold">{{ $ancTotal }}</span></div>
                </div>
                @if ($ancBelumValidasi > 0)
                    <div class="text-center">
                        @component('dashboard.components.buttons.validasi',
                            [
                                'url' => url('anc'),
                            ])
                        @endcomponent
                    </div>
                @endif
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
                </div>
                <div class="progress mt-2" style="height: 1px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="mt-2">
                    <a href="{{ url('stunting-anak') }}"><span
                            class="badge shadow rounded-pill bg-primary  mb-2">Stunting
                            Anak</span></a>
                    @if (Auth::user()->role != 'penyuluh')
                        <div class="d-flex flex-wrap justify-content-between small">Divalidasi: <span
                                class="fw-bold">{{ $stuntingAnakValidasi }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Ditolak: <span
                                class="fw-bold">{{ $stuntingAnakDitolak }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Belum Divalidasi: <span
                                class="fw-bold">{{ $stuntingAnakBelumValidasi }}</span></div>
                    @endif
                    <div class="d-flex flex-wrap justify-content-between small">Total Data: <span
                            class="fw-bold">{{ $stuntingAnakTotal }}</span></div>
                </div>
                @if ($stuntingAnakBelumValidasi > 0)
                    <div class="text-center">
                        @component('dashboard.components.buttons.validasi',
                            [
                                'url' => url('stunting-anak'),
                            ])
                        @endcomponent
                    </div>
                @endif
                <div class="progress mt-2" style="height: 1px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="mt-2">
                    <a href="{{ url('deteksi-ibu-melahirkan-stunting') }}"><span
                            class="badge shadow rounded-pill bg-primary  mb-2">Ibu Melahirkan Stunting</span></a>
                    @if (Auth::user()->role != 'penyuluh')
                        <div class="d-flex flex-wrap justify-content-between small">Divalidasi: <span
                                class="fw-bold">{{ $ibuMelahirkanStuntingValidasi }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Ditolak: <span
                                class="fw-bold">{{ $ibuMelahirkanStuntingDitolak }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Belum Divalidasi: <span
                                class="fw-bold">{{ $ibuMelahirkanStuntingBelumValidasi }}</span></div>
                    @endif
                    <div class="d-flex flex-wrap justify-content-between small">Total Data: <span
                            class="fw-bold">{{ $ibuMelahirkanStuntingTotal }}</span></div>
                </div>
                @if ($ibuMelahirkanStuntingBelumValidasi > 0)
                    <div class="text-center">
                        @component('dashboard.components.buttons.validasi',
                            [
                                'url' => url('deteksi-ibu-melahirkan-stunting'),
                            ])
                        @endcomponent
                    </div>
                @endif
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
                </div>
                <div class="progress mt-2" style="height: 1px;">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="mt-2">
                    <a href="{{ url('pertumbuhan-anak') }}"><span
                            class="badge shadow rounded-pill bg-danger  mb-2">Pertumbuhan Anak</span></a>
                    @if (Auth::user()->role != 'penyuluh')
                        <div class="d-flex flex-wrap justify-content-between small">Divalidasi: <span
                                class="fw-bold">{{ $pertumbuhanAnakValidasi }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Ditolak: <span
                                class="fw-bold">{{ $pertumbuhanAnakDitolak }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Belum Divalidasi: <span
                                class="fw-bold">{{ $pertumbuhanAnakBelumValidasi }}</span></div>
                    @endif
                    <div class="d-flex flex-wrap justify-content-between small">Total Data: <span
                            class="fw-bold">{{ $pertumbuhanAnakTotal }}</span></div>
                </div>
                @if ($pertumbuhanAnakBelumValidasi > 0)
                    <div class="text-center">
                        @component('dashboard.components.buttons.validasi',
                            [
                                'url' => url('pertumbuhan-anak'),
                            ])
                        @endcomponent
                    </div>
                @endif
                <div class="progress mt-2" style="height: 1px;">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 100%" aria-valuenow="100"
                        aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="mt-2">
                    <a href="{{ url('perkembangan-anak') }}"><span
                            class="badge shadow rounded-pill bg-danger  mb-2">Perkembangan Anak</span></a>
                    @if (Auth::user()->role != 'penyuluh')
                        <div class="d-flex flex-wrap justify-content-between small">Divalidasi: <span
                                class="fw-bold">{{ $perkembanganAnakValidasi }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Ditolak: <span
                                class="fw-bold">{{ $perkembanganAnakDitolak }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Belum Divalidasi: <span
                                class="fw-bold">{{ $perkembanganAnakBelumValidasi }}</span></div>
                    @endif
                    <div class="d-flex flex-wrap justify-content-between small">Total Data: <span
                            class="fw-bold">{{ $perkembanganAnakTotal }}</span></div>
                </div>
                @if ($perkembanganAnakBelumValidasi > 0)
                    <div class="text-center">
                        @component('dashboard.components.buttons.validasi',
                            [
                                'url' => url('perkembangan-anak'),
                            ])
                        @endcomponent
                    </div>
                @endif
            </div>

        </div>

        @if (Auth::user()->role != 'penyuluh')
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="alert alert-primary rounded-4">
                    <div class="card-body p-0">
                        <svg class="position-absolute top-0 end-0 mt-3 me-3 text-primary"
                            xmlns="http://www.w3.org/2000/svg" width="18" fill="currentColor" class="bi bi-person-video"
                            viewBox="0 0 16 16">
                            <path d="M8 9.05a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                            <path
                                d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2Zm10.798 11c-.453-1.27-1.76-3-4.798-3-3.037 0-4.345 1.73-4.798 3H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-1.202Z" />
                        </svg>

                        <div class="mb-2 text-uppercase">Profil</div>
                    </div>
                    <div class="progress mt-2" style="height: 1px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ url('keluarga') }}"><span
                                class="badge shadow rounded-pill bg-primary  mb-2">Keluarga</span></a>
                        <div class="d-flex flex-wrap justify-content-between small">Divalidasi: <span
                                class="fw-bold">{{ $keluargaValidasi }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Ditolak: <span
                                class="fw-bold">{{ $keluargaDitolak }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Belum Divalidasi: <span
                                class="fw-bold">{{ $keluargaBelumValidasi }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Total Data: <span
                                class="fw-bold">{{ $keluargaTotal }}</span></div>
                    </div>
                    @if ($keluargaBelumValidasi > 0)
                        <div class="text-center">
                            @component('dashboard.components.buttons.validasi',
                                [
                                    'url' => url('keluarga'),
                                ])
                            @endcomponent
                        </div>
                    @endif
                    <div class="progress mt-2" style="height: 1px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ url('keluarga') }}"><span class="badge shadow rounded-pill bg-primary  mb-2">Anggota
                                Keluarga</span></a>
                        <div class="d-flex flex-wrap justify-content-between small">Divalidasi: <span
                                class="fw-bold">{{ $anggotaKeluargaValidasi }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Ditolak: <span
                                class="fw-bold">{{ $anggotaKeluargaDitolak }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Belum Divalidasi: <span
                                class="fw-bold">{{ $anggotaKeluargaBelumValidasi }}</span></div>
                        <div class="d-flex flex-wrap justify-content-between small">Total Data: <span
                                class="fw-bold">{{ $anggotaKeluargaTotal }}</span></div>
                    </div>
                    @if ($anggotaKeluargaBelumValidasi > 0)
                        <div class="text-center">
                            @component('dashboard.components.buttons.validasi',
                                [
                                    'url' => url('keluarga'),
                                ])
                            @endcomponent
                        </div>
                    @endif
                </div>
            </div>
        @endif
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
