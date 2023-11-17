<html lang="en"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>LEAVE</title><head>
    <link href="{{realpath(__DIR__ . '/../../..').'/public/assets/css/print.css'}}" rel="stylesheet">
    <style>
        /*html {*/
            /*margin-top: 20px;*/
            /*margin-right: 20px;*/
            /*margin-left: 20px;*/
            /*margin-bottom: 0px;*/
            /*font-size: x-small;*/
            /*font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;*/
        /*}*/

        /*#border {*/
            /*border-collapse: collapse;*/
            /*border: none;*/
        /*}*/

        /*#border-top {*/
            /*border-collapse: collapse;*/
            /*border-top: none;*/
        /*}*/

        /*#border-right {*/
            /*border-collapse: collapse;*/
            /*border: 1px solid #000;*/
        /*}*/

        /*#border-bottom {*/
            /*border-collapse: collapse;*/
            /*border-bottom: none;*/
        /*}*/

        /*#border-bottom-t {*/
            /*border-collapse: collapse;*/
            /*border-top: 1px solid red;*/
            /*border-bottom: 1px solid red;*/
        /*}*/

        /*#border-left {*/
            /*border-collapse: collapse;*/
            /*border: 1px solid #000;*/
        /*}*/

        .align {
            text-align: center;
        }

        /*.align-top {*/
            /*vertical-align: top;*/
        /*}*/

        /*.align-right {*/
            /*text-align: right;*/
        /*}*/

        /*.table1 {*/
            /*width: 100%;*/
        /*}*/

        /*.table1 td {*/
            /*border: 1px solid #000;*/
        /*}*/

        /*.footer {*/
            /*width: 100%;*/
            /*text-align: center;*/
            /*position: fixed;*/
        /*}*/

        /*.footer {*/
            /*bottom: 15px;*/
        /*}*/

        /*.pagenum:before {*/
            /*content: counter(page);*/
        /*}*/

        /*.pagenum:before {*/
            /*content: counter(page);*/
        /*}*/

        .new-times-roman {
            font-family: "Times New Roman", Times, serif;
            font-size: 9.5pt;
        }

        #no-border {
            border-collapse: collapse;
            border: none;
        }
    </style>
</head><body>
    @for($i=0;$i<2;$i++)<div class="new-times-roman" style="margin-top:<?php if($i==1) echo '3.5%'; else echo '0%'; ?>">@if($i==1)
        <hr>@endif
        <table class="letter-head" cellpadding="0" cellspacing="0">
        <tr>
            <td id="no-border"  class="align" style="width: 15%;"><small>Civil Service Form No. 8 Revised 2020</small></td>
            <td id="no-border" class="align"><img src="{{realpath(__DIR__ . '/../../..').'/public/img/doh.png'}}" width="100"></td>
            <td width="100%" id="no-border">
                <div class="align" style="font-size: 10.5pt"> <br>Department of Health<br><strong>CENTRAL VISAYAS CENTER for HEALTH DEVELOPMENT</strong><br><br>APPLICATION FOR LEAVE</div>
            </td>
            <td id="no-border" class="align"><u>______________</u><br>Date of Receipt</td>
        </tr>
    </table>
        <table style="width: 100%; border-collapse: collapse; border: 1px solid black;">
            <tr>
                <td width="35%" style="border: 1px solid black; padding: 5px;">1. OFFICE/DEPARTMENT <br>{{ $leave->office_agency }}</td>
                <td width="65%" style="border: 1px solid black; padding: 5px;">

                    <label>2. NAME:</label>
                    <label style="margin-left: 10%">(Last)</label>
                    <label style="margin-left: 15%">(First)</label>
                    <label style="margin-left: 15%">(Middle)</label>
                    <br>
                    <label style="margin-left: 20%">{{ $leave->lastname }}</label>
                    <label style="margin-left: 12%">{{ $leave->firstname }}</label>
                    <label style="margin-left: 10%">{{ $leave->middlename }}</label>

                </td>
            </tr>
        </table>
        <table style="width: 100%; border-collapse: collapse; border: 1px solid black; border-top: 0px">
            <tr>
                <td width="35%" style="border: 1px solid black; padding: 5px;border-top: 0px">3. DATE OF FILING{{ $leave->date_filling }}</td>
                <td width="65%">
                    4. POSITION : &nbsp;&nbsp;{{ $leave->position }}
                   <label style="margin-left: 5%">5. SALARY :&nbsp; &nbsp;{{ $leave->salary }}</label>
                </td>
            </tr>
        </table>
        <table style="width: 100%; border-collapse: collapse; border: 1px solid black; border-top: 0px">
            <tr>
                <th style="width: 100%;text-align: center;"><strong>6. DETAILS OF APPLICATION</strong></th>
            </tr>
        </table>
        <table style="width: 100%; border-collapse: collapse; border: 1px solid black; border-top: 0px">
            <tr>
                <td style="width:50%;border: 1px solid black; padding: 5px;border-top: 0px">
                   6.A TYPE OF LEAVE TO BE AVAILED OF<br>
                   @if(isset($leaveTypes))
                       @foreach($leaveTypes as $row)
                           <div class="row">
                               @if($leave->leave_type == $row->code)
                                   <span style="font-weight: bold; text-decoration: underline; margin-left: 40px" class="glyphicon glyphicon-glass" aria-hidden="true"></span>
                                   @if($leave->leave_type == "OTHERS")
                                       <u style="margin-left: 20px">{{$leave->for_others}}</u>
                                   @else
                                       <span style="margin-left: 22px;"> {{ $row->desc }} </span>
                                   @endif
                               @else
                                   <span style="margin-left: 15%;"> {{ $row->desc }} </span>
                               @endif
                           </div>
                       @endforeach
                   @endif
               </td>
                <td style="width:50%;border: 1px solid black; padding: 5px;border-top: 0px">
                    6.B DETAILS OF LEAVE <br>
                    <div class="row" style="margin-left: 10%">
                            <div class="row">
                                <br><span>In case of Vacation/Special Privilege Leave</span>

                                @if ($leave->leave_details == '1')
                                    <br><label style="text-decoration: underline; margin-left: 10px" class="glyphicon glyphicon-ok" aria-hidden="true"></label>
                                    <label class="{{ $leave->leave_details == '1' ? 'text-decoration-underline' : '' }}"  style="margin-left: 10px">Within the Philippines</label>
                                    <u style="margin-left: 10px">{{$leave->leave_specify}}</u>
                                    <br><label style="margin-left: 36px">Abroad (Specify)</label><br>
                                @elseif ($leave->leave_details == '2')
                                    <br><span style="margin-left: 36px">Within the Philippines</span><br>
                                    <label style="text-decoration: underline; margin-left: 10px" class="glyphicon glyphicon-ok" aria-hidden="true"></label>
                                    <label class="{{ $leave->leave_details == '2' ? 'text-decoration-underline' : '' }}" style="margin-left: 10px">Abroad (Specify)</label>
                                    <label style="margin-left: 10px">{{$leave->leave_specify}}</label>
                                @else
                                    <br><label style="margin-left: 36px">Within the Philippines</label>
                                    <br><label style="margin-left: 36px">Abroad (Specify)</label>
                                @endif

                            </div>
                            <div class="row">
                                <span>In case of Sick Leave</span>
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
                                <span>In case of Special Leave Benefits for Women</span><br>
                                @if ($leave->leave_details == '5')
                                    <span style="text-decoration: underline; margin-left: 10px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                    <span class="{{ $leave->leave_details == '5' ? 'text-decoration-underline' : '' }}"  style="margin-left: 10px"> (Specify Illness)</span>
                                    <u style="margin-left: 10px">{{$leave->leave_specify}}</u>
                                @else
                                    <span style="margin-left: 36px">(Specify Illness)</span>
                                @endif
                            </div>
                            <div class="row">
                                <span>In case of Study Leave</span>
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
                                <span>Other Purpose</span>
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
                </td>
            </tr>
            <tr>
                <td style="width:50%;border: 1px solid black; padding: 5px;border-top: 0px">
                    <br>
                    <strong>6.C NUMBER OF WORKING DAYS APPLIED FOR :
                        @if(isset($leave->applied_num_days))
                            <span style="text-decoration: underline;" class="tab2">{{ $leave->applied_num_days }}</span>
                        @endif
                    </strong>
                    <br />
                    <div class="row">
                        <div class="col-md-12">
                            <strong >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;INCLUSIVE DATES: </strong><br>

                            @foreach($leave_dates as $dates)
                                <strong style="margin-left: 1%">

                                    @if(  date('F d,Y',strtotime($dates->startdate)) == date('F d,Y',strtotime($dates->enddate)))
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u style="margin-left: 10%">{{ date('F d,Y',strtotime($dates->startdate))}}</u>
                                    @else
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label style="margin-left: 10%px">{{ date('F d,Y',strtotime($dates->startdate)).' to '.date('F d,Y',strtotime($dates->enddate)) }}</label>
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
                <td style="width:50%;border: 1px solid black; padding: 5px;border-top: 0px;">
                    <br>
                    <strong>6.D COMMUTATION</strong>
                    <br />
                    <div class="row" style="margin-left: 10%">

                        @if($leave->com_requested == "1")
                            <span style="text-decoration: underline; margin-left: 10%" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                            <span>Requested</span><br>
                            <span style="margin-left: 10%">Requested</span>
                        @else
                            <span style="margin-left: 10%">Requested</span><br>
                            <span style="text-decoration: underline; margin-left: 10%" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                            <span>Not Requested</span>
                        @endif
                            <br><br>
                    </div>
                    <div style="text-align: center">
                        <label style="border-top: solid 2px black; width: 50%;">(Signature of Applicant)</label>
                    </div>


                </td>
            </tr>
        </table>
        <table style="width: 100%; border-collapse: collapse; border: 1px solid black; border-top: 0px">
            <tr>
                <th style="width: 100%;text-align: center;"><strong>7. DETAILS OF ACTION ON APPLICATION</strong></th>
            </tr>
        </table>
        <table style="width: 100%; border-collapse: collapse; border: 1px solid black; border-top: 0px">
            <tr>
                <td style="width:50%;border: 1px solid black; padding: 5px;border-top: 0px; vertical-align: top">
                            <strong>7.A CERTIFICATION OF LEAVE CREDITS <br />AS OF : <span style="text-decoration: underline;"></span></strong>

                                    <br />
                                    {{--<table style="width: 100%; border-collapse: collapse; border: 1px solid black; border-top: 0px">--}}
                                    <table style="width: 85%; text-align: center; border-collapse: collapse; border: 1px solid black">
                                        <tr>
                                            <th style="text-align: center; width: 10px; border: 1px solid black;width: 50%;"></th>
                                            <th style="text-align: center;border: 1px solid black;width: 40%;">Vacation Leave</th>
                                            <th style="text-align: center;border: 1px solid black;width: 40%;">Sick Leave</th>
                                        </tr>
                                        <tr height="40px">
                                            <td style="border: 1px solid black;">Total Earned</td>
                                            <td style="border: 1px solid black;">{{ $leave->vacation_balance }}</td>
                                            <td style="border: 1px solid black;">{{ $leave->sick_balance }}</td>
                                        </tr>
                                        <tr height ="40px">
                                            <td style="border: 1px solid black;">Less this application</td>
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
                                            <td style="border: 1px solid black;">{{$total1}} </td>
                                            <td style="border: 1px solid black;">{{$total2}}</td>
                                        </tr>
                                        <tr height = "40px">
                                            <?php
                                            $vac_bal = $leave->vacation_balance;
                                            $sick_bal = $leave->sick_balance;

                                            $total_val = $vac_bal-$total1;
                                            $total_sick = $sick_bal-$total2;
                                            ?>
                                            <td style="border: 1px solid black;">Balance</td>
                                            <td style="border: 1px solid black;">{{ $total_val > 1 ? $total_val.' days' : $total_val.' day' }}</td>
                                            <td style="border: 1px solid black;">{{ $total_sick > 1 ? $total_sick.' days' : $total_sick.' day' }}</td>
                                        </tr>
                                    </table>



                    <div class="row">
                        <div class="col-md-12 text-center">
                            {{--<br />--}}
                            {{--<u style="text-decoration: underline solid; color: #000; width: 100%;"><b>THERESA Q. TRAGICO</b></u>--}}
                            {{--<br />--}}
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
        </table>

    <hr>
    <div style="position:absolute; left: 30%;" class="align"><?php echo DNS1D::getBarcodeHTML($leave->route_no,"C39E",1,28) ?> <font class="route_no">{{$leave->route_no}}</font>
    </div>
</div>@endfor</body></html><script></script>