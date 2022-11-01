@extends('dashboard.layouts.main')

@section('title')
    Peta Data Moms Care
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
            <li class="breadcrumb-item active" aria-current="page">Moms Care</li>
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
                                    value="deteksi_dini">
                                    <span class="d-none d-sm-inline">Deteksi Dini</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link tab-map" data-bs-toggle="tab" href="#" role="tab"
                                    value="anc">
                                    <span class="d-none d-sm-inline">ANC</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body pt-2">
                        @component('dashboard.components.forms.petaData.export',
                            [
                                'tab' => 'deteksi_dini',
                                'action' => url('map-moms-care/export'),
                            ])
                        @endcomponent
                        <div class="row px-3 mt-2">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4" id="informasi_wilayah_deteksi_dini">
            <div class="col">
                <div class="card mb-3 border-dark">
                    <div class="card-header bg-dark border-bottom-0 py-3">
                        <h6 class="card-title mb-0 text-light">Informasi Lengkap Wilayah : <span
                                id="nama_wilayah_deteksi_dini">-</span>
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert alert-success rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-success text-light"><i
                                                class="fas fa-baby-carriage"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Kehamilan KRR (Beresiko Rendah)</div>
                                            <span class="small" id="resiko_rendah">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="alert alert-warning rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-warning text-light"><i
                                                class="fas fa-baby-carriage"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Kehamilan KRT (Beresiko TINGGI)</div>
                                            <span class="small" id="resiko_tinggi">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="alert alert-danger rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-danger text-light"><i
                                                class="fas fa-baby-carriage"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Kehamilan KRST (Beresiko SANGAT TINGGI)</div>
                                            <span class="small" id="resiko_sangat_tinggi">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4" id="informasi_wilayah_anc">
            <div class="col">
                <div class="card mb-3 border-dark">
                    <div class="card-header bg-dark border-bottom-0 py-3">
                        <h6 class="card-title mb-0 text-light">Informasi Lengkap Wilayah : <span
                                id="nama_wilayah_anc">-</span>
                        </h6>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title mb-3 text-dark">Kategori Badan</h6>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="alert alert-success rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-success text-light"><i
                                                class="fab fa-creative-commons-by"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Normal</div>
                                            <span class="small" id="badan_normal">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="alert alert-danger rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-danger text-light"><i
                                                class="fab fa-creative-commons-by"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Resiko Tinggi</div>
                                            <span class="small" id="badan_resiko_tinggi">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="card-title mb-3 text-dark">Kategori Tekanan Darah</h6>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="alert alert-primary rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-primary text-light"><i
                                                class="fas fa-tint"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Hipotensi</div>
                                            <span class="small" id="darah_hipotensi">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="alert alert-success rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-success text-light"><i
                                                class="fas fa-tint"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Normal</div>
                                            <span class="small" id="darah_normal">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="alert alert-warning rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-warning text-light"><i
                                                class="fas fa-tint"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Prahipertensi</div>
                                            <span class="small" id="darah_prahipertensi">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="alert alert-danger rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-danger text-light"><i
                                                class="fas fa-tint"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Hipertensi</div>
                                            <span class="small" id="darah_hipertensi">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="card-title mb-3 text-dark">Kategori Lingkar Lengan Atas</h6>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="alert alert-success rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-success text-light"><i
                                                class="fas fa-hand-paper"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Normal</div>
                                            <span class="small" id="lengan_normal">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="alert alert-danger rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-danger text-light"><i
                                                class="fas fa-hand-paper"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Kurang Gizi (BBLR)</div>
                                            <span class="small" id="lengan_kurang_gizi">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="card-title mb-3 text-dark">Kategori Denyut Jantung</h6>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="alert alert-success rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-success text-light"><i
                                                class="fas fa-heartbeat"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Normal</div>
                                            <span class="small" id="denyut_normal">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="alert alert-danger rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-danger text-light"><i
                                                class="fas fa-heartbeat"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Tidak Normal</div>
                                            <span class="small" id="denyut_tidak_normal">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="card-title mb-3 text-dark">Kategori Hemoglobin</h6>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="alert alert-success rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-success text-light"><i
                                                class="fas fa-hand-holding-water"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Normal</div>
                                            <span class="small" id="hemoglobin_normal">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="alert alert-danger rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-danger text-light"><i
                                                class="fas fa-hand-holding-water"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Anemia</div>
                                            <span class="small" id="hemoglobin_anemia">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="card-title mb-3 text-dark">Vaksin Tetanus Sebelum Hamil</h6>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="alert alert-success rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-success text-light"><i
                                                class="fas fa-syringe"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Sudah</div>
                                            <span class="small" id="tetanus_sebelum_sudah">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="alert alert-danger rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-danger text-light"><i
                                                class="fas fa-syringe"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Belum</div>
                                            <span class="small" id="tetanus_sebelum_belum">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="card-title mb-3 text-dark">Vaksin Tetanus Sesudah Hamil</h6>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="alert alert-success rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-success text-light"><i
                                                class="fas fa-syringe"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Sudah</div>
                                            <span class="small" id="tetanus_sesudah_sudah">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="alert alert-danger rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-danger text-light"><i
                                                class="fas fa-syringe"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Belum</div>
                                            <span class="small" id="tetanus_sesudah_belum">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="card-title mb-3 text-dark">Posisi Janin</h6>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="alert alert-success rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-success text-light"><i
                                                class="fas fa-baby"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Normal</div>
                                            <span class="small" id="janin_normal">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="alert alert-danger rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-danger text-light"><i
                                                class="fas fa-baby"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Sungsang</div>
                                            <span class="small" id="janin_sungsang">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="card-title mb-3 text-dark">Minum 90 Tablet Tambah Darah</h6>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="alert alert-success rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-success text-light"><i
                                                class="fas fa-capsules"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Sudah</div>
                                            <span class="small" id="tablet_sudah">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="alert alert-danger rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-danger text-light"><i
                                                class="fas fa-capsules"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Belum</div>
                                            <span class="small" id="tablet_belum">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="card-title mb-3 text-dark">Konseling</h6>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="alert alert-success rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-success text-light"><i
                                                class="fas fa-comments"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Sudah</div>
                                            <span class="small" id="konseling_sudah">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="alert alert-danger rounded-4 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar rounded no-thumbnail bg-danger text-light"><i
                                                class="fas fa-comments"></i></div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <div class="h6 mb-0">Belum</div>
                                            <span class="small" id="konseling_belum">-</span>
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
        var tab = 'deteksi_dini';
        $(document).ready(function() {
            initializeMap(9, centerMap);
            deteksiDini(9);
            $("#informasi_wilayah_anc").hide();
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
                    tab == 'deteksi_dini' ? deteksiDini(mapOnZoom) : anc(mapOnZoom);
                } else if (mapOnZoom >= 12 && boolDesa == false) {
                    boolDesa = true;
                    boolKecamatan = false;
                    // initializeMap(mapOnZoom, centerMap);
                    tab == 'deteksi_dini' ? deteksiDini(mapOnZoom) : anc(mapOnZoom);
                }

            });
        }
    </script>

    <script>
        var fitur = 'deteksiDini';
        $('.tab-map').on('click', function() {
            tab = $(this).attr('value');
            getProvinsi();
            // initializeMap(mapOnZoom, centerMap);
            if (tab == 'deteksi_dini') {
                deteksiDini(mapOnZoom);
                fitur = 'deteksiDini';
                $("#informasi_wilayah_deteksi_dini").show();
                $("#informasi_wilayah_anc").hide();
                $('#tab').val('deteksi_dini');
            } else if (tab == 'anc') {
                anc(mapOnZoom);
                fitur = 'anc';
                $("#informasi_wilayah_deteksi_dini").hide();
                $("#informasi_wilayah_anc").show();
                $('#tab').val('anc');
            }
        })
    </script>

    <script>
        var polygons = [];

        function deteksiDini(zoomMap) {
            $.ajax({
                url: "{{ url('/petaData/deteksiDini') }}",
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
                                    "<p class='my-0'><span class='my-0 badge bg-danger'>Kehamilan KRST (Beresiko SANGAT TINGGI) : " +
                                    response[i]
                                    .totalResikoSangatTinggi + "</span></p>" +
                                    "<p class='my-0'><span class='my-0 badge bg-warning'>Kehamilan KRT (Beresiko TINGGI) : " +
                                    response[i]
                                    .totalResikoTinggi + "</span></p>" +
                                    "<p class='my-0'><span class='my-0 badge bg-success'>Kehamilan KRR (Beresiko Rendah) : " +
                                    response[i]
                                    .totalResikoRendah + "</span></p>"
                                )
                                // .on('mouseover', function(e) {
                                //     this.openPopup(e.latlng);
                                // })
                                .on('click', L.bind(getDetailDeteksiDini, null, response[i].id))
                                .addTo(map);
                            polygons.push(polygon);
                        }
                    }
                },
            })
        }

        function anc(zoomMap) {
            $.ajax({
                url: "{{ url('/petaData/anc') }}",
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
                                    "<p class='my-0'><span class='my-0 badge bg-danger'>Badan Resiko Tinggi : " +
                                    response[i]
                                    .totalBadanResikoTinggi + "</span></p>" +
                                    "<p class='my-0'><span class='my-0 badge bg-success'>Badan Normal : " +
                                    response[i]
                                    .totalBadanNormal + "</span></p>" +
                                    "<hr class='my-2'>" +
                                    "<p class='my-0'><span class='my-0 badge bg-success'>Tekanan Darah Normal : " +
                                    response[i]
                                    .totalTekananDarahNormal + "</span></p>" +
                                    "<p class='my-0'><span class='my-0 badge bg-primary'>Tekanan Darah Hipotensi : " +
                                    response[i]
                                    .totalTekananDarahHipotensi + "</span></p>" +
                                    "<p class='my-0'><span class='my-0 badge bg-warning'>Tekanan Darah Prahipertensi : " +
                                    response[i]
                                    .totalTekananDarahPrahipertensi + "</span></p>" +
                                    "<p class='my-0'><span class='my-0 badge bg-danger'>Tekanan Darah Hipertensi : " +
                                    response[i]
                                    .totalTekananDarahHipertensi + "</span></p>" +
                                    "<hr class='my-2'>" +
                                    "<p class='my-0'><span class='my-0 badge bg-success'>Lengan Atas Normal : " +
                                    response[i]
                                    .totalLenganAtasNormal + "</span></p>" +
                                    "<p class='my-0'><span class='my-0 badge bg-danger'>Lengan Atas Kurang Gizi (BBLR) : " +
                                    response[i]
                                    .totalLenganAtasKurangGizi + "</span></p>" +
                                    "<hr class='my-2'>" +
                                    "<p class='my-0'><span class='my-0 badge bg-success'>Hemoglobin Darah Normal : " +
                                    response[i]
                                    .totalHemoglobinDarahNormal + "</span></p>" +
                                    "<p class='my-0'><span class='my-0 badge bg-danger'>Hemoglobin Darah Anemia : " +
                                    response[i]
                                    .totalHemoglobinDarahAnemia + "</span></p>" +
                                    "<hr class='my-2'>" +
                                    "<p class='my-0'><span class='my-0 badge bg-success'>Sudah Minum 90 Tablet Penambah Darah : " +
                                    response[i]
                                    .totalMinum90TabletSudah + "</span></p>" +
                                    "<p class='my-0'><span class='my-0 badge bg-danger'>Belum Minum 90 Tablet Penambah Darah : " +
                                    response[i]
                                    .totalMinum90TabletBelum + "</span></p>"
                                )
                                .on('click', L.bind(getDetailAnc, null, response[i].id))
                                // .on('mouseover', function(e) {
                                //     this.openPopup(e.latlng);
                                // })
                                .addTo(map);
                            polygons.push(polygon);
                        }
                    }
                },
            })
        }

        function getDetailDeteksiDini(id) {
            $.ajax({
                url: "{{ url('/petaData/detailDeteksiDini') }}",
                type: "GET",
                data: {
                    id: id,
                    zoomMap: mapOnZoom
                },
                success: function(response) {
                    $('#nama_wilayah_deteksi_dini').html(response.wilayah.nama);
                    $('#resiko_rendah').html(response.data.totalResikoRendah);
                    $('#resiko_tinggi').html(response.data.totalResikoTinggi);
                    $('#resiko_sangat_tinggi').html(response.data.totalResikoSangatTinggi);
                },
            })
        }

        function getDetailAnc(id) {
            $.ajax({
                url: "{{ url('/petaData/detailAnc') }}",
                type: "GET",
                data: {
                    id: id,
                    zoomMap: mapOnZoom
                },
                success: function(response) {
                    $('#nama_wilayah_anc').html(response.wilayah.nama);
                    $('#badan_normal').html(response.data.totalBadanNormal);
                    $('#badan_resiko_tinggi').html(response.data.totalBadanResikoTinggi);

                    $('#darah_hipotensi').html(response.data.totalTekananDarahHipotensi);
                    $('#darah_prahipertensi').html(response.data.totalTekananDarahPrahipertensi);
                    $('#darah_hipertensi').html(response.data.totalTekananDarahHipertensi);
                    $('#darah_normal').html(response.data.totalTekananDarahNormal);

                    $('#lengan_normal').html(response.data.totalLenganAtasNormal);
                    $('#lengan_kurang_gizi').html(response.data.totalLenganAtasKurangGizi);

                    $('#denyut_normal').html(response.data.totalDenyutJantungNormal);
                    $('#denyut_tidak_normal').html(response.data.totalDenyutJantungTidakNormal);

                    $('#hemoglobin_normal').html(response.data.totalHemoglobinDarahNormal);
                    $('#hemoglobin_anemia').html(response.data.totalHemoglobinDarahAnemia);

                    $('#tetanus_sebelum_sudah').html(response.data.totalVaksinSebelumHamilSudah);
                    $('#tetanus_sebelum_belum').html(response.data.totalVaksinSebelumHamilBelum);

                    $('#tetanus_sesudah_sudah').html(response.data.totalVaksinSesudahHamilSudah);
                    $('#tetanus_sesudah_belum').html(response.data.totalVaksinSesudahHamilBelum);

                    $('#janin_normal').html(response.data.totalPosisiJaninNormal);
                    $('#janin_sungsang').html(response.data.totalPosisiJaninSungsang);

                    $('#tablet_sudah').html(response.data.totalMinum90TabletSudah);
                    $('#tablet_belum').html(response.data.totalMinum90TabletBelum);

                    $('#konseling_sudah').html(response.data.totalKonselingSudah);
                    $('#konseling_belum').html(response.data.totalKonselingBelum);
                },
            })
        }

        function initializeFilter() {
            initializeMap(mapOnZoom, centerMap);
            if (tab == 'deteksi_dini') {
                deteksiDini(mapOnZoom);
            } else if (tab == 'anc') {
                anc(mapOnZoom);
            }
        }
    </script>

    <script>
        $('#m-link-peta-data').addClass('active');
        $('#menu-peta-data').addClass('collapse show')
        $('#ms-link-peta-moms-care').addClass('active')
    </script>
@endpush
