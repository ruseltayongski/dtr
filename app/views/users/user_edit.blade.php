@if(isset($user))
    <form action="{{ asset('user/edit') }}" method="POST" id="create">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="hidden" name="id" value="6" />
        <div class="modal-body">
            <table class="table table-hover table-form table-striped">
                <tr>
                    <td class="col-sm-3"><label>Region {{ $user->region }}</label></td>
                    <td class="col-sm-1">:</td>
                    <td class="col-sm-8">
                        <select class="form-control" name="region" required>
                            <option <?php if($user->region=='region_7') echo 'selected'; ?> value="region_7">Region 7</option>
                            <option <?php if($user->region=='region_8') echo 'selected'; ?> value="region_8">Region 8</option>
                            <option <?php if($user->region=='region_10') echo 'selected'; ?> value="region_10">Region 10</option>
                            <option <?php if($user->region=='region_12') echo 'selected'; ?> value="region_12">Region 12</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-3"><label>Field Status</label></td>
                    <td class="col-sm-1">:</td>
                    <td class="col-sm-8">
                        <select class="form-control" name="field_status" required>
                            <option value="region">Region Employee</option>
                            <option value="hrh">HRH Employee</option>
                        </select>
                    </td>
                </tr>
                @if(Auth::user()->usertype == "1")
                    <tr>
                        <td class="col-sm-3"><label>Usertype:</label></td>
                        <td class="col-sm-1">:</td>
                        <td class="col-sm-8">
                            <select name="usertype" class="form-control">
                                <option value="{{ $usertype_default["value"] }}">{{ $usertype_default["description"] }}</option>
                                @foreach($usertype as $row)
                                    @if($user->usertype != $row["value"])
                                        <option value="{{ $row["value"] }}">{{ $row["description"] }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>
                @endif
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
                <tr>
                    <td class="col-sm-3"><label>IMEI</label></td>
                    <td class="col-sm-1">:</td>
                    <td class="col-sm-8">
                        <input type="text" name="imei" value="{{ $user->imei }}" class="form-control">
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-3"><label>Authority</label></td>
                    <td class="col-sm-1">:</td>
                    <td class="col-sm-8">
                        <select name="authority" id="authority" class="form-control">
                            <option value="">None...</option>
                            <option <?php if($user->authority=='reset_password') echo 'selected'; ?> value="reset_password">Reset Password</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-3"><label>User Roles</label></td>
                    <td class="col-sm-1">:</td>
                    <td class="col-sm-8">
                        <select class="form-control select2 user_roles" multiple="multiple" name="user_roles[]" data-placeholder="Select user roles" style="width: 100%">
                            @foreach($user_claim as $claim)
                                <option value='{{ $claim->id }}'>{{ $claim->claim_type }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="col-sm-3"><label>Area of Assignment</label></td>
                    <td class="col-sm-1">:</td>
                    <td class="col-sm-8">
                        <select class="form-control select2 assigned_areas" multiple="multiple" name="assigned_area[]" data-placeholder="Select areas of assignment" style="width: 100%">
                            @foreach($assignment_areas as $area)
                                <option value='{{ $area->id }}'>{{ $area->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
            <a href="{{ asset('mobileV3/area_of_assignment/'.$user->userid) }}" class="btn btn-success" name="getArea" target="_blank" style="color: white;">
                <i class="fa fa-map-marker">&nbsp; Get Area Coordinates</i>
            </a>
            <button type="submit" class="btn btn-success user_add" id="update_user" name="update" value="update"><i class="fa fa-send"></i>Update</button>
        </div>
    </form>
@endif
<script>
    $('.chosen-select').chosen();
    $('.select2').select2();

    var user_roles = <?php echo $user_roles; ?>;
    function getClaimsId(data) {
        var claims_id = [data.claims_id].join(" ");
        return claims_id;
    }
    $('.user_roles').val(user_roles.map(getClaimsId)).trigger('change');

    var assigned_areas = <?php echo $assigned_areas; ?>;
    function getAreaId(data) {
        var area_of_assignment_id = [data.area_of_assignment_id].join(" ");
        return area_of_assignment_id;
    }
    $('.assigned_areas').val(assigned_areas.map(getAreaId)).trigger('change');    

</script>
