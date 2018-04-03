<div class="{{ $_GET['count'] }}">
    <hr>
    <div class="form-group" >
        <label class="col-sm-3 control-label green">Inclusive Date and Area</label>
        <div class="col-sm-9">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control" id="{{ 'inclusive'.$_GET['count'] }}" name="inclusive[]" placeholder="Input date range here..." required>
            </div>
        </div> 
    </div>

    <div class="form-group" id="{{ $_GET['count'] }}"> 
        <label class="col-sm-3 control-label green">Area</label>
        <div class="col-sm-9">
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-location-arrow"></i>
                </div>
                <textarea name="area[]" class="form-control" rows="1" placeholder="Input your area here..." style="resize: none;" required></textarea>
            </div>
        </div>
    </div>

    <div class="form-group" id="{{ $_GET['count'] }}">
        <label class="col-sm-3 control-label green">SO Time</label>
        <div class="col-sm-8">
            <select class="form-control" name="so_time[]" id="so_time">
                <option value="wholeday">wholeday</option>
                <option value="am">halfday / AM</option>
                <option value="pm">halfday / PM</option>
            </select>
        </div>
        <div class="col-sm-1" style="margin-top:1%;">
            <button type="button" value="{{ $_GET['count'] }}" onclick="remove_row($(this));" class="btn-xs btn-danger" style="color: white" ><span class="fa fa-close"></span></button>
        </div>
    </div>
</div>







