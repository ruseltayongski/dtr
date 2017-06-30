<?php
use App\Http\Controllers\PersonalController as personal;
use App\Http\Controllers\DocumentController as document;
use App\Calendar;

if(isset($lists) and count($lists) > 0) {
    $day1 = explode('-',$start_date);
    $day2 = explode('-',$end_date);

    $startday = floor($day1[2]);
    $endday = $day2[2];
}
?>
@extends('layouts.app')

@section('content')
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h3 class="page-header">Print Monthly Attendance
            </h3>
            <form class="form-inline" method="POST" action="{{ asset('personal/print/filter') }}" id="searchForm">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="container-fluid">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control" id="inclusive1" name="date_range" placeholder="Input date range here..." required>
                            </div>
                        </div>
                        <button type="submit" name="filter" class="btn btn-success form-control" value="Filter">
                            <i class="fa fa-search"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
            <div class="clearfix"></div>
            <div class="page-divider"></div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @if(isset($lists) and count($lists) >0)
                            <div class="table-responsive">
                                <table class="table table-list table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th class="col-sm-3" style="text-align: center;">AM</th>
                                            <th class="col-sm-3" style="text-align: center;">PM</th>
                                        </tr>
                                    </thead>
                                </table>
                                <table border="1" class="table table-list table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <td class="text-center">Date</td>
                                            <td class="text-center">DAY</td>
                                            <td class="text-center">IN</td>
                                            <td class="text-center">OUT</td>
                                            <td class="text-center">IN</td>
                                            <td class="text-center">OUT</td>
                                            <td class="text-center">LATE</td>
                                            <td class="text-center">UNDERTIME</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $temp1 = -0;
                                            $temp2 = -0;
                                            $condition = -0;
                                            $title = '';
                                            $am_out = '';
                                            $ok = false;
                                            $logs = null;
                                            $index = 0;
                                            $log_date = "";
                                        ?>
                                        @for($d = $startday; $d <= $endday; $d++)
                                            <?php
                                                $d >= 1 && $d < 10 ? $zero='0' : $zero = '';
                                                $datein = $day1[0]."-".$day1[1]."-".$zero.$d;

                                                if($index != count($lists)) {
                                                    if($datein == $lists[$index]['datein']){
                                                        $log_date = $lists[$index]['datein'];
                                                        $logs = $lists[$index];
                                                        $index = $index + 1;
                                                    }
                                                }

                                                $am_out = '';
                                                $am_in =  personal::get_time($datein, 'IN','AM');
                                                if(!($logs['am_in'] == '' or $logs['am_in'] == null)){
                                                        $am_out = personal::get_time($datein, 'OUT', 'AM');
                                                        //flag for calendar
                                                        $ok = false;
                                                } else {
                                                    $condition = floor(strtotime($datein) / (60 * 60 * 24));
                                                    $check_calendar = document::check_calendar();
                                                    foreach($check_calendar as $check)
                                                    {
                                                        if(isset(Calendar::where('route_no',$check->route_no)
                                                                        ->where('start',$datein)
                                                                        ->first()->title)) {
                                                            $title = Calendar::where('route_no',$check->route_no)
                                                                    ->where('start',$datein)
                                                                    ->orWhere('end',$datein)
                                                                    ->get()
                                                                    ->first();
                                                            $temp1 = floor(strtotime($title->start) / (60 * 60 * 24));
                                                            $temp2 = floor(strtotime($title->end) / (60 * 60 * 24));
                                                        }
                                                        if($condition < $temp2 and $title != ''){
                                                            $am_out = "<p style='color:red;'>".$title->title."</p>";
                                                            $ok = true;
                                                            break;
                                                        }
                                                        else {
                                                            $am_out = '';
                                                            $ok = false;
                                                        }
                                                    }
                                                }

                                                if($datein == $log_date)
                                                {
                                                    $am_in = $logs['am_in'];
                                                    $am_out = $logs['am_out'];
                                                    $pm_in = $logs['pm_in'];
                                                    $pm_out = $logs['pm_out'];

                                                    $late = personal::late($am_in, $pm_in);
                                                    $ut = personal::undertime($am_out,$pm_out);
                                                } else {
                                                    $am_in = '';
                                                    $am_out = '';
                                                    $pm_in = '';
                                                    $pm_out = '';
                                                    $late = '';
                                                    $ut = personal::undertime($am_out,$pm_out);
                                                }
                                                ?>
                                            <tr>
                                                <td class="text-center">{{ $datein }}</td>
                                                <td class="text-center">{{ personal::day_name($datein) }}</td>
                                                @if($ok)
                                                    <td class="text-center" colspan="4">{{ isset($am_out) ? $am_out : '' }}</td>
                                                @else
                                                    <td class="text-center">{{ isset($am_in) ? $am_in : '' }}</td>
                                                    <td class="text-center">{{ isset($am_out) ? $am_out : '' }}</td>
                                                    <td class="text-center">{{ isset($pm_in) ? $pm_in : '' }}</td>
                                                    <td class="text-center">{{ isset($pm_out) ? $pm_out : '' }}</td>
                                                @endif
                                                <td class="text-center">{{ isset($late) ? $late : '' }}</td>
                                                <td class="text-center">{{ isset($ut) ? $ut : '' }}</td>

                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
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
    @parent
    <script>
        $('#inclusive1').daterangepicker();
    </script>
@endsection