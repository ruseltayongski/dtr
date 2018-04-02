@extends('layouts.app')
@section('content')
<div class="col-md-12 wrapper">
    <div class="box box-info">
        <div class="box-body">
            <h3 class="page-header">Office Order</h3>

            <div class="row">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Option</strong></div>
                                <div class="panel-body">
                                    <form class="form-inline" method="POST" action="{{ asset('form/so_list') }}" id="searchForm">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <td class="col-sm-2" style="font-size: 12px;"><strong>Keyword</strong></td>
                                                    <td class="col-sm-1">: </td>
                                                    <td class="col-sm-9">
                                                        <input type="text" class="col-md-2 form-control" value="{{ Session::get('keyword') }}" id="inputEmail3" name="keyword" style="width: 100%" placeholder="Route no, Subject">
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <button type="submit" class="btn-lg btn-success center-block col-sm-12" id="print" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Printing DTR">
                                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">List</strong></div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if(!Auth::user()->usertype)
                                                <a href="#document_form" data-link="{{ asset('form/sov1') }}" class="btn btn-success" data-dismiss="modal" data-backdrop="static" data-toggle="modal" data-target="#document_form" style="background-color:darkmagenta;color: white;"><i class="fa fa-plus"></i> Create new</a>
                                            @endif
                                        </div>
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if(isset($office_order) and count($office_order) >0)
                                                <div class="table-responsive">
                                                    <table class="table table-list table-hover table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center"></th>
                                                            <th class="text-center" width="28%">Route #</th>
                                                            <th class="text-center" width="15%">Prepared Date</th>
                                                            @if(Auth::user()->usertype)
                                                            <th class="text-center">Prepared Name</th>
                                                            @endif
                                                            <th class="text-center">Subject</th>
                                                            <th class="text-center">Approved Status</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody style="font-size: 10pt;">
                                                        @foreach($office_order as $so)
                                                            <tr>
                                                                <td class="text-center"><a href="#track" data-link="{{ asset('form/track/'.$so->route_no) }}" data-route="{{ $so->route_no }}" data-toggle="modal" class="btn btn-sm btn-success col-sm-12" style="background-color: darkmagenta;color: white;"><i class="fa fa-line-chart"></i> Track</a></td>
                                                                <td>
                                                                    <a class="title-info" style="color: #f0ad4e;" data-route="{{ $so->route_no }}" data-backdrop="static" data-link="{{ asset('/form/info/'.$so->route_no.'/office_order') }}" href="#so_info" data-toggle="modal">{{ $so->route_no }}</a>
                                                                </td>
                                                                <td class="text-center">{{ date('M d, Y',strtotime($so->prepared_date)) }}</td>
                                                                @if(Auth::user()->usertype)
                                                                <td>
                                                                    <?php $name = InformationPersonal::where('userid','=',$so->prepared_by)->first(); ?>
                                                                    {{ $name->fname.' '.$name->mname.' '.$name->lname }}
                                                                </td>
                                                                @endif
                                                                <td class="text-center">{{ $so->subject }}</td>
                                                                @if($so->approved_status)
                                                                    <td class="text-center"><span class="label label-info"><i class="fa fa-smile-o"></i> Approved </span></td>
                                                                @else
                                                                    <td class="text-center"><span class="label label-danger"><i class="fa fa-frown-o"></i> Disapprove </span></td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                {{ $office_order->links() }}
                                            @else
                                                <div class="alert alert-danger" role="alert"><span style="color:red;">Documents records are empty.</span></div>
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
    </div>
</div>

<div class="modal fade" role="dialog" id="so_info" style="overflow-y:scroll;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#9C8AA5;padding:15px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> Create Document</h4>
            </div>
            <div class="modal-body">
                <div class="modal_content"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@endsection
@section('js')
    <script>
        $('.input-daterange input').each(function() {
            $(this).datepicker("clearDates");
        });
        //document information
        $("a[href='#so_info']").on('click',function(){
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

        $("a[href='#document_form']").on('click',function(e){
            $('.modal-title').html('Office Order');
            $('.modal_content').html(loadingState);
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

        $("a[href='#form_type']").on("click",function(){
            <?php
                $asset = asset('form/sov1');
                $delete = asset('so_delete');
                $doc_type = "OFFICE ORDER";
            ?>
        });

        $('#inclusive3').daterangepicker();
    </script>

@endsection
