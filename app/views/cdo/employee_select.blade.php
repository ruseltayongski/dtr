<select class="form-control select_supervise" multiple="multiple" name="privilege_employee[]" style="width: 100%">
    @foreach(User::get() as $personnel)
        <option value='{{ $personnel->userid }}'>{{ $personnel->fname.' '.$personnel->mname.' '.$personnel->lname }}</option>
    @endforeach
</select>
<script>
    $('.select_supervise').select2();
    $('.select_supervise').val(<?php echo $supervised_employee; ?>).trigger('change');
</script>