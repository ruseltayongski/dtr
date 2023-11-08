
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <table cellpadding="0" cellspacing="0" width="100%" style="margin-top: 10px">
                <tr>
                    <td class="align" width="15%" style="text-align: center; vertical-align: top;"><small>Civil Service Form No. 6<br>Revised 2020</small></td>
                    <td class="align" width="15%" style="text-align: right"><img src="{{ asset('public/img/doh.png') }}" width="100" ></td>
                    <td width="48%" >
                        <div class="align small-text" style="text-align: center">
                            Republic of the Philippines<br>
                            <strong>DEPARTMENT OF HEALTH<br>
                                CENTRAL VISAYAS CENTER for HEALTH DEVELOPMENT<br></strong>
                            Osmeña Boulevard, Cebu City, 6000 Philippines<br>
                        </div>
                    </td>
                    <td class="align" width="30%" style="text-align: center; vertical-align: center;"><h6>
                            <u>_____________</u><br>Date of Receipt
                        </h6></td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" width="100%" style="margin-top: 5px; margin-bottom: 5px">
                <thead></thead>
                <tbody>
                <tr>
                    <th style="width: 100%;text-align: center; font-size: 25px;">APPLICATION FOR LEAVE</th>
                </tr>
                </tbody>
            </table>
            <table border="2" style="width: 100%;" >
                <tr>
                    <td width="25%">
                        <p style="padding: 10px;">
                            1. OFFICE/DEPARTMENT <br /><b>{{ $leave->office_agency }}</b>
                        </p>
                    </td>
                    <td width="75%">
                        <div class="row" style="padding: 10px;">
                            <span class="col-sm-3">2. NAME:</span>
                            <span class="col-sm-3">(Last)</span>
                            <span class="col-sm-3">(First)</span>
                            <span class="col-sm-3">(Middle)</span>
                            <br>
                            <span class="col-sm-3">&nbsp;</span>
                            <span class="col-sm-3"><b>{{ $leave->lastname }}</b></span>
                            <span class="col-sm-3"><b>{{ $leave->firstname }}</b></span>
                            <span class="col-sm-3"><b>{{ $leave->middlename }}</b></span>
                        </div>
                    </td>
                </tr>
            </table>
            <table border="2" style="width: 100%;border-top: 0px;">
                <tr>
                    <td width="25%">
                        <p style="padding: 10px;">
                            3. DATE OF FILING<b> &nbsp; &nbsp; &nbsp;{{ $leave->date_filling }}</b>
                        </p>
                    </td>
                    <td width="75%">
                        <p style="padding: 10px;">
                            4. POSITION<b> &nbsp; &nbsp; &nbsp;{{ $leave->position }}</b>
                            &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
                            &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
                            &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;
                            5. SALARY<b> &nbsp; &nbsp; &nbsp;{{ $leave->salary }}</b>
                        </p>
                    </td>
                </tr>
            </table>
            <table border="2" style="width: 100%;">
                <thead></thead>
                <tbody>
                <tr>
                    <th style="width: 100%;text-align: center; font-size: 20px;">6. DETAILS OF APPLICATION</th>
                </tr>
                </tbody>
            </table>
            <table border="2" style="width: 100%;" >
                <thead></thead>
                <tbody>
                <tr>
                    <td class="col-md-6">
                        <div class="row" style="padding: 10px;">
                            <div class="col-md-12">
                                <strong>6.A TYPE OF LEAVE TO BE AVAILED OF</strong>
                                <br><br>
                                @if(isset($leaveTypes))
                                @foreach($leaveTypes as $row)
                                    <div class="row">
                                        @if($leave->leave_type == $row->code)
                                            <span style="text-decoration: underline; margin-left: 40px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                            @if($leave->leave_type == "OTHERS")
                                                <u style="margin-left: 20px">{{$leave->for_others}}</u>
                                            @else
                                                <span style="margin-left: 22px;"> {{ $row->desc }} </span>
                                            @endif
                                        @else
                                            <span style="margin-left: 80px;"> {{ $row->desc }} </span>
                                        @endif


                                    </div>
                                @endforeach
                                    @endif
                            </div>
                        </div>
                    </td>
                    <td class="col-md-6">
                        <div class="row" style="padding: 10px;">
                            <div class="col-md-12">
                                <strong>6.B DETAILS OF LEAVE<br></strong>
                                <div class="row">
                                    <div class="col-md-12 col-md col-md-offset-1">
                                        <div class="row">
                                            <br><span><i>In case of Vacation/Special Privilege Leave</i></span>
                                            @if ($leave->leave_details == '1')
                                                <br><span style="text-decoration: underline; margin-left: 10px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                <span class="{{ $leave->leave_details == '1' ? 'text-decoration-underline' : '' }}"  style="margin-left: 10px">Within the Philippines</span>
                                                <u style="margin-left: 10px">{{$leave->leave_specify}}</u>
                                                <br><span style="margin-left: 36px">Abroad (Specify)</span><br>
                                            @elseif ($leave->leave_details == '2')
                                                <br><span style="margin-left: 36px">Within the Philippines</span><br>
                                                <span style="text-decoration: underline; margin-left: 10px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                <span class="{{ $leave->leave_details == '2' ? 'text-decoration-underline' : '' }}" style="margin-left: 10px">Abroad (Specify)</span>
                                                <u style="margin-left: 10px">{{$leave->leave_specify}}</u>
                                            @else
                                                <br><span style="margin-left: 36px">Within the Philippines</span>
                                                <br><span style="margin-left: 36px">Abroad (Specify)</span>
                                            @endif

                                        </div>
                                        <div class="row">
                                            <span><i>In case of Sick Leave</i></span>
                                            @if ($leave->leave_details == '3')
                                                <span style="text-decoration: underline; margin-left: 10px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                <span class="{{ $leave->leave_details == '3' ? 'text-decoration-underline' : '' }}"  style="margin-left: 10px">In Hospital (Specify Illness)</span>
                                                <u style="margin-left: 10px">{{$leave->leave_specify}}</u>
                                                <br><span style="margin-left: 36px">Out Patient (Specify Illness)</span><br>
                                            @elseif ($leave->leave_details == '4')
                                                <br><span style="margin-left: 36px">In Hospital (Specify Illness)</span><br>
                                                <span style="text-decoration: underline; margin-left: 10px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                <span class="{{ $leave->leave_details == '4' ? 'text-decoration-underline' : '' }}" style="margin-left: 10px">Out Patient (Specify Illness)</span>
                                                <u style="margin-left: 10px">{{$leave->leave_specify}}</u>
                                            @else
                                                <br><span style="margin-left: 36px">In Hospital (Specify Illness)</span>
                                                <br><span style="margin-left: 36px">Out Patient (Specify Illness)</span>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <span><i>In case of Special Leave Benefits for Women</i></span><br>
                                            @if ($leave->leave_details == '5')
                                                <span style="text-decoration: underline; margin-left: 10px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                <span class="{{ $leave->leave_details == '5' ? 'text-decoration-underline' : '' }}"  style="margin-left: 10px"> (Specify Illness)</span>
                                                <u style="margin-left: 10px">{{$leave->leave_specify}}</u>
                                            @else
                                                <span style="margin-left: 36px">(Specify Illness)</span>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <span><i>In case of Study Leave</i></span>
                                            @if ($leave->leave_details == '6')
                                                <span style="text-decoration: underline; margin-left: 10px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                <span class="{{ $leave->leave_details == '6' ? 'text-decoration-underline' : '' }}"  style="margin-left: 10px">Comppletion of Master's Degree</span>
                                                <u style="margin-left: 10px">{{$leave->leave_specify}}</u>
                                                <br><span style="margin-left: 36px">BAR/Board Examination Review</span>
                                            @elseif ($leave->leave_details == '7')
                                                <br><span style="margin-left: 36px">Completion of Master's Degree</span>
                                                <span style="text-decoration: underline; margin-left: 10px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                <span class="{{ $leave->leave_details == '7' ? 'text-decoration-underline' : '' }}" style="margin-left: 10px">BAR/Board Examination Review</span>
                                                <u style="margin-left: 10px">{{$leave->leave_specify}}</u>
                                            @else
                                                <br><span style="margin-left: 36px">Completion of Master's Degree</span>
                                                <br><span style="margin-left: 36px">BAR/Board Examination Review</span>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <span><i>Other Purpose</i></span>
                                            @if ($leave->leave_details == '6')
                                                <span style="text-decoration: underline; margin-left: 10px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                <span class="{{ $leave->leave_details == '6' ? 'text-decoration-underline' : '' }}"  style="margin-left: 10px">Monetization of Leave Credits</span>
                                                <br><span style="margin-left: 36px">Terminal Leave</span>
                                            @elseif ($leave->leave_details == '7')
                                                <br><span style="margin-left: 36px">Monetization of Leave Credits</span>
                                                <span style="text-decoration: underline; margin-left: 10px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                <span class="{{ $leave->leave_details == '7' ? 'text-decoration-underline' : '' }}" style="margin-left: 10px">Terminal Leave</span>
                                            @else
                                                <br><span style="margin-left: 36px">Monetization of Leave Credits</span>
                                                <br><span style="margin-left: 36px">Terminal Leave</span>
                                            @endif
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <table border="2" style="width: 100%;border-top: 0px;" >
                <thead></thead>
                <tbody>
                <tr>
                    <td class="col-md-6" style="vertical-align: top">
                        <br>
                        <strong>6.C NUMBER OF WORKING DAYS APPLIED FOR :
                            @if(isset($leave->applied_num_days))
                                <span style="text-decoration: underline;" class="tab2">{{ $leave->applied_num_days }}</span>
                            @endif
                        </strong>
                        <br />
                        <div class="row">
                            <div class="col-md-12">
                                <strong >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Inclusive Dates : </strong><br>

                                @foreach($leave_dates as $dates)
                                <strong style="margin-left: 1%">

                                    @if(  date('F d,Y',strtotime($dates->startdate)) == date('F d,Y',strtotime($dates->enddate)))
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><i style="margin-left: 20px">{{ date('F d,Y',strtotime($dates->startdate))}}</i></u>
                                    @else
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i style="margin-left: 20px">{{ date('F d,Y',strtotime($dates->startdate)).' to '.date('F d,Y',strtotime($dates->enddate)) }}</i>
                                    @endif
                                    &nbsp;&nbsp;
                                </strong><br>
                                @endforeach
                                <small class="text-orange" style="margin-left: 28%">
                                    @if(!empty($leave->half_day_first) && !empty($leave->half_day_last))
                                        Half day in first day({{ $leave->half_day_first }}) and half day({{ $leave->half_day_last }}) in last day
                                    @elseif(!empty($leave->half_day_first))
                                        Half day in first day({{ $leave->half_day_first }})
                                    @elseif(!empty($leave->half_day_last))
                                        Half day in last day({{ $leave->half_day_last }})
                                    @endif
                                </small>
                            </div>
                        </div>
                    </td>
                    <td class="col-md-6" style="vertical-align: top">
                        <br>
                        <strong>6.D COMMUTATION</strong>
                        <br />
                        <div class="row">

                                @if($leave->com_requested == "1")
                                    <span style="text-decoration: underline; margin-left: 30px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                    <span>Requested</span><br>
                                    <span style="margin-left: 45px">Requested</span>
                                @else
                                    <span style="margin-left: 45px">Requested</span><br>
                                    <span style="text-decoration: underline; margin-left: 30px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                    <span>Not Requested</span>
                                @endif

                        </div>
                        <div class="row">
                            <div class="has-success text-center">
                                <br />
                                <br />
                                <p style="border-top: solid 2px black; width: 100%;">(Signature of Applicant)</p>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <table border="2" style="width: 100%;">
                <thead></thead>
                <tbody>
                <tr>
                    <th style="width: 100%;text-align: center; font-size: 20px;">7. DETAILS OF ACTION ON APPLICATION</th>
                </tr>
                </tbody>
            </table>
            <table border="2" style="width: 100%;" >
                <thead></thead>
                <tbody>
                <tr>
                    <td class="col-md-6">
                        <div class="row" style="padding:10px;">
                            <div class="col-md-12">
                                <strong>7.A CERTIFICATION OF LEAVE CREDITS <br />AS OF : <span style="text-decoration: underline;"></span></strong>
                                <div class="row">
                                    <div class="col-md-12">
                                        <br />
                                        <table border="2" style="width: 100%; text-align: center;">
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
                                                <td>{{ $leave->vacation_balance }}</td>
                                                <td>{{ $leave->sick_balance }}</td>
                                            </tr>
                                            <tr height ="30">
                                                <td>Less this application</td>
                                                <?php
                                                    if($leave->credit_used == "VL"){
                                                        $total1 = $leave->applied_num_days;
                                                        $total2 = 0;
                                                    }else if($leave->credit_used == "SL"){
                                                        $total1 = 0;
                                                        $total2 = $leave->applied_num_days;
                                                    }else{
                                                        $total1 = 0;
                                                        $total2 = 0;
                                                    }
                                                ?>
                                                <td>{{$total1}} </td>
                                                <td>{{$total2}}</td>
                                            </tr>
                                            <tr height = "30">
                                                <?php
                                                $vac_bal = $leave->vacation_balance;
                                                $sick_bal = $leave->sick_balance;

                                                $total_val = $vac_bal-$total1;
                                                $total_sick = $sick_bal-$total2;
                                                ?>
                                                <td class="col-md-2">Balance</td>
                                                <td class="col-md-2">{{ $total_val > 1 ? $total_val.' days' : $total_val.' day' }}</td>
                                                <td class="col-md-2">{{ $total_sick > 1 ? $total_sick.' days' : $total_sick.' day' }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <br />
                                <u style="text-decoration: underline solid; color: #000; width: 100%;"><b>THERESA Q. TRAGICO</b></u>
                                <br />
                                <strong>ADMINISTRATIVE OFFICER V</strong>
                            </div>
                        </div>
                    </td>
                    <td class="col-md-6" style="vertical-align: top; position: relative">
                        <div class="row" style="padding:10px;">
                            <div class="col-md-12">
                                <strong>7.B RECOMMENDATION</strong>
                                <div class="row" >
                                    <strong class="col-sm-1">
                                        @if($leave->reco_approval == "approve")
                                            <span style="text-decoration: underline;width: 20px;" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                        @else
                                            <span style="text-decoration: underline;" aria-hidden="true">&nbsp;</span>
                                        @endif
                                    </strong>
                                    <label>For Approval</label><br>
                                    <strong class="col-sm-1">
                                        @if($leave->reco_approval == "disapprove")
                                            <span style="text-decoration: underline;width: 20px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                        @else
                                            <span style="text-decoration: underline;" aria-hidden="true">&nbsp;</span>
                                        @endif
                                    </strong>
                                    <strong style="margin-left: 10px">For disapproval due to </strong>
                                    @if(isset($leave->disapproved_due_to))
                                        <em>{{ $leave->disapproved_due_to }}</em>
                                    @endif
                                </div>
                                <br><br><br><br><br><br><br><br>
                                <div class="bottom-text">
                                    <p style="border-top: solid 2px black; width: 100%; text-align: center; margin-bottom: 0px">(Authorized Officer)</p>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <table border="2" style="width: 100%;" >
                <thead></thead>
                <tbody>
                <tr>
                    <td class="col-md-6">
                        <div class="row" style="padding:10px;">
                            <strong>7.C APPROVE FOR :</strong>
                            <br />
                            <div class="col-md-12">
                                <div class="row">


                                            @if($leave->approved_for== "1")
                                                    <span style="text-decoration: underline; margin-left: 20px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                    <strong>days with pay</strong><br>
                                                    <strong style="margin-left: 40px">days without pay</strong><br>
                                                    <strong style="margin-left: 40px">others (specify)</strong>

                                            @elseif($leave->approved_for== "2")

                                                    <strong style="margin-left: 40px">days with pay</strong><br>
                                                    <span style="text-decoration: underline; margin-left: 20px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                    <strong>days without pay</strong><br>
                                                    <strong style="margin-left: 40px">others (specify)</strong>

                                             @elseif($leave->approved_for !=null)

                                                    <strong style="margin-left: 40px">days with pay</strong><br>
                                                    <strong style="margin-left: 40px">days without pay</strong><br>
                                                    <span style="text-decoration: underline; margin-left: 20px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                    <strong style="margin-left: 2px">others (specify)</strong>
                                                    <u style="margin-left: 10px">{{$leave->approved_for}}</u>
                                             @else
                                                    <strong style="margin-left: 40px">days with pay</strong><br>
                                                    <strong style="margin-left: 40px">days without pay</strong><br>
                                                    <strong style="margin-left: 40px">others (specify)</strong>
                                                @endif

                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="col-md-6" style="vertical-align: top">
                        <div class="row" style="padding: 10px;">
                            <strong>7.D DISAPPROVED DUE TO :</strong>
                            <br />
                            @if(isset($leave->reason_for_disapproval))
                               <u style="margin-left: 50px"><em>{{ $leave->reason_for_disapproval }}</em></u>
                            @endif
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <a target="_blank" class="btn btn-success" href="{{ asset('FPDF/print_leave.php?id=' .$leave->id) }}" style="color: white;"><i class="fa fa-print"></i> Print</a>
                @if(Auth::user()->usertype !=1 && $leave->status != 'APPROVED')
                    <a href="{{ asset('leave/update/' . $leave->id) }}"  class="btn btn-primary btn-submit" style="color:white;"><i class="fa fa-pencil"></i> Update</a>
                    <a href="{{ asset('leave/delete/' .$leave->id) }}" style="color:white" class="btn btn-danger" ><i class="fa fa-trash"></i> Remove</a>
                @endif
            </div>
        </div>
    </div>
</div>
<style>

</style>
