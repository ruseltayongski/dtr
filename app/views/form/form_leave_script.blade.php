<!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<!-- Moment.js (required) -->
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>

<!-- jQuery (if not already included) -->

<!-- Daterangepicker -->
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>

    var vl_bal = {{($user->vacation_balance != null)?$user->vacation_balance:0}};
    var sl_bal = {{($user->sick_balance != null)?$user->sick_balance:0}};
    var FL = {{($spl)?$spl->FL:0}};
    var SPL = {{($spl)?$spl->SPL:0}};
    var spl_pending = {{ $spl_pending }};
    var fl_pending = {{ $fl_pending }};

    var radio_val = $('input[name="leave_type"]:checked').val();

    function leave_value() {
         radio_val = $('input[name="leave_type"]:checked').val();
         return radio_val;
    }

    var holidays = <?php echo json_encode($holidays) ?>;
    var con_holidays = holidays.map(function(d) {
        return moment(d, 'YYYY-MM-DD').format('MM/DD/YYYY');
    });

    $(function () {

        $("body").delegate("#inclusive11", "focusin", function () {

            var today = new Date();

            var weekday = new Array(7);
            weekday[0] = "Sunday";
            weekday[1] = "Monday";
            weekday[2] = "Tuesday";
            weekday[3] = "Wednesday";
            weekday[4] = "Thursday";
            weekday[5] = "Friday";
            weekday[6] = "Saturday";

            var name_of_days = weekday[today.getDay()];
            var beforeDaysToApply;
            var spl_type = $('#spl_type').val();
            radio_val = leave_value();

            if (radio_val == "VL" || radio_val == "SOLO_PL" || radio_val == "SLBW" ){
                if( name_of_days == "Friday" ){
                    beforeDaysToApply = 7;
                }else {
                     beforeDaysToApply = 5;
                }
            }else if(radio_val == "SPL") {
                if (spl_type == 'unemergency') {
                    if (name_of_days == "Friday") {
                        beforeDaysToApply = 9;
                    } else {
                        beforeDaysToApply = 7;
                    }
                }
            }else if(radio_val == "AL"){
                if (name_of_days == "Friday") {
                    beforeDaysToApply = 5;
                } else {
                    beforeDaysToApply = 3;
                }
            }else {
                var lastYear = today.getFullYear() - 1;
                start = "01/01/" + lastYear;
                start = "01/01/" + lastYear;
            }

            var startDateObj = new Date(today);
            startDateObj.setDate(startDateObj.getDate() + beforeDaysToApply);

            var dd = String(startDateObj.getDate()).padStart(2, '0');
            var mm = String(startDateObj.getMonth() + 1).padStart(2, '0');
            var yyyy = startDateObj.getFullYear();

            startDate = mm + '/' + dd + '/' + yyyy;
            endDate = startDate;


            if(radio_val == "VL" || radio_val == "SOLO_PL" || radio_val == "SLBW" || radio_val == "AL"){
                startDate = startDate;
                endDate = endDate;
            }else{
                if(spl_type == "unemergency"){
                    startDate = startDate;
                    endDate = endDate;
                }
                startDate = today;
                endDate = today;
            }

            var inputVal = $(this).val();
            if (inputVal.includes(" - ")) {
                var selectedDates = inputVal.split(" - ");
                startDate = moment(selectedDates[0], "MM/DD/YYYY");
                endDate = moment(selectedDates[1], "MM/DD/YYYY");
            }

            if ($(this).data('daterangepicker')) {
                $(this).data('daterangepicker').remove();
            }

            $(this).daterangepicker({
                locale: {
                    format: 'MM/DD/YYYY'
                },
                minDate: mm + '/' + dd + '/' + yyyy,
                startDate: startDate,
                endDate: endDate,
                isInvalidDate: function(date) {
                    if (['VL','SL','SPL','FL','SOLO_PL','STUD_L', 'RL', 'RL', 'SEL', 'OTHERS'].includes(leave_value()) || leave_value() == null) {
                        var formatted = moment(date).format('MM/DD/YYYY');
                        var day = date.day();
                        return (day === 0 || day === 6 || con_holidays.includes(formatted));
                    }
                    return false;
                }
            }).on('apply.daterangepicker', function (ev, picker) {

                var closestClone = $(this).closest('.table-data');
                var remarksContainer = closestClone.find('.date_remarks');

                $('#vl_less').val(0);
                $('#sl_less').val(0);
                $('#vl_rem').val(vl_bal);
                $('#sl_rem').val(sl_bal);

                var radio_val = $('input[name="leave_type"]:checked').val();

                var days = totalDays();
                $('#applied_num_days').val(days);
                if(radio_val == "PL" || radio_val == "SOLO_PL"){
                    if(days>7){
                        Lobibox.alert('error', {msg:"7 Days of Leave Only!"})
                        $('.datepickerInput1').val("");
                    }else{
                        $('#with_pay').val(days + " day(s)");
                    }
                }else if(radio_val == "ML"){
                    if(days>105){
                        Lobibox.alert('error', {msg:"105 Days of Leave Only!"});
                        $('.datepickerInput1').val("");
                    }else{
                        $('#with_pay').val(days + " day(s)");
                    }
                }else if(radio_val == "10D_VAWCL"){
                    if(days>10){
                        Lobibox.alert('error', {msg:"10 Days of Leave Only!"});
                        $('.datepickerInput1').val("");
                    }else{
                        $('#with_pay').val(days + " day(s)");
                    }
                }else if(radio_val == "STUD_L" || radio_val == "RL"){
                    if(days>180){
                        Lobibox.alert('error', {msg:"Up to 6 Months of Leave Only!"});
                        $('.datepickerInput1').val("");
                    }else{
                        $('#with_pay').val(days + " day(s)");
                    }
                }else if(radio_val == "SEL"){
                    if(days>5){
                        Lobibox.alert('error', {msg:"5 Days Only!"});
                        $('.datepickerInput1').val("");
                    }
                    $('#with_pay').val(days + " day(s)");
                }else if(radio_val == "SLBW"){
                    if(days>60){
                        Lobibox.alert('error', {msg:" Up to 2 Months Only!"});
                        $('.datepickerInput1').val("");
                    }else{
                        $('#with_pay').val(days + " day(s)");
                    }
                }else if(radio_val == "AL"){
                    if(days>7){
                        Lobibox.alert('error', {msg:" Up to 7 days Only!"});
                        $('.datepickerInput1').val("");
                    }else{
                        $('#with_pay').val(days + " day(s)");
                    }
                }else if(radio_val == "FL" || radio_val == "VL"){
                    $('#vl_less').val(days);

                    if(radio_val == "FL") {
                        if (days > FL) {
                            Lobibox.alert('error', {
                                msg: 'Insufficient FL balance!',
                                size: 'mini'
                            });
                            $('.datepickerInput1').val("");
                            $('#applied_num_days').val("");
                        }else if (days + fl_pending > FL) {
                            Lobibox.alert('error', {
                                msg: 'Insufficient FL remaining balance!',
                                size: 'mini'
                            });
                            $('.datepickerInput1').val("");
                            $('#applied_num_days').val("");
                        }
                    }
                        if(vl_bal > 0){
                            if(vl_bal >= days){
                                $('#with_pay').val(days + ' day(s)');
                                $('#vl_rem').val(vl_bal-days);
                                $('#vl_less').val(days);
                            }else{
                                $('#without_pay').val( (days - vl_bal) + ' day(s)');
                                $('#with_pay').val( vl_bal + ' day(s)');
                                $('#vl_rem').val(0);
                                $('#vl_less').val(vl_bal);
                            }
                        }else{
                            $('#without_pay').val(days + ' day(s)');
                        }
                }else if(radio_val == 'SL' || radio_val == 'SPL'){
                    if(radio_val == 'SL'){
                        if(sl_bal >= days){
                            $('#with_pay').val(days + ' day(s)');
                            $('#sl_rem').val(sl_bal-days);
                            $('#sl_less').val(days);

                        }else{
                            var in_bal = sl_bal - days;
                            var aft_bal = 0;
                            if(vl_bal >= -(in_bal)){
                                aft_bal = vl_bal - -(in_bal);
                                $('#vl_less').val(-(in_bal));
                                $('#vl_rem').val(aft_bal);
                                $('#with_pay').val((-(in_bal) + sl_bal)  + ' day(s)');
                                $('#sl_less').val(days - -(in_bal));
                                $('#sl_rem').val(0);

                            }else{

                                var less_vl = -(in_bal) - vl_bal;

                                $('#vl_less').val(vl_bal);
                                $('#vl_rem').val(0);
                                $('#without_pay').val(less_vl +  ' day(s)');
                                $('#sl_less').val(sl_bal);
                                $('#sl_rem').val(0);
                                $('#with_pay').val((sl_bal + vl_bal) + ' day(s)');
                            }
                        }
                    }else if(radio_val == "SPL"){
                        if(days>SPL){
                            Lobibox.alert('error',{msg:"Exceed SPL Balance/Maximum of 3!"});
                            $('.datepickerInput1').val("");
                            $('#applied_num_days').val("");
                        }else if( spl_pending + days> SPL){
                            Lobibox.alert('error',{msg:"Exceed your SPL remaining balance!"});
                            $('.datepickerInput1').val("");
                            $('#applied_num_days').val("");
                        }else{
                            $('#with_pay').val(days + " day(s)");
                        }
                    }

                    var end_date   = moment(picker.endDate.format('YYYY-MM-DD'));

                    var currentDate = new Date(); // Get the current date
                    var endDateForLoop = new Date(currentDate);
                    endDateForLoop.setDate(endDateForLoop.getDate() - 1);

                    remarksContainer.empty();
                    $('#date_remarks2').empty();

                    if (end_date <= currentDate) {

                        var dayAfterEndDate = new Date(end_date);
                        dayAfterEndDate.setDate(dayAfterEndDate.getDate() + 1); // Increment endDate by 1 day

                        for (var date = dayAfterEndDate; date <= endDateForLoop; date.setDate(date.getDate() + 1)) {
                            // Check if the current date is Saturday (6) or Sunday (0)
                            var dayOfWeek = date.getDay(); // 0 = Sunday, 6 = Saturday

                            if (dayOfWeek !== 0 && dayOfWeek !== 6) { // Exclude Saturdays and Sundays
                                var formattedDate = new Date(date).toLocaleDateString('en-US');
                                if (!days_display.includes(formattedDate)) {
                                    // If not, append and push to array
                                    remarksContainer.append(
                                        '<div style="display: flex; align-items: center; margin-bottom: 5px;">' +
                                        '<span style="flex: 1; text-align: left;">' + formattedDate + '</span>' +
                                        '<select class="chosen-select-static form-control sl_option" name="date_remarks[]" style="flex: 3; width: auto;" required>' +
                                        '<option value="">Select Reason</option>' +
                                        '<option value="cdo">CDO</option>' +
                                        '<option value="leave">LEAVE</option>' +
                                        '<option value="rpo">RPO</option>' +
                                        '<option value="holiday">HOLIDAY</option>' +
                                        '</select>' +
                                        '<input type="hidden" class="form-control rpo_details" style="width: auto;" name="rpo_rem[]" placeholder="rpo#/title">' +
                                        '<input type="hidden" name="s_dates[]" value="'+formattedDate+'">' +
                                        '</div>'
                                    );
                                    days_display.push(formattedDate);
                                }
                            }
                        }
                    }

                }
            });

            var radio_val = $('input[name="leave_type"]:checked').val();

            if(radio_val == "SPL" || radio_val == "RL"){
                $(".range_inputs").append("" +
                    "<div class='alert-info'>" +
                    "<h6 style='color: #206ff0;padding-right: 5%;padding-left:5%'>Note: 1 week working days before apply</h6>" +
                    "</div>" +
                    "");
            }else if(radio_val == "VL" || radio_val == "SOLO_PL" || radio_val == "SLBW"){
                $(".range_inputs").append("" +
                    "<div class='alert-info'>" +
                    "<h6 style='color: #206ff0;padding-right: 5%;padding-left:5%'>Note: 5 working days before apply</h6>" +
                    "</div>" +
                    "");
            }else{
                $(".range_inputs").append("" +
                    "<div class='alert-info'>" +
                    "<h6 style='color: #206ff0;padding-right: 5%;padding-left:5%'>Note: Check application details for more info!</h6>" +
                    "</div>" +
                    "");
            }
        });
    });

    $(document).on('change', '.sl_option', function () {
        var value = $(this).val();
        var rpoInput = $(this).siblings('.rpo_details');

        if (value === 'rpo') {
            rpoInput.attr('type', 'text').attr('required', true);
        } else {
            rpoInput.attr('type', 'hidden').removeAttr('required');
        }
    });

    $('.chosen-select-static').chosen();

    var days_display = [];

    $(".addButton1").click(function () {
        var clonedData = $('#clone_data').clone();

        clonedData.find('input[type="text"]').val('');
        clonedData.find('div[type="text"]').empty();
        clonedData.find('.date_remarks').empty();

        $('#data_here').append(clonedData);
    });

    $(document).on("click", ".deleteButton1", function () {
        var td = $(this).closest('td');
        var totalRows = td.find('.table-data').length;

        if (totalRows > 1) {
            $(this).closest('.table-data').remove();
        } else {
            $('#applied_num_days').val('');
            $('.datepickerInput1').val('');
        }

        var days = totalDays();
        $('#applied_num_days').val(days);
        $('#vl_rem').val(vl_bal);
        $('#sl_rem').val(sl_bal);
        $('#vl_less').val(0);
        $('#sl_less').val(0);
        $('#with_pay').val('');
        $('#without_pay').val('');
    });

    function getAllDates() {
        var dates = [];
        $('.datepickerInput1').each (function(){
            var selectedDate = $(this).val();
            dates.push(selectedDate);
        })
        return dates;
    }

    function totalDays() {
        var dates = getAllDates();
        var totalDays = 0;

        dates.forEach(function (daterange) {
            var startdate = daterange.split(" - ")[0];
            var endDate = daterange.split(" - ")[1];
            if(startdate !== '' && endDate !==''){

                var start = moment(startdate, 'MM/DD/YYYY');
                var end = moment(endDate, 'MM/DD/YYYY');
                var weekdaysCount = 0;
                var rad_type = leave_value();

                while (start <= end) {
                    if(['PL', 'ML', '10D_VAWCL', 'SLBW', 'AL'].includes(rad_type)){
                        weekdaysCount++;
                    }else{
                        if (start.day() != 6 && start.day() != 0 && !con_holidays.includes(start.format('MM/DD/YYYY'))) {
                            weekdaysCount++;
                        }
                    }
                    start.add(1, 'day');
                }

                totalDays += weekdaysCount;
            }
        });
        return totalDays;
    }

</script>