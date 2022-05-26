@push('style')
    <style>
        input {
            text-transform: uppercase;
        }

        #email {
            text-transform: lowercase !important;
        }

    </style>
@endpush

<div class="row g-3">
    <div class="col-lg-6 col-md-6">
        @component('dashboard.components.formElements.input',
            [
                'label' => 'Nama Lengkap',
                'type' => 'text',
                'id' => 'nama-lengkap',
                'name' => 'nama_lengkap',
                'class' => 'ubah-profil',
                'value' => $profil->nama_lengkap ?? null,
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
        @endcomponent
    </div>
    <div class="col-lg-6 col-md-6">
        @component('dashboard.components.formElements.input',
            [
                'label' => 'NIK',
                'type' => 'text',
                'id' => 'nik',
                'name' => 'nik',
                'class' => 'angka ubah-profil',
                'value' => $profil->nik ?? null,
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
        @endcomponent
    </div>
    <div class="col-lg-6 col-md-6">
        <label for="" class="mb-1">Jenis Kelamin <sup class="text-danger">*</sup></label>
        <div class="d-flex flex-row">
            <div class="p-2">
                @component('dashboard.components.formElements.radio',
                    [
                        'id' => 'jenis-kelamin-laki-laki',
                        'name' => 'jenis_kelamin',
                        'value' => 'LAKI-LAKI',
                        'label' => 'LAKI-LAKI',
                        'class' => 'ubah-profil',
                        'checked' => isset($profil) && $profil->jenis_kelamin == 'LAKI-LAKI' ? 'checked' : '',
                    ])
                @endcomponent
            </div>
            <div class="p-2">
                @component('dashboard.components.formElements.radio',
                    [
                        'id' => 'jenis-kelamin-perempuan',
                        'name' => 'jenis_kelamin',
                        'value' => 'PEREMPUAN',
                        'label' => 'PEREMPUAN',
                        'class' => 'ubah-profil',
                        'checked' => isset($profil) && $profil->jenis_kelamin == 'PEREMPUAN' ? 'checked' : '',
                    ])
                @endcomponent
            </div>
        </div>
        <span class="text-danger error-text jenis_kelamin-error"></span>
    </div>
    <div class="col-lg-6 col-md-6">
        @component('dashboard.components.formElements.input',
            [
                'label' => 'Tempat Lahir',
                'type' => 'text',
                'id' => 'tempat-lahir',
                'name' => 'tempat_lahir',
                'class' => 'ubah-profil',
                'value' => $profil->tempat_lahir ?? null,
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
        @endcomponent
    </div>
    <div class="col-lg-6 col-md-6">
        @component('dashboard.components.formElements.input',
            [
                'label' => 'Tanggal Lahir',
                'type' => 'text',
                'id' => 'tanggal-lahir',
                'name' => 'tanggal_lahir',
                'class' => 'tanggal ubah-profil',
                'placeholder' => 'dd-mm-yyyy',
                'value' => isset($profil) ? Carbon\Carbon::parse($profil->tanggal_lahir)->isoFormat('DD-MM-YYYY') : '',
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
        @endcomponent
    </div>
    <div class="col-lg-6 col-md-6">
        @component('dashboard.components.formElements.select',
            [
                'label' => 'Agama',
                'name' => 'agama',
                'id' => 'agama',
                'class' => 'select2 agama ubah-profil',
                'attribute' => '',
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
            @slot('options')
                @foreach ($agama as $row)
                    <option value="{{ $row->id }}"
                        {{ isset($profil) && $row->id == $profil->agama_id ? 'selected' : '' }}>
                        {{ $row->agama }}</option>
                @endforeach
            @endslot
        @endcomponent
    </div>
    <div class="col-lg-6 col-md-6">
        @component('dashboard.components.formElements.select',
            [
                'label' => 'Pendidikan',
                'name' => 'pendidikan',
                'id' => 'pendidikan',
                'class' => 'select2 pendidikan ubah-profil',
                'attribute' => '',
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
            @slot('options')
                @foreach ($pendidikan as $row)
                    <option value="{{ $row->id }}"
                        {{ isset($profil) && $row->id == $profil->pendidikan_id ? 'selected' : '' }}>
                        {{ $row->pendidikan }}</option>
                @endforeach
            @endslot
        @endcomponent
    </div>
    <div class="col-lg-6 col-md-6">
        @component('dashboard.components.formElements.select',
            [
                'label' => 'Jenis Pekerjaan',
                'name' => 'pekerjaan',
                'id' => 'pekerjaan',
                'class' => 'select2 pekerjaan ubah-profil',
                'attribute' => '',
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
            @slot('options')
                @foreach ($pekerjaan as $row)
                    <option value="{{ $row->id }}"
                        {{ isset($profil) && $row->id == $profil->jenis_pekerjaan_id ? 'selected' : '' }}>
                        {{ $row->pekerjaan }}</option>
                @endforeach
            @endslot
        @endcomponent
    </div>
    <div class="col-lg-6 col-md-6">
        @component('dashboard.components.formElements.select',
            [
                'label' => 'Golongan Darah',
                'name' => 'golongan_darah',
                'id' => 'golongan-darah',
                'class' => 'select2 golongan-darah ubah-profil',
                'attribute' => '',
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
            @slot('options')
                @foreach ($golonganDarah as $row)
                    <option value="{{ $row->id }}"
                        {{ isset($profil) && $row->id == $profil->golongan_darah_id ? 'selected' : '' }}>
                        {{ $row->golongan_darah }}</option>
                @endforeach
            @endslot
        @endcomponent
    </div>
    <div class="col-lg-6 col-md-6">
        @component('dashboard.components.formElements.select',
            [
                'label' => 'Status Perkawinan',
                'name' => 'status_perkawinan',
                'id' => 'status-perkawinan',
                'class' => 'select2 status-perkawinan ubah-profil',
                'attribute' => '',
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
            @slot('options')
                @foreach ($statusPerkawinan as $row)
                    <option value="{{ $row->id }}"
                        {{ isset($profil) && $row->id == $profil->status_perkawinan_id ? 'selected' : '' }}>
                        {{ $row->status_perkawinan }}</option>
                @endforeach
            @endslot
        @endcomponent
    </div>
    <div class="col-lg-6 col-md-6">
        @component('dashboard.components.formElements.input',
            [
                'label' => 'Tanggal Perkawinan',
                'type' => 'text',
                'id' => 'tanggal-perkawinan',
                'name' => 'tanggal_perkawinan',
                'class' => 'tanggal ubah-profil',
                'attribute' => 'disabled',
                'placeholder' => 'dd-mm-yyyy',
                'value' => isset($profil) ? Carbon\Carbon::parse($profil->tanggal_perkawinan)->isoFormat('DD-MM-YYYY') : null,
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
        @endcomponent
    </div>
    <div class="col-lg-6 col-md-6">
        @component('dashboard.components.formElements.select',
            [
                'label' => 'Status Hubungan Dalam Keluarga',
                'name' => 'status_hubungan',
                'id' => 'status-hubungan',
                'class' => 'select2 status-hubungan ubah-profil',
                'attribute' => 'disabled',
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
            @slot('options')
                @foreach ($statusHubungan as $row)
                    <option value="{{ $row->id }}"
                        {{ isset($profil) && $row->id == $profil->status_hubungan_dalam_keluarga_id ? 'selected' : '' }}>
                        {{ $row->status_hubungan }}</option>
                @endforeach
            @endslot
        @endcomponent
    </div>
    <div class="col-lg-6 col-md-6">
        <label for="" class="mb-1">Kewarganegaraan <sup class="text-danger">*</sup></label>
        <div class="d-flex flex-row">
            <div class="p-2">
                @component('dashboard.components.formElements.radio',
                    [
                        'id' => 'kewarganegaraan-wni',
                        'class' => 'kewarganegaraan ubah-profil',
                        'name' => 'kewarganegaraan',
                        'value' => 'WNI',
                        'label' => 'Warga Negara Indonesia (WNI)',
                        'checked' => isset($profil) && $profil->kewarganegaraan == 'WNI' ? 'checked' : '',
                    ])
                @endcomponent
            </div>
            <div class="p-2">
                @component('dashboard.components.formElements.radio',
                    [
                        'id' => 'kewarganegaraan-wna',
                        'class' => 'kewarganegaraan ubah-profil',
                        'name' => 'kewarganegaraan',
                        'value' => 'WNA',
                        'label' => 'Warga Negara Asing (WNA)',
                        'checked' => isset($profil) && $profil->kewarganegaraan == 'WNA' ? 'checked' : '',
                    ])
                @endcomponent
            </div>
        </div>
        <span class="text-danger error-text jenis_kelamin-error"></span>
    </div>
    <div class="col-lg-3 col-md-3">
        @component('dashboard.components.formElements.input',
            [
                'label' => 'Nomor Paspor',
                'type' => 'text',
                'id' => 'nomor-paspor',
                'name' => 'nomor_paspor',
                'value' => $profil->no_paspor ?? null,
                'class' => 'nomor-paspor ubah-profil',
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
        @endcomponent
    </div>
    <div class="col-lg-3 col-md-3">
        @component('dashboard.components.formElements.input',
            [
                'label' => 'Nomor KITAP',
                'type' => 'text',
                'id' => 'nomor-kitap',
                'name' => 'nomor_kitap',
                'value' => $profil->no_kitap ?? null,
                'class' => 'nomor-kitap ubah-profil',
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
        @endcomponent
    </div>
    <div class="col-lg-6 col-md-6">
        @component('dashboard.components.formElements.input',
            [
                'label' => 'Nama Ayah',
                'type' => 'text',
                'id' => 'ayah',
                'name' => 'ayah',
                'value' => $profil->nama_ayah ?? null,
                'class' => 'ayah ubah-profil',
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
        @endcomponent
    </div>
    <div class="col-lg-6 col-md-6">
        @component('dashboard.components.formElements.input',
            [
                'label' => 'Nama Ibu',
                'type' => 'text',
                'id' => 'ibu',
                'name' => 'ibu',
                'value' => $profil->nama_ibu ?? null,
                'class' => 'ibu ubah-profil',
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
        @endcomponent
    </div>
    <div id="info-ubah-2" class="info-ubah">

    </div>
    <div class="col-lg-6 col-md-6">
        <label class="col-form-label">Foto Profil</label>
        <div class="col-md-9 col-sm-8">
            <div class="image-input foto-profil avatar xxl rounded-4"
                style="background-image: url({{ isset($profil) && $profil->foto_profil != null ? $foto_profil : asset('assets/dashboard/images/avatar.png') }});">
                <div class="avatar-wrapper foto-profil rounded-4"
                    style="background-image: url({{ isset($profil) && $profil->foto_profil != null ? $foto_profil : asset('assets/dashboard/images/avatar.png') }});">
                </div>
                <div class="file-input"
                    style="background: var(--card-color); text-align: center; height: 24px; width: 24px; line-height: 24px; border-radius: 24px; background-position: center !important;">
                    <input type="file" class="form-control pb-3" name="foto_profil" id="foto-profil"
                        style="z-index: 999999" value="" accept="image/*">
                    <label for="file-input2" class="fa fa-pencil shadow"></label>
                </div>
            </div>
        </div>
        <span class="text-danger error-text foto_profil-error"></span>
    </div>
</div>
<div class="card fieldset mt-5 p-4">
    <span class="fieldset-tile bg-white">Domisili</span>
    <div id="info-ubah-1" class="info-ubah">

    </div>
    <div class="row g-3">
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="check-domisili" checked="false">
                <label class="form-check-label" for="flexCheckDefault">Samakan dengan alamat kartu keluarga</label>
            </div>
        </div>
        <div class="col-lg-12 col-md-12">
            @component('dashboard.components.formElements.input',
                [
                    'label' => 'Alamat',
                    'type' => 'text',
                    'id' => 'alamat-domisili',
                    'name' => 'alamat_domisili',
                    'class' => '',
                    'value' => $profil->wilayahDomisili->alamat ?? null,
                    'wajib' => '<sup class="text-danger">*</sup>',
                ])
            @endcomponent
        </div>
        <div class="col-lg-6 col-md-6">
            @component('dashboard.components.formElements.select',
                [
                    'label' => 'Provinsi',
                    'name' => 'provinsi_domisili',
                    'id' => 'provinsi-domisili',
                    'class' => 'select2 provinsi-domisili',
                    'attribute' => '',
                    'wajib' => '<sup class="text-danger">*</sup>',
                ])
                @slot('options')
                    @foreach ($provinsi as $prov)
                        <option value="{{ $prov->id }}"
                            {{ isset($profil->wilayahDomisili) && $prov->id == $profil->wilayahDomisili->provinsi_id ? 'selected' : '' }}>
                            {{ $prov->nama }}</option>
                    @endforeach
                @endslot
            @endcomponent
        </div>
        <div class="col-lg-6 col-md-6">
            @component('dashboard.components.formElements.select',
                [
                    'label' => 'Kabupaten / Kota',
                    'name' => 'kabupaten_kota_domisili',
                    'id' => 'kabupaten-kota-domisili',
                    'class' => 'select2 kabupaten-kota-domisili',
                    'attribute' => '',
                    'wajib' => '<sup class="text-danger">*</sup>',
                ])
                @slot('options')
                    @if ($kabupatenKotaDomisili)
                        @foreach ($kabupatenKotaDomisili as $kab)
                            <option value="{{ $kab->id }}"
                                {{ isset($profil->wilayahDomisili) && $kab->id == $profil->wilayahDomisili->kabupaten_kota_id ? 'selected' : '' }}>
                                {{ $kab->nama }}</option>
                        @endforeach
                    @endif
                @endslot
            @endcomponent
        </div>
        <div class="col-lg-6 col-md-6">
            @component('dashboard.components.formElements.select',
                [
                    'label' => 'Kecamatan',
                    'name' => 'kecamatan_domisili',
                    'id' => 'kecamatan-domisili',
                    'class' => 'select2 kecamatan-domisili',
                    'attribute' => '',
                    'wajib' => '<sup class="text-danger">*</sup>',
                ])
                @slot('options')
                    @if ($kecamatanDomisili)
                        @foreach ($kecamatanDomisili as $kec)
                            <option value="{{ $kec->id }}"
                                {{ isset($profil->wilayahDomisili) && $kec->id == $profil->wilayahDomisili->kecamatan_id ? 'selected' : '' }}>
                                {{ $kec->nama }}</option>
                        @endforeach
                    @endif
                @endslot
            @endcomponent
        </div>
        <div class="col-lg-6 col-md-6">
            @component('dashboard.components.formElements.select',
                [
                    'label' => 'Desa / Kelurahan',
                    'name' => 'desa_kelurahan_domisili',
                    'id' => 'desa-kelurahan-domisili',
                    'class' => 'select2 desa-kelurahan-domisili',
                    'attribute' => '',
                    'wajib' => '<sup class="text-danger">*</sup>',
                ])
                @slot('options')
                    @if ($desaKelurahanDomisili)
                        @foreach ($desaKelurahanDomisili as $des)
                            <option value="{{ $des->id }}"
                                {{ isset($profil->wilayahDomisili) && $des->id == $profil->wilayahDomisili->desa_kelurahan_id ? 'selected' : '' }}>
                                {{ $des->nama }}</option>
                        @endforeach
                    @endif
                @endslot
            @endcomponent
        </div>
        <div class="col-12" id="col-alamat-domisili">
            <label for="formFile" class="form-label">Upload Surat Keterangan Domisili (.pdf / .jpeg / .png)</label>
            <input class="form-control" type="file" id="file-domisili" name="file_domisili"
                accept="image/*, application/pdf">
            @if (isset($profil))
                <small class="text-muted mt-1" style="font-style: italic">Boleh dikosongkan apabila sebelumnya telah
                    mengupload Surat Keterangan Domisili atau tidak melakukan perubahan pada wilayah
                    domisili.</small>
            @endif
            <span class="text-danger d-block error-text file_domisili-error"></span>
        </div>
        <div class="col-12 text-end">
            @component('dashboard.components.buttons.submit',
                [
                    'id' => 'proses-profil',
                    'type' => 'submit',
                    'class' => 'text-white text-uppercase',
                    'label' => $titleSubmit ?? 'Simpan',
                ])
            @endcomponent
        </div>
    </div>
</div>


@push('script')
    <script>
        $(function() {
            inisialisasi()
        })

        var alamatKK = '{{ $alamatKK }}'
        var provinsiKK = '{{ $provinsiKK }}'
        var kabupatenKotaKK = '{{ $kabupatenKotaKK }}'
        var kecamatanKK = '{{ $kecamatanKK }}'
        var desaKelurahanKK = '{{ $desaKelurahanKK }}';

        function inisialisasi() {
            $('#status-hubungan').attr('disabled', true);

            // if ('{{ $profil->status_hubungan_dalam_keluarga_id }}' == 1) {
            //     $('#status-hubungan').attr('disabled', true);
            // } else {
            //     $('#status-hubungan').attr('disabled', false);
            // }

            $('#check-domisili').prop('checked', false)
            if ($('#desa-kelurahan-domisili').val() != '') {
                if ($('#desa-kelurahan-domisili').val() == desaKelurahanKK) {
                    $('#check-domisili').prop('checked', true)
                    $('#col-alamat-domisili').addClass('d-none')
                }
            }

            if ($('{{ $profil }}' != null)) {
                $('.wajib-kata-sandi').addClass('d-none')

            }

            $('.kewarganegaraan').click(function() {
                if (this.value == 'WNI') {
                    $('#nomor-paspor').val('-');
                    $('#nomor-kitap').val('-');
                } else {
                    $('#nomor-paspor').val('');
                    $('#nomor-kitap').val('');
                }
            });



            $('#status-perkawinan').on('change', function() {
                if ($('#status-perkawinan').val() != 1) {
                    $('#tanggal-perkawinan').prop('disabled', false);
                } else {
                    $('#tanggal-perkawinan').prop('disabled', true);
                    $('#tanggal-perkawinan').val('');
                }
            });

            $('#check-domisili').click(function() {
                if ($(this).is(':checked')) {
                    if (alamatKK == '' || provinsiKK == '' || kabupatenKotaKK == '' || kecamatanKK ==
                        '' ||
                        desaKelurahanKK == '') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Alamat Kartu Keluarga Belum Lengkap',
                            text: 'Silahkan lengkapi alamat kartu keluarga terlebih dahulu, untuk menyamakannya dengan alamat domisili.',
                        })
                        $('#check-domisili').prop('checked', false)
                    } else {
                        $('#col-alamat-domisili').addClass('d-none')
                        $('#alamat-domisili').val(alamatKK)
                        $('#provinsi-domisili').val(provinsiKK)
                        $('#provinsi-domisili').trigger('change')
                        if ($('#provinsi-domisili').val() != provinsiKK) {
                            $('#check-domisili').prop('checked', false)
                            $('#col-alamat-domisili').removeClass('d-none')
                        }
                    }
                } else {
                    $('#col-alamat-domisili').removeClass('d-none')
                }
            })

            //////// Wilayah Domisilli
            if ('{{ isset($profil) }}') {
                $('#kabupaten-kota-domisili').attr('disabled', false)
                $('#kecamatan-domisili').attr('disabled', false)
                $('#desa-kelurahan-domisili').attr('disabled', false)
            } else {
                $('#kabupaten-kota-domisili').attr('disabled', true)
                $('#kecamatan-domisili').attr('disabled', true)
                $('#desa-kelurahan-domisili').attr('disabled', true)

            }

            // $('#alamat-domisili').on('keyup', function(){
            //     if($('#alamat-domisili').val() != alamatKK){
            //         $('#check-domisili').prop('checked', false)
            //         $('#col-alamat-domisili').removeClass('d-none')
            //     } 
            // });
        }

        $(document).on('change', '#provinsi-domisili', function() {
            if ($('#provinsi-domisili').val() != provinsiKK) {
                $('#check-domisili').prop('checked', false)
                $('#col-alamat-domisili').removeClass('d-none')
            }

            $('#kecamatan-domisili').html('')
            $('#kecamatan-domisili').attr('disabled', true)

            $('#desa-kelurahan-domisili').html('')
            $('#desa-kelurahan-domisili').attr('disabled', true)

            $('#kabupaten-kota-domisili').html('');
            $('#kabupaten-kota-domisili').attr('disabled', false)
            $('#kabupaten-kota-domisili').append('<option value="">- Pilih Salah Satu -</option>')
            $.get("{{ route('listKabupatenKota') }}", {
                idProvinsi: $("#provinsi-domisili").val()
            }, function(result) {
                $.each(result, function(key, val) {
                    if (val.id == kabupatenKotaKK) {
                        if ($('#check-domisili').is(':checked')) {
                            $('#kabupaten-kota-domisili').append('<option value="' + val
                                .id +
                                '" selected>' + val.nama + '</option>')
                            $('#kabupaten-kota-domisili').trigger('change')
                        } else {
                            $('#kabupaten-kota-domisili').append(
                                `<option value="${val.id}">${val.nama}</option>`);
                        }
                    } else {
                        $('#kabupaten-kota-domisili').append(
                            `<option value="${val.id}">${val.nama}</option>`);
                    }
                })
            });
        })

        $(document).on('change', '#kabupaten-kota-domisili', function() {
            if ($('#kabupaten-kota-domisili').val() != kabupatenKotaKK) {
                $('#check-domisili').prop('checked', false)
                $('#col-alamat-domisili').removeClass('d-none')
            }
            $('#desa-kelurahan-domisili').html('')
            $('#desa-kelurahan-domisili').attr('disabled', true)

            $('#kecamatan-domisili').html('')
            $('#kecamatan-domisili').attr('disabled', false)
            $('#kecamatan-domisili').append('<option value="">- Pilih Salah Satu -</option>')
            $.get("{{ route('listKecamatan') }}", {
                idKabupatenKota: $("#kabupaten-kota-domisili").val()
            }, function(result) {
                $.each(result, function(key, val) {
                    if (val.id == kecamatanKK) {
                        if ($('#check-domisili').is(':checked')) {
                            $('#kecamatan-domisili').append(
                                `<option value="${val.id}" selected>${val.nama}</option>`
                            );
                            $('#kecamatan-domisili').trigger('change')
                        } else {
                            $('#kecamatan-domisili').append(
                                `<option value="${val.id}">${val.nama}</option>`);
                        }
                    } else {
                        $('#kecamatan-domisili').append(
                            `<option value="${val.id}">${val.nama}</option>`);
                    }
                })
            });
        })

        $(document).on('change', '#kecamatan-domisili', function() {
            if ($('#kecamatan-domisili').val() != kecamatanKK) {
                $('#check-domisili').prop('checked', false)
                $('#col-alamat-domisili').removeClass('d-none')
            }
            $('#desa-kelurahan-domisili').html('');
            $('#desa-kelurahan-domisili').attr('disabled', false)
            $('#desa-kelurahan-domisili').append('<option value="">- Pilih Salah Satu -</option>')
            $.get("{{ route('listDesaKelurahan') }}", {
                idKecamatan: $("#kecamatan-domisili").val()
            }, function(result) {
                $.each(result, function(key, val) {
                    if (val.id == desaKelurahanKK) {
                        if ($('#check-domisili').is(':checked')) {
                            $('#desa-kelurahan-domisili').append(
                                `<option value="${val.id}" selected>${val.nama}</option>`
                            );
                            $('#desa-kelurahan-domisili').trigger('change')
                        } else {
                            $('#desa-kelurahan-domisili').append(
                                `<option value="${val.id}">${val.nama}</option>`);
                        }

                    } else {
                        $('#desa-kelurahan-domisili').append(
                            `<option value="${val.id}">${val.nama}</option>`);
                    }
                })
            });
        })

        $(document).on('change', '#desa-kelurahan-domisili', function() {
            $.ajax({
                type: "GET",
                url: "{{ url('cek-bidan-domisili') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    desaKelurahanID: $('#desa-kelurahan-domisili').val()
                },
                success: function(response) {
                    if (response != 1) {
                        Swal.fire(
                            'Tidak ditemukan bidan',
                            'Tidak ditemukan bidan untuk desa/kelurahan domisili yang anda pilih. Silahkan pilih desa/kelurahan domisili lain.',
                            'error'
                        ).then(function() {
                            $('#profil').trigger('change');

                            $('#kecamatan-domisili').trigger('change')
                            $('#check-domisili').prop('checked', false)
                            $('#col-alamat-domisili').removeClass('d-none')
                            $('#nama-bidan').attr('disabled', true)

                        })
                    }
                }
            })

            if ($('#desa-kelurahan-domisili').val() != desaKelurahanKK) {
                $('#check-domisili').prop('checked', false)
                $('#col-alamat-domisili').removeClass('d-none')
            } else {
                $('#check-domisili').prop('checked', true)
                $('#col-alamat-domisili').addClass('d-none')
            }

        })
    </script>
@endpush
