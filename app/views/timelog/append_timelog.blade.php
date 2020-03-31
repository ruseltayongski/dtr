<?php
    $log_type = explode("ñ",$elementId)[4];
    $disabled = '';
    $min = '';
    $max = '';
    switch ($log_type){
        case 'AM_IN':
            $min = '00:00:00';
            if($pm_in == 'empty')
                $max = '12:59:00';
            else
                $max = substr($pm_in, 0, -3);
            break;
        case 'AM_OUT':
            if($am_in == 'empty' || $am_in == 'dayoff' || $am_in == 'holiday'){
                $disabled = "disabled";
            } else {
                $min = substr($am_in, 0, -3);
                if($pm_in == 'empty')
                    $max = '16:59:00';
                else
                    $max = substr($pm_in, 0, -3);
            }
            break;
        case 'PM_IN':
            if($am_out == 'empty')
                $min = '12:00:00';
            else
                $min = substr($am_out, 0, -3);

            if($pm_out == 'empty')
                $max = '16:59:00';
            else
                $max = substr($pm_out, 0, -3);
            break;
        case 'PM_OUT':
            if($pm_in == 'empty' || $pm_in == 'dayoff' || $pm_in == 'holiday'){
                $disabled = "disabled";
            } else {
                $min = substr($pm_in, 0, -3);
                $max = '23:59:00';
            }
            break;
    }
?>
@if($disabled == 'disabled')
    <div class="alert alert-error">
        Please fill up {{ $log_type == 'AM_OUT' ? 'am in' : 'pm in' }} first
    </div>
@else
    <table class="table table-list table-hover table-striped">
        <tr>
            <td >Time Log:</td>
            <td >
                <input type="time" style="width: 100%" id="{{ $elementId.'time_log' }}" min="{{ $min }}" max="{{ $max }}" {{ $disabled }}>
            </td>
        </tr>
        <tr>
            <td >Office Order:</td>
            <td ><input type="number" style="width: 100%" min="-4" max="9999" id="{{ $elementId.'office_order' }}" {{ $disabled }}></td>
        </tr>
        <tr>
            <td >Travel Order:</td>
            <td ><input type="number" style="width: 100%" min="-4" max="9999" id="{{ $elementId.'travel_order' }}" {{ $disabled }}></td>
        </tr>
        <!--
        <tr>
            <td >Memorandum No:</td>
            <td ><input type="number" style="width: 100%" min="-4" max="9999" id="{{ $elementId.'memorandum_order' }}" {{ $disabled }}></td>
        </tr>
        -->
        @if( explode("ñ",$elementId)[3] != 'holiday' && explode("ñ",$elementId)[3] != 'dayoff' )
            <tr>
                <td >LEAVE:</td>
                <td >
                    <select name="" style="width: 100%" id="{{ $elementId.'leave' }}" class="form-control" {{ $disabled }}>
                        <option value="">Select Leave Type</option>
                        <option value="VACATION LEAVE">VACATION LEAVE</option>
                        <option value="SICK LEAVE">SICK LEAVE</option>
                        <option value="PATERNITY LEAVE">PATERNITY LEAVE</option>
                        <option value="MATERNITY LEAVE">MATERNITY LEAVE</option>
                        <option value="SPECIAL LEAVE">SPECIAL LEAVE</option>
                        <option value="FORCE LEAVE">FORCE LEAVE</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td >CDO:</td>
                <td ><input type="checkbox" name="{{ $elementId.'cdo' }}" style="width: 20%;transform: scale(1.5);" id="{{ $elementId.'cdo' }}" {{ $disabled }}></td>
            </tr>
            <tr>
                <td >JO BREAK:</td>
                <td ><input type="checkbox" name="{{ $elementId.'jobreak' }}" style="width: 20%;transform: scale(1.5);" id="{{ $elementId.'jobreak' }}" {{ $disabled }}></td>
            </tr>
        @endif
        <tr>
            <td >EMPTY:</td>
            <td ><input type="checkbox" name="{{ $elementId.'empty' }}" style="width: 20%;transform: scale(1.5);" id="{{ $elementId.'empty' }}"></td>
        </tr>
    </table>
@endif
