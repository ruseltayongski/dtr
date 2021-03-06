<?php
$total = 0;
$item_no = 1;
?>
        <!DOCTYPE html>
<html>
<title>Office Order</title>
<head>
    <link href="{{ realpath(__DIR__ . '/../../..').'/public/assets/css/print.css' }}" rel="stylesheet">
    <style>
        html {
            margin-top: 5px;
            margin-right: 30px;
            margin-left: 30px;
            margin-bottom: 50px;
            font-size:x-small;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        #no-border{
            border-collapse: collapse;
            border: none;
        }
        #border-top{
            border-collapse: collapse;
            border-top: none;
        }
        #border-right{
            border-collapse: collapse;
            border:1px solid #000;
        }
        #border-bottom{
            border-collapse: collapse;
            border-bottom: none;
        }
        #border-bottom-t{
            border-collapse: collapse;
            border-top:1px solid red;
            border-bottom:1px solid red;
        }
        #border-left{
            border-collapse: collapse;
            border:1px solid #000;
        }
        .align{
            text-align: center;
        }
        .align-top{
            vertical-align : top;
        }
        .table1 {
            width: 100%;
            padding-left: 10px;
        }
        .table1 td {
            border:1px solid #000;
        }
        #padding-bottom {
            padding-bottom: 5px;
        }
        .footer {
            width: 100%;
            text-align: center;
            position: fixed;
        }
        .footer {
            bottom: 35px;
        }
        .pagenum:before {
            content: counter(page);
        }
        .pagenum:before {
            content: counter(page);
        }
        .new-times-roman{
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
        }
    </style>
</head>
<div class="footer">
    <hr>
    <div style="position:absolute; left: 25%;" class="align">
        <?php echo DNS1D::getBarcodeHTML(Session::get('route_no'),"C39E",1,28) ?>
        <font class="route_no">{{ Session::get('route_no') }}</font>
    </div>
    <div style="position:absolute;margin-top: 33px;" class="align">
        <i style="font-size: 6pt;">
            <?php
            $preparedDivision = pdoController::search_division(pdoController::user_search($office_order->prepared_by)['division'])['id'];
            if( isset($preparedDivision) ) {
                if($preparedDivision == 3)
                    $preparedDivision = 'RD / ARD';
                elseif($preparedDivision == 4)
                    $preparedDivision = 'LHSD';
                elseif($preparedDivision == 5)
                    $preparedDivision = 'RLED';
                elseif($preparedDivision == 6)
                    $preparedDivision = 'MSD';
                else
                    $preparedDivision = 'NoDivision';
            }
            else
                $preparedDivision = 'NoDivision';


            $preparedSection = pdoController::search_section(pdoController::user_search($office_order->prepared_by)['section'])['description'];
            $preparedName = InformationPersonal::where('userid','=',$office_order->prepared_by)->first()->lname;
            echo $preparedDivision.'/'.$preparedSection.'/'.str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($preparedName))));
            ?>
        </i>
    </div>
</div>
<body>
<div class="new-times-roman" style="margin-bottom: 25px;">
    <div style="position:absolute;margin-left: 191px;margin-top: 207px;">
        <b>:</b>
    </div>
    <table class="letter-head" cellpadding="0" cellspacing="0">
        <tr>
            <td id="no-border" class="align"><img src="{{ realpath(__DIR__ . '/../../..').'/public/img/doh.png' }}" width="100"></td>
            <td width="100%" id="no-border">
                <div class="align" style="font-size: 10.5pt">
                    Republic of the Philippines<br>
                    DEPARTMENT OF HEALTH<br>
                    <strong>CENTRAL VISAYAS CENTER for HEALTH DEVELOPMENT</strong><br>
                    Osmeña Boulevard,Sambag II,Cebu City, 6000 Philippines<br>
                    Regional Director’s Office Tel. No. (032) 253-6355 Fax No. (032) 254-0109<br>
                    Official Website: http://www.ro7.doh.gov.ph Email Address: dohro7@gmail.com<br>
                </div>
            </td>
            <td id="no-border" class="align"><img src="{{ realpath(__DIR__ . '/../../..').'/public/img/f1.jpg' }}" width="100"></td>
        </tr>
    </table>
    <hr>
    <table class="letter-head" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="4" id="no-border">
                <?php
                $monthA=array(array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec")
                ,array("January","February","March","April","May","June","July","August","September","October","November","December"));
                $m=date('M',strtotime($office_order->prepared_date));
                for($i=0;$i<count($monthA[0]);$i++){
                    if($m==$monthA[0][$i]){
                        $pos=$i;
                        break;
                    }
                }
                echo str_replace( $m,$monthA[1][$pos],date('d M Y',strtotime($office_order->prepared_date)) );
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="1" id="no-border" width="25%"><b>OFFICE ORDER</b></td>
            <td colspan="3" id="no-border" width="75%">)</td>
        </tr>
        <tr>
            <td colspan="1" id="no-border" width="25%">No.<h2 style="display: inline;"><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></h2>{{ 's., '.date('Y',strtotime($office_order->prepared_date)) }}&nbsp;&nbsp;<b></b></td>
            <td colspan="3" id="no-border" width="75%">)</td>
        </tr>
        <tr>
            <td colspan="1" id="no-border" class="align-top" width="25%"><b>SUBJECT:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u></u></td>
            <td colspan="3" id="no-border" width="75%"><u>{{ $office_order->subject }}</u></td>
        </tr>
        <tr>
            <td colspan="4" id="no-border">{{ nl2br($office_order->header_body) }}</td>
        </tr>
    </table>

    <?php
    $hrCount = 0;
    $inclusiveDateLength = count($inclusive_dates);
    $duplicateName = [];
    foreach( $inclusive_dates as $inclusive_date ) {
    $count = 0;
    unset($flag);
    $dateFlag = true;
    $dateStartEnd = '- <i>('.'<u>'.date('d M Y',strtotime($inclusive_date->start)).'</u>'.' to '.'<u>'.date('d M Y',strtotime($inclusive_date->end)).'</u>'.')</i>';
    foreach( $division as $div ) {
    foreach($name as $row) {
    if( $div['id'] == $row->division_id && !isset($flag[$div['id']]) ) {
    ?>
    <table class="table1" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="3" id="no-border"><b>{{ $div['description'] }} {{ $dateFlag ? $dateStartEnd : '' }} - {{ $inclusive_date->area }}</b></td>
        </tr>
        <tr>
            <td id="no-border padding-bottom" width="45%">
                <i>
                    Name
                </i>
            </td>
            <td id="no-border padding-bottom" width="45%">
                <i>
                    Designation
                </i>
            </td>
            <td id="no-border padding-bottom" width="20%">
                <i>
                    Employment Status
                </i>
            </td>
        </tr>
        <?php
        foreach($name as $details) {
        if( $div['id'] == $details->division_id) {
        //if(!array_key_exists($details->userid,$duplicateName))
        $count++;

        isset( $details->fname ) ? $fname = $details->fname : $fname = 'no fname in pis';
        $details->mname != '' ? $mname = strtoupper($details->mname[0]) : $mname = '';
        isset( $details->lname ) ? $lname = $details->lname : $lname = 'no lname in pis';
        $duplicateName[$details->userid] = $details->userid;
        ?>
        <tr>
            <td id="no-border">{{ $count.' '.$fname.' '.$mname.'. '.$lname }}</td>
            <td id="no-border">@if(isset(pdoController::designation_search($details->designation_id)['description'])) {{ pdoController::designation_search($details->designation_id)['description'] }} @endif</td>
            <td id="no-border">{{ $details->job_status }}</td>
        </tr>
        <?php
        }
        }
        if( $div['id'] == 6 ) {
        for( $i = 0; $i < $office_order->driver; $i++ ) {
        $count++;
        ?>
        <tr>
            <td id="no-border">{{ $count }}.<b>____________________</b></td>
            <td id="no-border">Driver</td>
            <td id="no-border">Job Order</td>
        </tr>
        <?php
        }
        $stopDriver = true;
        }
        ?>
    </table>
    <br>
    <?php
    $flag[$div['id']] = true;
    $dateFlag = false; //To minimize the redundant division id
    }
    }
    }

    $hrCount++;
    if($hrCount != $inclusiveDateLength){
        echo '<hr>';
    }
    }
    if( $office_order->driver > 0 and !isset($stopDriver) ) {
    ?>
    <table class="table1" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="3" id="no-border"><b>{{ Division::find(6)->description }}</b></td>
        </tr>
        <tr>
            <td id="no-border padding-bottom" width="45%">
                <i>
                    Name
                </i>
            </td>
            <td id="no-border padding-bottom" width="45%">
                <i>
                    Designation
                </i>
            </td>
            <td id="no-border padding-bottom" width="10%">
                <i>
                    Job Status
                </i>
            </td>
        </tr>
        <?php
        for( $i = 0; $i < $office_order->driver; $i++ ) {
        $count++;
        ?>
        <tr>
            <td id="no-border">{{ $count }}.<b>____________________</b></td>
            <td id="no-border">Driver</td>
            <td id="no-border">Job Order</td>
        </tr>
        <?php
        }
        ?>
    </table>
    <?php
    }

    foreach($name as $row) {
    if( $row['division_id'] == '' ) {
    ?>
    <table class="table1" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="3" id="no-border"><b>NO DIVISION</b></td>
        </tr>
        <tr>
            <td id="no-border padding-bottom" width="45%">
                <i>
                    Name
                </i>
            </td>
            <td id="no-border padding-bottom" width="45%">
                <i>
                    Designation
                </i>
            </td>
            <td id="no-border padding-bottom" width="10%">
                <i>
                    Job Status
                </i>
            </td>
        </tr>

        <?php
        foreach($name as $row) {
        if( $row['division_id'] == '' ) {
        $count++;
        isset( $row['fname'] ) ? $fname = $row['fname'] : $fname = 'no fname';
        $row['mname'] != '' ? $mname = $row['mname'] : $mname = '';
        isset( $row['lname'] ) ? $lname = $row['lname'] : $lname = 'no lname';
        ?>
        <tr>
            <td id="no-border">{{ $count.' '.$fname.' '.$mname.' '.$lname }}</td>
            <td id="no-border">@if(isset(pdoController::designation_search($row['designation_id'])['description'])) {{ pdoController::designation_search($row['designation_id'])['description'] }} @endif</td>
            <td id="no-border">{{ $row['job_status'] }}</td>
        </tr>
        <?php
        }
        }
        ?>
    </table>
    <?php
    break;
    }
    }
    ?>

    <table class="letter-head" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="3" id="no-border">{{ nl2br($office_order->footer_body) }}</td>
        </tr>
        <tr>
            <td id="no-border"></td>
        </tr>
        <tr>
            <td colspan="3" id="no-border">
                <b>
                    {{ $office_order->approved_by }}
                </b><br>
                <?php
                if($office_order->approved_by == 'Jaime S. Bernadas, MD, MGM, CESO III')
                    echo 'Director IV';
                elseif($office_order->approved_by == 'Ellenietta HMV N. Gamolo,MD,MPH,CESE')
                    echo 'Director III';
                else
                    echo 'Director III';
                ?>
            </td>
        </tr>
    </table>
</div>
</body>
</html>