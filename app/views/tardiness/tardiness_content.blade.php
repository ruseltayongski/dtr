<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
<select name="year" id="year" class="form-control" required>
    @if(isset($yearAppend))
        <option value="{{ $yearAppend }}">{{ $yearAppend }}</option>
    @endif
    @for( $year = date("Y"); $year >= date("Y")-10; $year-- )
        <option value="{{ $year }}">{{ $year }}</option>
    @endfor
</select>
<br>
<select name="month" id="month" class="form-control" required>
    @if(isset($monthAppend))
        <option value="{{ $monthAppend }}">{{ date("F",strtotime ($monthAppend- date("n")." months")) }}</option>
    @else
        <option value="{{ date("n") }}">{{ date("F") }}</option>
    @endif
    @for( $month = 1; $month <= 12; $month++ )
        <?php $monthCount = $month - date("n") ?>
        <option value="{{ $month }}">{{ date("F",strtotime ($monthCount." months")) }}</option>
    @endfor
</select>