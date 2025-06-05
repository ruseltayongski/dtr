
<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CCTV Logs">
    <meta name="author" content="">
    <meta http-equiv="cache-control" content="max-age=0" />
    <link rel="icon" href="{{ asset('resources/img/favicon.png') }}">
    <title>CCTV Logs</title>
    <link href="{{ asset('resources/assets/css/bootstrap.pdf.css') }}" rel="stylesheet">
    <title>
        CCTV Logs
    </title>
    <style>
        body {
            margin-left: 10px;
            padding: 0;
            width: 100%;
            font-size: 15px;
        }
        .container-fluid {
            width: 100%;
            padding: 0;
            margin: 0;
        }
        table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            margin: 0;
        }
        th, td {
            border: 1px solid black;
            padding: 4px;
            word-wrap: break-word;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }
        /* Make the empty column narrower */
        td:last-child {
            width: 25%;
        }
        td:first-child, td:nth-child(2) {
            width: 75%;
        }
        /* Remove any margin that might cause overflow */
        .table-wrapper {
            width: 100%;
            overflow: visible;
            padding: 0;
            margin: 0;
        }
    </style>

</head><body>
<div class="container-fluid">
    <div class="table-wrapper">
        <div style="text-align: center;">{{ $date }}</div>
            @if(isset($groupedLogs))
                <?php $overall = 0; $i = 0;?>
                @foreach($groupedLogs as $name => $row)
                    <?php $total = 0; $j = 0; ?>
                    @foreach($row as $date => $item)
                        @if($j == 0)
                            <table style="width: 100%; margin-top: 7px; margin-bottom: 10px; border: 0px">
                                <tr>
                                    <td style="text-align: left; border: 0px; width: 80%; font-weight: bold">{{ $name . ' - '. $item[0]->userid }}</td>
                                    <td style="text-align: center; border: 0px; width: 20%; font-weight: bold">{{ $i == 0 ? 'Total' : '' }}</td>
                                </tr>
                            </table>
                        @endif
                        <table style="width: 100%; border: 0px;">
                            <tr>
                                <td style="border: 0px; width: 80%"><span style="margin-left: 10%">{{ date('F j, Y', strtotime($date)) }}</span></td>
                                <td style="text-align: center; border: 0px; width: 20%">{{ count($item) }}</td>
                            </tr>
                        </table>
                        @foreach($item as $data)
                            <div>
                                <span style="margin-left: 15%; line-height: .95">{{ date('h:i:s A', strtotime($data->time)) }}</span>
                            </div>
                            <?php $total = $total + 1; ?>
                            <?php $overall = $overall + 1; ?>
                        @endforeach
                        <?php $j++; ?>
                    @endforeach
                    <hr>
                    <table style="width: 100%; border: 0px;">
                        <tr>
                            <td style="border: 0px; width: 80%"></td>
                            <td style="text-align: center; border: 0px; width: 20%">{{ $total }}</td>
                        </tr>
                    </table>
                    <?php $i++; ?>
                @endforeach
                <br>
                <table style="width: 100%; border: 0px;">
                    <tr>
                        <td style="border: 0px; width: 80%; font-weight: bold">Grand Total : </td>
                        <td style="text-align: center; border: 0px; width: 20%; font-weight: bold">{{ $overall }}</td>
                    </tr>
                </table>
            @else
            @endif
        </div>
    </div>
</div>
</body></html>
