@if(isset($user))
    <form action="{{ asset('user/edit') }}" method="POST" id="create">
        <input type="hidden" name="id" value="6" />
        <div class="modal-body">
            <table class="table table-hover table-form table-striped">
                <tr>
                    <td class="col-sm-3"><label>First name</label></td>
                    <td class="col-sm-1">:</td>
                    <td class="col-sm-8"><input type="text" name="fname" value="{{ $user->fname }}" class="form-control" required></td>
                </tr>
                <tr>
                    <td class="col-sm-3"><label>Middle name</label></td>
                    <td class="col-sm-1">:</td>
                    <td class="col-sm-8"><input type="text" name="mname" value="{{ $user->mname }}" class="form-control"></td>
                </tr>
                <tr>
                    <td class="col-sm-3"><label>Last name</label></td>
                    <td class="col-sm-1">:</td>
                    <td class="col-sm-8"><input type="text" name="lname" value="{{ $user->lname }}" class="form-control" required></td>
                </tr>
                <tr>
                    <td class="col-sm-3"><label>Username</label></td>
                    <td class="col-sm-1">:</td>
                    <td class="col-sm-8">
                        <input type="text" name="username" value="{{ $user->username }}" class="form-control" onblur="checkUser(this);" data-link="http://localhost:8000/dtsv3.0/check/user"required>
                    </td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
            <button type="submit" class="btn btn-success user_add" id="update_user" name="update" value="update"><i class="fa fa-send"></i>Update</button>
        </div>
    </form>
@endif
<script>
    $('.chosen-select').chosen();
</script>
