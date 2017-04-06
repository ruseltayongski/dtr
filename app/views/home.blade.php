
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
        <h3 class="page-header">Employee Attendance
        </h3>
        <form class="form-inline" method="GET" action="{{ asset('search') }}"  id="searchForm">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Search ID and or NAME" name="keyword" autofocus>
                <button  type="submit" name="search" value="search" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
                <div class="btn-group">
                    <div class="input-group input-daterange">
                        <span class="input-group-addon">From</span>
                        <input type="text" class="form-control" name="from" value="2012-04-05">
                        <span class="input-group-addon">To</span>
                        <input type="text" class="form-control" name="to" value="2012-04-19">
                        <span class="input-group-addon"></span>
                        <button type="submit" name="filter" class="btn btn-success form-control" value="Filter">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Filters
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <div class="clearfix"></div>
        <div class="page-divider"></div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if(isset($lists) and count($lists) >0)
                        <div class="table-responsive">
                            <table class="table table-list table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>DTR ID</th>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>Transaction date</th>
                                    <th>Transaction time</th>
                                    <th>Event Type</th>
                                    <th>Terminal</th>
                                    <th><i class="fa fa-cog" aria-hidden="true"></i></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($lists as $list)
                                    <tr>
                                        <td>{{ $list->dtr_id }}</td>
                                        <td>{{ $list->lastname }}</td>
                                        <td>{{ $list->department }} </td>
                                        <td>
                                            {{ date('l', strtotime($list->datein)) }}
                                            {{ date("M",strtotime($list->datein)).'. ' . $list->date_d .' , ' .$list->date_y }}
                                        </td>
                                        <td>{{ date("h:i A", strtotime($list->time)) }}</td>
                                        <td>{{ $list->event }}</td>
                                        <td>{{ $list->terminal }}</td>
                                        <td>
                                            <a class="btn btn-default" href="{{ asset('edit/attendance/' .$list->dtr_id) }}">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $lists->links() }}
                    @else
                        <div class="alert alert-danger" role="alert">DTR records are empty.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
@@parent

<script>
    $('.input-daterange input').each(function() {
        $(this).datepicker("clearDates");
    });
    function delete_time(id)
    {
        $('#delete_time').modal('show');
        $('#dtr_id_val').val(id);
    }
</script>
@endsection