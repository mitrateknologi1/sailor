@extends('dashboard.layouts.main')

@section('title')
    Detail Mencegah Malnutrisi Remaja
@endsection

@push('style')
@endpush

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Randa Kabilasa</li>
            <li class="breadcrumb-item active" aria-current="page">Mencegah Malnutrisi Remaja</li>
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
                                        <h5>Hasil Mencegah Malnutrisi Remaja</h5>
                                        <p class="text-muted" id="tanggal-proses"> {{ $data['tanggal_proses'] }} </p>
                                    </div>
                                </div>
                                @php
                                    $looping = 1;
                                    if ($mencegahMalnutrisi->kategori == 'Tidak Berpartisipasi Mencegah Stunting') {
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
                                            <li class="justify-content-between mb-2">
                                                <label><i class="fas fa-hand-paper"></i>Lingkar Lengan Atas</label>
                                                <span class="badge bg-info float-end text-uppercase" id="modal-nama-bidan">
                                                    {{ $data['lingkar_lengan_atas'] }}
                                                </span>
                                            </li>
                                            <li class="justify-content-between mb-2">
                                                <label><i class="fas fa-ruler-combined"></i>Tinggi/Berat
                                                    Badan</label>
                                                <span class="badge bg-info float-end text-uppercase" id="modal-nama-bidan">
                                                    {{ $data['tinggi_badan'] . ' Cm / ' . $data['berat_badan'] . ' Kg' }}
                                                </span>
                                            </li>
                                            <li class="justify-content-between mb-2">
                                                <label><i class="fas fa-heartbeat"></i>Kategori Hemoglobin</label>
                                                @php
                                                    $badge = '';
                                                    if ($data['kategori_hemoglobin'] == 'Normal') {
                                                        $badge = 'bg-success';
                                                    } elseif ($data['kategori_hemoglobin'] == 'Terindikasi Anemia') {
                                                        $badge = 'bg-warning';
                                                    } else {
                                                        $badge = 'bg-danger';
                                                    }
                                                @endphp
                                                <span class="badge float-end {{ $badge }} text-uppercase"
                                                    id="modal-nama-bidan">
                                                    {{ $data['kategori_hemoglobin'] }}
                                                </span>
                                            </li>
                                            <li class="justify-content-between mb-2">
                                                <label><i class="fas fa-hand-paper"></i>Kategori Lingkar Lengan Atas</label>
                                                @php
                                                    $badge = '';
                                                    if ($data['kategori_lingkar_lengan_atas'] == 'Normal') {
                                                        $badge = 'bg-success';
                                                    } else {
                                                        $badge = 'bg-danger';
                                                    }
                                                @endphp
                                                <span class="badge float-end {{ $badge }} text-uppercase"
                                                    id="modal-nama-bidan">
                                                    {{ $data['kategori_lingkar_lengan_atas'] }}
                                                </span>
                                            </li>
                                            <li class="justify-content-between mb-2">
                                                <label><i class="fas fa-child"></i>Kategori Indeks Masa Tubuh</label>
                                                @php
                                                    $badge = '';
                                                    if ($data['kategori_imt'] == 'Normal') {
                                                        $badge = 'bg-success';
                                                    } elseif ($data['kategori_imt'] == 'Kurus' || $data['kategori_imt'] == 'Gemuk') {
                                                        $badge = 'bg-warning';
                                                    } else {
                                                        $badge = 'bg-danger';
                                                    }
                                                @endphp
                                                <span class="badge float-end {{ $badge }} text-uppercase"
                                                    id="modal-nama-bidan">
                                                    {{ $data['kategori_imt'] }}
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
                                @foreach ($daftarSoal as $soal)
                                    @php
                                        $checkedYa = '';
                                        $checkedTidak = '';

                                        $jawabanSoal = \App\Models\JawabanMencegahMalnutrisi::where('mencegah_malnutrisi_id', $mencegahMalnutrisi->id)
                                            ->where('soal_id', $soal->id)
                                            ->first();
                                        if ($jawabanSoal) {
                                            if ($jawabanSoal->jawaban == 'Ya') {
                                                $checkedYa = 'checked';
                                            } else {
                                                $checkedTidak = 'checked';
                                            }
                                        }
                                    @endphp
                                    @if ($jawabanSoal)
                                        <input type="text" value="{{ $soal->id }}" hidden name="soal_id[]">
                                        <div class="card p-0 my-3">
                                            <div class="card-body">
                                                <p>{{ $looping }}. {{ $soal->soal }}</p>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">Ya</label>
                                                    <input class="form-check-input" type="radio"
                                                        id="jawaban-{{ $looping }}"
                                                        name="jawaban-{{ $looping }}[]" value="Ya"
                                                        {{ $checkedYa }} disabled>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">Tidak</label>
                                                    <input class="form-check-input" type="radio"
                                                        id="jawaban-{{ $looping }}"
                                                        name="jawaban-{{ $looping }}[]" value="Tidak"
                                                        {{ $checkedTidak }} disabled>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $looping++;
                                        @endphp
                                    @endif
                                @endforeach
                                @if ($data['is_valid_mencegah_malnutrisi'] == 0)
                                    <div class="row g-3 align-items-end" id="form-konfirmasi">
                                        <div class="col-lg col-sm-12" id="pilih-konfirmasi">
                                            @component('dashboard.components.formElements.select',
                                                [
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
                                                @component('dashboard.components.formElements.select',
                                                    [
                                                        'label' => 'Bidan sesuai lokasi domisili kepala keluarga',
                                                        'id' => 'nama-bidan',
                                                        'name' => 'bidan_id',
                                                        'class' => 'bidan_id filter',
                                                        'wajib' => '<sup class="text-danger">*</sup>',
                                                    ])
                                                    @slot('options')
                                                        @foreach ($data['bidan_konfirmasi'] as $bidan)
                                                            <option value="{{ $bidan->id }}">{{ $bidan->nama_lengkap }}
                                                            </option>
                                                        @endforeach
                                                    @endslot
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
                                @endif
                                <div class="row g-2 mt-2">
                                    <div class="col-sm-6 col-lg">
                                        @component('dashboard.components.buttons.back',
                                            [
                                                'url' => url('randa-kabilasa'),
                                            ])
                                        @endcomponent
                                    </div>
                                    {{-- @if (Auth::user()->profil->id == $mencegahMalnutrisi->randaKabilasa->bidan_id || Auth::user()->role == 'admin')
                                        <div class="col-sm-6 col-lg">
                                            @component('dashboard.components.buttons.edit', [
    'id' => 'modal-btn-ubah',
    'url' => url('mencegah-malnutrisi' . '/' . $mencegahMalnutrisi->randaKabilasa->id . '/edit'),
])
                                            @endcomponent
                                        </div>
                                    @endif --}}
                                    @if ($data['is_valid_mencegah_malnutrisi'] == 0)
                                        <div class="col-sm-12 col-lg" id="col-modal-btn-konfirmasi">
                                            @component('dashboard.components.buttons.konfirmasi',
                                                [
                                                    'id' => 'modal-btn-konfirmasi',
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
        $('#konfirmasi').change(function() {
            if ($('#konfirmasi').val() == 1) {
                $('#col-alasan').addClass('d-none');
            } else {
                $('#col-alasan').removeClass('d-none');
            }
            $('#alasan').val('');
        })

        const printErrorMsg = (msg) => {
            $.each(msg, function(key, value) {
                $('.' + key + '-error').text(value);
            });
        }

        $(document).on('click', '#modal-btn-konfirmasi', function() {
            let id = '{{ $data['id'] }}';
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Konfirmasi data deteksi mencegah malnutrisi ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, Konfirmasi'
            }).then((result) => {
                if (result.value) {
                    $('.error-text').text('');
                    $.ajax({
                        type: "PUT",
                        url: "{{ url('mencegah-malnutrisi/validasi') }}" + '/' + id,
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id,
                            bidan_id: '{{ Auth::user()->role }}' == "admin" ? $("#nama-bidan")
                                .val() : '{{ Auth::user()->profil->id }}',
                            konfirmasi: $('#konfirmasi').val(),
                            alasan: $('#alasan').val()
                        },
                        success: function(response) {
                            if ($.isEmptyObject(response.error)) {
                                if (response.res == 'success') {
                                    if (response.konfirmasi == 1) {
                                        Swal.fire(
                                            'Berhasil!',
                                            'Data berhasil divalidasi.',
                                            'success'
                                        ).then(function() {
                                            window.location.href =
                                                "{{ url('randa-kabilasa') }}";
                                        })
                                    } else {
                                        Swal.fire(
                                            'Berhasil!',
                                            'Data berhasil ditolak.',
                                            'success'
                                        ).then(function() {
                                            window.location.href =
                                                "{{ url('randa-kabilasa') }}";
                                        })
                                    }
                                }
                            } else {
                                printErrorMsg(response.error);

                                Swal.fire(
                                    'Terjadi Kesalahan!',
                                    'Periksa kembali data yang anda masukkan',
                                    'error'
                                )
                            }
                        }
                    })
                }
            })
        })
    </script>

    <script>
        $('#m-link-randa-kabilasa').addClass('active');
    </script>
@endpush
