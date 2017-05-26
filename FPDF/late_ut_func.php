<?php


function late($s_am_in,$s_pm_in,$am_in,$pm_in,$datein)
{
    $hour = 0;
    $min = 0;
    $total = 0;

    if(isset($am_in) and $am_in != '' || $am_in != null) {
        if(strtotime($am_in) > strtotime($s_am_in)) {
            $a = new DateTime($datein.' '. $am_in);
            $b = new DateTime($datein.' '. $s_am_in);

            $interval = $a->diff($b);
            $hour1 = $interval->h;
            $min1 = $interval->i;


            if($hour1 > 0) {
                $hour1 = $hour1 * 60;
            }
            $total += ($hour1 + $min1);
        }

    }

    if(isset($pm_in) and $pm_in != '' || $pm_in != null) {
        if(strtotime($pm_in) > strtotime($s_pm_in)) {
            $a = new DateTime($datein.' '.$pm_in);
            $b = new DateTime($datein.' '.$s_pm_in);

            $interval = $a->diff($b);
            $hour2 = $interval->h;
            $min2 = $interval->i;


            if($hour2 > 0) {
                $hour2 = $hour2 * 60;
            }

            $total += ($hour2 + $min2);
        }
    }

    if($total == 0) $total = '';
    return $total;

}

function undertime($s_am_in,$s_pm_in,$am_in,$pm_in,$s_am_out,$s_pm_out,$am_out,$pm_out,$datein)
{

    $hour = '';
    $min = '';
    $total = '';

    if($am_in == '' and $am_out == '') {
        $a = new DateTime($datein.' '. $s_am_in);
        $b = new DateTime($datein.' '. $s_am_out);

        $interval = $b->diff($a);
        $hour1 = $interval->h;
        $min1 = $interval->i;

        if($hour1 > 0) {
            $hour1 = $hour1 * 60;
        }
        $total += ($hour1 + $min1);

    }

    if($pm_in == '' and $pm_out == '') {

        $a = new DateTime($datein.' '. $s_pm_in);
        $b = new DateTime($datein.' '. $s_pm_out);

        $interval = $b->diff($a);
        $hour2 = $interval->h;
        $min1 = $interval->i;

        if($hour2 > 0) {
            $hour2 = $hour2 * 60;
        }
        $total += ($hour2 + $min1);

    }

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
            $total += ($hour1 + $min1);
        }
    }
    if(isset($pm_out) and $pm_out != '' || $pm_out != null) {

        if(strtotime($pm_out) < strtotime($s_pm_out)) {
            $hour2 = 0;
            $a = new DateTime($datein.' '.$pm_out);
            $b = new DateTime($datein.' '.$s_pm_out);

            $interval = $b->diff($a);
            $hour2 = $interval->h;
            $min2 = $interval->i;

            if($hour2 > 0) {
                $hour2 = $hour2 * 60;
            }
            $total += ($hour2 + $min2);
        }
    }
    if($total == 0 ) $total = '';
    return $total;
}


?>