<table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px;">
    <thead>
    <tr style="background-color: #f0f0f0;">
        <th style="text-align: left; padding: 8px;">#</th>
        <th style="text-align: left; padding: 8px;"></th>
        <th style="text-align: left; padding: 8px;">Name</th>
        <th style="text-align: left; padding: 8px;">Date Applied</th>
    </tr>
    </thead>
    <tbody>
    @foreach($cdo as $index => $row)
        <input type="hidden" name="route_no[]" value="{{ $row->route_no }}">
        <tr style="text-align:left; background-color: {{ $index % 2 == 0 ? '#ffffff' : '#f9f9f9' }};">
            <td style="padding: 8px; width: 10%;">{{ $index + 1 }}</td>
            <td style="padding: 8px; width: 20%;">
                <input
                    class="form-control accepted_date"
                    id="accepted_date_{{ $index }}"
                    name="accepted_date[]"
                    required
                    style="width: 100%; padding: 6px;"
                >
            </td>
            <td style="padding: 8px; width: 40%;">{{ ucwords(strtolower($row->name->fname . ' ' . $row->name->mname .' '.$row->name->lname)) }}</td>
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
    </tbody>
</table>
<script>
    $(document).ready(function() {
        var manuallyEdited = [];

        $('.accepted_date').each(function(index) {
            $(this).datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

            $(this).on('change', function() {
                manuallyEdited[index] = true;
            });
        });

        $('#accepted_date_0').on('change', function() {
            var selectedDate = $(this).val();

            $('.accepted_date').each(function(index) {
                if (index !== 0 && !manuallyEdited[index]) {
                    $(this).val(selectedDate).datepicker('update', selectedDate);
                }
            });
        });
    });

</script>
