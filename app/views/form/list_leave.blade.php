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
            <form class="form-inline" method="POST" action="{{ asset('search') }}" onsubmit="return searchDocument();" id="searchForm">

                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search ID and or NAME" name="keyword" value="{{ Session::get('keyword') }}" autofocus>
                    <button  type="submit" name="search" value="search" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
                    <a class="btn btn-success" href="{{ asset('form/leave') }}">Create new</a>
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
                        @if(isset($leaves) and count($leaves) >0)
                            <div class="table-responsive">
                                <table class="table table-list table-hover table-striped">
                                    <thead>
                                         <tr style="background-color:grey;">
                                            <td width="8%"></td>
                                            <td><b>Date Created</b></td>
                                            <td><b>Application for Leave</b></td>
                                            <td width="30%">
                                                <b><span class="glyphicon glyphicon-cog" aria-hidden="true"></span></b>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($leaves as $leave)
                                        <tr>
                                            <td><a href="#track" data-link="{{ asset('') }}" data-toggle="modal" class="btn btn-sm btn-success col-sm-12" style="background-color: darkmagenta;color:white;"><i class="fa fa-line-chart"></i> Track</a></td>
                                            <td style="color: #c87f0a;">
                                                <a href="#leave" data-toggle="modal" data-link="{{ asset('leave/get') }}" data-id="{{ $leave->id }}"><b>{{ $leave->date_filling }}</b></a>
                                            </td>
                                            <td>{{ $leave->leave_type }}</td>
                                            <td>
                                                <b>
                                                    <a class="btn btn-info" href="{{ asset('leave/update/' . $leave->id) }}">Edit</a>
                                                    <a class="btn btn-warning" href="{{ asset('leave/delete/' .$leave->id) }}">Delete</a>
                                                    <a target="_blank" class="btn btn-success" href="{{ asset('leave/print/' .$leave->id) }}">Print</a>
                                                </b>
                                            </td>
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
@endsection
@section('js')
    @@parent
    <script>
        $('.input-daterange input').each(function() {
            $(this).datepicker("clearDates");
        });
        $('a[href="#leave').click(function(){

            var id = $(this).data('id');
            var url = $(this).data('link');

            $.get(url +'/' +id , function(data){
                $('#leave_form').modal('show');
                $('.modal-body').html(data);
            });
        });
    </script>
@endsection
