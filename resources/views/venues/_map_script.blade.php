<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        mapboxgl.accessToken = 'pk.eyJ1IjoianVsaWVuYm91cmRlYXUiLCJhIjoiY2szMnlxa2E2MGFwazNpbXE0YTB5enpkNyJ9.B1h5q4L-OZRtrcv0vutGqA';

        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/light-v10',
            zoom: 12,
            center: [{{ $venue->lng }}, {{ $venue->lat }}]
        });

        map.on('load', function () {
            // Add a layer showing the places.
            map.addLayer({
                "id": "places",
                "type": "symbol",
                "source": {
                    "type": "geojson",
                    "data": {
                        "type": "FeatureCollection",
                        "features": {!! json_encode($venues->toMapPoints()) !!}
                    }
                },
                "layout": {
                    "icon-image": "{icon}-15",
                    "icon-allow-overlap": true
                }
            });

            // When a click event occurs on a feature in the places layer, open a popup at the
            // location of the feature, with description HTML from its properties.
            map.on('click', 'places', function (e) {
                var coordinates = e.features[0].geometry.coordinates.slice();
                var description = e.features[0].properties.description;

                // Ensure that if the map is zoomed out such that multiple
                // copies of the feature are visible, the popup appears
                // over the copy being pointed to.
                while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                    coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                }

                new mapboxgl.Popup()
                    .setLngLat(coordinates)
                    .setHTML(description)
                    .addTo(map);
            });

            // Change the cursor to a pointer when the mouse is over the places layer.
            map.on('mouseenter', 'places', function () {
                map.getCanvas().style.cursor = 'pointer';
            });

            // Change it back to a pointer when it leaves.
            map.on('mouseleave', 'places', function () {
                map.getCanvas().style.cursor = '';
            });
        });
    });
</script>
