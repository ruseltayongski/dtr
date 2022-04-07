@if(count($areas) > 0)
    <!-- Leaflet.js -->
    <link rel="stylesheet" href="{{ asset('public/admin/leaflet/leaflet.css') }}">

    <style>
        #map { height: 1000px; }
    </style>

    <div id="map"></div>


    <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/admin/leaflet/leaflet.js') }}"></script>

    <script>
        /*$("#map").height($(window).height()).width($(window).width());*/

        var latitude = <?php echo isset($latitude) ? $latitude : $areas[0]->latitude;?>;
        var longitude = <?php echo isset($longitude) ? $longitude : $areas[0]->longitude ;?>;

        var area = L.map("map").setView([latitude, longitude], 25);
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/streets-v11',
            zoomOffset: -1,
            tileSize: 512,
            accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw'
        }).addTo(area);

        $.each(<?php echo $areas;?>,function(index){
            L.circle([this.latitude, this.longitude], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: this.radius
            }).addTo(area);
        });

        L.marker([latitude, longitude]).addTo(area);
        $("#map").val(area);
    </script>
@else
    <h1>NO AREA OF ASSIGNMENT</h1>
@endif




