<table class="table table-list table-hover table-striped">
    <tr>
        <td >Time Log:</td>
        <td ><input type="time" style="width: 100%" id="{{ $id.'time_log' }}"></td>
    </tr>
    <tr>
        <td >Office Order:</td>
        <td ><input type="number" style="width: 100%" min="-4" max="9999" id="{{ $id.'office_order' }}"></td>
    </tr>
    <tr>
        <td >CDO:</td>
        <td ><input type="checkbox" name="{{ $id.'cdo' }}" style="width: 20%;transform: scale(1.5);" id="{{ $id.'cdo' }}"></td>
    </tr>
    <tr>
        <td >LEAVE:</td>
        <td >
            <select name="" style="width: 100%" id="{{ $id.'leave' }}" class="form-control">
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