<center>
    <form action="{{ asset('form/absent') }}" method="POST">
        <input type="text" class="form-control" id="absent" name="absent" placeholder="Input date range here..." required>
        <br>
        <button type="submit" class="btn btn-danger" style="color:white;"><i class="fa fa-send"> Submit Absent</i></button>
    </form>
</center>
<script>
    $(function(){
        $("body").delegate("#absent","focusin",function(){
            $(this).daterangepicker();
        });
    });
</script>