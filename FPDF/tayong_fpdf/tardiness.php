<?php

    $result = [];
    if(isset($employeeList) and count($employeeList) > 0) {
        $GLOBALS['division'] = $employeeList[0]['division'];
        for($i = 0; $i < count($employeeList); $i++) {
            $name = $employeeList[$i]['lname'] . ', ' . $employeeList[$i]['fname'] . ' ' . $employeeList[$i]['mname'];
            $result[$i] = $pdf->simplifyDtr(strtoupper(utf8_encode($name)),$employeeList[$i]['userid'], $date_from,$date_to,$employeeList[$i]['sched']);
        }
    }

    $late_day_total = [];
    $employeeLate = [];
    foreach($result as $row){
        if(!empty($row["late_day_total"])){
            $late_day_total[$row["userid"]] = [
                $row["late_day_total"],
                $row["late_total"]
            ];
            $employeeLate[$row["userid"]] = $row;
        }
    }

    uasort($late_day_total,"Descending");
    $count = 0;
    foreach ($late_day_total as $key => $value){
        $pdf->printTardiness($employeeLate[$key],$count);
        $count++;
    }

    function Ascending($a, $b) {
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? -1 : 1;
    }

    function Descending($a, $b) {
        if ($a == $b) {
            return 0;
        }
        return ($a > $b) ? -1 : 1;
    }


    $pdf->Output();

?>