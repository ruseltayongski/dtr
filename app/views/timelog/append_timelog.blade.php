<table class="table table-list table-hover table-striped">
    <tr>
        <td >Time Log:</td>
        <td >
            <?php
                $log_type = explode("ñ",$elementId)[4];
                $disabled = '';
                $min = '';
                $max = '';
                switch ($log_type){
                    case 'AM_IN':
                        $min = '00:00:00';
                        $max = '12:59:00';
                        break;
                    case 'AM_OUT':
                        if($am_in == 'empty' || $am_in == 'dayoff' || $am_in == 'holiday'){
                            $disabled = "disabled";
                        } else {
                            $min = $am_in;
                            $max = '16:59:00';
                        }
                        break;
                    case 'PM_IN':
                        $min = '12:00:00';
                        $max = '16:59:00';
                        break;
                    case '':
                        if($pm_in == 'empty' || $pm_in == 'dayoff' || $pm_in == 'holiday'){
                            $disabled = "disabled";
                        } else {
                            $min = $pm_in;
                            $max = '12:59:00';
                        }
                    break;
                }
            ?>
            <input type="time" style="width: 100%" id="{{ $elementId.'time_log' }}" min="{{ $min }}" max="{{ $max }}" {{ $disabled }}>
        </td>
    </tr>
    <tr>
        <td >Office Order:</td>
        <td ><input type="number" style="width: 100%" min="-4" max="9999" id="{{ $elementId.'office_order' }}"></td>
    </tr>
    <tr>
        <td >CDO:</td>
        <td ><input type="checkbox" name="{{ $elementId.'cdo' }}" style="width: 20%;transform: scale(1.5);" id="{{ $elementId.'cdo' }}"></td>
    </tr>
    <tr>
        <td >LEAVE:</td>
        <td >
            <select name="" style="width: 100%" id="{{ $elementId.'leave' }}" class="form-control">
                <option value="">Select Leave Type</option>
                <option value="VACATION LEAVE">VACATION LEAVER</option>
                <option value="SICK LEAVE">SICK LEAVE</option>
                <option value="PATERNITY LEAVE">PATERNITY LEAVE</option>
                <option value="MATERNITY LEAVE">MATERNITY LEAVE</option>
                <option value="SPECIAL LEAVE">SPECIAL LEAVE</option>
                <option value="FORCE LEAVE">FORCE LEAVE</option>
            </select>
        </td>
    </tr>

</table>