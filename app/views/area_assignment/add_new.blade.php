<form action="{{ asset('area-assignment/add-area') }}" method="POST" class="form-submit form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="province" value="{{ $province }}">
    <div class="box box-info">
        <div class="box-body">
            <div class="form-group">
                <label class="col-sm-3 control-label">Name of Area:</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <textarea cols="40" class="form-control" name="areaName" required></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Latitude:</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input style="width: 163%" type="text" class="form-control" name="latitude"required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Longitude:</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input style="width: 163%" type="text" class="form-control" name="longitude"required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Radius:</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input style="width: 163%" type="number" min="0" class="form-control" name="radius"required>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
        <button type="submit" class="btn btn-success btn-submit" style="color:white;">Save</button>
    </div>
</form>