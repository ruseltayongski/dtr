<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flexbox Debugging</title>
    <style>
        .container {
            width: 100%;
            height: 100px;
        }
    </style>
</head><body>
<div class="container">
    <br>
    <div class="box" style="height: 42%; border: 1px solid black">
        <div style="text-align: center">
            <h2>CERTIFICATE OF COC EARNED</h2>
        </div>
        <br>
        <div style="display: inline-block; padding: 2px">
            <br>
            <table width="100%" style="font-weight: bold;">
                <tr>
                   <td style="width:45%; text-align: right">
                        This certificate entitles Mr./Ms.
                   </td>
                    <td style="width:45%; text-align: center; border-bottom: 2px solid black">
                        {{ $pis['fname'].' '.$pis['lname'] }}
                    </td>
                    <td style="width:10%; text-align: left">
                        to
                    </td>
                </tr>
            </table>
            <br>
            <table width="100%" style="font-weight: bold;">
                <tr>
                    <td style="width:45%; border-bottom: 2px solid black; text-align: center">
                        {{ $sum >40 ? '40 hrs' : $sum.' hrs' }}
                    </td>
                    <td style="width:45%; text-align: left;">
                        of Compensatory Overtime Credits.
                    </td>
                    <td style="width:10%;"></td>
                </tr>
            </table>
            <div style="margin-top: 100px; text-align: center">
                <span style="border-bottom: 1.5px solid black; font-weight: bold">
                    {{ $division_head['6'] == 6 ? 'RAMIL R. ABREA, CPA, MBA' : ($division_head['6'] == 5 ? 'ANNESSA P. PATINDOL, RMT, MD, MMHoA' :
                        ($division_head['6'] == 4 ? 'JONATHAN NEIL V. ERASMO, MD, MPH, FPSMS' : ($division_head['6'] == 3 ? 'SOPHIA M. MANCAO, MD, DPSP, RN-MAN' : '')))
                    }}
                </span><br>
                <span>
                    {{ $division_head['6'] == 6 ? 'Chief, Management Support Division' : ($division_head['6'] == 5 ? 'Chief, Regulation, Licensing and Enforcement Divsion' :
                        ($division_head['6'] == 4 ? 'Chief, Local Health Support Division' : ($division_head['6'] == 3 ? 'Director lll' : '')))
                    }}
                </span>
            </div>

        </div>
    </div>
       <br>
    <div class="green-box" style="text-align: right; font-size: 12px">
        DOHRO7-MSDPS-SOP-05-Form2 Rev 0
    </div>
    <br>
    <div class="green-box" style="height: 48%;">
        <table width="100%" style="border: 1px solid black; border-collapse: collapse; text-align: center; ">
            <tr style="font-weight: bold;">
                <td style="border: 1.5px solid black; align-items: center; width: 30%; padding:7px" colspan="5">No. Of Hours Earned/Beginning Balance</td>
                <td style="border: 1.5px solid black; width: 25%">Date of CTC</td>
                <td style="border: 1.5px solid black; width: 12.5%">Used COC's</td>
                <td style="border: 1.5px solid black; width: 20%">Remaining COC's</td>
                <td style="border: 1.5px solid black; width: 12.5%">Remarks</td>
            </tr>
            @foreach($card as $row)
                <tr style="">
                    <td style="width:11%">{{ $row['ot_hours'].' hrs' }}</td>
                    <td style="width:.2%">x</td>
                    <td style="width:1%">{{ $row['ot_rate'] }}</td>
                    <td style="width:.2%">=</td>
                    <td style="width:13%; text-align:right">{{ $row['ot_credits'].' hrs' }}&nbsp;&nbsp;&nbsp;</td>
                    <td style="border-left: 1.5px solid black; width: 31%; vertical-align: top; text-align: left; padding:1px">
                        {{ date('F j, Y', strtotime($row->ot_date)) }}
                    </td>
                    <td style="border-left: 1.5px solid black; width: 14%"></td>
                    <td style="border-left: 1.5px solid black; width: 15.6%"></td>
                    <td style="border-left: 1.5px solid black; width: 14%"></td>
                </tr>
            @endforeach
            <tr style="">
                <td style=""></td>
                <td style="text-align: center;" colspan="4">
                    <img src="{{realpath(__DIR__ . '/../../..').'/FPDF/image/line.png'}}" style="width: 180px; height: 1.5px">
                </td>
                <td style="border-left: 1.5px solid black; vertical-align: top; text-align: left;"></td>
                <td style="border-left: 1.5px solid black;">&nbsp;</td>
                <td style="border-left: 1.5px solid black;">&nbsp;</td>
                <td style="border-left: 1.5px solid black;">&nbsp;</td>
            </tr>
            <tr style="">
                <td style=""></td>
                <td style="text-align: right" colspan="4">{{ $sum.' hrs' }}&nbsp;&nbsp;&nbsp;</td>
                <td style="border-left: 1.5px solid black; vertical-align: top; text-align: left;"></td>
                <td style="border-left: 1.5px solid black;"></td>
                <td style="border-left: 1.5px solid black;"></td>
                <td style="border-left: 1.5px solid black;"></td>
            </tr>
            <tr style="">
                <td style=""></td>
                <td style="text-align: right" colspan="4"></td>
                <td style="border-left: 1.5px solid black; vertical-align: top; text-align: left;">&nbsp;</td>
                <td style="border-left: 1.5px solid black;"></td>
                <td style="border-left: 1.5px solid black;"></td>
                <td style="border-left: 1.5px solid black;"></td>
            </tr>
            @if($sum >40)
                <tr style="">
                    <td style="width:9%"></td>
                    <td style="width:.5%"></td>
                    <td style="width:1%"></td>
                    <td style="width:.5%">=></td>
                    <td style="width:9%; text-align:right">40 hrs&nbsp;&nbsp;&nbsp;</td>
                    <td style="border-left: 1.5px solid black; vertical-align: top; text-align: left;"> maximum credit per month</td>
                    <td style="border-left: 1.5px solid black;"></td>
                    <td style="border-left: 1.5px solid black;"></td>
                    <td style="border-left: 1.5px solid black;"></td>
                </tr>
            @endif
            @if(count($card) < 11)
                @for ($i = 1; $i < $total; $i++)
                    <tr style="">
                        <td style=""></td>
                        <td style="text-align: right" colspan="2"></td>
                        <td style="text-align: left" colspan="2"></td>
                        <td style="border-left: 1.5px solid black; vertical-align: top; text-align: left;"></td>
                        <td style="border-left: 1.5px solid black;">&nbsp;</td>
                        <td style="border-left: 1.5px solid black;">&nbsp;</td>
                        <td style="border-left: 1.5px solid black;">&nbsp;</td>
                    </tr>
                @endfor
            @endif

        </table>
        <div style="margin-top: 1px">
            <span style="text-align: left;">Certified Correct:</span>
            <br><br>
            <div style="text-align: center">
                <span style="border-bottom: 1.5px solid black">THERESA Q. TRAGICO</span><br>
                <span>Administrative Officer V</span><br>
                <span>Personnel Section</span>
            </div>
            <div class="green-box" style="text-align: right; font-size: 12px; margin-top: 5px">
                DOHRO7-MSDPS-SOP-05-Form2 Rev 0
            </div>
        </div>
    </div>
</div>
</body></html>
