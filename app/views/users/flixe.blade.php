@extends('layouts.app')

@section('content')
    <div class="alert alert-jim" id="inputText">
        <h2>Employee's Work Schedule Group</h2>
        <hr />
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Group Lists</strong></div>
                        <div class="panel-body">
                            <form class="form-inline form-filter" action="{{ asset('filter/flixe') }}" method="GET" >
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <div class="input-group">
                                        <select class="form-control col-sm-5" name="sched" id="work_sched">
                                            <option disabled>Select work schedule</option>
                                            @if(isset($scheds) and count($scheds) > 0)
                                                @foreach($scheds as $sched)
                                                    <option value="{{ $sched->id }}">{{ $sched->description }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <button type="submit" name="filter_range" class="btn btn-success form-control" value="Filter">
                                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Filters
                                    </button>
                                </div>
                            </form>
                            <div class="clearfix"></div>
                            <div class="page-divider"></div>

                            @if(isset($users) and count($users) >0)
                                <div class="table-responsive">
                                    <table class="table table-list table-hover table-striped">
                                        <thead>
                                        <tr>
                                            <th class="text-center">User ID</th>
                                            <th class="text-center">Name </th>
                                            <th class="text-center">Work Schedule</th>
                                            <th class="text-center">Option</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $user)
                                            <tr>
                                                <td class="text-center"><a href="#user" data-id="{{ $user->userid }}"  class="title-info">{{ $user->userid }}</a></td>
                                                <td class="text-center"><a href="#user" data-id="{{ $user->id }}" data-link="{{ asset('user/edit') }}" class="text-bold">{{ $user->fname ." ". $user->mname." ".$user->lname }}</a></td>
                                                <td class="text-center">
                                                    <span class="text-bold">{{ $user->description }}</span>

                                                </td>
                                                <td class="text-center"><button data-id="{{ $user->userid }}" type="button" class="btn btn-info btn-xs change_sched">Change</button></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $users->links() }}
                            @else
                                <div class="alert alert-danger" role="alert">No results.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <span id="data_link" data-link="{{ asset('change/work-schedule') }}" />
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

        $('.change_sched').click(function(){
            $('#change_schedule').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
            var url = $('#data_link').data('link');

            var data = {
                id : $(this).data('id')
            };

            $.get(url,data, function(res){
                $('#schedule_modal').html(res);
            });

        });

    </script>
@endsection



