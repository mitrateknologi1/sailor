@extends('dashboard.layouts.main')

@section('title')
    Detail Mencegah Pernikahan Dini
@endsection

@push('style')
@endpush

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Randa Kabilasa</li>
            <li class="breadcrumb-item active" aria-current="page">Mencegah Pernikahan Dini</li>
        </ol>
    </div>
@endsection

@section('content')
    <section>
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12">
                <div class="card p-0">
                    {{-- <div class="card-header py-3 bg-transparent border-bottom-0">
                        <h6 class="card-title mb-0">Basic example</h6>
                    </div> --}}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="d-flex w-100 justify-content-between mb-1">
                                    <div>
                                        <h5>Hasil Mencegah Pernikahan Dini</h5>
                                        <p class="text-muted" id="tanggal-proses"> {{ $data['tanggal_proses'] }} </p>
                                    </div>
                                </div>
                                @php
                                    if ($data['kategori'] == 'Tidak Berpartisipasi Mencegah Stunting') {
                                        $classKategoriEmot = 'fa-solid fa-face-frown';
                                        $classKategoriAlert = 'alert-danger';
                                        $classKategoriBg = 'bg-danger';
                                    } else {
                                        $classKategoriEmot = 'fa-solid fa-face-smile';
                                        $classKategoriAlert = 'alert-success';
                                        $classKategoriBg = 'bg-success';
                                    }
                                @endphp
                                <div class="alert kategori-alert rounded-4 {{ $classKategoriAlert }}">
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="avatar rounded no-thumbnail kategori-bg text-light {{ $classKategoriBg }}">
                                            <i id="kategori-emot" class="{{ $classKategoriEmot }}"></i>
                                        </div>
                                        <div class="d-flex w-100 justify-content-between align-items-center">
                                            <div class="h6 mb-0" id="modal-kategori" style="margin-left: 5px">
                                                {{ $data['kategori'] }} </div>
                                            <div class="float-end" id="modal-zscore"><span class="badge kategori-bg">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card fieldset border border-dark my-4">
                                    <span class="fieldset-tile text-dark ml-5 bg-white">Info Remaja :</span>
                                    <div class="card-body p-0 py-1 px-1">
                                        <ul class="list-unstyled mb-0">
                                            <li class="justify-content-between mb-2">
                                                <label><i class="fa-solid fa-person-dress fa-lg"></i> Nama :</label>
                                                <span class="badge bg-info float-end text-uppercase" id="modal-nama-ibu">
                                                    {{ $data['nama_anak'] }}
                                                </span>
                                            </li>
                                            <li class="justify-content-between mb-2">
                                                <label><i class="bi bi-calendar2-event-fill"></i> Tanggal Lahir</label>
                                                <span class="badge bg-info float-end text-uppercase"
                                                    id="modal-tanggal-lahir">
                                                    {{ $data['tanggal_lahir'] }}
                                                </span>
                                            </li>
                                            <li class="justify-content-between mb-2">
                                                <label><i class="fa-solid fa-cake-candles"></i> Usia</label>
                                                <span class="badge bg-info float-end text-uppercase" id="modal-usia">
                                                    {{ $data['usia_tahun'] }} </span>
                                            </li>
                                            <li class="justify-content-between mb-2">
                                                <label><i class="fas fa-venus-mars"></i> Jenis Kelamin</label>
                                                <span class="badge bg-info float-end text-uppercase" id="modal-usia">
                                                    {{ $data['jenis_kelamin'] }} </span>
                                            </li>
                                            <li class="justify-content-between mb-2">
                                                <label><i class="fa-solid fa-map-location-dot"></i> Desa/Kelurahan</label>
                                                <span class="badge bg-info float-end text-uppercase"
                                                    id="modal-desa-kelurahan">
                                                    {{ $data['desa_kelurahan'] }}
                                                </span>
                                            </li>
                                            <li class="justify-content-between mb-2">
                                                <label><i class="bi bi-calendar2-event-fill"></i> Tanggal
                                                    diperiksa/validasi</label>
                                                <span class="badge bg-info float-end text-uppercase"
                                                    id="modal-diperiksa-divalidasi"> {{ $data['tanggal_validasi'] }}
                                                </span>
                                            </li>
                                            <li class="justify-content-between mb-2">
                                                <label><i class="fa-solid fa-map-location-dot"></i> Oleh Bidan</label>
                                                <span class="badge bg-info float-end text-uppercase" id="modal-nama-bidan">
                                                    {{ $data['bidan'] }}
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex w-100 justify-content-between mb-1">
                                    <div>
                                        <h5>Pertanyaan</h5>
                                    </div>
                                </div>
                                <div class="card my-3 p-0">
                                    <div class="card-body">
                                        <p>1. Apakah anda berencana menikah di usia kurang dari 20 tahun ?</p>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">Ya</label>
                                            <input class="form-check-input" type="radio" id="jawaban-1" name="jawaban_1[]"
                                                value="Ya" onchange="changeJawaban1()" disabled
                                                @if ($randaKabilasa->mencegahPernikahanDini) @if ($randaKabilasa->mencegahPernikahanDini->jawaban_1 == 'Ya')
                                checked @endif
                                                @endif
                                            >
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">Tidak</label>
                                            <input class="form-check-input" type="radio" id="jawaban-1" name="jawaban_1[]"
                                                value="Tidak" onchange="changeJawaban1()" disabled
                                                @if ($randaKabilasa->mencegahPernikahanDini) @if ($randaKabilasa->mencegahPernikahanDini->jawaban_1 == 'Tidak')
                                checked @endif
                                                @endif
                                            >
                                        </div>
                                        <p class="text-danger jawaban_1-error my-0"></p>
                                    </div>
                                </div>

                                <div class="card my-3 p-0">
                                    <div class="card-body">
                                        <p>2. Apakah anda berencana menikah di usia 21-35 tahun ?</p>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">Ya</label>
                                            <input class="form-check-input" type="radio" id="jawaban-2" name="jawaban_2[]"
                                                value="Ya" disabled
                                                @if ($randaKabilasa->mencegahPernikahanDini) @if ($randaKabilasa->mencegahPernikahanDini->jawaban_2 == 'Ya')
                                checked @endif
                                                @endif
                                            >
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">Tidak</label>
                                            <input class="form-check-input" type="radio" id="jawaban-2" name="jawaban_2[]"
                                                value="Tidak" disabled
                                                @if ($randaKabilasa->mencegahPernikahanDini) @if ($randaKabilasa->mencegahPernikahanDini->jawaban_2 == 'Tidak')
                                checked @endif
                                                @endif
                                            >
                                        </div>
                                        <p class="text-danger jawaban_2-error my-0"></p>
                                    </div>
                                </div>

                                <div class="card my-3 p-0">
                                    <div class="card-body">
                                        <p>3. Jika anda perempuan, apakah anda berencana menikah di usia 35 tahun ? (Jawab
                                            Tidak bila anda
                                            laki-laki)</p>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">Ya</label>
                                            <input class="form-check-input" type="radio" id="jawaban-3" name="jawaban_3[]"
                                                value="Ya" disabled
                                                @if ($randaKabilasa->mencegahPernikahanDini) @if ($randaKabilasa->mencegahPernikahanDini->jawaban_3 == 'Ya')
                                checked @endif
                                                @endif
                                            >
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">Tidak</label>
                                            <input class="form-check-input" type="radio" id="jawaban-3" name="jawaban_3[]"
                                                value="Tidak" disabled
                                                @if ($randaKabilasa->mencegahPernikahanDini) @if ($randaKabilasa->mencegahPernikahanDini->jawaban_3 == 'Tidak')
                                checked @endif
                                                @endif
                                            >
                                        </div>
                                        <p class="text-danger jawaban_3-error my-0"></p>
                                    </div>
                                </div>
                                <div class="row g-2 mt-2">
                                    <div class="col-sm-6 col-lg">
                                        @component('dashboard.components.buttons.back', [
                                            'url' => url('randa-kabilasa'),
                                            ])
                                        @endcomponent
                                    </div>
                                    @if (Auth::user()->profil->id == $randaKabilasa->bidan_id || Auth::user()->role == 'admin')
                                        <div class="col-sm-6 col-lg">
                                            @component('dashboard.components.buttons.edit', [
                                                'id' => 'modal-btn-ubah',
                                                'url' => url('mencegah-pernikahan-dini' . '/' . $randaKabilasa->id . '/' .
                                                $randaKabilasa->id . '/edit'),
                                                ])
                                            @endcomponent
                                        </div>
                                    @endif
                                </div>
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
        $('#m-link-randa-kabilasa').addClass('active');
    </script>
@endpush
