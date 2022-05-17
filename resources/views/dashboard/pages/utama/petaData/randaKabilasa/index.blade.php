@extends('dashboard.layouts.main')

@section('title')
    Peta Data Randa Kabilasa
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
            <li class="breadcrumb-item active" aria-current="page">Randa Kabilasa</li>
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
                    </div>
                    <div class="card-body pt-2">
                        @component('dashboard.components.forms.petaData.export',
                            [
                                'tab' => 'randa_kabilasa',
                                'provinsi' => $provinsi,
                                'action' => url('map-randa-kabilasa/export'),
                            ])
                        @endcomponent
                        <div class="row px-3 mt-2">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4" id="informasi_wilayah">
            <div class="col">
                <div class="card mb-3 border-dark">
                    <div class="card-header bg-dark border-bottom-0 py-3">
                        <h6 class="card-title mb-0 text-light">Informasi Lengkap Wilayah : <span id="nama_wilayah">-</span>
                        </h6>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title mb-3 text-dark">Kategori Hemoglobin (HB)</h6>
                        <div class="row">
                            <div class="col-lg-4">
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
                                                <div class="h6 mb-0" id="hb_normal_pria">-</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Perempuan</small>
                                                <div class="h6 mb-0" id="hb_normal_wanita">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card overflow-hidden">
                                    <div class="card-header bg-warning  border-bottom-0">
                                        <span class="text-truncate">Terindikasi Anemia</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar2.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Laki-Laki</small>
                                                <div class="h6 mb-0" id="hb_terindikasi_anemia_pria">-</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Perempuan</small>
                                                <div class="h6 mb-0" id="hb_terindikasi_anemia_wanita">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card overflow-hidden">
                                    <div class="card-header bg-danger text-light border-bottom-0">
                                        <span class="text-truncate">Anemia</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar2.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Laki-Laki</small>
                                                <div class="h6 mb-0" id="hb_anemia_pria">-</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Perempuan</small>
                                                <div class="h6 mb-0" id="hb_anemia_wanita">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="card-title my-3 text-dark">Kategori Lingkar Lengan Atas</h6>
                        <div class="row">
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
                                                <div class="h6 mb-0" id="lila_normal_pria">-</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Perempuan</small>
                                                <div class="h6 mb-0" id="lila_normal_wanita">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card overflow-hidden">
                                    <div class="card-header bg-danger text-light  border-bottom-0">
                                        <span class="text-truncate">Kurang Gizi</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar2.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Laki-Laki</small>
                                                <div class="h6 mb-0" id="lila_kurang_gizi_pria">-</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Perempuan</small>
                                                <div class="h6 mb-0" id="lila_kurang_gizi_wanita">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="card-title my-3 text-dark">Kategori Indeks Masa Tubuh</h6>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card overflow-hidden">
                                    <div class="card-header bg-danger text-light border-bottom-0">
                                        <span class="text-truncate">Sangat Kurus</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar2.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Laki-Laki</small>
                                                <div class="h6 mb-0" id="imt_sangat_kurus_pria">-</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Perempuan</small>
                                                <div class="h6 mb-0" id="imt_sangat_kurus_wanita">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card overflow-hidden">
                                    <div class="card-header bg-warning text-dark  border-bottom-0">
                                        <span class="text-truncate">Kurus</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar2.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Laki-Laki</small>
                                                <div class="h6 mb-0" id="imt_kurus_pria">-</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Perempuan</small>
                                                <div class="h6 mb-0" id="imt_kurus_wanita">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card overflow-hidden">
                                    <div class="card-header bg-success text-light  border-bottom-0">
                                        <span class="text-truncate">Normal</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar2.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Laki-Laki</small>
                                                <div class="h6 mb-0" id="imt_normal_pria">-</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Perempuan</small>
                                                <div class="h6 mb-0" id="imt_normal_wanita">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card overflow-hidden">
                                    <div class="card-header bg-warning text-dark  border-bottom-0">
                                        <span class="text-truncate">Gemuk</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar2.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Laki-Laki</small>
                                                <div class="h6 mb-0" id="imt_gemuk_pria">-</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Perempuan</small>
                                                <div class="h6 mb-0" id="imt_gemuk_wanita">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card overflow-hidden">
                                    <div class="card-header bg-danger text-light  border-bottom-0">
                                        <span class="text-truncate">Sangat Gemuk</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar2.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Laki-Laki</small>
                                                <div class="h6 mb-0" id="imt_sangat_gemuk_pria">-</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Perempuan</small>
                                                <div class="h6 mb-0" id="imt_sangat_gemuk_wanita">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="card-title my-3 text-dark">Asesmen Mencegah Malnutrisi</h6>
                        <div class="row">
                            <div class="col">
                                <div class="card overflow-hidden">
                                    <div class="card-header bg-success text-light border-bottom-0">
                                        <span class="text-truncate">Berpartisipasi Mencegah Stunting</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar2.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Laki-Laki</small>
                                                <div class="h6 mb-0" id="mencegah_malnutrisi_pria">-</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Perempuan</small>
                                                <div class="h6 mb-0" id="mencegah_malnutrisi_wanita">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card overflow-hidden">
                                    <div class="card-header bg-danger text-light border-bottom-0">
                                        <span class="text-truncate">Tidak Berpartisipasi Mencegah Stunting</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar2.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Laki-Laki</small>
                                                <div class="h6 mb-0" id="tidak_mencegah_malnutrisi_pria">-</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Perempuan</small>
                                                <div class="h6 mb-0" id="tidak_mencegah_malnutrisi_wanita">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="card-title my-3 text-dark">Asesmen Meningkatkan Life Skill</h6>
                        <div class="row">
                            <div class="col">
                                <div class="card overflow-hidden">
                                    <div class="card-header bg-success text-light border-bottom-0">
                                        <span class="text-truncate">Berpartisipasi Mencegah Stunting</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar2.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Laki-Laki</small>
                                                <div class="h6 mb-0" id="meningkatkan_skill_pria">-</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Perempuan</small>
                                                <div class="h6 mb-0" id="meningkatkan_skill_wanita">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card overflow-hidden">
                                    <div class="card-header bg-danger text-light border-bottom-0">
                                        <span class="text-truncate">Tidak Berpartisipasi Mencegah Stunting</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar2.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Laki-Laki</small>
                                                <div class="h6 mb-0" id="tidak_meningkatkan_skill_pria">-</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Perempuan</small>
                                                <div class="h6 mb-0" id="tidak_meningkatkan_skill_wanita">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="card-title my-3 text-dark">Asesmen Mencegah Pernikahan Dini</h6>
                        <div class="row">
                            <div class="col">
                                <div class="card overflow-hidden">
                                    <div class="card-header bg-success text-light border-bottom-0">
                                        <span class="text-truncate">Berpartisipasi Mencegah Stunting</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar2.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Laki-Laki</small>
                                                <div class="h6 mb-0" id="mencegah_pernikahan_dini_pria">-</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Perempuan</small>
                                                <div class="h6 mb-0" id="mencegah_pernikahan_dini_wanita">-</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card overflow-hidden">
                                    <div class="card-header bg-danger text-light border-bottom-0">
                                        <span class="text-truncate">Tidak Berpartisipasi Mencegah Stunting</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar2.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Laki-Laki</small>
                                                <div class="h6 mb-0" id="tidak_mencegah_pernikahan_dini_pria">-
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="avatar rounded"
                                                src="{{ asset('assets/dashboard/') }}/images/xs/avatar4.jpg" alt="">
                                            <div class="flex-fill ms-3">
                                                <small>Perempuan</small>
                                                <div class="h6 mb-0" id="tidak_mencegah_pernikahan_dini_wanita">-
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
        $(document).ready(function() {
            initializeMap(9, centerMap);
            randaKabilasa(9);
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
                $('#zoomMap').val(mapOnZoom);

                if (mapOnZoom <= 11 && boolKecamatan == false) {
                    boolKecamatan = true;
                    boolDesa = false;
                    initializeMap(mapOnZoom, centerMap);
                    randaKabilasa(mapOnZoom);
                } else if (mapOnZoom >= 12 && boolDesa == false) {
                    boolDesa = true;
                    boolKecamatan = false;
                    initializeMap(mapOnZoom, centerMap);
                    randaKabilasa(mapOnZoom);
                }

            });
        }
    </script>

    <script>
        function randaKabilasa(zoomMap) {
            $.ajax({
                url: "{{ url('/petaData/randaKabilasa') }}",
                type: "GET",
                data: {
                    zoomMap: zoomMap,
                    kabupaten: $('#kabupaten-kota').val(),
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
                                    // "<p class='my-0'>Total HB Normal : " +
                                    // response[i]
                                    // .totalHbNormal + "</p>" +
                                    // "<p class='my-0'>Total HB Terindikasi Anemia : " + response[i]
                                    // .totalHbTerindikasiAnemia + "</p>" +
                                    // "<p class='my-0'>Total HB Anemia : " + response[i]
                                    // .totalHbAnemia + "</p>" +
                                    // "<hr class='my-2'>" +
                                    // "<p class='my-0'>Total Lingkar Lengan Atas Kurang Gizi : " + response[i]
                                    // .totalLingkarKurangGizi + "</p>" +
                                    // "<p class='my-0'>Total Lingkar Lengan Atas Normal : " + response[i]
                                    // .totalLingkarNormal + "</p>" +
                                    // "<hr class='my-2'>" +
                                    // "<p class='my-0'>Total Indeks Masa Tubuh Sangat Kurus : " + response[i]
                                    // .totalImtSangatKurus + "</p>" +
                                    // "<p class='my-0'>Total Indeks Masa Tubuh Kurus : " + response[i]
                                    // .totalImtKurus + "</p>" +
                                    // "<p class='my-0'>Total Indeks Masa Tubuh Normal : " + response[i]
                                    // .totalImtNormal + "</p>" +
                                    // "<p class='my-0'>Total Indeks Masa Tubuh Gemuk : " + response[i]
                                    // .totalImtGemuk + "</p>" +
                                    // "<p class='my-0'>Total Indeks Masa Tubuh Sangat Gemuk : " + response[i]
                                    // .totalImtSangatGemuk + "</p>" +
                                    // "<hr class='my-2'>" +
                                    "<p class='fw-bold my-0 title'>Asesmen Mencegah Malnutrisi</p>" +
                                    "<p class='my-0'><span class='my-0 badge bg-success'>Berpartisipasi Mencegah Stunting : " +
                                    response[i]
                                    .totalMencegahMalnutrisi + "</span></p>" +
                                    "<p class='my-0'><span class='my-0 badge bg-danger'>Tidak Berpartisipasi Mencegah Stunting : " +
                                    response[i]
                                    .totalTidakMencegahMalnutrisi + "</span></p>" +
                                    "<hr class='my-2'>" +
                                    "<p class='fw-bold my-0 title'>Asesmen Meningkatkan Life Skill</p>" +
                                    "<p class='my-0'><span class='my-0 badge bg-success'>Berpartisipasi Mencegah Stunting : " +
                                    response[i]
                                    .totalMeningkatkanLifeSkill + "</span></p>" +
                                    "<p class='my-0'><span class='my-0 badge bg-danger'>Tidak Berpartisipasi Mencegah Stunting : " +
                                    response[i]
                                    .totalTidakMeningkatkanLifeSkill + "</span></p>" +
                                    "<hr class='my-2'>" +
                                    "<p class='fw-bold my-0 title'>Asesmen Mencegah Pernikahan Dini</p>" +
                                    "<p class='my-0'><span class='my-0 badge bg-success'>Berpartisipasi Mencegah Stunting : " +
                                    response[i]
                                    .totalMencegahPernikahanDini + "</span></p>" +
                                    "<p class='my-0'><span class='my-0 badge bg-danger'>Tidak Berpartisipasi Mencegah Stunting : " +
                                    response[i]
                                    .totalTidakMencegahPernikahanDini + "</span></p>"
                                )
                                // .on('mouseover', function(e) {
                                //     this.openPopup(e.latlng);
                                // })
                                .on('click', L.bind(getDetailPeta, null, response[i].id))
                                .addTo(map);
                        }
                    }
                },
            })
        }

        function getDetailPeta(id) {
            $.ajax({
                url: "{{ url('/petaData/detailRandaKabilasa') }}",
                type: "GET",
                data: {
                    id: id,
                    zoomMap: mapOnZoom
                },
                success: function(response) {
                    $('#nama_wilayah').html(response.wilayah.nama);

                    $('#hb_normal_pria').html(response.pria.totalHbNormal);
                    $('#hb_normal_wanita').html(response.wanita.totalHbNormal);

                    $('#hb_terindikasi_anemia_pria').html(response.pria.totalHbTerindikasiAnemia);
                    $('#hb_terindikasi_anemia_wanita').html(response.wanita.totalHbTerindikasiAnemia);
                    $('#hb_anemia_pria').html(response.pria.totalHbAnemia);
                    $('#hb_anemia_wanita').html(response.wanita.totalHbAnemia);

                    $('#lila_normal_pria').html(response.pria.totalLingkarNormal);
                    $('#lila_normal_wanita').html(response.wanita.totalLingkarNormal);
                    $('#lila_kurang_gizi_pria').html(response.pria.totalLingkarKurangGizi);
                    $('#lila_kurang_gizi_wanita').html(response.wanita.totalLingkarKurangGizi);

                    $('#imt_sangat_kurus_pria').html(response.pria.totalImtSangatKurus);
                    $('#imt_sangat_kurus_wanita').html(response.wanita.totalImtSangatKurus);
                    $('#imt_kurus_pria').html(response.pria.totalImtKurus);
                    $('#imt_kurus_wanita').html(response.wanita.totalImtKurus);
                    $('#imt_normal_pria').html(response.pria.totalImtNormal);
                    $('#imt_normal_wanita').html(response.wanita.totalImtNormal);
                    $('#imt_gemuk_pria').html(response.pria.totalImtGemuk);
                    $('#imt_gemuk_wanita').html(response.wanita.totalImtGemuk);
                    $('#imt_sangat_gemuk_pria').html(response.pria.totalImtSangatGemuk);
                    $('#imt_sangat_gemuk_wanita').html(response.wanita.totalImtSangatGemuk);

                    $('#mencegah_malnutrisi_pria').html(response.pria.totalMencegahMalnutrisi);
                    $('#mencegah_malnutrisi_wanita').html(response.wanita.totalMencegahMalnutrisi);
                    $('#tidak_mencegah_malnutrisi_pria').html(response.pria.totalTidakMencegahMalnutrisi);
                    $('#tidak_mencegah_malnutrisi_wanita').html(response.wanita.totalTidakMencegahMalnutrisi);

                    $('#meningkatkan_skill_pria').html(response.pria.totalMeningkatkanLifeSkill);
                    $('#meningkatkan_skill_wanita').html(response.wanita.totalMeningkatkanLifeSkill);
                    $('#tidak_meningkatkan_skill_pria').html(response.pria.totalTidakMeningkatkanLifeSkill);
                    $('#tidak_meningkatkan_skill_wanita').html(response.wanita.totalTidakMeningkatkanLifeSkill);

                    $('#mencegah_pernikahan_dini_pria').html(response.pria.totalMencegahPernikahanDini);
                    $('#mencegah_pernikahan_dini_wanita').html(response.wanita.totalMencegahPernikahanDini);
                    $('#tidak_mencegah_pernikahan_dini_pria').html(response.pria
                        .totalTidakMencegahPernikahanDini);
                    $('#tidak_mencegah_pernikahan_dini_wanita').html(response.wanita
                        .totalTidakMencegahPernikahanDini);
                },
            })
        }

        function initializeFilter() {
            initializeMap(mapOnZoom, centerMap);
            randaKabilasa(mapOnZoom);
        }
    </script>

    <script>
        $('#m-link-peta-data').addClass('active');
        $('#menu-peta-data').addClass('collapse show')
        $('#ms-link-peta-randa-kabilasa').addClass('active')
    </script>
@endpush
