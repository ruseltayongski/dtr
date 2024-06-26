{{--<form action="{{ asset('leave/update/save') }}" method="POST">--}}
    {{--<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">--}}
    {{--<input type="hidden" name="id" value="{{ $leave->id }}" />--}}
    {{--<div class="row">--}}
@extends('layouts.app')

@section('content')

    <div class="panel panel-default">
        {{--<label class="text-success">Vacation Balance: <span class="badge bg-blue">{{ Session::get("vacation_balance") }}</span></label>--}}
        {{--<label class="text-danger">Sick Balance: <span class="badge bg-red">{{ Session::get("sick_balance") }}</span></label>--}}
        <div>
            <table cellpadding="0" cellspacing="0" width="100%" style="margin-top: 10px">
                <tr>
                    <td class="align" width="10%" style="text-align: center; vertical-align: top;"><h6>CSC Form No.8<br>Revised 2020</h6></td>
                    <td class="align" width="12%" style="text-align: right"><img src="{{ asset('public/img/doh.png') }}" width="100" ></td>
                    <td width="60%" >
                        <div class="align small-text" style="text-align: center">
                            Republic of the Philippines<br>
                            <strong>DEPARTMENT OF HEALTH<br>
                                CENTRAL VISAYAS CENTER for HEALTH DEVELOPMENT<br></strong>
                            Osmeña Boulevard, Cebu City, 6000 Philippines<br>
                        </div>
                    </td>
                    <td class="align" width="30%" style="text-align: center; vertical-align: center;"><h6>
                            <u>{{ date("Y-m-d") }}</u><br>Date of Receipt
                        </h6></td>
                </tr>
            </table>
        </div>

        <div style="text-align: center;">
            <h4><strong style="margin-left: 3em;">APPLICATION FOR LEAVE</strong></h4>
        </div>

        <form action="{{ asset('leave/update/save') }}" method="POST">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="id" value="{{ $leave->id }}" />
                        <table border="1px" width="100%">
                            <td style="width: 30%">
                                <div class="row">
                                    <div class="form-group">
                                        <label class="control-label" for="inputSuccess1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. OFFICE/DEPARTMENT</label>
                                        <input type="text" class="form-control" id="inputSuccess1" name="office_agency" value="DOH Central Visayas CHD" style="width:250px; margin-left: 80px;">
                                    </div>
                                </div>
                            </td>
                            <td style="width: 70%">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="inputSuccess1">2. NAME:</label>
                                            <label class="control-label" for="inputSuccess1" style="margin-left: 25px"> (Last) </label>
                                            <input type="text" class="form-control" id="inputSuccess1" name="lastname" value="{{ $leave->lastname }}" style=" width:200px; margin-left: 90px; margin-right: 10px">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="inputSuccess1" style="margin-left: 80px">(First)</label>
                                            <input type="text" class="form-control" id="inputSuccess1" name="firstname" value="{{ $leave->firstname }}" style="width:200px;  margin-left: 60px;">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="inputSuccess1" style="margin-left: 80px">(Middle)</label>
                                            <input type="text" class="form-control" id="inputSuccess1" name="middlename" value="{{ $leave->middlename }}" style=" width:200px; margin-left: 25px;">
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </table>
                        <table border="1" style="width: 100%; border-collapse: collapse; border-top: 0px" >
                            <tr>
                                <td style="width: 30%">
                                    <div class="row">
                                        <div  class="col-md-12">
                                            <label class="control-label" for="inputSuccess1">3. DATE OF FILING</label>
                                            <input type="text" class="form-control" name="date_filling" value="{{ date("Y-m-d") }}" readonly style="display: inline-block; width: 180px; margin-top: 4px ">
                                        </div>
                                    </div>
                                </td>
                                <td  style="width: 70%">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="control-label" for="inputSuccess1">4. POSITION</label>
                                            <input type="text" class="form-control" id="inputSuccess1" name="position" value="{{ $leave->position }}" readonly style="display: inline-block; width: 250px; margin-top: 4px">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label" for="inputSuccess1">5. SALARY</label>
                                            <input type="text" class="form-control" id="inputSuccess1" name="salary" value="{{ sprintf("%.2f",$leave->salary)  }}" readonly style="display: inline-block; width: 270px; margin-top: 4px">
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        </table>
                        <table border="1" style="width: 100%; border-collapse: collapse; border-top: 2px" >
                            <tr>
                                <td style="text-align: center; font-size: 18px">
                                    <strong> 6. DETAILS OF APPLICATION</strong>
                                </td>
                            </tr>
                        </table>
                        <table border="1" style="width: 100%; border-collapse: collapse; border-top: 0px" >
                            <tr>
                                <td style="width: 50%;">
                                    <strong>&nbsp;&nbsp;&nbsp;&nbsp;6.A TYPE OF LEAVE TO BE AVAILED OF</strong>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="has-success">

                                                    @if(isset($leave_type))
                                                        @foreach($leave_type as $row)
                                                            <div class="checkbox">
                                                                <label style="margin-right: 50px">
                                                                    @if($leave->leave_type == $row->code)
                                                                    <input type="radio" class="minimal" id="leave_type" name="leave_type" onclick="here()" value="{{ $row->code }}" checked required>
                                                                    {{ $row->desc }}
                                                                    @if($row->code == 'OTHERS')
                                                                        <input type="text"  name="others_type" class="others_type_dis others_type_dis_txt" id="others_txt" style="width: 380px; margin-left: 20px" value="{{$leave->for_others}}" />
                                                                    @endif
                                                                        @else
                                                                        <input type="radio" class="minimal" id="leave_type" name="leave_type" onclick="here()" value="{{ $row->code }}" required>
                                                                        {{ $row->desc }}
                                                                        @endif
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td style="width:50%">
                                    <strong>&nbsp;&nbsp;&nbsp;&nbsp;6.B DETAILS OF LEAVE</strong>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="has-success">
                                                    <div class="checkbox">

                                                        <label><i>In case of Vacation/Special Privilege leave</i></label><br>
                                                        <label>
                                                            @if ($leave->leave_details == '1')
                                                            <input type="radio" id="checkboxSuccess" class="vac_dis" value="1" name="leave_details" checked > Within the Philippines
                                                            <input type="text" name="for_text_input" class="vac_dis" id="within_txt" style="margin-left: 60px; width: 250px" value="{{$leave->leave_specify}}" >
                                                            @else
                                                                <input type="radio" id="checkboxSuccess" class="vac_dis" value="1" name="leave_details"> Within the Philippines
                                                                <input type="text" name="for_text_input" class="vac_dis" id="within_txt" style="margin-left: 60px; width: 250px" >
                                                                @endif
                                                        </label><br>
                                                        <label>
                                                            @if ($leave->leave_details == '2')
                                                            <input type="radio" id="checkboxSuccess" class="vac_dis" value="2" name="leave_details" checked> Abroad (Specify)
                                                            <input type="text" name="for_text_input" class="vac_dis" id="abroad_txt" style="margin-left: 92px; width: 250px" value="{{$leave->leave_specify}}" />
                                                                @else
                                                                <input type="radio" id="checkboxSuccess" class="vac_dis" value="2" name="leave_details"> Abroad (Specify)
                                                                <input type="text" name="for_text_input" class="vac_dis" id="abroad_txt" style="margin-left: 92px; width: 250px" />
                                                                @endif
                                                        </label> <br>

                                                        <label><i>In case of Sick Leave</i></label><br>
                                                        <label>
                                                            @if ($leave->leave_details == '3')
                                                            <input type="radio" id="checkboxSuccess" class="sick_dis" value="3" name="leave_details" checked> In Hospital (Specify Illness)
                                                            <input type="text"  name="for_text_input" class="sick_dis" id="in_hos_txt" style="margin-left: 30px; width: 250px" value="{{$leave->leave_specify}}">
                                                                @else
                                                                <input type="radio" id="checkboxSuccess" class="sick_dis" value="3" name="leave_details"> In Hospital (Specify Illness)
                                                                <input type="text"  name="for_text_input" class="sick_dis" id="in_hos_txt" style="margin-left: 30px; width: 250px" >
                                                                @endif
                                                        </label>
                                                        <label>
                                                            @if ($leave->leave_details == '4')
                                                            <input type="radio" id="checkboxSuccess" class="sick_dis" value="4" name="leave_details" checked> Out-patient (Specify Illness)
                                                            <input type="text" name="for_text_input" class="sick_dis" id="out_hos_txt" style="margin-left: 26px; width: 250px" value="{{$leave->leave_specify}}">
                                                                @else
                                                                <input type="radio" id="checkboxSuccess" class="sick_dis" value="4" name="leave_details"> Out-patient (Specify Illness)
                                                                <input type="text" name="for_text_input" class="sick_dis" id="out_hos_txt" style="margin-left: 26px; width: 250px" >
                                                                @endif
                                                        </label><br>

                                                        <label><i>In case of Special Leave Benefits for Women</i></label><br>
                                                        <label>
                                                            @if ($leave->leave_details == '5')
                                                            <input type="radio" id="checkboxSuccess" class="spec_dis" value="5" name="leave_details" checked> (Specify Illness)
                                                            <input type="text"  name="for_text_input" class="spec_dis" id="spec_txt" style="margin-left: 98px; width: 250px" value="{{$leave->leave_specify}}" >
                                                                @else
                                                                <input type="radio" id="checkboxSuccess" class="spec_dis" value="5" name="leave_details"> (Specify Illness)
                                                                <input type="text"  name="for_text_input" class="spec_dis" id="spec_txt" style="margin-left: 98px; width: 250px" >
                                                                @endif
                                                        </label><br>

                                                        <label><i>In case of Study Leave</i></label><br>
                                                        <label>
                                                            @if ($leave->leave_details == '6')
                                                            <input type="radio" id="checkboxSuccess" class="stud_dis" value="6" name="leave_details" checked> Completion of Master's Degree
                                                            <input type="text"  name="for_text_input" class="stud_dis" id="master_txt" style="margin-left: 13px; width: 250px" value="{{$leave->leave_specify}}"/>
                                                                @else
                                                                <input type="radio" id="checkboxSuccess" class="stud_dis" value="6" name="leave_details"> Completion of Master's Degree
                                                                <input type="text"  name="for_text_input" class="stud_dis" id="master_txt" style="margin-left: 13px; width: 250px" />
                                                                @endif
                                                        </label>
                                                        <label>
                                                            @if ($leave->leave_details == '7')
                                                            <input type="radio" id="checkboxSuccess" class="stud_dis" value="7" name="leave_details" checked> BAR/Board Examination Review
                                                            <input type="text" name="for_text_input" class="stud_dis" id="bar_txt" style="margin-left: 8px; width: 250px" value="{{$leave->leave_specify}}"/>
                                                                @else
                                                                <input type="radio" id="checkboxSuccess" class="stud_dis" value="7" name="leave_details"> BAR/Board Examination Review
                                                                <input type="text" name="for_text_input" class="stud_dis" id="bar_txt" style="margin-left: 8px; width: 250px" />
                                                                @endif
                                                        </label><br>

                                                        <label><i>Other Purpose</i></label><br>
                                                        <label>
                                                            @if ($leave->leave_details == '8')
                                                            <input type="radio" id="checkboxSuccess" class="others_dis" value="8" name="leave_details" checked> Monetization of Leave Credits
                                                                @else
                                                                <input type="radio" id="checkboxSuccess" class="others_dis" value="8" name="leave_details"> Monetization of Leave Credits
                                                                @endif
                                                        </label><br>
                                                        <label>
                                                            @if ($leave->leave_details == '9')
                                                            <input type="radio" id="checkboxSuccess" class="others_dis" value="9" name="leave_details" checked> Terminal Leave
                                                                @else
                                                                <input type="radio" id="checkboxSuccess" class="others_dis" value="9" name="leave_details"> Terminal Leave
                                                                @endif
                                                        </label><br><br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <table border="1" style="width: 100%; border-collapse: collapse; border-top: 100px" id="myTable">

                            <tr style="width: 50%" id="row_data">
                                <td id="data_here">
                                    <strong>&nbsp;&nbsp;&nbsp;&nbsp;6C. NUMBER OF WORKING DAYS APPLIED FOR :</strong><br>
                                    <input type="text" class="form-control" name="applied_num_days" id="applied_num_days" style="margin-left: 10px; width: 96%" readonly value="{{$leave->applied_num_days}}"/>
                                    <input type="hidden" class="form-control" name="credit_used" id="credit_used"/>
                                    <div style="display: flex; align-items: center;">
                                        <strong class="sm-m-3" style="margin-right: 10px;">&nbsp;&nbsp;&nbsp;&nbsp; INCLUSIVE DATES:</strong>
                                        <button style="width: 60px;  margin-top: 5px; margin-bottom: 5px; margin-left: 58.5%" class="btn btn-sm btn-default addButton1" type="button"><strong>+</strong></button>
                                    </div>
                                    @foreach($leave_dates as $index => $date)
                                        <div class="table-data" id="clone_data">
                                            <div class="input-group" style="margin-left: 10px; margin-bottom: 10px" >
                                                <div class="input-group-addon" style="margin-bottom: 10px">
                                                    <i class="fa fa-calendar"></i>
                                                </div>

                                                <input style="width: 70%" type="text" class="form-control datepickerInput1" id="inclusive11" name="inclusive_dates1[]" placeholder="Input date here..."
                                                       required value="<?php echo date('m/d/Y', strtotime($date->startdate)).' - '.date('m/d/Y', strtotime($date->enddate));?>">
                                                <button style="width: 60px; margin-left: 16%" type="button" class="btn btn-sm btn-default deleteButton1"><strong>-</strong></button>
                                            </div>
                                        </div>
                                    @endforeach

                                </td>

                                </td>
                                <td style="width: 50%; margin-top: 10px; vertical-align: top" rowspan="2">
                                    <strong style="vertical-align: top">&nbsp;&nbsp;&nbsp;&nbsp;6.D COMMUTATION</strong>
                                    <div class="has-success">
                                        <div class="checkbox">
                                            <label>
                                                @if($leave->commutation == "1")
                                                    <input type="radio" id="commutation" value="1" name="com_requested" checked> Requested
                                                @else
                                                    <input type="radio" id="commutation" value="1" name="com_requested"> Requested
                                                @endif
                                            </label><br>
                                            <label>
                                                @if($leave->commutation == "2")
                                                    <input type="radio" id="commutation" value="2" name="com_requested" checked> Not Requested
                                                @else
                                                    <input type="radio" id="commutation" value="2" name="com_requested"> Not Requested
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="row" style="padding: 1%">
                        <div class="col-md-12 float-right" style="text-align: right">
                            <button type="submit" name="submit" class="btn btn-primary btn-lg">Submit</button>
                        </div>
                    </div>
                </div>
            </div> <!-- PANEL BODY -->
        </form>
    </div>
@endsection
@section('js')

    @include('form.form_leave_script')
    <script>

        $('input[name="leave_type"]').change(function(){

            var val = this.value;

            if(val == "OTHERS") {
                $('#others_txt').prop('disabled', false);
                $('input[name="for_text_input"]').prop('disabled', true).val("");

            }else if(val == "VL") {
                $('input[name="for_text_input"]').prop('disabled', true).val("");

            } else if(val == "SL") {
                $('input[name="for_text_input"]').prop('disabled', true).val("");

            } else if(val == "SPL") {
                $('input[name="for_text_input"]').prop('disabled', true).val("");

            }else if(val == "STUD_L") {
                $('input[name="for_text_input"]').prop('disabled', true).val("");

            }else if(val == "SLBW") {
                $('input[name="for_text_input"]').prop('disabled', true).val("");
            }else{
                $('[id^="checkboxSuccess"]').prop({ disabled: true, checked: false });
                $('input[name="for_text_input"]').prop('disabled', true).val("");
            }
        });


        $('input[class="vac_dis"]').change(function(){
            var val = this.value;
            if(val == "1")
            {
                $('#within_txt').prop('disabled', false).val('');
                $('#abroad_txt').prop('disabled', true);
                $('#in_hos_txt, #in_hos_txt, #master_txt, #bar_txt, #spec_txt').prop('disabled', true);

            } else if(val == "2"){
                $('#abroad_txt').prop('disabled', false);
                $('#within_txt').prop('disabled', true).val('');
                $('#in_hos_txt, #out_hos_txt, #master_txt, #bar_txt, #spec_txt').prop('disabled', true);
            }
        });

        $('input[class="sick_dis"]').change(function(){
            var val = this.value;
            if(val == "3")
            {
                $('#in_hos_txt').prop('disabled', false).val('');
                $('#out_hos_txt').prop('disabled', true);
                $('#within_txt, #abroad_txt, #master_txt, #bar_txt, #spec_txt').prop('disabled', true);
            } else if(val == "4"){
                $('#out_hos_txt').prop('disabled', false);
                $('#in_hos_txt').prop('disabled', true).val('');
                $('#within_txt, #abroad_txt, #master_txt, #bar_txt, #spec_txt').prop('disabled', true);
            }
        });
        $('input[class="stud_dis"]').change(function(){
            var val = this.value;
            if(val == "6")
            {
                $('#master_txt').prop('disabled', false).val('');
                $('#bar_txt').prop('disabled', true);
                $('#within_txt, #abroad_txt, #in_hos_txt, #out_hos_txt, #spec_txt').prop('disabled', true);
            } else if(val == "7"){
                $('#bar_txt').prop('disabled', false);
                $('#master_txt').prop('disabled', true).val('');
                $('#within_txt, #abroad_txt, #in_hos_txt, #out_hos_txt, #spec_txt').prop('disabled', true);
            }
        });

        $('input[class="spec_dis"]').change(function(){

            $('#spec_txt').prop('disabled', false).val('');
            $('#within_txt, #abroad_txt, #in_hos_txt, #out_hos_txt, #master_txt, #bar_txt').prop('disabled', true);

        });
        $('input[class="others_dis"]').change(function(){
            $('#within_txt, #abroad_txt, #in_hos_txt, #out_hos_txt, #master_txt, #bar_txt, #spec_txt').prop('disabled', true);
        });

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