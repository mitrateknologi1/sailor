@extends('dashboard.layouts.main')

@section('title')
    Deteksi Ibu Melahirkan Stunting
@endsection

@push('style')
@endpush

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Deteksi Stunting</li>
            <li class="breadcrumb-item active" aria-current="page">Deteksi Ibu Melahirkan Stunting</li>
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
                        <h5 class="card-title mb-2">Data Deteksi Ibu Melahirkan Stunting</h5>
                        @if (Auth::user()->role != 'penyuluh')
                            @component('dashboard.components.buttons.add',
                                [
                                    'id' => 'btn-tambah',
                                    'class' => '',
                                    'url' => url('deteksi-ibu-melahirkan-stunting/create'),
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
                                            @foreach ($deteksiIbuMelahirkanStunting as $item)
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
                                                                    <img src="{{ isset($item->anggotaKeluarga) && $item->anggotaKeluarga->foto_profil != null && Storage::exists('upload/foto_profil/keluarga/' . $item->anggotaKeluarga->foto_profil) ? Storage::url('upload/foto_profil/keluarga/' . $item->anggotaKeluarga->foto_profil) : asset('assets/dashboard/images/avatar.png') }}"
                                                                        alt="Avatar"
                                                                        class="rounded-circle avatar xl shadow img-thumbnail">
                                                                </div>
                                                            </div>
                                                            <small
                                                                class="text-muted">{{ Carbon\Carbon::parse($item->created_at)->translatedFormat('j F Y') }}
                                                            </small>
                                                            <div class="d-flex">
                                                                <p>{{ $item->anggotaKeluarga->nama_lengkap }}</p>
                                                                <p style="margin-left: auto; order: 2"><a
                                                                        href="{{ url('deteksi-ibu-melahirkan-stunting/' . $item->id) }}"
                                                                        id="btn-lihat" data-toggle="tooltip"
                                                                        data-placement="top" title="Lihat"
                                                                        value={{ $item->id }}><i
                                                                            class="fa-solid shadow fa-circle-info"></i></a>
                                                                </p>
                                                            </div>
                                                            <ul class="list-group list-group-custom text-center">
                                                                <li class="list-group-item p-2 py-1 text-muted">
                                                                    <span>{{ $usia }}</span>
                                                                </li>
                                                                <li class="list-group-item p-2 py-1 text-muted">
                                                                    <span>
                                                                        @if ($item->kategori == 'Beresiko Melahirkan Stunting')
                                                                            <span class="badge bg-danger">Beresiko
                                                                                Melahirkan Stunting
                                                                            </span>
                                                                        @elseif($item->kategori == 'Tidak Beresiko Melahirkan Stunting')
                                                                            <span class="badge bg-success">Tidak Beresiko
                                                                                Melahirkan Stunting</span>
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
                                                                            href="{{ url('deteksi-ibu-melahirkan-stunting') . '/' . $item->id . '/edit' }}">
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
                                                        <a href="{{ url('deteksi-ibu-melahirkan-stunting/create') }}"
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

        $('#m-link-deteksi-stunting').addClass('active');
        $('#menu-deteksi-stunting').addClass('collapse show')
        $('#ms-link-ibu-melahirkan-stunting').addClass('active')

        $(document).on('click', '#btn-lihat', function() {
            let id = $(this).attr('value');
            $.ajax({
                type: "GET",
                url: "{{ url('stunting-anak') }}" + '/' + id,
                success: function(data) {
                    console.log(data);
                    $('#modal-lihat').modal('show');
                    $('#tanggal-proses').text('Dibuat Tanggal: ' + data.tanggal_proses);
                    $('#modal-nama-anak').text(data.nama_anak);
                    $('#modal-nama-ayah').text(data.nama_ayah);
                    $('#modal-nama-ibu').text(data.nama_ibu);
                    $('#modal-tanggal-lahir').text(data.tanggal_lahir);
                    $('#modal-usia').text(data.usia);
                    $('#modal-jenis-kelamin').text(data.jenis_kelamin);
                    $('#modal-tinggi-badan').text(data.tinggi_badan + ' Cm');
                    $('#modal-kategori').text(data.kategori);
                    $('#modal-zscore').text('ZScore : ' + data.zscore);
                    $('#modal-desa-kelurahan').text(data.desa_kelurahan);
                    $('#modal-diperiksa-divalidasi').text(data.tanggal_validasi);
                    $('#modal-nama-bidan').text(data.bidan);
                    $('#modal-btn-ubah').attr('href', "{{ url('stunting-anak') }}" + '/' +
                        id + '/edit');

                    var kategoriBg = ['bg-danger', 'bg-warning', 'bg-info', 'bg-success', 'bg-primary'];
                    var kategoriAlert = ['alert-danger', 'alert-warning', 'alert-info', 'alert-success',
                        'alert-primary'
                    ];
                    var kategoriEmot = ['fa-solid fa-face-frown', 'fa-solid fa-face-meh',
                        'fa-solid fa-face-smile', 'fa-solid fa-face-surprise'
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

                    if (data.kategori == 'Sangat Pendek (Resiko Stunting Tinggi)') {
                        $('.kategori-bg').addClass('bg-danger');
                        $('.kategori-alert').addClass('alert-danger');
                        $('#kategori-emot').addClass('fa-solid fa-face-frown');
                    } else if (data.kategori == 'Pendek (Resiko Stunting Sedang)') {
                        $('.kategori-bg').addClass('bg-warning');
                        $('.kategori-alert').addClass('alert-warning');
                        $('#kategori-emot').addClass('fa-solid fa-face-meh');
                    } else if (data.kategori == 'Normal') {
                        $('.kategori-bg').addClass('bg-success');
                        $('.kategori-alert').addClass('alert-success');
                        $('#kategori-emot').addClass('fa-solid fa-face-smile');
                    } else if (data.kategori == 'Tinggi') {
                        $('.kategori-bg').addClass('bg-primary');
                        $('.kategori-alert').addClass('alert-primary');
                        $('#kategori-emot').addClass('fa-solid fa-face-surprise');
                    }
                },
            })
        })
    </script>
@endpush
