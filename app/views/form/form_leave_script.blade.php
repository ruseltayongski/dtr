<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
<script>
    var vl_unchange = {{ ($user->vacation_balance != null)?$user->vacation_balance:0 }};
    var sl_unchange = {{ ($user->sick_balance != null)?$user->sick_balance:0 }};

    var vl_bal = {{ ($user->vacation_balance != null)?$user->vacation_balance:0 }};
    var sl_bal = {{ ($user->sick_balance != null)?$user->sick_balance:0 }};
    var FL = {{ $spl ? $spl->FL:0 }};
    var SPL = {{ $spl ? $spl->SPL:0 }};
    var WL = {{ $spl ? $spl->wellness:0 }};
    var spl_pending = {{ $spl_pending }};
    var fl_pending = {{ $fl_pending }};
    var wl_pending = {{ $wellness_pending }};
    var radio_val = $('input[name="leave_type"]:checked').val();

    function leave_value() {
         radio_val = $('input[name="leave_type"]:checked').val();
         return radio_val;
    }

    var holidays = <?php echo json_encode($holidays) ?>;
    var con_holidays = holidays.map(function(d) {
        return moment(d, 'YYYY-MM-DD').format('MM/DD/YYYY');
    });

    $('#spl_emergency').on('click', function(){
        $('#spl_type').val('emergency');
        var uncheckedValue = "SPL";

        $('.selected_type').each(function () {

            var selectedValue = $(this).find('option:selected').val();
            if (selectedValue == uncheckedValue) {
                var td = $(this).closest('td');
                var totalRows = td.find('.table-data').length;

                $(this).closest('.input-group').find('.days_input').val("");
                $(this).closest('.input-group').find('.selected_type').prop('selectedIndex', 0).trigger('chosen:updated');
                $(this).closest('.input-group').find('.datepickerInput1').val("");
             
                $('#applied_num_days').val(overall_days());
                deduction();
                check_with_pay();
            }
        });
    });

    $('#spl_none_emergency').on('click', function(){
        $('#spl_type').val('unemergency');
        var uncheckedValue = "SPL";

        $('.selected_type').each(function () {

            var selectedValue = $(this).find('option:selected').val();
            if (selectedValue == uncheckedValue) {
                var td = $(this).closest('td');
                var totalRows = td.find('.table-data').length;

                $(this).closest('.input-group').find('.days_input').val("");
                $(this).closest('.input-group').find('.selected_type').prop('selectedIndex', 0).trigger('chosen:updated');
                $(this).closest('.input-group').find('.datepickerInput1').val("");
             
                $('#applied_num_days').val(overall_days());
                deduction();
                check_with_pay();
            }
        });
    });

    $('#wl_emergency').on('click', function(){
        $('.wl_attachment').css('display', 'block');
        $('#wl_type').val('emergency');
        var uncheckedValue = "WL";

        $('.selected_type').each(function () {

            var selectedValue = $(this).find('option:selected').val();
            if (selectedValue == uncheckedValue) {
                var td = $(this).closest('td');
                var totalRows = td.find('.table-data').length;

                $(this).closest('.input-group').find('.days_input').val("");
                $(this).closest('.input-group').find('.selected_type').prop('selectedIndex', 0).trigger('chosen:updated');
                $(this).closest('.input-group').find('.datepickerInput1').val("");
             
                $('#applied_num_days').val(overall_days());
                deduction();
                check_with_pay();
            }
        });
    });

    $('#wl_none_emergency').on('click', function(){
        $('.wl_attachment').css('display', 'none');
        $('#wl_type').val('unemergency');
        var uncheckedValue = "WL";

        $('.selected_type').each(function () {

            var selectedValue = $(this).find('option:selected').val();
            if (selectedValue == uncheckedValue) {
                var td = $(this).closest('td');
                var totalRows = td.find('.table-data').length;

                $(this).closest('.input-group').find('.days_input').val("");
                $(this).closest('.input-group').find('.selected_type').prop('selectedIndex', 0).trigger('chosen:updated');
                $(this).closest('.input-group').find('.datepickerInput1').val("");
             
                $('#applied_num_days').val(overall_days());
                deduction();
                check_with_pay();
            }
        });
    });

    $('#sl_emergency').on('click', function(){
        $('#sl_type').val('emergency');
        var uncheckedValue = "SL";

        $('.selected_type').each(function () {

            var selectedValue = $(this).find('option:selected').val();
            if (selectedValue == uncheckedValue) {
                var td = $(this).closest('td');
                var totalRows = td.find('.table-data').length;

                $(this).closest('.input-group').find('.days_input').val("");
                $(this).closest('.input-group').find('.selected_type').prop('selectedIndex', 0).trigger('chosen:updated');
                $(this).closest('.input-group').find('.datepickerInput1').val("");
             
                $('#applied_num_days').val(overall_days());
                deduction();
                check_with_pay();
            }
        });
    });

    $('#sl_none_emergency').on('click', function(){
        $('#sl_type').val('unemergency');

        var uncheckedValue = "SL";

        $('.selected_type').each(function () {

            var selectedValue = $(this).find('option:selected').val();
            if (selectedValue == uncheckedValue) {
                var td = $(this).closest('td');
                var totalRows = td.find('.table-data').length;

                $(this).closest('.input-group').find('.days_input').val("");
                $(this).closest('.input-group').find('.selected_type').prop('selectedIndex', 0).trigger('chosen:updated');
                $(this).closest('.input-group').find('.datepickerInput1').val("");
             
                $('#applied_num_days').val(overall_days());
                deduction();
                check_with_pay();
            }
        });
    });

    $(function () {

        $("body").delegate("#inclusive11", "focusin", function (e) {
            var $this = $(this);

            var radio_val = $this
                .closest('.input-group')
                .find('.selected_type')
                .val();

            if (!radio_val) {

                $this.blur(); // remove focus first

                alert('Please select type of leave first. Thank you');

                var picker = $this.data('daterangepicker');
                if (picker) {
                    picker.hide();
                }

                return false;
            }
            
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
            var sl_type = $('#sl_type').val();
            var wl_type = $('#wl_type').val();
            // radio_val = leave_value();

            if (radio_val == "VL" || radio_val == "SOLO_PL" || radio_val == "SLBW" || radio_val == "SL" ){
                // && sl_type == "emergency"
                if(radio_val == "SL"){
                    beforeDaysToApply = -31;
                }else{
                    if( name_of_days == "Friday" ){
                        beforeDaysToApply = 7;
                    }else {
                        beforeDaysToApply = 5;
                    }
                }

            }else if(radio_val == "SPL") {
                if (spl_type == 'unemergency') {
                    if (name_of_days == "Friday") {
                        beforeDaysToApply = 9;
                    } else {
                        beforeDaysToApply = 7;
                    }
                }
            }else if(radio_val == "WL") {
                if (wl_type == 'unemergency') {
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
                    var formatted = moment(date).format('MM/DD/YYYY');

                    if (['VL','SL','SPL','WL','FL','SOLO_PL','STUD_L', 'RL', 'RL', 'SEL', 'OTHERS'].includes(leave_value()) || leave_value() == null) {
                        var day = date.day();
                        return (day === 0 || day === 6 || con_holidays.includes(formatted));
                    }else{
                        return con_holidays.includes(formatted);
                    }
                    return false;
                }
            }).on('apply.daterangepicker', function (ev, picker) {

                var invalid = false;

                var closestClone = $(this).closest('.table-data');
                var remarksContainer = closestClone.find('.date_remarks');

                var radio_val = $(this).closest('.input-group').find('.selected_type').val();
                var days = totalDays(radio_val);
                var spec_days = specific_days($(this).val(), radio_val);

                if(radio_val == "PL" || radio_val == "SOLO_PL"){
                    if(days>7){
                        Lobibox.alert('error', {msg:"7 Days of Leave Only!"})
                        $(this).closest('.input-group').find('.datepickerInput1').val("");
                    }else{
                        $('#with_pay').val(days + " day(s)");   
                    }
                }else if(radio_val == "ML"){
                    if(days>105){
                        Lobibox.alert('error', {msg:"105 Days of Leave Only!"});
                        $(this).closest('.input-group').find('.datepickerInput1').val("");
                    }else{
                        $('#with_pay').val(days + " day(s)");
                    }
                }else if(radio_val == "10D_VAWCL"){
                    if(days>10){
                        Lobibox.alert('error', {msg:"10 Days of Leave Only!"});
                        $(this).closest('.input-group').find('.datepickerInput1').val("");

                    }else{
                        $('#with_pay').val(days + " day(s)");
                    }
                }else if(radio_val == "STUD_L" || radio_val == "RL"){
                    if(days>180){
                        Lobibox.alert('error', {msg:"Up to 6 Months of Leave Only!"});
                        $(this).closest('.input-group').find('.datepickerInput1').val("");
                    }else{
                        $('#with_pay').val(days + " day(s)");
                    }
                }else if(radio_val == "SEL"){
                    if(days>5){
                        Lobibox.alert('error', {msg:"5 Days Only!"});
                        $(this).closest('.input-group').find('.datepickerInput1').val("");
                    }
                    $('#with_pay').val(days + " day(s)");
                }else if(radio_val == "SLBW"){
                    if(days>60){
                        Lobibox.alert('error', {msg:" Up to 2 Months Only!"});
                        $(this).closest('.input-group').find('.datepickerInput1').val("");
                    }else{
                        $('#with_pay').val(days + " day(s)");
                    }
                }else if(radio_val == "AL"){
                    if(days>7){
                        Lobibox.alert('error', {msg:" Up to 7 days Only!"});
                        $(this).closest('.input-group').find('.datepickerInput1').val("");
                    }else{
                        $('#with_pay').val(days + " day(s)");
                    }
                }else if(radio_val == "FL" || radio_val == "VL"){
                    $('#vl_less').val(days);
                    var check_fl = check_fl_bal();

                    if(radio_val == "FL") {
                        if (check_fl > FL) {
                            Lobibox.alert('error', {
                                msg: 'Insufficient FL balance!',
                                size: 'mini'
                            });
                            $(this).closest('.input-group').find('.datepickerInput1').val("");
                            $('#applied_num_days').val("");
                            invalid = true;
                            deduction();
                            check_with_pay();   
                        }else if (check_fl + fl_pending > FL) {
                            Lobibox.alert('error', {
                                msg: 'Insufficient FL remaining balance!',
                                size: 'mini'
                            });
                            $(this).closest('.input-group').find('.datepickerInput1').val("");
                            $('#applied_num_days').val("");
                            invalid = true;
                            deduction();
                            check_with_pay();   
                        }else{
                            $('#with_pay').val( days + ' day(s)');
                        }
                    }
                    if(vl_bal > 0){
                        if(vl_bal >= days){
                            $('#with_pay').val(days + ' day(s)');
                            $('#vl_rem').val(vl_bal-days);
                            $('#vl_less').val(days);
                        }else{
                            $('#without_pay').val( days - vl_bal + ' day(s)');
                            $('#with_pay').val( vl_bal + ' day(s)');
                            $('#vl_rem').val(0);
                            $('#vl_less').val(vl_bal);
                        }
                    }else{
                        $('#without_pay').val(days + ' day(s)');
                    }
                      
                }else if(radio_val == 'SL' || radio_val == 'SPL' || radio_val == 'WL'){
                    if(radio_val == 'SL'){
                        if(sl_type == "unemergency"){
                            var endDate = picker.endDate.clone().startOf('day');
                            var yesterday = moment().subtract(1, 'day').startOf('day');
                            if (endDate.isBefore(yesterday)) {
                                if(priv == 1){
                                    $('.priv_data').val(1);
                                }else{
                                    Lobibox.alert('warning', {
                                        msg: '<i class="fa fa-spinner fa-spin"></i> Unemergency Sick Leave applications for dates earlier than yesterday require a special privilege. Please contact the HR Leave Administrator to have this privilege granted before submitting your application. Thank you.',
                                        size: 'mini',
                                        closeButton: false,
                                        delay: false,
                                        sound: false
                                    });

                                    $(this).closest('.input-group').find('.datepickerInput1').val("");

                                    // picker.setStartDate(moment());
                                    // picker.setEndDate(moment());

                                    return;
                                }                                
                            }
                        }else{
                            if(spec_days > 5){
                                $('.sl_attachment').css('display', 'block');
                                lockOutsideSlAttchment($('.sl_attachment'));
                            }
                        }
                        
                        if(sl_bal >= days){
                            $('#with_pay').val(days + ' day(s)');
                            $('#sl_rem').val((sl_bal-days).toFixed(3));
                            $('#sl_less').val(days);

                        }else{
                            var in_bal = sl_bal - days;
                            var aft_bal = 0;

                            var vl_less = vl_bal;
                            var vl_check = check_vl_rem();
                            
                            if(vl_bal == vl_check || vl_check > vl_bal){
                                vl_bal = 0;
                            }else if(vl_bal > vl_check){
                                vl_bal = vl_bal - vl_check;
                                vl_less = vl_check;
                            }else{

                            }

                            if(vl_bal >= -(in_bal)){

                                aft_bal = vl_bal - -(in_bal);
                                $('#vl_less').val(
                                    parseFloat(-in_bal) + parseFloat(vl_check)
                                );                                
                                $('#vl_rem').val(aft_bal);
                                $('#with_pay').val(-(in_bal) + sl_bal  + ' day(s)');
                                $('#sl_less').val(days - -(in_bal));
                                $('#sl_rem').val(0);

                            }else{

                                var less_vl = -(in_bal) - vl_bal;

                                $('#vl_less').val(vl_less);
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
                            $(this).closest('.input-group').find('.datepickerInput1').val("");
                            $('#applied_num_days').val("");
                            invalid = true;
                        }else if( spl_pending + days> SPL){
                            Lobibox.alert('error',{msg:"Exceed your SPL remaining balance!"});
                            $(this).closest('.input-group').find('.datepickerInput1').val("");
                            $('#applied_num_days').val("");
                            invalid = true;
                            return;
                        }else{
                            $('#with_pay').val(days + " day(s)");
                        }
                    }else if(radio_val == "WL"){
                        if(days>WL){
                            Lobibox.alert('error',{msg:"Exceed Wellness Leave Balance/Maximum of 5!"});
                            $(this).closest('.input-group').find('.datepickerInput1').val("");
                            $('#applied_num_days').val("");
                            invalid = true;

                        }else if( wl_pending + days> WL){
                            Lobibox.alert('error',{msg:"Exceed your Wellness Leave remaining balance!"});
                            $(this).closest('.input-group').find('.datepickerInput1').val("");
                            $('#applied_num_days').val("");
                            invalid = true;

                            return;
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
                $('#applied_num_days').val(overall_days());
                if(!invalid){
                    $(this).closest('.input-group').find('.days_input').val(spec_days);
                }
                deduction();
                check_with_pay();
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

        $('#clone_data').find('.selected_type').chosen('destroy');

        // Only grab the FIRST input-group and its FIRST date_remarks
        var $firstGroup = $('#clone_data').find('.input-group').first();
        var $firstRemarks = $('#clone_data').find('.date_remarks').first();

        // Clone just those two elements, wrapped together
        var clonedData = $firstGroup.clone().add($firstRemarks.clone());

        $('#clone_data').find('.selected_type').chosen({
            width: '80px'
        });

        clonedData.filter('input[type="text"]').val('');
        clonedData.find('input[type="text"]').val('');
        clonedData.filter('.date_remarks').empty();
        clonedData.find('.date_remarks').empty();

        var checkedValues = $('input[name="leave_type"]:checked')
            .map(function () {
                return $(this).val();
            })
            .get();

        var $select = clonedData.filter('.input-group').find('.selected_type');
        if ($select.length === 0) {
            $select = clonedData.find('.selected_type');
        }

        $select.empty().append(`
            <option value="" selected disabled hidden>Type</option>
        `);

        checkedValues.forEach(function (item) {
            $select.append(
                $('<option>', {
                    value: item,
                    text: item
                })
            );
        });

        clonedData.find('.chosen-container').remove();

        $('#data_here').append(clonedData);

        $select.chosen({
            width: '80px'
        });

    });

    $(document).on('change', '.leave-toggle', function () {

        if (!this.checked) {
            var uncheckedValue = $(this).val();

            $('.selected_type').each(function () {
                var $select = $(this);

                $select.find('option[value="' + uncheckedValue + '"]').remove();
                $select.trigger('chosen:updated'); 

                var selectedValue = $select.find('option:selected').val();
                if (selectedValue == uncheckedValue) {
                    var td = $select.closest('td');
                    var totalRows = td.find('.table-data').length;

                    if (totalRows > 1) {
                        $select.closest('.table-data').remove();
                    } else {
                        $select.closest('.input-group').find('#applied_num_days').val("");
                        $select.closest('.input-group').find('.datepickerInput1').val("");
                    }

                    $('#applied_num_days').val(overall_days());
                    deduction();
                    check_with_pay();
                }
            });
        }else{
            if($(this).val() == "SL"){
                var $slDiv = $(".sl_div");
                $slDiv.show();
                lockOutsideSlDiv($slDiv);
            } else {
                $(document).off('click.slLock mousedown.slLock');
                $(".sl_div").removeClass('sl-locked-highlight').hide();
            }
        }
    });

    function lockOutsideSlDiv($slDiv){
        $(document).off('click.slLock mousedown.slLock');

        $slDiv.addClass('sl-locked-highlight'); 
        $(document).on('mousedown.slLock click.slLock', function(e){
            if($(e.target).closest('.sl_div').length){
                $(document).off('click.slLock mousedown.slLock');
                $slDiv.removeClass('sl-locked-highlight');
                return; 
            }

            e.preventDefault();
            e.stopImmediatePropagation();
            return false;
        });
    }

    function lockOutsideSlAttchment($slDiv){
        $(document).off('click.slLock mousedown.slLock');
        $slDiv.addClass('sl-locked-highlight');
        $slDiv.attr('tabindex', -1).trigger('focus');

        $(document).on('mousedown.slLock click.slLock', function(e){
            if($(e.target).closest('.sl_attachment').length){
                $(document).off('click.slLock mousedown.slLock');
                $slDiv.removeClass('sl-locked-highlight');
                return;
            }
            e.preventDefault();
            e.stopImmediatePropagation();
            return false;
        });
    }

    $('input[name="sl_emergency_status"]').change(function(){
        $('body').children().css('pointer-events', 'auto');
    });

    $(document).on("click", ".deleteButton1", function () {
        var td = $(this).closest('td');
        var totalRows = td.find('.table-data').length;

        if (totalRows > 1) {
            $(this).closest('.table-data').remove();
        } else {
            $(this).closest('.input-group').find('#applied_num_days').val("");
            $(this).closest('.input-group').find('.datepickerInput1').val("");
        }

        $('#applied_num_days').val(overall_days());
        deduction();
        check_with_pay();   
    });

    function getAllDates(radio_val) {
        var dates = [];

        var check_data;
        if (radio_val == "FL" || radio_val == "VL") {
            check_data = ["FL", "VL"];
        } else {
            check_data = [radio_val];
        }

        $('.selected_type').each(function () {    

            if (check_data.includes($(this).val())) {

                var selectedDate = $(this)
                    .closest('.input-group')
                    .find('.datepickerInput1')
                    .val();
                dates.push({
                    date: selectedDate,
                    type: $(this).val()
                });
            }
        });

        return dates;
    }

    function totalDays(radio_val) {
        var dates = getAllDates(radio_val);
        var totalDays = 0;

        dates.forEach(function (item) {
            var daterange = item.date;
            var startdate = daterange.split(" - ")[0];
            var endDate = daterange.split(" - ")[1];
            if(startdate !== '' && endDate !==''){

                var start = moment(startdate, 'MM/DD/YYYY');
                var end = moment(endDate, 'MM/DD/YYYY');
                var weekdaysCount = 0;
                var rad_type = item.type;

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

    function deduction(){
        var SL_usage = check_sl_rem();
        var VL_usage = check_vl_rem();
        var SL_rem = 0;
        var VL_rem = 0;
        var VL_with_pay = vl_unchange;
        var SL_with_pay = sl_unchange;

        if(vl_unchange >= VL_usage){
            VL_rem = vl_unchange - VL_usage;
            VL_with_pay = VL_usage;
        }

        if(sl_unchange >= SL_usage){
            SL_rem = sl_unchange - SL_usage;
            SL_with_pay = SL_usage;
        }else{
            var sl_excess = SL_usage - sl_unchange;
            if(VL_rem >= sl_excess){
                VL_with_pay = VL_with_pay + sl_excess;
            }else{
                VL_with_pay = VL_with_pay + VL_rem;
            }
        }

        $('#vl_less').val(VL_with_pay);
        $('#sl_less').val(SL_with_pay);

        $('#vl_rem').val(vl_unchange - VL_with_pay);
        $('#sl_rem').val(sl_unchange - SL_with_pay);
    }

    function check_sl_rem(){

        var dates = [];
        var result = 0;

        $('.datepickerInput1').each (function(){
            var selectedDate = $(this).val();
            var type = $(this)
                .closest('.input-group')
                .find('.selected_type')
                .val();

            if (type == "SL") {
                dates.push({
                    date: selectedDate,
                    type: type
                });
            }
        })

        var totalDays = 0;

        dates.forEach(function (item) {
            var daterange = item.date;
            var startdate = daterange.split(" - ")[0];
            var endDate = daterange.split(" - ")[1];
            if(startdate !== '' && endDate !==''){

                var start = moment(startdate, 'MM/DD/YYYY');
                var end = moment(endDate, 'MM/DD/YYYY');
                var weekdaysCount = 0;
                var rad_type = item.type;

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

        // result = vl_bal + totalDays;
        return totalDays;
    }

    function check_vl_rem(){

        var dates = [];
        var check_data = ["FL", "VL"];
        var result = 0;

        $('.datepickerInput1').each (function(){
            var selectedDate = $(this).val();
            var type = $(this)
                .closest('.input-group')
                .find('.selected_type')
                .val();

            if (check_data.includes(type)) {
                dates.push({
                    date: selectedDate,
                    type: type
                });
            }
        })

        var totalDays = 0;

        dates.forEach(function (item) {
            var daterange = item.date;
            var startdate = daterange.split(" - ")[0];
            var endDate = daterange.split(" - ")[1];
            if(startdate !== '' && endDate !==''){

                var start = moment(startdate, 'MM/DD/YYYY');
                var end = moment(endDate, 'MM/DD/YYYY');
                var weekdaysCount = 0;
                var rad_type = item.type;

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

        // result = vl_bal + totalDays;
        return totalDays;
    }

    function check_fl_bal(){

        var dates = [];

        $('.datepickerInput1').each (function(){
            var selectedDate = $(this).val();
            var type = $(this)
                .closest('.input-group')
                .find('.selected_type')
                .val();

            if (type == "FL") {
                dates.push({
                    date: selectedDate,
                    type: type
                });
            }
        })

        var totalDays = 0;

        dates.forEach(function (item) {
            var daterange = item.date;
            var startdate = daterange.split(" - ")[0];
            var endDate = daterange.split(" - ")[1];
            if(startdate !== '' && endDate !==''){

                var start = moment(startdate, 'MM/DD/YYYY');
                var end = moment(endDate, 'MM/DD/YYYY');
                var weekdaysCount = 0;
                var rad_type = item.type;

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

    function check_with_pay(){
       
        var vl_less = parseInt($('#vl_less').val()) || 0;
        var sl_less = parseInt($('#sl_less').val()) || 0;

        var result = vl_less + sl_less;

        var dates = [];
        var check_data = ["FL", "SL", "VL"];

        $('.datepickerInput1').each (function(){
            var selectedDate = $(this).val();
            var type = $(this)
                .closest('.input-group')
                .find('.selected_type')
                .val();

            if (!check_data.includes(type)) {
                dates.push({
                    date: selectedDate,
                    type: type
                });
            }
        })

        var totalDays = 0;

        dates.forEach(function (item) {
            var daterange = item.date;
            var startdate = daterange.split(" - ")[0];
            var endDate = daterange.split(" - ")[1];
            if(startdate !== '' && endDate !==''){

                var start = moment(startdate, 'MM/DD/YYYY');
                var end = moment(endDate, 'MM/DD/YYYY');
                var weekdaysCount = 0;
                var rad_type = item.type;

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

        result = result + totalDays;
        $('#with_pay').val(result + ' day(s)')
        var without = overall_days() - result;
        $('#without_pay').val(without + ' day(s)');
    }

    function specific_days(daterange, radio_val) {
        var startdate = daterange.split(" - ")[0];
        var endDate = daterange.split(" - ")[1];
        var days = 0;
        if(startdate !== '' && endDate !==''){

            var start = moment(startdate, 'MM/DD/YYYY');
            var end = moment(endDate, 'MM/DD/YYYY');
            var weekdaysCount = 0;
            var rad_type = radio_val;

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

            days += weekdaysCount;
        }

        return days;
    }

    function overall_days() {

        var dates = [];
        $('.datepickerInput1').each (function(){
            var selectedDate = $(this).val();
            var type = $(this)
                .closest('.input-group')
                .find('.selected_type')
                .val();

            dates.push({
                date: selectedDate,
                type: type
            });
        })

        var totalDays = 0;

        dates.forEach(function (item) {
            var daterange = item.date;
            var startdate = daterange.split(" - ")[0];
            var endDate = daterange.split(" - ")[1];
            if(startdate !== '' && endDate !==''){

                var start = moment(startdate, 'MM/DD/YYYY');
                var end = moment(endDate, 'MM/DD/YYYY');
                var weekdaysCount = 0;
                var rad_type = item.type;

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