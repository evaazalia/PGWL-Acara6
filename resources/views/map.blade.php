@extends('layouts.template')

@section('styles')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />

    {{-- leaflet draw css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">

    <style>
        /* full height map container */
        #map {
            --navbar-height: 56px;
            height: calc(100vh);
            width: 100%;
            margin: 0;
            padding: 0;
        }

        body,
        html {
            height: 100%;
            margin: 0;
        }
    </style>
@endsection

@section('content')
    <div id="map"></div>
    {{-- modal input point --}}
    <div class="modal" tabindex="-1" id="modalInputPoint">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Point</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('point.store')}}" method="post">
                    @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Fill name">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" placeholder="Fill description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="geometry_point" class="form-label">Geometry</label>
                        <textarea class="form-control" id="geometry_point" name="geometry_point" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- modal input polyline --}}
    <div class="modal" tabindex="-1" id="modalInputPolyline">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Polyline</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('polyline.store')}}" method="post">
                    @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Fill name">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" placeholder="Fill description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="geometry_polyline" class="form-label">Geometry</label>
                        <textarea class="form-control" id="geometry_polyline" name="geometry_polyline" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- modal input polygon --}}
    <div class="modal" tabindex="-1" id="modalInputPolygon">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Input Polygon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('polygon.store')}}" method="post">
                    @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Fill name">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" placeholder="Fill description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="geometry_polygon" class="form-label">Geometry</label>
                        <textarea class="form-control" id="geometry_polygon" name="geometry_polygon" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

    {{-- leaflet draw js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

    {{-- terraformer js --}}
    <script src="https://unpkg.com/@terraformer/wkt"></script>

    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        // initialize map centered on Yogyakarta
        var map = L.map('map').setView([-7.795580, 110.369490], 12);

        // add OpenStreetMap basemap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        /* Digitize Function */
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        var drawControl = new L.Control.Draw({
            draw: {
                position: 'topleft',
                polyline: true,
                polygon: true,
                rectangle: true,
                circle: false,
                marker: true,
                circlemarker: false
            },
            edit: false
        });

        map.addControl(drawControl);

        map.on('draw:created', function(e) {
            var type = e.layerType,
                layer = e.layer;

            console.log(type);

            var drawnJSONObject = layer.toGeoJSON();
            var objectGeometry = Terraformer.geojsonToWKT(drawnJSONObject.geometry);

            console.log(drawnJSONObject);
            console.log(objectGeometry);

            if (type === 'polyline') {
                console.log("Create " + type);
                // set value geometry to geometry_polyline textarea
                $('#geometry_polyline').val(objectGeometry);

                // show modal input polyline
                $('#modalInputPolyline').modal('show');

                // modal dismiss reload page
                $('#modalInputPolyline').on('hidden.bs.modal', function() {
                    location.reload();
                });

            } else if (type === 'polygon' || type === 'rectangle') {
                console.log("Create " + type);
                // set value geometry to geometry_polygon textarea
                $('#geometry_polygon').val(objectGeometry);

                // show modal input polygon
                $('#modalInputPolygon').modal('show');

                // modal dismiss reload page
                $('#modalInputPolygon').on('hidden.bs.modal', function() {
                    location.reload();
                });

            } else if (type === 'marker') {
                console.log("Create " + type);
                // set value geometry to geometry_point textarea
                $('#geometry_point').val(objectGeometry);

                // show modal input point
                $('#modalInputPoint').modal('show');

                // modal dismiss reload page
                $('#modalInputPoint').on('hidden.bs.modal', function() {
                    location.reload();
                });
            } else {
                console.log('__undefined__');
            }

            drawnItems.addLayer(layer);
        });
    </script>
@endsection
