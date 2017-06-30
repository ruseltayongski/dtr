<?php
use Illuminate\Support\Facades\Session;
if(Session::has('lists')){
    $lists = Session::get('lists');
}
?>
@extends('layouts.app')
@section('content')
    <div class="col-md-12 wrapper" style="height: 200px;">
        <div class="alert alert-jim">
            <h3 class="page-header">Employee monthly attendance
            </h3>
            <div class="container">
                <div class="row">
                    <div class="col-md-11">
                        <div class="row upload-section">
                            <div id="alert" class="ng-cloak alert alert-warning alert-dismissible col-lg-12" role="alert">
                                <strong>Warning!</strong><span id="msg"></span>
                            </div>

                            <div class="progress">
                                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                    <strong class="text-center" style="font-size: medium;font-weight: bold;">Please wait. Generating attendance report.</strong>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-offset-3">
                                <form action="{{ asset('FPDF/dtr.php') }}" method="POST" id="filter" target="_blank">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <div class="btn-group">
                                        <div class="input-group input-daterange" >
                                            <span class="input-group-addon">From</span>
                                            <input type="text" class="form-control" name="from" >
                                            <span class="input-group-addon">To</span>
                                            <input type="text" class="form-control" name="to" >
                                            <span class="input-group-addon"></span>
                                            <button type="submit" name="filter" class="btn btn-success form-control" value="Filter">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Filters
                                            </button>
                                        </div>
                                    </div>
                                </form>
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
        var is_ok = false;
        error = "";
        $('#alert').hide();
        $('.input-daterange input').each(function() {
            $(this).datepicker("clearDates");
        });

        (function($){
            $('#filter').submit(function(event){

               var from = $('input[name="from"]').val();
               var to = $('input[name="to"]').val();
               if(isEmpty(from) && isEmpty(to)){
                    event.preventDefault();
                   $('#msg').html(null);
                    $('#msg').html("Filter date is empty.");
                    $('#alert').show();
               }

            });

        })($);
    </script>

@endsection
