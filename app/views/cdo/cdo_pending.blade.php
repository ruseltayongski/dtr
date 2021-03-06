<span id="cdo_updatev1" data-link="{{ asset('cdo_updatev1') }}"></span>
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
                <th class="text-center" width="10%">Option</th>
            </tr>
            </thead>
            <tbody style="font-size: 10pt;">
            @foreach($paginate_pending as $row)
                <tr>
                    <td><a href="#track" data-link="{{ asset('form/track/'.$row->route_no) }}" data-route="{{ $row->route_no }}" data-toggle="modal" class="btn btn-sm btn-success col-sm-12" style="background-color:#9C8AA5;color:white;"><i class="fa fa-line-chart"></i> Track</a></td>
                    <td><a class="title-info" data-backdrop="static" data-route="{{ $row->route_no }}" style="color: #f0ad4e;" data-link="{{ asset('/form/info/'.$row->route_no.'/cdo') }}" href="#document_info" data-toggle="modal">{{ $row->route_no }}</a></td>
                    <td>{{ $row->subject }}</td>
                    <td><?php if(isset($row->start)) echo date('m/d/Y',strtotime($row->start)).' - '.date('m/d/Y',strtotime('-1 day',strtotime($row->end))); ?></td>
                    <td>
                        <?php
                        $personal_information = InformationPersonal::where('userid','=',$row['prepared_name'])->first();
                        echo $personal_information->fname.' '.$personal_information->mname.' '.$personal_information->lname;
                        ?>
                    </td>
                    <td class="text-center">
                        <b style="color:green;">
                            {{ $personal_information->bbalance_cto }}
                        </b>
                    </td>
                    <td><button type="submit" class="btn-xs btn-info" value="{{ $row->id }}" onclick="pending_status($(this))" style="color:white;"><i class="fa fa-smile-o"></i> Approve</button></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $paginate_pending->links() }}
@else
    <div class="alert alert-danger" role="alert"><span style="color:red;">Documents records are empty.</span></div>
@endif

