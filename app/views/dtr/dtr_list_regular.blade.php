@extends('layouts.app')

@section('content')
    <h3 class="page-header">Regular DTR</h3>
    <div class="row" id="inputText">
        <div class="col-md-12">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Print all regular dtr</strong></div>
                    <div class="panel-body">
                        <form action="{{ asset('FPDF/print_all.php') }}" method="POST" id="all_jo">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
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
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">PDF document list</strong></div>
                    <div class="panel-body">
                        <form class="form-inline form-accept" action="{{ asset('search/regular') }}" method="GET">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control" id="inclusive3" name="q" placeholder="Input date range here...">
                                </div>
                                <button type="submit" name="filter_range" class="btn btn-success form-control" value="Filter">
                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Filters
                                </button>
                            </div>
                        </form>
                        <div class="clearfix"></div>
                        <div class="page-divider"></div>

                        @if(count($lists))
                            <div class="table-responsive">
                                <table class="table table-list table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Inclusive Dates</th>
                                        <th class="text-center">Date Generated</th>
                                        <th class="text-center">Time Generated</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center"><i class="fa fa-cog" aria-hidden="true"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($lists as $list)
                                        <tr>
                                            <td class="text-center"><strong><a href="#">{{ date("M d, Y",strtotime($list->date_from ))." to ".date("M d, Y",strtotime($list->date_to )) }}</a> </strong></td>
                                            <td class="text-center"><strong><a href="#">{{ date("M d, Y",strtotime($list->date_created)) }}</a> </strong> </td>
                                            <td class="text-center"><strong><a href="#">{{ $list->time_created }} </a> </strong></td>
                                            <td class="text-center"><strong><a href="#">{{ $list->type }}</a> </strong></td>
                                            <td class="text-center">
                                                <a class="btn btn-success"  href="{{ asset('dtr/'.$list->id) }}">View</a>
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



