<?php
use Illuminate\Support\Facades\Session;
if(Session::has('lists')){
    $lists = Session::get('lists');
}
?>
@extends('layouts.app')
@section('content')
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h3 class="page-header">Print employee attendance
            </h3>
            <div class="container">
                <div class="row">
                    <div class="col-md-11">
                        <div class="row upload-section">
                            <div id="alert" class="ng-cloak alert alert-warning alert-dismissible col-lg-12" role="alert">
                                <strong>Warning!</strong><span id="msg"></span>
                            </div>
                            <div class="alert-success alert col-md-6 col-lg-offset-3">
                                <form action="{{ asset('print-monthly') }}" method="POST" id="filter">
                                    {{ csrf_field() }}
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
            <div class="clearfix"></div>
            <div class="page-divider"></div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @if(isset($lists) and count($lists) >0)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-list table-hover table-striped">
                                            <thead>
                                            <tr>
                                                <th>Userid</th>
                                                <th>Name</th>
                                                <th>Department</th>
                                                <th>Transaction date</th>
                                                <th>Transaction time</th>
                                                <th>Event Type</th>
                                                <th>Terminal</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($lists as $list)
                                                <tr>
                                                    <td>{{ $list->userid }}</td>
                                                    <td>{{ $list->lastname .", " .$list->lastname }}</td>
                                                    <td>{{ $list->department }}</td>
                                                    <td>{{ date("M",strtotime($list->datein)).'. ' . $list->date_d .' , ' .$list->date_y }}</td></td>
                                                    <td>{{date("h:i A", strtotime($list->time)) }}</td>
                                                    <td>{{ $list->event }}</td>
                                                    <td>{{ $list->terminal }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    {{ $lists->links() }}
                                </div>
                            </div>
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
    @@parent
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
