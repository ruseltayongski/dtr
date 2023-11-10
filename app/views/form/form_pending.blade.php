
{{--<span id="cdo_updatev1" data-link="{{ asset('cdo_updatev1') }}"></span>--}}
@if(isset($paginate_pending) and count($paginate_pending) >0)
    <div class="table-responsive" style="margin-top: -20px;">
        <label style="padding-bottom: 10px;">Check to select all to approve </label>
        <input type="checkbox" id="click_approve">
        <label class="button" style="font-weight: normal !important;"></label>
        <table class="table table-list table-hover table-striped">
            <thead>
            <tr>
                <th></th>
                <th class="text-center">Route #</th>
                <th class="text-center">Reason</th>
                <th class="text-center">Inclusive Dates</th>
                <th class="text-center">Prepared Name</th>
                <th class="text-center">Beginning Balance</th>
                <th class="text-center">Option</th>
            </tr>
            </thead>
            <tbody style="font-size: 10pt;">

            </tbody>
        </table>
    </div>
    {{ $paginate_pending->links() }}
@else
    <div class="alert alert-danger" role="alert"><span style="color:red;">Documents records are empty.</span></div>
@endif

<script>
</script>