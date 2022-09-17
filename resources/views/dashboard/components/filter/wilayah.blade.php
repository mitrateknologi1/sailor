<div class="row mt-2">
    <div class="col-lg">
        @component('dashboard.components.formElements.select',
            [
                'label' => 'Provinsi',
                'id' => 'provinsi_filter',
                'name' => 'provinsi_filter',
                'class' => 'filter select2',
            ])
            @slot('options')
            @endslot
        @endcomponent
    </div>
    <div class="col-lg">
        @component('dashboard.components.formElements.select',
            [
                'label' => 'Kabupaten / Kota',
                'id' => 'kabupaten_filter',
                'name' => 'kabupaten_filter',
                'class' => 'filter select2',
            ])
            @slot('options')
            @endslot
        @endcomponent
    </div>
    <div class="col-lg">
        @component('dashboard.components.formElements.select',
            [
                'label' => 'Kecamatan',
                'id' => 'kecamatan_filter',
                'name' => 'kecamatan_filter',
                'class' => 'filter select2',
            ])
            @slot('options')
            @endslot
        @endcomponent
    </div>
    <div class="col-lg">
        @component('dashboard.components.formElements.select',
            [
                'label' => 'Desa / Kelurahan',
                'id' => 'desa_filter',
                'name' => 'desa_filter',
                'class' => 'filter select2',
            ])
            @slot('options')
            @endslot
        @endcomponent
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function() {
            $('#provinsi_filter').html('')
            $('#provinsi_filter').attr('disabled', false)
            $('#provinsi_filter').append('<option value="">- Pilih Salah Satu -</option>')
            $('#provinsi_filter').append('<option value="semua">Semua</option>')
            $.ajax({
                url: "{{ url('provinsi-fitur') }}",
                type: 'GET',
                data: {
                    'fitur': '{{ $fitur }}'
                },
                success: function(response) {
                    response.map((nilai) => {
                        $('#provinsi_filter').append('<option value="' + nilai.id + '">' + nilai
                            .nama + '</option>');
                    });
                }
            })
        })

        $(document).on('change', '#provinsi_filter', function() {
            $('#kabupaten_filter').html('')
            $('#kecamatan_filter').html('')
            $('#desa_filter').html('')
            $('#kabupaten_filter').attr('disabled', false)
            $('#kabupaten_filter').append('<option value="">- Pilih Salah Satu -</option>')
            $('#kabupaten_filter').append('<option value="semua">Semua</option>')
            $('#kecamatan_filter').append('<option value="">- Pilih Salah Satu -</option>')
            $('#kecamatan_filter').append('<option value="semua">Semua</option>')
            $('#desa_filter').append('<option value="">- Pilih Salah Satu -</option>')
            $('#desa_filter').append('<option value="semua">Semua</option>')
            $('#kabupaten_filter').val('').trigger('change');
            $('#kecamatan_filter').val('').trigger('change');
            $('#desa_filter').val('').trigger('change');
            $.ajax({
                url: "{{ url('kabupaten-fitur') }}",
                type: 'GET',
                data: {
                    'fitur': '{{ $fitur }}',
                    'provinsi': $(this).val()
                },
                success: function(response) {
                    response.map((nilai) => {
                        $('#kabupaten_filter').append('<option value="' + nilai.id + '">' +
                            nilai
                            .nama + '</option>');
                    });
                }
            })
        })

        $(document).on('change', '#kabupaten_filter', function() {
            $('#kecamatan_filter').html('')
            $('#desa_filter').html('')
            $('#kecamatan_filter').attr('disabled', false)
            $('#kecamatan_filter').append('<option value="">- Pilih Salah Satu -</option>')
            $('#kecamatan_filter').append('<option value="semua">Semua</option>')
            $('#desa_filter').append('<option value="">- Pilih Salah Satu -</option>')
            $('#desa_filter').append('<option value="semua">Semua</option>')
            $('#desa_filter').val('').trigger('change');
            $('#kecamatan_filter').val('').trigger('change');
            $.ajax({
                url: "{{ url('kecamatan-fitur') }}",
                type: 'GET',
                data: {
                    'fitur': '{{ $fitur }}',
                    'kabupaten': $(this).val()
                },
                success: function(response) {
                    response.map((nilai) => {
                        $('#kecamatan_filter').append('<option value="' + nilai.id + '">' +
                            nilai
                            .nama + '</option>');
                    });
                }
            })
        })

        $(document).on('change', '#kecamatan_filter', function() {
            $('#desa_filter').html('')
            $('#desa_filter').attr('disabled', false)
            $('#desa_filter').append('<option value="">- Pilih Salah Satu -</option>')
            $('#desa_filter').append('<option value="semua">Semua</option>')
            $('#desa_filter').val('').trigger('change')
            $.ajax({
                url: "{{ url('desa-fitur') }}",
                type: 'GET',
                data: {
                    'fitur': '{{ $fitur }}',
                    'kecamatan': $(this).val()
                },
                success: function(response) {
                    response.map((nilai) => {
                        $('#desa_filter').append('<option value="' + nilai.id + '">' +
                            nilai
                            .nama + '</option>');
                    });
                }
            })
        })
    </script>
@endpush
