<input type="hidden" value="{{ csrf_token() }}" name="_token">
<meta name="csrf-token" content="{{ csrf_token() }}">   
<div>
    <div>
        <select class="form-control" id="leave_priviledge_data" name="leave_priviledge_data[]" style="width:100%" multiple>
            <option value="">Select User(s)</option>
            @foreach($users as $row)
                <option value="{{ $row->userid }}" {{ in_array((string)$row->userid, array_map('strval', $privs)) ? 'selected' : '' }}>
                    {{ $row->userid .' - '. $row->fname .' '. $row->lname }}
                </option>
            @endforeach
        </select>
    </div>
</div>
<script>
    $('#leave_priviledge_data').select2({
        placeholder: 'Select User(s)',
        width: '100%',
        dropdownParent: $('#leave_priviledge') 
    });
</script>
