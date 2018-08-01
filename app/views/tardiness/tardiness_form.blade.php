<form action="{{ asset('FPDF/print_tardiness.php') }}" method="POST" class="tardiness_form" target="_blank">
    <div class="modal-body" id="tardiness_content">
        @include('tardiness.tardiness_content')
    </div>
    <div class="modal-footer" id="modal_footer">
        <button type="button" class="btn btn-info" id="tardiness_generate"><i class="ace-icon fa fa-list-ol bigger-160"></i> Generate</button>
    </div>
</form>

<script>
    $("#tardiness_view").click(function() {
        $(".tardiness_form").attr("action", "{{ asset('FPDF/print_tardiness.php') }}");
    });
    $("#tardiness_generate").click(function() {

        var url = "<?php echo asset('tardiness_generate'); ?>";
        var month = $("#month").val();
        var year = $("#year").val();
        var json = {
            "month" : month,
            "year" : year,
            "_token" : "<?php echo csrf_token(); ?>",
        };

        $('#tardiness_content').html(loadingState);
        $.post(url,json,function(result){
            $('#tardiness_content').html(result);
            $('#modal_footer').append('<button type="submit" class="btn btn-success" id="tardiness_view"><i class="ace-icon fa fa-folder bigger-160"></i> View</button>');
            Lobibox.notify('info',{
                msg:'Successfully generated tardiness'
            });
        });
    });
</script>
