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
    </style>
    <div class="row">
        <div class="col-md-12">
            <form class="form-inline" autocomplete="off" method="POST" action="{{ $supervisor ? asset('logs/timelogs/supervisor') : asset('logs/timelogs') }}" id="submit_logs" style="margin-right: 2%">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="text" class="form-control filter_dates" value="{{ Session::get('filter_dates') }}" id="inclusive3" name="filter_dates" placeholder="Filter Date" readonly>
                <button type="submit" class="btn btn-primary" id="print">
                    Generate
                </button>
                <div class="label pull-right bg-red" style="font-size: 12pt">{{ $timeLog[0]->name }}</div>
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
                                    <tr>
                                        <td>
                                            <strong class="text-green">{{ date("F d, Y",strtotime($row->datein)) }}</strong><br>
                                            <small class="text-orange" style="font-size: 8pt;">{{ $row->dayname }}</small>
                                        </td>
                                        <td> <!-- AM IN -->
                                            <input type="hidden" value="{{ explode("_",explode('|',$row->time)[0])[2] }}" id="{{ $count."ñ"."AM_IN" }}">
                                            <?php $time = explode("_",explode('|',$row->time)[0])[0]; ?>
                                            @if(empty(explode("_",explode('|',$row->time)[0])[1]) || explode("_",explode('|',$row->time)[0])[3] == 'mobile')
                                                <strong class="badge bg-green" style="font-size: 10pt">{{ $time }}</strong><br>
                                                @if(isset(explode("_",explode('|',$row->time)[0])[4]) && isset(explode("_",explode('|',$row->time)[0])[5]))
                                                    <?php
                                                        $latitude = explode("_",explode('|',$row->time)[0])[4];
                                                        $longitude = explode("_",explode('|',$row->time)[0])[5];
                                                    ?>
                                                    @if($latitude != "empty" && $longitude != "empty")
                                                        <?php
                                                            $lat_element = 'lat'.date("YmdHis",strtotime($row->datein.$time)).'am_in';
                                                            $lon_element = 'lon'.date("YmdHis",strtotime($row->datein.$time)).'am_in';
                                                        ?>
                                                        Latitude : <small id="{{ $lat_element }}">{{ $latitude }}</small> <button class="btn btn-default btn-xs" type="button" onclick="copyToClipboard('{{ '#'.$lat_element }}')">Copy</button><br>
                                                        Longitude : <small id="{{ $lon_element }}">{{ $longitude }}</small> <button class="btn btn-default btn-xs" type="button" style="margin-top: 1%" onclick="copyToClipboard('{{ '#'.$lon_element }}')">Copy</button><br>
                                                        <i class="ace-icon fa fa-hand-o-right"></i> <a href="https://www.latlong.net/Show-Latitude-Longitude.html" target="_blank"><strong>location url</strong></a>
                                                    @endif
                                                @endif
                                            @else
                                                <strong style="cursor: pointer;" class="editable text-blue" id="<?php echo
                                                    Auth::user()->userid.'ñ'.
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
                                            @if(empty(explode("_",explode('|',$row->time)[1])[1]) || explode("_",explode('|',$row->time)[1])[3] == 'mobile')
                                                <strong class="badge bg-green">{{ $time }}</strong><br>
                                                @if(isset(explode("_",explode('|',$row->time)[1])[4]) && isset(explode("_",explode('|',$row->time)[1])[5]))
                                                    <?php
                                                        $latitude = explode("_",explode('|',$row->time)[1])[4];
                                                        $longitude = explode("_",explode('|',$row->time)[1])[5];
                                                    ?>
                                                    @if($latitude != "empty" && $longitude != "empty")
                                                        <?php
                                                            $lat_element = 'lat'.date("YmdHis",strtotime($row->datein.$time)).'am_out';
                                                            $lon_element = 'lon'.date("YmdHis",strtotime($row->datein.$time)).'am_out';
                                                        ?>
                                                        Latitude : <small id="{{ $lat_element }}">{{ $latitude }}</small> <button class="btn btn-default btn-xs" type="button" onclick="copyToClipboard('{{ '#'.$lat_element }}')">Copy</button><br>
                                                        Longitude : <small id="{{ $lon_element }}">{{ $longitude }}</small> <button class="btn btn-default btn-xs" type="button" style="margin-top: 1%" onclick="copyToClipboard('{{ '#'.$lon_element }}')">Copy</button><br>
                                                        <i class="ace-icon fa fa-hand-o-right"></i> <a href="https://www.latlong.net/Show-Latitude-Longitude.html" target="_blank"><strong>location url</strong></a>
                                                    @endif
                                                @endif
                                            @else
                                                <strong style="cursor: pointer;" class="editable text-blue" id="<?php echo
                                                    Auth::user()->userid.'ñ'.
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
                                            @if(empty(explode("_",explode('|',$row->time)[2])[1]) || explode("_",explode('|',$row->time)[2])[3] == 'mobile')
                                                <strong class="badge bg-green">{{ $time }}</strong><br>
                                                @if(isset(explode("_",explode('|',$row->time)[2])[4]) && isset(explode("_",explode('|',$row->time)[2])[5]))
                                                    <?php
                                                        $latitude = explode("_",explode('|',$row->time)[2])[4];
                                                        $longitude = explode("_",explode('|',$row->time)[2])[5];
                                                    ?>
                                                    @if($latitude != "empty" && $longitude != "empty")
                                                        <?php
                                                            $lat_element = 'lat'.date("YmdHis",strtotime($row->datein.$time)).'pm_in';
                                                            $lon_element = 'lon'.date("YmdHis",strtotime($row->datein.$time)).'pm_in';
                                                        ?>
                                                        Latitude : <small id="{{ $lat_element }}">{{ $latitude }}</small> <button class="btn btn-default btn-xs" type="button" onclick="copyToClipboard('{{ '#'.$lat_element }}')">Copy</button><br>
                                                        Longitude : <small id="{{ $lon_element }}">{{ $longitude }}</small> <button class="btn btn-default btn-xs" type="button" style="margin-top: 1%" onclick="copyToClipboard('{{ '#'.$lon_element }}')">Copy</button><br>
                                                        <i class="ace-icon fa fa-hand-o-right"></i> <a href="https://www.latlong.net/Show-Latitude-Longitude.html" target="_blank"><strong>location url</strong></a>
                                                    @endif
                                                @endif
                                            @else
                                                <strong style="cursor: pointer;" class="editable text-blue" id="<?php echo
                                                    Auth::user()->userid.'ñ'.
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
                                            @if(empty(explode("_",explode('|',$row->time)[3])[1]) || explode("_",explode('|',$row->time)[3])[3] == 'mobile')
                                                <strong class="badge bg-green">{{ explode("_",explode('|',$row->time)[3])[0] }}</strong><br>
                                                @if(isset(explode("_",explode('|',$row->time)[3])[4]) && isset(explode("_",explode('|',$row->time)[3])[5]))
                                                    <?php
                                                        $latitude = explode("_",explode('|',$row->time)[3])[4];
                                                        $longitude = explode("_",explode('|',$row->time)[3])[5];
                                                    ?>
                                                    @if($latitude != "empty" && $longitude != "empty")
                                                        <?php
                                                            $lat_element = 'lat'.date("YmdHis",strtotime($row->datein.$time)).'pm_out';
                                                            $lon_element = 'lon'.date("YmdHis",strtotime($row->datein.$time)).'pm_out';
                                                        ?>
                                                        Latitude : <small id="{{ $lat_element }}">{{ $latitude }}</small> <button class="btn btn-default btn-xs" type="button" onclick="copyToClipboard('{{ '#'.$lat_element }}')">Copy</button><br>
                                                        Longitude : <small id="{{ $lon_element }}">{{ $longitude }}</small> <button class="btn btn-default btn-xs" type="button" style="margin-top: 1%" onclick="copyToClipboard('{{ '#'.$lon_element }}')">Copy</button><br>
                                                        <i class="ace-icon fa fa-hand-o-right"></i> <a href="https://www.latlong.net/Show-Latitude-Longitude.html" target="_blank"><strong>location url</strong></a>
                                                    @endif
                                                @endif
                                            @else
                                                <strong style="cursor: pointer;" class="editable text-blue" id="<?php echo
                                                    Auth::user()->userid.'ñ'.
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
                                </table>
                            </div>
                            <form action="{{ asset('FPDF/timelog/print_individual1.php') }}" target="_blank" method="POST">
                                <div style="padding: 1%;margin-top: -2%;float: right">
                                    <button class="btn btn-success" name="filter_range" value="{{ Session::get('filter_dates') }}"><i class="fa fa-print"></i> Generate PDF</button>
                                </div>
                                <input type="hidden" name="userid" value="{{ $userid }}">
                                <input type="hidden" name="job_status" value="{{ Session::get('job_status') }}">
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

        $.fn.editable.defaults.mode = 'inline';

        $(function(){
            $(".editable").each(function(){
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
                        var time = this.id.split("ñ")[2];
                        var log_status = this.id.split("ñ")[3];
                        var log_type = this.id.split("ñ")[4];
                        if(timelog){
                            log_status_change = "edited_change";
                            edited_display = timelog+":00";
                        }
                        else if(office_order){
                            log_status_change = "so_change";
                            edited_display = "SO # "+office_order
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
                        console.log(json);
                        /*var url = "<?php echo asset('logs/timelog/edit'); ?>";
                        var input_hidden_element = $("#"+this.id.split("ñ")[5]+"ñ"+log_type);
                        $.post(url,json,function(result){
                            console.log(ID.replace(/cdo/g,log_status_change));
                            var input_hidden_time = result.display_time; //display hidden time for trapping and where purposes
                            input_hidden_element.val(input_hidden_time);
                            Lobibox.notify(result.notification,{
                                msg:result.message
                            });
                        });
                        $("#"+this.id).html(edited_display);*/
                    }
                });
            })
        });

        ( function($) {
            var Radiolist = function(options) {
                this.init('radiolist', options, Radiolist.defaults);
            };
            $.fn.editableutils.inherit(Radiolist, $.fn.editabletypes.checklist);

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
                    //console.log(ID);
                    am_in = $("#"+ID).parent().parent().children('td').children('input').get(0).value;
                    am_out = $("#"+ID).parent().parent().children('td').children('input').get(1).value;
                    pm_in = $("#"+ID).parent().parent().children('td').children('input').get(2).value;
                    pm_out = $("#"+ID).parent().parent().children('td').children('input').get(3).value;
                    console.log($("#"+ID).parent().parent().children('td').children('input').get(0).value);
                    var json = {
                        "elementId" : ID,
                        "am_in" : am_in,
                        "am_out" : am_out,
                        "pm_in" : pm_in,
                        "pm_out" : pm_out
                    };
                    console.log(json);
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
                tpl : '<div class="editable-radiolist"></div>',

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