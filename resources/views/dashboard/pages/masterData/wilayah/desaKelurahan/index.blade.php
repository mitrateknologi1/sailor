@extends('dashboard.layouts.main')

@section('title')
    Desa/Kelurahan
@endsection

@push('style')
    <style>
        #map {
            height: 400px;
            margin-top: 0px;
        }

    </style>
@endpush

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Wilayah</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $kecamatan->kabupatenKota->provinsi->nama }}</li>
            <li class="breadcrumb-item active" aria-current="page">{{ $kecamatan->kabupatenKota->nama }}</li>
            <li class="breadcrumb-item active" aria-current="page">{{ $kecamatan->nama }}</li>
            <li class="breadcrumb-item active" aria-current="page">Desa | Kelurahan</li>
        </ol>
    </div>
@endsection

@section('content')
    <section>
        <div class="row mb-4">
            <div class="col">
                <div class="card ">
                    <div
                        class="card-header bg-light-secondary d-flex justify-content-between align-items-center border-bottom-0 pt-3 pb-0">
                        <h5 class="card-title mb-0">Data Wilayah Desa/Kelurahan</h5>
                        @component('dashboard.components.buttons.add', [
                            'id' => 'btn-tambah',
                            'class' => '',
                            'url' => url('masterData/desaKelurahan' . '/' . $kecamatan->id . '/create'),
                            ])
                        @endcomponent
                    </div>
                    <div class="card-body pt-2">
                        <div class="row px-3 mt-2">
                            <div id="map"></div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="card fieldset border border-secondary">
                                    @component('dashboard.components.dataTables.index', [
                                        'id' => 'table-data',
                                        'th' => ['No', 'Nama', 'Polygon', 'Warna Polygon', 'Aksi'],
                                        ])
                                    @endcomponent
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
        var center = [-0.8794398, 119.8251756];

        var map = L.map("map").setView(center, 12);

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: 'Data © <a href="http://osm.org/copyright">OpenStreetMap</a>',
            maxZoom: 18,
        }).addTo(map);

        $(document).ready(function() {
            $.ajax({
                url: "{{ url('/map/desaKelurahan') }}",
                type: "GET",
                data: {
                    kecamatan: "{{ $kecamatan->id }}"
                },
                success: function(response) {
                    if (response.status == 'success') {
                        for (var i = 0; i < response.data.length; i++) {
                            L.polygon(response.data[i].koordinatPolygon, {
                                    color: response.data[i].warna_polygon,
                                    weight: 1,
                                    opacity: 1,
                                    fillOpacity: 0.5
                                })
                                .addTo(map)
                                .bindPopup(response.data[i].nama);
                        }
                    }
                },
            })
        })
    </script>

    <script>
        $('#warna').change(function() {
            warna = $(this).val();
            drawnItems.setStyle({
                color: warna,
            });
        })
    </script>

    <script>
        $(document).on('click', '#btn-delete', function() {
            let id = $(this).val();

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda akan menghapus data desa/kelurahan ini ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ url('masterData/desaKelurahan' . '/' . $kecamatan->id) }}" +
                            '/' + id,
                        type: 'DELETE',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire(
                                    'Terhapus!',
                                    'Data desa/kelurahan telah dihapus.',
                                    'success'
                                ).then(function() {
                                    table.draw();
                                })
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    'Data desa/kelurahan gagal dihapus.',
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
        var table = $('#table-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('masterData/desaKelurahan' . '/' . $kecamatan->id) }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'statusPolygon',
                    name: 'statusPolygon',
                    class: 'text-center'
                },
                {
                    data: 'warnaPolygon',
                    name: 'warnaPolygon',
                    class: 'text-center'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true,
                    class: 'text-center'
                },
            ]
        });
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
        }

        function resetModal() {
            resetError();
            $('#form-tambah')[0].reset();
            $('#form-edit')[0].reset();
        }

        function resetErrorElement(key) {
            $('.' + key + '-error').addClass('d-none');
        }
    </script>
@endpush
