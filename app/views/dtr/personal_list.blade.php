
@extends('layouts.app')

@section('content')
    <div class="alert alert-jim" id="inputText">
        <h2 class="page-header">Admin Generated DTR</h2>
        <div class="page-divider">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-inline" method="POST" action="{{ asset('personal/dtr/list') }}"  id="searchForm">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control" id="filter_dates" name="filter_range" placeholder="Filter date range here...">
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
                                        <th class="text-center">Inclusive Dates</th>
                                        <th class="text-center">Date Generated</th>
                                        <th class="text-center">Time Generated</th>
                                        <th class="text-center"><i class="fa fa-cog" aria-hidden="true"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($lists as $list)
                                        <tr>

                                            <td class="text-center"><strong><a href="#"> {{ date("M d, Y",strtotime($list->date_from ))." to ".date("M d, Y",strtotime($list->date_to )) }}</a></strong></td>
                                            <td class="text-center"><strong><a href="#">{{ date("M d, Y",strtotime($list->date_created)) }}</a> </strong> </td>
                                            <td class="text-center"><strong><a href="#">{{ $list->time_created }}</a>  </strong></td>
                                            <td class="text-center">
                                                <a class="btn btn-success view_gen" href="{{ asset('FPDF/d.php?id='.$list->id.'&userid='.Auth::user()->userid ) }}">
                                                    <span class="glyphicon glyphicon-eye-open"></span> View
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
    </div>
@endsection
@section('js')
    @parent
    <script>

        $('.view_gen').click(function() {
            $('#loading_modal').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        });

        $('#filter_dates').daterangepicker();
    </script>
@endsection



