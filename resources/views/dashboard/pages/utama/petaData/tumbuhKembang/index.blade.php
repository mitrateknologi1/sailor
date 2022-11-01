@extends('dashboard.layouts.main')

@section('title')
    Peta Data Tumbuh Kembang
@endsection

@push('style')
    <style>
        #map {
            height: 700px;
            margin-top: 0px;
        }
    </style>
@endpush

@section('breadcrumb')
    <div class="col">
        <ol class="breadcrumb bg-transparent mb-0">
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Peta Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tumbuh Kembang</li>
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
                        <h5 class="card-title mb-0">Peta</h5>
                        <ul class="nav nav-tabs tab-card pt-3 " role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active tab-map" data-bs-toggle="tab" href="#" role="tab"
                                    value="stunting_anak">
                                    <span class="d-none d-sm-inline">Pertumbuhan Anak</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body pt-2">
                        @component('dashboard.components.forms.petaData.export',
                            [
                                'tab' => 'stunting_anak',
                                'action' => url('map-tumbuh-kembang/export'),
                            ])
                        @endcomponent
                        <div class="row px-3 mt-2">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4" id="informasi_wilayah_ibu_melahirkan_stunting">
            <div class="col">
                <div class="card mb-3 border-dark">
                    <div class="card-header bg-dark border-bottom-0 py-3">
                        <h6 class="card-title mb-0 text-light">Informasi Lengkap Wilayah : <span
                                id="nama_wilayah_ibu_melahirkan_stunting">-</span>
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="alert alert-success rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-success text-light"><i
                                                class="fas fa-baby-carriage"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Tidak Beresiko Melahirkan Stunting</div>
                                            <span class="small" id="tidak_beresiko_melahirkan_stunting">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="alert alert-danger rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-danger text-light"><i
                                                class="fas fa-baby-carriage"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Beresiko Melahirkan Stunting</div>
                                            <span class="small" id="beresiko_melahirkan_stunting">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4" id="informasi_wilayah_stunting_anak">
            <div class="col">
                <div class="card mb-3 border-dark">
                    <div class="card-header bg-dark border-bottom-0 py-3">
                        <h6 class="card-title mb-0 text-light">Informasi Lengkap Wilayah : <span id="nama_wilayah">-</span>
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card overflow-hidden">
                                    <div class="card-header bg-danger text-light border-bottom-0">
                                        <span class="text-truncate">Gizi Buruk</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar2.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Laki-Laki</small>
                                                <div class="h6 mb-0" id="gizi_buruk_pria">-</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Perempuan</small>
                                                <div class="h6 mb-0" id="gizi_buruk_wanita">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card overflow-hidden">
                                    <div class="card-header bg-warning text-dark border-bottom-0">
                                        <span class="text-truncate">Gizi Kurang</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar2.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Laki-Laki</small>
                                                <div class="h6 mb-0" id="gizi_kurang_pria">-</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Perempuan</small>
                                                <div class="h6 mb-0" id="gizi_kurang_wanita">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card overflow-hidden">
                                    <div class="card-header bg-success text-light border-bottom-0">
                                        <span class="text-truncate">Gizi Baik</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar2.jpg"
                                                alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Laki-Laki</small>
                                                <div class="h6 mb-0" id="gizi_baik_pria">-</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar4.jpg"
                                                alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Perempuan</small>
                                                <div class="h6 mb-0" id="gizi_baik_wanita">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card overflow-hidden">
                                    <div class="card-header bg-primary text-light border-bottom-0">
                                        <span class="text-truncate">Gizi Lebih</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar2.jpg"
                                                alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Laki-Laki</small>
                                                <div class="h6 mb-0" id="gizi_lebih_pria">-</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar4.jpg"
                                                alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Perempuan</small>
                                                <div class="h6 mb-0" id="gizi_lebih_wanita">-</div>
                                            </div>
                                        </div>
                                    </div>
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
        var map = null;
        var mapOnZoom = 9;
        var boolKecamatan = true;
        var boolDesa = false;
        var centerMap = [-1.1786786, 119.9906707];
        var tab = 'pertumbuhan_anak';
        $(document).ready(function() {
            initializeMap(9, centerMap);
            pertumbuhanAnak(9);
            $("#informasi_wilayah_ibu_melahirkan_stunting").hide();
        })

        function initializeMap(mapZoom, centerMap) {
            if (map != undefined || map != null) {
                map.remove();
            }

            map = L.map("map").setView(centerMap, mapZoom);
            map.addControl(new L.Control.Fullscreen());

            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: 'Data © <a href="http://osm.org/copyright">OpenStreetMap</a>',
                maxZoom: 18,
            }).addTo(map);
            map.invalidateSize();

            map.on("zoomend", function(e) {

                mapOnZoom = map.getZoom();
                centerMap = map.getCenter();
                $('#zoomMap').val(mapOnZoom);

                if (mapOnZoom <= 11 && boolKecamatan == false) {
                    boolKecamatan = true;
                    boolDesa = false;
                    // initializeMap(mapOnZoom, centerMap);
                    pertumbuhanAnak(mapOnZoom);
                } else if (mapOnZoom >= 12 && boolDesa == false) {
                    boolDesa = true;
                    boolKecamatan = false;
                    // initializeMap(mapOnZoom, centerMap);
                    pertumbuhanAnak(mapOnZoom);
                }

            });
        }
    </script>

    <script>
        var fitur = 'pertumbuhanAnak';
        $('.tab-map').on('click', function() {
            getProvinsi();
            tab = $(this).attr('value');
            // initializeMap(mapOnZoom, centerMap);
            pertumbuhanAnak(mapOnZoom);
            $("#informasi_wilayah_stunting_anak").show();
        })
    </script>

    <script>
        var polygons = [];

        function pertumbuhanAnak(zoomMap) {
            $.ajax({
                url: "{{ url('/petaData/pertumbuhanAnak') }}",
                type: "GET",
                data: {
                    zoomMap: zoomMap,
                    kabupaten: $('#kabupaten-kota').val(),
                },
                success: function(response) {
                    if (response.length > 0) {
                        polygons.forEach(function(item) {
                            map.removeLayer(item)
                        });
                        for (var i = 0; i < response.length; i++) {
                            var polygon = L.polygon(response[i].koordinatPolygon, {
                                    color: 'white',
                                    fillColor: response[i].warnaPolygon,
                                    weight: 1,
                                    opacity: 1,
                                    fillOpacity: 1
                                })
                                .bindTooltip(response[i].nama, {
                                    permanent: true,
                                    direction: "center",
                                    className: 'labelPolygon'
                                })
                                .bindPopup(
                                    "<p class='fw-bold my-0 text-center title'>" + response[i].nama +
                                    "</p><hr class='my-2'>" +
                                    "<p class='my-0'><span class='my-0 badge bg-danger'>Gizi Buruk : " +
                                    response[i]
                                    .totalGiziBuruk + "</span></p>" +
                                    "<p class='my-0'><span class='my-0 badge bg-warning'>Gizi Kurang : " +
                                    response[i]
                                    .totalGiziKurang + "</span></p>" +
                                    "<p class='my-0'><span class='my-0 badge bg-success'>Gizi Baik : " +
                                    response[i]
                                    .totalGiziBaik + "</span></p>" +
                                    "<p class='my-0'><span class='my-0 badge bg-primary'>Gizi Lebih : " +
                                    response[i]
                                    .totalGiziLebih + "</span></p>"
                                )
                                // .on('mouseover', function(e) {
                                //     this.openPopup(e.latlng);
                                // })
                                .on('click', L.bind(getDetailPertumbuhanAnak, null, response[i].id))
                                .addTo(map);
                            polygons.push(polygon);
                        }
                    }
                },
            })
        }

        function getDetailPertumbuhanAnak(id) {
            $.ajax({
                url: "{{ url('/petaData/detailPertumbuhanAnak') }}",
                type: "GET",
                data: {
                    id: id,
                    zoomMap: mapOnZoom
                },
                success: function(response) {
                    $('#nama_wilayah').html(response.wilayah.nama);
                    $("#gizi_buruk_pria").html(response.pria.totalGiziBuruk);
                    $("#gizi_buruk_wanita").html(response.wanita.totalGiziBuruk);

                    $('#gizi_kurang_pria').html(response.pria.totalGiziKurang);
                    $('#gizi_kurang_wanita').html(response.wanita.totalGiziKurang);

                    $('#gizi_baik_pria').html(response.pria.totalGiziBaik);
                    $('#gizi_baik_wanita').html(response.wanita.totalGiziBaik);

                    $('#gizi_lebih_pria').html(response.pria.totalGiziLebih);
                    $('#gizi_lebih_wanita').html(response.wanita.totalGiziLebih);
                },
            })
        }

        function initializeFilter() {
            initializeMap(mapOnZoom, centerMap);
            pertumbuhanAnak(mapOnZoom);
        }
    </script>

    <script>
        $('#m-link-peta-data').addClass('active');
        $('#menu-peta-data').addClass('collapse show')
        $('#ms-link-peta-tumbuh-kembang').addClass('active')
    </script>
@endpush
