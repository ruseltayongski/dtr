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
                            $color = ['red','aqua','green'];
                            $fa = ['fa-exclamation-circle','fa-smile-o','fa-users'];
                            $status = ['pending','approve','all'];
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
                                                <input type="text" class="form-control" value="{{ Session::get('keyword') }}" id="inputEmail3" name="keyword" style="width: 100%" placeholder="Route no, Reason">
                                            </div>
                                            <button type="submit" class="btn btn-primary" name="search" id="search" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Printing DTR">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search
                                            </button>
                                        </form>
                                    </div>
                                    <div class="panel-body">
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
                                        <form class="form-inline" method="POST" action="{{ asset('form/cdo_list') }}" id="searchForm">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" value="{{ Session::get('keyword') }}" id="inputEmail3" name="keyword" style="width: 100%" placeholder="Route no, Reason">
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
                            <!--ALL-->
                            <div class="tab-pane" id="all">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <form class="form-inline" method="POST" action="{{ asset('form/cdo_list') }}" id="searchForm">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" value="{{ Session::get('keyword') }}" id="inputEmail3" name="keyword" style="width: 100%" placeholder="Route no, Reason">
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
        $(".all").text(<?php echo count($cdo["count_all"]); ?>);
        $("a[href='#approve']").on("click",function(){
            $('.ajax_approve').html(loadingState);
            type = 'approve';
            getPosts(1,keyword);
            <?php Session::put('keyword',null); ?>
        });
        $("a[href='#pending']").on("click",function(){
            $('.ajax_pending').html(loadingState);
            type = 'pending';
            getPosts(1,keyword);
            <?php Session::put('keyword',null); ?>
        });
        $("a[href='#all']").on("click",function(){
            $('.ajax_all').html(loadingState);
            type = 'all';
            getPosts(1,keyword);
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
            keyword = $("input[name='keyword']").val();
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
    </script>

    <script>

        function pending_status(data){
            var page = "<?php echo Session::get('page_pending') ?>";
            var url = $("#cdo_updatev1").data('link')+'/'+data.val()+'/pending?page='+page;
            $.post(url,function(result){
                console.log(url);
                //$('.ajax_pending').html(loadingState);
                setTimeout(function(){
                    if(result['count_pending'] && !result['paginate_pending']){
                        console.log("asin1");
                        getPosts(page-1,'');
                    } else {
                        console.log("asin2");
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