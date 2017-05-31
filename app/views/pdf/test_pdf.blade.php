
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="cache-control" content="max-age=0" />
    <link rel="icon" href="{{ asset('public/img/favicon.png') }}">
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('resources/assets/css/bootstrap.pdf.css') }}" rel="stylesheet">
    <title>
        Application fo Leave
    </title>
    <style>
        body {
           font-family: "DejaVu Sans", sans-serif;
            font-size: x-small;
        }
        table {
            border : thin;
        }
    </style>
</head>

<body>

<table border="1" style="width: 100%;" class="container">
    <thead></thead>
    <tbody>
    <tr>
        <th style="width: 100%;text-align: center; font-size:medium;">APPLICATION FOR LEAVE</th>
    </tr>
    </tbody>
</table>
<table border="1" style="width: 100%;border-top: 0px;" >
    <tr>
        <td>
            <p style="padding: 8px;">
                Office/Agency <br /><b>{{ $leave->office_agency }}</b>
            </p>
        </td>
        <td>
            <div style="padding: 8px;">
                <span class="col-sm-3">(2.) Name</span>
                <span class="col-sm-3 tab1">(Last)</span>
                <span class="col-sm-3">(First)</span>
                <span class="col-sm-3">(M.I.)</span>
            </div>
            <div style="padding: 8px;">
                <span class="col-sm-3">&nbsp;</span>
                <span class="col-sm-3 tab1"><b>{{ $leave->lastname }}</b></span>
                <span class="col-sm-3"><b>{{ $leave->firstname }}</b></span>
                <span class="col-sm-3"><b>{{ $leave->middlename }}</b></span>
            </div>
        </td>
    </tr>
</table>
<table border="1" style="width: 100%;border-top: 0px;">
    <tr>
        <td>

                (3.) Date of Filling<br /><b>{{ $leave->date_filling }}</b>

        </td>
        <td>

                (4.) Position<br /><b>{{ $leave->position }}</b>

        </td>
        <td>

                (5.) Salary (Monthly)<br /><b>{{ sprintf("%.2f",$leave->salary); }}</b>

        </td>
    </tr>
</table>
<table border="1" style="width: 100%;">
    <thead></thead>
    <tbody>
    <tr>
        <th style="width: 100%;text-align: center; font-size: medium;">DETAILS OF APPLICATION</th>
    </tr>
    </tbody>
</table>
<table border="1" style="width: 100%;" >
    <thead></thead>
    <tbody>
    <tr>
        <td style="width: 50%;">
            <div style="padding:10px;width: 100%;">
                <strong>(6a) TYPE OF LEAVE</strong>
                <br /><br />
                <table border="0" style="width: 100%;">
                    <thead>
                    <tr><th></th><th></th></tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="width: 20%;">
                            @if($leave->leave_type == "Vication")
                                <strong><span style="font-family: DejaVu Sans;">&#10004; </span></strong>
                            @else
                                <span style="text-decoration: underline;width: 10px;" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            @endif
                        </td>
                        <td><strong>VACATION</strong></td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">
                            @if($leave->leave_type == "To_sake_employement")
                                <strong><span style="font-family: DejaVu Sans;">&#10004; </span></strong>
                            @else
                                <span style="text-decoration: underline;width: 10px;" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            @endif
                        </td>
                        <td><strong>TO SAKE EMPLOYEMENT</strong></td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">
                            @if($leave->leave_type == "Others")
                                <strong><span style="font-family: DejaVu Sans;">&#10004; </span></strong>
                            @else
                                <span style="text-decoration: underline;width: 10px;" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            @endif
                        </td>
                        <td><strong>OTHERS (specify)</strong></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            @if(isset($leave->leave_type_others_1))
                                <span class="tab2"><em>{{  $leave->leave_type_others_1 }}</em></span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">
                            @if($leave->leave_type == "Sick")
                                <strong><span style="font-family: DejaVu Sans;">&#10004; </span></strong>
                            @else
                                <span style="text-decoration: underline;width: 10px;" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            @endif
                        </td>
                        <td><strong>SICK</strong></td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">
                            @if($leave->leave_type == "Maternity")
                                <strong><span style="font-family: DejaVu Sans;">&#10004; </span></strong>
                            @else
                                <span style="text-decoration: underline;width: 10px;" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            @endif
                        </td>
                        <td><strong>MATERNITY</strong></td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">
                            @if($leave->leave_type == "Others2")
                                <strong><span style="font-family: DejaVu Sans;">&#10004; </span></strong>
                            @else
                                <span style="text-decoration: underline;width: 10px;" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            @endif
                        </td>
                        <td><strong>OTHERS (specify)</strong></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            @if(isset($leave->leave_type_others_2))
                                <span class="tab2"><em>{{  $leave->leave_type_others_2 }}</em></span>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
                <strong>(6c) NUMBER OF WORKING DAYS APPLIED <br /> FOR :
                    @if(isset($leave->applied_num_days))
                        <span style="text-decoration: underline;" class="tab2">{{ $leave->applied_num_days }}</span>
                    @endif
                </strong>
                <div style="padding:10px;width: 100%;">
                    <strong class="col-md-4">Inclusive Dates : </strong>
                    <strong class="col-md-5">
                        {{ $leave->inc_from }} - {{ $leave->inc_to }}
                    </strong>
                </div>
            </div>
        </td>
        <td style="width: 50%;">
            <div style="padding:10px;width: 100%;">
                <strong>(6a) TYPE OF LEAVE</strong>
                <br />
                <span>(1) In case of vacation leave</span>
                <table border="0" style="width: 100%;">
                    <thead>
                    <tr><th></th><th></th></tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="width: 20%;">
                            @if($leave->vication_loc == "local")
                                <strong><span style="font-family: DejaVu Sans;">&#10004; </span></strong>
                            @else
                                <span style="text-decoration: underline;width: 10px;" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            @endif
                        </td>
                        <td><strong> Within the Philippines</strong></td>
                    </tr>
                    <tr>
                        <td>
                            @if($leave->vication_loc == "abroad")
                                <strong><span style="font-family: DejaVu Sans;">&#10004; </span></strong>
                            @else
                                <span style="text-decoration: underline;width: 10px;" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            @endif
                        </td>
                        <td>
                            <strong class="col-sm-6">
                                Abroad (specify)
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            @if(isset($leave->abroad_others))
                                <span class="tab2"><em>{{  $leave->abroad_others }}</em></span>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
                <br />
                <span>(1) In case of sick leave</span>
                <table border="0" style="width: 100%;">
                    <thead>
                    <tr><th></th><th></th></tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="width: 20%;">
                            @if($leave->sick_loc == "in_hostpital")
                                <strong><span style="font-family: DejaVu Sans;">&#10004; </span></strong>
                            @else
                                <span style="text-decoration: underline;width: 10px;" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            @endif
                        </td>
                        <td><strong> In Hospital</strong></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <em>
                                @if(isset($leave->in_hospital_specify))
                                    {{ $leave->in_hospital_specify }}
                                @else
                                    <strong><hr /></strong>
                                @endif
                            </em>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            @if($leave->sick_loc == "out_patient")
                                <strong><span style="font-family: DejaVu Sans;">&#10004; </span></strong>
                            @else
                                <span style="text-decoration: underline;width: 10px;" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            @endif
                        </td>
                        <td>
                            <strong class="col-sm-6">Out-patient (specify)</strong>
                        </td>
                    </tr>
                    <tr>
                        <em>
                            @if(isset($leave->out_patient_specify))
                                {{ $leave->out_patient_specify }}
                            @else
                                <strong><hr /></strong>
                            @endif
                        </em>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div style="padding:10px;width: 100%;">
                <strong>(6d) COMMUTATION</strong>
                <br />
                <table border="0" style="width: 100%;">
                    <thead><th></th></thead>
                    <tbody>
                    <tr>
                        <td>
                            @if($leave->com_requested == "yes")
                                <strong class="col-sm-1">
                                    <strong><span style="font-family: DejaVu Sans;">&#10004; </span></strong>
                                </strong>
                                <strong class="col-sm-6">
                                    Requested
                                </strong>
                            @else
                                <strong class="col-sm-1">
                                    <strong><span style="font-family: DejaVu Sans;">&#10004; </span></strong>
                                </strong>
                                <strong class="col-sm-6">
                                    Not Requested
                                </strong>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div style="padding:10px;width: 100%;">
                <br />
                <p style="border-top: solid 2px black; width: 100%;text-align: center;">Signature</p>
            </div>
        </td>
    </tr>
    </tbody>
</table>
<table border="1" style="width: 100%;">
    <thead></thead>
    <tbody>
    <tr>
        <th style="width: 100%;text-align: center; font-size:medium;">DETAILS OF ACTION ON APPLICATION</th>
    </tr>
    </tbody>
</table>
<table border="1" style="width: 100%;" >
    <thead></thead>
    <tbody>
    <tr>
        <td style="width: 50%;">
            <div class="row" style="padding:10px;">
                <div class="col-md-12">
                    <strong>(6a) CERTIFICATION OF LEAVE CREDITS <br />AS OF : <span style="text-decoration: underline;">{{ $leave->credit_date }}</span></strong>
                    <div class="row">
                        <div class="col-md-12">
                            <br />
                            <table border="1" style="width: 100%; text-align: center;">
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
        <td style="width: 50%;">
            <div style="padding: 8px;width:100%;">
                <strong>(7b) RECOMMENDATION</strong>
                <br />
                <table style="width:100%;">
                    <thead></thead>
                    <tbody>
                    <tr>
                        <td>
                            @if($leave->reco_approval == "approve")
                                <strong><span style="font-family: DejaVu Sans;">&#10004; </span></strong>
                            @else
                                <span style="text-decoration: underline;width: 20%;" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            @endif
                        </td>
                        <td> <strong>Approval</strong></td>
                    </tr>
                    <tr>
                        <td>
                            @if($leave->reco_approval == "disapprove")
                                <strong><span style="font-family: DejaVu Sans;">&#10004; </span></strong>
                            @else
                                <span style="text-decoration: underline;width: 20%;" aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            @endif
                        </td>
                        <td><strong class="col-sm-6">Disapproval</strong></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Due to:</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <span class="tab2">
                                @if(isset($leave->disaprove_due_to))
                                    <em>{{ $leave->disaprove_due_to }}</em>
                                @endif
                            </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </td>
    </tr>
    </tbody>
</table>
<table border="1" style="width: 100%;">
    <thead></thead>
    <tbody>
    <tr>
        <td style="width: 50%;">
            <div style="padding: 8px;width:100%;">
                <strong>(7c) APPROVE FOR :</strong>
                <br />
                <br />
                <table style="width: 60%;">
                    <tr>
                        <td><strong style="text-decoration: underline;">{{ (isset($leave->a_days_w_pay) ? $leave->a_days_w_pay : 0) }}</strong></td>
                        <td>day(s) with pay</td>
                    </tr>
                    <tr>
                        <td><strong style="text-decoration: underline;">{{ (isset($leave->a_days_wo_pay) ? $leave->a_days_wo_pay : 0) }}</strong></td>
                        <td>day(s) without pay</td>
                    </tr>
                    <tr>
                        <td><strong style="text-decoration: underline;">{{ (isset($leave->a_others) ? $leave->a_others : 0) }}</strong></td>
                        <td>others(specify)</td>
                    </tr>
                </table>
            </div>
        </td>
        <td style="width: 50%;">
            <div style="padding: 8px; width: 100%;">
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
<table border="1" style="width: 100%;" >
    <tr>
        <td>
            <div class="row" style="padding: 8px; text-align: center;">
                <strong><em><b>By Authority of the Secretary of Health</b></em></strong>
            </div>
            <table style="width: 100%;">
                <thead></thead>
                <tbody>
                <tr>
                    <td style="padding: 8px;">
                        <br /><br />
                        <p class="text-center" style="border-top: solid 2px black; width: 50%;">Date</p>
                    </td>
                    <td style="padding: 8px;">
                        <br /><br />
                        <p class="text-center" style="border-top: solid 2px black; width: 70%;">Authorized Official</p>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
</table>


<script src="{{ asset('resources/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('resources/assets/js/bootstrap.min.js') }}"></script>
</body>
</html>
