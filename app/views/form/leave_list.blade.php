@extends('layouts.app')

@section('content')
    @if(Session::has('message'))
        <div class="col-md-12 wrapper">
            <div class="alert alert-success" role="alert">
                {{ Session::get('message') }}
            </div>
        </div>
    @endif
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h3 class="page-header">Leave Documents
            </h3>
            <div class="row">
                <div class="col-md-12">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Document list</strong></div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <form action="{{ asset('search/leave') }}" method="GET">
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-search"></i></span>
                                                    <input type="text" class="form-control" placeholder="Search by route # or applicant name" name="q" aria-describedby="basic-addon1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if(isset($leaves) and count($leaves) >0)
                                                <div class="table-responsive">
                                                    <table class="table table-list table-hover table-striped">
                                                        <thead>
                                                        <tr style="background-color:grey;">
                                                            <th class="text-center"></th>
                                                            <th class="text-center">Route #</th>
                                                            <th class="text-center">Applicant Name</th>
                                                            <th class="text-center"><b>Date Created</b></th>
                                                            <th class="text-center"><b>Application for Leave</b></th>
                                                            <th class="text-center"></th>

                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($leaves as $leave)
                                                            <tr>
                                                                <td class="text-center">
                                                                    <a href="#track" data-link="{{ asset('form/track/'.$leave->route_no) }}" data-route="{{ $leave->route_no }}" data-toggle="modal" class="btn btn-sm btn-success" ><i class="fa fa-line-chart"></i> Track</a>
                                                                </td>
                                                                <td class="text-center">
                                                                    <a class="title-info">{{ $leave->route_no }}</a>
                                                                </td>
                                                                <td class="text-center"><span style="font-size:15px;font-weight:bold;">{{ $leave->firstname." ". $leave->lastname  }}</span></th>
                                                                <td class="text-center">
                                                                    <?php
                                                                        $date_time = new DateTime($leave->date_filling);
                                                                        $date = $date_time->format('M')." ".$date_time->format('d') .", ". $date_time->format('Y');
                                                                    ?>
                                                                    <a href="#"><b>{{ $date }}</b></a>
                                                                </td>
                                                                <td class="text-center">{{ $leave->leave_type }}</td>
                                                                <td class="text-center">
                                                                    @if($leave->approve == 0)
                                                                        <button type="button" class="btn btn-success btn-lg" id="leave_action" data-route="{{ $leave->route_no }}"><span style="color:yellowgreen;" class="glyphicon glyphicon-remove"></span></button>
                                                                    @else
                                                                        <a href="{{ asset('leave/cancel/'.$leave->route_no) }}" class="btn btn-success btn-lg" onclick="return confirm('Do you want to cancel leave application?')"><span class="glyphicon glyphicon-ok"></span></a>
                                                                    @endif
                                                                </th>
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
        $("#leave_action").click(function(){
            $('#modal_leave').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
            
            var route = $(this).data('route');
            $("#leave_route").val(route);
        });
    </script>
@endsection
