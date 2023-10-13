

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('public/img/favicon.png') }}">
    <meta http-equiv="cache-control" content="max-age=0" />
    <title>HRIS</title>

    <link href="{{ asset('public/assets/css/bootstrap.pdf.css') }}" rel="stylesheet">

    <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/bootstrap.min.js') }}"></script>

</head>

<body  class="ng-cloak ">


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
                                                @if($leave->leave_type == "Vication")
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
                                    <strong class="col-md-4">Inclusive Dates : </strong>
                                    <strong class="col-md-5">
                                        {{ $leave->inc_from }} - {{ $leave->inc_to }}
                                    </strong>
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
                                                @if($leave->vication_loc == "local")
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
                                                @if($leave->vication_loc == "abroad")
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
                                <strong>(6a) CERTIFICATION OF LEAVE CREDITS <br />AS OF : <span style="text-decoration: underline;">{{ $leave->credit_date }}</span></strong>
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
                                                <td height="60"></td>
                                                <td height="60"></td>
                                                <td height="60"></td>
                                            </tr>
                                            <tr>
                                                <td class="col-md-1"><b>{{ (isset($leave->vication_total) ? $leave->vication_total : 0) }}</b> Days</td>
                                                <td class="col-md-1"><b>{{ (isset($leave->sick_total) ? $leave->sick_total : 0) }}</b> Days</td>
                                                <td class="col-md-1"><b>{{ (isset($leave->over_total) ? $leave->over_total : 0) }}</b> Days</td>
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
                                <u style="text-decoration: underline solid; color: #000; width: 100%;"><b>REBECCA Q. BULAWAN</b></u>
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
                                        @if(isset($leave->disaprove_due_to))
                                            <em>{{ $leave->disaprove_due_to }}</em>
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
                            @if(isset($leave->disaprove_due_to))
                                <em>{{ $leave->disaprove_due_to }}</em>
                            @endif
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <table border="2" style="width: 100%;" >
                <thead>
                </thead>
                <tbody>
                <tr>
                    <td class="col-md-12">
                        <div class="row" style="padding: 10px; text-align: center;">
                            <strong><em><b>By Authority of the Secretary of Health</b></em></strong>
                        </div>
                        <br /><br /><br /><br/>
                        <div class="row">
                            <div class="col-md-3">
                                <p class="text-center" style="border-top: solid 2px black; width: 100%;">Date</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-center" style="border-top: solid 2px black; width: 100%;">Authorized Official</p>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>

</style>

</body>
</html>
