@extends('layouts.app')

@section('content')
    <style>
        tbody tr td:first-child{
            /*color: red;*/
        }
        tbody tr td:last-child{
            /*color: red;*/
        }
        .custom-font-size {
            font-size: 14px;
            padding: 2px;
        }
        .chosen-container-single{
            width: 260px !important;
        }
    </style>
    <div class="panel panel-default">
        <div style="margin-top: 50px; margin-left: 50px; margin-right: 40px">
            <table cellpadding="0" cellspacing="0" width="100%" style="margin-top: 30px">
                <tr>
                    <td class="align" width="12%" style="text-align: center; vertical-align: top;"><small>Civil Service Form No. 6<br><i>Revised 2020</i></small></td>
                    <td class="align" width="12%" style="text-align: right; "><br><br><img src="{{ asset('public/img/doh.png') }}" width="100" ></td>
                    <td width="58%" >
                        <br><br>
                        <div class="align small-text" style="text-align: center">
                            Republic of the Philippines<br>
                            <strong>DEPARTMENT OF HEALTH<br>
                                CENTRAL VISAYAS CENTER for HEALTH DEVELOPMENTfor_leave<br></strong>
                            Osmeña Boulevard, Cebu City, 6000 Philippines<br>
                        </div>
                    </td>
                    <td class="align" width="30%" style="text-align: center; vertical-align: center;"><h6>
                            <u>_____________</u><br>Date of Receipt
                        </h6></td>
                </tr>
            </table>
        </div>
        <div style="text-align: center; margin-top: 15px;">
            <h4><strong style="margin-left: 3em;">APPLICATION FOR LEAVE</strong></h4>
        </div>
        <div style="margin-left: 50px; margin-right: 40px">
            <i>
                <label>SPL Balance: </label>
                <label id="spl" style="color:red;">{{($spl)?$spl->SPL:0}}</label>
                <label>FL Balance: </label>
                <label id="fl" style=color:red;">{{($spl)?$spl->FL:0}}</label>
                <label>VL Balance: </label>
                <label id="vl" style="color:red;">{{($user->vacation_balance != null)?$user->vacation_balance:0}}</label>
                <label>SL Balance: </label>
                <label id="sl" style="color:red;">{{($user->sick_balance != null)?$user->sick_balance:0}}</label>
            </i>
        </div>
        <form action="{{ asset('form/leave') }}" method="POST" style="margin-top: 1px;margin-left: 50px; margin-right: 40px">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" id="token" name="_token" value="<?php echo csrf_token(); ?>">
                        <table border="1px" width="100%">
                            <td style="width: 30%">
                                <div class="row">
                                    <div class="form-group">
                                        <label class="control-label" for="inputSuccess1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. OFFICE/DEPARTMENT</label>
                                        <input type="text" class="form-control" id="inputSuccess1" name="office_agency" value="DOH Central Visayas CHD" style="width:60%; margin-left: 20%;">
                                    </div>
                                </div>
                            </td>
                            <td style="width: 70%">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="inputSuccess1">2. NAME:</label>
                                            <label class="control-label" for="inputSuccess1" style="margin-left: 20%"> (Last) </label>
                                            <input type="text" class="form-control" id="inputSuccess1" name="lastname" value="{{ $user->lname }}" style=" width:85%; margin-left: 40%; margin-right: 5%">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="inputSuccess1" style="margin-left: 40%">(First)</label>
                                            <input type="text" class="form-control" id="inputSuccess1" name="firstname" value="{{ $user->fname }}" style="width:85%;  margin-left: 23%;">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label" for="inputSuccess1" style="margin-left: 25%">(Middle)</label>
                                            <input type="text" class="form-control" id="inputSuccess1" name="middlename" value="{{ $user->mname }}" style=" width:85%; margin-left: 5%;">
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
                                            <input type="text" class="form-control" name="date_filling" value="{{ date("Y-m-d") }}" readonly style="display: inline-block; width: 50%; margin-top: 4px ">
                                        </div>
                                    </div>
                                </td>
                                <td  style="width: 70%">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <label class="control-label" for="inputSuccess1">4. POSITION</label>
                                            <input type="text" class="form-control" id="inputSuccess1" name="position" value="{{ $user->designation }}" readonly style="display: inline-block; width: 70%; margin-top: 4px">
                                        </div>
                                        <div class="col-md-5">
                                            <label class="control-label" for="inputSuccess1">5. SALARY</label>
                                            <input type="text" class="form-control" id="inputSuccess1" name="salary" value="{{ number_format($user->monthly_salary, 2, '.',',') }}" readonly style="display: inline-block; width: 60%; margin-top: 4px">
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        </table>
                        <table border="1" style="width: 100%; border-collapse: collapse; border-top: 2px" >
                            <tr><td></td></tr>
                        </table>
                        <table border="1" style="width: 100%; border-collapse: collapse; border-top: 2px" >
                            <tr>
                                <td style="text-align: center; font-size: 18px">
                                    <strong> 6. DETAILS OF APPLICATION</strong>
                                </td>
                            </tr>
                        </table>
                        <table border="1" style="width: 100%; border-collapse: collapse; border-top: 2px" >
                            <tr><td></td></tr>
                        </table>
                        <table border="1" style="width: 100%; border-collapse: collapse; border-top: 0px" >
                            <tr>
                                <td style="width: 52%;">
                                    <strong>&nbsp;&nbsp;&nbsp;&nbsp;6.A TYPE OF LEAVE TO BE AVAILED OF</strong>
                                    <a href="#application_details" data-toggle="modal" >( <i class="fa fa-info-circle" > <i>application details</i></i>)</a>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="has-success">
                                                    @foreach($leave_type as $index => $row)
                                                        <?php
                                                            $details = [
                                                                "(Sec. 51, Rule XVI, Omnibus Rules Implementing E.O. No. 292)",
                                                                "(Sec. 25, Rule XVI, Omnibus Rules Implementing E.O. No. 292)",
                                                                "(Sec. 43, Rule XVI, Omnibus Rules Implementing E.O. No. 292)",
                                                                "(R.A. No. 11210 / IRR issued by CSC, DOLE and SSS)",
                                                                "(R.A. No. 8187 / CSC MC No. 71, s. 1998, as amended)",
                                                                "(Sec. 21, Rule XVI, Omnibus Rules Implementing E.O. No. 292)",
                                                                "(R.A. No. 8972 / CSC MC No. 8, s. 2004)",
                                                                "(Sec. 68, Rule XVI, Omnibus Rules Implementing E.O. No. 292)",
                                                                "(R.A. No. 9262 / CSC MC No. 15, s. 2005)",
                                                                "(Sec. 55, Rule XVI, Omnibus Rules Implementing E.O. No. 292)",
                                                                "(R.A. No. 9710 / CSC MC No. 25, s. 2010)",
                                                                "(CSC MC No. 2, s. 2012, as amended)",
                                                                "(R.A. No. 8552)",
                                                            ]
                                                        ?>
                                                        <div class="checkbox">
                                                            <label style="margin-right: 5%; color:black">
                                                                <input type="radio" class="minimal" style="margin-top: auto" id="leave_type" name="leave_type" onclick="" value="{{ $row->code }}"
                                                                    {{ ($row->code == 'SPL' && (!$spl || ($spl && $spl->SPL == 0))) ? 'disabled' : '' }}
                                                                >
                                                                {{ $row->desc }} <small>{{($index == 13)?'':$details[$index]}}</small>
                                                                @if($row->code == 'OTHERS')
                                                                    <input type="text"  name="others_type" class="others_type_dis others_type_dis_txt" id="others_txt" style="width: 370px; margin-left: 20px; border: none; border-bottom: 2px solid black;" />
                                                                @endif
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td style="width:48%; vertical-align: top">
                                    <strong>&nbsp;&nbsp;&nbsp;&nbsp;6.B DETAILS OF LEAVE</strong>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="has-success1">
                                                    <div class="checkbox" style="">

                                                        <label><i>In case of Vacation/Special Privilege leave</i></label><br>
                                                        <label style="display: inline-block; width: 100%;">
                                                            <input type="radio" id="checkboxSuccess" class="vac_dis" value="1" name="leave_details"> Within the Philippines
                                                            <input type="text" name="for_text_input" class="vac_dis" id="within_txt" style="margin-left: 2%; width: 63%; border: none; border-bottom: 2px solid black;">
                                                        </label>
                                                        <br>
                                                        <label style="display: inline-block; width: 100%;">
                                                            <input type="radio" id="checkboxSuccess" class="vac_dis" value="2" name="leave_details"> Abroad (Specify)
                                                            <input type="text" name="for_text_input" class="vac_dis" id="abroad_txt" style="margin-left: 2%; width: 70.5%; border: none; border-bottom: 2px solid black;" />
                                                        </label> <br>
                                                        <label><i>In case of Sick Leave</i></label><br>
                                                        <label style="display: inline-block; width: 100%;">
                                                            <input type="radio" id="checkboxSuccess" class="sick_dis" value="3" name="leave_details"> In Hospital (Specify Illness)
                                                            <input type="text"  name="for_text_input" class="sick_dis" id="in_hos_txt" style="margin-left: 2%; width: 56.6%; border: none; border-bottom: 2px solid black;" >
                                                        </label>
                                                        <label style="display: inline-block; width: 100%;">
                                                            <input type="radio" id="checkboxSuccess" class="sick_dis" value="4" name="leave_details"> Out-patient (Specify Illness)
                                                            <input type="text" name="for_text_input" class="sick_dis" id="out_hos_txt" style="margin-left: 1%; width: 56.6%; border: none; border-bottom: 2px solid black;" >
                                                        </label><br>

                                                        <label><i>In case of Special Leave Benefits for Women</i></label><br>
                                                        <label style="display: inline-block; width: 100%;">
                                                            <input type="radio" id="checkboxSuccess" class="spec_dis" value="5" name="leave_details"> (Specify Illness)
                                                            <input type="text"  name="for_text_input" class="spec_dis" id="spec_txt" style="margin-left: 2%; width: 71.8%; border: none; border-bottom: 2px solid black;" >
                                                        </label><br>
                                                        <input type="text"  name="for_text_input" class="spec_dis" id="spec_txt2" style="margin-left: 4.5%; width: 91.2%; border: none; border-bottom: 2px solid black;" >

                                                        <label><i>In case of Study Leave</i></label><br>
                                                        <label>
                                                            <input type="radio" id="checkboxSuccess" class="stud_dis" value="6" name="leave_details"> Completion of Master's Degree
                                                        </label><br>
                                                        <label>
                                                            <input type="radio" id="checkboxSuccess" class="stud_dis" value="7" name="leave_details"> BAR/Board Examination Review
                                                        </label><br>
                                                        <label><i>Other Purpose</i></label><br>
                                                        <label>
                                                            <input type="radio" id="checkboxSuccess" class="others_dis" value="8" name="leave_details"> Monetization of Leave Credits
                                                        </label><br>
                                                        <div style="text-align: center; width: 100%; display: none" id="monetize_display">
                                                            <select class="monetize_select form-control" id="monetizeSelect" name="monetize_select" onchange="monetize($(this).val())">
                                                                <option value="">Please select value</option>
                                                                <option value="10">10</option>
                                                                <option value="15" {{($user->vacation_balance >= 15)?'':'disabled'}}>15</option>
                                                                <option value="20" {{($user->vacation_balance >= 20)?'':'disabled'}}>20</option>
                                                                <option value="25" {{($user->vacation_balance >= 25)?'':'disabled'}}>25</option>
                                                                <option value="30" {{($user->vacation_balance >= 30)?'':'disabled'}}>30</option>
                                                                <option value="50">50% Monetization</option>
                                                            </select>
                                                        </div>
                                                        <label>
                                                            <input type="radio" id="checkboxSuccess" class="others_dis" value="9" name="leave_details"> Terminal Leave
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
                            <tr style="width: 52%" id="row_data">
                                <td id="data_here">
                                    <strong>&nbsp;&nbsp;&nbsp;&nbsp;6.C NUMBER OF WORKING DAYS APPLIED FOR :</strong><br>
                                    <input type="text" class="form-control" name="applied_num_days" id="applied_num_days" style="text-align:center; margin-left: 5%; width: 51%;margin-top: 2%" readonly/>
                                    <input type="hidden" class="form-control" name="credit_used" id="credit_used"/>
                                    <strong class="sm-m-3" style="display: inline-block; margin-left: 5%; margin-top: 2%; margin-bottom: 10px">INCLUSIVE DATES :</strong>
                                    <button  style="width: 10.1%; display: inline-block; margin-left: 39.6%" class="btn btn-sm btn-info addButton1" type="button"><strong>+</strong></button>

                                    <div class="table-data" id="clone_data">
                                        <div class="input-group" style="margin-left:5%; margin-bottom: 2px" >
                                            <div class="input-group-addon" style="margin-bottom: 10px; ">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input style="width: 50%;" type="text" class="form-control datepickerInput1" id="inclusive11" name="inclusive_dates1[]" placeholder="Input date here..." required>
                                            <button style="width: 11.3%; margin-left: 12.5%" type="button" class="btn btn-sm btn-danger deleteButton1"><strong>-</strong></button>
                                        </div>
                                        <div class="row text-center" id="date_remarks" style="padding:10px; width:90%; margin-left: 5%"></div>
                                    </div>
                                </td>
                                <td style="width: 48%; margin-top: 10px; vertical-align: top" rowspan="2">
                                    <strong style="vertical-align: top">&nbsp;&nbsp;&nbsp;&nbsp;6.D COMMUTATION</strong>
                                    <div class="has-success">
                                        <div class="checkbox">
                                            <label>
                                                <input type="radio" id="commutation2" value="2" name="com_requested"> Not Requested
                                            </label><br>
                                            <label>
                                                <input type="radio" id="commutation" value="1" name="com_requested"> Requested
                                            </label>
                                        </div>
                                    </div>
                                    <br>
                                    <span style="margin-left: 30%; border-top: 1.5px solid black; padding-top: 5px;">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        (Signature of Applicant)
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </span>

                                </td>
                            </tr>
                        </table>
                        <table border="1" style="width: 100%; border-collapse: collapse; border-top: 2px" >
                            <tr><td></td></tr>
                        </table>
                        <table border="1" style="width: 100%; border-collapse: collapse; border-top: 2px" >
                            <tr>
                                <td style="text-align: center; font-size: 18px">
                                    <strong> 7. DETAILS OF ACTION ON APPLICATION</strong>
                                </td>
                            </tr>
                        </table>
                        <table border="1" style="width: 100%; border-collapse: collapse; border-top: 2px" >
                            <tr><td></td></tr>
                        </table>
                        <table border="1" style="width: 100%; border-collapse: collapse; border-top: 2px" >
                            <tr style="width: 52%" id="row_data">
                                <td style="vertical-align: top">
                                    <strong style="margin-left: 2%">7.A CERTIFICATION OF LEAVE CREDITS</strong><br>
                                    <p style="margin-left: 20%">As of <input name="as_of" style="border:none;border-bottom: 2px solid black; width:35%; text-align: center" value="<?php echo date('F j, Y', strtotime('last day of this month')); ?>" readonly></p>
                                    <div class="row">
                                        <div>
                                            <table border="2" style="width: 80%; text-align: center; align-items: center; margin-left: 10%">
                                                <thead>
                                                <tr>
                                                    <th style="text-align: center; width: 10px"></th>
                                                    <th style="text-align: center;">Vacation Leave</th>
                                                    <th style="text-align: center;">Sick Leave</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr height="30">
                                                    <td>Total Earned</td>
                                                    <td>{{($user->vacation_balance != null)?$user->vacation_balance:0}}</td>
                                                    <td>{{($user->sick_balance != null)?$user->sick_balance:0}}</td>
                                                </tr>
                                                <tr height ="30" style="">
                                                    <td>Less this application</td>
                                                    <td><input id="vl_less" name="vl_less" style="width: 30%; text-align: center; border:none" value="0" readonly></td>
                                                    <td><input id="sl_less" name="sl_less" style="width: 30%; text-align: center; border: none" value="0" readonly></td>
                                                </tr>
                                                <tr height = "30">
                                                    <td class="col-md-2">Balance</td>
                                                    <td class="col-md-2"><input id="vl_rem" name="vl_rem" style="width: 40%; text-align: center; border: none" value="{{($user->vacation_balance != null)?$user->vacation_balance:0}}" readonly></td>
                                                    <td class="col-md-2"><input id="sl_rem" name="sl_rem" style="width: 40%; text-align: center; border: none" value="{{($user->sick_balance != null)?$user->sick_balance:0}}" readonly></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <br><br>
                                            <select class="chosen-select-static form-control" name="certification_officer" required style="width: 70%;margin-right: 50%; text-align: center; ">
                                                @if(count($officer) > 0)
                                                    @foreach($officer as $section_head)
                                                        @if( $section_head['id'] == 17)
                                                            <option value="{{ $section_head['id'] }}">{{ $section_head['fname'].' '.$section_head['mname'].' '.$section_head['lname'] }}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                            <br>
                                            (Authorized Officer)
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 48%; margin-top: 10px; vertical-align: top" rowspan="2">
                                    <strong>&nbsp;&nbsp;&nbsp;7.B RECOMMENDATION</strong>
                                    <div class="row" >
                                        <strong class="col-sm-1">
                                        </strong>
                                        <label>For Approval</label><br>
                                        <strong class="col-sm-1">
                                        </strong>
                                        <strong style="margin-left: 10px; ">For disapproval due to </strong> &nbsp;<img style="height: .1px; margin-top: 1.5%;" src="{{ asset('FPDF/image/line.png') }}" width="50.7%" >
                                        <img src="{{ asset('FPDF/image/line.png') }}" width="80%" style="margin-left: 10%; height: .1px; margin-top: 5%;" >
                                        <img src="{{ asset('FPDF/image/line.png') }}" width="80%" style="margin-left: 10%; height: .1px; margin-top: 6%;" >
                                        <img src="{{ asset('FPDF/image/line.png') }}" width="80%" style="margin-left: 10%; height: .1px; margin-top: 6%;" >
                                        <br>
                                    </div>
                                    <br>
                                    <div style="margin-left: 2%; text-align: center">
                                        <select class="chosen-select-static form-control" name="recommendation_officer" required style="width: 70%;margin-right: 50%; text-align: center; ">
                                            @if(count($officer) > 0)
                                                @foreach($officer as $section_head)
                                                    <option value="{{ $section_head['id'] }}">{{ $section_head['fname'].' '.$section_head['mname'].' '.$section_head['lname'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <span style="margin-left: 40%;">(Authorized Officer)</span>
                                </td>
                            </tr>
                        </table>
                        <table border="1" style="width: 100%; border-collapse: collapse; border-top: 2px" >
                            <tr><td></td></tr>
                        </table>
                        <table border="1" style="width: 100%; border-collapse: collapse; border-top: 2px; border-bottom: 0px" >
                            <tr style="width: 52%" id="row_data">
                                <td style="vertical-align: top;  border-right: 0px; border-bottom: 0px;">
                                    <strong style="">&nbsp;&nbsp;&nbsp;7.C APPROVED FOR:</strong><br>
                                    <span style="margin-left: 10%"><input style="width: 22%; border: none; border-bottom: 2px solid black; height: 2%; margin-bottom: 0px" id="with_pay" name="with_pay" readonly> days with pay</span><br>
                                    <span style="margin-left: 10%"><input style="width: 22%; border: none; border-bottom: 2px solid black; height: 2%" id="without_pay" name="without_pay" readonly> days without pay</span><br>
                                    <span style="margin-left: 10%"><input style="width: 22%; border: none; border-bottom: 2px solid black; height: 2%; margin-bottom: 0px" id="others_pay" name="others_pay" readonly> others (Specify)</span>
                                <td style="width: 48%; margin-top: 10px;border-left: 0px;border-bottom: 0px; vertical-align: top" rowspan="2">
                                    <strong>&nbsp;&nbsp;&nbsp;7.D DISAPPROVED DUE TO:</strong>
                                    <div class="row" >
                                        <img src="{{ asset('FPDF/image/line.png') }}" width="80%" style="margin-left: 10%; height: .1px; margin-top: 1.5%;" ><br>
                                        <img src="{{ asset('FPDF/image/line.png') }}" width="80%" style="margin-left: 10%; height: .1px; margin-top: 1.5%;" ><br>
                                        <img src="{{ asset('FPDF/image/line.png') }}" width="80%" style="margin-left: 10%; height: .1px; margin-top: 1.5%;" ><br>
                                        <br>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <table border="1" style="width: 100%; border-collapse: collapse; border-top: 0px;" >
                            <tr>
                                <td style="border-top: 0px; align-items: center">
                                    <br>
                                    <div style="margin-left: 2%; text-align: center">
                                        <select class="chosen-select-static form-control" name="approved_officer" required style="width: 30%;margin-right: 50%">
                                            @if(count($officer) > 0)
                                                @foreach($officer as $section_head)
                                                    <option value="{{ $section_head['id'] }}">{{ $section_head['fname'].' '.$section_head['mname'].' '.$section_head['lname'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <span style="margin-left: 45%;">(Authorized Officer)</span>
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
                            <type type="hidden" id="spl_type" class="spl_type"></type>
                            <type type="hidden" id="monetize_val" name="monetize_val"></type>

                        </div>
                    </div>
                </div>
            </div> <!-- PANEL BODY -->
        </form>
    </div>
@endsection
@section('js')
    @parent
    @include('form.form_leave_script')
    <script>
        var vl = {{($user->vacation_balance != null)?$user->vacation_balance:0}};
        var sl = {{($user->sick_balance != null)?$user->sick_balance:0}};

        function monetize(data){
            $('#monetize_val').val(data);
            $('#with_pay').val(data + " day(s)");
            $('#applied_num_days').val(data);

            if(data == 50){
                alert('Please make sure to attach approved letter from RD!');
                var total = Math.ceil((vl + sl)/2);
                $('#applied_num_days').val(total);
                var div = total/2;
                console.log('div', vl + sl);

                var vl_rem = vl - div;
                var sl_rem = sl - div;
                var vl_deduct = div, sl_deduct = div;
                if(vl_rem < 0){
                    sl_rem = sl - (div + vl_rem);
                    vl_rem = 0;
                    sl_deduct = div + vl_rem;
//                    sl_deduct = div + flow;
                    vl_deduct = vl;
                    console.log('res', div + vl_rem);

                }else if (sl_rem < 0){
                    console.log('else', div + vl_rem);
                    vl_rem = vl - (div + sl_rem);
                    sl_rem = 0;
                    vl_deduct = div + sl_rem;
//                    vl_deduct = div + flow;
                    sl_deduct = sl;
                }
                console.log('after',sl_deduct);

                $('#vl_rem').val(vl_rem);
                $('#sl_rem').val(sl_rem);
                $('#vl_less').val(vl_deduct);
                $('#sl_less').val(sl_deduct);
            }else{
                $('#vl_less').val(data);
                $('#vl_rem').val(vl-data);
                $('#sl_less').val(0);
                $('#sl_rem').val(sl);
            }
        }
        $('.chosen-select-static').chosen();
        $('.monetize_select').chosen();
        $('#inc_date').daterangepicker();
        $('input[name="leave_type"]').change(function(){
            $('#date_remarks').empty();

            $('#inclusive11').attr({ required: true, disabled: false });

            $('.has-success1 input[type="radio"]').prop('checked', false);

            $('.datepickerInput1').val("");
            $('#applied_num_days').val("");
            $('#vl_less').val(0);
            $('#sl_less').val(0);
            $('#vl_rem').val(vl);
            $('#sl_rem').val(sl);

            var val = this.value;
            console.log('value', val);

            com2();

            if(val == "OTHERS") {
                $('#others_txt').prop('disabled', false);
                $('input[name="for_text_input"]').prop('disabled', true).val("");
                $('#commutation').prop('checked', false);
                $('#commutation2').prop('checked', false);
            }else if(val == "VL") {
                $('input[name="for_text_input"]').prop('disabled', true).val("");

            } else if(val == "SL") {
                $('input[name="for_text_input"]').prop('disabled', true).val("");

            } else if(val == "SPL") {
                $('input[name="for_text_input"]').prop('disabled', true).val("");

                Lobibox.alert('success', // AVAILABLE TYPES: "error", "info", "success", "warning"
                    {
                        msg: "Is this an emergency type of Special Privilege Leave?",
                        size: 'mini',
                        buttons: {
                            emergency: {
                                text: 'Emergency',
                                class: 'btn-success custom-font-size',
                                closeOnClick: true
                            },
                            notEmergency: {
                                text: 'Not an Emergency',
                                class: 'btn-danger custom-font-size',
                                closeOnClick: true
                            }
                        },
                        callback: function (lobibox, type) {
                            console.log('type', type);
                            if (type === 'emergency') {
                                // Handle emergency button click
                                $('#spl_type').val('emergency');
                                console.log('sfsd', $('#spl_type').val())
                            } else if (type === 'notEmergency') {
                                // Handle not emergency button click
                                $('#spl_type').val('unemergency');
                                console.log('sfsd', $('#spl_type').val())
                            }
                        }
                    });

            }else if(val == "STUD_L") {
                $('input[name="for_text_input"]').prop('disabled', true).val("");

            }else if(val == "SLBW") {
                $('input[name="for_text_input"]').prop('disabled', true).val("");
            }else{
            }
        });


        $('input[class="vac_dis"]').change(function(){
            com2();
            var val = this.value;
            if(val == "1")
            {
                console.log('here1');
                $('#within_txt').prop('disabled', false).val('');
                $('#abroad_txt').prop('disabled', true);
                $('#in_hos_txt, #in_hos_txt, #master_txt, #bar_txt, #spec_txt, #spec_txt2').prop('disabled', true);

            } else if(val == "2"){
                $('#abroad_txt').prop('disabled', false);
                $('#within_txt').prop('disabled', true).val('');
                $('#in_hos_txt, #out_hos_txt, #master_txt, #bar_txt, #spec_txt, #spec_txt2').prop('disabled', true);
            }
        });

        $('input[class="sick_dis"]').change(function(){
            var val = this.value;
            com2();
            console.log('sick', val);
            if(val == "3")
            {
                console.log('here3');
                $('#in_hos_txt').prop('disabled', false).val('');
                $('#out_hos_txt').prop('disabled', true);
                $('#within_txt, #abroad_txt, #master_txt, #bar_txt, #spec_txt, #spec_txt2').prop('disabled', true);
            } else if(val == "4"){
                $('#out_hos_txt').prop('disabled', false);
                $('#in_hos_txt').prop('disabled', true).val('');
                $('#within_txt, #abroad_txt, #master_txt, #bar_txt, #spec_txt, #spec_txt2').prop('disabled', true);
            }
        });
        $('input[class="stud_dis"]').change(function(){
            var val = this.value;
            com2();
            if(val == "6")
            {
                $('#master_txt').prop('disabled', false).val('');
                $('#bar_txt').prop('disabled', true);
                $('#within_txt, #abroad_txt, #in_hos_txt, #out_hos_txt, #spec_txt, #spec_txt2').prop('disabled', true);
            } else if(val == "7"){
                $('#bar_txt').prop('disabled', false);
                $('#master_txt').prop('disabled', true).val('');
                $('#within_txt, #abroad_txt, #in_hos_txt, #out_hos_txt, #spec_txt, #spec_txt2').prop('disabled', true);
            }
        });

        $('input[class="spec_dis"]').change(function(){
            com2();
            console.log('sdf');
            $('#spec_txt, #spec_txt2').prop('disabled', false).val('');
            $('#within_txt, #abroad_txt, #in_hos_txt, #out_hos_txt, #master_txt, #bar_txt').prop('disabled', true);

        });
        $('input[class="others_dis"]').change(function(){
            var val = this.value;
            console.log('value', val);
            if(val == 8){
                com();
                $('#inclusive11').attr({ required: false, disabled: true });
                console.log('vl', vl);
                if( vl >= 15){
                    $('#monetize_display').css('display', 'block');
                    $('.monetize_select').attr('required', true);
                }else{
                    Lobibox.alert('error', {
                        msg:'Make sure your vacation balance is equal to or more than 15!',
                        size:'mini'
                    });
                    $('input[name="leave_details"]').prop('checked', false);
                    $('input[name="com_requested"]').prop('checked', false);
                }

            }else{
                com2();
                $('#inclusive11').attr({ required: true, disabled: false });
            }

            $('#within_txt, #abroad_txt, #in_hos_txt, #out_hos_txt, #master_txt, #bar_txt, #spec_txt, #spec_txt2').prop('disabled', true);
        });

        function com(){
            $('#commutation').prop('checked', true);
            $('#commutation2').prop('checked', false);
        }

        function com2(){
            $('#commutation').prop('checked', false);
            $('#commutation2').prop('checked', true);
            $('#monetize_display').css('display', 'none');
            $('#monetize_type').val('');
            $('#applied_num_days').val();
            $('.monetize_select').attr('required', false);
            $('#with_pay').val('');
            $('#without_pay').val('');
            console.log('chaki');
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