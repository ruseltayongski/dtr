@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><strong style="font-size:medium;">{{ $area->name }}</strong></div>
                <div class="panel-body">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
    <script>
        var latitude = <?php echo $area->latitude;?>;
        var longitude = <?php echo $area->longitude;?>;
        var radius = <?php echo $area->radius;?>;

        var area = L.map("map").setView([latitude, longitude], 17);
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox/streets-v11',
            zoomOffset: -1,
            tileSize: 512,
            accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw'
        }).addTo(area);
        
        var circle = L.circle([latitude, longitude], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: radius
        }).addTo(area);

        L.marker([latitude, longitude]).addTo(area);

        $("#map").val(area);
    </script>
@endsection