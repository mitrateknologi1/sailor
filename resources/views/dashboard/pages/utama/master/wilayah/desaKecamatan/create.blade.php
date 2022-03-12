@extends('dashboard.layouts.main')

@section('title')
    Tambah Desa / Kelurahan
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
            <li class="breadcrumb-item active" aria-current="page">Prov. Sulawesi Tengah</li>
            <li class="breadcrumb-item active" aria-current="page">Kab. Parigi Moutong</li>
            <li class="breadcrumb-item active" aria-current="page">Kec. Parigi</li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Desa</li>
        </ol>
    </div>
@endsection

@section('content')
    <div class="row g-1">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title m-0">Peta</h6>
                    <div class="dropdown morphing scale-left">
                        <a href="#" class="card-fullscreen" data-bs-toggle="tooltip" title=""
                            data-bs-original-title="Card Full-Screen" aria-label="Card Full-Screen"><i
                                class="icon-size-fullscreen"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-12">
                            <div id="map"></div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <form class="row g-3">
                                        <div class="col-12">
                                            <label for="TextInput" class="form-label">Desa / Kecamatan</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="col-12">
                                            <label for="textareaInput" class="form-label">Warna</label>
                                            <input type="color" id="warna" class="form-control form-control-color"
                                                value="#563d7c" title="Choose your color">
                                        </div>
                                        <div class="col-12">
                                            <label for="textareaInput" class="form-label">Polygon</label>
                                            <textarea name="" cols="30" rows="5" class="form-control"
                                                id="polygon"></textarea>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- .row end -->
@endsection

@push('script')
    <script>
        var warna = $('#warna').val();
        var center = [-0.8037181, 120.1707766];
        // Create the map
        var map = L.map("map").setView(center, 15);
        // Set up the Open Street Map layer
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: 'Data © <a href="http://osm.org/copyright">OpenStreetMap</a>',
            maxZoom: 18,
        }).addTo(map);
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        var drawControl = new L.Control.Draw({
            position: "topright",
            draw: {
                polygon: {
                    shapeOptions: {
                        color: warna, //polygons being drawn will be purple color
                    },
                    allowIntersection: false,
                    drawError: {
                        color: "orange",
                        timeout: 1000,
                    },
                    showArea: true, //the area of the polygon will be displayed as it is drawn.
                    metric: false,
                    // repeatMode: true,
                },
                polyline: false,
                circlemarker: false, //circlemarker type has been disabled.
                rectangle: false,
                circle: false,
                marker: false,
            },
            edit: {
                featureGroup: drawnItems,
                edit: false,
            },
        });

        var drawControlEdit = new L.Control.Draw({
            position: "topright",
            draw: {
                polygon: false,
                polyline: false,
                circlemarker: false, //circlemarker type has been disabled.
                rectangle: false,
                circle: false,
                marker: false,
            },
            edit: {
                featureGroup: drawnItems,
                edit: false,
            },
        });

        map.addControl(drawControl);
        map.on("draw:created", function(e) {
            var type = e.layerType,
                layer = e.layer;
            drawnItems.addLayer(layer);
            console.log(JSON.stringify(layer.toGeoJSON()));
            drawControl.removeFrom(map);
            drawControlEdit.addTo(map);
            $("#polygon").val(JSON.stringify(layer.toGeoJSON())); //saving the layer to the input field using jQuery
        });

        map.on("draw:deleted", function(e) {
            drawControlEdit.removeFrom(map);
            drawControl.addTo(map);
            $("#polygon").val("");
        });
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
        $('#m-link-wilayah').addClass('active');
    </script>
@endpush
