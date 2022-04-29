@extends('dashboard.layouts.main')

@section('title')
    Pertumbuhan Anak
@endsection

@push('style')
@endpush

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tumbuh Kembang</li>
            <li class="breadcrumb-item active" aria-current="page">Pertumbuhan Anak</li>
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
                        <h5 class="card-title mb-2">Data Pertumbuhan Anak</h5>
                        @if (Auth::user()->role != 'penyuluh')
                            @component('dashboard.components.buttons.add', [
                                'id' => 'catatan-pertumbuhan-anak',
                                'class' => '',
                                'url' => route('pertumbuhan-anak.create'),
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
                                            @foreach ($pertumbuhanAnak as $item)
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
                                                                        id="btn-lihat" data-toggle="tooltip"
                                                                        data-placement="top" title="Lihat"
                                                                        data-pertumbuhan={{ $item->id }}><i
                                                                            class="fa-solid shadow fa-circle-info"></i></a>
                                                                </p>
                                                            </div>
                                                            <ul class="list-group list-group-custom text-center">
                                                                <li class="list-group-item p-2 py-1 text-muted">
                                                                    <span>{{ $usia }}</span>
                                                                </li>
                                                                <li class="list-group-item p-2 py-1 text-muted">
                                                                    <span>{{ $item->berat_badan }} Kg</span>
                                                                </li>
                                                                <li class="list-group-item p-2 py-1 text-muted">
                                                                    <span>
                                                                        @if ($item->hasil == 'Gizi Buruk')
                                                                            <span class="badge bg-danger">Gizi Buruk</span>
                                                                        @elseif($item->hasil == 'Gizi Kurang')
                                                                            <span class="badge bg-warning">Gizi
                                                                                Kurang</span>
                                                                        @elseif($item->hasil == 'Gizi Baik')
                                                                            <span class="badge bg-success">Gizi Baik</span>
                                                                        @elseif($item->hasil == 'Gizi Lebih')
                                                                            <span class="badge bg-primary">Gizi Lebih</span>
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
                                                                            href="{{ route('pertumbuhan-anak.edit', $item->id) }}">
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
                                                        <a href="{{ route('pertumbuhan-anak.create') }}"
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

    <div class="modal fade" id="modal-lihat" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body custom_scroll p-lg-4 pb-3">
                    <div class="d-flex w-100 justify-content-between mb-1">
                        <div>
                            <h5>Detail Pertumbuhan Anak</h5>
                            <p class="text-muted tanggal-proses" id="tanggal-proses"> - </p>
                        </div>
                        <button type="button" class="btn-close float-end" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="alert kategori-alert rounded-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar rounded no-thumbnail kategori-bg text-light "><i id="kategori-emot"
                                    class="kategori-emot"></i></div>
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div class="h6 mb-0 modal-kategori" id="modal-kategori" style="margin-left: 5px"> - </div>
                                <div class="float-end modal-zscore" id="modal-zscore"><span class="badge kategori-bg"> -
                                    </span></div>
                            </div>
                        </div>
                    </div>
                    <div class="card fieldset border border-dark my-4">
                        <span class="fieldset-tile text-dark ml-5 bg-white">Info Anak:</span>
                        <div class="card-body p-0 py-1 px-1">
                            <ul class="list-unstyled mb-0">
                                <li class="justify-content-between mb-2">
                                    <label><i class="fa-solid fa-child"></i> Nama Anak:</label>
                                    <span class="badge bg-info float-end text-uppercase modal-nama-anak"
                                        id="modal-nama-anak"> - </span>
                                </li>
                                {{-- <li class="justify-content-between mb-2">
                                    <label><i class="fa-solid fa-person fa-lg"></i> Nama Ayah:</label>
                                    <span class="badge bg-info float-end text-uppercase modal-nama-ayah" id="modal-nama-ayah"> - </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fa-solid fa-person-dress fa-lg"></i> Nama Ibu:</label>
                                    <span class="badge bg-info float-end text-uppercase modal-nama-ibu" id="modal-nama-ibu"> - </span>
                                </li> --}}
                                <li class="justify-content-between mb-2">
                                    <label><i class="fa-solid fa-venus-mars"></i> Jenis Kelamin</label>
                                    <span class="badge bg-info float-end text-uppercase modal-jenis-kelamin"
                                        id="modal-jenis-kelamin"> - </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="bi bi-calendar2-event-fill"></i> Tanggal Lahir</label>
                                    <span class="badge bg-info float-end text-uppercase modal-tanggal-lahir"
                                        id="modal-tanggal-lahir"> - </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fa-solid fa-cake-candles"></i> Usia</label>
                                    <span class="badge bg-info float-end text-uppercase modal-usia" id="modal-usia"> -
                                    </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fa-solid fa-weight-scale"></i> Berat Badan</label>
                                    <span class="badge bg-info float-end text-uppercase modal-berat-badan"
                                        id="modal-berat-badan"> - </span>
                                </li>
                                <li class="justify-content-between mb-2">
                                    <label><i class="fa-solid fa-map-location-dot"></i> Desa/Kelurahan</label>
                                    <span class="badge bg-info float-end text-uppercase modal-desa-kelurahan"
                                        id="modal-desa-kelurahan"> - </span>
                                </li>
                                <li class="justify-content-between mb-2" id="li-modal-status-konfirmasi">
                                    <label><i class="fa-solid fa-clipboard-question"></i> Status</label>
                                    <span class="badge bg-info float-end text-uppercase modal-status-konfirmasi"
                                        id="modal-status-konfirmasi"> - </span>
                                </li>
                                <li class="justify-content-between mb-2" id="li-modal-tanggal-konfirmasi">
                                    <label><i class="bi bi-calendar2-event-fill"></i> Tanggal Konfirmasi</label>
                                    <span class="badge bg-info float-end text-uppercase modal-tanggal-konfirmasi"
                                        id="modal-tanggal-konfirmasi"> - </span>
                                </li>
                                <li class="justify-content-between mb-2" id="li-modal-oleh-bidan">
                                    <label><i class="fa-solid fa-stethoscope"></i> Oleh Bidan</label>
                                    <span class="badge bg-info float-end text-uppercase modal-oleh-bidan"
                                        id="modal-oleh-bidan"> - </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row g-3 align-items-end" id="form-konfirmasi">
                        <div class="col-lg col-sm-12" id="pilih-konfirmasi">
                            @component('dashboard.components.formElements.select', [
                                'label' => 'Konfirmasi',
                                'id' => 'konfirmasi',
                                'name' => 'konfirmasi',
                                'class' => 'kosong',
                                'wajib' => '<sup class="text-danger">*</sup>',
                                ])
                                @slot('options')
                                    <option value="1">Validasi</option>
                                    <option value="2">Tolak</option>
                                @endslot
                            @endcomponent
                        </div>
                        @if (Auth::user()->role == 'admin')
                            <div class="col-lg col-sm-12" id="pilih-bidan">
                                @component('dashboard.components.formElements.select', [
                                    'label' => 'Bidan sesuai lokasi domisili kepala keluarga',
                                    'id' => 'nama-bidan',
                                    'name' => 'bidan_id',
                                    'class' => 'bidan_id filter',
                                    'wajib' => '<sup class="text-danger">*</sup>',
                                    ])
                                @endcomponent
                            </div>
                        @endif
                        <div class="col-12 mt-3 d-none" id="col-alasan">
                            <label for="textareaInput" class="form-label">Alasan <sup
                                    class="text-danger">*</sup></label>
                            <textarea name="alasan" id="alasan" cols="30" rows="5" class="form-control alasan"></textarea>
                            <span class="text-danger error-text alasan-error"></span>
                        </div>
                    </div>
                    <div class="row g-2 mt-3">
                        <div class="col">
                            <button class="btn btn-outline-dark text-uppercase w-100" data-bs-dismiss="modal"
                                aria-label="Close"><i class="bi bi-x-circle"></i> Tutup</button>
                        </div>
                        <div class="col-sm-12 col-lg-8" id="col-modal-btn-ubah">
                            @component('dashboard.components.buttons.edit', [
                                'id' => 'modal-btn-ubah',
                                ])
                            @endcomponent
                        </div>
                        <div class="col-sm-12 col-lg-8" id="col-modal-btn-konfirmasi">
                            @component('dashboard.components.buttons.konfirmasi', [
                                'id' => 'modal-btn-konfirmasi',
                                ])
                            @endcomponent
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

        $('#m-link-tumbuh-kembang').addClass('active');
        $('#menu-tumbuh-kembang').addClass('collapse show')
        $('#ms-link-pertumbuhan-anak').addClass('active')

        $(document).on('click', '#btn-lihat', function() {
            let id = $(this).data('pertumbuhan');
            $.ajax({
                type: "GET",
                url: "{{ url('pertumbuhan-anak') }}" + '/' + id,
                success: function(data) {
                    $('#modal-lihat').modal('show');
                    $('#col-modal-btn-ubah').addClass('d-none');
                    $('#col-modal-btn-konfirmasi').addClass('d-none');
                    $('#li-modal-tanggal-konfirmasi').addClass('d-none');
                    $('#li-modal-oleh-bidan').addClass('d-none');
                    $('#form-konfirmasi').addClass('d-none');
                    $('#col-alasan').addClass('d-none');
                    $('#konfirmasi').val('');
                    $('#nama-bidan').val('');
                    $('#alasan').val('');

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

                    if (data.kategori == 'Gizi Buruk') {
                        $('.kategori-bg').addClass('bg-danger');
                        $('.kategori-alert').addClass('alert-danger');
                        $('.kategori-emot').addClass('fa-solid fa-face-frown');
                    } else if (data.kategori == 'Gizi Kurang') {
                        $('.kategori-bg').addClass('bg-warning');
                        $('.kategori-alert').addClass('alert-warning');
                        $('.kategori-emot').addClass('fa-solid fa-face-meh');
                    } else if (data.kategori == 'Gizi Baik') {
                        $('.kategori-bg').addClass('bg-success');
                        $('.kategori-alert').addClass('alert-success');
                        $('.kategori-emot').addClass('fa-solid fa-face-smile');
                    } else if (data.kategori == 'Gizi Lebih') {
                        $('.kategori-bg').addClass('bg-primary');
                        $('.kategori-alert').addClass('alert-primary');
                        $('.kategori-emot').addClass('fa-solid fa-face-surprise');
                    }
                    $('#tanggal-proses').text('Dibuat Tanggal: ' + moment(data.tanggal_proses).format(
                        'LL'));
                    $('#modal-nama-anak').text(data.nama_anak);
                    $('#modal-nama-ayah').text(data.nama_ayah);
                    $('#modal-nama-ibu').text(data.nama_ibu);
                    $('#modal-tanggal-lahir').text(moment(data.tanggal_lahir).format('LL'));
                    $('#modal-usia').text(data.usia_tahun);
                    $('#modal-jenis-kelamin').text(data.jenis_kelamin);
                    $('#modal-berat-badan').text(data.berat_badan + ' Kg');
                    $('#modal-kategori').text(data.kategori);
                    $('#modal-zscore').text('ZScore : ' + data.zscore);
                    $('#modal-desa-kelurahan').text(data.desa_kelurahan);

                    if (data.is_valid == 0) {
                        if ('{{ Auth::user()->role }}' != 'keluarga') {
                            $('#modal-status-konfirmasi').text('Belum Divalidasi');
                            $('#col-modal-btn-konfirmasi').removeClass('d-none');
                            $('#form-konfirmasi').removeClass('d-none');
                            $('#konfirmasi').change(function() {
                                if ($('#konfirmasi').val() == 1) {
                                    $('#col-alasan').addClass('d-none');
                                } else {
                                    $('#col-alasan').removeClass('d-none');
                                }
                                $('#alasan').val('');
                            })
                            if ('{{ Auth::user()->role }}' == 'admin') {
                                $.each(data.bidan_konfirmasi, function(key, val) {
                                    $('#nama-bidan').html('')
                                    $('#nama-bidan').append(
                                        '<option value="" selected hidden>- Pilih Salah Satu -</option>'
                                    )
                                    $('#nama-bidan').append(
                                        `<option value="${val.id}">${val.nama_lengkap}</option>`
                                    );
                                })
                            } else if ('{{ Auth::user()->role }}' == 'bidan') {
                                $('#pilih-bidan').addClass('d-none');
                            }
                            $('#modal-btn-konfirmasi').val(id)
                        } else {
                            $('#modal-status-konfirmasi').text('Belum Divalidasi');
                        }
                    } else {
                        $('#li-modal-tanggal-konfirmasi').removeClass('d-none');
                        $('#li-modal-oleh-bidan').removeClass('d-none');
                        if (data.is_valid == 1) {
                            $('#modal-status-konfirmasi').text('Tervalidasi');
                            if (('{{ Auth::user()->profil->nama_lengkap }}' == data.bidan) || (
                                    '{{ Auth::user()->role }}' == 'admin')) {
                                $('#col-modal-btn-ubah').removeClass('d-none');
                                $('#modal-btn-ubah').attr('href', '{{ url('pertumbuhan-anak') }}' +
                                    '/' + id + '/edit');
                            } else {
                                $('#col-modal-btn-ubah').addClass('d-none');
                            }
                        } else if (data.is_valid == 2) {
                            $('#modal-status-konfirmasi').text('Ditolak');
                        }
                        $('#modal-tanggal-konfirmasi').text(moment(data.tanggal_validasi).format('LL'));
                        $('#modal-oleh-bidan').text(data.bidan);
                    }
                },
            })
        })
    </script>
@endpush
