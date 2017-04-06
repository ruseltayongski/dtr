<?php
ini_set('max_execution_time', 0);
ini_set('memory_limit','1000M');
ini_set('max_input_time','300000');

?>
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
    <link rel="icon" href="{{ asset('resources/img/favicon.png') }}">
    <!-- Bootstrap core CSS -->
    <title>
        JO Daily Attendance Report
    </title>
    <style>
    </style>
</head>
<body>
@for($i = 0; $i < count($lists); $i++)
    <div style="height: 700px;width: 750px;margin-left: -10px;padding: 0px;">
        <div style="height: 600px;width: 350px;float: left;">
            <span style="font-size: 10px;">Civil Service Form No. 43</span>
            <span style="font-size: 10px;margin-left: 115px;">Printed : {{ date('m/d/Y') }}</span>
            <p style="text-align: center;margin-top: -1.5px;">DAILY TIME RECORD</p>
            <p style="text-align: center;width: 100%;margin-top: -2px;border-bottom: thin dashed #333;"></p>
            <span style="font-size: 10px;">For the month of </span><b style="margin-left: 10px;">02-2017</b>
            <span style="font-size: 10px;margin-left: 115px;">ID NO. : {{ $lists[$i]['userid'] }}</span>
            <br />
            <br />
            <table border="0" style="width: 100%;">
                <thead>
                <tr>
                    <th style="font-size: 9px;">&nbsp;</th>
                    <th style="font-size: 9px;">AM</th>
                    <th style="font-size: 9px;">PM</th>
                    <th style="font-size: 9px;">UNDERTIME</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="font-size: 9px;text-align: center;">DAY</td>
                    <td style="font-size: 9px;">ARRIVAL | DEPARTURE</td>
                    <td style="font-size: 9px;">ARRIVAL | DEPARTURE</td>
                    <td style="font-size: 9px;text-align: center;">LATE | UT</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div style="height: 600px;width: 350px;float: right;">
            <span style="font-size:10px;">Civil Service Form No. 43</span>
            <span style="font-size: 10px;margin-left: 115px;">Printed : {{ date('m/d/Y') }}</span>
            <p style="text-align:center;margin-top: -1.5px;">DAILY TIME RECORD</p>
            <p style="text-align: center;width: 100%;margin-top: -2px;border-bottom: thin dashed #333;"></p>
            <span style="font-size: 10px;">For the month of </span><b style="margin-left: 10px;">02-2017</b>
            <span style="font-size: 10px;margin-left: 115px;">ID NO. : {{ $lists[$i]['userid'] }}</span>
            <br />
            <br />
            <table border="0" style="width: 100%;">
                <thead>
                <tr>
                    <th style="font-size: 9px;">&nbsp;</th>
                    <th style="font-size: 9px;">AM</th>
                    <th style="font-size: 9px;">PM</th>
                    <th style="font-size: 9px;">UNDERTIME</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="font-size: 9px;">DAY</td>
                    <td style="font-size: 9px;">ARRIVAL | DEPARTURE</td>
                    <td style="font-size: 9px;">ARRIVAL | DEPARTURE</td>
                    <td style="font-size: 9px;text-align: center;">LATE | UT</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endfor
</body>
</html>

