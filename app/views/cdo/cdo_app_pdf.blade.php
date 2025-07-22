<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APPROVED CDO LOGS</title>
    <style>
        .container {
            width: 100%;
            height: 100px;
        }
    </style>
</head><body>
<div class="container">
    <div style="display: inline-block; padding: 2px">
        <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px;">
            <tr style="background-color: #f0f0f0;">
                <th style="text-align: left; padding: 8px;">#</th>
                <th style="text-align: left; padding: 8px;">Name</th>
                <th style="text-align: left; padding: 8px;">Date</th>
                <th style="text-align: left; padding: 8px;">Date Applied</th>
            </tr>
            @foreach($cdo as $index => $row)
                <input type="hidden" name="route_no[]" value="{{ $row->route_no }}">
                <tr style="text-align:left; background-color: {{ $index % 2 == 0 ? '#ffffff' : '#f9f9f9' }};">
                    <td style="padding: 8px; width: 10%;">{{ $index + 1 }}</td>
                    <td style="padding: 8px; width: 30%;">{{ $row->name->fname . ' ' . $row->name->lname }}</td>
                    <td style="padding: 8px; width: 30%;">{{ date('F j, Y', strtotime($dates[$index])) }}</td>
                    <td style="padding: 8px; width: 30%;">
                        @foreach($row->appliedDates as $date)
                            <?php
                            $hours = $date->cdo_hours === 'cdo_am' ? ' (AM)' : ($date->cdo_hours === 'cdo_pm' ? ' (PM)' : '');
                            $start_date = date('M j, Y', strtotime($date->start_date));
                            $end_date = date('M j, Y', strtotime('-1 day', strtotime($date->end_date)));
                            $dateStrings = ($start_date === $end_date) ? "$start_date$hours" : "$start_date - $end_date$hours";
                            echo $dateStrings;
                            ?>
                            <br>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
</body></html>
