
<form action="{{ asset('area-assignment/update')  }}" method="POST" class="form-submit form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="id" value="{{ $area->id }}">
    <div class="box box-info">
        <div class="box-body">
            <div class="form-group">
                <label class="col-sm-3 control-label">Name of Area</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <input type="text" class="form-control" value="{{ $area->name }}" name="areaName"required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Latitude</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="text" class="form-control" value="{{ $area->latitude }}"name="latitude"required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Longitude</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="text" class="form-control" value="{{ $area->longitude }}"name="longitude"required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Radius</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="number" min="0" class="form-control" value="{{ $area->radius }}"name="radius"required>
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