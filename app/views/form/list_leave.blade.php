@extends('layouts.app')


@section('content')
    @if(Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
    @endif
    <h3 class="page-header">Leave Documents
    </h3>
    <div class="row">
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Option</strong></div>
                        <div class="panel-body">
                            <form class="form-inline" method="POST" action="{{ asset('form/leave/all') }}" id="searchForm">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td class="col-sm-2" style="font-size: 12px;"><strong>Dates</strong></td>
                                            <td class="col-sm-1"> :</td>
                                            <td class="col-sm-9">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control" id="inclusive3" value="{{ $filter_range }}" name="filter_range" placeholder="Input date range here...">
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <button type="submit"  class="btn-lg btn-success center-block col-sm-12" id="print" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Printing DTR">
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
                        <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Document list</strong></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ asset('form/leave') }}" class="btn btn-success center-block col-md-3" onclick="checkBalance();">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create new
                                    </a>
                                    <label class="text-success">Vacation Balance: <span class="badge bg-blue">{{ Session::get("vacation_balance") }}</span></label>
                                    <label class="text-danger">Sick Balance: <span class="badge bg-red">{{ Session::get("sick_balance") }}</span></label>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-12">
                                    @if(isset($leaves) and count($leaves) >0)
                                        <div class="table-responsive">
                                            <table class="table table-list table-hover table-striped">
                                                <thead>
                                                <tr style="background-color:grey;">
                                                    <th class="text-center"></th>
                                                    <th class="text-center">Route #</th>
                                                    <th class="text-center"><b>Date Created</b></th>
                                                    <th class="text-center"><b>Application for Leave</b></th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($leaves as $leave)
                                                    <tr>
                                                        <td class="text-center">
                                                            <a href="#track" data-link="{{ asset('form/track/'.$leave->route_no) }}" data-route="{{ $leave->route_no }}" data-toggle="modal" class="btn btn-sm btn-success col-sm-12" ><i class="fa fa-line-chart"></i> Track</a>
                                                        </td>
                                                        <td class="text-center">
                                                            <a class="title-info" data-route="{{ $leave->route_no }}" data-id="{{ $leave->id }}" data-backdrop="static" data-link="{{ asset('leave/get') }}" href="#leave_info" data-toggle="modal">{{ $leave->route_no }}</a>
                                                        </td>

                                                        <td class="text-center">
                                                            <a href="#" data-toggle="modal"><b>{{ $leave->date_filling }}</b></a>
                                                        </td>
                                                        <td class="text-center">{{ $leave->leave_type }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        {{ $leaves->links() }}
                                    @else
                                        <div class="alert alert-danger" role="alert">Documents records are empty.</div>
                                    @endif
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
    @parent
    <script>
        $('#inclusive3').daterangepicker();

        $('a[href="#leave_info').click(function(){
            var id = $(this).data('id');
            var url = $(this).data('link');

            $.get(url +'/' +id , function(data){
                $('#leave_info').modal('show');
                $('.modal-body_leave').html(data);
            });
        });

        function checkBalance(){
            @if(!Session::get('vacation_balance') || !Session::get('sick_balance'))
            Lobibox.alert('error', //AVAILABLE TYPES: "error", "info", "success", "warning"
                {
                    msg: "LEAVE BALANCE INSUFFICIENT"
                });
            event.preventDefault();
            @endif
        }

    </script>
@endsection
