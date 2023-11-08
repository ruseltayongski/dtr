
<span id="cdo_updatev1" data-link="{{ asset('cdo_updatev1') }}"></span>
@if(isset($paginate_cancelled) and count($paginate_cancelled) >0)
    <div class="table-responsive" style="margin-top: -20px;">
        <table class="table table-list table-hover table-striped">
            <thead>
            <tr>
                <th></th>
                <th class="text-center">Route #</th>
                <th class="text-center">Reason</th>
                <th class="text-center">Inclusive Dates</th>
                <th class="text-center">Prepared Name</th>
                <th class="text-center">Beginning Balance</th>
                <th class="text-center" width="20%">Option</th>
            </tr>
            </thead>
            <tbody style="font-size: 10pt;">
            @foreach($paginate_cancelled as $row)
                <tr>
                    <td><a href="#track" data-link="{{ asset('form/track/'.$row->route_no) }}" data-route="{{ $row->route_no }}" data-toggle="modal" class="btn btn-sm btn-success col-sm-12" style="background-color:#9C8AA5;color:white;"><i class="fa fa-line-chart"></i> Track</a></td>
                    <td class="route-cell"><a class="title-info" data-backdrop="static" data-route="{{ $row->route_no }}" style="color: #f0ad4e;" data-link="{{ asset('/form/info/'.$row->route_no.'/cdo') }}" href="#document_info" data-toggle="modal">{{ $row->route_no }}</a></td>
                    <td>{{ $row->subject }}</td>
                    <td>
                        @if($row->applied_dates == null)
                            <?php
<<<<<<< HEAD
                            $hours = "";
                                if($row->cdo_hours == "cdo_am"){
                                    $hours = " (AM)";
                                }else if ($row->cdo_hours == "cdo_pm") {
                                    $hours = " (PM)";
                                } 
=======
                            $hours = " ";
                            if($row->cdo_hours == "cdo_am"){
                                $hours=" (AM)";
                            }else if($row->cdo_hours == "cdo_pm"){
                                $hours=" (PM)";
                            }
>>>>>>> e735085183a01eeb6d7c9e06a741db6d60c1c501
                            $start_date = date('M j, Y', strtotime($row->start));
                            $end_date = date('M j, Y', strtotime('-1 day', strtotime($row->end)));
                            $dateStrings = ($start_date == $end_date) ? "$start_date $hours" : "$start_date - $end_date $hours";
                            echo $dateStrings;
                            ?>
                        @else
                            <?php
                            $get_date = CdoAppliedDate::where('cdo_id', $row->id)->get();
                            $dateStrings=[];
                            if(count($get_date)>0){
<<<<<<< HEAD
                               foreach ($get_date as $index=>$dates){
                                $hours = "";
                                if($dates->cdo_hours == "cdo_am"){
                                    $hours = " (AM)";
                                }else if ($dates->cdo_hours == "cdo_pm") {
                                    $hours = " (PM)";
                                } 
                                $start_date = date('M j, Y', strtotime($dates->start_date));
                                $end_date = date('M j, Y', strtotime('-1 day', strtotime($dates->end_date)));
                                $dateStrings[] = ($start_date == $end_date) ? "$start_date $hours" : "$start_date - $end_date $hours";
                                }
                                echo implode(',<br>',$dateStrings); 
                            }else{
                                $hours = "";
                                if($row->cdo_hours == "cdo_am"){
                                    $hours = " (AM)";
                                }else if ($row->cdo_hours == "cdo_pm") {
                                    $hours = " (PM)";
                                } 
=======
                                foreach ($get_date as $index=>$dates){
                                    $hours = " ";
                                    if($dates->cdo_hours == "cdo_am"){
                                        $hours=" (AM)";
                                    }else if($dates->cdo_hours == "cdo_pm"){
                                        $hours=" (PM)";
                                    }
                                    $start_date = date('M j, Y', strtotime($dates->start_date));
                                    $end_date = date('M j, Y', strtotime('-1 day', strtotime($dates->end_date)));
                                    $dateStrings[] = ($start_date == $end_date) ? "$start_date $hours" : "$start_date - $end_date $hours";
                                }
                                echo implode(',<br>',$dateStrings);
                            }else{
                                $hours = " ";
                                if($row->cdo_hours == "cdo_am"){
                                    $hours=" (AM)";
                                }else if($row->cdo_hours == "cdo_pm"){
                                    $hours=" (PM)";
                                }
>>>>>>> e735085183a01eeb6d7c9e06a741db6d60c1c501
                                $start_date = date('M j, Y', strtotime($row->start));
                                $end_date = date('M j, Y', strtotime('-1 day', strtotime($row->end)));
                                $dateStrings = ($start_date == $end_date) ? "$start_date $hours" : "$start_date - $end_date $hours";
                                echo $dateStrings;
                            }
                            ?>
                        @endif
                    </td>
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
                    <td class="text-center"><span class="label label-warning"><i class="fa fa-frown-o"></i> Cancelled </span></td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {{ $paginate_cancelled->links() }}
@else
    <div class="alert alert-danger" role="alert"><span style="color:red;">Documents records are empty.</span></div>
@endif
