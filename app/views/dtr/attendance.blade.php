@extends('layouts.app')

@section('content')
    <div class="alert alert-jim" id="inputText">
        <h2>Attendace</h2>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Filter Attendance</strong></div>
                            <div class="panel-body">
                                <form action="{{ asset('attendance/q') }}" method="GET">
                                <form action="{{ asset('attendance/q') }}" method="GET">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <td class="col-sm-3"><strong>Keyword</strong></td>
                                                <td class="col-sm-1"> :</td>
                                                <td class="col-sm-9"><input type="text" class="col-md-2 form-control" id="inputEmail3" name="q" value=""></td>
                                            </tr>
                                            <tr>
                                                <td class="col-sm-3"><strong>Dates</strong></td>
                                                <td class="col-sm-1"> :</td>
                                                <td class="col-sm-9">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control" id="inclusive2" name="filter_range" placeholder="Input date range here..." required>
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
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Attendance list</strong></div>
                        <div class="panel-body">
                            <div class="clearfix"></div>

                            @if(isset($lists) and count($lists) >0)
                                <div class="table-responsive">
                                    <table class="table table-list table-hover table-striped">
                                        <thead>
                                        <tr>
                                            <th class="text-center" style="font-size: smaller;">Userid</th>
                                            <th class="text-center" style="font-size: smaller;">Name</th>
                                            <th class="text-center" style="font-size: smaller;">Date</th>
                                            <th class="text-center" style="font-size: smaller;">Time</th>
                                            <th class="text-center" style="font-size: smaller;">Event</th>
                                            <th class="text-center" style="font-size: smaller;">Remark</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($lists as $list)
                                            <tr>
                                                <td class="text-center title-info" style="font-size: smaller;"><strong><a href="#">{{ $list->userid }}</a> </strong> </td>
                                                <td class="text-center" style="font-size: smaller;"><strong><a href="#">{{ $list->fname ." " .$list->lname }}</a> </strong> </td>
                                                <td class="text-center" style="font-size: smaller;"><strong><a href="#">{{ $list->datein }} </a> </strong></td>
                                                <td class="text-center" style="font-size: smaller;"><strong><a href="#">{{ $list->time }}</a> </strong></td>
                                                <td class="text-center" style="font-size: smaller;"><strong><a href="#">{{ $list->event }}</a> </strong></td>
                                                <td class="text-center" style="font-size: smaller;"><strong><a href="#">{{ $list->remark }}</a> </strong></td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $lists->links() }}
                            @else
                                <div class="alert alert-danger" role="alert">No attendance</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection
@section('plugin')
    <script src="{{ asset('resources/plugin/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('resources/plugin/daterangepicker/daterangepicker.js') }}"></script>
@endsection

@section('css')
    <link href="{{ asset('resources/plugin/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
@endsection
@section('js')
    @parent
    <script>
        $('#all_jo').submit(function(){
            $('#generate_dtr_jo').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        });

        $('#inclusive2').daterangepicker();
        $('#inclusive3').daterangepicker();
    </script>
@endsection



