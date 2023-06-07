
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
    <meta http-equiv="cache-control" content="max-age=0" />
    <title>HRMIS</title>

    <!-- SELECT 2 i top para dile mausab ang color-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugin/select2/select2.min.css') }}" />

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('public/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/css/font-awesome.min.css') }}" rel="stylesheet">

    <link href="{{ asset('public/assets/css/AdminLTE.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/plugin/dist/css/google-font.css') }}" rel="stylesheet">

    @if(Request::segments()[0] == "work-schedule")
        <link rel="stylesheet" type="text/css" href="{{ asset('public/plugin/datatables/datatables.min.css') }}" />

    @endif

    <!--CHOSEN SELECT -->
    <link href="{{ asset('public/plugin/chosen/chosen.css') }}" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{ asset('public/assets/css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('public/plugin/iCheck/square/blue.css') }}">

    <!-- Custom styles for this template -->
    <link href="{{ asset('public/assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugin/Lobibox new/css/lobibox.css') }}" />

    <!-- handsontable.css -->
    <link href="{{ asset('public/assets/css/handsontable.css') }}" rel="stylesheet">

    <!-- wysihtml5 -->
    <link href="{{ asset('public/plugin/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet">
    <!-- bootstrap datepicker -->
    <!--DATE RANGE-->
    <link href="{{ asset('public/plugin/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugin/clockpicker/dist/jquery-clockpicker.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugin/clockpicker/dist/bootstrap-clockpicker.min.css') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/datepicer/css/bootstrap-datepicker3.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/datepicer/css/bootstrap-datepicker3.standalone.css') }}" />

    <!-- Leaflet.js -->
    <link rel="stylesheet" href="{{ asset('public/admin/leaflet/leaflet.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugin/bootstrap3-editable/css/bootstrap-editable.css') }}" />



    @if(Request::segments()[0] == "calendar")
        <link href="{{ asset('public/plugin/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet">
        <link href="{{ asset('public/plugin/fullcalendar/fullcalendar.print.css') }}" media="print">
        <style>
            .tooltipevent{padding:0;margin:0;font-size:75%;text-align:center;position:absolute;bottom:0;opacity:.8;width:350px;height:30px;background:#ccc;position:absolute;z-index:10001;}
        </style>
        <!-- Theme style -->
        <link href="{{ asset('public/plugin/dist/css/AdminLTE.min.css') }}" rel="stylesheet">
    @endif

    <style>
        body {
            background: url('{{ asset('public/img/backdrop.png') }}'), -webkit-gradient(radial, center center, 0, center center, 460, from(#ccc), to(#ddd));
        }
        /*go top scroll up*/
        #myBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            font-size: 18px;
            border: none;
            outline: none;
            background-color: rgba(38, 125, 61, 0.92);
            color: white;
            cursor: pointer;
            padding: 15px;
            border-radius: 4px;
        }
        #myBtn:hover {
            background-color: #555;
        }

        #map { 
            height: 450px;
        }
        /*end go top scroll up*/
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
    <div class="header" style="background-color:#2F4054;padding:10px;color: white">
        <div class="col-md-4">
            <span class="title-info">Welcome, </span> <span class="title-desc">{{ Auth::user()->fname }} {{ Auth::user()->lname }}</span>
        </div>
        <div class="col-md-4">
            <span class="title-desc">
                @if(Auth::user()->usertype == 0 || Auth::user()->usertype == 1)
                    {{ strtoupper(Session::get('region') == 'region_8' ? 'Region 8' : 'cebu province') }}
                @elseif(Auth::user()->usertype == 2 || Auth::user()->usertype == 3)
                    NEGROS PROVINCE
                @elseif(Auth::user()->usertype == 4 || Auth::user()->usertype == 5)
                    BOHOL PROVINCE
                @endif
            </span>
        </div>
        <div class="col-md-4 text-right">
            <span class="title-desc"> {{ Auth::user()->usertype ? 'ADMIN' : 'STANDARD' }} USER</span>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="header" style="background-color:#846c90	;padding:10px;">
        <div class="container">
            @if(Session::get('region') == 'region_8')
                <img src="{{ asset('public/img/reg8_banner.png') }}" class="img-responsive" />
            @else
                <img src="{{ asset('public/img/banner_dtr2023v1.png') }}" class="img-responsive" />
            @endif
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

<div class="container" id="container" style="background-color: white;padding: 1%">
    <div class="loading"></div>
    @yield('content')
    <div class="clearfix"></div>
    @include('modal')
</div> <!-- /container -->
<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-arrow-up"></i></button>

<footer class="footer">
    <div class="container">
        <p>Copyright &copy; 2017 DOH-RO7 All rights reserved</p>
    </div>
</footer>

        <!-- Bootstrap core JavaScript
    ================================================== -->
<script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('public/plugin/datatables/datatables.min.js') }}"></script>

<!-- DATE RANGE SELECT -->

<script src="{{ asset('public/plugin/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('public/plugin/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('public/plugin/Lobibox new/js/Lobibox.js') }}"></script>
<script src="{{ asset('public/assets/js/jquery-validate.js') }}"></script>
<script src="{{ asset('public/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/assets/datepicer/js/bootstrap-datepicker.js') }}"></script>
<!-- CLOCK PICKER -->
<script src="{{ asset('public/plugin/clockpicker/dist/jquery-clockpicker.min.js') }}"></script>
<script src="{{ asset('public/plugin/clockpicker/dist/bootstrap-clockpicker.min.js') }}"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="{{ asset('public/assets/js/ie10-viewport-bug-workaround.js') }}"></script>

<!-- bootstrap datepicker -->
<script src="{{ asset('public/assets/js/script.js') }}?v=2"></script>
<script src="{{ asset('public/assets/js/form-justification.js') }}"></script>
<script src="{{ asset('public/plugin/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>

<!-- SELECT 2 -->
<script src="{{ asset('public/plugin/select2/select2.full.min.js') }}"></script>
<!-- CHOSEN SELECT -->
<script src="{{ asset('public/plugin/chosen/chosen.jquery.js') }}"></script>

<script src="{{ asset('public/plugin/fullcalendar/moment.js') }}"></script>
<script src="{{ asset('public/plugin/fullcalendar/fullcalendar.min.js') }}"></script>

<!-- iCheck -->
<script src="{{ asset('public/plugin/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('public/plugin/bootstrap3-editable/js/bootstrap-editable.js') }}"></script>
<script src="{{ asset('public/plugin/bootstrap3-editable/js/bootstrap-editable.min.js') }}"></script>

<script src="{{ asset('public/assets/js/handsontable.js') }}"></script>

<script src="{{ asset('public/admin/leaflet/leaflet.js') }}"></script>

<script>var loadingState = '<center><img src="{{ asset('public/img/spin.gif') }}" width="150" style="padding:20px;"></center>'; </script>

<script>
    $("#absent").daterangepicker();
    $('.create-absent').click(function(){
        var url = $(this).data('link');
        $('.modal_content').html('');
        $('.loading').show();
        setTimeout(function (){
            $.get(url, function(data){
                $('.loading').hide();
                $('.modal_content').html(data);

            });
        },1000);
    });

    function select_absent(element)
    {

        var val = $(element).val();
        if(val == "SO")
        {

            $('#desc').removeAttr('disabled');
        } else if(val == "LEAVE") {
            $('#desc').prop('disabled',true);
        } else if(val == "CTO") {

        }
    }

    var urlParams = new URLSearchParams(window.location.search);
    var query_string = urlParams.get('search') ? urlParams.get('search') : '';
    $(".pagination").children().each(function(index){
        var _href = $($(this).children().get(0)).attr('href');
        $($(this).children().get(0)).attr('href',_href+'&search='+query_string);
    });

    //Get the button
    var mybutton = document.getElementById("myBtn");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        $('body,html').animate({
            scrollTop : 0 // Scroll to top of body
        }, 500);
    }

</script>
@section('js')

@show


@if(Session::get('app_version_post'))
    <script>
        Lobibox.notify('success',{
            size:'mini',
            title:'',
            msg:'Successfully Updated!'
        });
    </script>
    <?php Session::forget('app_version_post'); ?>
@endif
@if(Session::get('announcement_post'))
    <script>
        Lobibox.notify('success',{
            size:'mini',
            title:'',
            msg:'Successfully Updated!'
        });
    </script>
    <?php Session::forget('announcement_post'); ?>
@endif

@if(Session::get('added'))
    <script>
        Lobibox.notify('success',{
            msg:'Successfully Added!'
        });
    </script>
    <?php Session::forget('added'); ?>
@endif
@if(Session::get('updatedUser'))
    <script>
        Lobibox.notify('success',{
            msg:'Successfully Updated!'
        });
    </script>
    <?php Session::forget('updatedUser'); ?>
@endif
@if(Session::get('deleted'))
    <script>
        Lobibox.notify('error',{
            size:'mini',
            title:'',
            msg:'Successfully Deleted!'
        });
    </script>
    <?php Session::forget('deleted'); ?>
@endif
@if(Session::get('approved_leave'))
    <script>
        Lobibox.notify('success',{
            size:'mini',
            title:'',
            msg:'Leave application successfully approved!'
        });
    </script>
    <?php Session::forget('approved_leave'); ?>
@endif
@if(Session::get('update_leave_balance'))
    <script>
        Lobibox.notify('success',{
            size:'mini',
            title:'',
            msg:'Leave credit successfully updated!'
        });
    </script>
    <?php Session::forget('update_leave_balance'); ?>
@endif
@if(Session::get('disapproved_leave'))
    <script>
        Lobibox.notify('error',{
            size:'mini',
            title:'',
            msg:'Leave application disapproved!'
        });
    </script>
    <?php Session::forget('disapproved_leave'); ?>
@endif
@if(Session::get('pending_leave'))
    <script>
        Lobibox.notify('info',{
            size:'mini',
            title:'',
            msg:'Leave application set to pending!'
        });
    </script>
    <?php Session::forget('pending_leave'); ?>
@endif
@if(Session::get('updated'))
    <script>
        Lobibox.notify('info',{
            msg:'Successfully Updated!'
        });
    </script>
    <?php Session::forget('updated'); ?>
@endif
@if(Session::get('absent'))
    <script>
        Lobibox.notify('error',{
            msg:'Successfully Absent!'
        });
    </script>
    <?php Session::forget('absent'); ?>
@endif
@if(Session::get('msg'))
    <script>
        var msg = <?php echo "'". Session::get('msg') ."';"; ?>
        Lobibox.notify('info',{
            msg:msg
        });
    </script>
    <?php Session::forget('msg'); ?>
@endif
@if(Session::get('upload_logs'))
    <script>
        Lobibox.notify('success',{
            msg:'Successfully uploaded logs!'
        });
    </script>
    <?php Session::forget('upload_logs'); ?>
@endif
@if(Session::get('superviseAdd'))
    <script>
        Lobibox.notify('success',{
            size:'mini',
            title:'',
            msg:'Success!'
        });
    </script>
    <?php Session::forget('superviseAdd'); ?>
@endif
</body>
</html>
