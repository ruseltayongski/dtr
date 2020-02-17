@extends('layouts.app')

@section('content')
    @if(Session::has('message'))
        <div class="col-md-12 wrapper">
            <div class="alert alert-success" role="alert">
                {{ Session::get('message') }}
            </div>
        </div>
    @endif
    <h3 class="page-header">Leave Documents</h3>
    <form class="form-inline form-accept" action="{{ asset('tracked/leave') }}" method="GET">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <div class="form-group">
            <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Quick Search" autofocus>
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
        </div>
    </form><br>
    <div class="row">
        <div class="col-md-12">
            @if(isset($leaves) and count($leaves) >0)
                <div class="table-responsive">
                    <table class="table table-list table-hover table-striped">
                        <thead>
                        <tr style="background-color:grey;">
                            <th ></th>
                            <th >Route #</th>
                            <th >Applicant Name</th>
                            <th ><b>Date Created</b></th>
                            <th ><b>Application for Leave</b></th>
                            <th ><b>Status</b></th>
                            <th >Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($leaves as $leave)
                            <tr>
                                <td >
                                    <a href="#track" data-link="{{ asset('form/track/'.$leave->route_no) }}" data-route="{{ $leave->route_no }}" data-toggle="modal" class="btn btn-sm btn-success" ><i class="fa fa-line-chart"></i> Track</a>
                                </td>
                                <td >
                                    <a class="title-info" data-route="{{ $leave->route_no }}" data-id="{{ $leave->id }}" data-backdrop="static" data-link="{{ asset('leave/get') }}" href="#leave_info" data-toggle="modal">{{ $leave->route_no }}</a>
                                </td>
                                <td ><span style="font-size:15px;font-weight:bold;">{{ $leave->firstname." ". $leave->lastname  }}</span></td>
                                <td >
                                    <?php
                                    $date_time = new DateTime($leave->date_filling);
                                    $date = $date_time->format('M')." ".$date_time->format('d') .", ". $date_time->format('Y');
                                    ?>
                                    <a href="#"><b>{{ $date }}</b></a>
                                </td>
                                <td >{{ $leave->leave_type }}</td>
                                <td>
                                    <?php
                                        if($leave->status == 'PENDING')
                                            $color = 'primary';
                                        elseif($leave->status == 'APPROVED')
                                            $color = 'success';
                                        else
                                            $color = 'danger';
                                    ?>
                                    <small class="label label-{{ $color }}">{{ $leave->status }}</small>
                                </td>
                                <td >
                                    @if($leave->status == 'PENDING')
                                        <button type="button" class="btn btn-success btn-sm leave_approved" data-route="{{ $leave->route_no }}"><span class="glyphicon glyphicon-ok"></span> Approved</button>
                                        <button type="button" class="btn btn-danger btn-sm leave_disapproved" data-route="{{ $leave->route_no }}"><span class="glyphicon glyphicon-remove"></span> Disapproved</button>
                                    @else
                                        <button type="button" class="btn btn-primary btn-sm leave_pending" data-route="{{ $leave->route_no }}"><span class="glyphicon glyphicon-question-sign"></span> Set Pending</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $leaves->links() }}
            @else
                <div class="alert alert-danger" role="alert">Empty Records</div>
            @endif
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
        $(".leave_approved").click(function(){
            $('#modal_leave_approved').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
            
            var route = $(this).data('route');
            $("#leave_route_approved").val(route);
        });

        $(".leave_disapproved").click(function(){
            $('#modal_leave_disapproved').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });

            var route = $(this).data('route');
            console.log(route);
            $("#leave_route_disapproved").val(route);
        });

        $(".leave_pending").click(function(){
            $('#modal_leave_pending').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });

            var route = $(this).data('route');
            $("#leave_route_pending").val(route);
        });
    </script>
@endsection
