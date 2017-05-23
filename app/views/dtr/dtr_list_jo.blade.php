@extends('layouts.app')

@section('content')
    <div class="alert alert-jim" id="inputText">
        <h2>Job Order DTR</h2>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Print all job order dtr</strong></div>
                            <div class="panel-body">
                                <form action="{{ asset('FPDF/jo_dtr.php') }}" method="POST" id="all_jo">
                                    <div class="table-responsive">
                                        <table class="table">
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
                                        <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print
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
                        <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">PDF document list</strong></div>
                        <div class="panel-body">
                            <form class="form-inline form-accept" action="{{ asset('/search') }}" method="GET">
                                <div class="form-group">
                                    <input type="text" name="search" class="form-control" placeholder="Quick Search" autofocus>
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
                                </div>
                            </form>
                            <div class="clearfix"></div>
                            <div class="page-divider"></div>

                            @if(isset($users) and count($users) > 0)
                                <div class="table-responsive">
                                    <table class="table table-list table-hover table-striped">
                                        <thead>
                                        <tr>
                                            <th>User ID</th>
                                            <th>Name </th>
                                            <th>Work Schedule</th>
                                            <th>Option</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <td><a href="#user" data-id="{{ $user->userid }}"  class="title-info">{{ $user->userid }}</a></td>
                                                <td><a href="#user" data-id="{{ $user->id }}" data-link="{{ asset('user/edit') }}" class="text-bold">{{ $user->fname ." ". $user->mname." ".$user->lname }}</a></td>
                                                <td>
                                                    <span class="text-bold">{{ $user->description }}</span>

                                                </td>
                                                <td><button data-id="{{ $user->userid }}" type="button" class="btn btn-info btn-xs change_sched">Change</button></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <span id="data_link" data-link="{{ asset('change/work-schedule') }}" />
                                {{ $users->links() }}
                            @else
                                <div class="alert alert-danger">
                                    <strong><i class="fa fa-times fa-lg"></i>No users found.</strong>
                                </div>
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
    </script>
@endsection



