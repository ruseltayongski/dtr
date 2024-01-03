


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
<form action="{{ $data['asset'] }}" method="POST" class="form-submit" id="mainForm">
    <input type="hidden" value="{{ csrf_token() }}" name="_token">
    <div class="clearfix"></div>
    <div class="new-times-roman table-responsive">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td class="align"><img src="{{ asset('public/img/doh.png') }}" width="100"></td>
                <td width="90%" >
                    <div class="align small-text">
                        DEPARTMENT OF HEALTH<br>
                        <strong>CENTRAL VISAYAS CENTER for HEALTH DEVELOPMENT VII<br>
                            APPLICATION FOR COMPENSATORY TIME OFF</strong><br>
                    </div>
                </td>
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
                <td class="col-sm-1">Division: </td>
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
                        <input class="form-control datepickercalendar" id="prepared_date" value="<?php if(isset($data['cdo']['prepared_date'])) echo date('m/d/Y',strtotime($data['cdo']['prepared_date'])); else echo date('m/d/Y'); ?>" name="prepared_date" requiredm readonly>
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
                <td style="width: 58%">
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
                <td style="width: 42%">
                    <table class="table table-list table-hover table-striped" id="myTable">
                        <tr>
                            <td colspan="4">NUMBER OF WORKING DAY/S APPLIED FOR:</td>
                        </tr>
                        <tr>
                            <td>
                                <span style="display: inline-block;">Inclusive Dates:</span>
                                <div style="display: inline-block;">
                                    <button style="width: 50px; display: inline-block; margin-left: 155px" class="btn btn-sm btn-default addButton" type="button"><strong>+</strong></button>
                                </div>
                            </td>
                        </tr>

                        @if(isset($data['cdo']['start']))
                            <?php
                            $inclusiveDatesData = $data['inclusiveDates'];
                            ?>
                            @if(count($inclusiveDatesData) === 0)
                                    <tr class="newRow">
                                        <td>
                                            <label style="width: 160px; margin: 0; padding: 0;" id="date_label" name="date_label" class="date_label">
                                                {{ date('m/d/Y', strtotime($data['cdo']['start'])) }} - {{ date('m/d/Y', strtotime('-1 day', strtotime($data['cdo']['end']))) }}
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input style="width: 100px; margin-right: 5px; display: inline-block" type="text" class="form-control datepickerInput" value="{{ date('m/d/Y', strtotime($data['cdo']['start'])) }} - {{ date('m/d/Y', strtotime('-1 day', strtotime($data['cdo']['end']))) }}" id="inclusive1" name="inclusive_dates[]" placeholder="Input date here..." required>
                                                <select type="hidden" style="width: 120px; display: inline-block; margin-right: 5px" class="form-control cdo_hours" name="cdo_hours[]" required>
                                                    <option value="cdo_wholeday" {{$data['cdo']['cdo_hours'] === 'cdo_wholeday' ? 'selected' : '' }}>WHOLEDAY</option>
                                                    <option value="cdo_am" {{ $data['cdo']['cdo_hours'] === 'cdo_am' ? 'selected' : '' }}>AM</option>
                                                    <option value="cdo_pm" {{ $data['cdo']['cdo_hours'] === 'cdo_pm' ? 'selected' : '' }}>PM</option>
                                                </select>
                                                <button style="width: 45px; height: 33px" type="button" class="btn btn-sm btn-default deleteButton"><strong>-</strong></button>
                                            </div>
                                        </td>
                                    </tr>
                            @else
                                @foreach($data['inclusiveDates'] as $index => $inclusiveDates)
                                    <tr class="newRow">
                                        <td>
                                            <?php
                                            $start_date = $inclusiveDates['start_date'];
                                            $end_date = date('Y-m-d', strtotime('-1 day', strtotime($inclusiveDates['end_date'])));
                                            $formatted_range = date('m/d/Y', strtotime($start_date)) . ' - ' . date('m/d/Y', strtotime($end_date));
                                            ?>
                                            <label style="width: 300px; margin: 0; padding: 0;" id="date_label" name="date_label" class="date_label">
                                                <?php if($inclusiveDates['status'] == 1){
                                                    if($inclusiveDates['cdo_hours'] == "cdo_am"){
                                                        echo $formatted_range . '  (PM was CANCELLED)';
                                                    }else if ($inclusiveDates['cdo_hours'] == "cdo_pm"){
                                                        echo $formatted_range . '  (AM was CANCELLED)';
                                                    }else{
                                                        echo $formatted_range . '  (CANCELLED)';
                                                    }

                                                } else{
                                                    echo $formatted_range;} ?></label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input style="width: 100px; margin-right: 5px; display: inline-block" type="text" class="form-control datepickerInput" value="<?php echo date('m/d/Y', strtotime($inclusiveDates['start_date'])) . ' - ' . date('m/d/Y', strtotime('-1 day', strtotime($inclusiveDates['end_date']))); ?>" id="inclusive1" name="inclusive_dates[]" placeholder="Input date here..." required>
                                                <select type="hidden" style="width: 120px; display: inline-block; margin-right: 5px" class="form-control cdo_hours" name="cdo_hours[]" required>
                                                    <option value="cdo_wholeday" {{ $inclusiveDates['cdo_hours'] === 'cdo_wholeday' ? 'selected' : '' }}>WHOLEDAY</option>
                                                    <option value="cdo_am" {{ $inclusiveDates['cdo_hours'] === 'cdo_am' ? 'selected' : '' }}>AM</option>
                                                    <option value="cdo_pm" {{ $inclusiveDates['cdo_hours'] === 'cdo_pm' ? 'selected' : '' }}>PM</option>
                                                </select>
                                                <button style="width: 45px; height: 33px" type="button" class="btn btn-sm btn-default deleteButton"><strong>-</strong></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @else
                            <tr class="newRow">
                                <td>
                                    <label style="width: 170px; margin: 0; padding: 0;" class="date_label" id="date_label" name="date_label"></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input style="width: 100px; margin-right: 5px; display:inline-block;" type="text" class="form-control datepickerInput" value="" id="inclusive1" name="inclusive_dates[]" placeholder="Input date here..." required>
                                        <select type="hidden" style="width: 100px; display:inline-block; margin-right: 5px" class="form-control cdo_hours" name="cdo_hours[]">
                                            <option value='cdo_wholeday'>WHOLEDAY</option>
                                            <option value='cdo_am'>AM</option>
                                            <option value='cdo_pm'>PM</option>
                                        </select>
                                        <button style="width: 50px; height: 33px; margin-left: 4%" type="button" class="btn btn-sm btn-default deleteButton"><strong>-</strong></button>
                                    </div>
                                </td>
                            </tr>
                        @endif

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
                                <input type="text" value="<?php
                                if(isset($data['cdo']['less_applied_for']))
                                    echo $data['cdo']['less_applied_for'];
                                else
                                    echo 0;
                                ?>" class="form-control less_applied" name="less_applied" maxlength="15" readonly>
                            </td>
                            <td>
                                <input type="text" value="<?php
                                if(isset($data)) {
                                    if(isset($data['cdo']['remaining_balance']))
                                        echo $data['cdo']['remaining_balance'];
                                    else
                                        echo 0;
                                }
                                else
                                    echo $data['bbalance_cto'];
                                ?>" class="form-control remaining_balance" name="remaining_balance" maxlength="15" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="alert-info" style="padding: 2%;">
                                    <span style="color:black;">
                                        <i class="fa fa-hand-o-right"></i>
                                        Note: The CTO beginning balance and remaining balance will change once CTO is processed by the HRMO.
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
                                    @if(count($data['section_head']) > 0)
                                        @foreach($data['section_head'] as $section_head)
                                            @if(isset($section_head['id']))
                                                <option value="{{ $section_head['id'] }}">{{ $section_head['fname'].' '.$section_head['mname'].' '.$section_head['lname'] }}</option>
                                            @endif
                                        @endforeach
                                    @endif
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
                {{--@if(Auth :: user()->usertype !=1)--}}
                    @if ($data['cdo']['approved_status'] == 1 || $data['cdo']['approved_status'] == 3)
                    @else
                    <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#deleteDocument" style="color:white"><i class="fa fa-trash"></i> Remove</button>
                    @endif
                {{--@else--}}
                    {{--<button onclick="warning1()" type="button" class="btn btn-danger" ><i class="fa fa-trash"></i> Remove</button>--}}
                {{--@endif--}}
                <button type="button" class="btn btn-success" data-dismiss="modal" style="color:white" data-toggle="modal" data-target="#paperSize"><i class="fa fa-barcode"></i> Barcode v1</button>
                <a target="_blank" href="{{ asset('pdf/track') }}" class="btn btn-success" style="color:white"><i class="fa fa-barcode"></i> Barcode v2</a>
                <a target="_blank" href="{{ asset('form/cdov1/pdf') }}" class="btn btn-success" style="color:white"><i class="fa fa-barcode"></i> Barcode v3</a>
                @if( Auth::user()->usertype !=1)
                    @if ($data['cdo']['approved_status'] == 1 || $data['cdo']['approved_status'] == 3)
                    @else
                        <button type="submit" class="btn btn-primary btn-submit" style="color:white"><i class="fa fa-pencil"></i> Update</button>
                    @endif
                @else
                    <button type="button" class="btn btn-primary btn-submit" style="color:white"><i class="fa fa-pencil"></i> Update</button>
                @endif
            </div>
        @else
            <div class="modal-footer">
                <button type="button" class="btn btn-default"  data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                <button type="submit" class="btn btn-success btn-submit" style="color:white;"><i class="fa fa-send"></i> Submit</button>
            </div>
        @endif
    </div>
</form>
</body>


<script>
    var previousDate;
    var dates=[];
    var datesList=[];
    var totalDays=0;
    var updatedValue=[];
    var indexList=[];
    var deletedList=[];
    var deletedIndex=[];
    var deletedValue=[];
    $('.datepickerInput').on('click', function() {
        previousDate = $(this).val();
    });

    $('.datepickerInput').on('apply.daterangepicker', function() {
        var currentDate = $(this).val();
        if (previousDate !== currentDate){
            dates.push(previousDate);
        }
    });
    $('.chosen-select-static').chosen();


    $(document).ready(function () {


        <?php
        $privilege_employee = PrivilegeEmployee::get();
        $userid = Auth::user()->userid;
        $isPrivilegeEmployee = false;
        $personal_information= InformationPersonal::where('userid', '=', $userid)->first();
        $open_dates = false;
        if($personal_information){
            $division= $personal_information->division_id;
            $section= $personal_information->section_id;
            if($division == 3 && $section == 52 || $section == 53){
                $open_dates = true;
            }
        }
        foreach ($privilege_employee as $employee) {
            if ($employee->userid == $userid && $employee->status ==0) {
                $isPrivilegeEmployee = true;
                break;
            }
        }
        echo "var isPrivilegeEmployee = " . ($isPrivilegeEmployee ? 'true' : 'false') . ";";
        echo "var open_dates = " . ($open_dates ? 'true' : 'false') . ";";
        ?>
        var today = new Date();

        var dd = today.getDate();
        var dd2 = today.getDate();
        var mm = today.getMonth() + 1;
        var yyyy = today.getFullYear();

        var firstDayOfMonth = new Date(yyyy, mm - 1, 1);

        var daysDiff = Math.floor((today - firstDayOfMonth) / (1000 * 60 * 60 * 24)) + 1;
        var month =0;
        if(mm == 1){
            month = 12;
        }else{
            month = mm-1;
        }
        var startDate = month + '/' + (dd - daysDiff) + '/' + yyyy;
        var endDate = mm + '/' + dd2 + '/' + yyyy;

        if(isPrivilegeEmployee){
            if(open_dates){
                $('.datepickercalendar').datepicker({
                    autoclose: true,
                    locale: {
                        format: 'MM/DD/YYYY'
                    },
                    minDate: mm + '/' + dd + '/' + yyyy,
                    startDate: startDate,
                    endDate: endDate,
                });
            }else{
                $('.datepickercalendar').datepicker({
                    autoclose: true,
                    daysOfWeekDisabled: [0,6],
                    locale: {
                        format: 'MM/DD/YYYY'
                    },
                    minDate: mm + '/' + dd + '/' + yyyy,
                    startDate: startDate,
                    endDate: endDate,
                });
            }
        }else{
             startDate = mm + '/' + dd + '/' + yyyy;
             endDate = mm + '/' + dd + '/' + yyyy;
            $('.datepickercalendar').datepicker({
                autoclose: true,
                daysOfWeekDisabled: [0,6],
                locale: {
                    format: 'MM/DD/YYYY'
                },
                minDate: mm + '/' + dd + '/' + yyyy,
                startDate: startDate,
                endDate: endDate,
            });
        }

        $(".deleteButton").each(function () {

        });
        var row= $(this).closest("tr"); //.remove();
        var totalRows = row.siblings("tr").andSelf().length;
        if (totalRows-2 > 1) {
//            row.remove();
        }
        $(this).remove();
    });

    var cdo_hoursDefault = "<?php if(isset($data['inclusiveDates'])) foreach($data['inclusiveDates'] as $index=>$inclusiveDates)echo $inclusiveDates['cdo_hours'] ?>";
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

    function getAllCDO(row) {
        <?php

            $isTrue=false;
        if(isset($data['inclusiveDates'])){
            $isTrue=true;
        }else{
            $isTrue=false;
        }

        echo "var isTrue = " . ($isTrue ? 'true' : 'false') . ";";

        ?>

        var hours = [];
        var length= 0;
        var con1= 0;
        var con2=0;
        var startIndex= 0;
        var endIndex=0;
        var resultArray=[];

        if(isTrue==false){
            if (row) {
                row.find('.cdo_hours').each(function() {
                    var hour = $(this).val();
                    hours.push(hour);
                });
            }
            if(deletedList.length==0){
                length= hours.length + deletedList.length;
                con1= length/6;
                con2= con1 * 4;
                startIndex= con2;
                endIndex=startIndex+con1;
                resultArray=hours.slice(startIndex, endIndex);
            }else {
                length= hours.length + deletedList.length;
                con1= length/6;
                con2= con1 * 4;
                startIndex= con2;
                endIndex=startIndex+con1 - deletedList.length;
                resultArray=hours.slice(startIndex, endIndex);
            }

        }else{
            if (row) {
                row.find('.cdo_hours').each(function() {
                    var hour = $(this).val();
                    hours.push(hour);
                });
            }if(deletedList.length==0){
                length= hours.length;
                con1= length/6;
                con2= con1 * 3;
                startIndex= con2;
                endIndex=startIndex+con1;
                resultArray=hours.slice(startIndex, endIndex);
            }else{
                length= hours.length + deletedList.length;
                con1= length/6;
                con2= con1 * 3;
                startIndex= con2;
                endIndex=startIndex+con1-deletedList.length;
                resultArray=hours.slice(startIndex, endIndex);
            }
        }
        return resultArray;
        deletedList=[];
    }

    function getAllSelectedDates(row) {
        var selectedDates = [];
        var selected=[];
        var length=0;
        var con=0;
        var con1=0;
        var startIndex=0;
        var endIndex=0;

        <?php
        $isTrue=false;
        if(isset($data['inclusiveDates'])){
            $isTrue=true;
        }else{
            $isTrue=false;
        }
        echo "var isTrue = " . ($isTrue ? 'true' : 'false') . ";";
        ?>
        if (row) {
            row.find('.datepickerInput').each(function() {
                var selectedDate = $(this).val();
                selected.push(selectedDate);
            });
        }
        if(isTrue==true){
            if(deletedList.length==0){
                 length= selected.length;
                 con=length/6;
                 con1= length/2;
                 startIndex= con1;
                 endIndex=startIndex+con;
                selectedDates=selected.slice(startIndex, endIndex);
            }else{
                 length= selected.length +deletedList.length;
                 con=length/6;
                 con1= length/2;
                 startIndex= con1;
                 endIndex=startIndex+con - deletedList.length;
                selectedDates=selected.slice(startIndex, endIndex);
            }
        }else{
            if(deletedList.length==0){
                 length= selected.length;
                 con=length/6;
                 con1= (length/3)*2 ;
                 startIndex= con1;
                 endIndex=startIndex+con;
                selectedDates=selected.slice(startIndex, endIndex);
            }else{
                 length= selected.length +deletedList.length;
                 con=length/6;
                 con1= (length/3)*2 ;
                 startIndex= con1;
                 endIndex=startIndex+con - deletedList.length;
                selectedDates=selected.slice(startIndex, endIndex);
            }
        }
        return selectedDates;
    }
    function calculateCDO(cdo_hours) {
        if (cdo_hours=='cdo_am' || cdo_hours == 'cdo_pm'){
            return 4;
        }
        else{
            return 8;
        }
    }
    function calculateTotalDays(){
        var totalDays=0;

        var newRow= $('.newRow');
        var selectedDates = getAllSelectedDates(newRow);

        selectedDates.forEach(function (dateRange) {
            var startDate = dateRange.split(" - ")[0];
            var endDate = dateRange.split(" - ") [1];

            if(startDate !== '' && endDate !=='') {
                var start = moment(startDate, 'MM/DD/YYYY');
                var end = moment(endDate, 'MM/DD/YYYY');
                var diff = end.diff(start, 'days') + 1;

                if (!isNaN(diff)) {

                    totalDays += diff;
                }
            }
        });
        return totalDays;
    }

    function calculateTotalCDO(){
        var totalCDO=0;

        var newRow= $('.newRow');
        var selectedDates = getAllSelectedDates(newRow);
        var hours= getAllCDO(newRow);

        for (var i = 0; i < selectedDates.length; i++) {
            var cdoHours = hours[i];
            var computation=calculateCDO(cdoHours);
            var selectedDateRange = selectedDates[i];

            var startDate = selectedDateRange.split(" - ")[0];
            var endDate = selectedDateRange.split(" - ")[1];
            if (startDate !== '' && endDate !== '') {
                var start = moment(startDate, 'MM/DD/YYYY');
                var end = moment(endDate, 'MM/DD/YYYY');
                var diff = end.diff(start, 'days') + 1;

                if (!isNaN(computation) && !isNaN(diff)) {
                    totalCDO += computation * diff;
                }
            }
            }
        return totalCDO;
    }

    $(function () {

        $("body").delegate("#inclusive1", "focusin", function () {
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

            <?php
            $privilege_employee = PrivilegeEmployee::get();
            $userid = Auth::user()->userid;

            $isPrivilegeEmployee = false;

            $personal_information= InformationPersonal::where('userid', '=', $userid)->first();
            $open_dates = false;
            if($personal_information){
                $division= $personal_information->division_id;
                $section= $personal_information->section_id;
                if($division == 3 && $section == 52 || $section == 53){
                    $open_dates = true;
                }
            }

            foreach ($privilege_employee as $employee) {
                if ($employee->userid == $userid && $employee->status ==0) {
                    $isPrivilegeEmployee = true;
                    break;
                }
            }
                $holiday = Calendars::get();
                $holiday_dates = array();
                foreach ($holiday as $event) {
                    if($event->status == "1")
                    $holiday_dates[] = $event['start'];
                }
            echo "var holidays = " . json_encode($holiday_dates) . ";";
            echo "var isPrivilegeEmployee = " . ($isPrivilegeEmployee ? 'true' : 'false') . ";";
            echo "var open_dates = " . ($open_dates ? 'true' : 'false') . ";";
            echo "var userid = " . json_encode($userid) . ";";
            echo "var privilegeData = " . json_encode($privilege_employee) . ";";
            echo "var personal_information = " . json_encode($personal_information) . ";";
            ?>
            var name_of_days = weekday[today.getDay()];
            var beforeDaysToApply;
            if (open_dates) {
                beforeDaysToApply = 2;
            }
            else{
                if (name_of_days === "Friday") {
                    beforeDaysToApply = 2;
                } else {
                    beforeDaysToApply = 2;
                }
            }
            var dd = today.getDate();
            var mm = today.getMonth() + 1;
            var yyyy = today.getFullYear();

            function isHoliday(date) {
                const formattedDate = moment(date).format('YYYY-MM-DD');
                return holidays.includes(formattedDate);
            }

            function getNextValidDay(date, daysToSkip) {
                while (daysToSkip > 0 || isHoliday(date) || date.getDay() === 0 || date.getDay() === 6) {
                    if (!isHoliday(date) && date.getDay() !== 0 && date.getDay() !== 6) {
                        daysToSkip--;
                    }
                    date.setDate(date.getDate() + 1);
                }
                return date;
            }
                var nextValidDay = getNextValidDay(new Date(yyyy, mm - 1, dd), Math.abs(beforeDaysToApply));
                dd = nextValidDay.getDate();
                mm = nextValidDay.getMonth() + 1;
                yyyy = nextValidDay.getFullYear();
                // console.log('date', holidays);

             previousDate = $(this).val();

             if(previousDate !== ""){
                 startDate = previousDate.split(" - ")[0];
                 endDate = previousDate.split(" - ")[1];
             }else{

                 if(isPrivilegeEmployee && open_dates){

                     var firstDay = mm-1+'/01/'+yyyy;
                     startDate = firstDay;
                     endDate = today.getDate();

                }if(isPrivilegeEmployee){

                    var firstDay = mm-1+'/01/'+yyyy;
                    startDate = firstDay;
                    endDate = today.getDate();

                }else{
                    startDate = mm + '/' + dd + '/' + yyyy;
                    endDate = mm + '/' + dd + '/' + yyyy;
                }
            }

            $(this).daterangepicker({
                autoclose: true,
                locale: {
                    format: 'MM/DD/YYYY'
                },
                minDate:isPrivilegeEmployee ? mm - 1 + '/01/' + yyyy : mm + '/' + dd + '/' + yyyy,
                startDate: startDate,
                endDate: endDate,

            }).on('apply.daterangepicker', function (ev, picker) {


                var selectedStartDate = picker.startDate;
                var selectedEndDate = picker.endDate;

                var dateLabel = $(this).closest('.newRow').find('.date_label');
                if (typeof dateLabel !== 'undefined' && dateLabel.length > 0) {
                    dateLabel.text(selectedStartDate.format('MM/DD/YYYY') + ' - ' + selectedEndDate.format('MM/DD/YYYY'));
                } else {
                }
                dateLabel.val(selectedStartDate.format('MM/DD/YYYY') + ' - ' + selectedEndDate.format('MM/DD/YYYY'));
                $(this).val(selectedStartDate.format('MM/DD/YYYY') + ' - ' + selectedEndDate.format('MM/DD/YYYY'));

                var newRow= $('.newRow');
                var selectedDates = getAllSelectedDates(newRow);

                var totalDays = calculateTotalDays();
                var less_applied2 = calculateTotalCDO();

                var start = moment(picker.startDate.format('YYYY-MM-DD'));
                var end   = moment(picker.endDate.format('YYYY-MM-DD'));
                diff = end.diff(start, 'days'); // returns correct number
                TotalDate = diff+1;

                        {{--// to be continued //to avoid non consecutive days--}}
                        {{--<?php--}}
                        {{--$check = cdo::where('prepared_name', Auth::user()->userid)->orderBy('id', 'desc')->first();--}}
                        {{--$date_list = [];--}}
                        {{--if($check){--}}
                        {{--$days_applied = $check->less_applied_for;--}}

                        {{--$datelist =[];--}}
                        {{--$applied1 = [];--}}
                        {{--$diff1 =[];--}}
                        {{--$datess = cdo::where('prepared_name', Auth::user()->userid)->orderBy('id', 'desc')->take(5)->get();--}}
                        {{--if($datess){--}}
                        {{--foreach ($datess as $dates){--}}
                        {{--if(!Empty($dates)){--}}
                        {{--if($dates->less_applied_for == 8 or $dates->less_applied_for ==4){--}}
                        {{--$date_list[]= $dates->start;--}}
                        {{--}else{--}}
                        {{--$applied = CdoAppliedDate::where('cdo_id','=', $dates->id)->get();--}}
                        {{--$applied1[]=$applied;--}}

                        {{--foreach ($applied as $date){--}}

                        {{--$diff = (strtotime($date->start_date) - strtotime($date->end_date)) / (60 * 60 * 24) ;--}}
                        {{--$diff = -($diff);--}}
                        {{--$diff1[]=$diff;--}}

                        {{--if($diff == 1){--}}
                        {{--$date_list[]= date('F j, Y', strtotime($date->start_date));--}}
                        {{--} else{--}}
                        {{--$start = strtotime($date->start_date);--}}
                        {{--$end = strtotime($date->end_date);--}}

                        {{--while ($diff >= 1){--}}
                        {{--$end = strtotime('-1 day', $end);--}}
                        {{--$date_list[] = date('F j, Y', $end);--}}
                        {{--$diff--;--}}
                        {{--}--}}
                        {{--}--}}
                        {{--}--}}
                        {{--}--}}
                        {{--}--}}
                        {{--break;--}}
                        {{--}--}}
                        {{--}--}}
                        {{--$sorted = array_map('strtotime',$date_list);--}}
                        {{--array_multisort($sorted, SORT_ASC, $date_list);--}}
                        {{--$last_five = array_slice($date_list, -5);--}}
                        {{--$index = count($last_five);--}}
                        {{--$first = strtotime($last_five[$index-1]);--}}
                        {{--$value = date('m/d/Y',$first);--}}
                        {{--$num = $index-1;--}}
                        {{--$i = $index-2;--}}
                        {{--$data = [];--}}
                        {{--$total = 1;--}}

                        {{--$holiday = Calendars::get();--}}
                        {{--$holiday_dates = array();--}}
                        {{--foreach ($holiday as $event) {--}}
                        {{--$holiday_dates[] = $event['start'];--}}
                        {{--}--}}
                        {{--while($num>=1){--}}
                        {{--$data[] = date('F j, Y', $first);--}}
                        {{--$first = strtotime('-1 day', $first);--}}
                        {{--if($last_five[$i] == date('F j, Y', $first)){--}}
                        {{--$total = $total+1;--}}
                        {{--}--}}
                        {{--else{--}}
                        {{--$timestamp = strtotime($last_five[$i]);--}}
                        {{--$weekday = date("D", $timestamp);--}}

                        {{--if($weekday === "Sun" || $weekday === "Sat" || in_array($timestamp, $holiday_dates)){--}}
                        {{--$total = $total+1;--}}
                        {{--}else{--}}
                        {{--break;--}}
                        {{--}--}}
                        {{--}--}}
                        {{--$num--;--}}
                        {{--$i--;--}}
                        {{--}--}}
                        {{--$res = 5-$total;--}}
                        {{--$first1 = strtotime($last_five[$index-1]);--}}
                        {{--$date_after_date = [];--}}
                        {{--if($res ==0){--}}
                        {{--$first1 = strtotime('+1 day', $first1);--}}
                        {{--$date_after_date[]= date('m/d/Y',$first1);--}}
                        {{--}else{--}}
                        {{--while ($res>=1){--}}
                        {{--$first1 = strtotime('+1 day', $first1);--}}
                        {{--$date_after_date[]= date('m/d/Y',$first1);--}}
                        {{--$res--;--}}
                        {{--}--}}
                        {{--}--}}
                        {{--}else{--}}
                        {{--$days_applied = 0;--}}
                        {{--}--}}

                        {{--echo "var days_applied= " .json_encode(!Empty($days_applied)?$days_applied : '') .";";--}}
                        {{--echo "var res= " .json_encode(!Empty($total)? $total : 0) .";";--}}
                        {{--echo "var complete_date= " .json_encode(!Empty($date_after_date)? $date_after_date : '') .";";--}}
                        {{--?>--}}

                        {{--console.log ('dates', complete_date);--}}

                        {{--if(res == 0){--}}
                        {{--if(complete_date[0]== selectedStartDate.format('MM/DD/YYYY')){--}}
                        {{--fivedays();--}}
                        {{--}else{--}}
                        {{--}--}}
                        {{--}else{--}}
                        {{--if(complete_date.length <= totalDays){--}}
                        {{--if(selectedStartDate.format('MM/DD/YYYY') == complete_date[0] && selectedEndDate.format('MM/DD/YYYY') == complete_date[complete_date.length-1]){--}}
                        {{--fivedays();--}}
                        {{--}--}}
                        {{--}--}}
                        {{--}--}}
                var data = "<?php
                        $id=Auth::user()->userid ;
                        $all_cdo = cdo::where('prepared_name', $id)->where('approved_status', '0')->get();
                        $balance = 0;
                        if($all_cdo){
                            foreach ($all_cdo as $cdo){
                                $balance += $cdo->less_applied_for;
                            }
                            echo $balance;
                        }else{
                            echo $balance;
                        }
                        ?>";
                var balance = "<?php $pis = InformationPersonal::where('userid', Auth::user()->userid)->first(); echo !Empty($pis->bbalance_cto)?$pis->bbalance_cto :0;?>";
                var to_consume = balance - data;
                if(to_consume>=less_applied2){
                    if (totalDays<=5) {
                        if (less_applied2 < parseInt($(".beginning_balance").val()) + 8) {
                            $(".less_applied").val(less_applied2); //
                        }
                        else {
                            Lobibox.alert('error', //AVAILABLE TYPES: "error", "info", "success", "warning"
                                {
                                    msg: "Insufficient CTO balance."
                                });
                            $('.datepickerInput').val("");
                            $(".newRow").find("#date_label").text("");
                            $('.less_applied').val(0);
                        }
                    }
                    else {
                        fivedays();
                        $('.datepickerInput').val("");
                        $(".newRow").find("#date_label").text("");
                        $('.less_applied').val(0);
                    }
                }else{
                    if (less_applied2 <= parseInt($(".beginning_balance").val())) {
                        Lobibox.alert('error', {msg: "Insufficient CTO balance. Remove pending application."});
                    }
                    else{
                        Lobibox.alert('error', {msg: "Insufficient CTO balance."});

                    }

                    $('.datepickerInput').val("");
                    $(".newRow").find("#date_label").text("");
                    $('.less_applied').val(0);
                }

                $(".remaining_balance").val(parseFloat($(".beginning_balance").val()) - parseFloat($(".less_applied").val()));
//                $(".cdo_hours").val($(".cdo_hours option:first").val());
                halfdayFlag1 = true;
                halfdayFlag2 = true;
            });

            $(".range_inputs").append("" +
                "<div class='alert-info'>" +
                "<h6 style='color: #206ff0;padding-right: 5%;padding-left:5%'>Note: 2 working days before apply</h6>" +
                "</div>" +
                "");
        });
    });

    $ (".addButton").click(function(e){  //clonedRow =newRow;
        var row= $(this).closest("tr");
        var totalRows = row.siblings("tr").andSelf().length;
        if(totalRows-1<11){
            var newRow = $("#myTable .newRow:first").clone();
            newRow.removeAttr("style");
            newRow.attr("data-newly-added", "true");
            newRow.find(".datepickerInput").val("");
            newRow.find("#date_label").text("");
            newRow.find(".datepickerInput").daterangepicker();

            $("#myTable tbody").append(newRow);
            newRow.addClass("newRow");
        }else {
            limit();
            e.preventDefault();
        }
        e.preventDefault();
    });

    $(document).on("click",".deleteButton", function(){
        var row= $(this).closest("tr"); //.remove();
        var input= row.find("input[name='inclusive_dates[]']");
        var select= row.find("select[name='cdo_hours[]']");
        var selectedIndex = row.index();
        var deletedValue=select.val();

        deletedDate= input.val();
        var totalRows = row.siblings("tr").andSelf().length;
        if (totalRows-2 > 1) {
            deletedIndex.push(selectedIndex-2);
            deletedList.push(deletedValue);
            row.remove();
            var dates =document.getElementsByName('inclusive_dates[]');
            for (var i =0; i<dates.length; i++){
                if(dates[i].value == deletedDate){
                    datesList.push(dates[i].value);
                }
            }
        } else if (totalRows-2 ==1){
            $(".datepickerInput").val("");
            $(".newRow").find("#date_label").text("");
        }

        var row= $(".newRow").val();
        getAllCDO(row);
        var cdoHours = calculateTotalCDO();
        $(".less_applied").val(cdoHours);
        $(".remaining_balance").val(parseFloat($(".beginning_balance").val()) - parseFloat($(".less_applied").val()));
    });

    $(document).on('click','.cdo_hours', function () {
        latestValue = $(this).val();
    });

    $(document).on('change','.cdo_hours', function () {
        var selected = $(this).val();
        var selectedIndex = $('.cdo_hours').index(this);
        var index;
        var result;

        var element=$('.cdo_hours').length;
        if(element>0){
            index= element/2;
            result=selectedIndex-index;
        }
        indexList.push(result);
        updatedValue.push(selected);
        var row= $(".newRow").val();
        getAllCDO(row);
        var cdoHours = calculateTotalCDO();
        $(".less_applied").val(cdoHours);
        $(".remaining_balance").val(parseFloat($(".beginning_balance").val()) - parseFloat($(".less_applied").val()));
        var all=[];
        $(".newRow").find('.cdo_hours').each(function() {
            var hour = $(this).val();
            all.push(hour);
        });
        var leng= all.length;
        var con1= leng/6;
        var con2= con1 * 4;
        var startIndex= con2;
        var endIndex=startIndex+con1;
        var extractedArray=all.slice(startIndex, endIndex);
        var allAll = [];

        $(".newRow").each(function() {
            var modifiedValue = $(this).find('.cdo_hours').val();
            allAll.push(modifiedValue);
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

    $('.form-submit').on('submit',function(e){
        e.preventDefault();

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

            this.submit();
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
                msg: "Cannot update/remove approved CTO."
            });
    }
    function warning1(){
        Lobibox.alert('info', //AVAILABLE TYPES: "error", "info", "success", "warning"
            {
                msg: "Admin cannot modify/remove filed cto!"
            });
    }
    function limit(){
        Lobibox.alert('info', //AVAILABLE TYPES: "error", "info", "success", "warning"
            {
                msg: "Limit to 10 rows only!"
            });
    }
    function fivedays(){
        Lobibox.alert('error', //AVAILABLE TYPES: "error", "info", "success", "warning"
            {
                msg: "The use of CTO can be used continuously up to a maximum of five(5) consecutive day per single availment, or on staggered basis within the year."
            });
        $('.datepickerInput').val("");
        $(".newRow").find("#date_label").text("");
    }

</script>