
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="author" content="Lourence Rex B. Traya">
    <meta name="author" content="Rusel Tayong">
    <meta name="author" content="Department of Health Region 7">
    <link rel="icon" href="{{ asset('public/img/favicon.png') }}">
    <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>HRMIS</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('public/admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('public/admin/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('public/admin/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/admin/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('public/admin/dist/css/skins/_all-skins.min.css') }}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{{ asset('public/admin/bower_components/morris.js/morris.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('public/admin/bower_components/jvectormap/jquery-jvectormap.css') }}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('public/admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('public/admin/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{ asset('public/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugin/bootstrap3-editable/css/bootstrap-editable.css') }}" />

    <style>
        body {
            background: url('{{ asset('public/img/backdrop.png') }}'), -webkit-gradient(radial, center center, 0, center center, 460, from(#ccc), to(#ddd));
        }
        .color-palette {
            height: 35px;
            line-height: 35px;
            text-align: center;
        }

        .color-palette-set {
            margin-bottom: 15px;
        }

        .color-palette span {
            display: none;
            font-size: 12px;
        }

        .color-palette:hover span {
            display: block;
        }

        .color-palette-box h4 {
            position: absolute;
            top: 100%;
            left: 25px;
            margin-top: -40px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 12px;
            display: block;
            z-index: 7;
        }
    </style>

    @section('css')

    @show
    @section('head-js')
    <!--DATE RANGE-->
    @show
</head>

<body  class="ng-cloak ">
<div class="loading"></div>

<!-- Fixed navbar -->

<nav class="navbar navbar-default navbar-static-top">
    <div class="header" style="background-color:#2F4054;padding:10px;">
        <div class="col-md-4">
            <span class="title-info">Welcome,</span> <span class="title-desc">{{ Auth::user()->fname }} {{ Auth::user()->lname }}</span>
        </div>
        <div class="col-md-4">
            <span class="title-info">Location:</span>
            <span class="title-desc">
                @if(Auth::user()->usertype == 0 || Auth::user()->usertype == 1)
                    Cebu
                @elseif(Auth::user()->usertype == 2 || Auth::user()->usertype == 3)
                    Negros
                @elseif(Auth::user()->usertype == 4 || Auth::user()->usertype == 5)
                    Bohol
                @endif
            </span>
        </div>
        <div class="col-md-4">
            <span class="title-info">Date:</span> <span class="title-desc">{{ date('M d, Y') }}</span>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="header" style="background-color:#9C8AA5	;padding:10px;">
        <div class="container">
            <img src="{{ asset('public/img/banner2019.png') }}" class="img-responsive" />
        </div>
    </div>
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"></a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            @if(Auth::user()->usertype == "1")
                @include('layouts.admin-menu')
            @elseif(Auth::user()->usertype == "0" || Auth::user()->usertype == '2' || Auth::user()->usertype == '4')
                @include('layouts.personal')
            @elseif(Auth::user()->usertype == "3" || Auth::user()->usertype == '5')
                @include('layouts.menu-sub-admin')
            @endif
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">
    <div class="loading"></div>
    @yield('content')
    <div class="clearfix"></div>
    @include('modal1')
</div> <!-- /container -->
<footer class="footer">
    <div class="container">
        <p>Copyright &copy; 2017 DOH-RO7 All rights reserved</p>
    </div>
</footer>

<!-- jQuery 3 -->
<script src="{{ asset('public/admin/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('public/admin/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('public/admin/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Morris.js charts -->
<script src="{{ asset('public/admin/bower_components/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('public/admin/bower_components/morris.js/morris.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('public/admin/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ asset('public/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('public/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('public/admin/bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('public/admin/bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('public/admin/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<script src="{{ asset('public/admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('public/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ asset('public/admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('public/admin/bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/admin/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('public/admin/dist/js/pages/dashboard.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('public/admin/dist/js/demo.js') }}"></script>

<script src="{{ asset('public/plugin/bootstrap3-editable/js/bootstrap-editable.js') }}"></script>
<script src="{{ asset('public/plugin/bootstrap3-editable/js/bootstrap-editable.min.js') }}"></script>

</body>
</html>
