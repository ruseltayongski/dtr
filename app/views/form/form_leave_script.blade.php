<script>

    var vacation_balance = "<?php echo Session::get('vacation_balance'); ?>";
    var sick_balance = "<?php echo Session::get('sick_balance'); ?>";
    var radio_val;
    function leave_value() {
         radio_val = $('input[name="leave_type"]:checked').val();
         return radio_val;
    }
    function here() {
        var rad = $('input[name="leave_type"]:checked').val();
    }

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

            var radio_val = leave_value();
            //5 days prior
             if (radio_val == "VL" || radio_val == "SOLO_PL" || radio_val == "SLBW" ||radio_val == "FL" ){
                 console.log("ahw");
                 if( name_of_days == "Friday" ){
                     beforeDaysToApply = 7;
                 } else {
                     beforeDaysToApply = 5;
                 }
             }else if(radio_val == "SPL" || radio_val == "RL"){
                 if( name_of_days == "Friday" ){
                     beforeDaysToApply = 9;
                 } else {
                     beforeDaysToApply = 7;
                 }
             }else {
                 var lastYear = today.getFullYear() - 1;
                 start = "01/01/" + lastYear;
                 start = "01/01/" + lastYear;
             }

                var dd = today.getDate() + beforeDaysToApply;
                var mm = today.getMonth() + 1;
                var yyyy = today.getFullYear();
                startDate = mm + '/' + dd + '/' + yyyy;
                endDate = mm + '/' + dd + '/' + yyyy;

            if(radio_val == "VL" || radio_val == "SOLO_PL" || radio_val == "SLBW" ||
                radio_val == "SPL" || radio_val == "RL" ||radio_val == "FL"){
                 startDate = startDate;
                 endDate = endDate;
            }else{
                startDate = today
                endDate = today;
            }

            $(this).daterangepicker({
                locale: {
                    format: 'MM/DD/YYYY'
                },
                minDate: mm + '/' + dd + '/' + yyyy,
                startDate: startDate,
                endDate: endDate,
            }).on('apply.daterangepicker', function (ev, picker) {
//                var start = moment(picker.startDate.format('YYYY-MM-DD'));
//                var end   = moment(picker.endDate.format('YYYY-MM-DD'));
//                diff = end.diff(start, 'days');
//                $('#applied_num_days').val(diff+1);

                var radio_val = $('input[name="leave_type"]:checked').val();
                var days = totalDays();
                console.log(" total number of days:", days);

                <?php
                    $leave = InformationPersonal::where('userid', Auth::user()->userid)->first();
                    $leave1 = AditionalLeave::where('userid', Auth:: user()->userid)->first();

                    echo "var FL = ".json_encode(!Empty($leave1->FL)? $leave1->FL : 0). ";";
                    echo "var SPL = ".json_encode(!Empty($leave1->SPL)? $leave1->SPL : 0). ";";
                    echo "var VL = ".json_encode(!Empty($leave->vacation_balance) ? $leave-> vacation_balance : 0). ";";
                    echo "var SL = ".json_encode(!Empty($leave->sick_balance)? $leave->sick_balance : 0). ";";
                    ?>

                if(radio_val == "SPL"){
                    if(days>3 || days>SPL){
                        Lobibox.alert('error',{msg:"Exceed SPL Balance/Maximum of 3!"});
                        $('.datepickerInput1').val("");
                    }else{
                        $('#applied_num_days').val(days);
                    }
                }else if(radio_val == "VL"){
                    if(days > VL){
                        Lobibox.alert('error', {msg:"Exceed VL Balance!"});
                        $('.datepickerInput1').val("");
                    }else{
                        $('#applied_num_days').val(days);
                    }
                }else if(radio_val == "FL"){
                    if(days> FL){
                        Lobibox.alert('error', {msg:"Exceed FL Balance!"});
                        $('.datepickerInput1').val("");
                    }else{
                        $('#applied_num_days').val(days);
                    }
                }else if(radio_val == "SL"){
                    if(days> SL){
                        Lobibox.alert('error', {msg:"Exceed SL Balance"});
                        $('.datepickerInput1').val("");
                    }else{
                        $('#applied_num_days').val(days);
                    }
                }else if(radio_val == "PL" || radio_val == "SOLO_PL"){
                    if(days>7){
                        Lobibox.alert('error', {msg:"7 Days of Leave Only!"})
                        $('.datepickerInput1').val("");
                    }else{
                        $('#applied_num_days').val(days);
                    }
                }else if(radio_val == "ML"){
                    if(days>105){
                        Lobibox.alert('error', {msg:"105 Days of Leave Only!"});
                        $('.datepickerInput1').val("");
                    }else{
                        $('#applied_num_days').val(days);
                    }
                }else if(radio_val == "10D_VAWCL"){
                    if(days>10){
                        Lobibox.alert('error', {msg:"10 Days of Leave Only!"});
                        $('.datepickerInput1').val("");
                    }else{
                        $('#applied_num_days').val(days);
                    }
                }else if(radio_val == "STUD_L" || radio_val == "RL"){
                    if(days>180){
                        Lobibox.alert('error', {msg:"Up to 6 Months of Leave Only!"});
                        $('.datepickerInput1').val("");
                    }else{
                        $('#applied_num_days').val(days);
                    }
                }else if(radio_val == "SEL"){
                    if(days>5){
                        Lobibox.alert('error', {msg:"5 Days Only!"});
                        $('.datepickerInput1').val("");
                    }else{
                        $('#applied_num_days').val(days);
                    }
                }else if(radio_val == "SLBW"){
                    if(days>60){
                        Lobibox.alert('error', {msg:" Up to 2 Months Only!"});
                        $('.datepickerInput1').val("");
                    }else{
                        $('#applied_num_days').val(days);
                    }
                }else{
                    $('#applied_num_days').val(days);
                }

            });


            var radio_val = $('input[name="leave_type"]:checked').val();
            console.log("radio_val", radio_val);

            if(radio_val == "SPL" || radio_val == "RL"){
                $(".range_inputs").append("" +
                    "<div class='alert-info'>" +
                    "<h6 style='color: #206ff0;padding-right: 5%;padding-left:5%'>Note: 1 week working days before apply</h6>" +
                    "</div>" +
                    "");
            }else if(radio_val == "VL" || radio_val == "SPL" || radio_val == "SLBW"){
                console.log("ahww");
                $(".range_inputs").append("" +
                    "<div class='alert-info'>" +
                    "<h6 style='color: #206ff0;padding-right: 5%;padding-left:5%'>Note: 5 working days before apply</h6>" +
                    "</div>" +
                    "");
            }else{
                $(".range_inputs").append("" +
                    "<div class='alert-info'>" +
                    "<h6 style='color: #206ff0;padding-right: 5%;padding-left:5%'>Note: HELLO MADLANG PEOPLE!</h6>" +
                    "</div>" +
                    "");
            }


        });
    });

    $(".addButton1").click(function () {
        console.log("button clicked!");
        var clonedData = $('#clone_data').clone();

        clonedData.find('input[type="text"]').val('');

        $('#data_here').append(clonedData);
    });

    $(document).on("click", ".deleteButton1", function () {
        var td = $(this).closest('td');
        var totalRows = td.find('.table-data').length;
        console.log("Total rows:", totalRows);

        if (totalRows > 1) {
            $(this).closest('.table-data').remove();
        } else {
            $('#applied_num_days').val('');
            $('.datepickerInput1').val('');
        }

        var days = totalDays();
        $('#applied_num_days').val(days);
    });

    function getAllDates() {
        var dates = [];
        console.log("dates", $('.datepickerInput1').val());
        $('.datepickerInput1').each (function(){
            var selectedDate = $(this).val();
            dates.push(selectedDate);
            console.log("aww", selectedDate);
        })
        console.log("datesdates", dates);
        return dates;
    }

    function totalDays() {
        var dates = getAllDates();
        var totalDays = 0;
        console.log("dates", dates)
        dates.forEach(function (daterange) {
            var startdate = daterange.split(" - ")[0];
            var endDate = daterange.split(" - ")[1];
            if(startdate !== '' && endDate !==''){
                var start = moment(startdate, 'MM/DD/YYYY');
                var end = moment(endDate, 'MM/DD/YYYY');
                var diff = end.diff(start, 'days') + 1;
                if(!isNaN(diff)){
                    totalDays += diff;
                }
            }
        });
        return totalDays;

    }


</script>