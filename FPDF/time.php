<?php

    

$hour = '';
$min = '';
$total = '';

$s_am_out = '12:00:00';
$am_out = '09:30:00';


$s_pm_out = '17:00:00';
$pm_out = '17:00:00';



$datein = '2017-03-31';
$hour1 = '';
$hour2 = '';
$min1 = '';
$min2 = '';

if(isset($am_out) and $am_out != '' || $am_out != null) {
    if(strtotime($am_out) < strtotime($s_am_out)) {
        $a = new DateTime($datein.' '. $am_out);
        $b = new DateTime($datein.' '. $s_am_out);

        $interval = $b->diff($a);
        $hour1 = $interval->h;
        $min1 = $interval->i;


        if($hour1 > 0) {
            $hour1 = $hour1 * 60;
        }
        echo "Hour1 :  ". $hour1;
        echo "<br />";
        echo "Min1 :   ". $min1;
        echo "<br />";
        
        $total += ($hour1 + $min1);
    }
}

if(isset($am_out) and $pm_out != '' || $pm_out != null) {
    if(strtotime($pm_out) < strtotime($s_pm_out)) {
        $a = new DateTime($datein.' '.$pm_out);
        $b = new DateTime($datein.' '.$s_pm_out);

        $interval = $b->diff($a);
        $hour2 = $interval->h;
        $min2 = $interval->i;


        if($hour2 > 0) {
            $hour2 = $hour2 * 60;
        }

        echo "Hour2 :  ". $hour2;
        echo "<br />";
        echo "Min2 :   ". $min2;
        echo "<br />";
        $total += ($hour2 + $min2);
    }
}

echo "Total : " .$total;
?>