<form method="POST" enctype="multipart/form-data" id="form-export" action="{{ $action }}">
    @csrf
    <div class="row mt-3">
        <input type="text" id="tab" name="tab" value="{{ $tab }}" hidden>
        <input type="text" id="zoomMap" name="zoomMap" value="9" hidden>
        <div class="col-lg-5 col-md-6">
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
                @endslot
            @endcomponent
        </div>
        <div class="col-lg-5 col-md-6">
            @component('dashboard.components.formElements.select',
                [
                    'label' => 'Kabupaten / Kota',
                    'name' => 'kabupaten',
                    'id' => 'kabupaten-kota',
                    'class' => 'select2 kabupaten-kota',
                    'attribute' => '',
                    'wajib' => '<sup class="text-danger">*</sup>',
                ])
                @slot('options')
                @endslot
            @endcomponent
        </div>
        <div class="col-lg-2 col-md-6 d-flex align-items-end">
            <button type="submit" class="btn btn-success btn-sm col-12"><i class="far fa-file-excel"></i> Export
                Excel</button>
        </div>
</form>

@push('script')
    @error('provinsi')
        <script>
            $('.provinsi-error').text('{{ $message }}');
        </script>
    @enderror

    @error('kabupaten')
        <script>
            $('.kabupaten-error').text('{{ $message }}');
        </script>
    @enderror

    <script>
        function getProvinsi() {
            $('#provinsi').html('');
            $('#provinsi').append('<option value="">- Pilih Salah Satu -</option>');
            $('#kabupaten-kota').html('')
            $('#kabupaten-kota').append('<option value="">- Pilih Salah Satu -</option>')
            $.ajax({
                url: "{{ url('provinsi-fitur') }}",
                type: 'GET',
                data: {
                    'fitur': fitur
                },
                success: function(response) {
                    response.map((nilai) => {
                        $('#provinsi').append('<option value="' + nilai.id + '">' + nilai
                            .nama + '</option>');
                    });
                    initializeFilter();
                }
            })
        }

        $(document).on('change', '#provinsi', function() {
            $('#kabupaten-kota').html('')
            $('#kabupaten-kota').append('<option value="">- Pilih Salah Satu -</option>')
            $.ajax({
                url: "{{ url('kabupaten-fitur') }}",
                type: 'GET',
                data: {
                    'fitur': fitur,
                    'provinsi': $(this).val()
                },
                success: function(response) {
                    response.map((nilai) => {
                        $('#kabupaten-kota').append('<option value="' + nilai.id + '">' +
                            nilai
                            .nama + '</option>');
                    });
                    initializeFilter();
                }
            })
        })
        // $("#provinsi").change(function() {
        //     if ($("#provinsi").val() != '') {
        //         $("#kabupaten-kota").html('');
        //         $("#kabupaten-kota").append('<option value="">- Pilih Salah Satu -</option>')
        //         $.get("{{ route('listKabupatenKota') }}", {
        //             idProvinsi: $("#provinsi").val()
        //         }, function(result) {
        //             $.each(result, function(key, val) {
        //                 $('#kabupaten-kota').append(
        //                     `<option value="${val.id}">${val.nama}</option>`);
        //             })
        //         });
        //     }
        //     initializeFilter();
        // });

        $("#kabupaten-kota").change(function() {
            initializeFilter();
        })

        $(document).ready(function() {
            getProvinsi();
        });
    </script>
@endpush
