
@extends('layouts.app')
@section('content')
<div class="row">    
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Mobile Logs</strong></div>
                    <div class="panel-body">
                        
                        <div class="table-responsive">
                            <table class="table table-list table-hover table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center">User ID</th>
                                    <th class="text-center">Name </th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Day</th>
                                    <th class="text-center">Logs</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                    @for($r1 = $data['startday']; $r1 <= $data['endday']; $r1++)

                                        <?php
                                            $r1 >= 1 && $r1 < 10 ? $zero='0' : $zero = '';
                                            $datein = $data['day1'][0]."-".$data['day1'][1]."-".$zero.$r1;
                                            $day_name = date('D', strtotime($datein));
                                            $logs = DB::table('dtr_file')
                                                    ->where('userid','=',$data['userid'])
                                                    ->where('datein','=',$datein)
                                                    ->where('remark','=','MOBILE')
                                                    ->get();
                                            $user = DB::table('users')->where('userid','=',$data['userid'])->first();
                                        ?>

                                        
                                        <tr>
                                            <td class="text-center" style="text-align: center; vertical-align: middle;"><a href="#user"  class="title-info">{{ $data['userid'] }}</a></td>
                                            <td style="text-align: center; vertical-align: middle;">{{ $user->fname. " ".$user->lname }}</td>
                                            <td class="text-center" style="text-align: center; vertical-align: middle;" >{{ $datein }}</td>
                                            <td class="text-center" style="text-align: center; vertical-align: middle;" >{{ $day_name }}</td>
                                            <td class="text-center" >
                                                <table class="table">
                                                    @foreach($logs as $log)
                                                        <tr>
                                                            <td>{{ $log->time }}</td>
                                                            <td>{{ $log->event }}</td>
                                                            <td class="text-center"><a href="{{ asset('public/logs_image/'.$log->log_image) }}" target="_blank"><img src="{{ asset('public/logs_image/'.$log->log_image) }}"></td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
