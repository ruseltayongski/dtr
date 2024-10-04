@extends('layouts.app')
@section('content')
    <style>
        .chosen-container-single{
            width: 180px !important;
        }
    </style>
    <div class="box box-info">
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <?php
                            $statusCount = 0;
                            $counter = 0;
                            $color = ['yellow','aqua','orange','red','green'];
                            $fa = ['fa-exclamation-circle','fa-smile-o','fa-frown-o','fa-times','fa-users'];
                            $status = ['pending','approve','cancelled','disapprove','all'];
                            ?>
                            @foreach($status as $row)
                                <?php $statusCount++; ?>
                                <li class="@if($statusCount == 1){{ 'active' }}@endif">
                                    <a href="#{{ $row }}" class="btn btn-app" data-toggle="tab">
                                        <span class="badge bg-{{ $color[$counter] }} {{ $row }}">0</span>
                                        <i class="fa {{ $fa[$counter] }}"></i> {{ $row == 'disapprove' ? 'disapproved' : $row }}
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
                                        <form class="form-inline" method="POST" action="{{ asset('form/leave_list') }}" id="searchForm">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" value="{{ Session::get('keyword') }}" id="inputEmail4" name="keyword" style="width: 100%" placeholder="Route no, Reason, Lname">
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
                                                <div class="ajax_pending">
                                                    @include('form.form_pending')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--DISAPPROVED-->
                            <div class="tab-pane" id="disapprove">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <form class="form-inline" method="POST" action="{{ asset('form/leave_list') }}" id="searchForm2">
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
                                                <div class="ajax_disapproved">

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
                                        <form class="form-inline" method="POST" action="{{ asset('form/leave_list') }}" id="searchForm1">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" value="{{ Session::get('keyword') }}" id="inputEmail3" name="keyword" style="width: 100%" placeholder="Route no, Reason, Lname">
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
                                        <form class="form-inline" method="POST" action="{{ asset('form/leave_list') }}" id="searchForm3">
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
                                        <form class="form-inline" method="POST" action="{{ asset('form/leave_list') }}" id="searchForm4">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" value="{{ Session::get('keyword') }}" id="inputEmail" name="keyword" style="width: 100%" placeholder="Route no, Reason, Lname">
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
        //        $("a[href='#document_info']").on('click',function(){
        //            var route_no = $(this).data('route');
        //            $('.modal_content').html(loadingState);
        //            $('.modal-title').html('Route #: '+route_no);
        //            var url = $(this).data('link');
        //            setTimeout(function(){
        //                $.ajax({
        //                    url: url,
        //                    type: 'GET',
        //                    success: function(data) {
        //                        $('.modal_content').html(data);
        //                        $('#reservation').daterangepicker();
        //                        var datePicker = $('body').find('.datepicker');
        //                        $('input').attr('autocomplete', 'off');
        //                    }
        //                });
        //            },1000);
        //        });

        $("#inclusive3").daterangepicker();
        $('.input-daterange input').each(function() {
            $(this).datepicker("clearDates");
        });
        $('a[href="#leave_info').click(function(){
            var id = $(this).data('id');
            var url = $(this).data('link');
            $('.modal-title').html('Route #: '+ $(this).data('route'));

            $.get(url +'/' +id , function(data){
                $('#leave_info').modal('show');
                $('.modal-body_leave').html(data);
            });
        });
        {{--$("a[href='#form_type']").on("click",function(){--}}
        {{--<?php--}}
        {{--$asset = asset('form/cdov1');--}}
        {{--$delete = asset('cdo_delete');--}}
        {{--$doc_type = 'CDO';--}}
        {{--?>--}}
        {{--});--}}

        //default type
        var type = 'pending';
        var keyword = '';
        $(".pending").text(<?php echo count($leave["count_pending"]); ?>);
        $(".approve").text(<?php echo count($leave["count_approve"]); ?>);
        $(".cancelled").text(<?php echo count($leave["count_cancelled"]); ?>);
        $(".disapprove").text(<?php echo count($leave["count_disapproved"]); ?>);
        $(".all").text(<?php echo count($leave["count_all"]); ?>);

        $("a[href='#approve']").on("click",function(){
            console.log('here');
            $("input[name='keyword']").val("");
            $('.ajax_approve').html(loadingState);
            type = 'approve';
            getPosts(1,keyword ='');
            <?php Session::put('keyword',null); ?>
        });

        $("a[href='#disapprove']").on("click",function(){
            console.log('ajax_disapproved content:', loadingState);

            $("input[name='keyword']").val("");
            $('.ajax_disapproved').html(loadingState);
            type = 'disapproved';
            getPosts(1,keyword = '');
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
                console.log('chalidol');
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
        $("#searchForm4").submit(function(e) {
            keyword = $(this).find("input[name='keyword']").val();
            getPosts(1,keyword);
            return false;
        });

        function getPosts(page,keyword) {
            $.ajax({
                url : '?type='+type+'&page='+page+"&keyword="+keyword,
                type: 'GET',
            }).done(function (result) {
                console.log('keyword', keyword);
                $('.ajax_'+type).html(loadingState);
                setTimeout(function(){
                    $('.ajax_'+type).html(result)
                    console.log('result', result);

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
            <?php $routes = Leave::get(); ?>
            <?php foreach ($routes as $route){ ?>
                var route = "<?php echo $route->route_no;?>";
                if(name == route){

                    $(".modal-title").html("Route No:<strong>"+route);
                        <?php $dates = LeaveAppliedDates::where('leave_id', '=', $route->id)->get(); ?>
                    var dateList= [];
                    <?php foreach ($dates as $date) {?>
                        var diff = "<?php $diff=(strtotime($date->startdate)-strtotime($date->enddate))/ (60*60*24); echo $diff*-1; ?>";
                        var startDate = new Date("<?php echo date('F j, Y', strtotime($date->startdate)); ?>");
                        var endDate = new Date("<?php echo date('F j, Y', strtotime($date->enddate)); ?>");
                        console.log("date", startDate);
                        if(diff == 0){
                            dateList.push(startDate.toLocaleDateString());
                        }else{
                            while (startDate <= endDate) {
                                dateList.push(startDate.toLocaleDateString());
                                startDate.setDate(startDate.getDate() + 1);
                            }
                        }
                    <?php }?>
                    var container = document.querySelector("#cancel_date table");
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
                            '</div>';
                        container.innerHTML += html;
                        i = i + 1;
                    }

                    $('#dates').val(dateList);
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
            $('#cancel_type').val("leave");
            $('#route').val(name);
            console.log(name);
        }

        function pending_leave(data, details, userid){

            var route = $(data).data('route');
            $("#leave_route_approved").val(route);
            console.log('result', details);
            var url ="<?php echo asset('leave/approved')?>"+"/"+route;
            $.get(url,function(result) {
                console.log('chaka');
                Lobibox.notify('success', {
                    size: 'mini',
                    title: '',
                    msg: 'Leave application successfully approved!'
                });
                location.reload();
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
        var move_route = '';
        var dateList = [];
        function move_dates(event) {
            $('#move_body').empty();
            var name = event.target.getAttribute('value');
            move_route = name;
            $('#route').val(name);
            $('#move_route').val(name);
            console.log('name', name);

                <?php $routes = Leave::get(); ?>
                <?php foreach ($routes as $route){ ?>
            var route = "<?php echo $route->route_no;?>";
            if(name == route){

                $(".modal-title").html("Route No:<strong>"+route);
                    <?php $dates = LeaveAppliedDates::where('leave_id', '=', $route->id)->where('status', '!=', 1)->get(); ?>
                    <?php foreach ($dates as $date) {?>
                var diff = "<?php $diff=(strtotime($date->startdate)-strtotime($date->enddate))/ (60*60*24); echo $diff*-1; ?>";
                var startDate = new Date("<?php echo date('F j, Y', strtotime($date->startdate)); ?>");
                var endDate = new Date("<?php echo date('F j, Y', strtotime($date->enddate)); ?>");
                console.log("date", startDate);
                if(diff == 0){
                    dateList.push(startDate.toLocaleDateString());
                }else{
                    while (startDate <= endDate) {
                        dateList.push(startDate.toLocaleDateString());
                        startDate.setDate(startDate.getDate() + 1);
                    }
                }
                    <?php }?>
                var length = dateList.length;
                var i=0;

                while(length > i){
                    $('#move_select').append($('<option>', {
                        value: dateList[i],
                        text: dateList[i]
                    }))
                    i++;
                }

                $('.move_datepickerInput').datepicker({
                    autoclose: true
                });

            }
            <?php }?>
            $('#move_select').chosen();


        }

        var result = [];

        function check() {
            $('.for_clone').each(function() {
                var $clone = $(this);
                var date_move = $clone.find('select');
                var move_date = $clone.find('.move_datepickerInput');

                result.push({
                    from_date: date_move.val(),
                    move_date: move_date.val()
                });
            });

            var filteredResult = result.filter(function(item) {
                return item.in_date && item.move_date;
            });

            var latestResult = filteredResult.reduce(function(acc, current) {
                var moveDateParts = current.move_date.split(" - ")[0].split('/');
                var currentMoveDate = new Date(moveDateParts[2], moveDateParts[0] - 1, moveDateParts[1]);

                if (!acc[current.in_date] || currentMoveDate > acc[current.in_date].moveDateObj) {
                    acc[current.in_date] = {
                        move_date: current.move_date,
                        moveDateObj: currentMoveDate
                    };
                }
                return acc;
            }, {});

            var uniqueResult = Object.keys(latestResult).map(function(in_date) {
                return {
                    in_date: in_date,
                    move_date: latestResult[in_date].move_date
                };
            });
        }

        function subsub(){
            check();
            $.ajax({
                type: 'POST',
                url: '/dtr/move_dates',
                data: {
                    _token: '{{ csrf_token() }}',
                    result: result,
                    route_no: move_route,
                    dates: dateList
                },
                success: function(response) {
                    console.log('res', response);
                    if(response == "success"){
                        setTimeout(function(){
                            Lobibox.notify('success', {
                                size: 'mini',
                                title: '',
                                msg: 'Leave application successfully moved!'
                            });
                        },700);
                        location.reload();
                    }else{
                        setTimeout(function(){
                            Lobibox.notify('error', {
                                size: 'mini',
                                title: '',
                                msg: 'Leave application is not found!'
                            });
                        },700);
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    // Log the status and error
                    console.log('Status:', status);
                    console.log('Error:', error);
                    console.log('Response Text:', xhr.responseText);
                    try {
                        var jsonResponse = JSON.parse(xhr.responseText);
                        console.log('Response JSON:', jsonResponse);
                    } catch (e) {
                        console.log('Response is not JSON:', xhr.responseText);
                    }
                    console.log('Status Code:', xhr.status);
                }
            });
        }

        function addMove(button) {
            var $clone = button.closest('.for_clone').clone();
            var $select = $clone.find('select');

            $select.chosen('destroy');
            $clone.find('.chosen-container').remove();

            $clone.find('button').text(' - ').attr('onclick', 'removeMove($(this))');
            $clone.find('button').attr('class', 'btn-danger');
            $clone.find('.move_datepickerInput').val('');

            $clone.insertAfter('.for_clone:last');

            $select.chosen();
            $clone.find('.move_datepickerInput').datepicker();
        }

        function removeMove(button) {
            button.closest('.for_clone').remove();
        }


    </script>
@endsection