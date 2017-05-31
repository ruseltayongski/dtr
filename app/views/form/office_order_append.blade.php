<tr id="{{ $_GET['count'] }}">
    <td class="col-sm-3"><label>Inclusive Date and Area</label></td>
    <td class="col-sm-1">:</td>
    <td class="col-sm-8">
        <div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control" id="{{ 'inclusive'.$_GET['count'] }}" name="inclusive[]" placeholder="Input date range here..." required style="width: 40%">
            <textarea name="area[]" class="form-control" rows="1" placeholder="Input your area here..." style="resize: none;width: 40%;margin-left:2%" required></textarea>
            &nbsp;
            <button type="button" value="{{ $_GET['count'] }}" onclick="remove($(this))" class="btn btn-danger" style="color: white" ><span class="fa fa-close"></span></button>
        </div>
    </td>
</tr>
