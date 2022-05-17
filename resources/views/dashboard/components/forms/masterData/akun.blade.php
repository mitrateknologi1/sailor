<form id="{{ $form_id }}" action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
    @csrf
    @if (isset($method) && $method == 'PUT')
        @method('PUT')
    @endif
    <div class="row g-4">
        <div class="col-lg-4 col-md-6">
            @component('dashboard.components.formElements.input',
                [
                    'label' => 'Nomor HP',
                    'type' => 'text',
                    'id' => 'nomor-hp',
                    'name' => 'nomor_hp',
                    'class' => 'angka',
                    'value' => isset($user) ? $user->nomor_hp : null,
                    'wajib' => '<sup class="text-danger">*</sup>',
                ])
            @endcomponent
        </div>
        <div class="col-lg-4 col-md-6">
            @component('dashboard.components.formElements.input',
                [
                    'label' => 'Kata Sandi',
                    'type' => 'password',
                    'id' => 'kata-sandi',
                    'name' => 'kata_sandi',
                    'class' => '',
                    'wajib' => '<sup class="text-danger">*</sup>',
                ])
            @endcomponent
            @if ($method == 'PUT')
                <div class="form-text text-muted">
                    <small><i>Kosongkan kata sandi jika tidak ingin mengubahnya</i></small>
                </div>
            @endif
        </div>
        <div class="col-lg-4 col-md-6">
            @component('dashboard.components.formElements.input',
                [
                    'label' => 'Ulangi Kata Sandi',
                    'type' => 'password',
                    'id' => 'ulangi-kata-sandi',
                    'name' => 'ulangi_kata_sandi',
                    'class' => '',
                    'wajib' => '<sup class="text-danger">*</sup>',
                ])
            @endcomponent
            @if ($method == 'PUT')
                <div class="form-text text-muted">
                    <small><i>Kosongkan kata sandi jika tidak ingin mengubahnya</i></small>
                </div>
            @endif
        </div>
        @if (Auth::user()->role == 'admin')
            <div class="col-lg-4 col-md-6">
                @component('dashboard.components.formElements.select',
                    [
                        'label' => 'Role / Profil',
                        'name' => 'role',
                        'id' => 'role',
                        'class' => 'select2 role',
                        'attribute' => '',
                        'wajib' => '<sup class="text-danger">*</sup>',
                    ])
                    @slot('options')
                        @if (Auth::user()->id == '5gf9ba91-4778-404c-aa7f-5fd327e87e80')
                            <option value="admin" {{ isset($user) && $user->role == 'admin' ? 'selected' : '' }}>Admin
                            </option>
                        @endif
                        @if ($method == 'PUT')
                            <option value="keluarga"
                                {{ isset($user) && $user->role == 'keluarga' && $user->is_remaja == 0 ? 'selected' : '' }}>
                                Kepala Keluarga
                            </option>
                            <option value="keluarga"
                                {{ isset($user) && $user->role == 'keluarga' && $user->is_remaja == 1 ? 'selected' : '' }}>
                                Remaja
                            </option>
                        @endif
                        <option value="bidan" {{ isset($user) && $user->role == 'bidan' ? 'selected' : '' }}>Bidan</option>
                        <option value="penyuluh" {{ isset($user) && $user->role == 'penyuluh' ? 'selected' : '' }}>Penyuluh
                        </option>
                    @endslot
                @endcomponent
            </div>
        @endif
        <div class="col-lg-4 col-md-6">
            <label for="" class="mb-1">Status <sup class="text-danger">*</sup></label>
            <div class="d-flex flex-row">
                <div class="p-2">
                    @component('dashboard.components.formElements.radio',
                        [
                            'id' => 'status-aktif',
                            'name' => 'status',
                            'value' => '1',
                            'label' => 'Aktif',
                            'checked' => isset($user) && $user->status == 1 ? 'checked' : '',
                        ])
                    @endcomponent
                </div>
                <div class="p-2">
                    @component('dashboard.components.formElements.radio',
                        [
                            'id' => 'status-tidak-aktif',
                            'name' => 'status',
                            'value' => '0',
                            'label' => 'Tidak Aktif',
                            'checked' => isset($user) && $user->status == 0 ? 'checked' : '',
                        ])
                    @endcomponent
                </div>
            </div>
            <span class="text-danger error-text status-error"></span>
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
        if ('{{ $method }}' == 'PUT') {
            $('#role').attr('disabled', true);
        }
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
                            if ($.isEmptyObject(data.error)) {
                                if ('{{ $method }}' == 'POST') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: 'Data akun berhasil ditambahkan',
                                    }).then((result) => {
                                        window.location.href =
                                            "{{ url()->previous() }}";
                                    })
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: 'Data akun berhasil diubah',
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
