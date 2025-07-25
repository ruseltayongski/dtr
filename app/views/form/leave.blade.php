
<div class="container-fluid" style="width: 980px;">
    <div class="row">
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
                                    CENTRAL VISAYAS CENTER for HEALTH DEVELOPMENTleave<br></strong>
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
            <form action="{{ asset('leave/update/save') }}" method="POST"  style="margin-top: 1px;margin-left: 0.5%; margin-right: 0.5%">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" id="token" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" name="id" value="{{$leave->id}}">
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
                                                <input type="text" class="form-control" name="date_filling" value="{{ date("Y-m-d") }}" readonly style="margin-left:2px;display: inline-block; width: 45%; margin-top: 4px ">
                                            </div>
                                        </div>
                                    </td>
                                    <td  style="width: 70%">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <label class="control-label" for="inputSuccess1">4. POSITION</label>
                                                <input type="text" class="form-control" id="inputSuccess1" name="position" value="{{ $leave->position }}" readonly style="display: inline-block; width: 70%; margin-top: 4px">
                                            </div>
                                            <div class="col-md-5">
                                                <label class="control-label" for="inputSuccess1">5. SALARY</label>
                                                <input type="text" class="form-control" id="inputSuccess1" name="salary" value="{{ number_format($leave->salary, 2, '.', ',') }}" readonly style="display: inline-block; width: 60%; margin-top: 4px">
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
                                    <td style="width: 52%; vertical-align: top">
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
                                                                <label style="margin-right: 2%; color:black">
                                                                    <input type="radio" class="minimal" style="margin-top: auto" id="leave_type" name="leave_type" onclick="" value="{{ $row->code }}" {{($leave->leave_type == $row->code)?'checked' :''}}>
                                                                    {{ $row->desc }} <span style="font-size: 10.6px; margin-left: auto">{{($index == 13)?'':$details[$index]}}</span>
                                                                    @if($row->code == 'OTHERS')
                                                                        <input type="text"  value ="{{$leave->for_others}}" name="others_type" class="others_type_dis others_type_dis_txt" id="others_txt" style="width: 370px; margin-left: 20px; border: none; border-bottom: 2px solid black;" />
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
                                                                <input type="radio" id="checkboxSuccess" class="vac_dis" value="1" name="leave_details" {{($leave->leave_details == 1)?'checked' :''}}> Within the Philippines
                                                                <input type="text" name="for_text_input" class="vac_dis" id="within_txt" style="margin-left: 2%; width: 60%; border: none; border-bottom: 2px solid black;"
                                                                       value="{{($leave->leave_details == 1)?$leave->leave_specify : ''}}">
                                                            </label>
                                                            <br>
                                                            <label style="display: inline-block; width: 100%;">
                                                                <input type="radio" id="checkboxSuccess" class="vac_dis" value="2" name="leave_details" {{($leave->leave_details == 2)?'checked' :''}}> Abroad (Specify)
                                                                <input type="text" name="for_text_input" class="vac_dis" id="abroad_txt" style="margin-left: 2%; width: 67.5%; border: none; border-bottom: 2px solid black;"  value="{{($leave->leave_details == 2)?$leave->leave_specify :''}}"/>
                                                            </label> <br>
                                                            <label><i>In case of Sick Leave</i></label><br>
                                                            <label style="display: inline-block; width: 100%;">
                                                                <input type="radio" id="checkboxSuccess" class="sick_dis" value="3" name="leave_details" {{($leave->leave_details == 3)?'checked' :''}}> In Hospital (Specify Illness)
                                                                <input type="text"  name="for_text_input" class="sick_dis" id="in_hos_txt" style="margin-left: 2%; width: 53%; border: none; border-bottom: 2px solid black;" value="{{($leave->leave_details == 3)?$leave->leave_specify :''}}" >
                                                            </label>
                                                            <label style="display: inline-block; width: 100%;">
                                                                <input type="radio" id="checkboxSuccess" class="sick_dis" value="4" name="leave_details" {{($leave->leave_details == 4)?'checked' :''}}> Out-patient (Specify Illness)
                                                                <input type="text" name="for_text_input" class="sick_dis" id="out_hos_txt" style="margin-left: 1%; width: 53%; border: none; border-bottom: 2px solid black;" value="{{($leave->leave_details == 4)?$leave->leave_specify :''}}">
                                                            </label><br>

                                                            <label><i>In case of Special Leave Benefits for Women</i></label><br>
                                                            <label style="display: inline-block; width: 100%;">
                                                                <input type="radio" id="checkboxSuccess" class="spec_dis" value="5" name="leave_details" {{($leave->leave_details == 5)?'checked' :''}}> (Specify Illness)
                                                                <input type="text"  name="for_text_input" class="spec_dis" id="spec_txt" style="margin-left: 2%; width: 68%; border: none; border-bottom: 2px solid black;" value="{{($leave->leave_details == 5)?$leave->leave_specify :''}}">
                                                            </label><br>
                                                            <input type="text"  name="for_text_input" class="spec_dis" id="spec_txt2" style="margin-left: 4.5%; width: 90%; border: none; border-bottom: 2px solid black;" >

                                                            <label><i>In case of Study Leave</i></label><br>
                                                            <label>
                                                                <input type="radio" id="checkboxSuccess" class="stud_dis" value="6" name="leave_details" {{($leave->leave_details == 6)?'checked' :''}}> Completion of Master's Degree
                                                            </label><br>
                                                            <label>
                                                                <input type="radio" id="checkboxSuccess" class="stud_dis" value="7" name="leave_details" {{($leave->leave_details == 7)?'checked' :''}}> BAR/Board Examination Review
                                                            </label><br>
                                                            <label><i>Other Purpose</i></label><br>
                                                            <label>
                                                                <input type="radio" id="checkboxSuccess" class="others_dis" value="8" name="leave_details" {{($leave->leave_details == 8 )?'checked' :''}}> Monetization of Leave Credits
                                                            </label><br>
                                                            <div style="margin-left: 10%; width: 80%; text-align: center; display: none" id="monetize_display">
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
                                                                <input type="radio" id="checkboxSuccess" class="others_dis" value="9" name="leave_details" {{($leave->leave_details == 9)?'checked' :''}}> Terminal Leave
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
                                        <input type="text" class="form-control" name="applied_num_days" id="applied_num_days" value="{{(int)$leave->applied_num_days}}" style="text-align:center; margin-left: 5%; width: 50%;margin-top: 2%" readonly/>
                                        <input type="hidden" class="form-control" name="credit_used" id="credit_used"/>
                                        <strong class="sm-m-3" style="display: inline-block; margin-left: 5%; margin-top: 2%; ">INCLUSIVE DATES :</strong>
                                        <button  style="width: 50px; display: inline-block; margin-left: 200px; border-radius:0px; font-size:10px" class="btn btn-xs btn-info addButton1" type="button">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                        <br><br>
                                        @foreach($leave_dates as $dates)
                                            {{--<strong style="margin-left: 1%">--}}
                                            <div class="table-data" id="clone_data">
                                                <div class="input-group" style="margin-left:5%; margin-bottom: 2px; margin-top: 0px" >
                                                    <div class="input-group-addon" style="">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input value="{{ date('m/d/Y',strtotime($dates->startdate)).' - '.date('m/d/Y',strtotime($dates->enddate)) }}" style="width: 50%" type="text" class="form-control datepickerInput1" id="inclusive11" name="inclusive_dates1[]" placeholder="Input date here..." required>
                                                    <button style="width: 50px; margin-left: 66.7px; border-radius:0px" type="button" class="btn btn-xs btn-danger deleteButton1">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row" id="date_remarks"></div>

                                            {{--</strong>--}}
                                        @endforeach
                                        {{--<div class="row" id="date_remarks"></div>--}}
                                        @if($leave->sl_remarks)
                                            <div class="row" id="date_remarks2">
                                                @foreach($leave->sl_remarks as $index => $row)
                                                    <div class="row" id="" style="padding:5px; width:90%; margin-left: 5%">
                                                        <div>
                                                            @if($index == 0)
                                                                <span style="font-weight: bold">SL remarks:<br></span>
                                                            @endif
                                                            <span style="display: inline-block; margin-right: 10px;">{{ date('m/d/Y',strtotime($row->date)) }}</span>
                                                                <select class="hosen-select-static form-control" name="date_remarks[]" style="flex: 3; width: 80%; display: inline-block;" required>' +
                                                                    <option value="">Select Reason</option>
                                                                    <option value="cdo" {{ $row->remarks == 'cdo' ? 'selected' :'' }}>CDO</option>
                                                                    <option value="leave" {{ $row->remarks == 'leave' ? 'selected' :'' }}>LEAVE</option>
                                                                    <option value="rpo" {{ $row->remarks == 'rpo' ? 'selected' :'' }}>RPO</option>
                                                                    <option value="holiday" {{ $row->remarks == 'holiday' ? 'selected' :'' }}>HOLIDAY</option>
                                                                </select>
                                                            {{--<input type="text" value="{{ $row->remarks }}" class="form-control" name="date_remarks[]" placeholder="Enter remarks" name="remarks_' + formattedDate.replace(/\//g, '-') + '" style="display: inline-block;width: 80%" />--}}
                                                            <input type="hidden" name="s_dates[]" value="'+formattedDate+'">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                    <td style="width: 48%; margin-top: 10px; vertical-align: top" rowspan="2">
                                        <strong style="vertical-align: top">&nbsp;&nbsp;&nbsp;&nbsp;6.D COMMUTATION</strong>
                                        <div class="has-success">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="radio" id="commutation2" value="2" name="com_requested" {{($leave->commutation == 2)?'checked':''}}> Not Requested
                                                </label><br>
                                                <label>
                                                    <input type="radio" id="commutation" value="1" name="com_requested" {{($leave->commutation == 1)?'checked':''}}> Requested
                                                </label>
                                            </div>
                                        </div>
                                        <img src="{{ asset('FPDF/image/line.png') }}" width="30%" style="position: absolute; left: 60%; top: 59%; height: .1px; margin-top: 6%;" >
                                        <br><br>
                                        <span style="margin-left: 37%">(Signature of Applicant)</span>
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
                                                        <td><input id="vl_less" name="vl_less" style="width: 30%; text-align: center; border:none" value="{{!Empty($leave->vl_deduct)?$leave->vl_deduct:0}}" readonly></td>
                                                        <td><input id="sl_less" name="sl_less" style="width: 30%; text-align: center; border: none" value="{{!Empty($leave->sl_deduct)?$leave->sl_deduct:0}}" readonly></td>
                                                    </tr>
                                                    <tr height = "30">
                                                        <td class="col-md-2">Balance</td>
                                                        <td class="col-md-2">
                                                            <input id="vl_rem" name="vl_rem" style="width: 40%; text-align: center; border: none"
                                                                   value="{{ ($user->vacation_balance != null) ? ($user->vacation_balance - (!empty($leave->vl_deduct) ? $leave->vl_deduct : 0)) : 0 }}"
                                                                   readonly>
                                                        </td>
                                                        <td class="col-md-2">
                                                            <input id="sl_rem" name="sl_rem" style="width: 40%; text-align: center; border: none"
                                                                   value="{{ ($user->sick_balance != null) ? ($user->sick_balance - (!empty($leave->sl_deduct) ? $leave->sl_deduct : 0)) : 0 }}"
                                                                   readonly>
                                                        </td>
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
                                                                <option value="{{ $section_head['id'] }}" {{($leave->officer_1 == $section_head['id'])?'selected':''}}>{{ $section_head['fname'].' '.$section_head['mname'].' '.$section_head['lname'] }}</option>
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
                                        <br><br>
                                        <div style="margin-left: 2%; text-align: center">
                                            <select class="chosen-select-static form-control" name="recommendation_officer" required style="width: 70%;margin-right: 50%; text-align: center; ">
                                                @if(count($officer) > 0)
                                                    @foreach($officer as $section_head)
                                                        <option value="{{ $section_head['id'] }}" {{($leave->officer_2 == $section_head['id'])?'selected':''}}>{{ $section_head['fname'].' '.$section_head['mname'].' '.$section_head['lname'] }}</option>
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
                                        <span style="margin-left: 10%"><input value="{{($leave->with_pay != 0)? intval($leave->with_pay) :''}}" style="width: 22%; border: none; border-bottom: 2px solid black; height: 2%; margin-bottom: 0px" id="with_pay" name="with_pay" readonly> days with pay</span><br>
                                        <span style="margin-left: 10%"><input value="{{($leave->without_pay != 0)? intval($leave->without_pay) :''}}" style="width: 22%; border: none; border-bottom: 2px solid black; height: 2%" id="without_pay" name="without_pay" readonly> days without pay</span><br>
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
                                                        <option value="{{ $section_head['id'] }}" {{($leave->officer_3 == $section_head['id'])?'selected':''}}>{{ $section_head['fname'].' '.$section_head['mname'].' '.$section_head['lname'] }}</option>
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
                {{--<div class="panel-body">--}}
                    {{--<div class="row">--}}
                        {{--<div class="row" style="padding: 1%">--}}
                            {{--<div class="col-md-12 float-right" style="text-align: right">--}}
                                {{--<button type="submit" name="submit" class="btn btn-primary btn-lg">Update</button>--}}
                                <type type="hidden" id="spl_type"></type>
                                <type type="hidden" id="monetize_val" name="monetize_val"></type>
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div> <!-- PANEL BODY -->--}}
                <div class="modal-footer">
                    <div class="row">
                        <div class="modal-footer">

                            <div class="alert-info" style=" display: inline-block; width: 50%; float: left">
                                <p style="padding: 2px; margin: 0; text-align: center">
                        <span >
                            <i class="fa fa-hand-o-right"></i>
                            Please print the leave application details on the back of your form. HR will not accept your leave form unless these details are printed.
                        </span>
                                </p>
                            </div>
                            <div style="display: inline-block; width: 50%;">
                                {{--<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>--}}
                                <a target="_blank" class="btn btn-success" href="{{ asset('FPDF/print_leave.php?id=' .$leave->id) }}" style="color: white;"><i class="fa fa-print"></i> Print(Front)</a>
                                <a target="_blank" class="btn btn-success" href="{{ asset('leave/print/' .$leave->id) }}" style="color: white;"><i class="fa fa-print"></i> Print(Back)</a>
                                @if( Auth::user()->usertype !=1 && $leave->status == 0 )
                                    <button href="{{ asset('leave/update/save') }}"  class="btn btn-primary btn-submit" style="color:white;"><i class="fa fa-pencil"></i> Update</button>
                                    <a href="{{ asset('leave/delete/' .$leave->id) }}" style="color:white" class="btn btn-danger" ><i class="fa fa-trash"></i> Remove</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
<style>

</style>
@include('form.form_leave_script')
<script>
    var vl = {{($user->vacation_balance != null)?$user->vacation_balance:0}};
    var sl = {{($user->sick_balance != null)?$user->sick_balance:0}};

    function monetize(data){

        $('#monetize_val').val(data);
        $('#with_pay').val(data + " day(s)");
        $('#applied_num_days').val(data);
        console.log('data');

        if(data == 50){
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
//    $('#monetizeSelect').chosen();
    $('.chosen-select-static').chosen();
    $('#inc_date').daterangepicker();
    $('input[name="leave_type"]').change(function(){
        $('#date_remarks').empty();
        $('#date_remarks2').empty();
        $('#clone_data').not(':first').remove();
        console.log('sample');

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
        if(val == 8){
            alert('Please make sure to attach approved letter from RD!');
            com();
            $('#inclusive11').attr({ required: false, disabled: true });
            console.log('vl', vl);
            if( vl >= 15){
                $('#monetizeSelect').attr('required', true);
                $('#monetize_display').css('display', 'block');
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
        $('#monetizeSelect').attr('required', false);
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