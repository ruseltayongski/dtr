@extends('layouts.app')

@section('content')
    <style>
        @keyframes highlight {
            0% {
                background: #ffff99;
            }
            100% {
                background: none;
            }
        }

        .highlight {
            animation: highlight 3s;
        }

        .profile-user-img{
            width: 200px;
            height: 200px;
            cursor: pointer;
        }

        .rotater {
            transition: all 0.3s ease;
            border: 0.0625em solid black;
            border-radius: 3.75em;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            <form class="form-inline" autocomplete="off" method="POST" action="{{ $supervisor ? asset('logs/timelogs/supervisor') : asset('logs/timelogs') }}" id="submit_logs" style="margin-right: 2%">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="text" class="form-control filter_dates" value="{{ Session::get('filter_dates') }}" id="inclusive3" name="filter_dates" placeholder="Filter Date" readonly>
                <button type="submit" class="btn btn-primary" id="print">
                    Generate
                </button>
                <div class="label pull-right bg-red" style="font-size: 12pt">{{ $timeLog[0]->userid.' - '.$timeLog[0]->name }}</div>
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <strong style="font-size: 15pt">Manage Timelog</strong><br>
                                <i class="ace-icon fa fa-hand-o-right"></i> Note: Just click the timelog to edit<br>
                                <small class="badge bg-green" style="font-size: 8pt;">08:00:00</small> &nbsp;&nbsp;NOT EDITABLE
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th width="10%">Date In</th>
                                        <th width="12%">AM IN</th>
                                        <th width="12%">AM OUT</th>
                                        <th width="12%">PM IN</th>
                                        <th width="15%">PM OUT</th>
                                    </tr>
                                    <tbody class="timelog">
                                    <?php $count = 0; ?>
                                    @foreach($timeLog as $row)
                                    <?php $count++; ?>
                                    <?php $time = explode("_",explode('|',$row->time)[0])[0]; ?>
                                    <!-- for map-->
                                    <?php
                                    $am_in_lat = isset(explode("_",explode('|',$row->time)[0])[4]) ? explode("_",explode('|',$row->time)[0])[4] : "empty";
                                    $am_in_lon = isset(explode("_",explode('|',$row->time)[0])[5]) ? explode("_",explode('|',$row->time)[0])[5] : "empty";
                                    $am_in_time = isset(explode("_",explode('|',$row->time)[0])[0]) ? explode("_",explode('|',$row->time)[0])[0] : "empty";

                                    $am_out_lat = isset(explode("_",explode('|',$row->time)[1])[4]) ? explode("_",explode('|',$row->time)[1])[4] : "empty";
                                    $am_out_lon = isset(explode("_",explode('|',$row->time)[1])[5]) ? explode("_",explode('|',$row->time)[1])[5] : "empty";
                                    $am_out_time = isset(explode("_",explode('|',$row->time)[1])[0]) ? explode("_",explode('|',$row->time)[1])[0] : "empty";

                                    $pm_in_lat = isset(explode("_",explode('|',$row->time)[2])[4]) ? explode("_",explode('|',$row->time)[2])[4] : "empty";
                                    $pm_in_lon = isset(explode("_",explode('|',$row->time)[2])[5]) ? explode("_",explode('|',$row->time)[2])[5] : "empty";
                                    $pm_in_time = isset(explode("_",explode('|',$row->time)[2])[0]) ? explode("_",explode('|',$row->time)[2])[0] : "empty";

                                    $pm_out_lat = isset(explode("_",explode('|',$row->time)[3])[4]) ? explode("_",explode('|',$row->time)[3])[4] : "empty";
                                    $pm_out_lon = isset(explode("_",explode('|',$row->time)[3])[5]) ? explode("_",explode('|',$row->time)[3])[5] : "empty";
                                    $pm_out_time = isset(explode("_",explode('|',$row->time)[3])[0]) ? explode("_",explode('|',$row->time)[3])[0] : "empty";
                                    ?>
                                    @if($am_in_lat != "empty" || $am_in_lon != "empty" || $am_out_lat != "empty" || $am_out_lon != "empty" || $pm_in_lat != "empty" || $pm_in_lon != "empty" || $pm_out_lat != "empty" || $pm_out_lon != "empty")
                                    <tr>
                                        <td colspan="5">
                                            <?php
                                                if(strpos($am_in_time, 'RPO #') !== false) {
                                                    $am_in_time = 'empty';
                                                }
                                                if(strpos($am_out_time, 'RPO #') !== false) {
                                                    $am_out_time = 'empty';
                                                }
                                                if(strpos($pm_in_time, 'RPO #') !== false) {
                                                    $pm_in_time = 'empty';
                                                }
                                                if(strpos($pm_out_time, 'RPO #') !== false) {
                                                    $pm_out_time = 'empty';
                                                }
                                            ?>
                                            <iframe src="{{ asset('map').'/'.$am_in_lat.'/'.$am_in_lon.'/'.$am_in_time.'/'.$am_out_lat.'/'.$am_out_lon.'/'.$am_out_time.'/'.$pm_in_lat.'/'.$pm_in_lon.'/'.$pm_in_time.'/'.$pm_out_lat.'/'.$pm_out_lon.'/'.$pm_out_time }}" style="width: 100%;height: 400px;"></iframe>
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td>
                                            <strong class="text-green">{{ date("F d, Y",strtotime($row->datein)) }}</strong><br>
                                            <small class="text-orange" style="font-size: 8pt;">{{ $row->dayname }}</small>
                                        </td>
                                        <td> <!-- AM IN -->
                                            <input type="hidden" value="{{ explode("_",explode('|',$row->time)[0])[2] }}" id="{{ $count."ñ"."AM_IN" }}">
                                            <!-- end map -->
                                            @if(empty(explode("_",explode('|',$row->time)[0])[1]) || explode("_",explode('|',$row->time)[0])[3] == 'mobile' || explode("_",explode('|',$row->time)[0])[3] == 'normal')
                                                <strong class="badge bg-green" style="font-size: 10pt;position: absolute;">{{ $time }}</strong><br>
                                                @if(isset(explode("_",explode('|',$row->time)[0])[4]) && isset(explode("_",explode('|',$row->time)[0])[5]))
                                                    <?php
                                                        $latitude = explode("_",explode('|',$row->time)[0])[4];
                                                        $longitude = explode("_",explode('|',$row->time)[0])[5];
                                                    ?>
                                                    @if($latitude != "empty" && $longitude != "empty")
                                                        <?php
                                                            $log_image = explode("_",explode('|',$row->time)[0]);
                                                            $path_timelog = asset('public/logs_imageV2').'/'.$userid.'/timelog'.'/'.$log_image[6];
                                                            $path_screenshot = asset('public/logs_imageV2').'/'.$userid.'/screenshot'.'/'.$log_image[6];

                                                            if(isset($log_image[7]))
                                                                $src_image = asset('public/logs_image').'/'.$log_image[6].'_'.$log_image[7].'_'.$log_image[8].'_'.$log_image[9].'_'.$log_image[10].'_'.$log_image[11].'_'.$log_image[12];
                                                            elseif($latitude == 'null')
                                                                $src_image = $path_screenshot;
                                                            else
                                                                $src_image = $path_timelog;

                                                            $lat_element = 'lat'.date("YmdHis",strtotime($row->datein.$time)).'am_in';
                                                            $lon_element = 'lon'.date("YmdHis",strtotime($row->datein.$time)).'am_in';
                                                        ?>
                                                        <strong class="badge bg-red" style="position: absolute;margin-top: -20px;margin-left: 90px;">Click image to rotate</strong>
                                                        <?php
                                                            $am_in_lat = $latitude;
                                                            $am_in_lon = $longitude;
                                                            $am_in_time = $time;
                                                        ?>
                                                        <div style="padding: 2%;">
                                                            <img class="profile-user-img img-responsive " src="{{ $src_image }}" alt="User profile picture" onclick="rotate(this)">
                                                        </div>
                                                        <table class="table table-bordered table-striped">
                                                            <tr>
                                                                <td><div class="pull-right">Latitude :</div></td>
                                                                <td><small id="{{ $lat_element }}">{{ $latitude }}</small> <button class="btn btn-default btn-xs" type="button" onclick="copyToClipboard('{{ '#'.$lat_element }}')">Copy</button></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="pull-right">Longitude :</div></td>
                                                                <td><small id="{{ $lon_element }}">{{ $longitude }}</small> <button class="btn btn-default btn-xs" type="button" style="margin-top: 1%" onclick="copyToClipboard('{{ '#'.$lon_element }}')">Copy</button></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="pull-right">Address :</div>
                                                                </td>
                                                                <td>
                                                                    <i class="ace-icon fa fa-hand-o-right"></i> <a href="https://www.latlong.net/Show-Latitude-Longitude.html" target="_blank"><strong>URL</strong></a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    @endif
                                                @endif
                                            @else
                                                <strong style="cursor: pointer;" class="editable badge bg-blue" id="<?php echo
                                                    $userid.'ñ'.
                                                    $row->datein.'ñ'.
                                                    str_replace(':','-',explode("_",explode('|',$row->time)[0])[2]).
                                                    'ñ'.explode("_",explode('|',$row->time)[0])[3].'ñ'.
                                                    "AM_IN"."ñ".
                                                    $count;
                                                ?>">{{ strtoupper($time) }}</strong>
                                            @endif
                                        </td>
                                        <td> <!-- AM OUT -->
                                            <input type="hidden" value="{{ explode("_",explode('|',$row->time)[1])[2] }}" id="{{ $count."ñ"."AM_OUT" }}">
                                            <?php $time = explode("_",explode('|',$row->time)[1])[0]; ?>
                                            @if(empty(explode("_",explode('|',$row->time)[1])[1]) || explode("_",explode('|',$row->time)[1])[3] == 'mobile' || explode("_",explode('|',$row->time)[1])[3] == 'normal')
                                                <strong class="badge bg-green">{{ $time }}</strong><br>
                                                @if(isset(explode("_",explode('|',$row->time)[1])[4]) && isset(explode("_",explode('|',$row->time)[1])[5]))
                                                    <?php
                                                        $latitude = explode("_",explode('|',$row->time)[1])[4];
                                                        $longitude = explode("_",explode('|',$row->time)[1])[5];
                                                    ?>
                                                    @if($latitude != "empty" && $longitude != "empty")
                                                        <?php
                                                            $log_image = explode("_",explode('|',$row->time)[1]);
                                                            $path_timelog = asset('public/logs_imageV2').'/'.$userid.'/timelog'.'/'.$log_image[6];
                                                            $path_screenshot = asset('public/logs_imageV2').'/'.$userid.'/screenshot'.'/'.$log_image[6];

                                                            if(isset($log_image[7]))
                                                                $src_image = asset('public/logs_image').'/'.$log_image[6].'_'.$log_image[7].'_'.$log_image[8].'_'.$log_image[9].'_'.$log_image[10].'_'.$log_image[11].'_'.$log_image[12];
                                                            elseif($latitude == 'null')
                                                                $src_image = $path_screenshot;
                                                            else
                                                                $src_image = $path_timelog;


                                                            $lat_element = 'lat'.date("YmdHis",strtotime($row->datein.$time)).'am_out';
                                                            $lon_element = 'lon'.date("YmdHis",strtotime($row->datein.$time)).'am_out';
                                                        ?>
                                                            <?php
                                                            $am_out_lat = $latitude;
                                                            $am_out_lon = $longitude;
                                                            $am_out_time = $time;
                                                            ?>
                                                        <div style="padding: 2%;">
                                                            <img class="profile-user-img img-responsive" src="{{ $src_image }}" alt="User profile picture" onclick="rotate(this)">
                                                        </div>
                                                        <table class="table table-bordered table-striped">
                                                            <tr>
                                                                <td><div class="pull-right">Latitude :</div></td>
                                                                <td><small id="{{ $lat_element }}">{{ $latitude }}</small> <button class="btn btn-default btn-xs" type="button" onclick="copyToClipboard('{{ '#'.$lat_element }}')">Copy</button></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="pull-right">Longitude :</div></td>
                                                                <td><small id="{{ $lon_element }}">{{ $longitude }}</small> <button class="btn btn-default btn-xs" type="button" style="margin-top: 1%" onclick="copyToClipboard('{{ '#'.$lon_element }}')">Copy</button></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="pull-right">Location :</div>
                                                                </td>
                                                                <td>
                                                                    <i class="ace-icon fa fa-hand-o-right"></i> <a href="https://www.latlong.net/Show-Latitude-Longitude.html" target="_blank"><strong>URL</strong></a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    @endif
                                                @endif
                                            @else
                                                <strong style="cursor: pointer;" class="editable badge bg-blue" id="<?php echo
                                                    $userid.'ñ'.
                                                    $row->datein.'ñ'.
                                                    str_replace(':','-',explode("_",explode('|',$row->time)[1])[2]).
                                                    'ñ'.explode("_",explode('|',$row->time)[1])[3].'ñ'.
                                                    "AM_OUT"."ñ".
                                                    $count;
                                                ?>">{{ strtoupper($time) }}</strong>
                                            @endif
                                        </td>
                                        <td > <!-- PM IN -->
                                            <input type="hidden" value="{{ explode("_",explode('|',$row->time)[2])[2] }}" id="{{ $count."ñ"."PM_IN" }}">
                                            <?php $time = explode("_",explode('|',$row->time)[2])[0]; ?>
                                            @if(empty(explode("_",explode('|',$row->time)[2])[1]) || explode("_",explode('|',$row->time)[2])[3] == 'mobile' || explode("_",explode('|',$row->time)[2])[3] == 'normal')
                                                <strong class="badge bg-green">{{ $time }}</strong><br>
                                                @if(isset(explode("_",explode('|',$row->time)[2])[4]) && isset(explode("_",explode('|',$row->time)[2])[5]))
                                                    <?php
                                                        $latitude = explode("_",explode('|',$row->time)[2])[4];
                                                        $longitude = explode("_",explode('|',$row->time)[2])[5];
                                                    ?>
                                                    @if($latitude != "empty" && $longitude != "empty")
                                                        <?php
                                                            $log_image = explode("_",explode('|',$row->time)[2]);
                                                            $path_timelog = asset('public/logs_imageV2').'/'.$userid.'/timelog'.'/'.$log_image[6];
                                                            $path_screenshot = asset('public/logs_imageV2').'/'.$userid.'/screenshot'.'/'.$log_image[6];

                                                            if(isset($log_image[7]))
                                                                $src_image = asset('public/logs_image').'/'.$log_image[6].'_'.$log_image[7].'_'.$log_image[8].'_'.$log_image[9].'_'.$log_image[10].'_'.$log_image[11].'_'.$log_image[12];
                                                            elseif($latitude == 'null')
                                                                $src_image = $path_screenshot;
                                                            else
                                                                $src_image = $path_timelog;


                                                            $lat_element = 'lat'.date("YmdHis",strtotime($row->datein.$time)).'pm_in';
                                                            $lon_element = 'lon'.date("YmdHis",strtotime($row->datein.$time)).'pm_in';
                                                        ?>
                                                            <?php
                                                                $pm_in_lat = $latitude;
                                                                $pm_in_lon = $longitude;
                                                                $pm_in_time = $time;
                                                            ?>
                                                            <div style="padding: 2%;">
                                                                <img class="profile-user-img img-responsive" src="{{ $src_image }}" alt="User profile picture" onclick="rotate(this)">
                                                            </div>
                                                            <table class="table table-bordered table-striped">
                                                                <tr>
                                                                    <td><div class="pull-right">Latitude :</div></td>
                                                                    <td><small id="{{ $lat_element }}">{{ $latitude }}</small> <button class="btn btn-default btn-xs" type="button" onclick="copyToClipboard('{{ '#'.$lat_element }}')">Copy</button></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><div class="pull-right">Longitude :</div></td>
                                                                    <td><small id="{{ $lon_element }}">{{ $longitude }}</small> <button class="btn btn-default btn-xs" type="button" style="margin-top: 1%" onclick="copyToClipboard('{{ '#'.$lon_element }}')">Copy</button></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="pull-right">Location :</div>
                                                                    </td>
                                                                    <td>
                                                                        <i class="ace-icon fa fa-hand-o-right"></i> <a href="https://www.latlong.net/Show-Latitude-Longitude.html" target="_blank"><strong>URL</strong></a>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                    @endif
                                                @endif
                                            @else

                                                <strong style="cursor: pointer;" class="editable badge bg-blue" id="<?php echo
                                                    $userid.'ñ'.
                                                    $row->datein.'ñ'.
                                                    str_replace(':','-',explode("_",explode('|',$row->time)[2])[2]).
                                                    'ñ'.explode("_",explode('|',$row->time)[2])[3].'ñ'.
                                                    "PM_IN"."ñ".
                                                    $count;
                                                ?>">{{ strtoupper($time) }}</strong>

                                            @endif
                                        </td>
                                        <td > <!-- PM OUT -->
                                            <input type="hidden" value="{{ explode("_",explode('|',$row->time)[3])[2] }}" id="{{ $count."ñ"."PM_OUT" }}">
                                            <?php $time = explode("_",explode('|',$row->time)[3])[0]; ?>
                                            @if(empty(explode("_",explode('|',$row->time)[3])[1]) || explode("_",explode('|',$row->time)[3])[3] == 'mobile' || explode("_",explode('|',$row->time)[3])[3] == 'normal')
                                                <strong class="badge bg-green">{{ explode("_",explode('|',$row->time)[3])[0] }}</strong><br>
                                                @if(isset(explode("_",explode('|',$row->time)[3])[4]) && isset(explode("_",explode('|',$row->time)[3])[5]))
                                                    <?php
                                                        $latitude = explode("_",explode('|',$row->time)[3])[4];
                                                        $longitude = explode("_",explode('|',$row->time)[3])[5];
                                                    ?>
                                                    @if($latitude != "empty" && $longitude != "empty")
                                                        <?php
                                                            $log_image = explode("_",explode('|',$row->time)[3]);
                                                            $path_timelog = asset('public/logs_imageV2').'/'.$userid.'/timelog'.'/'.$log_image[6];
                                                            $path_screenshot = asset('public/logs_imageV2').'/'.$userid.'/screenshot'.'/'.$log_image[6];

                                                            if(isset($log_image[7]))
                                                                $src_image = asset('public/logs_image').'/'.$log_image[6].'_'.$log_image[7].'_'.$log_image[8].'_'.$log_image[9].'_'.$log_image[10].'_'.$log_image[11].'_'.$log_image[12];
                                                            elseif($latitude == 'null')
                                                                $src_image = $path_screenshot;
                                                            else
                                                                $src_image = $path_timelog;


                                                            $lat_element = 'lat'.date("YmdHis",strtotime($row->datein.$time)).'pm_out';
                                                            $lon_element = 'lon'.date("YmdHis",strtotime($row->datein.$time)).'pm_out';
                                                        ?>
                                                        <?php
                                                            $pm_out_lat = $latitude;
                                                            $pm_out_lon = $longitude;
                                                            $pm_out_time = $time;
                                                        ?>
                                                        <div style="padding: 2%;">
                                                            <img class="profile-user-img img-responsive" src="{{ $src_image }}" alt="User profile picture" onclick="rotate(this)">
                                                        </div>
                                                        <table class="table table-bordered table-striped">
                                                            <tr>
                                                                <td><div class="pull-right">Latitude :</div></td>
                                                                <td><small id="{{ $lat_element }}">{{ $latitude }}</small> <button class="btn btn-default btn-xs" type="button" onclick="copyToClipboard('{{ '#'.$lat_element }}')">Copy</button></td>
                                                            </tr>
                                                            <tr>
                                                                <td><div class="pull-right">Longitude :</div></td>
                                                                <td><small id="{{ $lon_element }}">{{ $longitude }}</small> <button class="btn btn-default btn-xs" type="button" style="margin-top: 1%" onclick="copyToClipboard('{{ '#'.$lon_element }}')">Copy</button></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="pull-right">Location :</div>
                                                                </td>
                                                                <td>
                                                                    <i class="ace-icon fa fa-hand-o-right"></i> <a href="https://www.latlong.net/Show-Latitude-Longitude.html" target="_blank"><strong>URL</strong></a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    @endif
                                                @endif
                                            @else
                                                <strong style="cursor: pointer;" class="editable badge bg-blue" id="<?php echo
                                                    $userid.'ñ'.
                                                    $row->datein.'ñ'.
                                                    str_replace(':','-',explode("_",explode('|',$row->time)[3])[2]).
                                                    'ñ'.explode("_",explode('|',$row->time)[3])[3].'ñ'.
                                                    "PM_OUT"."ñ".
                                                    $count;
                                                ?>">{{ strtoupper($time) }}</strong>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    <tr>
                                        <td colspan="5"></td>
                                    </tr>
                                </table>
                            </div>
                            <form action="{{ asset('FPDF/timelog/print_individual1.php') }}" target="_blank" method="POST">
                                <div style="padding: 1%;margin-top: -2%;float: right">
                                    <label class="bg-green" style=" height:34px; padding: 6px; color: white; border-radius: 3px; margin: 2px">{{Session::get('filter_dates')}}</label>
                                    <a target="_blank" href="{{ url('personal/excel/' . $userid . '?excel_range=' . Session::get('filter_dates')) }}" class="btn btn-success" style="color:white">
                                        <i class="fa fa-barcode"></i> Generate EXCEL
                                    </a>
                                    <button class="btn btn-success" name="filter_range" value="{{ Session::get('filter_dates') }}"><i class="fa fa-print"></i> Generate PDF</button>
                                </div>
                                <input type="hidden" name="userid" value="{{ $userid }}">
                                <input type="hidden" name="job_status" value="{{ $job_status }}">
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

@section('js')
    @parent
    <script>

        function rotate(image) {
            let rotateAngle = Number(image.getAttribute("rotangle")) + 90;
            image.setAttribute("style", "transform: rotate(" + rotateAngle + "deg)");
            image.setAttribute("rotangle", "" + rotateAngle);
        }

        $.fn.editable.defaults.mode = 'popup';

        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            $(element).addClass("highlight");
            setTimeout(function () {
                $(element).removeClass('highlight');
            }, 3000);
            document.execCommand("copy");
            $temp.remove();
        }

        $('#inclusive3').daterangepicker();
        $('#submit_logs').submit(function(){
            $('#print_individual').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        });

        function displayAll(element) {
            var check_all = '<span class="all_rows_span" style="margin-left: 5px">CHECK ALL:</span><input type="checkbox" class="all_rows_checkbox" name="update_all" style="margin-left:5px; width: 20px; transform: scale(1.5);" id="update_all">';

            $('.editable-popup .all_rows_span').remove();
            $('.editable-popup .all_rows_checkbox').remove();

            $(element).after(check_all);

        }

        $(function(){
            $(".editable").each(function(){
                console.log('editable');
                $('#'+this.id).editable({
                    type: 'radiolist',
                    value: '',
                    source: [
                        {value: 1, text: ''},
                    ],
                    validate: function(value) {
                        var ID = this.id;
                        console.log(ID);

                        var timelog = $("#"+this.id+"time_log").val();
                        var office_order = $("#"+this.id+"office_order").val();
                        var travel_order = $("#"+this.id+"travel_order").val();
                        var memorandum_order = $("#"+this.id+"memorandum_order").val();
                        var leave = $("#"+this.id+"leave").val();

                        var userid = this.id.split("ñ")[0];
                        var datein = this.id.split("ñ")[1];
                        var log_status = this.id.split("ñ")[3];
                        var log_type = this.id.split("ñ")[4];
                        var input_hidden_element = $("#"+this.id.split("ñ")[5]+"ñ"+log_type);
                        var time = input_hidden_element.val();
                        if(timelog){
                            log_status_change = "edited_change";
                            edited_display = timelog+":00";
                        }
                        else if(office_order){
                            log_status_change = "so_change";
                            edited_display = "RPO # "+office_order
                        }
                        else if(travel_order){
                            log_status_change = "to_change";
                            edited_display = "TO # "+travel_order
                        }
                        else if(memorandum_order){
                            log_status_change = "mo_change";
                            edited_display = "MO # "+memorandum_order
                        }
                        else if($("#"+this.id+"cdo").is(':checked')){
                            log_status_change = "cdo_change";
                            edited_display = "CDO";
                        }
                        else if(leave){
                            log_status_change = "leave_change";
                            edited_display = leave;
                        }
                        else if($("#"+this.id+"jobreak").is(':checked')){
                            log_status_change = "jobreak_change";
                            edited_display = "JO BREAK";
                        }
                        else if($("#"+this.id+"holiday").is(':checked')){
                            log_status_change = "holiday_change";
                            edited_display = "HOLIDAY";
                        }
                        else if($("#"+this.id+"dayoff").is(':checked')){
                            log_status_change = "dayoff_change";
                            edited_display = "DAY OFF";
                        }
                        else if($("#"+this.id+"flexi").is(':checked')){
                            log_status_change = "flexi_change";
                            edited_display = "FLEXI-TIME";
                        }
                        else if($("#"+this.id+"empty").is(':checked')){
                            log_status_change = "empty";
                            edited_display = "EMPTY";
                        }

                        json = {
                            "userid":userid,
                            "datein":datein,
                            "time":time,
                            "edited_display":edited_display,
                            "log_status":log_status,
                            "log_status_change": log_status_change,
                            "log_type":log_type
                        };
                        var url = "<?php echo asset('logs/timelog/edit'); ?>";

                        if($("#update_all").is(':checked')){
                            var all_entry = ['AM_IN', 'AM_OUT', 'PM_IN', 'PM_OUT'];
                            var all_data = this.id;
                            var part = all_data.split('ñ');

                            all_entry.forEach(function(data){
                                console.log("data "+data);
                                var input = $('#'+part[5]+'ñ'+data);
                                var strong_element = input.closest('td').find('strong');
                                var ID = strong_element.attr('id');
                                var id_parts = ID.split('ñ');
                                log_status = id_parts[3];
                                log_type = data;
                                time = input.val();

                                json = {
                                    "userid":userid,
                                    "datein":datein,
                                    "time":time,
                                    "edited_display":edited_display,
                                    "log_status":log_status,
                                    "log_status_change": log_status_change,
                                    "log_type":log_type
                                };

                                $.post(url,json,function(result){
                                    var input_hidden_time = result.display_time;
                                    input_hidden_element.val(input_hidden_time);
                                    var new_id = ID.replace(new RegExp(log_status, "g"),log_status_change == 'empty' ? log_status_change : log_status_change.split('_')[0]);

                                    $("#"+ID).attr('id',new_id); // this.id

                                    Lobibox.notify(result.notification,{
                                        msg:result.message
                                    });
                                });
                                $("#"+ID).html(edited_display);
                            });
                        }else{
                            $.post(url,json,function(result){
                                var input_hidden_time = result.display_time; //display hidden time for trapping and where purposes
                                input_hidden_element.val(input_hidden_time);
                                var new_id = ID.replace(new RegExp(log_status, "g"),log_status_change == 'empty' ? log_status_change : log_status_change.split('_')[0]);
                                console.log("log_status: "+log_status);
                                console.log("log_status_change: "+log_status_change);
                                console.log(json);
                                console.log("new_id: "+new_id);
                                $("#"+ID).attr('id',new_id);
                                Lobibox.notify(result.notification,{
                                    msg:result.message
                                });
                            });

                            $("#"+this.id).html(edited_display);
                        }
                    }
                });
            })
        });

        ( function($) {
            var Radiolist = function(options) {
                this.init('radiolist', options, Radiolist.defaults);
            };
            $.fn.editableutils.inherit(Radiolist, $.fn.editabletypes.checklist);
            console.log('radiobuttton');

            $.extend(Radiolist.prototype, {
                renderList : function() {
                    var $label;
                    this.$tpl.empty();
                    if (!$.isArray(this.sourceData)) {
                        return;
                    }

                    for (var i = 0; i < this.sourceData.length; i++) {
                        var ID = this.options.scope.id;
                        $label = $('<label>', {'class':this.options.inputclass}).append($('<input>', {
                            type : 'radio',
                            name : this.options.name,
                            value : this.sourceData[i].value
                        })).append($('<span>').text(this.sourceData[i].text));

                    }

                    this.$input = this.$tpl.find('input[type="radio"]');
                    var timelogToAppend = this.$tpl;
                    var am_in,am_out,pm_in,pm_out;
                    console.log(ID);
                    $(".arrow").removeClass("arrow");
                    am_in = $("#"+ID).parent().parent().children('td').children('input').get(0).value;
                    am_out = $("#"+ID).parent().parent().children('td').children('input').get(1).value;
                    pm_in = $("#"+ID).parent().parent().children('td').children('input').get(2).value;
                    pm_out = $("#"+ID).parent().parent().children('td').children('input').get(3).value;
                    var json = {
                        "elementId" : ID,
                        "am_in" : am_in,
                        "am_out" : am_out,
                        "pm_in" : pm_in,
                        "pm_out" : pm_out
                    };
                    var url = "<?php echo asset('logs/timelog/append') ?>";
                    $.post(url,json,function(result){
                        timelogToAppend.append(result);
                    });
                },
                input2value : function() {
                    return this.$input.filter(':checked').val();
                },
                str2value: function(str) {
                    return str || null;
                },

                value2input: function(value) {
                    this.$input.val([value]);
                },
                value2str: function(value) {
                    return value || '';
                },
            });

            Radiolist.defaults = $.extend({}, $.fn.editabletypes.list.defaults, {
                /**
                 @property tpl
                 @default <div></div>
                 **/
                tpl : '<div class="editable-radiolist" style="background-color: yellow"></div>',

                /**
                 @property inputclass, attached to the <label> wrapper instead of the input element
                 @type string
                 @default null
                 **/
                inputclass : '',

                name : 'defaultname'
            });

            $.fn.editabletypes.radiolist = Radiolist;
        }(window.jQuery));

    </script>


@endsection