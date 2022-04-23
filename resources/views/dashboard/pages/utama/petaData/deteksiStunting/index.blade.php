@extends('dashboard.layouts.main')

@section('title')
    Peta Data Deteksi Stunting
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
            <li class="breadcrumb-item"><a class="text-secondary" href="{{ url('dashboard') }}">Peta Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Deteksi Stunting</li>
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
                                    <span class="d-none d-sm-inline">Stunting Anak</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link tab-map" data-bs-toggle="tab" href="#" role="tab"
                                    value="ibu_melahirkan_stunting">
                                    <span class="d-none d-sm-inline">Ibu Melahirkan Stunting</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body pt-2">
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
                                        <span class="text-truncate">Sangat Pendek (Resiko Stunting Tinggi)</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar2.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Laki-Laki</small>
                                                <div class="h6 mb-0" id="sangat_pendek_pria">-</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Perempuan</small>
                                                <div class="h6 mb-0" id="sangat_pendek_wanita">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card overflow-hidden">
                                    <div class="card-header bg-warning text-dark border-bottom-0">
                                        <span class="text-truncate">Pendek (Resiko Stunting Sedang)</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar2.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Laki-Laki</small>
                                                <div class="h6 mb-0" id="pendek_pria">-</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Perempuan</small>
                                                <div class="h6 mb-0" id="pendek_wanita">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card overflow-hidden">
                                    <div class="card-header bg-success text-light border-bottom-0">
                                        <span class="text-truncate">Normal</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar2.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Laki-Laki</small>
                                                <div class="h6 mb-0" id="normal_pria">-</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Perempuan</small>
                                                <div class="h6 mb-0" id="normal_wanita">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card overflow-hidden">
                                    <div class="card-header bg-primary text-light border-bottom-0">
                                        <span class="text-truncate">Tinggi</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar2.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Laki-Laki</small>
                                                <div class="h6 mb-0" id="tinggi_pria">-</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Perempuan</small>
                                                <div class="h6 mb-0" id="tinggi_wanita">-</div>
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
        var tab = 'stunting_anak';
        $(document).ready(function() {
            initializeMap(9, centerMap);
            stuntingAnak(9);
            $("#informasi_wilayah_ibu_melahirkan_stunting").hide();
        })

        function initializeMap(mapZoom, centerMap) {
            if (map != undefined || map != null) {
                map.remove();
            }

            map = L.map("map").setView(centerMap, mapZoom);
            // map.addControl(new L.Control.Fullscreen());

            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: 'Data © <a href="http://osm.org/copyright">OpenStreetMap</a>',
                maxZoom: 18,
            }).addTo(map);
            map.invalidateSize();

            map.on("zoomend", function(e) {

                mapOnZoom = map.getZoom();
                centerMap = map.getCenter();

                if (mapOnZoom <= 11 && boolKecamatan == false) {
                    boolKecamatan = true;
                    boolDesa = false;
                    initializeMap(mapOnZoom, centerMap);
                    tab == 'stunting_anak' ? stuntingAnak(mapOnZoom) : ibuMelahirkanStunting(mapOnZoom);
                } else if (mapOnZoom >= 12 && boolDesa == false) {
                    boolDesa = true;
                    boolKecamatan = false;
                    initializeMap(mapOnZoom, centerMap);
                    tab == 'stunting_anak' ? stuntingAnak(mapOnZoom) : ibuMelahirkanStunting(mapOnZoom);
                }

            });
        }
    </script>

    <script>
        $('.tab-map').on('click', function() {
            tab = $(this).attr('value');
            initializeMap(mapOnZoom, centerMap);
            if (tab == 'stunting_anak') {
                stuntingAnak(mapOnZoom);
                $("#informasi_wilayah_stunting_anak").show();
                $("#informasi_wilayah_ibu_melahirkan_stunting").hide();
            } else if (tab == 'ibu_melahirkan_stunting') {
                ibuMelahirkanStunting(mapOnZoom);
                $("#informasi_wilayah_stunting_anak").hide();
                $("#informasi_wilayah_ibu_melahirkan_stunting").show();
            }
        })
    </script>

    <script>
        function stuntingAnak(zoomMap) {
            $.ajax({
                url: "{{ url('/petaData/stuntingAnak') }}",
                type: "GET",
                data: {
                    zoomMap: zoomMap
                },
                success: function(response) {
                    if (response.length > 0) {
                        for (var i = 0; i < response.length; i++) {
                            L.polygon(response[i].koordinatPolygon, {
                                    color: response[i].warnaPolygon,
                                    weight: 1,
                                    opacity: 1,
                                    fillOpacity: 0.5
                                })
                                .bindTooltip(response[i].nama, {
                                    permanent: true,
                                    direction: "center"
                                })
                                .bindPopup(
                                    "<p class='fw-bold my-0 text-center title'>" + response[i].nama +
                                    "</p><hr class='my-2'>" +
                                    "<p class='my-0'><span class='my-0 badge bg-danger'>Sangat Pendek (Resiko Stunting Tinggi) : " +
                                    response[i]
                                    .totalStuntingAnakSangatPendek + "</span></p>" +
                                    "<p class='my-0'><span class='my-0 badge bg-warning'>Pendek (Resiko Stunting Sedang) : " +
                                    response[i]
                                    .totalStuntingAnakPendek + "</span></p>" +
                                    "<p class='my-0'><span class='my-0 badge bg-success'>Normal : " +
                                    response[i]
                                    .totalStuntingAnakNormal + "</span></p>" +
                                    "<p class='my-0'><span class='my-0 badge bg-primary'>Tinggi : " +
                                    response[i]
                                    .totalStuntingAnakTinggi + "</span></p>"
                                )
                                // .on('mouseover', function(e) {
                                //     this.openPopup(e.latlng);
                                // })
                                .on('click', L.bind(getDetailStuntingAnak, null, response[i].id))
                                .addTo(map);
                        }
                    }
                },
            })
        }

        function ibuMelahirkanStunting(zoomMap) {
            $.ajax({
                url: "{{ url('/petaData/deteksiIbuMelahirkanStunting') }}",
                type: "GET",
                data: {
                    zoomMap: zoomMap
                },
                success: function(response) {
                    if (response.length > 0) {
                        for (var i = 0; i < response.length; i++) {
                            L.polygon(response[i].koordinatPolygon, {
                                    color: response[i].warnaPolygon,
                                    weight: 1,
                                    opacity: 1,
                                    fillOpacity: 0.5
                                })
                                .bindTooltip(response[i].nama, {
                                    permanent: true,
                                    direction: "center"
                                })
                                .bindPopup(
                                    "<p class='fw-bold my-0 text-center title'>" + response[i].nama +
                                    "</p><hr class='my-2'>" +
                                    "<p class='my-0'><span class='my-0 badge bg-danger'>Beresiko Melahirkan Stunting : " +
                                    response[i]
                                    .totalBeresikoMelahirkanStunting + "</span></p>" +
                                    "<p class='my-0'><span class='my-0 badge bg-success'>Tidak Beresiko Melahirkan Stunting : " +
                                    response[i]
                                    .totalTidakBeresikoMelahirkanStunting + "</span></p>"
                                )
                                // .on('mouseover', function(e) {
                                //     this.openPopup(e.latlng);
                                // })
                                .on('click', L.bind(getDetailIbuMelahirkanStunting, null, response[i].id))
                                .addTo(map);
                        }
                    }
                },
            })
        }

        function getDetailStuntingAnak(id) {
            $.ajax({
                url: "{{ url('/petaData/detailStuntingAnak') }}",
                type: "GET",
                data: {
                    id: id,
                    zoomMap: mapOnZoom
                },
                success: function(response) {
                    console.log(response);
                    $('#informasi_wilayah').removeClass('d-none');
                    $('#nama_wilayah').html(response.wilayah.nama);

                    $('#sangat_pendek_pria').html(response.pria.totalStuntingAnakSangatPendek);
                    $('#sangat_pendek_wanita').html(response.wanita.totalStuntingAnakSangatPendek);

                    $('#pendek_pria').html(response.pria.totalStuntingAnakPendek);
                    $('#pendek_wanita').html(response.wanita.totalStuntingAnakPendek);

                    $('#normal_pria').html(response.pria.totalStuntingAnakNormal);
                    $('#normal_wanita').html(response.wanita.totalStuntingAnakNormal);

                    $('#tinggi_pria').html(response.pria.totalStuntingAnakTinggi);
                    $('#tinggi_wanita').html(response.wanita.totalStuntingAnakTinggi);
                },
            })
        }

        function getDetailIbuMelahirkanStunting(id) {
            $.ajax({
                url: "{{ url('/petaData/detailIbuMelahirkanStunting') }}",
                type: "GET",
                data: {
                    id: id,
                    zoomMap: mapOnZoom
                },
                success: function(response) {
                    console.log(response);
                    $('#nama_wilayah_ibu_melahirkan_stunting').html(response.wilayah.nama);

                    $('#beresiko_melahirkan_stunting').html(response.data.totalBeresikoMelahirkanStunting);
                    $('#tidak_beresiko_melahirkan_stunting').html(response.data
                        .totalTidakBeresikoMelahirkanStunting);
                },
            })
        }
    </script>

    <script>
        $('#m-link-peta-data').addClass('active');
        $('#menu-peta-data').addClass('collapse show')
        $('#ms-link-peta-deteksi-stunting').addClass('active')
    </script>
@endpush
