<!doctype html>
<html lang="en">

<head>
    <style type="text/css">
        #mapid { height: 400px;width: 100%; }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
            crossorigin=""></script>
</head>

<body>
<div id="mapid"></div>

<script>
    var am_in_lat = "<?php echo $am_in_lat; ?>";
    var am_in_lon = "<?php echo $am_in_lon; ?>";
    var am_in_time = "<?php echo '<b>'.$am_in_time.'</b>'; ?>";

    var am_out_lat = "<?php echo $am_out_lat; ?>";
    var am_out_lon = "<?php echo $am_out_lon; ?>";
    var am_out_time = "<?php echo '<b>'.$am_out_time.'</b>'; ?>";

    var pm_in_lat = "<?php echo $pm_in_lat; ?>";
    var pm_in_lon = "<?php echo $pm_in_lon; ?>";
    var pm_in_time = "<?php echo '<b>'.$pm_in_time.'</b>'; ?>";

    var pm_out_lat = "<?php echo $pm_out_lat; ?>";
    var pm_out_lon = "<?php echo $pm_out_lon; ?>";
    var pm_out_time = "<?php echo '<b>'.$pm_out_time.'</b>'; ?>";

    var mymap = "";
    if(am_in_lat && am_in_lon){
        console.log(am_in_lat);
        console.log(am_in_lon);
        mymap = L.map('mapid').setView([am_in_lat, am_in_lon], 25);
    }
    else if(am_out_lat && am_out_lon){
        console.log(am_out_lat);
        console.log(am_out_lon);
        mymap = L.map('mapid').setView([am_out_lat, am_out_lon], 25);
    }
    else if(pm_in_lat && pm_in_lon){
        console.log(pm_in_lat);
        console.log(pm_in_lon);
        mymap = L.map('mapid').setView([pm_in_lat, pm_in_lon], 25);
    }
    else if(pm_out_lat && pm_out_lon){
        console.log(pm_out_lat);
        console.log(pm_out_lon);
        mymap = L.map('mapid').setView([pm_out_lat, pm_out_lon], 25);
    }

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1
    }).addTo(mymap);

    if( am_in_lat != "empty" && am_in_lat != null && am_in_lon != "empty" && am_in_lon != null ) {
        L.marker([am_in_lat, am_in_lon]).addTo(mymap)
            .bindPopup(am_in_time).openPopup();
        var popup = L.popup();
        mymap.on('click', onMapClick);
    }

    if( am_out_lat != "empty" && am_out_lat != null && am_out_lon != "empty" && am_out_lon != null ) {
        console.log("am_out_2");
        L.marker([am_out_lat, am_out_lon]).addTo(mymap)
            .bindPopup(am_out_time).openPopup();
        var popup = L.popup();
        mymap.on('click', onMapClick);
    }

    if( pm_in_lat != "empty" && pm_in_lat != null && pm_in_lon != "empty" && pm_out_lon != null ){
        console.log("pm_in_2");
        L.marker([pm_in_lat, pm_in_lon]).addTo(mymap)
            .bindPopup(pm_in_time).openPopup();
        var popup = L.popup();
        mymap.on('click', onMapClick);
    }

    if( pm_out_lat != "empty" && pm_out_lat != null && pm_out_lon != "empty" && pm_out_lon != null ) {
        console.log("pm_out_2");
        L.marker([pm_out_lat, pm_out_lon]).addTo(mymap)
            .bindPopup(pm_out_time).openPopup();
        var popup = L.popup();
        mymap.on('click', onMapClick);
    }

    function onMapClick(e) {
        popup
            .setLatLng(e.latlng)
            .setContent("You clicked the map at " + e.latlng.toString())
            .openOn(mymap);
    }


</script>
</body>

</html>
