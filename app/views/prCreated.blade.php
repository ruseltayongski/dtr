<tr id="{{ $_GET['count'] }}">
    <td id="border-bottom"><button type="button" value="{{ $_GET['count'] }}" onclick="erase($(this))" class="btn-sm"><small><i class="glyphicon glyphicon-remove"></i></small></button></td>
    <td id="border-bottom" class="{{ 'qty'.$_GET['count'] }}"><input type="number" name="qty[]" id="{{ 'qty'.$_GET['count'] }}" class="form-control" onkeyup="trapping()" required><small id="{{ 'E_qty'.$_GET['count'] }}">required!</small></td>
    <td id="border-bottom" class="{{ 'issue'.$_GET['count'] }}"><input type="text" name="issue[]" id="{{ 'issue'.$_GET['count'] }}" class="form-control" onkeyup="trapping()" required><small id="{{ 'E_issue'.$_GET['count'] }}">required!</small></td>
    <td id="border-bottom" class="{{ 'description'.$_GET['count'] }}">
        <textarea type="text" name="description[]" id="{{ 'description'.$_GET['count'] }}" class="form-control" onkeyup="trapping()" required></textarea><small id="{{ 'E_description'.$_GET['count'] }}">required!</small>
    </td>
    <td id="border-bottom"></td>
    <td id="border-bottom" class="{{ 'cost'.$_GET['count'] }}"><input type="text" name="cost[]" id="{{ 'cost'.$_GET['count'] }}" class="form-control" onkeyup="trapping()" required><small id="{{ 'E_cost'.$_GET['count'] }}">required!</small></td>
    <td id="border-bottom" class="{{ 'unit_cost'.$_GET['count'] }}"><input name="unit_cost[]" id="{{ 'unit_cost'.$_GET['count'] }}" class="form-control" readonly></td>
</tr>
