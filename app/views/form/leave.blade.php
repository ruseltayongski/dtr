
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
    .sl-locked-highlight {
        box-shadow: 0 0 0 1px #2ecc71, 0 0 1px rgba(46,204,113,0.6);
        transition: box-shadow 0.1s ease;
    }
</style>
<div class="container-fluid" style="width: 980px;">
    <div class="row">
        <div class="panel panel-default">
            <div style="margin-top: 10px; margin-left: 20px; margin-right: 20px">
                <table cellpadding="0" cellspacing="0" width="100%" style="margin-top: 10px">
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
            <form id="leaveForm" action="{{ url('form/leave/form/0') }}" enctype="multipart/form-data" method="POST"  style="margin-top: 1px;margin-left: 0.5%; margin-right: 0.5%">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" id="token" name="_token" value="<?php echo csrf_token(); ?>">
                            <input type="hidden" name="id" value="{{ $leave != null && $leave->id ? $leave->id : 0 }}">
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
                                                <input type="text" class="form-control" id="inputSuccess1" name="position" value="{{ $user->designation }}" readonly style="display: inline-block; width: 70%; margin-top: 4px">
                                            </div>
                                            <div class="col-md-5">
                                                <label class="control-label" for="inputSuccess1">5. SALARY</label>
                                                <input type="text" class="form-control" id="inputSuccess1" name="salary" value="{{ number_format($user->monthly_salary, 2, '.', ',') }}" readonly style="display: inline-block; width: 60%; margin-top: 4px">
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
                                                                "",
                                                                ""
                                                            ]
                                                            ?>
                                                            <div class="checkbox">
                                                                <label style="color:black">
                                                                    <input type="checkbox" style="margin-left:5px;" class="minimal leave-toggle"
                                                                    name="leave_type"value="{{ $row->code }}"
                                                                    {{ in_array($row->code, array_map('strval', $extended_leave->lists('leave_type'))) ? 'checked' : '' }}>
                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    {{ $row->code == "FL" ? 'Mandatory/Forced Leave' : ucwords(strtolower($row->desc)) }} 
                                                                    <span style="font-size: 10.6px; margin-left: auto">{{ $details[$index] }}</span>
                                                                    @if($row->code == 'OTHERS')
                                                                        <input type="text"  value ="{{ $leave ? $leave->for_others : '' }}" name="others_type" class="others_type_dis others_type_dis_txt" id="others_txt" style="width: 370px; margin-left: 20px; border: none; border-bottom: 2px solid black;" />
                                                                    @elseif($row->code == 'WL')
                                                                        <div class="wl_div" style="border:1px solid green; padding:10px; {{ in_array($row->code, array_map('strval', $extended_leave->lists('leave_type'))) ? 'display:block' : 'display:none' }} ">
                                                                            <input type="hidden" name="wl_type" id="wl_type">
                                                                            <input type="radio" class="minimal" style="margin-left:50px" id="wl_emergency" name="wl_emergency_status" value="wl_emergency"
                                                                                {{ ($i = array_search($row->code, array_map('strval', $extended_leave->lists('leave_type')))) !== false && isset($extended_leave[$i]) && $extended_leave[$i]->type == 'emergency' ? 'checked' : '' }}                                                                             
                                                                            >
                                                                            <label for="wl_emergency">Emergency</label>
                                                                            <input type="radio" class="minimal" style="margin-left:50px" id="wl_none_emergency" name="wl_emergency_status" value="wl_not_emergency"
                                                                                {{ ($i = array_search($row->code, array_map('strval', $extended_leave->lists('leave_type')))) !== false && isset($extended_leave[$i]) && $extended_leave[$i]->type == 'unemergency' ? 'checked' : '' }}                                                                             
                                                                            >
                                                                            <label for="wl_none_emergency">Not an Emergency</label>
                                                                            <!-- <div class="wl_attachment" style="width:100%; border:1px solid green; padding:10px; display:none;">
                                                                                <div style="display:flex; align-items:center; gap:10px;">
                                                                                    <label for="medical_certificate">Medical Certificate</label>
                                                                                    <input type="file"
                                                                                        id="medical_certificate"
                                                                                        name="medical_certificate"
                                                                                        accept=".pdf,image/*">
                                                                                </div>
                                                                            </div> -->
                                                                        </div>
                                                                    @elseif($row->code == 'SL')
                                                                        <div class="sl_div" style="border:1px solid green; padding:10px; {{ in_array($row->code, array_map('strval', $extended_leave->lists('leave_type'))) ? 'display:block' : 'display:none' }}">
                                                                            <input type="hidden" name="sl_type" id="sl_type">
                                                                            <input type="radio" class="minimal" style="margin-left:50px" id="sl_emergency" name="sl_emergency_status" value="sl_emergency"
                                                                                {{ ($i = array_search($row->code, array_map('strval', $extended_leave->lists('leave_type')))) !== false && isset($extended_leave[$i]) && $extended_leave[$i]->type == 'emergency' ? 'checked' : '' }}                                                                             
                                                                            >
                                                                            <label for="sl_emergency">Emergency</label>
                                                                            <input type="radio" class="minimal" style="margin-left:50px" id="sl_none_emergency" name="sl_emergency_status" value="sl_not_emergency"
                                                                                {{ ($i = array_search($row->code, array_map('strval', $extended_leave->lists('leave_type')))) !== false && isset($extended_leave[$i]) && $extended_leave[$i]->type == 'unemergency' ? 'checked' : '' }}                                                                             
                                                                            >
                                                                            <label for="sl_none_emergency">Not an Emergency</label>
                                                                            <div class="sl_attachment" tabindex="-1" style="width:100%; border:1px solid green; padding:10px; display:none;">
                                                                                <div style="display:flex; align-items:center; gap:10px;">
                                                                                    <label for="sl_medical_certificate">Medical Certificate</label>
                                                                                    <input type="file"
                                                                                        id="medical_certificate"
                                                                                        name="sl_medical_certificate"
                                                                                        accept=".pdf,image/*">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @elseif($row->code == 'SPL')
                                                                        <div class="spl_div" style="border:1px solid green; padding:10px; {{ in_array($row->code, array_map('strval', $extended_leave->lists('leave_type'))) ? 'display:block' : 'display:none' }}">
                                                                            <input type="hidden" name="spl_type" id="spl_type">
                                                                            <input type="radio" class="minimal" style="margin-left:50px" id="spl_emergency" name="spl_emergency_status" value="spl_emergency"
                                                                                {{ ($i = array_search($row->code, array_map('strval', $extended_leave->lists('leave_type')))) !== false && isset($extended_leave[$i]) && $extended_leave[$i]->type == 'emergency' ? 'checked' : '' }}                                                                             
                                                                            >
                                                                            <label for="spl_emergency">Emergency</label>
                                                                            <input type="radio" class="minimal" style="margin-left:50px" id="spl_none_emergency" name="spl_emergency_status" value="spl_not_emergency"
                                                                                {{ ($i = array_search($row->code, array_map('strval', $extended_leave->lists('leave_type')))) !== false && isset($extended_leave[$i]) && $extended_leave[$i]->type == 'unemergency' ? 'checked' : '' }}                                                                             
                                                                            >
                                                                            <label for="spl_none_emergency">Not an Emergency</label>
                                                                        </div>
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
                                                        <div class="checkbox" style="margin-left: 10px">

                                                            <label><i>In case of Vacation/Special Privilege leave</i></label><br>
                                                            <label style="display: inline-block; width: 100%;">
                                                                <input type="checkbox" id="checkboxSuccess1" class="vac_dis" value="1" name="leave_details[]" 
                                                                {{ $extended_details && in_array(1, array_map('strval', $extended_details->lists('details'))) ? 'checked' : '' }}>
                                                                Within the Philippines
                                                                <input type="text" name="within_txt" class="vac_dis" id="within_txt" style="margin-left: 2%; width: 60%; border: none; border-bottom: 2px solid black;" 
                                                                value="{{ $extended_details && (($index = array_search('1', array_map('strval', $extended_details->lists('details')))) !== false) ? $extended_details[$index]->remarks: '' }}">
                                                            </label>
                                                            <br>
                                                            <label style="display: inline-block; width: 100%;">
                                                                <input type="checkbox" id="checkboxSuccess2" class="vac_dis" value="2" name="leave_details[]" 
                                                                {{ $extended_details && in_array(2, array_map('strval', $extended_details->lists('details'))) ? 'checked' : '' }}
                                                                > Abroad (Specify)
                                                                <input type="text" name="abroad_txt" class="vac_dis" id="abroad_txt" style="margin-left: 2%; width: 67.5%; border: none; border-bottom: 2px solid black;"
                                                                value="{{ $extended_details && (($index = array_search('2', array_map('strval', $extended_details->lists('details')))) !== false) ? $extended_details[$index]->remarks: '' }}" />
                                                            </label> <br>
                                                            <label><i>In case of Sick Leave</i></label><br>
                                                            <label style="display: inline-block; width: 100%;">
                                                                <input type="checkbox" id="checkboxSuccess3" class="sick_dis" value="3" name="leave_details[]" 
                                                                {{ $extended_details && in_array(3, array_map('strval', $extended_details->lists('details'))) ? 'checked' : '' }}> In Hospital (Specify Illness)
                                                                <input type="text" name="in_hos_txt" class="sick_dis" id="in_hos_txt" style="margin-left: 2%; width: 53%; border: none; border-bottom: 2px solid black;" value="{{ $extended_details && (($index = array_search('3', array_map('strval', $extended_details->lists('details')))) !== false) ? $extended_details[$index]->remarks: '' }}" >
                                                            </label>
                                                            <label style="display: inline-block; width: 100%;">
                                                                <input type="checkbox" id="checkboxSuccess4" class="sick_dis" value="4" name="leave_details[]" {{ $extended_details && in_array(4, array_map('strval', $extended_details->lists('details'))) ? 'checked' : '' }}> Out-patient (Specify Illness)
                                                                <input type="text" name="out_hos_txt" class="sick_dis" id="out_hos_txt" style="margin-left: 1%; width: 53%; border: none; border-bottom: 2px solid black;" 
                                                                value="{{ $extended_details && (($index = array_search('4', array_map('strval', $extended_details->lists('details')))) !== false) ? $extended_details[$index]->remarks: '' }}">
                                                            </label><br>
                                                            <label><i>In case of Special Leave Benefits for Women</i></label><br>
                                                            <label style="display: inline-block; width: 100%;">
                                                                <input type="checkbox" id="checkboxSuccess5" class="spec_dis" value="5" name="leave_details[]" {{ $extended_details && in_array(5, array_map('strval', $extended_details->lists('details'))) ? 'checked' : '' }}> (Specify Illness)
                                                                <input type="text" name="spec_txt" class="spec_dis" id="spec_txt" style="margin-left: 2%; width: 68%; border: none; border-bottom: 2px solid black;" 
                                                                value="{{ $extended_details && (($index = array_search('5', array_map('strval', $extended_details->lists('details')))) !== false) ? (explode(' -- ', $extended_details[$index]->remarks)[0] ?? ''): ''}}">
                                                            </label><br>
                                                            <input type="text" name="spec_txt2" class="spec_dis" id="spec_txt2" style="margin-left: 4.5%; width: 90%; border: none; border-bottom: 2px solid black;" value="{{ $extended_details && (($index = array_search('5', array_map('strval', $extended_details->lists('details')))) !== false) ? (explode(' -- ', $extended_details[$index]->remarks)[1] ?? ''): ''}}">

                                                            <label><i>In case of Study Leave</i></label><br>
                                                            <label>
                                                                <input type="checkbox" id="checkboxSuccess6" class="stud_dis" value="6" name="leave_details[]" {{ ($leave != null && $leave->leave_details == 6) ? 'checked' : '' }}> Completion of Master's Degree
                                                            </label><br>
                                                            <label>
                                                                <input type="checkbox" id="checkboxSuccess7" class="stud_dis" value="7" name="leave_details[]" {{ ($leave != null && $leave->leave_details == 7) ? 'checked' : '' }}> BAR/Board Examination Review
                                                            </label><br>
                                                            <label><i>Other Purpose</i></label><br>
                                                            <label>
                                                                <input type="checkbox" id="checkboxSuccess8" class="others_dis" value="8" name="leave_details[]" {{ ($leave != null && $leave->leave_details == 8) ? 'checked' : '' }}> Monetization of Leave Credits
                                                            </label><br>
                                                            <div style="margin-left: 10%; width: 80%; text-align: center; display: none" id="monetize_display">
                                                                <select class="monetize_select form-control" id="monetizeSelect" name="monetize_select" onchange="monetize($(this).val())">
                                                                    <option value="">Please select value</option>
                                                                    <option value="10">10</option>
                                                                    <option value="15" {{ ($user->vacation_balance >= 15)?'':'disabled' }}>15</option>
                                                                    <option value="20" {{ ($user->vacation_balance >= 20)?'':'disabled' }}>20</option>
                                                                    <option value="25" {{ ($user->vacation_balance >= 25)?'':'disabled' }}>25</option>
                                                                    <option value="30" {{ ($user->vacation_balance >= 30)?'':'disabled' }}>30</option>
                                                                    <option value="50">50% Monetization</option>
                                                                </select>
                                                            </div>
                                                            <label>
                                                                <input type="checkbox" id="checkboxSuccess9" class="others_dis" value="9" name="leave_details[]" {{ ($leave != null && $leave->leave_details == 9) ? 'checked' : '' }}> Terminal Leave
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
                                        <input type="text" class="form-control" name="applied_num_days" id="applied_num_days" value="{{ $leave != null ? (int)$leave->applied_num_days : '' }}" style="text-align:center; margin-left: 5%; width: 50%;margin-top: 2%" readonly/>
                                        <input type="hidden" class="form-control" name="credit_used" id="credit_used"/>
                                        <strong class="sm-m-3" style="display: inline-block; margin-left: 5%; margin-top: 2%; ">INCLUSIVE DATES :</strong>
                                        <button  style="width: 50px; display: inline-block; margin-left: 20px; border-radius:0px; font-size:10px; height:20px" class="btn btn-xs btn-info addButton1" type="button">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                        <br><br>
                                        <div class="table-data" id="clone_data">
                                            @if(count($extended_leave) <= 0)
                                                <div class="input-group" style="padding: 0px; margin-left:5%; margin-bottom: 2px; width:100%" >
                                                    <select class="form-control chosen-select-static selected_type" name="selected_type[]" style="width: 80px;">
                                                        <option value="" selected disabled hidden>Type</option>
                                                    </select>
                                                    <div class="input-group-addon form-control" style="margin-bottom: 5px;width: 50px; ">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input style="width: 40%;" type="text" class="form-control datepickerInput1" id="inclusive11" name="inclusive_dates1[]" placeholder="Input date here..." required>
                                                    <input type="text" name="days_input[]" style="width: 10%;" class="form-control days_input" readonly>
                                                    <button style="width: 11.3%; margin-left: 5%" type="button" class="btn btn-sm btn-danger deleteButton1"><strong>-</strong></button>
                                                </div>
                                                <div class="row text-center date_remarks" id="date_remarks" style="padding:10px; width:90%; margin-left: 5%"></div>
                                            @else
                                                @foreach($extended_leave as $dates)
                                                    <div class="input-group" style="padding: 0px; margin-left:5%; margin-bottom: 2px; width:100%" >
                                                        <select class="form-control chosen-select-static selected_type" name="selected_type[]" style="width: 80px;">
                                                            <option value="" selected disabled hidden>Type</option>
                                                            @foreach($extended_leave as $date)
                                                                <option value="{{ $date->leave_type }}" {{ $dates->leave_type == $date->leave_type ? "selected" : '' }}>{{ $date->leave_type }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="input-group-addon form-control" style="margin-bottom: 5px;width: 50px; ">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input style="width: 40%;" type="text" class="form-control datepickerInput1" id="inclusive11" name="inclusive_dates1[]" placeholder="Input date here..." value="{{ date('m/d/Y',strtotime($dates->start)).' - '.date('m/d/Y',strtotime($dates->end)) }}" required>
                                                        <input type="text" name="days_input[]" value="{{ $dates->days }}" style="width: 10%;" class="form-control days_input" readonly>
                                                        <button style="width: 11.3%; margin-left: 5%" type="button" class="btn btn-sm btn-danger deleteButton1"><strong>-</strong></button>
                                                    </div>
                                                    <div class="row text-center date_remarks" id="date_remarks" style="padding:10px; width:90%; margin-left: 5%"></div>
                                                @endforeach
                                            @endif
                                        </div>
                                        @if($leave != null && $leave->sl_remarks)
                                            <div class="row" id="date_remarks2">
                                                @foreach($leave->sl_remarks as $index => $row)
                                                    <div class="row" style="padding: 7px; width: 90%; margin-left: 5%;">
                                                        <div>
                                                            @if($index == 0)
                                                                <div style="font-weight: bold; margin-bottom: 5px;">Remarks:</div>
                                                            @endif
                                                            <div style="display: flex; align-items: center; gap: 10px;">
                                                                <span style="white-space: nowrap;">{{ date('m/d/Y', strtotime($row->date)) }}</span>
                                                                <select class="chosen-select-static form-control sl_option" name="date_remarks[]" style="flex: 1; min-width: 120px;" required>
                                                                    <option value="">Select Reason</option>
                                                                    <option value="cdo" {{ $row->remarks == 'cdo' ? 'selected' :'' }}>CDO</option>
                                                                    <option value="leave" {{ $row->remarks == 'leave' ? 'selected' :'' }}>LEAVE</option>
                                                                    <option value="rpo" {{ $row->remarks == 'rpo' ? 'selected' :'' }}>RPO</option>
                                                                    <option value="holiday" {{ $row->remarks == 'holiday' ? 'selected' :'' }}>HOLIDAY</option>
                                                                </select>
                                                                <input type="{{ $row->remarks == 'rpo' ? 'text' : 'hidden' }}"
                                                                       value="{{ $row->repo_rem }}"
                                                                       class="form-control rpo_details"
                                                                       style="flex: 1; min-width: 160px;"
                                                                       name="rpo_rem[]"
                                                                       placeholder="rpo#/title">

                                                                <input type="hidden" name="s_dates[]" value="{{ date('m/d/Y', strtotime($row->date)) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                    <td style="width: 48%; margin-top: 10px; vertical-align: top; position: relative; flex-direction: column;" rowspan="2">
                                        <strong style="vertical-align: top">&nbsp;&nbsp;&nbsp;&nbsp;6.D COMMUTATION</strong>
                                        <div class="has-success" style="display: flex;">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="radio" id="commutation2" value="2" name="com_requested" 
                                                    {{ ($leave != null && $leave->commutation == 2) ? 'checked' : '' }}
                                                    > Not Requested
                                                </label><br>
                                                <label>
                                                    <input type="radio" id="commutation" value="1" name="com_requested" 
                                                    {{ ($leave != null && $leave->commutation == 1) ? 'checked' : '' }}

                                                    > Requested
                                                </label>
                                            </div>
                                        </div>
                                        <div style="position: absolute; bottom: 0; width: 100%; text-align:center">
                                            <img src="{{ asset('FPDF/image/line.png') }}" width="50%" style="" >
                                            <br>
                                            <span style=>(Signature of Applicant)</span>
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
                                        <p style="margin-left: 20%">As of <input name="as_of" style="border:none;border-bottom: 2px solid black; width:35%; text-align: center" value="<?php echo date('F j, Y', strtotime('last day of previous month')); ?>" readonly></p>
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
                                                        <td>{{ ($user->vacation_balance != null) ? $user->vacation_balance:0 }}</td>
                                                        <td>{{ ($user->sick_balance != null) ? $user->sick_balance:0 }}</td>
                                                    </tr>
                                                    <tr height ="30" style="">
                                                        <td>Less this application</td>
                                                        <td><input id="vl_less" name="vl_less" style="width: 30%; text-align: center; border:none" value="{{ !Empty($leave->vl_deduct) ? $leave->vl_deduct:0 }}" readonly></td>
                                                        <td><input id="sl_less" name="sl_less" style="width: 30%; text-align: center; border: none" value="{{ !Empty($leave->sl_deduct) ? $leave->sl_deduct:0 }}" readonly></td>
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
                                                                <option value="{{ $section_head['id'] }}" {{ ( $leave != null && $leave->officer_1 == $section_head['id']) ? 'selected':''}}>{{ $section_head['fname'].' '.$section_head['mname'].' '.$section_head['lname'] }}</option>
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
                                                        <option value="{{ $section_head['id'] }}" {{ ($leave != null && $leave->officer_2 == $section_head['id'])?'selected':''}}>{{ $section_head['fname'].' '.$section_head['mname'].' '.$section_head['lname'] }}</option>
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
                                        <span style="margin-left: 10%"><input value="{{ ($leave != null && $leave->with_pay != 0)? intval($leave->with_pay) :'' }}" style="width: 22%; border: none; border-bottom: 2px solid black; height: 2%; margin-bottom: 0px" id="with_pay" name="with_pay" readonly> days with pay</span><br>
                                        <span style="margin-left: 10%"><input value="{{ ($leave != null && $leave->without_pay != 0)? intval($leave->without_pay) :'' }}" style="width: 22%; border: none; border-bottom: 2px solid black; height: 2%" id="without_pay" name="without_pay" readonly> days without pay</span><br>
                                        <span style="margin-left: 10%"><input style="width: 22%; border: none; border-bottom: 2px solid black; height: 2%; margin-bottom: 0px" id="others_pay" name="others_pay" readonly> others (Specify)</span>
                                    <td style="width: 48%; margin-top: 10px;border-left: 0px;border-bottom: 0px; vertical-align: top" rowspan="2">
                                        <strong>&nbsp;&nbsp;&nbsp;7.D DISAPPROVED DUE TO:</strong>
                                        <div class="row" >
                                            <img src="{{ asset('FPDF/image/line.png') }}" width="80%" style="margin-left: 10%; height: .1px; margin-top: 20px;" ><br>
                                            <img src="{{ asset('FPDF/image/line.png') }}" width="80%" style="margin-left: 10%; height: .1px; margin-top: 20px;" ><br>
                                            <img src="{{ asset('FPDF/image/line.png') }}" width="80%" style="margin-left: 10%; height: .1px; margin-top: 20px;" ><br>
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
                                                @if(count($officer3) > 0)
                                                    @foreach($officer3 as $division_head)
                                                        <option value="{{ $division_head['id'] }}" {{ ($leave != null && $leave->officer_3 == $division_head['id'])?'selected':''}}>{{ $division_head['fname'].' '.$division_head['mname'].' '.$division_head['lname'] }}</option>
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
                <type type="hidden" id="monetize_val" name="monetize_val"></type>
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
                                <a target="_blank" class="btn btn-success" href="{{ asset('FPDF/print_leave.php?id=' . (($leave && $leave->id) ? $leave->id : 0)) }}" style="color: white;"><i class="fa fa-print"></i> Print(Front)</a>
                                <a target="_blank" class="btn btn-success" href="{{ asset('leave/print/' . (($leave && $leave->id) ? $leave->id : 0)) }}" style="color: white;"><i class="fa fa-print"></i> Print(Back)</a>
                                @if( Auth::user()->usertype !=1 && ($leave != null && $leave->status == 0) )
                                    <button type="button" onclick="updateForm()"  class="btn btn-primary" style="color:white;"><i class="fa fa-pencil"></i> Update</button>
                                    <a href="{{ asset('leave/delete/' . (($leave && $leave->id) ? $leave->id : 0)) }}" style="color:white" class="btn btn-danger" ><i class="fa fa-trash"></i> Remove</a>
                                @elseif($leave == null)
                                    <button type="submit" class="btn btn-success" style="color:white;"><i class="fa fa-send"></i> Submit</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" class="priv_data" name="priv_data" value="0">
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@include('form.form_leave_script')
<script>
    var vl = {{ ($user->vacation_balance != null) ? $user->vacation_balance : 0 }};
    var sl = {{ ($user->sick_balance != null) ? $user->sick_balance : 0 }};
    var priv = {{ $priv }};

    function updateForm() {
        console.log($('#leaveForm').length);
        $.ajax({
            url: "{{ url('leave/update/save') }}",
            type: "POST",
            data: $('#leaveForm').serialize(),
            success: function(response) {
                Lobibox.alert({
                    size: 'mini',
                    msg: 'Successfully updated leave application!'
                });
                location.reload();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    function monetize(data){

        $('#monetize_val').val(data);

        if(data == 50){
            
            Lobibox.alert('warning', {
                msg: '<i class="fa fa-spinner fa-spin"></i> Make sure to attach letter from RD',
                size: 'mini',
                closeButton: false,
                delay: false,
                sound: false
            });

            var total = Math.ceil((vl + sl)/2);

            $('#with_pay').val(total + " day(s)");
            $('#applied_num_days').val(total);
            
            var div = total/2;
            var to_add = 0;
            var vl_deduct = 0;
            var sl_deduct = 0;

            if(vl >= div){
                vl_deduct = div;
            }else{
                vl_deduct = vl;
                to_add = div - vl;
            }

            if(sl >= div){
                sl_deduct = div + to_add;
            }else{
                sl_deduct = sl;
                vl_deduct = vl_deduct + (div - sl);
            }

            $('#vl_rem').val(vl >= vl_deduct ? vl - vl_deduct : 0);
            $('#sl_rem').val(sl >= sl_deduct ? sl - sl_deduct : 0);
            $('#vl_less').val(vl_deduct);
            $('#sl_less').val(sl_deduct);
        }else{
            if(vl < 15){
                Lobibox.alert('error', {
                    msg: '<i class="fa fa-spinner fa-spin"></i> Monetization request denied. The Vacation Leave (VL) balance must be at least 15 days to qualify for monetization',
                    size: 'mini',
                    closeButton: false,
                    delay: false,
                    sound: false
                });
                $('#monetizeSelect').val('').trigger('chosen:updated');
            }else{
                $('#with_pay').val(data + " day(s)");
                $('#applied_num_days').val(data);
            
                $('#vl_less').val(data);
                $('#vl_rem').val(vl-data);
                $('#sl_less').val(0);
                $('#sl_rem').val(sl);
            }
           
        }
    }

    var updated = '<?php echo $update; ?>'
    $('.chosen-select-static').chosen();
    $('#inc_date').daterangepicker();
    $('input[name="leave_type"]').change(function(){

        var val = this.value;

        var selected_type = $('.selected_type');

        var checkedValues = $('input[name="leave_type"]:checked')
            .map(function () {
                return $(this).val();
            })
            .get();
        
        checkedValues.forEach(function(item) {
            if (selected_type.find('option[value="' + item + '"]').length === 0) {
                selected_type.append(
                    $('<option>', {
                        value: item,
                        text: item
                    })
                );
            }
        });

        selected_type.trigger('chosen:updated'); 

        com2();

        if(val == "SL") {
            $('input[name="sl_emergency_status"]').prop('checked', false);
            $('.sl_attachment').css('display', 'none');
            $('.sl_div').css('display', 'block');
        } else if(val == "SPL") {
            $('.spl_div').css('display', 'block');

        }else if(val == "WL"){
            $('.wl_div').css('display', 'block');
        }

        if (!checkedValues.includes('SL')) {
            $('.sl_div').css('display', 'none');
        }

        if (!checkedValues.includes('SPL')) {
            $('.spl_div').css('display', 'none');
        }

        if (!checkedValues.includes('WL')) {
            $('.wl_div').css('display', 'none');
        }
    });

    var mon = 0;
    var term = 0;

    $('input[class="others_dis"]').change(function(){
        var val = this.value;
        $('.leave-toggle').prop('checked', false);
        $('#applied_num_days').val('');
        $('.datepickerInput1').val('');
        $('.days_input').val('');
        $('.selected_type').empty().trigger('chosen:updated');
        $('#data_here .input-group').not(':first').each(function() {
            $(this).next('.date_remarks').remove(); 
            $(this).remove(); 
        });

        $('#applied_num_days').val(overall_days());
        deduction();
        check_with_pay();
        com();
        $('#inclusive11').attr({ required: false, disabled: true });

        if(val == 8){
            
            $([1, 2, 3, 4, 5, 6, 7, 9].map(i => `#checkboxSuccess${i}`).join(',')).prop('checked', false);
            if(mon == 0){
                $('#monetizeSelect').attr('required', true);
                $('#monetize_display').css('display', 'block');
                mon = 1;
            }else{
                $('#monetizeSelect').attr('required', false);
                $('#monetize_display').css('display', 'none');
                mon = 0;
            }
        }else{
            mon = 0;
            $('#monetizeSelect').attr('required', false);
            $('#monetize_display').css('display', 'none');
            $([1, 2, 3, 4, 5, 6, 7, 8].map(i => `#checkboxSuccess${i}`).join(',')).prop('checked', false);
            $('#without_pay').val("");
            if(term == 0){
                var total = vl + sl;
                $('#with_pay').val(total + " day(s)");
                $('#applied_num_days').val(total);
                $('#vl_less').val(vl);
                $('#vl_rem').val(0);
                $('#sl_less').val(sl);
                $('#sl_rem').val(0);
                term = 1;
            }else{
                $('#with_pay').val("");
                $('#applied_num_days').val("");
                $('#vl_less').val(0);
                $('#vl_rem').val(vl);
                $('#sl_less').val(0);
                $('#sl_rem').val(sl);
                term = 0;
            }
            
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