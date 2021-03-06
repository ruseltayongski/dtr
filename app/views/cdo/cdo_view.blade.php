<title>CTO</title>
<head>
    <style>
        .align{
            text-align: center;
        }
        .align-right{
            text-align: right;
        }
        .align-left{
            text-align: left;
        }
        .new-times-roman{
            font-family: "Times New Roman", Times, serif;
            font-size: 11.5pt;
            padding: 15px;;
        }
        #border{
            border-collapse: collapse;
            border: 1px solid black;
        }
        .table-info tr td{
            font-weight:bold;
            color: #2b542c;
        }
        select {
            text-align-last: center;
        }
    </style>
</head>
<body>
<form action="{{ $data['asset'] }}" method="POST" class="form-submit">
    <input type="hidden" value="{{ csrf_token() }}" name="_token">
    <div class="clearfix"></div>
    <div class="new-times-roman table-responsive">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td class="align"><img src="{{ asset('public/img/doh.png') }}" width="100"></td>
                <td width="90%" >
                    <div class="align small-text">
                        Republic of the Philippines<br>
                        DEPARTMENT OF HEALTH<br>
                        <strong>CENTRAL VISAYAS CENTER for HEALTH DEVELOPMENT</strong><br>
                        Osmeña Boulevard,Sambag II,Cebu City, 6000 Philippines<br>
                        Regional Director’s Office Tel. No. (032) 253-6355 Fax No. (032) 254-0109<br>
                        Official Website: http://www.ro7.doh.gov.ph Email Address: dohro7@gmail.com<br>
                    </div>
                </td>
                <td class="align"><img src="{{ asset('public/img/f1.jpg') }}" width="100"></td>
            </tr>
        </table>
        <br>
        <table class="table table-hover table-striped">
            <tr>
                <td class="col-sm-1">Section: </td>
                <td>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-universal-access"></i>
                        </div>
                        <input type="text" value="{{ $data['section'] }}" class="form-control" readonly>
                    </div>
                </td>
                <td class="col-sm-1">Cluster: </td>
                <td >
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-universal-access"></i>
                        </div>
                        <input type="text" value="{{ $data['division'] }}" class="form-control" readonly>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="col-sm-1">Prepared Date: </td>
                <td>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar-o"></i>
                        </div>
                        <input class="form-control datepickercalendar" value="<?php if(isset($data['cdo']['prepared_date'])) echo date('m/d/Y',strtotime($data['cdo']['prepared_date'])); else echo date('m/d/Y'); ?>" name="prepared_date" required>
                    </div>
                </td>
                <td class="col-sm-1">Reason:</td>
                <td>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-book"></i>
                        </div>
                        <textarea name="subject" class="form-control" rows="1" style="resize: none;width: 100%;" required><?php if(isset($data['cdo']['subject']) and $data['type'] == 'update') echo $data['cdo']['subject'] ?></textarea>
                    </div>
                </td>
            </tr>
        </table>
        <table class="table table-hover table-striped">
            <tr>
                <td class="col-sm-7">
                    <table class="table table-list table-hover table-striped table-info">
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                        </tr>
                        <tr>
                            <td>
                                <i class="fa fa-user"></i>
                                {{ $data['name'] }}
                            </td>
                            <td>
                                <i class="fa fa-user-secret"></i>
                                {{ $data['position'] }}
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="col-sm-7">
                    <table class="table table-list table-hover table-striped">
                        <tr>
                            <td colspan="2">NUMBER OF WORKING DAY/S APPLIED FOR:</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control" value="<?php if(isset($data['cdo']['start'])) echo date('m/d/Y',strtotime($data['cdo']['start'])).' - '.date('m/d/Y',strtotime('-1 day',strtotime($data['cdo']['end']))); ?>" id="inclusive1" name="inclusive_dates" placeholder="Input date range here..." required>
                                </div>
                            </td>
                            <td class="col-sm-4">Inlusive Dates</td>
                        </tr>
                        <tr>
                            <td>
                                <select class="form-control cdo_hours" onchange="halfday($(this))" name="cdo_hours">
                                    <option value='cdo_wholeday'>WHOLEDAY</option>
                                    <option value='cdo_am'>AM</option>
                                    <option value='cdo_pm'>PM</option>
                                </select>
                            </td>
                            <td class="col-sm-4">am/pm/wholeday</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table class="table table-hover table-striped">
            <tr>
                <td class="col-sm-12">
                    <table class="table table-list table-hover table-striped">
                        <tr>
                            <td colspan="3"><strong>CERTIFICATION OF COMPENSATORY OVERTIME CREDITS</strong></td>
                        </tr>
                        <tr>
                            <td>Beginning Balance</td>
                            <td>Less Applied for</td>
                            <td>Remaining Balance</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" value="{{ $data['bbalance_cto'] }}" class="form-control beginning_balance" name="beginning_balance" maxlength="15" readonly>
                            </td>
                            <td>
                                <input type="text" value="<?php if($data['cdo']['less_applied_for']) echo $data['cdo']['less_applied_for']; else echo 0; ?>" class="form-control less_applied" name="less_applied" maxlength="15" readonly>
                            </td>
                            <td>
                                <input type="text" value="<?php if(isset($data)) {
                                        if($data['cdo']['remaining_balance'])
                                            echo $data['cdo']['remaining_balance'];
                                        else
                                            echo 0;
                                    } else echo $data['bbalance_cto']; ?>" class="form-control remaining_balance" name="remaining_balance" maxlength="15" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="alert-info" style="padding: 2%;">
                                    <span style="color:black;">
                                        <i class="fa fa-hand-o-right"></i> Note: The CDO/CTO beginning balance(credit) and remaining balance(credit) will be change when it was approve by the cdo/cto point person
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <td class="col-sm-7">
                    <table width="100%">
                        <tr><td class="align"><strong>THERESA Q. TRAGICO</strong></td></tr>
                        <tr><td class="align">Administrative Officer V</td></tr>
                        <tr><td class="align">Personel Section</td></tr>
                    </table>
                </td>
                <td>
                    <table width="100%">
                        <tr>
                            <td class="align">
                                <select class="chosen-select-static form-control" name="immediate_supervisor" required>
                                    @if($data['type'] == 'update')
                                        <option value="{{ $data['section_head'][0]['id'] }}">{{ $data['section_head'][0]['fname'].' '.$data['section_head'][0]['mname'].' '.$data['section_head'][0]['lname'] }}</option>
                                    @endif
                                    @foreach($data['section_head'] as $section_head)
                                        @if($data['section_head'][0]['id'] != $section_head['id'] and $data['type'] == 'update')
                                            <option value="{{ $section_head['id'] }}">{{ $section_head['fname'].' '.$section_head['mname'].' '.$section_head['lname'] }}</option>
                                        @elseif($data['type'] == 'add')
                                            <option value="{{ $section_head['id'] }}">{{ $section_head['fname'].' '.$section_head['mname'].' '.$section_head['lname'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr><td class="align">Immediate Supervisor</td></tr>
                        <tr>
                            <td class="align">
                                <br><br>
                                <select class="form-control" name="division_chief" required>
                                    @if($data['type'] == 'update')
                                        <option value="{{ $data['division_head'][0]['id'] }}">{{ $data['division_head'][0]['fname'].' '.$data['division_head'][0]['mname'].' '.$data['division_head'][0]['lname'] }}</option>
                                    @endif
                                    @foreach($data['division_head'] as $division_head)
                                        @if($data['division_head'][0]['id'] != $division_head['id'] and $data['type'] == 'update')
                                            <option value="{{ $division_head['id'] }}">{{ $division_head['fname'].' '.$division_head['mname'].' '.$division_head['lname'] }}</option>
                                        @elseif($data['type'] == 'add')
                                            <option value="{{ $division_head['id'] }}">{{ $division_head['fname'].' '.$division_head['mname'].' '.$division_head['lname'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr><td class="align">Division/Cluster Chief</td></tr>
                    </table>
                </td>
            </tr>
        </table>
        <hr>
        @if($data['type'] == "update")
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#deleteDocument" style="color:white"><i class="fa fa-trash"></i> Remove</button>
                <button type="button" class="btn btn-success" data-dismiss="modal" style="color:white" data-toggle="modal" data-target="#paperSize"><i class="fa fa-barcode"></i> Barcode v1</button>
                <a target="_blank" href="{{ asset('pdf/track') }}" class="btn btn-success" style="color:white"><i class="fa fa-barcode"></i> Barcode v2</a>
                <a target="_blank" href="{{ asset('form/cdov1/pdf') }}" class="btn btn-success" style="color:white"><i class="fa fa-barcode"></i> Barcode v3</a>
                @if(!$data['cdo']['approved_status'] || Auth::user()->usertype)
                    <button type="submit" class="btn btn-primary btn-submit" style="color:white"><i class="fa fa-pencil"></i> Update</button>
                @else
                    <button onclick="warning()" type="button" class="btn btn-primary btn-submit" style="color:white"><i class="fa fa-pencil"></i> Update</button>
                @endif
            </div>
        @else
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                <button type="submit" class="btn btn-success btn-submit" style="color:white;"><i class="fa fa-send"></i> Submit</button>
            </div>
        @endif
    </div>
</form>
</body>
<script>

    $('.chosen-select-static').chosen();
    $('.datepickercalendar').datepicker({
        autoclose: true
    });

    var cdo_hoursDefault = "<?php echo $data['cdo']['cdo_hours'] ?>";
    var halfdayFlag1  = true;
    var halfdayFlag2 = true;
    if(cdo_hoursDefault == 'cdo_am'){
        $(".cdo_hours").val($(".cdo_hours option:eq(1)").val());
        halfdayFlag2 = false;
    }
    else if(cdo_hoursDefault == 'cdo_pm') {
        $(".cdo_hours").val($(".cdo_hours option:eq(2)").val());
        halfdayFlag2 = false;
    }

    var rangeFlag = true;
    var less_applied,remaining_balance,diff,haldayDiff;

    $(function()
    {
        $("body").delegate("#inclusive1","focusin",function(){
            var today = new Date();

            var weekday = new Array(7);
            weekday[0] = "Sunday";
            weekday[1] = "Monday";
            weekday[2] = "Tuesday";
            weekday[3] = "Wednesday";
            weekday[4] = "Thursday";
            weekday[5] = "Friday";
            weekday[6] = "Saturday";

            var name_of_days = weekday[today.getDay()];
            var beforeDaysToApply;

            if( name_of_days == "Friday" ){
                beforeDaysToApply = 5;
            } else {
                beforeDaysToApply = 3;
            }

            var dd = today.getDate()+beforeDaysToApply;
            var mm = today.getMonth()+1;
            var yyyy = today.getFullYear();
            var startDate,endDate;
            @if(isset($data['cdo']['end']))
                startDate = "<?php echo date('m/d/Y',strtotime($data['cdo']['start'])); ?>";
            @else
                startDate = mm+'/'+dd+'/'+yyyy;
            @endif
            @if(isset($data['cdo']['end']))
                endDate = "<?php echo date('m/d/Y',strtotime('-1 day',strtotime($data['cdo']['end']))); ?>";
            @else
                endDate = mm+'/'+dd+'/'+yyyy;
            @endif
            $(this).daterangepicker({
                locale: {
                    format: 'MM/DD/YYYY'
                },
                minDate: mm+'/'+dd+'/'+yyyy,
                startDate: startDate,
                endDate: endDate,
            }).on('apply.daterangepicker', function(ev, picker)
            {
                var start = moment(picker.startDate.format('YYYY-MM-DD'));
                var end   = moment(picker.endDate.format('YYYY-MM-DD'));
                diff = end.diff(start, 'days'); // returns correct number
                less_applied = (diff+1)*8;

                console.log(start);
                if( less_applied < parseInt($(".beginning_balance").val())+8 ){
                    $(".less_applied").val(less_applied);
                }
                else {
                    Lobibox.alert('error', //AVAILABLE TYPES: "error", "info", "success", "warning"
                    {
                        msg: "Your beginning balance(credit) are not enough"
                    });
                }
                $(".remaining_balance").val( parseFloat($(".beginning_balance").val()) - parseFloat($(".less_applied").val()) );

                $(".cdo_hours").val($(".cdo_hours option:first").val());
                halfdayFlag1 = true;
                halfdayFlag2 = true;

            });
            $(".range_inputs").append("" +
                "<div class='alert-info'>" +
                    "<h6 style='color: #206ff0;padding-right: 5%;padding-left:5%'>Note: 3 working days before apply</h6>" +
                "</div>" +
                "");

        });
    });

    function halfday(data)
    {
        var cdo_hours = data.val();
      
        if(cdo_hours == 'cdo_wholeday'){
            if(halfdayFlag1){
                $(".less_applied").val( parseInt($(".less_applied").val()) + 4);
                halfdayFlag1 = false;
                halfdayFlag2 = true;
            }
        } 
        else {
            if(halfdayFlag2){
                $(".less_applied").val( parseInt($(".less_applied").val()) - 4 );
                halfdayFlag2 = false;
                halfdayFlag1 = true;
                wholedayFlag = true;
            }
        }
        $(".remaining_balance").val( parseInt($(".beginning_balance").val()) - parseInt($(".less_applied").val()) );

    }

    $('.form-submit').on('submit',function(){
        console.log(parseInt($(".less_applied").val()));

        <?php if(!Auth::user()->usertype): ?>

        if( parseInt($(".less_applied").val()) <= parseInt($(".beginning_balance").val()) ){
            $('.btn-submit').attr("disabled", true);
        }
        else {
            Lobibox.alert('error', //AVAILABLE TYPES: "error", "info", "success", "warning"
            {
                msg: "Your beginning balance(credit) are not enough"
            });
            $("#inclusive1").val('');
            return false;
        }

        <?php endif; ?>
    });

    $('input[name=approval]').on('ifChecked', function(event){
        $('input[name="disapproval"]').iCheck('uncheck');
    });
    $('input[name=disapproval]').on('ifChecked', function(event){
        $('input[name="approval"]').iCheck('uncheck');
    });

    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });

    function warning(){
        Lobibox.alert('info', //AVAILABLE TYPES: "error", "info", "success", "warning"
        {
            msg: "Cannot update if your CTO is already approved.."
        });
    }

</script>
