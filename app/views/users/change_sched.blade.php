<form action="{{ asset('change/work-schedule') }}" method="POST">

    <div class="modal-body">
        <table class="table table-hover table-form table-striped">
            <tr>
                <td class="col-sm-3"><label>User ID</label></td>
                <td class="col-sm-1">:</td>
                <td class="col-sm-8"><input type="text" name="prepared_by" class="form-control" value="{{ $user->userid }}" readonly></td>
            </tr>
            <tr>
                <td class="col-sm-3"><label>Name</label></td>
                <td class="col-sm-1">:</td>
                <td class="col-sm-8"><input type="text" name="routed_from" class="form-control" value="{{ $user->fname . " " . $user->lname }}"></td>
            </tr>
            <tr>
                <td class="col-sm-3"><label>Select Working Schedule</label></td>
                <td class="col-sm-1">:</td>
                <td class="col-sm-8">
                    <select class="form-control input-lg" name="schedule_id">
                        @if(isset($sched) and count($sched) > 0)
                            @foreach($sched as $s)
                                <option value="{{ $s->id }}" {{ ($s->id == $user->sched ? 'selected' : '') }}>{{ $s->description }}</option>
                            @endforeach
                        @endif
                    </select>
                </td>
            </tr>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> Submit</button>
    </div>
</form>