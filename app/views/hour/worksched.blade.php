@extends('layouts.app')

@section('content')
    <div class="alert alert-jim" id="inputText">
        <h2 class="page-header">Working Schedule</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="btn-group">
                    <a class="btn btn-success" href="{{  asset('create/work-schedule') }}">
                        <i class="fa fa-plus"></i>  Add New
                    </a>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="page-divider"></div>
        @if(Session::has('new_hour'))
            <div class="alert alert-success">
                <strong>{{ Session::get('new_hour') }}</strong>
            </div>
        @endif
        @if(count($hours))

            <div class="table-responsive">
                <table class="table table-list table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Description</th>
                            <th>AM Time In</th>
                            <th>AM Time Out</th>
                            <th>PM Time In</th>
                            <th>PM Time Out</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    @foreach($hours as $hour)
                        <tr>
                            <td>{{ $hour->id }}</td>
                            <td>{{ $hour->description }}</td>
                            <td>{{ $hour->am_in }}</td>
                            <td>{{ $hour->am_out }}</td>
                            <td>{{ $hour->pm_in }}</td>
                            <td>{{ $hour->pm_out }}</td>
                            <td>
                                <a class="btn btn-default" href="{{ asset('edit/work-schedule/' . $hour->id) }}">Update</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            {{ $hours->links() }}
        @else
            <div class="alert alert-danger">
                <strong><i class="fa fa-times fa-lg"></i>No flixe time records.</strong>
            </div>
        @endif
    </div>
@endsection



