@extends('layouts.app')
@section('content')
    <div class="box box-info">
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <?php
                            $statusCount = 0;
                            $counter = 0;
                            $color = ['red','aqua','orange','green'];
                            $fa = ['fa-exclamation-circle','fa-smile-o','fa-frown-o','fa-users'];
                            $status = ['pending','approve','cancelled','all'];
                            ?>
                            @foreach($status as $row)
                                <?php $statusCount++; ?>
                                <li class="@if($statusCount == 1){{ 'active' }}@endif">
                                    <a href="#{{ $row }}" class="btn btn-app" data-toggle="tab">
                                        <span class="badge bg-{{ $color[$counter] }} {{ $row }}">0</span>
                                        <i class="fa {{ $fa[$counter] }}"></i> {{ $row }}
                                        <?php $counter++; ?>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="active tab-content">
                            <!--pending-->
                            <div class="active tab-pane" id="pending">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <form class="form-inline" method="POST" action="{{ asset('form/cdo_list') }}" id="searchForm">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" value="{{ Session::get('keyword') }}" id="inputEmail3" name="keyword" style="width: 100%" placeholder="Route no, Reason, Lname">
                                            </div>
                                            <button type="submit" class="btn btn-primary" name="search" id="search" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Printing DTR">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search
                                            </button>
                                            <button type="button" class="btn btn-success users_privilege_modal"><i class="fa fa-plus">Privilege Employee</i></button>
                                        </form>
                                    </div>
                                    <div class="panel-body">
                                        <br />
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="ajax_pending">
                                                    @include('cdo.cdo_pending')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--APPROVE-->
                            <div class="tab-pane" id="approve">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <form class="form-inline" method="POST" action="{{ asset('form/cdo_list') }}" id="searchForm1">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" value="{{ Session::get('keyword') }}" id="inputEmail2" name="keyword" style="width: 100%" placeholder="Route no, Reason, Lname">
                                            </div>
                                            <button type="submit" class="btn btn-primary" name="search" id="search" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Printing DTR">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search
                                            </button>
                                        </form>
                                    </div>
                                    <div class="panel-body">
                                        <br />
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="ajax_approve">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--CANCELLED-->
                            <div class="tab-pane" id="cancelled">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <form class="form-inline" method="POST" action="{{ asset('form/cdo_list') }}" id="searchForm2">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" value="{{ Session::get('keyword') }}" id="inputEmail1" name="keyword" style="width: 100%" placeholder="Route no, Reason, Lname">
                                            </div>
                                            <button type="submit" class="btn btn-primary" name="search" id="search" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Printing DTR">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search
                                            </button>
                                        </form>
                                    </div>
                                    <div class="panel-body">
                                        <br />
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="ajax_cancelled">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--ALL-->
                            <div class="tab-pane" id="all">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <form class="form-inline" method="POST" action="{{ asset('form/cdo_list') }}" id="searchForm3">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" value="{{ Session::get('keyword') }}" id="inputEmail" name="keyword" style="width: 100%" placeholder="Route no, Reason, Lname">
                                            </div>
                                            <button type="submit" class="btn btn-primary" name="search" id="search" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Printing DTR">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search
                                            </button>
                                            @if(!Auth::user()->usertype)
                                                <a href="#document_form" data-link="{{ asset('form/cdov1/form') }}" class="btn btn-success" data-dismiss="modal" data-backdrop="static" data-toggle="modal" data-target="#document_form" style="background-color:#9C8AA5;color: white;"><i class="fa fa-plus"></i> Create new</a>
                                            @endif
                                        </form>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                @if($type == "list")
                                                    <a href="#document_form" data-link="{{ asset('form/cdov1/form') }}" class="btn btn-success" data-dismiss="modal" data-backdrop="static" data-toggle="modal" data-target="#document_form" style="background-color: #9C8AA5;color: white;"><i class="fa fa-plus"></i> Create new</a>
                                                @endif
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="ajax_all">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>

        $(document).ready(function() {
            $(".users_privilege_modal").click(function() {
                $('#users_privilege_modal').modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
                <?php
                $userid = Auth::user()->userid;
                echo "var userid = " . json_encode($userid) . ";";
                ?>

                var url = "<?php echo asset('privilege/list') ?>";
                var json = {
                    'supervisor_id' : userid
                };

                $('.users_privilege_select_body').html(loadingState);
                setTimeout(function(){
                    $.post(url,json,function(result){
                        $('.users_privilege_select_body').html(result);
                    });
                },700);

                $("#supervisor_id").val(userid);
            });
        });

        $("#inclusive3").daterangepicker();
        $('.input-daterange input').each(function() {
            $(this).datepicker("clearDates");
        });
        //document information
        $("a[href='#document_info']").on('click',function(){
            var route_no = $(this).data('route');
            $('.modal_content').html(loadingState);
            $('.modal-title').html('Route #: '+route_no);
            var url = $(this).data('link');
            setTimeout(function(){
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        $('.modal_content').html(data);
                        $('#reservation').daterangepicker();
                        var datePicker = $('body').find('.datepicker');
                        $('input').attr('autocomplete', 'off');
                    }
                });
            },500);
        });

        $("a[href='#document_form']").on('click',function(){
            $('.modal-title').html('CTO');
            var url = $(this).data('link');
            $('.modal_content').html(loadingState);
            setTimeout(function(){
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        $('.modal_content').html(data);
                        $('#reservation').daterangepicker();
                        var datePicker = $('body').find('.datepicker');
                        $('input').attr('autocomplete', 'off');
                    }
                });
            },500);
        });

        $("a[href='#form_type']").on("click",function(){
            <?php
            $asset = asset('form/cdov1');
            $delete = asset('cdo_delete');
            $doc_type = 'CDO';
            ?>
        });

        //default type
        var type = 'pending';
        var keyword = '';
        $(".pending").text(<?php echo count($cdo["count_pending"]); ?>);
        $(".approve").text(<?php echo count($cdo["count_approve"]); ?>);
        $(".cancelled").text(<?php echo count($cdo["count_cancelled"]); ?>);
        $(".all").text(<?php echo count($cdo["count_all"]); ?>);
        $("a[href='#approve']").on("click",function(){
            $("input[name='keyword']").val("");
            $('.ajax_approve').html(loadingState);
            type = 'approve';
            getPosts(1,keyword ='');
            <?php Session::put('keyword',null); ?>
        });
        $("a[href='#pending']").on("click",function(){
            $("input[name='keyword']").val("");
            $('.ajax_pending').html(loadingState);
            $('.input')
            type = 'pending';
            getPosts(1,keyword = '');
            <?php Session::put('keyword',null); ?>
        });
        $("a[href='#cancelled']").on("click",function(){
            $("input[name='keyword']").val("");
            $('.ajax_pending').html(loadingState);
            type = 'cancelled';
            getPosts(1,keyword = '');
            <?php Session::put('keyword',null); ?>
        });
        $("a[href='#all']").on("click",function(){
            $("input[name='keyword']").val("");
            $('.ajax_all').html(loadingState);
            type = 'all';
            getPosts(1,keyword = '');
            <?php Session::put('keyword',null); ?>
        });

        $(window).on('hashchange', function() {
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                } else {
                    getPosts(page,keyword);
                }
            }
        });
        $(document).ready(function() {
            $(document).on('click', '.pagination a', function (e) {
                getPosts($(this).attr('href').split('page=')[1],keyword);
                e.preventDefault();
            });
        });

        $("#searchForm").submit(function(e) {
            keyword = $(this).find("input[name='keyword']").val();
            getPosts(1,keyword);
            return false;
        });
        $("#searchForm1").submit(function(e) {
            keyword = $(this).find("input[name='keyword']").val();
            getPosts(1,keyword);
            return false;
        });
        $("#searchForm2").submit(function(e) {
            keyword = $(this).find("input[name='keyword']").val();
            getPosts(1,keyword);
            return false;
        });
        $("#searchForm3").submit(function(e) {
            keyword = $(this).find("input[name='keyword']").val();
            getPosts(1,keyword);
            return false;
        });



        function getPosts(page,keyword) {
            $.ajax({
                url : '?type='+type+'&page='+page+"&keyword="+keyword,
                type: 'GET',
            }).done(function (result) {

                $('.ajax_'+type).html(loadingState);
                setTimeout(function(){
                    $('.ajax_'+type).html(result);
                },700);

            }).fail(function (data) {
                console.log(data.responseText);
                /*alert('Page could not be loaded... refresh your page.');
                var redirect_url = "<?php echo asset('/'); ?>";
                window.location.href = redirect_url;*/
            });
        }

        function cancel_dates(event) {
            $('#cancel_body').empty();
            var name = event.target.getAttribute('value');
            $('#route').val(name);

                        <?php $routes = cdo::get(); ?>
                        <?php foreach ($routes as $route){ ?>
                    var route = "<?php echo $route->route_no;?>";
                    if(name == route){

                        $(".modal-title").html("Route No:<strong>"+route);
                            <?php $dates = CdoAppliedDate::where('cdo_id', '=', $route->id)->get(); ?>
                        var dateList= [];
                        var dateTime = [];
                            <?php foreach ($dates as $date) {?>
                        var container = document.querySelector("#cancel_date table");
                        var diff = "<?php $diff=(strtotime($date->start_date)-strtotime($date->end_date))/ (60*60*24); echo $diff*-1; ?>";
                        var startDate = new Date("<?php echo date('F j, Y', strtotime($date->start_date)); ?>");
                        var endDate = new Date("<?php echo date('F j, Y', strtotime('-1 day', strtotime($date->end_date))); ?>");
                        console.log("date", startDate);
                        if(diff == 1){
                            dateList.push(startDate.toLocaleDateString());
                            dateTime.push("<?php echo $date->cdo_hours?>");
                        }else{
                            while (startDate <= endDate) {
                                dateList.push(startDate.toLocaleDateString());
                                startDate.setDate(startDate.getDate() + 1);
                                dateTime.push("<?php echo $date->cdo_hours?>");
                            }
                        }
                            <?php }?>
                        var length = dateList.length;
                        var i=0;
                        var cancelAllCheckbox ='<label>Check to Cancel All:</label>'+
                            '<input style="transform: scale(1.5)" type="checkbox" class="minimal" id="applied_dates" value="cancel_all" name="applied_dates" />';
                        container.innerHTML += cancelAllCheckbox;
                        while (length > i) {
                            var html = '<div class="checkbox">' +
                                '<label style="margin-left: 15%">' +
                                '<input type="checkbox" style="transform: scale(1.5)" class="minimal" id="applied_dates" name="applied_dates" value="' + dateList[i] + '"  />' +
                                dateList[i] +
                                '</label><br>' +
                                '<label style="margin-left: 30%; transform: scale(1.2)"><input type="radio" name="time' + i + '" value="cdo_am"  /> AM</label>' +
                                '<label style="margin-left: 10%; transform: scale(1.2)"><input type="radio" name="time' + i + '" value="cdo_pm"  /> PM</label>' +
                                '<label style="margin-left: 10%; transform: scale(1.2)"><input type="radio" name="time' + i + '" value="cdo_wholeday"  /> Whole Day</label>' +
                                '</div>';
                            container.innerHTML += html;
                            i = i + 1;
                        }

                        $('#dates').val(dateList);
                        $('#all_hours').val(dateTime);
                    }
                    <?php }?>

                    $('input[type="checkbox"]').on('change', function () {
                        if ($(this).val() === "cancel_all") {
                            var isChecked = $(this).prop('checked');
                            $('input[name="applied_dates"]').prop('checked', isChecked);
                        }

                        var selectedCheckboxes = [];
                        $('input[name="applied_dates"]:checked').each(function () {
                                selectedCheckboxes.push($(this).val());
                        });
                        $('#selected_date').val(selectedCheckboxes.join(', '));
                    });


            $(document).on('change', 'input[type="radio"]', function () {
                var selectedValues = $('input[type="radio"]:checked').map(function () {
                    return $(this).val();
                }).get();
                selectedValues = selectedValues.filter(function (value) {
                    return value !== "JO";
                });
                $('#cdo_hours').val(selectedValues.join(', '));
            });

            $('input[type="radio"]').on('change', function () {
                var selectedBtn = [];
                $('input[name="time"]:checked').each(function () {
                    selectedBtn.push($(this).val());
                });
                $('#cdo_hours').val(selectedBtn.join(', '));
            });
            $('#cancel_type').val("cto");
        }

        function pending_status(data){
            var page = "<?php echo Session::get('page_pending') ?>";
            var url = $("#cdo_updatev1").data('link')+'/'+data.val()+'/pending?page='+page;
            $.post(url,function(result){
                //$('.ajax_pending').html(loadingState);
                setTimeout(function(){
                    if(result['count_pending'] && !result['paginate_pending']){
//                        console.log("asin1");
                        getPosts(page-1,'');
                    }
                    else {
//                        console.log("asin2");
                        $('.ajax_pending').html(result);
                    }
                    Lobibox.notify('info',{
                        msg:'Approve!'
                    });

                    var pendingCount = parseInt($(".pending").text()) - 1;
                    var approveCount = parseInt($(".approve").text()) + 1;

                    $(".pending").html(pendingCount);
                    $(".approve").html(approveCount);

                },700);
            });
        }

        function click_all(type){
            var url = "<?php echo asset('click_all');?>"+"/"+type.val();
            $.get(url,function(result){
                if(type.val() == 'pending'){
                    $('.ajax_approve').html(loadingState);
                    setTimeout(function(){
                        Lobibox.notify('error',{
                            msg:'pending!'
                        });
                        $('.ajax_approve').html(result['view']);
                        $(".pending").html(result['pending']);
                        $(".approve").html(result['approve']);
                    },700);
                }
                else if(type.val() == 'approve'){
                    $('.ajax_pending').html(loadingState);
                    setTimeout(function(){
                        Lobibox.notify('info',{
                            msg:'Approve!'
                        });
                        $('.ajax_pending').html(result['view']);
                        $(".pending").html(result['pending']);
                        $(".approve").html(result['approve']);
                    },700);
                }
            });
        }

        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });

        $('#click_approve').on('ifChecked', function(event){
            $(".button").html("<button type='button' value='approve' onclick='click_all($(this))' class='btn-group-sm btn-info'><i class='fa fa-smile-o'></i> Approve all cdo/cto</button>");
        });
        $('#click_approve').on('ifUnchecked', function(event){
            $(".button").html("");
        });
    </script>
@endsection