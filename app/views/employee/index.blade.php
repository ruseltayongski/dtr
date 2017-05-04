
@extends('layouts.app')

@section('content')
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h3 class="page-header">Your Attendance
            </h3>
            <form class="form-inline" method="GET" action="{{ asset('/personal/search/filter') }}"  id="searchForm">
                <div class="form-group">
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
                                        <th>Userid</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Transaction date</th>
                                        <th>Transaction time</th>
                                        <th>Event Type</th>
                                        <th>Terminal</th>
                                        <th>Remarks</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($lists as $list)
                                        <tr>
                                            <td>{{ $list->userid }}</td>
                                            <td>{{ $list->firstname .", " .$list->lastname }}</td>
                                            <td>{{ $list->department }} </td>
                                            <td>
                                                {{ date('l', strtotime($list->datein)) }}
                                                {{ date("M",strtotime($list->datein)).'. ' . $list->date_d .' , ' .$list->date_y }}
                                            </td>
                                            <td>{{ date("h:i A", strtotime($list->time)) }}</td>
                                            <td>{{ $list->event }}</td>
                                            <td>{{ $list->terminal }}</td>
                                            <td>{{ $list->remark }}</td>
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

    </script>
@endsection