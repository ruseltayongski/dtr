@extends('layouts.app')

@section('content')
    <div class="alert alert-jim" id="inputText">
        <h2 class="page-header">Job Order DTR</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="btn-group">
                    <button class="btn btn-success" onclick="date_modal();">Generate New
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="page-divider"></div>
        <div class="page-divider">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
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
    <div class="modal fade" tabindex="-1" role="dialog" id="generate_dtr_jo">
        <div class="modal-dialog modal-lg" role="document" style="width: 30%;">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #9900cc;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i>Generate DTR (Job Order)</h4>
                </div>

                <div class="modal-body">
                    <form action="{{ asset('FPDF/jo_dtr.php') }}" method="POST" id="dtr_filter">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control" id="inclusive2" name="filter_range" placeholder="Input date range here..." required>
                                </div>
                            </div>
                        </div>
                        <div class="page-divider"></div>
                        <div class="row">
                            <div class="col-md-5 col-lg-offset-4">
                                <button type="submit" class="btn btn-facebook btn-lg" id="btn_generate">
                                    Generate
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="row" id="jo_loading">
                        <div class="col-md-12">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                    <strong class="text-center" style="font-size: medium;font-weight: bold;">Please wait. Generating attendance report.</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection
@section('plugin')
    <script src="{{ asset('resources/plugin/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('resources/plugin/daterangepicker/daterangepicker.js') }}"></script>
@endsection

@section('css')
    <link href="{{ asset('resources/plugin/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
@endsection
@section('js')
    @@parent
    <script>
        function date_modal() {
            $('#generate_dtr_jo').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        }
        (function(){
            $('#jo_loading').hide();
        })();

        $('#dtr_filter').submit(function(event){
            $(this).fadeOut(1000);
            $('#jo_loading').show();
        });
        $('#inclusive2').daterangepicker();
    </script>
@endsection



