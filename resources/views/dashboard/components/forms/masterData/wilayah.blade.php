    @push('style')
        <style>
            #map {
                height: 600px;
                margin-top: 0px;
            }

        </style>
    @endpush

    <form method="POST" id="{{ $idForm ?? '' }}">
        @csrf
        @if ($method == 'PUT')
            @method("PUT")
        @else
            @method("POST")
        @endif

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
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div id="map"></div>
                                <span class="badge bg-danger mt-2 d-none polygon-error"></span>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form class="row g-3">
                                            <div class="col-12">
                                                <label for="TextInput"
                                                    class="form-label">{{ $title }}</label>
                                                <input type="text" class="form-control" name="nama" id="nama"
                                                    value="{{ $data->nama ?? '' }}">
                                                <span class="badge bg-danger mt-2 d-none nama-error"></span>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label for="textareaInput" class="form-label">Warna</label>
                                                <input type="color" id="warna" class="form-control form-control-color"
                                                    value="{{ $data->warna_polygon ?? '' }}" title="Choose your color"
                                                    name="warna_polygon">
                                                <span class="badge bg-danger mt-2 d-none warna_polygon-error"></span>

                                            </div>
                                            <div class="col-12 d-none">
                                                <label for="textareaInput" class="form-label">Polygon</label>
                                                <textarea name="polygon" cols="30" rows="5" class="form-control" id="polygon">{!! $data->polygon ?? '' !!}</textarea>
                                            </div>
                                            <div class="col-12 d-flex justify-content-end mt-3">
                                                @component('dashboard.components.buttons.submit', [
                                                    'label' => 'Simpan',
                                                    ])
                                                @endcomponent
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @push('script')
        <script>
            var warna = $('#warna').val();
            var center = [-0.8794398, 119.8251756];

            var map = L.map("map").setView(center, 11);

            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: 'Data © <a href="http://osm.org/copyright">OpenStreetMap</a>',
                maxZoom: 18,
            }).addTo(map);

            var drawnItems = new L.FeatureGroup();

            map.addLayer(drawnItems);
            map.addControl(new L.Control.Fullscreen());

            var drawControl = new L.Control.Draw({
                position: "topright",
                draw: {
                    polygon: {
                        shapeOptions: {
                            color: warna,
                        },
                        allowIntersection: false,
                        drawError: {
                            color: "orange",
                            timeout: 1000,
                        },
                        showArea: true,
                        metric: false,
                    },
                    polyline: false,
                    circlemarker: false,
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
                    circlemarker: false,
                    rectangle: false,
                    circle: false,
                    marker: false,
                },
                edit: {
                    featureGroup: drawnItems,
                    edit: false,
                },
            });
        </script>

        @if ($method == 'PUT')
            <script>
                $(document).ready(function() {
                    $('#polygon').val('{!! $data->polygon !!}');
                    $('#nama').val('{{ $data->nama }}');
                });

                if ("{{ $data->polygon }}") {
                    $.ajax({
                        url: "{{ $url }}",
                        type: "GET",
                        data: {
                            id: '{{ $data->id }}'
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                L.polygon(response.data.koordinatPolygon, {
                                        color: response.data.warna_polygon,
                                        weight: 1,
                                        opacity: 1,
                                        fillOpacity: 0.5
                                    })
                                    .addTo(drawnItems);
                            }
                        },
                    })
                    map.addControl(drawControlEdit);
                } else {
                    map.addControl(drawControl);
                }
            </script>
        @else
            <script>
                map.addControl(drawControl);
            </script>
        @endif

        <script>
            map.on("draw:created", function(e) {
                var type = e.layerType,
                    layer = e.layer;
                drawnItems.addLayer(layer);
                drawControl.removeFrom(map);
                drawControlEdit.addTo(map);
                $("#polygon").val(JSON.stringify(layer._latlngs));
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
    @endpush
