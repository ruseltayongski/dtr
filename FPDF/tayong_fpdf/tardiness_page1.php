<?php

    $GLOBALS['rank'] = 0;

    //Table with 20 rows and 4 columns
    $pdf->SetWidths(array(15,20,55,45,22,15,19));
    srand(microtime()*1000000);
    $pdf->SetFont('Arial','',10);
    $pdf->Row(array("RANK","ID #","NAME","POSITION","STATUS","DAYS","MINUTES"));
    $GLOBALS['rank']++;
    $pdf->SetFont('Arial','',8);

    foreach(tardiness_view($_POST['year'],$_POST['month']) as $row )
    {
        if( $row['userid'] != '200400037' && $row['position'] == 'Computer Maintenance Technologist III' ){
            $position = "No Position";
        } else {
            $position = $row['position'];
        }

        $pdf->Row(array($GLOBALS['rank'],$row['userid'],utf8_decode(str_replace("??","ñ",$row['name'])),$position,$row['employee_status'],$row['tardiness_day'],$row['tardiness_min']));
        $GLOBALS['rank']++;
    }


    $pdf->Output();

    function tardiness_view($year,$month)
    {
        $pdo = pis_con();
        try {
            //$st = $pdo->prepare("SELECT CAST(tardiness.tardiness_min as DECIMAL(9,2)) tardiness_min,tardiness.userid,tardiness.tardiness_day,personal_information.lname,personal_information.fname,personal_information.mname,personal_information.designation_id,personal_information.division_id,personal_information.section_id FROM `tardiness` left join personal_information on personal_information.userid = tardiness.userid where tardiness.year = ? and tardiness.month = ? order by tardiness_min desc");
            $st = $pdo->prepare("SELECT CAST(tardiness.tardiness_min as DECIMAL(9,2)) as tardiness_min,userid,name,position,division,section,employee_status,tardiness_day FROM tardiness where year = ? and month = ? and tardiness_day != 0 order by tardiness_min desc");

            $st->execute(array($year,$month));
            $row = $st->fetchAll(PDO::FETCH_ASSOC);
            if(isset($row) and count($row) > 0)
            {
                $pdo = null;
                return $row;
            }
        }catch(PDOException $ex)
        {
            echo $ex->getMessage();
            exit();
        }
    }


?>