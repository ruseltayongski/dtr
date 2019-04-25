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
        <td ><input type="checkbox" value="cdo" style="width: 20%;transform: scale(1.5);" id="{{ $id.'cdo' }}"></td>
    </tr>
    <tr>
        <td >LEAVE:</td>
        <td >
            <select name="" style="width: 100%" id="{{ $id.'leave' }}" class="form-control">
                <option value="Vacation Leave">Vacation Leave</option>
                <option value="Sick Leave">Sick Leave</option>
            </select>
        </td>
    </tr>

</table>