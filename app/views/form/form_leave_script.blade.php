<script>
    var vacation_balance = "<?php echo Session::get('vacation_balance'); ?>";
    var sick_balance = "<?php echo Session::get('sick_balance'); ?>";

    function clearHalfDaySickFirst(){
        $('input[name="half_day_first"]:checked').attr('checked',false);
    }
    function clearHalfDaySickLast(){
        $('input[name="half_day_last"]:checked').attr('checked',false);
    }

    function countWorkingDays(working_days,days){
        var set_daterange = new Date();
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
</script>