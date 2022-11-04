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

<form id="{{ $form_id }}" action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
    @csrf
    @if (isset($method) && $method == 'PUT')
        @method('PUT')
    @endif
    <div class="row g-4">
        @if ($method == 'POST')
            <div class="col-lg-4 col-md-6">
                @component('dashboard.components.formElements.select',
                    [
                        'label' => 'Akun (Nomor HP Penyuluh)',
                        'name' => 'user_id',
                        'id' => 'user-id',
                        'class' => 'select2',
                        'attribute' => '',
                        'wajib' => '<sup class="text-danger">*</sup>',
                        'button_add' =>
                            '<a href="' .
                            route('user.create') .
                            '" class="badge rounded-pill bg-success text-white shadow-sm float-end"><i class="bi bi-plus-circle"></i> Buat Akun</a>',
                    ])
                    @slot('options')
                        @foreach ($users as $row)
                            <option value="{{ $row->id }}" data-nomor-hp="{{ $row->nomor_hp }}">{{ $row->nomor_hp }}
                            </option>
                        @endforeach
                    @endslot
                @endcomponent
            </div>
        @endif
        <div class="col-lg-4 col-md-6">
            @component('dashboard.components.formElements.input',
                [
                    'label' => 'Nomor Induk Kependudukan (NIK)',
                    'type' => 'text',
                    'id' => 'nik',
                    'name' => 'nik',
                    'class' => 'angka',
                    'value' => $penyuluh->nik ?? null,
                    'wajib' => '<sup class="text-danger">*</sup>',
                ])
            @endcomponent
        </div>
        <div class="col-lg-4 col-md-6">
            @component('dashboard.components.formElements.input',
                [
                    'label' => 'Nama Lengkap',
                    'type' => 'text',
                    'id' => 'nama-lengkap',
                    'name' => 'nama_lengkap',
                    'class' => '',
                    'value' => $penyuluh->nama_lengkap ?? null,
                    'wajib' => '<sup class="text-danger">*</sup>',
                ])
            @endcomponent
        </div>
        <div class="col-lg-4 col-md-6">
            <label for="" class="mb-1">Jenis Kelamin <sup class="text-danger">*</sup></label>
            <div class="d-flex flex-row">
                <div class="p-2">
                    @component('dashboard.components.formElements.radio',
                        [
                            'id' => 'jenis-kelamin-laki-laki',
                            'name' => 'jenis_kelamin',
                            'value' => 'LAKI-LAKI',
                            'label' => 'LAKI-LAKI',
                            'checked' => isset($penyuluh) && $penyuluh->jenis_kelamin == 'LAKI-LAKI' ? 'checked' : '',
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
                            'checked' => isset($penyuluh) && $penyuluh->jenis_kelamin == 'PEREMPUAN' ? 'checked' : '',
                        ])
                    @endcomponent
                </div>
            </div>
            <span class="text-danger error-text jenis_kelamin-error"></span>
        </div>
        <div class="col-lg-4 col-md-6">
            @component('dashboard.components.formElements.input',
                [
                    'label' => 'Tempat Lahir',
                    'type' => 'text',
                    'id' => 'tempat-lahir',
                    'name' => 'tempat_lahir',
                    'class' => '',
                    'value' => $penyuluh->tempat_lahir ?? null,
                    'wajib' => '<sup class="text-danger">*</sup>',
                ])
            @endcomponent
        </div>
        <div class="col-lg-4 col-md-6">
            @component('dashboard.components.formElements.input',
                [
                    'label' => 'Tanggal Lahir',
                    'type' => 'text',
                    'id' => 'tanggal-lahir',
                    'name' => 'tanggal_lahir',
                    'class' => 'tanggal',
                    'placeholder' => 'dd-mm-yyyy',
                    'value' => $penyuluh->tanggal_lahir ?? null,
                    'wajib' => '<sup class="text-danger">*</sup>',
                ])
            @endcomponent
        </div>
        <div class="col-lg-4 col-md-6">
            @component('dashboard.components.formElements.select',
                [
                    'label' => 'Agama',
                    'name' => 'agama',
                    'id' => 'agama',
                    'class' => 'select2 agama',
                    'attribute' => '',
                    'wajib' => '<sup class="text-danger">*</sup>',
                ])
                @slot('options')
                    @foreach ($agama as $row)
                        <option value="{{ $row->id }}"
                            {{ isset($penyuluh) && $row->id == $penyuluh->agama_id ? 'selected' : '' }}>{{ $row->agama }}
                        </option>
                    @endforeach
                @endslot
            @endcomponent
        </div>
        <div class="col-lg-4 col-md-6">
            @component('dashboard.components.formElements.input',
                [
                    'label' => '7 Angka Terakhir STR / Tanggal Lahir',
                    'type' => 'text',
                    'id' => 'tujuh-angka-terakhir-str',
                    'name' => 'tujuh_angka_terakhir_str',
                    'class' => 'angka',
                    'value' => $penyuluh->tujuh_angka_terakhir_str ?? null,
                    'wajib' => '<sup class="text-danger">*</sup>',
                ])
            @endcomponent
        </div>
        <div class="col-lg-4 col-md-6">
            @component('dashboard.components.formElements.input',
                [
                    'label' => 'Nomor HP',
                    'type' => 'text',
                    'id' => 'nomor-hp',
                    'name' => 'nomor_hp',
                    'class' => 'angka',
                    'value' => $penyuluh->nomor_hp ?? null,
                    'wajib' => '<sup class="text-danger">*</sup>',
                ])
            @endcomponent
        </div>
        <div class="col-lg-4 col-md-6">
            @component('dashboard.components.formElements.input',
                [
                    'label' => 'Email',
                    'type' => 'text',
                    'id' => 'email',
                    'name' => 'email',
                    'class' => '',
                    'value' => $penyuluh->email ?? null,
                    // 'wajib' => '<sup class="text-danger">*</sup>',
                ])
            @endcomponent
        </div>
        <div class="col-lg-4 col-md-6">
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
                            {{ isset($penyuluh) && $prov->id == $penyuluh->provinsi_id ? 'selected' : '' }}>
                            {{ $prov->nama }}</option>
                    @endforeach
                @endslot
            @endcomponent
        </div>
        <div class="col-lg-4 col-md-6">
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
                    @if ($method == 'PUT')
                        @foreach ($kabupatenKota as $kab)
                            <option value="{{ $kab->id }}"
                                {{ isset($penyuluh) && $kab->id == $penyuluh->kabupaten_kota_id ? 'selected' : '' }}>
                                {{ $kab->nama }}</option>
                        @endforeach
                    @endif
                @endslot
            @endcomponent
        </div>
        <div class="col-lg-4 col-md-6">
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
                    @if ($method == 'PUT')
                        @foreach ($kecamatan as $kec)
                            <option value="{{ $kec->id }}"
                                {{ isset($penyuluh) && $kec->id == $penyuluh->kecamatan_id ? 'selected' : '' }}>
                                {{ $kec->nama }}</option>
                        @endforeach
                    @endif
                @endslot
            @endcomponent
        </div>
        <div class="col-lg-4 col-md-6">
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
                    @if ($method == 'PUT')
                        @foreach ($desaKelurahan as $des)
                            <option value="{{ $des->id }}"
                                {{ isset($penyuluh) && $des->id == $penyuluh->desa_kelurahan_id ? 'selected' : '' }}>
                                {{ $des->nama }}</option>
                        @endforeach
                    @endif
                @endslot
            @endcomponent
        </div>
        <div class="col-lg-4 col-md-6">
            @component('dashboard.components.formElements.input',
                [
                    'label' => 'Alamat',
                    'type' => 'text',
                    'id' => 'alamat',
                    'name' => 'alamat',
                    'class' => '',
                    'value' => $penyuluh->alamat ?? null,
                    'wajib' => '<sup class="text-danger">*</sup>',
                ])
            @endcomponent
        </div>
        <div class="col-lg-4 col-md-6">
            <label class="col-md-3 col-sm-4 col-form-label">Foto Profil</label>
            <div class="col-md-9 col-sm-8">
                <div class="image-input avatar xxl rounded-4"
                    style="background-image: url({{ isset($penyuluh) && $penyuluh->foto_profil != null ? Storage::url('upload/foto_profil/penyuluh/' . $penyuluh->foto_profil) : asset('assets/dashboard/images/avatar.png') }});">
                    <div class="avatar-wrapper rounded-4"
                        style="background-image: url({{ isset($penyuluh) && $penyuluh->foto_profil != null ? Storage::url('upload/foto_profil/penyuluh/' . $penyuluh->foto_profil) : asset('assets/dashboard/images/avatar.png') }});">
                    </div>
                    <div class="file-input"
                        style="background: var(--card-color); text-align: center; height: 24px; width: 24px; line-height: 24px; border-radius: 24px; background-position: center !important;">
                        <input type="file" class="form-control" name="foto_profil" id="foto-profil"
                            style="z-index: 999999" value="" accept="image/*">
                        <label for="file-input2" class="fa fa-pencil shadow"></label>
                    </div>
                </div>
            </div>
            <span class="text-danger error-text foto_profil-error"></span>
        </div>
        <div class="col-12 text-end">
            @component('dashboard.components.buttons.submit',
                [
                    'id' => 'proses-pertumbuhan-anak',
                    'type' => 'submit',
                    'class' => 'text-white text-uppercase',
                    'label' => 'Simpan',
                ])
            @endcomponent
        </div>
    </div>
</form>


@push('script')
    <script>
        if ('{{ $method }}' == 'POST') {
            $('#kabupaten-kota').attr('disabled', true)
            $('#kecamatan').attr('disabled', true)
            $('#desa-kelurahan').attr('disabled', true)
        }


        $(document).on('change', '.provinsi', function() {
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

        $(document).on('change', '.kabupaten-kota', function() {
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

        $(document).on('change', '.kecamatan', function() {
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

        $('#user-id').change(function() {
            $('#nomor-hp').val($('#user-id').find(':selected').data('nomor-hp'))
        })

        $('#{{ $form_id }}').submit(function(e) {
            e.preventDefault();
            if ('{{ $method }}' == 'POST') {
                var title = 'Simpan Data?'
                var textConfirm = 'Apakah anda yakin ingin menyimpan data ini?'
                var confirmButtonText = 'Ya, Simpan Data'
            } else {
                var title = 'Perbarui Data?'
                var textConfirm = 'Apakah anda yakin ingin memperbarui data ini?'
                var confirmButtonText = 'Ya, Perbarui'
            }
            Swal.fire({
                icon: 'question',
                title: title,
                text: textConfirm,
                showCancelButton: true,
                confirmButtonText: confirmButtonText,
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData(this);
                    var user_id = $('#user-id').val()
                    $('.error-text').text('');
                    $.ajax({
                        type: "POST",
                        url: "{{ $action }}",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            $("#overlay").fadeOut(100);
                            console.log(data)
                            if ($.isEmptyObject(data.error)) {
                                if ('{{ $method }}' == 'POST') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: 'Data penyuluh berhasil ditambahkan, selanjutnya tentukan lokasi tugas penyuluh',
                                    }).then((result) => {
                                        window.location.href =
                                            "{{ url('lokasi-tugas-penyuluh') }}/" +
                                            data.new_penyuluh_id;
                                    })
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: 'Data penyuluh berhasil diperbarui',
                                    }).then((result) => {
                                        window.location.href = "{{ $back_url }}";
                                    })
                                }

                            } else {
                                Swal.fire(
                                    'Terjadi Kesalahan!',
                                    'Periksa kembali data yang anda masukkan',
                                    'error'
                                )
                                printErrorMsg(data.error);
                            }
                        },
                        error: function(data) {
                            alert(data.responseJSON.message)
                        },

                    });
                    const printErrorMsg = (msg) => {
                        $.each(msg, function(key, value) {
                            $('.' + key + '-error').text(value);
                        });
                    }
                }

            })
        })
    </script>
@endpush
