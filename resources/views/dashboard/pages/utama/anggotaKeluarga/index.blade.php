@extends('dashboard.layouts.main')

@section('title')
    Anggota Keluarga
@endsection

@push('style')
    <style>

    </style>
@endpush

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Anggota Keluarga</li>
        </ol>
    </div>
@endsection

@section('content')
    <section>
        <div class="row mb-4">
            <div class="col">
                <div class="card">
                    <div
                        class="card-header bg-light-secondary d-flex justify-content-between align-items-center border-bottom-0 pt-3 pb-0">
                        <h5 class="card-title mb-2">Data Anggota Keluarga</h5>
                        @component('dashboard.components.buttons.add', [
                            'id' => 'catatan-pertumbuhan-anak',
                            'class' => '',
                            'url' => url('anggota-keluarga' . '/' . Auth::user()->profil->kartu_keluarga_id . '/create'),
                            ])
                        @endcomponent
                    </div>
                    <div class="card-body py-3">
                        <div class="row g-3">
                            <div class="col-lg-12 mt-0">
                                {{-- <div class="card fieldset border  p-lg-3 pt-4"> --}}
                                <div class="owl-carousel owl-theme owl-loaded owl-drag" id="anggota-keluarga-list">
                                    <div class="owl-stage-outer">
                                        <div class="owl-stage"
                                            style="transform: translate3d(0px, 0px, 0px); transition: all 0s ease 0s; width: 1084px;">
                                            @foreach ($keluarga as $item)
                                                {{-- @if ($item->is_valid == 1) --}}
                                                <div class="owl-item active" style="width: 206.8px; margin-right: 10px;">
                                                    <div class="item card ribbon fieldset border border-info">
                                                        @if ($item->status_hubungan_dalam_keluarga == 1)
                                                            <div class="option-10 position-absolute text-light">
                                                                <i class="fa fa-star"></i>
                                                            </div>
                                                        @endif
                                                        <div class="card-body p-0">
                                                            <div class="row justify-content-center">
                                                                <div class="avatar xl rounded-circle no-thumbnail mb-3">
                                                                    <img src="{{ isset($item) &&$item->foto_profil != null &&Storage::exists('upload/foto_profil/keluarga/' . $item->foto_profil)? asset('upload/foto_profil/keluarga/' . $item->foto_profil): asset('assets/dashboard/images/avatar.png') }}"
                                                                        alt="Avatar"
                                                                        class="rounded-circle avatar xl shadow img-thumbnail">
                                                                </div>
                                                            </div>
                                                            <small
                                                                class="text-muted">{{ $item->statusHubunganDalamKeluarga->status_hubungan }}
                                                            </small>
                                                            <div class="d-flex">
                                                                <p>{{ $item->nama_lengkap }}</p>
                                                                <p style="margin-left: auto; order: 2">
                                                                    <a id="btn-lihat" class="text-primary"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Lihat"
                                                                        data-anggota-keluarga={{ $item->id }}
                                                                        data-kartu-keluarga={{ $item->kartu_keluarga_id }}
                                                                        style="cursor: pointer"><i
                                                                            class="fa-solid shadow fa-circle-info"></i></a>
                                                                </p>
                                                            </div>
                                                            <ul class="list-group list-group-custom text-center">
                                                                <li class="list-group-item p-2 py-1 text-muted">
                                                                    <span>{{ ucfirst(strtolower($item->jenis_kelamin)) }}</span>
                                                                </li>
                                                                <li class="list-group-item p-2 py-1 text-muted">
                                                                    <span>{{ Carbon\Carbon::parse($item->tanggal_lahir)->translatedFormat('j F Y') }}</span>
                                                                </li>
                                                                <li class="list-group-item p-2 py-1 text-muted">
                                                                    <span>
                                                                        {{ \Carbon\Carbon::parse($item->tanggal_lahir)->diff(\Carbon\Carbon::now())->format('%y Tahun, %m Bulan') }}
                                                                    </span>
                                                                </li>
                                                                <li class="list-group-item p-2 py-1 text-muted">
                                                                    <span>
                                                                        {{ ucfirst(strtolower($item->wilayahDomisili->desaKelurahan->nama)) }}
                                                                    </span>
                                                                </li>
                                                                <li class="list-group-item p-2 py-1 text-muted">
                                                                    <span>
                                                                        @if ($item->is_valid == 1)
                                                                            <span
                                                                                class="badge rounded-pill bg-success">Tervalidasi</span>
                                                                        @elseif($item->is_valid == 2)
                                                                            <span
                                                                                class="badge rounded-pill bg-danger">Ditolak</span>
                                                                        @else
                                                                            <span
                                                                                class="badge rounded-pill bg-warning">Belum
                                                                                Divalidasi</span>
                                                                        @endif
                                                                    </span>
                                                                </li>
                                                                {{-- <li class="list-group-item p-2 py-1 text-muted"><span> {{  $item->bidan ? $item->bidan->nama_lengkap :  '-' }}</span></li> --}}
                                                            </ul>
                                                            @if ($item->is_valid == 2)
                                                                <div class="row justify-content-center mt-3">
                                                                    <div class="col-lg-12 text-center">
                                                                        <a
                                                                            href="{{ url('anggota-keluarga/' . $item->kartu_keluarga_id . '/' . $item->id) . '/edit' }}">
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
                                                        <a href="{{ url('anggota-keluarga' . '/' . Auth::user()->profil->kartu_keluarga_id . '/create') }}"
                                                            class="text-center text-muted">
                                                            <h1><i class="bi bi-plus-circle bi-lg"></i></h1>
                                                            <h6>Tambah Anggota</h6>
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
                        <div class="w-100">
                            <h5>Detail Keluarga</h5>
                        </div>

                        <button type="button" class="btn-close float-end" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p class="text-muted mb-0" id="">Dibuat: </p>
                            <p class="text-muted" id="modal-created-at">-</p>
                        </div>

                        <div class="col-6 float-end text-end" id="terakhir-diperbarui">
                            <p class="text-muted mb-0" id="">Terakhir Diperbarui: </p>
                            <p class="text-muted" id="modal-updated-at">-</p>
                        </div>
                    </div>

                    <div class="alert kategori-alert alert-primary rounded-4 mb-0">
                        <div class="d-flex align-items-center">
                            <div class="avatar rounded no-thumbnail kategori-bg bg-primary text-light mx-1"><i
                                    class="fa-solid fa-map-location-dot"></i></div>
                            <div class="d-flex w-100 justify-content-between align-items-center" style="font-size: 0.8em">
                                <div class="" id="">DOMISILI: </div>
                                <div class="float-end text-end" id="modal-domisili"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col mb-2">
                            <div class="card fieldset border border-dark">
                                <span class="fieldset-tile text-dark ml-5 bg-white">Info Kepala Keluarga:</span>
                                <div class="card-body p-0 py-1 px-1">
                                    <ul class="list-unstyled mb-0">
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-person fa-lg"></i> Nama Lengkap</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-nama-lengkap"> -
                                            </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-id-card"></i> NIK</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-nik"> - </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-venus-mars"></i> Jenis Kelamin</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-jenis-kelamin"> -
                                            </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-map-location-dot"></i> Tempat Lahir</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-tempat-lahir"> -
                                            </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="bi bi-calendar2-event-fill"></i> Tanggal Lahir</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-tanggal-lahir"> -
                                            </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-hands-praying"></i> Agama</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-agama"> - </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-graduation-cap"></i> Pendidikan</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-pendidikan"> -
                                            </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-briefcase"></i> Jenis Pekerjaan</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-jenis-pekerjaan">
                                                - </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-droplet"></i> Golongan Darah</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-golongan-darah">
                                                - </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-ring"></i> Status Perkawinan</label>
                                            <span class="badge bg-info float-end text-uppercase"
                                                id="modal-status-perkawinan"> - </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-calendar-day"></i> Tanggal Perkawinan</label>
                                            <span class="badge bg-info float-end text-uppercase"
                                                id="modal-tanggal-perkawinan"> - </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-people-roof"></i> Status Dalam Keluarga</label>
                                            <span class="badge bg-info float-end text-uppercase"
                                                id="modal-status-hubungan">
                                                - </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-flag"></i> Kewarganegaraan</label>
                                            <span class="badge bg-info float-end text-uppercase"
                                                id="modal-kewarganegaraan">
                                                - </span>
                                        </li>
                                        <li class="justify-content-between mb-2" id="li-nomor-paspor">
                                            <label><i class="fa-solid fa-passport"></i> Nomor Paspor</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-nomor-paspor"> -
                                            </span>
                                        </li>
                                        <li class="justify-content-between mb-2" id="li-nomor-kitap">
                                            <label><i class="fa-solid fa-passport"></i> Nomor KITAP</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-nomor-kitap"> -
                                            </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-person fa-lg"></i> Nama Ayah</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-nama-ayah"> -
                                            </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-person-dress fa-lg"></i> Nama Ibu</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-nama-ibu"> -
                                            </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-road"></i> Alamat Domisili</label>
                                            <span class="badge bg-info float-end text-uppercase"
                                                id="modal-alamat-domisili"> - </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-location-dot"></i> Desa/Kelurahan Domisili</label>
                                            <span class="badge bg-info float-end text-uppercase"
                                                id="modal-desa-kelurahan-domisili"> - </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-location-dot"></i> Kecamatan Domisili</label>
                                            <span class="badge bg-info float-end text-uppercase"
                                                id="modal-kecamatan-domisili"> - </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-location-dot"></i> Kabupaten/Kota Domisili</label>
                                            <span class="badge bg-info float-end text-uppercase"
                                                id="modal-kabupaten-kota-domisili"> - </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-location-dot"></i> Provinsi Domisili</label>
                                            <span class="badge bg-info float-end text-uppercase"
                                                id="modal-provinsi-domisili"> - </span>
                                        </li>
                                        <li class="justify-content-between mb-2 d-none" id="col-sk-domisili">
                                            <label><i class="fa-solid fa-file"></i> Surat Keterangan Domisili</label>
                                            <a href="#" id="file-surat-keterangan-domisili" target="_blank"><span
                                                    class="badge bg-success shadow float-end text-uppercase">Lihat</span></a>
                                            <span class="badge bg-info shadow float-end text-uppercase"
                                                id="modal-file-surat-keterangan-domisili">Tidak Ada</span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-phone"></i> Nomor HP</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-nomor-hp"> -
                                            </span>
                                        </li>
                                        <li class="justify-content-between mb-2">
                                            <label><i class="fa-solid fa-clipboard-question"></i> Status</label>
                                            <span class="badge bg-info float-end text-uppercase"
                                                id="modal-status-konfirmasi"> - </span>
                                        </li>
                                        <li class="justify-content-between mb-2" id="li-modal-tanggal-konfirmasi">
                                            <label><i class="bi bi-calendar2-event-fill"></i> Tanggal Konfirmasi</label>
                                            <span class="badge bg-info float-end text-uppercase"
                                                id="modal-tanggal-konfirmasi"> - </span>
                                        </li>
                                        <li class="justify-content-between mb-2" id="li-modal-oleh-bidan">
                                            <label><i class="fa-solid fa-stethoscope"></i> Oleh Bidan</label>
                                            <span class="badge bg-info float-end text-uppercase" id="modal-oleh-bidan"> -
                                            </span>
                                        </li>
                                        <li class="justify-content-between">
                                            <label><i class="fa-solid fa-image"></i> Foto Profil</label>
                                            <span class="float-end" id="modal-foto-profil">
                                            </span>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2 mt-3">
                        <div class="col">
                            <button class="btn btn-outline-dark text-uppercase w-100" data-bs-dismiss="modal"
                                aria-label="Close"><i class="bi bi-x-circle"></i> Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $('#m-link-anggota-keluarga').addClass('active');

        $(document).on('click', '#btn-lihat', function() {
            let anggotaKeluarga = $(this).data('anggota-keluarga');
            let keluarga = $(this).data('kartu-keluarga');
            $.ajax({
                type: "GET",
                url: "{{ url('anggota-keluarga') }}" + '/' + keluarga + '/' + anggotaKeluarga,
                success: function(data) {
                    $('#modal-lihat').modal('show');
                    $('#col-sk-domisili').addClass('d-none');
                    $('#modal-file-surat-keterangan-domisili').addClass('d-none')
                    $('#file-surat-keterangan-domisili').addClass('d-none')
                    $('#col-modal-btn-ubah').addClass('d-none');
                    $('#col-modal-btn-konfirmasi').addClass('d-none');
                    $('#li-modal-tanggal-konfirmasi').addClass('d-none');
                    $('#li-modal-oleh-bidan').addClass('d-none');
                    $('#form-konfirmasi').addClass('d-none');
                    $('#col-alasan').addClass('d-none');
                    $('#konfirmasi').val('');
                    $('#nama-bidan').val('');
                    $('#alasan').val('');

                    $('#modal-created-at').html(moment(data.created_at).format('LL'));
                    if (data.updated_at != null) {
                        $('#modal-updated-at').html(moment(data.updated_at).format('LL'));
                    } else {
                        $('#modal-updated-at').html(moment(data.created_at).format('LL'));
                    }
                    $('#modal-domisili').html(data.desa_kelurahan_domisili + ', ' + data
                        .kecamatan_domisili + ', ' + data.kabupaten_kota_domisili + ', ' + data
                        .provinsi_domisili)
                    $('#modal-nama-lengkap').html(data.nama_lengkap);
                    $('#modal-jenis-kelamin').html(data.jenis_kelamin);
                    $('#modal-nik').html(data.nik);
                    $('#modal-tempat-lahir').html(data.tempat_lahir);
                    $('#modal-tanggal-lahir').html(moment(data.tanggal_lahir).format('LL'));
                    $('#modal-agama').html(data.agama_);
                    $('#modal-pendidikan').html(data.pendidikan_);
                    $('#modal-jenis-pekerjaan').html(data.pekerjaan_);
                    $('#modal-golongan-darah').html(data.golongan_darah_);
                    $('#modal-status-perkawinan').html(data.status_perkawinan_);
                    if (data.tanggal_perkawinan != null) {
                        $('#modal-tanggal-perkawinan').html(moment(data.tanggal_perkawinan).format(
                            'LL'));
                    } else {
                        $('#modal-tanggal-perkawinan').html('-');
                    }
                    $('#modal-status-hubungan').html(data.status_hubungan_);
                    $('#modal-kewarganegaraan').html(data.kewarganegaraan);
                    $('#modal-nomor-paspor').html(data.no_paspor);
                    $('#modal-nomor-kitap').html(data.no_kitap);
                    $('#modal-nama-ayah').html(data.nama_ayah);
                    $('#modal-nama-ibu').html(data.nama_ibu);

                    $('#modal-alamat-domisili').html(data.alamat_domisili);
                    $('#modal-desa-kelurahan-domisili').html(data.desa_kelurahan_domisili);
                    $('#modal-kecamatan-domisili').html(data.kecamatan_domisili);
                    $('#modal-kabupaten-kota-domisili').html(data.kabupaten_kota_domisili);
                    $('#modal-provinsi-domisili').html(data.provinsi_domisili);

                    if (data.is_valid == 0) {
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

                        $('#modal-btn-konfirmasi').data('anggota-keluarga', anggotaKeluarga);
                        $('#modal-btn-konfirmasi').data('kartu-keluarga', keluarga);

                    } else {
                        $('#li-modal-tanggal-konfirmasi').removeClass('d-none');
                        $('#li-modal-oleh-bidan').removeClass('d-none');
                        if (data.is_valid == 1) {
                            $('#modal-status-konfirmasi').text('Tervalidasi');
                            if (('{{ Auth::user()->profil->nama_lengkap }}' == data.nama_bidan) ||
                                (
                                    '{{ Auth::user()->role }}' == 'admin')) {
                                $('#col-modal-btn-ubah').removeClass('d-none');
                                $('#modal-btn-ubah').attr('href',
                                    '{{ url('anggota-keluarga') }}' +
                                    '/' + keluarga + '/' + anggotaKeluarga + '/edit');
                            } else {
                                $('#col-modal-btn-ubah').addClass('d-none');
                            }
                        } else if (data.is_valid == 2) {
                            $('#modal-status-konfirmasi').text('Ditolak');
                        }
                        $('#modal-tanggal-konfirmasi').text(moment(data.tanggal_validasi).format(
                            'LL'));
                        $('#modal-tanggal-konfirmasi').html(moment(data.tanggal_validasi).format(
                            'LL'));
                        $('#modal-oleh-bidan').text(data.nama_bidan);
                    }


                    if (data.desa_kelurahan_nama != data.desa_kelurahan_domisili) {
                        $('#col-sk-domisili').removeClass('d-none');
                        if (data.surat_keterangan_domisili) {
                            $('#file-surat-keterangan-domisili').removeClass('d-none');
                            $('#file-surat-keterangan-domisili').attr('href',
                                '{{ asset('upload/surat_keterangan_domisili') }}/' + data
                                .surat_keterangan_domisili);
                        } else {
                            $('#modal-file-surat-keterangan-domisili').removeClass('d-none')
                        }
                    }

                    if (data.foto_profil != null) {
                        $('#modal-foto-profil').html(
                            '<div class="image-input shadow avatar xxl rounded-4" style="background-image: url(../upload/foto_profil/keluarga/' +
                            data.foto_profil + ')">')
                    } else {
                        $('#modal-foto-profil').html(
                            '<span class="badge bg-info text-uppercase shadow">Tidak Ada</span>'
                        )
                    }

                    $('#modal-nomor-hp').html(data.nomor_hp);
                },
            })
        })

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
