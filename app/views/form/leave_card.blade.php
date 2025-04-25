<form action="{{asset('leave_credits')}}" method="POST" style="padding:10px">
    <table class="table" id="leave_card_table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
        <thead style="background-color: darkgray; color:white;">
            <tr style="background-color: darkgray; border:1px solid darkgray">
                <td colspan="4" style="border:1px solid black; padding:5px;">NAME: {{ $user }}</td>
                <td colspan="4" style="border:1px solid black; padding:5px;">SECTION/DIVISION - {{ $division }}</td>
                <td colspan="3" style="border:1px solid black; padding:5px;">ETD : (pis data unavailable)</td>
            </tr>
            <tr style="background-color: darkgray;">
                <th rowspan="2" style="vertical-align: middle; color: white; border:1px solid black; padding:5px; width:250px">PERIOD</th>
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
                        @if($card->status == 2)
                            <a href="#" data-toggle="modal" onclick="checkAbsence(this)" data-target="#modify_deduction">{{ $card->particulars }}</a>
                        @elseif($card->status == 1)
                            <a href="#" data-toggle="modal" onclick="updateUT(this)" data-target="#modify_deduction">{{ $card->particulars }}</a>
                        @else
                            {{ $card->particulars }}
                        @endif
                    </td>
                    <td style="border:1px solid black; padding:5px;">{{ $card->vl_earned == 0 ? '':rtrim(rtrim(number_format($card->vl_earned, 3, '.', ''), '0'), '.') }}</td>
                    <td style="border:1px solid black; padding:5px;">{{ $card->vl_abswp == 0 ? '':rtrim(rtrim(number_format($card->vl_abswp, 3, '.', ''), '0'), '.') }}</td>
                    <td style="border:1px solid black; padding:5px;">{{ $card->vl_bal == 0 ? '':rtrim(rtrim(number_format($card->vl_bal, 3, '.', ''), '0'), '.') }}</td>
                    <td style="border:1px solid black; padding:5px;">{{ $card->vl_abswop == 0 ? '':rtrim(rtrim(number_format($card->vl_abswop, 3, '.', ''), '0'), '.') }}</td>
                    <td style="border:1px solid black; padding:5px;">{{ $card->sl_earned == 0 ? '':rtrim(rtrim(number_format($card->sl_earned, 3, '.', ''), '0'), '.') }}</td>
                    <td style="border:1px solid black; padding:5px;">{{ $card->sl_abswp == 0 ? '':rtrim(rtrim(number_format($card->sl_abswp, 3, '.', ''), '0'), '.') }}</td>
                    <td style="border:1px solid black; padding:5px;">{{ $card->sl_bal == 0 ? '':rtrim(rtrim(number_format($card->sl_bal, 3, '.', ''), '0'), '.') }}</td>
                    <td style="border:1px solid black; padding:5px;">{{ $card->sl_abswop == 0 ? '':rtrim(rtrim(number_format($card->sl_abswop, 3, '.', ''), '0'), '.') }}</td>
                    <td style="border:1px solid black; padding:5px;">{{ !empty($card->date_used) ? $card->date_used : '' }}</td>
                    <td style="display: none">{{ $card->userid }}</td>
                    <td style="display: none">{{ $card->id }}</td>
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
