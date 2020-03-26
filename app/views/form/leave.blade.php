
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <table border="2" style="width: 100%;">
                <thead></thead>
                <tbody>
                <tr>
                    <th style="width: 100%;text-align: center; font-size: x-large;">APPLICATION FOR LEAVE</th>
                </tr>
                </tbody>
            </table>
            <table border="2" style="width: 100%;border-top: 0px;" >
                <tr>
                    <td>
                        <p style="padding: 10px;">
                            Office/Agency <br /><b>{{ $leave->office_agency }}</b>
                        </p>
                    </td>
                    <td>
                        <div class="row" style="padding: 10px;">
                            <span class="col-sm-3">(2.) Name</span>
                            <span class="col-sm-3">(Last)</span>
                            <span class="col-sm-3">(First)</span>
                            <span class="col-sm-3">(M.I.)</span>
                        </div>
                        <div class="row" style="padding: 10px;">
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
                    <td>
                        <p style="padding: 10px;">
                            (3.) Date of Filling<br /><b>{{ $leave->date_filling }}</b>
                        </p>
                    </td>
                    <td>
                        <p style="padding: 10px;">
                            (4.) Position<br /><b>{{ $leave->position }}</b>
                        </p>
                    </td>
                    <td>
                        <p style="padding: 10px;">
                            (5.) Salary (Monthly)<br /><b>{{ $leave->salary }}</b>
                        </p>
                    </td>
                </tr>
            </table>
            <table border="2" style="width: 100%;">
                <thead></thead>
                <tbody>
                <tr>
                    <th style="width: 100%;text-align: center; font-size: x-large;">DETAILS OF APPLICATION</th>
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
                                <strong>(6a) TYPE OF LEAVE</strong>
                                <div class="row">
                                    <br />
                                    <div class="col-md-12 col-md col-md-offset-1">
                                        <div class="row">
                                            <strong class="col-sm-1">
                                                @if($leave->leave_type == "Vacation")
                                                    <span style="text-decoration: underline;" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                @else
                                                    <span style="text-decoration: underline;width: 20%;" aria-hidden="true">&nbsp;</span>
                                                @endif
                                            </strong>
                                            <strong class="col-sm-6">
                                                VACATION
                                            </strong>
                                        </div>
                                        <div class="row">
                                            <strong class="col-sm-1">
                                                @if($leave->leave_type == "To_sake_employement")
                                                    <span style="text-decoration: underline;" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                @else
                                                    <span style="text-decoration: underline;width: 20%;" aria-hidden="true">&nbsp;</span>
                                                @endif
                                            </strong>
                                            <strong class="col-sm-6">
                                                TO SAKE EMPLOYEMENT
                                            </strong>
                                        </div>
                                        <div class="row">
                                            <strong class="col-sm-1">
                                                @if($leave->leave_type == "Others")
                                                    <span style="text-decoration: underline;" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                @else
                                                    <span style="text-decoration: underline;width: 20%;" aria-hidden="true">&nbsp;</span>
                                                @endif
                                            </strong>
                                            <strong class="col-sm-6">
                                                OTHERS (specify)
                                            </strong>
                                        </div>
                                        <div class="row">
                                            <strong class="col-sm-1"></strong>
                                        <span class="col-sm-6">
                                            @if(isset($leave->leave_type_others_1))
                                                <span class="tab2"><em>{{  $leave->leave_type_others_1 }}</em></span>
                                            @endif
                                        </span>
                                        </div>
                                        <div class="row">
                                            <strong class="col-sm-1">
                                                @if($leave->leave_type == "Sick")
                                                    <span style="text-decoration: underline;" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                @else
                                                    <span style="text-decoration: underline;width: 20%;" aria-hidden="true">&nbsp;</span>
                                                @endif
                                            </strong>
                                            <strong class="col-sm-6">
                                                SICK
                                            </strong>
                                        </div>
                                        <div class="row">
                                            <strong class="col-sm-1">
                                                @if($leave->leave_type == "Maternity")
                                                    <span style="text-decoration: underline;" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                @else
                                                    <span style="text-decoration: underline;width: 20%;" aria-hidden="true">&nbsp;</span>
                                                @endif
                                            </strong>
                                            <strong class="col-sm-6">
                                                MATERNITY
                                            </strong>
                                        </div>
                                        <div class="row">
                                            <strong class="col-sm-1">
                                                @if($leave->leave_type == "Others2")
                                                    <span style="text-decoration: underline;" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                @else
                                                    <span style="text-decoration: underline;width: 20%;" aria-hidden="true">&nbsp;</span>
                                                @endif
                                            </strong>
                                            <strong class="col-sm-6">
                                                OTHERS (specify)
                                            </strong>
                                        </div>
                                        <div class="row">
                                            <strong class="col-sm-1"></strong>
                                        <span class="col-sm-6">
                                            @if(isset($leave->leave_type_others_2))
                                                <span class="tab2"><em>{{  $leave->leave_type_others_2 }}</em></span>
                                            @endif
                                        </span>
                                        </div>
                                    </div>
                                </div>
                                <strong>(6c) NUMBER OF WORKING DAYS APPLIED FOR :
                                    @if(isset($leave->applied_num_days))
                                        <span style="text-decoration: underline;" class="tab2">{{ $leave->applied_num_days }}</span>
                                    @endif
                                </strong>
                                <br />
                                <br />
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong >Inclusive Dates : </strong>
                                        <strong style="margin-left: 1%">
                                            <i>{{ date('F d,Y',strtotime($leave->inc_from)).' to '.date('F d,Y',strtotime($leave->inc_to)) }}</i>
                                        </strong><br>
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
                            </div>
                        </div>
                    </td>
                    <td class="col-md-6">
                        <div class="row" style="padding: 10px;">
                            <div class="col-md-12">
                                <strong>(6b) WHERE LEAVE WILL BE SPENT</strong>
                                <div class="row">
                                    <br />
                                    <div class="col-md-12 col-md col-md-offset-1">
                                        <span>(1) In case of vaction leave</span>
                                        <div class="row">
                                            <strong class="col-sm-1">
                                                @if($leave->vacation_loc == "local")
                                                    <span style="text-decoration: underline;" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                @else
                                                    <span style="text-decoration: underline;width: 20%;" aria-hidden="true">&nbsp;</span>
                                                @endif
                                            </strong>
                                            <strong class="col-sm-6">
                                                Within the Philippines
                                            </strong>
                                        </div>
                                        <div class="row">
                                            <strong class="col-sm-1">
                                                @if($leave->vacation_loc == "abroad")
                                                    <span style="text-decoration: underline;" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                @else
                                                    <span style="text-decoration: underline;width: 20%;" aria-hidden="true">&nbsp;</span>
                                                @endif
                                            </strong>
                                            <strong class="col-sm-6">
                                                Abroad (specify)
                                            </strong>
                                        </div>
                                        <div class="row">
                                            <strong class="col-sm-1"></strong>
                                        <span class="col-sm-6">
                                            @if(isset($leave->abroad_others))
                                                <span class="tab2"><em>{{  $leave->abroad_others }}</em></span>
                                            @endif
                                        </span>
                                        </div>
                                        <span>(2) In case of sick leave</span>
                                        <div class="row">
                                            <strong class="col-sm-1">
                                                @if($leave->sick_loc == "in_hostpital")
                                                    <span style="text-decoration: underline;" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                @else
                                                    <span style="text-decoration: underline;width: 20%;" aria-hidden="true">&nbsp;</span>
                                                @endif
                                            </strong>
                                            <strong class="col-sm-6">
                                                In Hospital (specify)
                                            </strong>
                                        </div>
                                        <div class="row">
                                            <strong class="col-sm-1"></strong>
                                        <span class="col-sm-6  col-md-offset-1">
                                            <em>
                                                @if(isset($leave->in_hospital_specify))
                                                    {{ $leave->in_hospital_specify }}
                                                @else
                                                    <strong><hr /></strong>
                                                @endif
                                            </em>

                                        </span>
                                        </div>
                                        <div class="row">
                                            <strong class="col-sm-1">
                                                @if($leave->sick_loc == "out_patient")
                                                    <span style="text-decoration: underline;" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                @else
                                                    <span style="text-decoration: underline;width: 20%;" aria-hidden="true">&nbsp;</span>
                                                @endif
                                            </strong>
                                            <strong class="col-sm-6">
                                                Out-patient (specify)
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <strong class="col-sm-1"></strong>
                                    <span class="col-sm-6  col-md-offset-1">
                                        <em>
                                            @if(isset($leave->out_patient_specify))
                                                {{ $leave->out_patient_specify }}
                                            @else
                                                <strong><hr /></strong>
                                            @endif
                                        </em>
                                    </span>
                                    </div>
                                </div>
                                <br />
                                <strong>(6d) COMMUTATION</strong>
                                <br />
                                <div class="row">
                                    <strong class="col-sm-12 col-md-offset-1">
                                        @if($leave->com_requested == "yes")
                                            <strong class="col-sm-1">
                                                <span style="text-decoration: underline;" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                            </strong>
                                            <strong class="col-sm-6">
                                                Requested
                                            </strong>
                                        @else
                                            <strong class="col-sm-1">
                                                <span style="text-decoration: underline;" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                            </strong>
                                            <strong class="col-sm-6">
                                                Not Requested
                                            </strong>
                                        @endif
                                    </strong>
                                </div>
                                <div class="row">
                                    <div class="has-success text-center">
                                        <br />
                                        <br />
                                        <p style="border-top: solid 2px black; width: 100%;">Signature</p>
                                    </div>
                                </div>
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
                    <th style="width: 100%;text-align: center; font-size: x-large;">DETAILS OF ACTION ON APPLICATION</th>
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
                                <strong>(7a) CERTIFICATION OF LEAVE CREDITS <br />AS OF : <span style="text-decoration: underline;"></span></strong>
                                <div class="row">
                                    <div class="col-md-12">
                                        <br />
                                        <table border="2" style="width: 100%; text-align: center;">
                                            <thead>
                                            <tr>
                                                <th style="text-align: center;">Vacation</th>
                                                <th style="text-align: center;">Sick</th>
                                                <th style="text-align: center;">Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td height="60">
                                                    <h2 class="text-green">
                                                        {{ $leave->vacation_balance }}
                                                    </h2>
                                                </td>
                                                <td height="60">
                                                    <h2 class="text-green">
                                                        {{ $leave->sick_balance }}
                                                    </h2>
                                                </td>
                                                <td height="60"><h2 class="text-green">{{ $leave->vacation_balance + $leave->sick_balance }}</h2></td>
                                            </tr>
                                            <tr>
                                                <?php
                                                    $vacation_balance_day = $leave->vacation_balance / 8;
                                                    $sick_balance_day = $leave->sick_balance / 8;
                                                    $total_balance_day = $vacation_balance_day + $sick_balance_day;
                                                ?>
                                                <td class="col-md-1"><b>{{ $vacation_balance_day > 1 ? $vacation_balance_day.' days' : $vacation_balance_day.' day' }}</b></td>
                                                <td class="col-md-1"><b>{{ $sick_balance_day > 1 ? $sick_balance_day.' days' : $sick_balance_day.' day' }}</b></td>
                                                <td class="col-md-1"><b>{{ $total_balance_day > 1 ? $total_balance_day.' days' : $total_balance_day.' day' }}</b></td>
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
                    <td class="col-md-6">
                        <div class="row" style="padding:10px;">
                            <div class="col-md-12">
                                <strong>RECOMMENDATION</strong>
                                <div class="row">
                                    <strong class="col-sm-1">
                                        @if($leave->reco_approval == "approve")
                                            <span style="text-decoration: underline;" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                        @else
                                            <span style="text-decoration: underline;width: 20%;" aria-hidden="true">&nbsp;</span>
                                        @endif
                                    </strong>
                                    <strong class="col-sm-6">
                                        Approval
                                    </strong>
                                </div>
                                <div class="row">
                                    <strong class="col-sm-1">
                                        @if($leave->reco_approval == "disapprove")
                                            <span style="text-decoration: underline;" class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                        @else
                                            <span style="text-decoration: underline;width: 20%;" aria-hidden="true">&nbsp;</span>
                                        @endif
                                    </strong>
                                    <strong class="col-sm-6">
                                        Disapproval
                                    </strong>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-md-offset-1">
                                        <strong>Due to :</strong>
                                        <br />
                                        @if(isset($leave->disapproved_due_to))
                                            <em>{{ $leave->disapproved_due_to }}</em>
                                        @endif
                                    </div>
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
                            <strong>APPROVE FOR :</strong>
                            <br />
                            <div class="col-md-12">
                                <div class="row">
                                    <table style="width: 60%;">
                                        <thead><tr><th></th><th></th></tr></thead>
                                        <tbody>
                                        <tr>
                                            <td><strong style="text-decoration: underline;">{{ (isset($leave->a_days_w_pay) ? $leave->a_days_w_pay : 0) }}</strong></td>
                                            <td><strong>day(s) with pay</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong style="text-decoration: underline;">{{ (isset($leave->a_days_wo_pay) ? $leave->a_days_wo_pay : 0) }}</strong></td>
                                            <td><strong>day(s) without pay</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong style="text-decoration: underline;">{{ (isset($leave->a_others) ? $leave->a_others : 0) }}</strong></td>
                                            <td><strong>others (specify)</strong></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="col-md-6">
                        <div class="row" style="padding: 10px;">
                            <strong>DISAPPROVED DUE TO :</strong>
                            <br />
                            <br />
                            @if(isset($leave->disapproved_due_to))
                                <em>{{ $leave->disapproved_due_to }}</em>
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
                @if(!Auth::user()->usertype && $leave->status != 'APPROVED')
                <a href="{{ asset('leave/update/' . $leave->id) }}"  class="btn btn-primary btn-submit" style="color:white;"><i class="fa fa-pencil"></i> Update</a>
                <a href="{{ asset('leave/delete/' .$leave->id) }}" style="color:white" class="btn btn-danger" ><i class="fa fa-trash"></i> Remove</a>
                @endif
            </div>
        </div>
    </div>
</div>
<style>

</style>
