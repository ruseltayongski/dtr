
@extends('layouts.app')
@section('content')
    <div class="box box-info">
        <div class="box-body">
            <span style="color:black;font-size: 15pt;padding: 1%;display:inline-flex;"> Beginning Balance: </span>
            <span style="color:green;display:inline-flex;font-size: 17pt;">
                <?php
                if(InformationPersonal::where('userid',Auth::user()->userid)->first()->bbalance_cto){
                    echo InformationPersonal::where('userid',Auth::user()->userid)->first()->bbalance_cto;
                }
                else {
                    echo 0;
                }
                ?>
            </span>
            <div class="row">
                <div class="col-md-12">
                    <!-- CREATED BY USER LIST CTO -->
                    <div class="active tab-pane" id="approve">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <form class="form-inline" method="POST" action="{{ asset('form/cdo_user') }}" id="searchForm">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" value="{{ Session::get('keyword') }}" id="inputEmail3" name="keyword" style="width: 100%" placeholder="Route no, Reason">
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="search" id="search" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Printing DTR">
                                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search
                                    </button>
                                    @if(Auth::user()->usertype != 1)
                                        <a href="#document_form" data-link="/dtr/form/cdov1/form" class="btn btn-success" data-dismiss="modal" data-backdrop="static" data-toggle="modal" data-target="#document_form" style="background-color:#9C8AA5;color: white;"><i class="fa fa-plus"></i> Create new</a>
                                    @endif
                                    <a class="btn btn-info" onclick="displayCard('{{ $userid }}')" data-dismiss="modal" data-toggle="modal" data-target="#ledger"><i class="fa fa-eye"></i> View Card</a>

                                </form>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        @if(isset($cdo['my_cdo']) and count($cdo['my_cdo']) >0)
                                            <div class="table-responsive">
                                                <table class="table table-list table-hover table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">Route #</th>
                                                        <th>Prepared Date</th>
                                                        <th>Exclusive Date</th>
                                                        <th>Reason</th>
                                                        <th>Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody style="font-size: 10pt;">
                                                    @foreach($cdo["my_cdo"] as $row)
                                                        <tr>
                                                            {{--<td><a href="#track" data-link="{{ asset('form/track/'.$row->route_no) }}" data-route="{{ $row->route_no }}" data-toggle="modal" class="btn btn-sm btn-success col-sm-12" style="background-color:#9C8AA5;color:white;"><i class="fa fa-line-chart"></i> Track</a></td>--}}
                                                            <td><a class="title-info" data-backdrop="static" data-route="{{ $row->route_no }}" style="color: #f0ad4e;" data-link="/dtr/form/info/{{ $row->route_no }}/cdo" href="#document_info" data-toggle="modal">{{ $row->route_no }}</a></td>
                                                            <td>{{ date('M d, Y',strtotime($row->prepared_date)) }}<br>{{ date('h:i:s A',strtotime($row->prepared_date)) }}</td>
                                                            <td>
                                                                @if($row->applied_dates == null)
                                                                    <?php
                                                                    $hours = " ";
                                                                    if($row->cdo_hours == "cdo_am"){
                                                                        $hours=" (AM)";
                                                                    }else if($row->cdo_hours == "cdo_pm"){
                                                                        $hours=" (PM)";
                                                                    }
                                                                    $start_date = date('M j, Y', strtotime($row->start));
                                                                    $end_date = date('M j, Y', strtotime('-1 day', strtotime($row->end)));
                                                                    $dateStrings = ($start_date == $end_date) ? "$start_date $hours" : "$start_date - $end_date $hours";
                                                                    echo $dateStrings;
                                                                    ?>
                                                                @else
                                                                    <?php
                                                                    $get_date = CdoAppliedDate::where('cdo_id', $row->id)->get();
                                                                    $dateStrings=[];
                                                                    if(count($get_date)>0){

                                                                        foreach ($get_date as $index=>$dates){
                                                                            $hours = " ";
                                                                            if($dates->cdo_hours == "cdo_am"){
                                                                                $hours=" (AM)";
                                                                            }else if($dates->cdo_hours == "cdo_pm"){
                                                                                $hours=" (PM)";
                                                                            }
                                                                            $start_date = date('M j, Y', strtotime($dates->start_date));
                                                                            $end_date = date('M j, Y', strtotime('-1 day', strtotime($dates->end_date)));
                                                                            $stat = '';
                                                                            if($dates->status == 1 || $dates->status == 11){
                                                                                $stat = ' (CANCELLED)';
                                                                            }
                                                                            $dateStrings[] = ($start_date == $end_date) ? "$start_date $hours $stat" : "$start_date - $end_date $hours $stat";
                                                                        }
                                                                        echo implode(',<br>',$dateStrings);
                                                                    }else{
                                                                        $hours = " ";
                                                                        if($row->cdo_hours == "cdo_am"){
                                                                            $hours=" (AM)";
                                                                        }else if($row->cdo_hours == "cdo_pm"){
                                                                            $hours=" (PM)";
                                                                        }
                                                                        $start_date = date('M j, Y', strtotime($row->start));
                                                                        $end_date = date('M j, Y', strtotime('-1 day', strtotime($row->end)));
                                                                        $dateStrings = ($start_date == $end_date) ? "$start_date $hours" : "$start_date - $end_date $hours";
                                                                        echo $dateStrings;
                                                                    }
                                                                    ?>
                                                                @endif
                                                            </td>
                                                            <td>{{ $row->subject }}</td>
                                                            @if($row->status ==3)
                                                                <td><span class="label label-warning"><i class="fa fa-frown-o"></i> Cancelled </span></td>
                                                            @elseif($row->approved_status)
                                                                <td><span class="label label-info"><i class="fa fa-smile-o"></i> Processed </span></td>
                                                            @else
                                                                <td><span class="label label-danger"><i class="fa fa-frown-o"></i> Pending </span></td>
                                                            @endif
                                                        </tr>

                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            {{ $cdo['my_cdo']->links() }}
                                        @else
                                            <div class="alert alert-danger" role="alert"><span style="color: white">Documents records are empty.</span></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="5" role="dialog" id="ledger">
        <div class="modal-dialog modal-xl" role="document" id="size" style="max-width:1250px; width:100%;">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #9C8AA5">
                    <strong><h4 class="modal-title" style="display: inline-block; font-weight: bold; color: white"> CTO HISTORY: {{ strtoupper($name) }}</h4></strong>
                    <button style="display: inline-block" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div style="text-align: center; width: 100%" class="card_view_body"></div>
            </div>
        </div>
    </div>
@endsection
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@section('js')
    <script>
        var account_id;
        var type = 0;
        function displayCard(userid, page){
            var overlay = $('<div></div>').css({
                position: 'absolute',
                top: 0,
                left: 0,
                width: '100%',
                height: '100%',
                display: 'flex',
                'align-items': 'center',
                'justify-content': 'center',
                'z-index': 999
            }).append(loadingState);

            account_id = userid;
            type == 0 ? $('.card_view_body').append(loadingState) : $('.card_view_body').append(overlay);
            $.get("{{ url('cdo/card_view').'/' }}" + userid, { page: page }, function(result) {
                $('.card_view_body').html(result);
            });
        }

        $(document).on('click', '.ajax-page-link', function(e) {
            e.preventDefault();
            var pageUrl = $(this).attr('href');
            var page = pageUrl.split('page=')[1];
            type = 1;
            displayCard(account_id, page);
        });


        $(document).ready(function () {
            @if(Session::get("cdo_falsification"))
                <?php Session::put("cdo_falsification", false); ?>
                var name = "<?php echo htmlspecialchars(Auth::user()->fname, ENT_QUOTES, 'UTF-8'); ?>"
                $('#falsification').modal('show');
            @endif

            var pageSize = 15;
            var currentPage = 1;
            var pagination = $("#pagination");
            var totalItems = $("#t_body tr").length;
            var totalPages = Math.ceil(totalItems / pageSize);

            currentPage = totalPages;

            function updateTableRows(page) {
                var startIndex = (page - 1) * pageSize;
                $("#t_body tr").hide().slice(startIndex, startIndex + pageSize).show();
            }

//            function createPaginationButtons() {
//                var buttons = [];
//                buttons.push('<li class="page-item"><a class="page-link" href="#" data-page="prev">&laquo;</a></li>');
//                for (var i = 1; i <= totalPages; i++) {
//                    buttons.push('<li class="page-item"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>');
//                }
//                buttons.push('<li class="page-item"><a class="page-link" href="#" data-page="next">&raquo;</a></li>');
//                pagination.html(buttons.join(''));
//            }

            function createPaginationButtons() {
                var buttons = [];
                buttons.push('<li class="page-item"><a class="page-link" href="#" data-page="prev">&laquo;</a></li>');

                // Reverse the pagination order
                for (var i = totalPages; i >= 1; i--) {
                    buttons.push('<li class="page-item"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>');
                }

                buttons.push('<li class="page-item"><a class="page-link" href="#" data-page="next">&raquo;</a></li>');
                pagination.html(buttons.join(''));
            }

            createPaginationButtons();
            updateTableRows(currentPage);

            pagination.on("click", ".page-link", function () {
                var targetPage = $(this).data("page");
                if (targetPage === "prev") {
                    currentPage = Math.max(currentPage - 1, 1);
                } else if (targetPage === "next") {
                    currentPage = Math.min(currentPage + 1, totalPages);
                } else {
                    currentPage = parseInt(targetPage);
                }
                updateTableRows(currentPage);
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

        <?php if(Auth::user()->usertype == 1): ?>
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
                alert('Page could not be loaded... refresh your page.');
                var redirect_url = "<?php echo asset('/'); ?>";
                window.location.href = redirect_url;
            });
        }
        <?php endif; ?>
    </script>
@endsection