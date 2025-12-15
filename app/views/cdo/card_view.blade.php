<table class="table  table-list table-hover table-striped" id="card_table" style="width: 100%; font-size: 14px; margin-bottom:0px">
    <thead  style="position: sticky; top: 0; z-index: 5; background-color: green">
    <tr>
        <th style="align-items: center; color: white; background-color: darkgray;" colspan="5">No. Of Hours Earned/Beginning Balance</th>
        <th style=" color: white;background-color: darkgray;">Date of Overtime</th>
        <th style=" color: white;background-color: darkgray;">No. of Hours Used</th>
        <th style="width: 20%; color: white;background-color: darkgray;">Date Used</th>
        <th style=" color: white;background-color: darkgray;">Balance Credits</th>
        <th style=" color: white;background-color: darkgray;">As Of</th>
        <th style=" color: white;background-color: darkgray;">Remarks</th>
    </tr>
    </thead>
    <tbody id="t_body" name="t_body">
    @if(isset($card_view) and count($card_view) >0)
        @foreach($card_view as $card_viewL)
            @if($card_viewL->status != 5)
                <tr>
                    @if($card_viewL->ot_hours !== null)
                        <td>@if($card_viewL->ot_hours != null) {{$card_viewL->ot_hours}} @endif</td>
                        <td>@if($card_viewL->ot_hours != null) x @endif</td>
                        <td>@if($card_viewL->ot_rate != null) {{$card_viewL->ot_rate}} @endif</td>
                        <td>@if($card_viewL->ot_hours != null) = @endif</td>
                        <td>@if($card_viewL->ot_credits != null) {{$card_viewL->ot_credits}} @endif</td>
                    @else
                        <td></td><td></td><td></td><td></td><td></td>
                    @endif
                    <td style="text-align: left">
                        @if($card_viewL->ot_date == null || $card_viewL->ot_date == '0000-00-00')
                        @else
                            {{ date('F j, Y', strtotime($card_viewL->ot_date)) }}
                        @endif
                    </td>
                    <td>@if($card_viewL->hours_used != 0 ) {{$card_viewL->hours_used}} @endif</td>
                    <td style="text-align: left"> <?php

                        if(!Empty($card_viewL->date_used) ){
                            $created = strtotime($card_viewL->created_at);
                            $condition = strtotime('2023-10-25');
                            if($created<=$condition){
                                $dateRanges = explode(",", $card_viewL->date_used);
                                $datelist = [];
                                foreach ($dateRanges as $date){
                                    $pattern = '/(\d{1,2}\/\d{1,2}\/\d{4}) - (\d{1,2}\/\d{1,2}\/\d{4}(?: \([^)]*\))?)/';

                                    if(preg_match($pattern, $date, $matches)){
                                        $startDate = $matches[1];
                                        $endDate = $matches[2];
                                        $add_ons = isset($matches[3])? $matches[3]: '';
                                        $endDate2 = preg_replace('/ \([^)]*\)/', '', $matches[2]);
                                        $diff= (strtotime($startDate)- strtotime($endDate2))/ (60*60*24);
                                        $diff= $diff * -1;

                                        $additionalData = '';
                                        $additionalPattern = '/\(([^)]*)\)/';
                                        if (preg_match($additionalPattern, $endDate, $additionalMatches)) {
                                            $additionalData = $additionalMatches[1];
                                        }

                                        if($diff == 0){
                                            $datelist[]= date('F j, Y', strtotime($endDate2)).' '. $additionalData;
                                        }else{
                                            $datelist[]= date('F j, Y', strtotime($startDate)).'-'. date('F j, Y', strtotime($endDate)).' '. $additionalData;
                                        }
                                    }
                                }
                                $dateRanges = implode('$', $datelist);
                                echo str_replace('$', '<br>', $dateRanges);

                            }else{
                                $dateRanges =str_replace('$', '<br>', $card_viewL->date_used);
                                echo $dateRanges;
                            }
                        }else{
                            echo "";
                        }
                        ?></td>
                    <td>{{$card_viewL->bal_credits}}</td>
                    <td style="text-align: left"><?php
                        if($card_viewL->status == "7" ){
                            $created = strtotime($card_viewL->created_at);
                            $condition = strtotime('2023-10-25');
                            if($created <= $condition){
                                echo "September 30, 2023";
                            }else{
                                echo date("F j, Y", strtotime($card_viewL->created_at));
                            }
                        }else{
                            echo date("F j, Y", strtotime($card_viewL->created_at));
                        }
                        ?></td>
                    @if ($card_viewL->status == 5)
                        <td id='remarks'style='color: red; text-align: left'>REMOVED: {{$card_viewL->remarks}}</td>
                    @elseif ($card_viewL->status == 2)
                        <td id='remarks'style='color: red; text-align: left'>MODIFIED(X): {{$card_viewL->remarks}}</td>
                    @elseif($card_viewL->status == 3)
                        <td id='remarks'style='color: red; text-align: left'>CANCELLED</td>
                    @elseif($card_viewL->status == 4)
                        <td id='remarks'style='color: blue; text-align: left'>PROCESSED</td>
                    @elseif($card_viewL->status == 1)
                        <td id='remarks'style='color: blue; text-align: left'>PROCESSED</td>
                    @elseif($card_viewL->status == 6)
                        <td id='remarks'style='color: red; text-align: left'>MODIFIED(X)</td>
                    @elseif($card_viewL->status == 7)
                        <td id='remarks'style='color: blue; text-align: left'>BALANCE</td>
                    @elseif($card_viewL->status == 9)
                        <td id='remarks'style='color: green; text-align: left'>EXCEED</td>
                    @else
                        <td id='remarks'style='color: red; text-align: left'>EXCEED</td>
                    @endif
                </tr>
            @else
                @if(Auth::user()->userid == $card_viewL->userid && $card_viewL->remarks == '0')
                    <tr>
                        <td style='color: red; text-align: center' colspan="12">{{ $card_viewL->date_used .' on '. date('F j, Y', strtotime($card_viewL->ot_date)) }}</td>
                    </tr>
                @endif
            @endif
        @endforeach
    @else
        <tr>
            <td colspan='8'>No Data Available</td>
        </tr>
    @endif
    </tbody>
</table>
<div class="modal-footer">
    <div class="alert-info" style="text-align: center; width: 100%;">
        <p style="padding: 12px; margin: 0; text-align: center;">
            <span >
                <i class="fa fa-hand-o-right"></i>
                Note: CTO credits earned within the current month can only be availed of the following month.
                An employee can earn a maximum of 40 hours CTO credit per month and a total of 120 hours CTO balance overall.
            </span>
        </p>
    </div>
    <div style="width: 100%; padding: 10px;">
        @if ($lastPage > 1)
        <ul class="pagination justify-content-center" id="pagination" style="margin: 0; padding: 0">
                @if ($card_view->getCurrentPage() < $lastPage)
                    <li>
                        <a href="{{ $card_view->getUrl($card_view->getCurrentPage() + 1) }}"
                           class="ajax-page-link"
                           data-page="{{ $card_view->getCurrentPage() + 1 }}">
                            Prev
                        </a>
                    </li>
                @endif
                @for ($i = $lastPage; $i >= 1; $i--)
                    <li class="{{ ($card_view->getCurrentPage() == $i) ? ' active' : '' }}">
                        <a href="{{ $card_view->getUrl($i) }}"
                           class="ajax-page-link"
                           data-page="{{ $i }}">
                            {{ $i }}
                        </a>
                    </li>
                @endfor
                @if ($card_view->getCurrentPage() > 1)
                    <li>
                        <a href="{{ $card_view->getUrl($card_view->getCurrentPage() - 1) }}"
                           class="ajax-page-link"
                           data-page="{{ $card_view->getCurrentPage() - 1 }}">
                            Next
                        </a>
                    </li>
                @endif
            </ul>
        @endif
    </div>
</div>
