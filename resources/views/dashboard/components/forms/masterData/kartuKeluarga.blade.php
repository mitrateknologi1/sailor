<div class="row g-3 py-1">
    <div class="col-lg-6 col-md-6">
        @component('dashboard.components.formElements.input',
            [
                'label' => 'Nomor Kartu Keluarga',
                'type' => 'text',
                'id' => 'nomor-kk',
                'name' => 'nomor_kk',
                'class' => 'angka',
                'value' => $kartuKeluarga->nomor_kk ?? null,
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
        @endcomponent
    </div>
    <div class="col-lg-6 col-md-6">
        @component('dashboard.components.formElements.input',
            [
                'label' => 'Nama Kepala Keluarga',
                'type' => 'text',
                'id' => 'nama-kepala-keluarga',
                'name' => 'nama_kepala_keluarga',
                'class' => '',
                'value' => $kartuKeluarga->nama_kepala_keluarga ?? null,
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
        @endcomponent
    </div>
    <div class="col-lg-6 col-md-6">
        @component('dashboard.components.formElements.input',
            [
                'label' => 'Alamat',
                'type' => 'text',
                'id' => 'alamat',
                'name' => 'alamat',
                'class' => '',
                'value' => $kartuKeluarga->alamat ?? null,
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
        @endcomponent
    </div>
    <div class="col-lg-6 col-md-6">
        <div class="row">
            <div class="col-3">
                @component('dashboard.components.formElements.input',
                    [
                        'label' => 'RT',
                        'type' => 'text',
                        'id' => 'rt',
                        'name' => 'rt',
                        'class' => 'angka',
                        'value' => $kartuKeluarga->rt ?? null,
                        // 'wajib' => '<sup class="text-danger">*</sup>',
                    ])
                @endcomponent
            </div>
            <div class="col-3">
                @component('dashboard.components.formElements.input',
                    [
                        'label' => 'RW',
                        'type' => 'text',
                        'id' => 'rw',
                        'name' => 'rw',
                        'class' => 'angka',
                        'value' => $kartuKeluarga->rw ?? null,
                        // 'wajib' => '<sup class="text-danger">*</sup>',
                    ])
                @endcomponent
            </div>
            <div class="col-6">
                @component('dashboard.components.formElements.input',
                    [
                        'label' => 'Kode POS',
                        'type' => 'text',
                        'id' => 'kode-pos',
                        'name' => 'kode_pos',
                        'class' => 'angka',
                        'value' => $kartuKeluarga->kode_pos ?? null,
                        // 'wajib' => '<sup class="text-danger">*</sup>',
                    ])
                @endcomponent
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6">
        @component('dashboard.components.formElements.select',
            [
                'label' => 'Provinsi',
                'name' => 'provinsi',
                'id' => 'provinsi',
                'class' => 'select2 provinsi',
                'attribute' => '',
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
            @slot('options')
                @foreach ($provinsi->where('id', 72) as $prov)
                    <option value="{{ $prov->id }}"
                        {{ isset($kartuKeluarga) && $prov->id == $kartuKeluarga->provinsi_id ? 'selected' : '' }}>
                        {{ $prov->nama }}</option>
                @endforeach
            @endslot
        @endcomponent
    </div>
    <div class="col-lg-6 col-md-6">
        @component('dashboard.components.formElements.select',
            [
                'label' => 'Kabupaten / Kota',
                'name' => 'kabupaten_kota',
                'id' => 'kabupaten-kota',
                'class' => 'select2 kabupaten-kota',
                'attribute' => '',
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
            @slot('options')
                @if ($kartuKeluarga)
                    @foreach ($kabupatenKota as $kab)
                        <option value="{{ $kab->id }}"
                            {{ isset($kartuKeluarga) && $kab->id == $kartuKeluarga->kabupaten_kota_id ? 'selected' : '' }}>
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
                'name' => 'kecamatan',
                'id' => 'kecamatan',
                'class' => 'select2 kecamatan',
                'attribute' => '',
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
            @slot('options')
                @if ($kartuKeluarga)
                    @foreach ($kecamatan as $kec)
                        <option value="{{ $kec->id }}"
                            {{ isset($kartuKeluarga) && $kec->id == $kartuKeluarga->kecamatan_id ? 'selected' : '' }}>
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
                'name' => 'desa_kelurahan',
                'id' => 'desa-kelurahan',
                'class' => 'select2 desa-kelurahan',
                'attribute' => '',
                'wajib' => '<sup class="text-danger">*</sup>',
            ])
            @slot('options')
                @if ($kartuKeluarga)
                    @foreach ($desaKelurahan as $des)
                        <option value="{{ $des->id }}"
                            {{ isset($kartuKeluarga) && $des->id == $kartuKeluarga->desa_kelurahan_id ? 'selected' : '' }}>
                            {{ $des->nama }}</option>
                    @endforeach
                @endif
            @endslot
        @endcomponent
    </div>

    <div class="col-12">
        <label for="formFile" class="form-label">Upload Kartu Keluarga (.pdf / .jpeg / .png)</label>
        <input class="form-control" name="file_kartu_keluarga" type="file" id="file-kartu-keluarga"
            accept="image/*, application/pdf">
        @if ($kartuKeluarga)
            <small class="text-muted mt-1" style="font-style: italic">Boleh dikosongkan apabila sebelumnya telah
                mengupload Kartu Keluarga dan tidak ingin mengubahnya</small>
        @endif
        <span class="text-danger error-text d-block file_kartu_keluarga-error"></span>
    </div>
</div>

@push('script')
    <script>
        var desaKelurahanKK = '{{ $desaKelurahanKK ?? null }}'
        var kecamatanKK = '{{ $kecamatanKK ?? null }}'
        var kabupatenKotaKK = '{{ $kabupatenKotaKK ?? null }}'
        var provinsiKK = '{{ $provinsiKK ?? null }}'
        var alamatKK = '{{ $alamatKK ?? null }}'

        if ('{{ isset($kartuKeluarga) }}') {
            $('#kabupaten-kota').attr('disabled', false)
            $('#kecamatan').attr('disabled', false)
            $('#desa-kelurahan').attr('disabled', false)
        } else {
            $('#kabupaten-kota').attr('disabled', true)
            $('#kecamatan').attr('disabled', true)
            $('#desa-kelurahan').attr('disabled', true)
        }

        $(document).on('keyup', '#alamat', function() {
            $('#check-domisili').prop('checked', false)
            $('#col-alamat-domisili').removeClass('d-none')
            alamatKK = $(this).val()
        })

        $(document).on('change', '#provinsi', function() {
            provinsiKK = $(this).val()
            $('#check-domisili').prop('checked', false)
            $('#col-alamat-domisili').removeClass('d-none')

            $('#kecamatan').html('')
            $('#kecamatan').attr('disabled', true)

            $('#desa-kelurahan').html('')
            $('#desa-kelurahan').attr('disabled', true)

            $('#kabupaten-kota').html('');
            $('#kabupaten-kota').attr('disabled', false)
            $('#kabupaten-kota').append('<option value="">- Pilih Salah Satu -</option>')
            $.get("{{ route('listKabupatenKota') }}", {
                idProvinsi: $("#provinsi").val()
            }, function(result) {
                $.each(result, function(key, val) {

                    $('#kabupaten-kota').append(`<option value="${val.id}">${val.nama}</option>`);
                })
            });
        })

        $(document).on('change', '#kabupaten-kota', function() {
            kabupatenKotaKK = $(this).val()
            $('#check-domisili').prop('checked', false)
            $('#col-alamat-domisili').removeClass('d-none')

            $('#desa-kelurahan').html('')
            $('#desa-kelurahan').attr('disabled', true)

            $('#kecamatan').html('')
            $('#kecamatan').attr('disabled', false)
            $('#kecamatan').append('<option value="">- Pilih Salah Satu -</option>')
            $.get("{{ route('listKecamatan') }}", {
                idKabupatenKota: $("#kabupaten-kota").val()
            }, function(result) {
                $.each(result, function(key, val) {
                    $('#kecamatan').append(`<option value="${val.id}">${val.nama}</option>`);
                })
            });
        })

        $(document).on('change', '#kecamatan', function() {
            kecamatanKK = $(this).val()
            $('#check-domisili').prop('checked', false)
            $('#col-alamat-domisili').removeClass('d-none')

            $('#desa-kelurahan').html('');
            $('#desa-kelurahan').attr('disabled', false)
            $('#desa-kelurahan').append('<option value="">- Pilih Salah Satu -</option>')
            $.get("{{ route('listDesaKelurahan') }}", {
                idKecamatan: $("#kecamatan").val()
            }, function(result) {
                $.each(result, function(key, val) {
                    $('#desa-kelurahan').append(`<option value="${val.id}">${val.nama}</option>`);
                })
            });
        })

        $(document).on('change', '#desa-kelurahan', function() {
            desaKelurahanKK = $(this).val()
            $('#check-domisili').prop('checked', false)
            $('#col-alamat-domisili').removeClass('d-none')

        })
    </script>
@endpush
