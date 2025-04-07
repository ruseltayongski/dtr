<form action="{{asset('leave_credits')}}" method="POST" style="padding:10px">
    <table class="table" id="leave_card_table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead style="background-color: darkgray; color:white;">
            <tr style="background-color: darkgray; border:1px solid darkgray">
                <td colspan="6" style="border:1px solid black; padding:5px;">{{ $user }}</td>
                <td colspan="5" style="border:1px solid black; padding:5px;">{{ $division }}</td>
            </tr>
            <tr style="background-color: darkgray;">
                <th rowspan="2" style="vertical-align: middle; color: white; border:1px solid black; padding:5px;">PERIOD</th>
                <th rowspan="2" style="vertical-align: middle; color: white; border:1px solid black; padding:5px;">PARTICULARS</th>
                <th colspan="4" style="text-align: center; color: white; border:1px solid black; padding:5px;">VACATION LEAVE</th>
                <th colspan="4" style="text-align: center; color: white; border:1px solid black; padding:5px;">SICK LEAVE</th>
                <th rowspan="2" style="vertical-align: middle; color: white; border:1px solid black; padding:5px;">DATE AND ACTION TAKEN ON APPL. FOR LEAVE</th>
            </tr>
            <tr>
                <th style="color: white; border:1px solid black; padding:5px;">EARNED</th>
                <th style="color: white; border:1px solid black; padding:5px;">ABS.UND.W/P</th>
                <th style="color: white; border:1px solid black; padding:5px;">BAL.</th>
                <th style="color: white; border:1px solid black; padding:5px;">ABS.UND.WOP</th>
                <th style="color: white; border:1px solid black; padding:5px;">EARNED</th>
                <th style="color: white; border:1px solid black; padding:5px;">ABS.UND.W/P</th>
                <th style="color: white; border:1px solid black; padding:5px;">BAL.</th>
                <th style="color: white; border:1px solid black; padding:5px;">ABS.UND.WOP</th>
            </tr>
        </thead>
        <tbody id="ledger_body" name="ledger_body">
            @foreach($card_details as $card)
                <tr>
                    <td style="border:1px solid black; padding:5px;">
                        @if($card->period !== null)
                            {{ $card->period }}
                        @endif
                    </td>
                    <td style="border:1px solid black; padding:5px;">
                        @if(strpos($card->particulars, 'deduct') !== false)
                            <a href="#" data-toggle="modal" onclick="checkAbsence(this)" data-target="#modify_deduction">{{ $card->particulars }}</a>
                        @elseif($card->remarks === 0)
                            <a href="#" data-toggle="modal" onclick="updateUT(this)" data-target="#modify_deduction">{{ $card->particulars }}</a>
                        @else
                            {{ $card->particulars }}
                        @endif
                    </td>
                    <td style="border:1px solid black; padding:5px;">{{ $card->vl_earned }}</td>
                    <td style="border:1px solid black; padding:5px;">{{ $card->vl_abswp }}</td>
                    <td style="border:1px solid black; padding:5px;">{{ $card->vl_bal }}</td>
                    <td style="border:1px solid black; padding:5px;">{{ $card->vl_abswop }}</td>
                    <td style="border:1px solid black; padding:5px;">{{ $card->sl_earned }}</td>
                    <td style="border:1px solid black; padding:5px;">{{ $card->sl_abswp }}</td>
                    <td style="border:1px solid black; padding:5px;">{{ $card->sl_bal }}</td>
                    <td style="border:1px solid black; padding:5px;">{{ $card->sl_abswop }}</td>
                    <td style="border:1px solid black; padding:5px;">{{ !empty($card->date_used) ? $card->date_used : '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="float:right">        
        {{ $card_details->links() }}
    </div>
    <div class="modal-footer">
        <input type="hidden" value="" id="user_iid" name="user_iid">
    </div>
</form>
