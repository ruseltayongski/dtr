@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <label class="text-success">Vacation Balance: <span class="badge bg-blue">{{ Session::get("vacation_balance") }}</span></label>
        <label class="text-danger">Sick Balance: <span class="badge bg-red">{{ Session::get("sick_balance") }}</span></label>
        <div class="alert alert-info"><strong>APPLICATION FOR LEAVE</strong> - (<small>CSC Form No.6 Revised 1998</small>)</div>
        <form action="{{ asset('form/leave') }}" method="POST">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" id="token" name="_token" value="<?php echo csrf_token(); ?>">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group has-success">
                                    <label class="control-label" for="inputSuccess1">(1.) Office/Agency</label>
                                    <input type="text" class="form-control" id="inputSuccess1" name="office_agency" value="DOH 7">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group has-success">
                                    <label class="control-label" for="inputSuccess1">(2.)  Last Name</label>
                                    <input type="text" class="form-control" id="inputSuccess1" name="lastname" value="{{ $user->lname }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group has-success">
                                    <label class="control-label" for="inputSuccess1">First Name</label>
                                    <input type="text" class="form-control" id="inputSuccess1" name="firstname" value="{{ $user->fname }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group has-success">
                                    <label class="control-label" for="inputSuccess1">Middle Name</label>
                                    <input type="text" class="form-control" id="inputSuccess1" name="middlename" value="{{ $user->mname }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 has-success">
                                <label class="control-label" for="inputSuccess1">(3.) Date of Filling</label>
                                <input type="text" class="form-control" name="date_filling" value="{{ date("Y-m-d") }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group has-success">
                                    <label class="control-label" for="inputSuccess1">(4.)  Position</label>
                                    <input type="text" class="form-control" id="inputSuccess1" name="position" value="{{ $user->designation }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group has-success">
                                    <label class="control-label" for="inputSuccess1">(5.)Salary (Monthly)</label>
                                    <input type="text" class="form-control" id="inputSuccess1" name="salary" value="{{ $user->monthly_salary }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="alert alert-info"><strong>DETAILS OF APPLICATION</strong></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>(6a) TYPE OF LEAVE</strong>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="has-success">
                                                @foreach(DB::table('leave_type')->get() as $row)
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="radio" class="minimal" id="leave_type" value="{{ $row->value }}" name="leave_type" onclick="dateRangeFunc('{{ $row->main_leave }}')" required>
                                                            {{ $row->desc }}
                                                            @if($row->value == 'Sick')
                                                            <div class="additional_sick"></div>
                                                            @endif
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <strong>(6c.) NUMBER OF WORKING DAYS APPLIED FOR :</strong>
                                <input type="text" class="form-control" name="applied_num_days" id="applied_num_days" readonly/>
                                <input type="hidden" class="form-control" name="credit_used" id="credit_used"/>
                                <div class="form-group inc_date_body"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <strong>(6b) WHERE LEAVE WILL BE SPENT</strong>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="has-success">
                                                    <div class="checkbox">
                                                        <label>(1.)In case of vacation leave</label>
                                                    </div>
                                                </div>
                                                <div class="has-success">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="radio" id="checkboxSuccess" class="vac_dis vac_dis_radio" value="local" name="vacation_loc">
                                                            Within the Philippines
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="has-success">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="radio" id="checkboxSuccess" class="vac_dis vac_dis_radio" value="abroad" name="vacation_loc">
                                                            Abroad (specify)
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="has-success">
                                                    <div class="form-group has-success">
                                                        <textarea type="text" class="form-control vac_dis vac_dis_txt" maxlength="200" id="inputSuccess1" name="abroad_others"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="has-success">
                                                    <div class="checkbox">
                                                        <label>(2.)In case of sick leave</label>
                                                    </div>
                                                </div>
                                                <div class="has-success">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="radio" id="checkboxSuccess" class="sic_dis sic_dis_radio" value="in_hostpital" name="sick_loc">
                                                            In Hospital (sepecify)
                                                            <input type="text"  name="in_hospital_specify" class="sic_dis sic_dis_txt" id="in_hos_txt" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="has-success">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="radio" id="checkboxSuccess" value="out_patient" name="sick_loc" class="sic_dis sic_dis_radio">
                                                            Out-patient (sepecify)
                                                            <input type="text" name="out_patient_specify" class="sic_dis sic_dis_txt" id="out_hos_txt" />
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <strong>(6d) COMMUTATION</strong>
                                    <div class="has-success">
                                        <div class="checkbox">
                                            <label>
                                                <input type="radio" id="checkboxSuccess" value="yes" name="com_requested">
                                                Requested
                                            </label>
                                            <label>
                                                <input type="radio" id="checkboxSuccess" value="no" name="com_requested">
                                                Not Requested
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding: 1%">
                        <div class="col-md-12 float-right">
                            <button type="submit" name="submit" class="btn btn-primary btn-lg">Submit</button>
                        </div>
                    </div>
                </div>
            </div> <!-- PANEL BODY -->
        </form>
    </div>
@endsection
@section('js')
    @parent
    <script>

        var vacation_balance = "<?php echo Session::get('vacation_balance'); ?>";
        var sick_balance = "<?php echo Session::get('sick_balance'); ?>";

        function clearHalfDaySickFirst(){
            $('input[name="half_day_first"]:checked').attr('checked',false);
        }
        function clearHalfDaySickLast(){
            $('input[name="half_day_last"]:checked').attr('checked',false);
        }

        function dateRangeFunc($main_leave){
            $(".inc_date_body").html(''); //clear
            $("#applied_num_days").val('');
            $("#credit_used").val('');

            var radio_val = $('input[name="leave_type"]:checked').val();
            var inc_date_element = '<strong class="control-label" >INCLUSIVE DATES :</strong>\n' +
                '                                        <div class="input-group">\n' +
                '                                            <div class="input-group-addon">\n' +
                '                                                <i class="fa fa-calendar"></i>\n' +
                '                                            </div>\n' +
                '                                            <input type="text" class="form-control" id="inc_date" name="inc_date" placeholder="Input date range here..." required onkeypress="return false;" >\n' +
                '                                        </div>';
            $(".inc_date_body").html(inc_date_element);
            $("#inc_date").attr('autocomplete', 'off');

            $("body").delegate("#inc_date","focusin",function() {
                $(".working_days_noted").html('');
            }); //clear
            if(radio_val == 'Vacation') {
                console.log(radio_val);
                $("body").delegate("#inc_date","focusin",function() {
                    $(".range_inputs").append("" +
                        "<div class='alert-info working_days_noted'>" +
                        "<h6 style='padding-right: 5%;padding-left:5%'>Note: 5 working days before apply for vacation leave</h6>" +
                        "</div>" +
                        "");
                });
            }
            if(radio_val == 'Sick'){
                var additional_sick = '<ul>\n' +
                    '                                                                Half day in first day? Please select.\n' +
                    '                                                                <ul>\n' +
                    '                                                                    <li>\n' +
                    '                                                                        <label>\n' +
                    '                                                                            <input type="radio" id="leave_type" value="AM" name="half_day_first" />\n' +
                    '                                                                            AM sick\n' +
                    '                                                                        </label>\n' +
                    '                                                                        <label>\n' +
                    '                                                                            <input type="radio" id="leave_type" value="PM" name="half_day_first" />\n' +
                    '                                                                            PM sick\n' +
                    '                                                                        </label>\n' + '<button type="button" onclick="clearHalfDaySickFirst();">Clear</button>' +
                    '                                                                    </li>\n' +
                    '                                                                </ul>\n' +
                    '                                                                Half day in last day? Please select.\n' +
                    '                                                                <ul>\n' +
                    '                                                                    <li>\n' +
                    '                                                                        <label>\n' +
                    '                                                                            <input type="radio" id="leave_type" value="AM" name="half_day_last" />\n' +
                    '                                                                            AM sick\n' +
                    '                                                                        </label>\n' +
                    '                                                                        <label>\n' +
                    '                                                                            <input type="radio" id="leave_type" value="PM" name="half_day_last" />\n' +
                    '                                                                            PM sick\n' +
                    '                                                                        </label>\n' + '<button type="button" onclick="clearHalfDaySickLast();">Clear</button>' +
                    '                                                                    </li>\n' +
                    '                                                                </ul>\n' +
                    '                                                        </ul>';
                $(".additional_sick").html(additional_sick);
            } else {
                $(".additional_sick").html('');
            }

            $('#inc_date').daterangepicker().on('apply.daterangepicker', function(ev, picker)
            {
                var start = moment(picker.startDate.format('YYYY-MM-DD')).add(1, 'days');
                var end   = moment(picker.endDate.format('YYYY-MM-DD')).add(1, 'days');
                var interval_days = end.diff(start,'days')+1; // returns correct number
                var applied_days = 0;
                var leave_balance_applied = 0;
                var sub_date,day_name,leave_condition = '';
                var days = new Array(7);
                days[0] = "Sunday";
                days[1] = "Monday";
                days[2] = "Tuesday";
                days[3] = "Wednesday";
                days[4] = "Thursday";
                days[5] = "Friday";
                days[6] = "Saturday";

                for(var i = 0; i < interval_days; i++) {
                    sub_date = end.subtract(1,'d').format('YYYY-MM-DD');
                    day_name = days[new Date(sub_date).getDay()];
                    if(day_name != "Saturday" && day_name != "Sunday"){
                        applied_days++;
                    }
                }

                console.log("applied days:"+applied_days);
                leave_balance_applied = applied_days * 8;

                var half_day_first = $('input[name="half_day_first"]:checked').val();
                var half_day_last = $('input[name="half_day_last"]:checked').val();

                if(half_day_first !== undefined){
                    leave_balance_applied -= 4;
                    applied_days -= 0.5;
                }
                if(half_day_last !== undefined){
                    leave_balance_applied -= 4;
                    applied_days -= 0.5;
                }
                if($main_leave == 'no'){
                    leave_balance_applied = 0;
                }

                if( (leave_balance_applied <= 4 && radio_val =='Sick' ) || radio_val == 'Sick' ){
                    leave_condition = sick_balance;
                    $("#credit_used").val('sick_balance');
                }
                else if(radio_val == 'Vacation'){
                    leave_condition = vacation_balance;
                    $("#credit_used").val('vacation_balance');
                }
                else{
                    leave_condition = 0;
                    $("#credit_used").val('');
                }

                console.log(leave_balance_applied);
                console.log(leave_condition);

                if( leave_balance_applied <= leave_condition ){
                    $("#applied_num_days").val(applied_days);
                }
                else {
                    Lobibox.alert('error', //AVAILABLE TYPES: "error", "info", "success", "warning"
                    {
                        msg: "INSUFFICIENT LEAVE BALANCE"
                    });

                    $("#applied_num_days").val('');
                    $("#inc_date").val('');
                    $("#credit_used").val('');
                }


            });

        }



        $('input[name="leave_type"]').change(function(){

            var val = this.value;
        
            if(val == "Vacation")
            {
                vac_radio_txt(false,false,'');
                sick_radio_txt(true,false,'');
                others1_txt(true,'');
                others2_txt(true,'');

            } else if(val == "To_sake_employement") 
            {
                vac_radio_txt(true,false,'');
                sick_radio_txt(true,false,'');
                others1_txt(true,'');
                others2_txt(true,'');

            } else if(val == "Others")
            {
                vac_radio_txt(true,false,'');
                sick_radio_txt(true,false,'');
                others1_txt(false,'');
                others2_txt(true,'');
            } else if(val == "Sick") 
            {
                vac_radio_txt(true,false,'');
                sick_radio_txt(false,false,'');
                others1_txt(true,'');
                others2_txt(true,'');

            } else if(val == "Maternity")
            {
                vac_radio_txt(true,false,'');
                sick_radio_txt(true,false,'');
                others1_txt(true,'');
                others2_txt(true,'');
            } else if(val == "Others2")
            {
                vac_radio_txt(true,false,'');
                sick_radio_txt(true,false,'');
                others1_txt(true,'');
                others2_txt(false,'');
            }
            
        });

       $('input[name="vacation_loc"]').change(function(){
            var val = this.value;
            if(val == "local")
            {
                $('.vac_dis_txt').prop('disabled', true).val('');
            } else if(val == "abroad"){
                $('.vac_dis_txt').prop('disabled', false).val('');

            }
       });

       $('input[name="in_hostpital"]').change(function(){
            var val = this.attr('checked');
            alert(val);
       });
    
        $('input[name="sick_loc"]').change(function(){
            var val = this.value;
            if(val == "in_hostpital")
            {
                $('#in_hos_txt').prop('disabled', false).val('');
                $('#out_hos_txt').prop('disabled',true).val('');
            }else if(val == "out_patient")
            {
                $('#out_hos_txt').prop('disabled',false).val('');
                $('#in_hos_txt').prop('disabled', true).val('');
            }
        }); 

         $('#in_hos_txt').prop('disabled', true);
         $('#out_hos_txt').prop('disabled',true);
        function vac_radio_txt(state,checked,txt_val)
        {
            $('.vac_dis').prop('disabled', state);
            $('.vac_dis_txt').val(txt_val);
            $('.vac_dis_txt').prop('disabled', state);
            $('.vac_dis_radio').prop('checked', checked);
        }
        function sick_radio_txt(state,checked,txt_val)
        {
             $('.sic_dis').prop('disabled', state);
             $('.sic_dis_radio').prop('disabled', state);
             $('.sic_dis_radio').prop('checked', checked);
             $('.sic_dis_txt').val(state);
             $('.sic_dis_txt').val(txt_val);   
        }

        function others1_txt(state,txt_val)
        {
            $('.others1_txt').val(txt_val);
            $('.others1_txt').prop('disabled', state);
            
        }
        function others2_txt(state,txt_val)
        {
            $('.others2_txt').val(txt_val);
            $('.others2_txt').prop('disabled', state);
        }


        function validate(evt) {
            var theEvent = evt || window.event;
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode( key );
            var regex = /[0-9]|\./;
            if( !regex.test(key) ) {
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
            }
            
        }

    </script>
@endsection