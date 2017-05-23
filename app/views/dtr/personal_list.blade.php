<?php
use Illuminate\Support\Facades\Auth;

?>

@extends('layouts.app')

@section('content')
    <div class="alert alert-jim" id="inputText">
        <h2 class="page-header">Admin Generated DTR</h2>
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
                                                <a class="btn btn-success" href="{{ asset('FPDF/personal_generate.php?id='.$list->id.'&userid='.Auth::user()->userid ) }}">View</a>
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
    </script>
@endsection



