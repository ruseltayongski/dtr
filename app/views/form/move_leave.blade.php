<input type="hidden" value="{{ csrf_token() }}" name="_token">
<meta name="csrf-token" content="{{ csrf_token() }}">   
<div>
    <div>
        <label>User: {{ $user->fname .' '. $user->lname }}</label>
        <select class="form-control" id="leave_move_id" name="leave_id" onchange="displayDates(this)" style="width:100%">
            <option value="">Select Leave</option>

            @foreach($data as $row)
                <option data-start ="{{ $row->start }}" data-type ="{{ $row->leave_type }}"  data-end ="{{ $row->end }}" value="{{ $row->id }}">
                    {{ $row->leave_type }} ( {{ $row->start == $row->end ? date('F j, Y', strtotime($row->start)) : date('F j, Y', strtotime($row->start)) .' - '. date('F j, Y', strtotime($row->end)) }} )
                </option>
            @endforeach
        </select>
        <select class="form-control select2" name="leave_move_data" style="width:100%; display:none" onchange="displayMoveDates()">
            <option value="">Select Dates</option>
        </select>
        <div class="input-group dates_to_move" style="margin-bottom: 2px; width:100%; display:none">
            <div class="input-group-addon form-control" style="margin-bottom: 5px;width: 20%; ">
                <i class="fa fa-calendar"></i>
            </div>
            <input style="width: 80%;" type="text" class="form-control move_selected_date" id="move_selected_date" name="move_selected_date" placeholder="Select date here..." required>
        </div>
    </div>
</div>
<script>
    if ($('#leave_move_id').data('select2')) {
        $('#leave_move_id').select2('destroy');
    }
    $('#leave_move_id').select2({
        placeholder: 'Select Leave',
        width: '100%'
    });

    $('.move_selected_date').daterangepicker({
        singleDatePicker: true,
        autoUpdateInput: false,
        showDropdowns: true,
        locale: {
            format: 'MM/DD/YYYY'
        }
    });

    $('.move_selected_date').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY'));
    });

    function displayMoveDates(){
        $('.dates_to_move').css('display', 'block');
    }

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

        var excluded = <?php echo json_encode($excluded); ?>;

        var cancelled = excluded.map(function(d) {
            return moment(d, 'YYYY-MM-DD').format('MM/DD/YYYY');
        });

        var start = moment(startdate);
        var end   = moment(endDate);

        var $leaveData = $('select[name="leave_move_data"]');

        $leaveData.empty();

        $leaveData.append(
            $('<option>', {
                value: "",
                text: "Select Date"
            })
        );

        while (start.isSameOrBefore(end)) {

            var include = false;

            if (['PL','ML','10D_VAWCL','SLBW','AL'].includes(rad_type)) {
                include = true;
            } else {

                var formatted = start.format('MM/DD/YYYY');

                if (
                    start.day() != 0 &&
                    start.day() != 6 &&
                    !con_holidays.includes(formatted) &&
                    !cancelled.includes(formatted)
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
                $leaveData.val(null).trigger('change');
            } else {
                $leaveData.select2({
                    placeholder: 'Select Date',
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