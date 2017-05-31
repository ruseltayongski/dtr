<html>
<style type="text/css">
    .barcode {
        @if($size=='letter')
        top: 960px;
        @elseif($size=='a4')
        top: 1030px;
        @elseif($size=='legal')
        top: 1255px;
        @endif
        position: relative;
        left: -50%;
    }
    .route_no {
        font-size: 1em;
        text-align:center;
    }
</style>
<title>{{ Session::get('route_no') }}</title>
<body>
<div style="position: absolute; left: 50%;">
    <div class="barcode">
        <font class="route_no">{{ Session::get('route_no') }}</font>
        <?php echo DNS1D::getBarcodeHTML(Session::get('route_no'),"C39E",1,15) ?>
    </div>
</div>
</body>
</html>