<style>
    .table-info tr td:first-child {
        font-weight:bold;
        color: #2b542c;
    }
</style>
<form action="{{ asset('document/update') }}" method="post" class="form-submit">
    {{ csrf_field() }}
    <table class="table table-hover table-striped table-info">
        <tr>
            <td class="text-right col-lg-4">Document Type :</td>
            <td class="col-lg-8">Office Order</td>
        </tr>
        <tr>
            <td class="text-right">Subject :</td>
            <td>{{ $info->subject }}</td>
        </tr>
    </table>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
        <a href="{{ asset('form/so_view') }}" class="btn btn-warning"><i class="fa fa-barcode"></i> View Document</a>
        <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#deleteDocument"><i class="fa fa-trash"></i> Remove</button>
    </div>
</form>

<script>
    $('.daterange').daterangepicker();
</script>
