@extends('layouts.app')

@section('content')
    <div class="alert alert-jim" id="inputText">
        <h2 class="page-header">Filtered DTR</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="btn-group">
                    <button class="btn btn-success btn-lg" id="date_modal">Generate New
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

                        @if(isset($lists) and count($lists) >0)
                            <div class="table-responsive">
                                <table class="table table-list table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Inclusive Dates</th>
                                        <th>Date Generated</th>
                                        <th>Time Generated</th>
                                        <th><i class="fa fa-cog" aria-hidden="true"></i></th>
                                    </tr>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($lists as $list)
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>
                                                <strong style="color:#F39C2B;font-size: medium;">{{ date("M/d/y",strtotime($list->date_from ))." to ".date("M/d/y",strtotime($list->date_to )) }}</strong>
                                            </td>
                                            <td style="color:#337ab7;"><strong>{{ date("M-d-y",strtotime($list->date_created)) }}</strong> </td>
                                            <td style="color:#337ab7;"><strong>{{ $list->time_created }}</strong> </td>
                                            <td>
                                                <a aria-label="Left Align" class="btn btn-success" href="{{ asset('FPDF/personal_generate.php?id='.$list->id.'&userid='.Auth::user()->userid) }}">
                                                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View
                                                </a>
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
    <div class="modal fade" tabindex="-1" role="dialog" id="generate_dtr_filter">
        <div class="modal-dialog modal-md" role="document" id="size">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #9900cc;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i>Generate DTR (Filter DTR)</h4>
                </div>
                <div class="modal-body">
                    <div id="response"></div>
                    <form action="{{ asset('personal/filter') }}" method="POST" id="dtr_filter">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control" id="inclusive1" name="filter_range" placeholder="Input date range here..." required>
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
                    <div class="row" id="loading_filter">
                        <div class="modal_content"><center><img src="{{ asset('public/img/spin.gif') }}" width="150" style="padding:10px;"></center></div>
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
    @parent
    <script>

        $('#date_modal').click(function(){
            $('#dtr_filter').show();
            $('#loading_filter').hide();
            $('#response').hide();
            $('#size').removeClass('modal-lg').addClass('modal-md');
            $('#generate_dtr_filter').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        });

        (function(){
            $('#loading_filter').hide();

            $('#dtr_filter').submit(function(e){
                e.preventDefault();

                $(this).hide();
                $('#loading_filter').show();

                var url = $(this).attr('action');
                var data = {
                    filter_range : $("input[name='filter_range']").val(),
                    _token : $("input[name='_token']").val()
                };

                $.ajax({
                    url: url,
                    type: 'POST',
                    data : data,
                    success: function(res) {
                        $('#size').removeClass('modal-md').addClass('modal-lg');
                        $('#dtr_filter').hide();
                        $('#loading_filter').hide();
                        $('#response').show();
                        $('#response').html(res);
                    }
                });
            });
        })();
        $('#inclusive1').daterangepicker();
    </script>
@endsection



