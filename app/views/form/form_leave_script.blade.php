<script>
    var vacation_balance = "<?php echo Session::get('vacation_balance'); ?>";
    var sick_balance = "<?php echo Session::get('sick_balance'); ?>";

    function clearHalfDaySickFirst(){
        $('input[name="half_day_first"]:checked').attr('checked',false);
    }
    function clearHalfDaySickLast(){
        $('input[name="half_day_last"]:checked').attr('checked',false);
    }

    function countWorkingDays(working_days,days,date){
        var set_daterange = date;
        var add_from_weekend = 0;
        for(var i = 0; i < working_days; i++) {
            day_name = days[new Date(set_daterange).getDay()];
            if(day_name == "Saturday" ||  day_name == "Sunday"){
                add_from_weekend++;
            }
            set_daterange.setDate(set_daterange.getDate() + 1);
        }
        set_daterange.setDate(set_daterange.getDate() + add_from_weekend);
        set_daterange = set_daterange.toLocaleDateString();

        return set_daterange;
    }

    function calendarNotice($message,$alert_info){
        $("body").delegate("#inc_date","focusin",function() {
            $(".range_inputs").append("" +
                "<div class='"+$alert_info+" working_days_noted' style='width: 100%'>" +
                "<h6 style='padding-right: 5%;padding-left:5%'>"+$message+"</h6>" +
                "</div>" +
                "");
        });
    }

    function additionalSick(radio_val,set_daterange){
        if(radio_val == 'Sick'){
            var additional_sick = '<ul>\n' +
                '                                                                Half day in first day? Please select.\n' +
                '                                                                <ul>\n' +
                '                                                                    <li>\n' +
                '                                                                        <label>\n' +
                '                                                                            <input type="radio" id="leave_type" value="AM" name="half_day_first" />\n' +
                '                                                                            AM sick\n' +
                '                                                                        </label>\n' +
                '                                                                        <label>\n' +
                '                                                                            <input type="radio" id="leave_type" value="PM" name="half_day_first" />\n' +
                '                                                                            PM sick\n' +
                '                                                                        </label>\n' + '<button type="button" onclick="clearHalfDaySickFirst();">Clear</button>' +
                '                                                                    </li>\n' +
                '                                                                </ul>\n' +
                '                                                                Half day in last day? Please select.\n' +
                '                                                                <ul>\n' +
                '                                                                    <li>\n' +
                '                                                                        <label>\n' +
                '                                                                            <input type="radio" id="leave_type" value="AM" name="half_day_last" />\n' +
                '                                                                            AM sick\n' +
                '                                                                        </label>\n' +
                '                                                                        <label>\n' +
                '                                                                            <input type="radio" id="leave_type" value="PM" name="half_day_last" />\n' +
                '                                                                            PM sick\n' +
                '                                                                        </label>\n' + '<button type="button" onclick="clearHalfDaySickLast();">Clear</button>' +
                '                                                                    </li>\n' +
                '                                                                </ul>\n' +
                '                                                        </ul>';
            $(".additional_sick").html(additional_sick);
            applyDaterangepicker(set_daterange);
        } else {
            $(".additional_sick").html('');
            applyDaterangepicker(set_daterange);
        }
    }

    function applyDaterangepicker(set_daterange){
        $('#inc_date').daterangepicker({
            locale: {
                format: 'MM/DD/YYYY'
            },
            minDate: set_daterange,
            startDate: set_daterange,
            endDate: set_daterange,
        }).on('apply.daterangepicker', function(ev, picker)
        {
            var start = moment(picker.startDate.format('YYYY-MM-DD')).add(1, 'days');
            var end   = moment(picker.endDate.format('YYYY-MM-DD')).add(1, 'days');
            var interval_days = end.diff(start,'days')+1; // returns correct number
            var applied_days = 0;
            var sub_date,day_name,leave_condition = '';

            for(var i = 0; i < interval_days; i++) {
                sub_date = end.subtract(1,'d').format('YYYY-MM-DD');
                day_name = days[new Date(sub_date).getDay()];
                if(day_name != "Saturday" && day_name != "Sunday"){
                    applied_days++;
                }
            }

            console.log("applied days:"+applied_days);
            var leave_balance_applied = applied_days * 8;

            var half_day_first = $('input[name="half_day_first"]:checked').val();
            var half_day_last = $('input[name="half_day_last"]:checked').val();

            if(half_day_first !== undefined){
                leave_balance_applied -= 4;
                applied_days -= 0.5;
            }
            if(half_day_last !== undefined){
                leave_balance_applied -= 4;
                applied_days -= 0.5;
            }
            if($main_leave == 'no'){
                leave_balance_applied = 0;
            }

            if( (leave_balance_applied <= 4 && radio_val =='Sick' ) || radio_val == 'Sick' ){
                leave_condition = sick_balance;
                $("#credit_used").val('sick_balance');
            }
            else if(radio_val == 'Vacation'){
                leave_condition = vacation_balance;
                $("#credit_used").val('vacation_balance');
            }
            else{
                leave_condition = 0;
                $("#credit_used").val('');
            }

            console.log(leave_balance_applied);
            console.log(leave_condition);

            if( leave_balance_applied <= leave_condition ){
                $("#applied_num_days").val(applied_days);
            }
            else {
                Lobibox.alert('error', //AVAILABLE TYPES: "error", "info", "success", "warning"
                    {
                        msg: "INSUFFICIENT LEAVE BALANCE"
                    });

                $("#applied_num_days").val('');
                $("#inc_date").val('');
                $("#credit_used").val('');
            }

        });
    }

</script>