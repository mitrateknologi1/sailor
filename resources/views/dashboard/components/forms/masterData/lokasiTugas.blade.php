<form id="{{ $form_id }}" action="#" method="POST" autocomplete="off">
    @csrf
    @method('PUT')
    <div class="listLokasi" id="listLokasi">
        @foreach ($user->lokasiTugas as $row)
            <div class="card fieldset border border-secondary mt-4" id="daftarLokasi{{ $loop->iteration }}">
                <span class="fieldset-tile text-secondary bg-white ml-6">Lokasi Tugas</span>
                <div class="row g-3 mb-3">
                    <div class="col-lg-3 col-md-6">
                        {{-- Provinsi --}}
                        @component('dashboard.components.formElements.select',
                            [
                                'label' => 'Provinsi',
                                'name' => 'provinsi[]',
                                'id' => 'provinsi' . $loop->iteration,
                                'class' => 'select2 provinsi',
                                'attribute' => 'data-iteration = ' . $loop->iteration . ' data-kabupaten-kota = ' . $row->kabupaten_kota_id,
                                'wajib' => '<sup class="text-danger">*</sup>',
                            ])
                            @slot('options')
                                @foreach ($provinsi->where('id', 72) as $prov)
                                    <option value="{{ $prov->id }}" {{ $prov->id == $row->provinsi_id ? 'selected' : '' }}>
                                        {{ $prov->nama }}</option>
                                @endforeach
                            @endslot
                        @endcomponent
                    </div>
                    <div class="col-lg-3 col-md-6">
                        {{-- Kabupaten / Kota --}}
                        @component('dashboard.components.formElements.select',
                            [
                                'label' => 'Kabupaten / Kota',
                                'name' => 'kabupaten_kota[]',
                                'id' => 'kabupaten-kota' . $loop->iteration,
                                'class' => 'select2 kabupaten-kota',
                                'attribute' => 'data-iteration = ' . $loop->iteration,
                                'wajib' => '<sup class="text-danger">*</sup>',
                            ])
                            @slot('options')
                                @foreach ($kabupatenKota as $kab)
                                    <option value="{{ $kab->id }}"
                                        {{ $kab->id == $row->kabupaten_kota_id ? 'selected' : '' }}>{{ $kab->nama }}
                                    </option>
                                @endforeach
                            @endslot
                        @endcomponent
                    </div>
                    <div class="col-lg-3 col-md-6">
                        {{-- Kecamatan --}}
                        @component('dashboard.components.formElements.select',
                            [
                                'label' => 'Kecamatan',
                                'name' => 'kecamatan[]',
                                'id' => 'kecamatan' . $loop->iteration,
                                'class' => 'select2 kecamatan',
                                'attribute' => 'data-iteration = ' . $loop->iteration,
                                'wajib' => '<sup class="text-danger">*</sup>',
                            ])
                            @slot('options')
                                @foreach ($kecamatan as $kec)
                                    <option value="{{ $kec->id }}" {{ $kec->id == $row->kecamatan_id ? 'selected' : '' }}>
                                        {{ $kec->nama }}</option>
                                @endforeach
                            @endslot
                        @endcomponent
                    </div>
                    <div class="col-lg-3 col-md-6">
                        {{-- Desa / Kelurahan --}}
                        @component('dashboard.components.formElements.select',
                            [
                                'label' => 'Desa / Kelurahan',
                                'name' => 'desa_kelurahan[]',
                                'id' => 'desa-kelurahan' . $loop->iteration,
                                'class' => 'select2 desa-kelurahan',
                                'attribute' => 'data-iteration = ' . $loop->iteration,
                                'wajib' => '<sup class="text-danger">*</sup>',
                            ])
                            @slot('options')
                                @foreach ($desaKelurahan as $des)
                                    <option value="{{ $des->id }}"
                                        {{ $des->id == $row->desa_kelurahan_id ? 'selected' : '' }}>{{ $des->nama }}
                                    </option>
                                @endforeach
                            @endslot
                        @endcomponent
                    </div>
                </div>
                <div class="div d-flex justify-content-end">
                    <button type="button" class="btn btn-danger btn-sm btnHapusLokasiLama"
                        data-iteration={{ $loop->iteration }}><i class="fas fa-trash-alt"></i>
                        Hapus
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row mt-3">
        <div class="col-12 text-center">
            <button type="button" id="tambahLokasiTugas" class="btn btn-primary"><i class="bi bi-plus-circle"></i>
                Tambah Lokasi</button>
        </div>
        <div class="col-12 text-center">
            @component('dashboard.components.buttons.submit',
                [
                    'label' => 'Simpan Lokasi',
                    'class' => 'mt-4',
                ])
            @endcomponent
        </div>
    </div>
</form>

@push('script')
    <script>
        $(document).on('click', '.btnHapusLokasiLama', function() {
            var iteration = $(this).data('iteration');
            $('#daftarLokasi' + iteration).remove();
            $(this).remove();
        })

        var i = 1000;
        $('#tambahLokasiTugas').on('click', function() {
            i++;
            var lokasi = '<div class="card fieldset border border-secondary mt-4" id="daftarLokasi' + i +
                '"><span class="fieldset-tile text-secondary bg-white ml-6">Lokasi Tugas</span> <div class="row g-3 mb-3">' +
                // Provinsi
                '<div class="col-lg-3 col-md-6"> <label class="form-label">Provinsi <sup class="text-danger">*</sup></label> <select class="form-select select2 provinsi" id="provinsi' +
                i + '" aria-hidden="true" data-iteration = ' + i +
                ' name="provinsi[]"> <option value="" selected hidden>- Pilih Salah Satu -</option> </select></div>' +
                // Kabupaten / Kota
                '<div class="col-lg-3 col-md-6"><label class="form-label">Kabupaten / Kota <sup class="text-danger">*</sup></label><select class="form-select select2 kabupaten-kota" id="kabupaten-kota' +
                i + '" aria-hidden="true" data-iteration = ' + i +
                ' name="kabupaten_kota[]"><option value="" selected hidden>- Pilih Salah Satu -</option></select></div>' +
                // Kecamatan
                '<div class="col-lg-3 col-md-6"><label class="form-label">Kecamatan <sup class="text-danger">*</sup></label><select class="form-select select2 kecamatan" id="kecamatan' +
                i + '" aria-hidden="true" data-iteration = ' + i +
                ' name="kecamatan[]"><option value="" selected hidden>- Pilih Salah Satu -</option></select></div>' +
                // Desa / Kelurahan
                '<div class="col-lg-3 col-md-6"><label class="form-label">Desa / Kelurahan <sup class="text-danger">*</sup></label><select class="form-select select2 desa-kelurahan" id="desa-kelurahan' +
                i + '" aria-hidden="true" data-iteration = ' + i +
                ' name="desa_kelurahan[]"><option value="" selected hidden>- Pilih Salah Satu -</option></select></div>' +
                // Button Hapus
                '</div> <div class="div d-flex justify-content-end"> <button type="button" class="btn btn-danger btn-sm btnHapusLokasiBaru" data-iteration = ' +
                i + '><i class="fas fa-trash-alt"></i> Hapus</button></div></div>';

            $('#listLokasi').append(lokasi);
            $('#kabupaten-kota' + i).attr('disabled', true)
            $('#kecamatan' + i).attr('disabled', true)
            $('#desa-kelurahan' + i).attr('disabled', true)
            provinsi(i)
            $('.select2').select2({
                placeholder: "- Pilih Salah Satu -",
            })
        })

        $(document).on('click', '.btnHapusLokasiBaru', function() {
            var iteration = $(this).data('iteration');
            $('#daftarLokasi' + iteration).remove();
            $(this).remove();
        })

        function provinsi(i) {
            $.get("{{ route('listProvinsi') }}", function(result) {
                // console.log(i);
                $.each(result, function(key, val) {
                    $('#provinsi' + i).append(`<option value="${val.id}">${val.nama}</option>`);
                })
            });
        }

        // $(".provinsi").change(function() {
        $(document).on('change', '.provinsi', function() {
            var iteration = $(this).data('iteration');
            if (iteration > 1000) {
                $('#kabupaten-kota' + iteration).attr('disabled', false)
            }
            $('#kecamatan' + iteration).attr('disabled', true)
            $('#desa-kelurahan' + iteration).attr('disabled', true)
            $('#kecamatan' + iteration).html('')
            $('#desa-kelurahan' + iteration).html('')

            $('#kabupaten-kota' + iteration).html('');
            $('#kabupaten-kota' + iteration).append('<option value="">- Pilih Salah Satu -</option>')
            $.get("{{ route('listKabupatenKota') }}", {
                idProvinsi: $("#provinsi" + iteration).val()
            }, function(result) {
                $.each(result, function(key, val) {
                    $('#kabupaten-kota' + iteration).append(
                        `<option value="${val.id}">${val.nama}</option>`);
                })
            });
        })

        // $(".kabupaten-kota").change(function() {
        $(document).on('change', '.kabupaten-kota', function() {
            var iteration = $(this).data('iteration');
            $('#kecamatan' + iteration).attr('disabled', false)
            $('#desa-kelurahan' + iteration).attr('disabled', true)

            $('#kecamatan' + iteration).html('');
            $('#desa-kelurahan' + iteration).html('')
            $('#kecamatan' + iteration).append('<option value="">- Pilih Salah Satu -</option>')
            $.get("{{ route('listKecamatan') }}", {
                idKabupatenKota: $("#kabupaten-kota" + iteration).val()
            }, function(result) {
                $.each(result, function(key, val) {
                    $('#kecamatan' + iteration).append(
                        `<option value="${val.id}">${val.nama}</option>`);
                })
            });
        })

        // $(".kecamatan").change(function() {
        $(document).on('change', '.kecamatan', function() {
            var iteration = $(this).data('iteration');
            $('#desa-kelurahan' + iteration).attr('disabled', false)

            $('#desa-kelurahan' + iteration).html('');
            $('#desa-kelurahan' + iteration).append('<option value="">- Pilih Salah Satu -</option>')
            $.get("{{ route('listDesaKelurahan') }}", {
                idKecamatan: $("#kecamatan" + iteration).val()
            }, function(result) {
                $.each(result, function(key, val) {
                    $('#desa-kelurahan' + iteration).append(
                        `<option value="${val.id}">${val.nama}</option>`);
                })
            });
        })

        $('#{{ $form_id }}').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Simpan lokasi tugas?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, Simpan'
            }).then((result) => {
                if (result.value) {
                    var formData = new FormData(this);
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
                        success: function(response) {
                            if (response.res == 'Berhasil') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.msg,
                                }).then((result) => {
                                    window.location.href = "{{ $back_url }}";
                                });
                            } else if (response.res == 'Tidak Lengkap') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.msg,
                                })
                            } else if (response.res = 'Lokasi Tugas Kosong') {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Lokasi Tugas Dikosongkan',
                                }).then((result) => {
                                    window.location.href = "{{ $back_url }}";
                                });
                            }
                        },
                        error: function(response) {
                            alert(response.responseJSON.message)
                        },

                    });
                }
            })
        })







        $(function() {
            if ('{{ $user->lokasiTugas }}' == '[]') {
                $('#tambahLokasiTugas').click();
            }
            // $('.provinsi').trigger('change');

        });
    </script>
@endpush
