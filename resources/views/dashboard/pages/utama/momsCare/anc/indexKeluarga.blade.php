@extends('dashboard.layouts.main')

@section('title')
    ANC
@endsection

@push('style')
@endpush

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Moms Care</li>
            <li class="breadcrumb-item active" aria-current="page">ANC</li>
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
                        <h5 class="card-title mb-2">Data ANC</h5>
                        @if (Auth::user()->role != 'penyuluh')
                            @component('dashboard.components.buttons.add',
                                [
                                    'id' => 'btn-tambah',
                                    'class' => '',
                                    'url' => url('anc/create'),
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
                                            @foreach ($anc as $item)
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
                                                                <p style="margin-left: auto; order: 2"><a href="#"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        id="btn-lihat" title="Lihat"
                                                                        value={{ $item->id }}><i
                                                                            class="fa-solid shadow fa-circle-info"></i></a>
                                                                </p>
                                                            </div>
                                                            <ul class="list-group list-group-custom text-center">
                                                                <li class="list-group-item p-2 py-1 text-muted">
                                                                    <span>{{ $usia }}</span>
                                                                </li>
                                                                <li class="list-group-item p-2 py-1 ">
                                                                    <span>Pemeriksaan Ke :
                                                                        {{ $item->pemeriksaan_ke }}</span>
                                                                </li>
                                                                <li class="list-group-item p-2 py-1 ">
                                                                    <span>Kehamilan Ke :
                                                                        {{ $item->pemeriksaanAnc->kehamilan_ke }}</span>
                                                                </li>
                                                                <li class="list-group-item p-2 py-1 ">
                                                                    <span>Badan :
                                                                        <br>
                                                                        @if ($item->kategori_badan == 'Normal')
                                                                            <span class="badge bg-success">Normal
                                                                            </span>
                                                                        @else
                                                                            <span class="badge bg-danger">Resiko Tinggi
                                                                            </span>
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                                <li class="list-group-item p-2 py-1 ">
                                                                    <span>Tekanan Darah :
                                                                        <br>
                                                                        @if ($item->kategori_tekanan_darah == 'Normal')
                                                                            <span class="badge bg-success">Normal
                                                                            </span>
                                                                        @elseif ($item->kategori_tekanan_darah == 'Hipotensi')
                                                                            <span class="badge bg-primary">Hipotensi
                                                                            </span>
                                                                        @elseif($item->kategori_tekanan_darah == 'Prahipertensi')
                                                                            <span class="badge bg-warning">Prahipertensi
                                                                            </span>
                                                                        @else
                                                                            <span class="badge bg-danger">Hipertensi
                                                                            </span>
                                                                        @endif

                                                                    </span>
                                                                </li>
                                                                <li class="list-group-item p-2 py-1 ">
                                                                    <span>Lengan Atas :
                                                                        <br>
                                                                        @if ($item->kategori_lengan_atas == 'Normal')
                                                                            <span class="badge bg-success">Normal
                                                                            </span>
                                                                        @else
                                                                            <span class="badge bg-danger">Normal
                                                                            </span>
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                                <li class="list-group-item p-2 py-1 ">
                                                                    <span>Hemoglobin Darah :
                                                                        <br>
                                                                        @if ($item->kategori_hemoglobin_darah == 'Normal')
                                                                            <span class="badge bg-success">Normal
                                                                            </span>
                                                                        @else
                                                                            <span class="badge bg-danger">Anemia
                                                                            </span>
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                                <li class="list-group-item p-2 py-1 ">
                                                                    <span>Minum 90 Tablet Tambah Darah :
                                                                        <br>
                                                                        @if ($item->minum_tablet == 'Sudah')
                                                                            <span class="badge bg-success">Sudah
                                                                            </span>
                                                                        @else
                                                                            <span class="badge bg-danger">Belum
                                                                            </span>
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                                <li class="list-group-item p-2 py-1 text-muted">
                                                                    <span>
                                                                        @if ($item->is_valid == 1)
                                                                            <span
                                                                                class="badge bg-success">Tervalidasi</span>
                                                                        @elseif($item->is_valid == 2)
                                                                            <span class="badge bg-danger">Ditolak</span>
                                                                        @else
                                                                            <span class="badge bg-warning">Belum
                                                                                Divalidasi</span>
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                                <li class="list-group-item p-2 py-1 text-muted"><i
                                                                        class="fa-solid fa-stethoscope"></i>
                                                                    <span>{{ $item->bidan ? $item->bidan->nama_lengkap : '-' }}</span>
                                                                </li>
                                                            </ul>
                                                            @if ($item->is_valid == 2)
                                                                <div class="row justify-content-center mt-3">
                                                                    <div class="col-lg-12 text-center">
                                                                        <a
                                                                            href="{{ url('anc') . '/' . $item->id . '/edit' }}">
                                                                            <span
                                                                                class="btn btn-sm btn-outline-danger shadow-sm"><i
                                                                                    class="fas fa-edit"></i> Perbarui
                                                                                Data</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            @endif
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
                                                        <a href="{{ url('anc/create') }}" class="text-center text-muted">
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

    <div class="modal fade" id="modal-lihat" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body custom_scroll p-lg-4 pb-3">
                    <div class="d-flex w-100 justify-content-between">
                        <div>
                            <h5>Hasil Antenatal Care</h5>
                            <p class="text-muted mb-0" id="tanggal-proses"> - </p>
                        </div>
                        <button type="button" class="btn-close float-end" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="card fieldset border border-dark my-4">
                        <span class="fieldset-tile text-dark ml-5 bg-white">Info Ibu:</span>
                        <div class="card-body p-0 py-1 px-1">
                            <ul class="list-unstyled mb-0">
                                <li class="justify-content-between mb-2">
                                    <label><i class="fa-solid fa-child"></i> Nama Ibu:</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-nama-ibu"> - </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Pemeriksaan Ke:</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-pemeriksaan-ke"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Kehamilan Ke:</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-kehamilan-ke"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="bi bi-calendar2-event-fill"></i> Tanggal Lahir</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-tanggal-lahir"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="bi bi-calendar2-event-fill"></i> Tanggal Haid Terakhir</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-tanggal-haid-terakhir"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="bi bi-calendar2-event-fill"></i> Usia Kehamilan :</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-usia-kehamilan"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="bi bi-calendar2-event-fill"></i> Tanggal Perkiraan Lahir :</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-tanggal-perkiraan-lahir">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-ruler-combined"></i> Tinggi / Berat Badan :</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-tinggi-berat-badan">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pump-medical"></i> Sistolik / Diastolik :</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-sistolik-diastolik">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-hand-paper"></i> Lengan Atas :</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-lengan-atas">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-ruler-vertical"></i> Tinggi Fundus (Cm) :</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-tinggi-fundus">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-heart"></i> Hemoglobin Darah :</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-hemoglobin-darah">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-heartbeat"></i> Denyut Jantung Janin :</label>
                                    <span class="badge bg-info float-end text-uppercase" id="modal-denyut-jantung">
                                        -
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card fieldset border border-dark my-4">
                        <span class="fieldset-tile text-dark ml-5 bg-white">Hasil :</span>
                        <div class="card-body p-0 py-1 px-1">
                            <ul class="list-unstyled mb-0">
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Badan:</label>
                                    <span class="badge float-end text-uppercase kategori-bg"
                                        id="modal-kategori-tinggi-badan"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Tekanan Darah:</label>
                                    <span class="badge float-end text-uppercase kategori-bg"
                                        id="modal-kategori-tekanan-darah"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Lengan Atas:</label>
                                    <span class="badge float-end text-uppercase kategori-bg"
                                        id="modal-kategori-lengan-atas"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Denyut Jantung:</label>
                                    <span class="badge float-end text-uppercase kategori-bg"
                                        id="modal-kategori-denyut-jantung"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Hemoglobin Darah:</label>
                                    <span class="badge float-end text-uppercase kategori-bg"
                                        id="modal-kategori-hemoglobin-darah">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Vaksin Tetanus Sebelum Hamil:</label>
                                    <span class="badge float-end text-uppercase kategori-bg"
                                        id="modal-vaksin-tetanus-sebelum-hamil">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Vaksin Tetanus Sesudah Hamil:</label>
                                    <span class="badge float-end text-uppercase kategori-bg"
                                        id="modal-vaksin-tetanus-sesudah-hamil">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Posisi Janin:</label>
                                    <span class="badge float-end text-uppercase kategori-bg" id="modal-posisi-janin">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Minum 90 Tablet Tambah darah:</label>
                                    <span class="badge float-end text-uppercase kategori-bg" id="modal-minum-tablet">
                                        -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fas fa-pencil-alt"></i> Konseling:</label>
                                    <span class="badge float-end text-uppercase kategori-bg" id="modal-konseling">
                                        -
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-sm-6 col-lg-12">
                            <button class="btn btn-outline-dark text-uppercase w-100" data-bs-dismiss="modal"
                                aria-label="Close"><i class="bi bi-x-circle"></i> Tutup</button>
                        </div>
                        {{-- <div class="col-sm-6 col-lg-8">
                            @component('dashboard.components.buttons.edit', [
    'id' => 'modal-btn-ubah',
])
                            @endcomponent
                        </div> --}}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).on('click', '#btn-lihat', function() {
            let id = $(this).attr('value');
            $.ajax({
                type: "GET",
                url: "{{ url('anc') }}" + '/' + id,
                success: function(data) {
                    $('#modal-lihat').modal('show');
                    $('#tanggal-proses').text('Tanggal : ' + moment().format('LL'))
                    $('#modal-nama-ibu').text(data.nama_ibu);
                    $('#modal-tanggal-lahir').text(moment(data.tanggal_lahir)
                        .format('LL'));
                    $('#modal-usia').text(data.usia_tahun);
                    $('#modal-status').text(data.status);
                    $('#modal-tanggal-haid-terakhir').text(data
                        .tanggal_haid_terakhir_sebut);
                    $('#modal-pemeriksaan-ke').text(data
                        .pemeriksaan_ke);
                    $('#modal-kehamilan-ke').text(data
                        .kehamilan_ke);
                    $('#modal-tanggal-perkiraan-lahir').text(data
                        .tanggal_perkiraan_lahir_sebut);
                    $('#modal-kategori-tinggi-badan').text(data
                        .kategori_tinggi_badan);
                    $('#modal-kategori-tekanan-darah').text(data
                        .kategori_tekanan_darah);
                    $('#modal-kategori-lengan-atas').text(data
                        .kategori_lengan_atas);
                    $('#modal-kategori-denyut-jantung').text(data
                        .kategori_denyut_jantung);
                    $('#modal-kategori-hemoglobin-darah').text(data
                        .kategori_hemoglobin_darah);
                    $('#modal-tinggi-berat-badan').text(data
                        .tinggi_badan + " Cm / " + data
                        .berat_badan + " Kg");
                    $('#modal-sistolik-diastolik').text(data
                        .tekanan_darah_sistolik + " / " + data
                        .tekanan_darah_diastolik);
                    $('#modal-usia-kehamilan').text(data
                        .usia_kehamilan + ' Minggu Lagi');
                    $('#modal-lengan-atas').text(data
                        .lengan_atas);
                    $('#modal-tinggi-fundus').text(data
                        .tinggi_fundus);
                    $('#modal-hemoglobin-darah').text(data
                        .hemoglobin_darah);
                    $('#modal-denyut-jantung').text(data
                        .denyut_jantung);
                    $('#modal-vaksin-tetanus-sebelum-hamil').text(data
                        .vaksin_tetanus_sebelum_hamil);
                    $('#modal-vaksin-tetanus-sesudah-hamil').text(data
                        .vaksin_tetanus_sesudah_hamil);
                    $('#modal-posisi-janin').text(data
                        .posisi_janin);
                    $('#modal-minum-tablet').text(data
                        .minum_tablet);
                    $('#modal-konseling').text(data
                        .konseling);

                    var kategoriBg = ['bg-danger', 'bg-warning', 'bg-info',
                        'bg-success', 'bg-primary'
                    ];
                    var kategoriAlert = ['alert-danger', 'alert-warning',
                        'alert-info', 'alert-success', 'alert-primary'
                    ];
                    var kategoriEmot = ['fa-solid fa-face-frown',
                        'fa-solid fa-face-meh', 'fa-solid fa-face-smile',
                        'fa-solid fa-face-surprise'
                    ];
                    $.each(kategoriBg, function(i, v) {
                        $('.kategori-bg').removeClass(v);
                    });
                    $.each(kategoriAlert, function(i, v) {
                        $('.kategori-alert').removeClass(v);
                    });
                    $.each(kategoriEmot, function(i, v) {
                        $('.kategori-emot').removeClass(v);
                    });

                    if (data.kategori_tinggi_badan == 'Resiko Tinggi') {
                        $('#modal-kategori-tinggi-badan').addClass('bg-danger');
                    } else {
                        $('#modal-kategori-tinggi-badan').addClass('bg-success');
                    }

                    if (data.kategori_tekanan_darah == 'Hipotensi') {
                        $('#modal-kategori-tekanan-darah').addClass('bg-primary');
                    } else if (data.kategori_tekanan_darah == 'Normal') {
                        $('#modal-kategori-tekanan-darah').addClass('bg-success');
                    } else if (data.kategori_tekanan_darah == 'Prahipertensi') {
                        $('#modal-kategori-tekanan-darah').addClass('bg-warning');
                    } else {
                        $('#modal-kategori-tekanan-darah').addClass('bg-danger');
                    }

                    if (data.kategori_lengan_atas == 'Kurang Gizi (BBLR)') {
                        $('#modal-kategori-lengan-atas').addClass('bg-danger');
                    } else {
                        $('#modal-kategori-lengan-atas').addClass('bg-success');
                    }

                    if (data.kategori_denyut_jantung == 'Normal') {
                        $('#modal-kategori-denyut-jantung').addClass('bg-success');
                    } else {
                        $('#modal-kategori-denyut-jantung').addClass('bg-danger');
                    }

                    if (data.kategori_hemoglobin_darah == 'Normal') {
                        $('#modal-kategori-hemoglobin-darah').addClass(
                            'bg-success');
                    } else {
                        $('#modal-kategori-hemoglobin-darah').addClass('bg-danger');
                    }

                    if (data.vaksin_tetanus_sebelum_hamil == 'Sudah') {
                        $('#modal-vaksin-tetanus-sebelum-hamil').addClass(
                            'bg-success');
                    } else {
                        $('#modal-vaksin-tetanus-sebelum-hamil').addClass(
                            'bg-danger');
                    }

                    if (data.vaksin_tetanus_sesudah_hamil == 'Sudah') {
                        $('#modal-vaksin-tetanus-sesudah-hamil').addClass(
                            'bg-success');
                    } else {
                        $('#modal-vaksin-tetanus-sesudah-hamil').addClass(
                            'bg-danger');
                    }

                    if (data.posisi_janin == 'Normal') {
                        $('#modal-posisi-janin').addClass('bg-success');
                    } else {
                        $('#modal-posisi-janin').addClass('bg-danger');
                    }

                    if (data.minum_tablet == 'Sudah') {
                        $('#modal-minum-tablet').addClass('bg-success');
                    } else {
                        $('#modal-minum-tablet').addClass('bg-danger');
                    }

                    if (data.konseling == 'Sudah') {
                        $('#modal-konseling').addClass('bg-success');
                    } else {
                        $('#modal-konseling').addClass('bg-danger');
                    }

                    if (("{{ Auth::user()->profil->id }}" == data.bidan_id) || (
                            "{{ Auth::user()->role }}" ==
                            "admin")) {
                        $('#modal-btn-ubah').attr('href', "{{ url('anc') }}" + '/' +
                            id + '/edit');
                        $('#modal-btn-ubah').show();
                    } else {
                        $('#modal-btn-ubah').hide();
                    }

                },
            })
        })
    </script>
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

        $('#m-link-moms-care').addClass('active');
        $('#menu-moms-care').addClass('collapse show')
        $('#ms-link-anc').addClass('active')
    </script>
@endpush
