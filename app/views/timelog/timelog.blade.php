
@extends('layouts.app')

@section('content')
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <div class="row">
                <div class="col-md-12">
                    <form class="form-inline" autocomplete="off" method="POST" action="{{ asset('logs/timelog') }}" id="submit_logs">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="text" class="form-control filter_dates" value="{{ Session::get('filter_dates') }}" id="inclusive3" name="filter_dates" placeholder="Filter Date" required>
                        <button type="submit" class="btn btn-success" id="print">
                            Go
                        </button>
                    </form>
                    <br>
                    @if(empty($timeLog))
                        <div class="alert alert-info">
                            <p style="color: #1387ff">
                                No logs record
                            </p>
                        </div>
                    @else
                        <div class="panel panel-default">
                            <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Logs</strong></div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-list table-hover table-striped">
                                        <tr>
                                            <th>Date In</th>
                                            <th>AM IN</th>
                                            <th>AM OUT</th>
                                            <th>PM IN</th>
                                            <th>PM OUT</th>
                                        </tr>
                                        <tbody class="timelog">
                                        @foreach($timeLog as $row)
                                        <tr>
                                            <td>{{ $row->datein }}</td>
                                            <td>{{ explode('|',$row->time)[0] }}</td>
                                            <td>{{ explode('|',$row->time)[1] }}</td>
                                            <td>{{ explode('|',$row->time)[2] }}</td>
                                            <td>{{ explode('|',$row->time)[3] }}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    @parent

    <script>
        $('#inclusive3').daterangepicker();
        $('#submit_logs').submit(function(){
            $('#print_individual').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        });
    </script>
@endsection