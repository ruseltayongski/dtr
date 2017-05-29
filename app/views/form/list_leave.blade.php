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
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Option</strong></div>
                                <div class="panel-body">
                                    <form class="form-inline" method="POST" action="{{ asset('search') }}" onsubmit="return searchDocument();" id="searchForm">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <td class="col-sm-3" style="font-size: 12px;"><strong>Keyword</strong></td>
                                                    <td class="col-sm-1">: </td>
                                                    <td class="col-sm-9">
                                                        <input type="text" class="col-md-2 form-control" id="inputEmail3" name="keyword" placeholder="Name, Userid">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-sm-3" style="font-size: 12px;"><strong>Dates</strong></td>
                                                    <td class="col-sm-1"> :</td>
                                                    <td class="col-sm-9">
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </div>
                                                            <input type="text" class="form-control" id="inclusive3" name="filter_range" placeholder="Input date range here..." required>
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
                                            <a href="{{ asset('form/leave') }}"  class="btn btn-success center-block col-md-3">
                                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create new
                                            </a>
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
