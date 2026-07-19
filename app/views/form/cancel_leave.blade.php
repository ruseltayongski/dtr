<input type="hidden" value="{{ csrf_token() }}" name="_token">
<meta name="csrf-token" content="{{ csrf_token() }}">   
<div>
    <div>
        <label>User: {{ $user->fname .' '. $user->lname }}</label>
        <select class="form-control leave_leave" name="leave_id" onchange="displayDates(this)" style="width:100%">
            <option value="">Select Leave</option>
            @foreach($data as $row)
                <option data-start ="{{ $row->start }}" data-type ="{{ $row->leave_type }}"  data-end ="{{ $row->end }}" value="{{ $row->id }}">
                    {{ $row->leave_type }} ( {{ $row->start == $row->end ? date('F j, Y', strtotime($row->start)) : date('F j, Y', strtotime($row->start)) .' - '. date('F j, Y', strtotime($row->end)) }} )
                </option>
            @endforeach
        </select>
        <select class="form-control" name="leave_data[]" multiple style="width:100%; display:none">
            <option value="">Select Dates</option>
        </select>
    </div>
</div>
<script>

    $('.leave_leave').select2({
        placeholder: 'Select Leave',
        width: '100%'
    });

    function displayDates(select) {

        var $selected = $(select).find(':selected');

        var rad_type  = $selected.data('leave_type');
        var startdate = $selected.data('start');
        var endDate   = $selected.data('end');

        if (!startdate || !endDate) {
            return;
        }

        var holidays = <?php echo json_encode($holidays); ?>;

        var con_holidays = holidays.map(function(d) {
            return moment(d, 'YYYY-MM-DD').format('MM/DD/YYYY');
        });

        var start = moment(startdate);
        var end   = moment(endDate);

        var $leaveData = $('select[name="leave_data[]"]');

        $leaveData.empty();

        while (start.isSameOrBefore(end)) {

            var include = false;

            if (['PL','ML','10D_VAWCL','SLBW','AL'].includes(rad_type)) {
                include = true;
            } else {

                var formatted = start.format('MM/DD/YYYY');

                if (
                    start.day() != 0 &&
                    start.day() != 6 &&
                    !con_holidays.includes(formatted)
                ) {
                    include = true;
                }
            }

            if (include) {
                $leaveData.append(
                    $('<option>', {
                        value: start.format('YYYY-MM-DD'),
                        text: start.format('MMMM D, YYYY')
                    })
                );
            }

            start.add(1, 'day');
        }

        if ($leaveData.find('option').length > 0) {

            $leaveData.show();

            if ($leaveData.hasClass('select2-hidden-accessible')) {
                $leaveData.trigger('change');
            } else {
                $leaveData.select2({
                    placeholder: 'Select Date(s)',
                    width: '100%'
                });
            }

        } else {

            $leaveData.hide();

            if ($leaveData.hasClass('select2-hidden-accessible')) {
                $leaveData.val(null).trigger('change');
            }
        }
    }
</script>
