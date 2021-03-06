@extends('layouts.app')
@section('content')
    <div class="box box-info">
        <div class="box-body">
            <span style="color:black;font-size: 15pt;padding: 1%;display:inline-flex;"> Beginning Balance : </span>
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
                                    @if(!Auth::user()->usertype)
                                        <a href="#document_form" data-link="{{ asset('form/cdov1/form') }}" class="btn btn-success" data-dismiss="modal" data-backdrop="static" data-toggle="modal" data-target="#document_form" style="background-color:#9C8AA5;color: white;"><i class="fa fa-plus"></i> Create new</a>
                                    @endif
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
                                                        <th></th>
                                                        <th class="text-center">Route #</th>
                                                        <th >Prepared Date</th>
                                                        <th >Reason</th>
                                                        <th class="text-center">Approved Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody style="font-size: 10pt;">
                                                    @foreach($cdo["my_cdo"] as $row)
                                                        <tr>
                                                            <td><a href="#track" data-link="{{ asset('form/track/'.$row->route_no) }}" data-route="{{ $row->route_no }}" data-toggle="modal" class="btn btn-sm btn-success col-sm-12" style="background-color:#9C8AA5;color:white;"><i class="fa fa-line-chart"></i> Track</a></td>
                                                            <td><a class="title-info" data-backdrop="static" data-route="{{ $row->route_no }}" style="color: #f0ad4e;" data-link="{{ asset('/form/info/'.$row->route_no.'/cdo') }}" href="#document_info" data-toggle="modal">{{ $row->route_no }}</a></td>
                                                            <td>{{ date('M d, Y',strtotime($row->prepared_date)) }}<br>{{ date('h:i:s A',strtotime($row->prepared_date)) }}</td>
                                                            <td>{{ $row->subject }}</td>
                                                            @if($row->approved_status)
                                                                <td class="text-center"><span class="label label-info"><i class="fa fa-smile-o"></i> Approved </span></td>
                                                            @else
                                                                <td class="text-center"><span class="label label-danger"><i class="fa fa-frown-o"></i> Pending to approved.. </span></td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            {{ $cdo['my_cdo']->links() }}
                                        @else
                                            <div class="alert alert-danger" role="alert"><span style="color: #ffeff1">Documents records are empty.</span></div>
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

        <?php if(Auth::user()->usertype): ?>
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