@extends('dashboard.layouts.main')

@section('title')
    Tambah Kecamatan
@endsection

@push('style')
@endpush

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Wilayah</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $kabupatenKota->provinsi->nama }}</li>
            <li class="breadcrumb-item active" aria-current="page">{{ $kabupatenKota->nama }}</li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Kecamatan</li>
        </ol>
    </div>
@endsection

@section('content')
    @component('dashboard.components.forms.masterData.wilayah',
        [
            'idForm' => 'form-tambah',
            'title' => 'Tambah Kecamatan',
            'method' => 'POST',
        ])
    @endcomponent
@endsection

@push('script')
    <script>
        $('#form-tambah').submit(function(e) {
            e.preventDefault();
            resetError();
            $.ajax({
                url: "{{ url('masterData/kecamatan' . '/' . $kabupatenKota->id) }}",
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status == 'success') {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Data Berhasil Disimpan',
                            showConfirmButton: false,
                        })
                        setTimeout(
                            function() {
                                $(location).attr('href',
                                    "{{ url('masterData/kecamatan' . '/' . $kabupatenKota->id) }}"
                                );
                            }, 2000
                        );
                    } else {
                        printErrorMsg(response.error);
                    }
                },
                error: function(response) {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Data Gagal Disimpan',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            })
        })

        $(document).ready(function() {
            $.ajax({
                url: "{{ url('map/kecamatan') }}",
                type: "GET",
                data: {
                    kabupatenKota: "{{ $kabupatenKota->id }}"
                },
                success: function(response) {
                    console.log(response);
                    if (response.status == 'success') {
                        for (var i = 0; i < response.data.length; i++) {
                            L.polygon(response.data[i].koordinatPolygon, {
                                    color: response.data[i].warna_polygon,
                                    weight: 1,
                                    opacity: 1,
                                    fillOpacity: 1
                                })
                                .addTo(map)
                                .bindTooltip(response.data[i].nama, {
                                    permanent: true,
                                    direction: "center",
                                    className: 'labelPolygon'
                                });
                        }
                    }
                },
            })
        })
    </script>

    <script>
        $('#m-link-wilayah').addClass('active');

        function printErrorMsg(msg) {
            $.each(msg, function(key, value) {
                $('.' + key + '-error').removeClass('d-none');
                $('.' + key + '-error').text(value);
            });
        }

        function resetError() {
            resetErrorElement('nama');
            resetErrorElement('warna');
            resetErrorElement('polygon');
        }

        function resetErrorElement(key) {
            $('.' + key + '-error').addClass('d-none');
        }
    </script>
@endpush
