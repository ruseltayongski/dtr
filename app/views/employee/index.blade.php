@extends('layouts.app')

@section('content')
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <div class="row">
                <div class="col-md-4">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Print individual DTR</strong></div>
                                <div class="panel-body">
                                    <form action="{{ asset('FPDF/print_individual.php') }}" autocomplete="off" method="POST" id="print_pdf">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <td class="col-sm-3"><strong>User ID </strong></td>
                                                    <td class="col-sm-1">: </td>
                                                    <td class="col-sm-9">
                                                        @if(Auth::user()->usertype == "1")
                                                            <input type="text" class="col-md-2 form-control" id="inputEmail3" name="userid" value="" required>
                                                        @else
                                                            <input type="text" readonly class="col-md-2 form-control" id="inputEmail3" name="userid" value="{{ Auth::user()->userid }}" required>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-sm-3"><strong>Dates</strong></td>
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
                                        <button type="submit"  class="btn-lg btn-success center-block col-sm-12" id="upload" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Printing DTR">
                                            <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <!--
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading"><div style="color: #1560f0;font-size:medium;">Most Punctual Employee</div></div>
                                <div class="panel-body">
                                    <form action="{{ asset('FPDF/print_individual.php') }}" method="POST" id="print_pdf">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr class="success">
                                                    <th class="col-sm-2"></th>
                                                    <th class="col-sm-2">Rank</th>
                                                    <th class="col-sm-6">Name</th>
                                                    <th class="col-sm-3">Points</th>
                                                </tr>
                                                @foreach(range(0,3) as $index)
                        <tr>
                            <td class="col-sm-2"><img src="{{ asset('public/img/gonzales1.jpg') }}" class="img-circle" style="width: 100%" alt="Cinque Terre"></td>
                                                    <td class="col-sm-2">1</td>
                                                    <td class="col-sm-5 align-text-bottom">Jeswyrne Gonzales</td>
                                                    <td class="col-sm-3">555</td>
                                                </tr>
                                                <tr>
                                                    <td class="col-sm-2"><img src="{{ asset('public/img/mayor.jpg') }}" class="img-circle" style="width: 100%" alt="Cinque Terre"></td>
                                                    <td class="col-sm-2">2</td>
                                                    <td class="col-sm-5">Asnaui Pangcatan</td>
                                                    <td class="col-sm-3">555</td>
                                                </tr>
                                                <tr>
                                                    <td class="col-sm-2"><img src="{{ asset('public/img/traya.jpg') }}" class="img-circle" style="width: 100%" alt="Cinque Terre"></td>
                                                    <td class="col-sm-2">3</td>
                                                    <td class="col-sm-5">Lourence Rex Traya</td>
                                                    <td class="col-sm-3">555</td>
                                                </tr>
                                                @endforeach
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
-->

                    </div>
                </div>
                <div class="col-md-8">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Your current time logs for this month</strong></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form class="form-inline" method="GET" action="{{ asset('personal/search') }}"  id="searchForm">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control" id="filter_dates" value="{{ "06/16/2018 - 06/30/2018" }}" name="filter_range1" placeholder="Filter date range here..." >
                                                </div>
                                                <button type="submit" name="filter" class="btn btn-success form-control" value="Filter">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Filters
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <br />
                                <div class="row">
                                    <div class="col-md-12">
                                        @if(isset($lists) and count($lists) >0)
                                            <div class="table-responsive">
                                                <table class="table table-list table-hover table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">Attendance Date</th>
                                                        <th class="text-center">Attendance Time</th>
                                                        <th class="text-center">Event Type</th>
                                                        <th class="text-center">Remarks</th>
                                                        <th><span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($lists as $list)
                                                        <tr>
                                                            <td class="text-center">
                                                                <a href="#">
                                                                    <strong>{{ $list->datein }}</strong>
                                                                </a>

                                                            </td>
                                                            <td class="text-center"><strong><a href="#"> {{ $list->time }}</a></strong></td>
                                                            <td class="text-center"><strong><a href="#">{{ $list->event }}</a> </strong></td>
                                                            <td class="text-center">
                                                                <strong><a href="#">{{ $list->remark }}</a> </strong>
                                                            </td>
                                                            <td>
                                                                @if($list->edited == "1")
                                                                    <a class="btn btn-danger" href="{{ asset('delete/edited/logs/'.$list->userid .'/'. $list->datein .'/'. $list->time .'/'. $list->event) }}">
                                                                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                                                    </a>
                                                                @else
                                                                    <span>-----</span>
                                                                @endif

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
            </div>
        </div>
    </div>

@endsection

@section('js')
    @parent

    <script>
        $('.input-daterange input').each(function() {
            $(this).datepicker("clearDates");
        });
        $('#inclusive3').daterangepicker();
        $('#filter_dates').daterangepicker();
        $('#print_pdf').submit(function(){
            $('#upload').button('loading');
            $('#print_individual').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        });
    </script>
@endsection