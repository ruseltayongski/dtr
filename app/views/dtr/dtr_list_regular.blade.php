@extends('layouts.app')

@section('content')
    <div class="alert alert-jim" id="inputText">
        <h2>Regular DTR</h2>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Print all job order dtr</strong></div>
                            <div class="panel-body">
                                <form action="{{ asset('FPDF/print_all.php') }}" method="POST" id="all_jo">
                                    <input type="hidden" name="emptype" value="REG" />
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

                            @if(isset($lists) and count($lists) >0)
                                <div class="table-responsive">
                                    <table class="table table-list table-hover table-striped">
                                        <thead>
                                        <tr>
                                            <th>Report ID</th>
                                            <th>Inclusive Dates</th>
                                            <th>Date Generated</th>
                                            <th>Time Generated</th>
                                            <th><i class="fa fa-cog" aria-hidden="true"></i></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($lists as $list)
                                            <tr>
                                                <td>{{ $list->id }}</td>
                                                <td>{{ date("M-d-y",strtotime($list->date_from ))." to ".date("M-d-y",strtotime($list->date_to )) }}</td>
                                                <td>{{ date("M-d-y",strtotime($list->date_created)) }} </td>
                                                <td>{{ $list->time_created }} </td>
                                                <td>
                                                    <a class="btn btn-success" href="{{ asset('').'/FPDF/pdf-files/'.$list->filename }}">View</a>
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



