<?php
/*use App\Tracking;
use App\Tracking_Details;
use App\User as User;
use App\Http\Controllers\DocumentController as Doc;
use App\Section;*/
$route_no = Session::get('route_no');
$document = pdoController::search_tracking_master($route_no);
$tracking = pdoController::search_tracking_details($route_no);

?>
<html>
<title>Track Details</title>
<style>
    .upper, .info, .table {
        width: 100%;
    }
    .upper td, .info td, .table td {
        border:1px solid #000;
    }
    .upper td {
        padding:10px;
    }
    .info {
        margin-top: 90px;
    }
    .info td {
        padding: 5px;
        vertical-align: top;
    }
    .table th {
        border:1px solid #000;
    }
    .table td {
        padding: 5px;
        vertical-align: top;
    }
    .barcode {
        top: 130px;
        position: relative;
        left: -50%;
    }
    .route_no {
        font-size:1.2em;
        margin-left:70px;
    }

</style>
<body>
<div style="position: absolute; left: 50%;">
    <div class="barcode">
        <?php echo DNS1D::getBarcodeHTML(Session::get('route_no'),"C39E",1,43) ?>
        <font class="route_no">{{ $route_no }}</font>
    </div>
</div>
<table class="upper" cellpadding="0" cellspacing="0">
    <tr>
        <td width="20%"><center><img src="{{ asset('public/img/doh.png') }}" width="100"></center></td>
        <td width="60%">
            <center>
                <strong>Republic of the Philippines</strong><br>
                Department of Health - Regional Office 7<br>
                <h3 style="margin:0;">DOCUMENT TRACKING SYSTEM<br>(DTS)</h3>
            </center>
        </td>
        <!--
<td width="20%"><?php echo DNS2D::getBarcodeHTML(Session::get('route_no'), "QRCODE",5,5); ?></td>

                -->
        <?php $image_path = '/img/ro7.png'; ?>
        <td width="20%"><center><img src="{{ asset('public/img/ro7.png') }}" width="100"></center></td>
    </tr>

</table>

<table class="info" width="100%" cellspacing="0">
    <tr>
        <td width="30%">
            <strong>PREPARED BY:</strong><br>
            <?php $user = pdoController::user_search1($document['prepared_by']) ?>
            {{ $user['fname'].' '.$user['lname'] }}
            <br><br>
        </td>
        <td>
            <strong>SECTION:</strong><br>
            {{ pdoController::search_section($user['section'])['description'] }}
            <br><br>
        </td>
        <td width="30%">
            <strong>PREPARED DATE:</strong><br>
            {{ date('M d, Y',strtotime($document['prepared_date'])) }}
            <br><br>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <strong>DOCUMENT TYPE:</strong>
            Office Order
            <br>
            <br>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <strong>REMARKS / SUBJECT:</strong>
            {{ nl2br($document['description']) }}
            <br>
            <br>
        </td>
    </tr>
</table>

<table cellspacing="0" class="table">
    <tr>
        <th width="15%">DATE</th>
        <th width="35%">RECEIVED BY</th>
        <th width="35%">ACTION / REMARKS</th>
        <th width="15%">SIGNATURE</th>
    </tr>
    @foreach($tracking as $doc)
        @if($doc['received_by'] != $doc['delivered_by'])
            <tr>
                <td>{{ date('M d, Y', strtotime($doc['date_in'])) }}<br>{{ date('h:i A', strtotime($doc['date_in'])) }}</td>
                <td>
                    <?php $user = pdoController::user_search1($doc['received_by']) ?>
                    {{ $user['fname'].' '.$user['mname'].' '.$user['lname'] }}
                    <br>
                    <em>({{ pdoController::search_section($user['section'])['description'] }})</em>
                </td>
                <td>{{ $doc['action'] }}</td>
                <td></td>
            </tr>
        @endif
    @endforeach
    @for($i = count($tracking); $i <= 10; $i++)
        <tr>
            <td>&nbsp;<br><br></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    @endfor
</table>
</body>
</html>
