@push('script')
<script>
    $(function() {
        
        $('#kabupaten-kota').attr('disabled', true);
            $('#kecamatan').attr('disabled', true);
            $('#desa-kelurahan').attr('disabled', true);

        $.get("{{ route('listProvinsi') }}", function(result) {
            $.each(result, function(key, val) {
                if (val.id == '{{$provinsi}}' ) {
                    $('#provinsi{{$loop}}').append(`<option value="${val.id}" selected>${val.nama}</option>`);
                    $('#provinsi{{$loop}}').trigger('change');
                } else {
                    $('#provinsi{{$loop}}').append(`<option value="${val.id}">${val.nama}</option>`);
                } 
            })
        });

        $("#provinsi").change(function() {
            if($("#provinsi").val() != ''){
                $("#kabupaten-kota").html('');
                $("#kabupaten-kota").append('<option value="">- Pilih Salah Satu -</option>')
                $.get("{{ route('listKabupatenKota') }}", {idProvinsi: $("#provinsi").val()}, function(result) {
                    $.each(result, function(key, val) {
                        if (val.id == '{{ $kabupaten_kota }}' ) {
                            $('#kabupaten-kota').append(`<option value="${val.id}" selected>${val.nama}</option>`);
                            $('#kabupaten-kota').trigger('change');
                        } else {
                            $('#kabupaten-kota').append(`<option value="${val.id}">${val.nama}</option>`);
                        }
                    })
                    $('#kabupaten-kota').attr('disabled', false);
                });
            }
        });

        $("#kabupaten-kota").change(function() {
            if($("#kabupaten-kota").val() != ''){
                $("#kecamatan").html('');
                $("#kecamatan").append('<option value="">- Pilih Salah Satu -</option>')
                $.get("{{ route('listKecamatan') }}", {idKabupatenKota: $("#kabupaten-kota").val()}, function(result) {
                    $.each(result, function(key, val) {
                        if (val.id == '{{ $kecamatan }}' ) {
                            $('#kecamatan').append(`<option value="${val.id}" selected>${val.nama}</option>`);
                            $('#kecamatan').trigger('change');
                        } else {
                            $('#kecamatan').append(`<option value="${val.id}">${val.nama}</option>`);
                        }
                    })
                    $('#kecamatan').attr('disabled', false); 
                });
            }
        });

        $("#kecamatan").change(function() {
            if($("#kecamatan").val() != ''){
                $("#desa-kelurahan").html('');
                $("#desa-kelurahan").append('<option value="">- Pilih Salah Satu -</option>')
                $.get("{{ route('listDesaKelurahan') }}", {idKecamatan: $("#kecamatan").val()}, function(result) {
                    $.each(result, function(key, val) {
                        if (val.id == '{{ $desa_kelurahan }}' ) {
                            $('#desa-kelurahan').append(`<option value="${val.id}" selected>${val.nama}</option>`);
                        } else {
                            $('#desa-kelurahan').append(`<option value="${val.id}">${val.nama}</option>`);
                        }
                    })
                    $('#desa-kelurahan').attr('disabled', false);     
                });
            }
        });
    });
</script>    
@endpush