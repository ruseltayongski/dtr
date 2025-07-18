<html>
<head>
    <style>
        .center {
            margin: auto;
            width: 60%;
            border: 3px solid #73AD21;
            padding: 10px;
        }
    </style>
</head>
<body>

<a href="{{ asset('public/apk/version_4/dtr.apk') }}"><i class="fa fa-mobile-phone"></i>
    <div class="center">
        <center>
             <b style="font-size: 20pt;">Mobile DTR(apk) v{{ $version->latest_version }}</b>
        </center>
    </div>
</a>

</body>
</html>