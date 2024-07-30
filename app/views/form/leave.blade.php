
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
                                CENTRAL VISAYAS CENTER for HEALTH DEVELOPMENTblade<br></strong>
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
            <table border="" style="width: 100%;" >
                <thead></thead>
                <tbody>
                <tr>
                    <td style="width: 52%; vertical-align: top">
                        <strong style="margin-left: 1px">6.A TYPE OF LEAVE TO BE AVAILED OF</strong>
                        <br><br>
                        @if(isset($leaveTypes))
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
                            @foreach($leaveTypes as $index => $row)
                                <div class="row" style="margin-bottom: 5px">
                                    @if($leave->leave_type == $row->code)
                                        <span style="text-decoration: underline; margin-left: 25px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                        @if($leave->leave_type == "OTHERS")
                                            <u style="margin-left: 5px">{{$leave->for_others}}</u>
                                        @else
                                            <span style="margin-left: 10px;"> {{ $row->desc }}<small style="font-size: 10.8px">{{($index == 13)?'':$details[$index]}}</small> </span>
                                        @endif
                                    @else
                                        <span style="margin-left: 50px;"> {{ $row->desc }} <small style="font-size: 10.8px">{{($index == 13)?'':$details[$index]}}</small></span>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </td>
                    <td class="col-md-5" style="vertical-align: top">
                        <strong>6.B DETAILS OF LEAVE<br></strong>
                        <div class="row">
                            <div class="col-md-12 col-md col-md-offset-1">
                                <div class="row">
                                    <br><span><i>In case of Vacation/Special Privilege Leave</i></span>
                                    @if ($leave->leave_details == '1')
                                        <br><span style="text-decoration: underline; margin-left: 10px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                        <span class="{{ $leave->leave_details == '1' ? 'text-decoration-underline' : '' }}"  style="margin-left: 10px">Within the Philippines</span>
                                        <u style="margin-left: 10px">{{($leave->leave_specify != 'None')?$leave->leave_specify:''}}</u>
                                        <br><span style="margin-left: 36px">Abroad (Specify)</span><br>
                                    @elseif ($leave->leave_details == '2')
                                        <br><span style="margin-left: 36px">Within the Philippines</span><br>
                                        <span style="text-decoration: underline; margin-left: 10px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                        <span class="{{ $leave->leave_details == '2' ? 'text-decoration-underline' : '' }}" style="margin-left: 10px">Abroad (Specify)</span>
                                        <u style="margin-left: 10px">{{($leave->leave_specify != 'None')?$leave->leave_specify:''}}</u>
                                    @else
                                        <br><span style="margin-left: 36px">Within the Philippines</span>
                                        <br><span style="margin-left: 36px">Abroad (Specify)</span>
                                    @endif

                                </div>
                                <div class="row">
                                    <span><i>In case of Sick Leave</i></span>
                                    @if ($leave->leave_details == '3')
                                        <br><span style="text-decoration: underline; margin-left: 10px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                        <span class="{{ $leave->leave_details == '3' ? 'text-decoration-underline' : '' }}"  style="margin-left: 10px">In Hospital (Specify Illness)</span>
                                        <u style="margin-left: 10px">{{($leave->leave_specify != 'None')?$leave->leave_specify:''}}</u>
                                        <br><span style="margin-left: 36px">Out Patient (Specify Illness)</span><br>
                                    @elseif ($leave->leave_details == '4')
                                        <br><span style="margin-left: 36px">In Hospital (Specify Illness)</span><br>
                                        <span style="text-decoration: underline; margin-left: 10px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                        <span class="{{ $leave->leave_details == '4' ? 'text-decoration-underline' : '' }}" style="margin-left: 10px">Out Patient (Specify Illness)</span>
                                        <u style="margin-left: 10px">{{($leave->leave_specify != 'None')?$leave->leave_specify:''}}</u>
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
                                        <u style="margin-left: 10px">{{($leave->leave_specify != 'None')?$leave->leave_specify:''}}</u>
                                    @else
                                        <span style="margin-left: 36px">(Specify Illness)</span>
                                    @endif
                                </div>
                                <div class="row">
                                    <span><i>In case of Study Leave</i></span>
                                    @if ($leave->leave_details == '6')
                                        <br><span style="text-decoration: underline; margin-left: 10px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                        <span class="{{ $leave->leave_details == '6' ? 'text-decoration-underline' : '' }}"  style="margin-left: 10px">Comppletion of Master's Degree</span>
                                        <u style="margin-left: 10px">{{($leave->leave_specify != 'None')?$leave->leave_specify:''}}</u>
                                        <br><span style="margin-left: 36px">BAR/Board Examination Review</span>
                                    @elseif ($leave->leave_details == '7')
                                        <br><span style="margin-left: 36px">Completion of Master's Degree</span>
                                        <span style="text-decoration: underline; margin-left: 10px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                        <span class="{{ $leave->leave_details == '7' ? 'text-decoration-underline' : '' }}" style="margin-left: 10px">BAR/Board Examination Review</span>
                                        <u style="margin-left: 10px">{{($leave->leave_specify != 'None')?$leave->leave_specify:''}}</u>
                                    @else
                                        <br><span style="margin-left: 36px">Completion of Master's Degree</span>
                                        <br><span style="margin-left: 36px">BAR/Board Examination Review</span>
                                    @endif
                                </div>
                                <div class="row">
                                    <span><i>Other Purpose</i></span>
                                    @if ($leave->leave_details == '6')
                                        <br><span style="text-decoration: underline; margin-left: 10px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
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

                    </td>
                </tr>
                </tbody>
            </table>
            <table border="2" style="width: 100%;border-top: 0px;" >
                <tr>
                    <td id="data_here" style="width: 55.6%">
                        <strong>&nbsp;&nbsp;&nbsp;&nbsp;6.C NUMBER OF WORKING DAYS APPLIED FOR :</strong><br>
                        <input value="{{(int)$leave->applied_num_days}}" type="text" class="form-control" name="applied_num_days" id="applied_num_days" style="text-align:center; margin-left: 8.5%; width: 50%;margin-top: 2%" readonly/>
                        <input type="hidden" class="form-control" name="credit_used" id="credit_used"/>
                        <strong class="sm-m-3" style="display: inline-block; margin-left: 8.5%; margin-top: 2%; margin-bottom: 10px">INCLUSIVE DATES :</strong><br>
                        @foreach($leave_dates as $dates)
                            <strong style="margin-left: 1%">
                            @if(  date('F d,Y',strtotime($dates->startdate)) == date('F d,Y',strtotime($dates->enddate)))
                            <input style="margin-left: 8.5%; text-align: center; border: none; border-bottom: 1px solid black; width: 49%;" value="{{ date('F d,Y',strtotime($dates->startdate))}}" readonly>
                            @else
                            <input style="margin-left: 8.5% ; text-align: center; border: none; border-bottom: 1px solid black; width: 49%;" value="{{ date('F d,Y',strtotime($dates->startdate)).' to '.date('F d,Y',strtotime($dates->enddate)) }}" readonly>
                            @endif
                            &nbsp;&nbsp;
                            </strong><br>
                        @endforeach
                    </td>
                    <td style="vertical-align: top;">
                        <strong>6.D COMMUTATION</strong>
                        <br>
                        <div class="row">

                            @if($leave->commutation == 2)
                                <span style="margin-left: 45px">Requested</span><br>
                                <span style="text-decoration: underline; margin-left: 30px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                <span>Not Requested</span>
                            @else
                                <span style="text-decoration: underline; margin-left: 30px" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                <span>Requested</span><br>
                                <span style="margin-left: 45px">Not Requested</span>
                            @endif
                        </div><br><br>
                        <img src="{{ asset('FPDF/image/line.png') }}" width="30%" style="position: absolute; left: 62%; top: 58.6%; height: .1px; margin-top: 6%;" >
                        <br>
                        <span style="margin-left: 32%">(Signature of Applicant)</span>
                    </td>
                </tr>
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
                <tr>
                    <td style="vertical-align: top; width: 55.5%">
                        <strong style="margin-left: 2%">7.A CERTIFICATION OF LEAVE CREDITS</strong><br>
                        <p style="margin-left: 20%">As of <input name="as_of" style="border:none;border-bottom: 2px solid black; width:30%; text-align: center" value="<?php echo date('F j, Y') ?>"></p>
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
                                        <td>{{$leave->vacation_balance}}</td>
                                        <td>{{$leave->sick_balance}}</td>
                                    </tr>
                                    <tr height ="30" style="">
                                        <td>Less this application</td>
                                        <td>
                                            <input id="vl_less" name="vl_less" style="width: 30%; text-align: center; border:none"
                                                   value="{{ (strpos((string)$leave->vl_deduct, '.') === false || (int)explode('.', (string)$leave->vl_deduct)[1] === 0) ?  (int)$leave->vl_deduct : $leave->vl_deduct }}" readonly>
                                        </td>
                                        <td>
                                            <input id="sl_less" name="sl_less" style="width: 30%; text-align: center; border:none"
                                                   value="{{ (strpos((string)$leave->sl_deduct, '.') === false || (int)explode('.', (string)$leave->sl_deduct)[1] === 0) ?  (int)$leave->sl_deduct : $leave->sl_deduct }}" readonly>
                                        </td>
                                    </tr>
                                    <tr height = "30">
                                        <td class="col-md-2">Balance</td>
                                        <td class="col-md-2"><input id="vl_rem" name="vl_rem" style="width: 40%; text-align: center; border: none" value="{{$leave->vacation_balance - $leave->vl_deduct}}" readonly></td>
                                        <td class="col-md-2"><input id="sl_rem" name="sl_rem" style="width: 40%; text-align: center; border: none" value="{{$leave->sick_balance - $leave->sl_deduct}}" readonly></td>
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
                                            <option value="{{ $section_head['id'] }}" {{($leave->officer_1 == $section_head['id'])? 'selected' : ''}}>{{ $section_head['fname'].' '.$section_head['mname'].' '.$section_head['lname'] }}</option>
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
                        <div style="margin-left: 2%; text-align: center; margin-top: 8.5%">
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
                        <span style="margin-left: 10%"><input value ="{{($leave->with_pay != 0)?$leave->with_pay : ''}}" style="width: 22%; border: none; border-bottom: 2px solid black; height: 2%; margin-bottom: 0px" id="with_pay" name="with_pay" readonly> days with pay</span><br>
                        <span style="margin-left: 10%"><input value ="{{($leave->without_pay != 0)?$leave->without_pay : ''}}" style="width: 22%; border: none; border-bottom: 2px solid black; height: 2%" id="without_pay" name="without_pay" readonly> days without pay</span><br>
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
                            <select class="chosen-select-static form-control" name="approved_officer" required style="width: 30%;margin-right: 60%">
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
                    @if(Auth::user()->usertype !=1 && $leave->status == 0 )
                        <a href="{{ asset('leave/update/' . $leave->id) }}"  class="btn btn-primary btn-submit" style="color:white;"><i class="fa fa-pencil"></i> Update</a>
                        <a href="{{ asset('leave/delete/' .$leave->id) }}" style="color:white" class="btn btn-danger" ><i class="fa fa-trash"></i> Remove</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<style>

</style>
<script>
    $('.chosen-select-static').chosen();
</script>
