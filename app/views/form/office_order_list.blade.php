@extends('layouts.app')


@section('content')
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h3 class="page-header">Office Order
            </h3>
            <form class="form-inline" method="POST" action="{{ asset('form/so_list') }}" onsubmit="return searchDocument();" id="searchForm">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search here.." name="keyword" value="{{ Session::get('keyword') }}" autofocus>
                    <button  type="submit" name="search" value="search" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
                    <a class="btn btn-success" data-dismiss="modal" data-backdrop="static" data-toggle="modal" data-target="#form_type" style="background-color: darkmagenta;color: white;"><i class="fa fa-plus"></i> Create new</a>
                </div>
            </form>
            <div class="clearfix"></div>
            <div class="page-divider"></div>
            <div class="row">
                <div class="col-md-12">
                    @if(isset($office_order) and count($office_order) >0)
                        <div class="table-responsive">
                            <table class="table table-list table-hover table-striped">
                                <thead>
                                <tr>
                                    <th width="8%"></th>
                                    <th width="20%">Route #</th>
                                    <th width="15%">Prepared Date</th>
                                    <th width="20%">Document Type</th>
                                    <th>Subject</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($office_order as $so)
                                    <tr>
                                        <td><a href="#track" data-link="{{ asset('form/track/'.$so->route_no) }}" data-route="{{ $so->route_no }}" data-toggle="modal" class="btn btn-sm btn-success col-sm-12" style="background-color: darkmagenta;color:white;"><i class="fa fa-line-chart"></i> Track</a></td>
                                        <td><a class="title-info" data-route="{{ $so->route_no }}" data-link="{{ asset('/form/info/'.$so->route_no) }}" href="#document_info" data-toggle="modal">{{ $so->route_no }}</a></td>
                                        <td>{{ date('M d, Y',strtotime($so->prepared_date)) }}<br>{{ date('h:i:s A',strtotime($so->prepared_date)) }}</td>
                                        <td>Office Order</td>
                                        <td>{{ $so->subject }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $office_order->links() }}
                    @else
                        <div class="alert alert-danger" role="alert">Documents records are empty.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" tabindex="-1" role="dialog" id="form_type" style="z-index:999991;">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: darkmagenta">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4><i class="fa fa-file-pdf-o"></i> Select Form Type</h4>
                </div>
                <div class="modal-body text-center">
                    <div class="col-xs-4" style="left: 10%">
                        <a href="#document_form" data-dismiss="modal" data-link="{{ asset('form/sov1') }}" data-backdrop="static" data-toggle="modal" data-target="#document_form" class="text-success">
                            <i class="fa fa-file-pdf-o fa-5x"></i><br>
                            <i>Form V1</i>
                        </a>
                    </div>
                    <div class="col-xs-4" style="left: 25%;">
                        <a href="so" class="text-info">
                            <i class="fa fa-file-pdf-o fa-5x"></i><br>
                            <i>Form V2</i>
                        </a>
                    </div>
                </div>
                <div class="clearfix"></div>
                <br />
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection
@section('js')
    @if(Session::get('added'))
        {{--<div class="alert alert-success">
            <i class="fa fa-check"></i> Successfully Added!
        </div>--}}
        <script>
            Lobibox.notify('success',{
                msg:'Successfully Added!'
            });
        </script>
        <?php Session::forget('added'); ?>
    @endif
    @if(Session::get('deleted'))
        {{--<div class="alert alert-warning">
            <i class="fa fa-check"></i> Successfully Deleted!
        </div>--}}
        <script>
            Lobibox.notify('error',{
                msg:'Successfully Deleted!'
            });
        </script>
        <?php Session::forget('deleted'); ?>
    @endif
    @if(Session::get('updated'))
        <script>
            Lobibox.notify('info',{
                msg:'Successfully Updated!'
            });
        </script>
        <?php Session::forget('updated'); ?>
    @endif

    @parent
    <script>
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
            },1000);
        });

        $("a[href='#document_form']").on('click',function(){
            $('.modal-title').html('Office Order');
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
            },1000);
        });
    </script>

@endsection
