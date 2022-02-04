@extends('layouts.app')
@section('content')

<div class="panel panel-default" style="height: 1000px;">
    <div class="panel-heading"><strong class="text-orange" style="font-size: 15pt;">{{ ucfirst($province) }}:</strong> <strong style="font-size:medium;">{{ $area->name }}</strong>
        <div class="panel-body">
            <div id="map"></div>
        </div>
    </div>
</div>

@endsection
@section('js')
    <script>
        $("#container").removeClass("container");
        $("#map").height($(window).height()).width($(window).width());

        var latitude = <?php echo $area->latitude;?>;
        var longitude = <?php echo $area->longitude;?>;
        var radius = <?php echo $area->radius;?>;

        var area = L.map("map").setView([latitude, longitude], 25);
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/streets-v11',
            zoomOffset: -1,
            tileSize: 512,
            accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw'
        }).addTo(area);
        
        L.circle([latitude, longitude], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: radius
        }).addTo(area);

        L.marker([latitude, longitude]).addTo(area);
        $("#map").val(area);
    </script>
@endsection