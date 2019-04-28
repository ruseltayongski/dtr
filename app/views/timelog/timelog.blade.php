
@extends('layouts.app')

@section('content')
    <style>
        u{
            color: #307bff;
        }
    </style>
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <div class="row">
                <div class="col-md-12">
                    <form class="form-inline" autocomplete="off" method="POST" action="{{ asset('logs/timelog') }}" id="submit_logs" style="margin-right: 2%">
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
                            <div class="panel-heading">
                                <?php
                                    $from = explode('-',Session::get('filter_dates'))[0];
                                    $to = explode('-',Session::get('filter_dates'))[1];
                                ?>
                                <strong style="color: #f01786;font-size:medium;">Manage Time Log {{ ' - '.date('F d,Y',strtotime($from)).' to '.date('F d,Y',strtotime($to)) }}</strong>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-list table-hover table-striped">
                                        <tr>
                                            <th width="10%">Date In</th>
                                            <th width="10%">AM IN</th>
                                            <th width="10%">AM OUT</th>
                                            <th width="10%">PM IN</th>
                                            <th width="10%">PM OUT</th>
                                        </tr>
                                        <tbody class="timelog">
                                        <?php $count = 0; ?>
                                        @foreach($timeLog as $row)
                                        <?php $count++; ?>
                                        <tr>
                                            <td >{{ $row->datein }}</td>
                                            <td>
                                                @if(explode("_",explode('|',$row->time)[0])[1] == "''")
                                                    <b><u><span>{{ explode("_",explode('|',$row->time)[0])[0] }}</span></u></b>
                                                @else
                                                    <span style="cursor: pointer;" class="editable" id="<?php echo
                                                        Auth::user()->userid.'ñ'.
                                                        $row->datein.'ñ'.
                                                        str_replace(':','-',explode("_",explode('|',$row->time)[0])[2]).
                                                        'ñ'.explode("_",explode('|',$row->time)[0])[3].'ñ'.
                                                        "AM_IN"."ñ".
                                                        $count;
                                                    ?>">{{ explode("_",explode('|',$row->time)[0])[0] }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(explode("_",explode('|',$row->time)[1])[1] == "''")
                                                    <b><u><span>{{ explode("_",explode('|',$row->time)[1])[0] }}</span></u></b>
                                                @else
                                                    <span style="cursor: pointer;" class="editable" id="<?php echo
                                                        Auth::user()->userid.'ñ'.
                                                        $row->datein.'ñ'.
                                                        str_replace(':','-',explode("_",explode('|',$row->time)[1])[2]).
                                                        'ñ'.explode("_",explode('|',$row->time)[1])[3].'ñ'.
                                                        "AM_OUT"."ñ".
                                                        $count;
                                                    ?>">{{ explode("_",explode('|',$row->time)[1])[0] }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(explode("_",explode('|',$row->time)[2])[1] == "''")
                                                    <b><u><span>{{ explode("_",explode('|',$row->time)[2])[0] }}</span></u></b>
                                                @else
                                                    <span style="cursor: pointer;" class="editable" id="<?php echo
                                                        Auth::user()->userid.'ñ'.
                                                        $row->datein.'ñ'.
                                                        str_replace(':','-',explode("_",explode('|',$row->time)[2])[2]).
                                                        'ñ'.explode("_",explode('|',$row->time)[2])[3].'ñ'.
                                                        "PM_IN"."ñ".
                                                        $count;
                                                    ?>">{{ explode("_",explode('|',$row->time)[2])[0] }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(explode("_",explode('|',$row->time)[3])[1] == "''")
                                                    <b><u><span>{{ explode("_",explode('|',$row->time)[3])[0] }}</span></u></b>
                                                @else
                                                    <span style="cursor: pointer;" class="editable" id="<?php echo
                                                        Auth::user()->userid.'ñ'.
                                                        $row->datein.'ñ'.
                                                        str_replace(':','-',explode("_",explode('|',$row->time)[3])[2]).
                                                        'ñ'.explode("_",explode('|',$row->time)[3])[3].'ñ'.
                                                        "PM_OUT"."ñ".
                                                        $count;
                                                    ?>">{{ explode("_",explode('|',$row->time)[3])[0] }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                    <a href="#" id="username" style="color:black" data-type="radiolist"></a>
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
                        var edited_display,timelog,office_order,cdo,leave,userid,datein,time,log_type,log_status,log_status_change,url,json;

                        timelog = $("#"+this.id+"time_log").val();
                        office_order = $("#"+this.id+"office_order").val();
                        cdo = $("#"+this.id+"cdo").val();
                        leave = $("#"+this.id+"leave").val();

                        userid = this.id.split("ñ")[0];
                        datein = this.id.split("ñ")[1];
                        time = this.id.split("ñ")[2];
                        log_status = this.id.split("ñ")[3];
                        log_type = this.id.split("ñ")[4];
                        if(timelog){
                            log_status_change = "edited";
                            edited_display = timelog+":00";
                        }
                        else if(office_order){
                            log_status_change = "so";
                            edited_display = "SO#"+office_order
                        }
                        else if($("#"+this.id+"cdo").is(':checked')){
                            log_status_change = "cdo";
                            edited_display = "CDO";
                        }
                        else if(leave){
                            log_status_change = "leave";
                            edited_display = leave;
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

                        url = "<?php echo asset('logs/timelog/edit'); ?>";
                        $.post(url,json,function(result){
                           console.log(result);
                        });

                        $("#"+this.id).html(edited_display);
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
                    console.log(ID);
                    $.get("<?php echo asset('logs/append').'/' ?>"+ID,function(result){
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