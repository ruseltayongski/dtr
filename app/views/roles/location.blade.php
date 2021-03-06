@extends('layouts.app')

@section('content')
    <h3 class="page-header">Supervised Employee(s)</h3>
    <form class="form-inline form-accept" action="{{ asset('location/roles') }}" method="GET">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <div class="form-group">
            <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Quick Search" autofocus>
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
        </div>
    </form><br>
    <div class="row">
        <div class="col-md-12">
            @if(isset($supervise_employee) and count($supervise_employee) >0)
                <div class="table-responsive">
                    <table class="table table-list table-hover table-striped">
                        <thead>
                        <tr style="background-color:grey;">
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Division</th>
                            <th>Section</th>
                            <th>Job Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($supervise_employee as $supervise)
                            <tr>
                                <td>{{ $supervise->userid }}</td>
                                <td>
                                    <b><a href="#" data-supervise_id="{{ $supervise->userid }}" data-supervise_name="{{ strtoupper($supervise->name) }}" class="supervise_view text-green">{{ strtoupper($supervise->name) }}</a></b>
                                </td>
                                <td><small>{{ $supervise->designation }}</small></td>
                                <td><small>{{ $supervise->division }}</small></td>
                                <td><small>{{ $supervise->section }}</small></td>
                                <td><small>{{ $supervise->job_status }}</small></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $supervise_employee->links() }}
            @else
                <div class="alert alert-danger" role="alert">Empty Records</div>
            @endif
        </div>
    </div>
@endsection
@section('js')
    @parent
    <script>
        $(".supervise_view").click(function(e){
            e.preventDefault();
            $('#supervise_view').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
            var supervise_id = $(this).data('supervise_id');
            $("#supervise_id").val(supervise_id);
            var supervise_name = $(this).data('supervise_name');
            $(".supervise_name").html(supervise_name);
        });
    </script>
@endsection
