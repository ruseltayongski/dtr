<form action="{{ asset('create/flixe') }}" method="POST">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <div class="modal-body">
        <table class="table table-hover table-form table-striped">
            <tr>
                <td class="col-sm-3"><label>Prepared By</label></td>
                <td class="col-sm-1">:</td>
                <td class="col-sm-8"><input type="text" disabled value="{{ Auth::user()->fname }} {{ Auth::user()->mname }} {{ Auth::user()->lname }}" class="form-control"></td>
            </tr>
            <tr>
                <td class=""><label>Prepared Date</label></td>
                <td>:</td>
                <td><input type="text" disabled value="{{ date('m/d/Y h:i:s A') }}"  class="form-control"></td>
            </tr>
            <tr>
                <td class=""><label>Time</label></td>
                <td>:</td>
                <td>
                    <input id="input-a" value="" data-default="20:48" class="form-control">
                </td>
            </tr>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
        <button type="submit" class="btn btn-success" onclick="$('form').attr('taraget','');"><i class="fa fa-send"></i> Submit</button>
    </div>
</form>
