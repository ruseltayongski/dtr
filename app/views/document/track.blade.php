
@if(count($document))

    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th width="25%">Received By</th>
            <th width="25%">Date In</th>
            <th width="25%">Duration</th>
            <th width="25%">Remarks</th>
        </tr>
        </thead>
        <tbody>
        <?php $data = array(); ?>
        @foreach($document as $doc)
            <?php
            $user = pdoController::user_search1($doc['received_by']);
            $data['received_by'][] = $user['fname'].' '.$user['lname'];
            $data['section'][] = pdoController::search_section($user['section'])['description'];
            $data['date'][] = $doc['date_in'];
            $data['date_in'][] = date('M d, Y', strtotime($doc['date_in']));
            $data['time_in'][] = date('h:i A', strtotime($doc['date_in']));
            $data['remarks'][] = $doc['action'];
            $data['status'][] = $doc['status'];
            ?>
        @endforeach
        @for($i=0;$i<count($data['received_by']);$i++)
            <tr>
                <td>{{ $data['received_by'][$i] }}
                    <br>
                    <em>({{ $data['section'][$i] }})</em>
                </td>
                <td>
                    {{ $data['date_in'][$i] }}
                    <br>
                    {{ $data['time_in'][$i] }}
                </td>
                <td>
                    <?php
                    $count = count($data['date']) - 1;
                    $next = true;
                    if($count>$i){
                        $date = $data['date'][$i+1];
                        $next = false;
                    }else{
                        $date = date('Y-m-d H:i:s');
                    }
                    ?>
                    @if($next && $data['status'][$i]==1)
                        Cycle End
                    @else
                        {{ ReleaseController::duration($data['date'][$i],$date) }}
                    @endif
                </td>
                <td>{{ nl2br($data['remarks'][$i]) }}</td>
            </tr>
        @endfor
        </tbody>
    </table>
@else
    <div class="alert alert-danger">
        <i class="fa fa-times"></i> No tracking history!
    </div>
@endif