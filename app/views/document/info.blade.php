<style>
    .table-info tr td:first-child {
        font-weight:bold;
        color: #2b542c;
    }
</style>
<span id="so_append" data-link="{{ asset('so_append') }}"></span>
<span id="inclusive_name" data-link="{{ asset('inclusive_name_view') }}"></span>
<form action="@if($info->doc_type == 'OFFICE_ORDER') {{ asset('so_updatev1') }} @else {{ asset('cdo_updatev1') }} @endif" method="post" class="form-submit">
    <table>
        <tr>
            <td class="col-md-1"><img height="130" width="130" src="{{ asset('public/img/ro7.png') }}" /></td>
            <td class="col-lg-10" style="text-align: center;">
                Repulic of the Philippines <br />
                <strong>DEPARTMENT OF HEALTH REGIONAL OFFICE NO. VII</strong><br />
                Osmeña Boulevard, Cebu City, 6000 Philippines <br />
                Regional Director's Office Tel. No. (032) 253-635-6355 Fax No. (032) 254-0109 <br />
                Official Website:<a target="_blank" href="http://www.ro7.doh.gov.ph"><u>http://www.ro7.doh.gov.ph</u></a> Email Address: dohro7{{ '@' }}gmail.com
            </td>
            <td class="col-md-10"><img height="130" width="130" src="{{ asset('public/img/ro7.png') }}" /> </td>
        </tr>
    </table>
    @if($info->doc_type == "TIME_OFF")
        <table class="table table-hover table-striped table-info">
            <tr>
                <td class="col-sm-3"><label>Name</label></td>
                <td class="col-sm-1"><strong>:</strong></td>
                <td class="col-sm-8"><input type="text" class="form-control" value="{{ Auth::user()->fname }} {{ Auth::user()->lname }}" required readonly></td>
            </tr>
            <tr>
                <td class="col-sm-3"><label>Date</label></td>
                <td class="col-sm-1"><strong>:</strong></td>
                <td class="col-sm-8"><input class="form-control datepickercalendar" value="{{ date('m/d/Y',strtotime($info->date)) }}" name="date" required></td>
            </tr>
            <tr>
                <td class="col-sm-3"><label>Subject</label></td>
                <td class="col-sm-1"><strong>:</strong></td>
                <td class="col-sm-8"><textarea class="form-control" name="subject" rows="3" style="resize:none;" required>{{ $info->subject }}</textarea></td>
            </tr>
            <tr>
                <td class="col-sm-3"><label>Inclusive Dates:</label></td>
                <td class="col-sm-1"><strong>:</strong></td>
                <td class="col-sm-8">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control" id="inclusive1" value="{{ date('m/d/Y',strtotime($info->start)).' - '.date('m/d/Y',strtotime('-1 day',strtotime($info->end))) }}" name="inclusive_dates" placeholder="Input date range here..." required>
                    </div>
                </td>
            </tr>
        </table>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#deleteDocument" style="color:white"><i class="fa fa-trash"></i> Remove</button>
            <button type="button" class="btn btn-success" data-dismiss="modal" style="color:white" data-toggle="modal" data-target="#paperSize"><i class="fa fa-barcode"></i> Barcode v1</button>
            <a target="_blank" href="{{ asset('pdf/track') }}" class="btn btn-success" style="color:white"><i class="fa fa-barcode"></i> Barcode v2</a>
            <button type="submit" class="btn btn-primary btn-submit" style="color:white"><i class="fa fa-pencil"></i> Update</button>
        </div>
    @else
        <table class="table table-hover table-striped table-info">
            <tr>
                <td class="col-sm-3"><label>Document Type </label></td>
                <td class="col-sm-1"><strong>:</strong></td>
                <td class="col-sm-8">Office Order</td>
            </tr>
            <tr>
                <td class="col-sm-3"><label>Prepared date </label></td>
                <td class="col-sm-1"><strong>:</strong></td>
                <td class="col-sm-8"><input class="form-control datepickercalendar" value="{{ date('m/d/Y',strtotime($info->prepared_date)) }}" name="prepared_date" <?php if($info->version == 1)echo 'required';else echo'disabled';?>></td>
            </tr>
            <tr>
                <td class="col-sm-3"><label>Subject </label></td>
                <td class="col-sm-1"><strong>:</strong></td>
                <td class="col-sm-8">
                    <textarea class="form-control" name="subject" rows="3" style="resize:none;" <?php if($info->version == 1)echo 'required';else echo'disabled';?>>{{ $info->subject }}</textarea>
                </td>
            </tr>
            @if($info->version == 1)
                <tr>
                    <td class="col-sm-3"><label>Inclusive Name </label></td>
                    <td class="col-sm-1"><strong>:</strong></td>
                    <td class="col-sm-8">
                        <select class="form-control select2" name="inclusive_name[]" multiple="multiple" data-placeholder="Select a name" required>
                            @foreach($users as $row)
                                <option value="{{ $row['id'] }}">{{ $row['fname'].' '.$row['mname'].' '.$row['lname'] }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tbody class="p_inclusive_date">
                <?php
                $count = 1;
                foreach($inclusive_date as $row):
                ?>
                <tr id="{{ $count }}">
                    <td class="col-sm-3"><label>Inclusive Dates </label></td>
                    <td class="col-sm-1"><strong>:</strong></td>
                    <td class="col-sm-8">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control" style="width: 40%;" value="{{ date('m/d/Y',strtotime($row->start)).' - '.date('m/d/Y',strtotime('-1 day',strtotime($row->end))) }}" id="{{ 'inclusive'.$count }}" name="inclusive[]" placeholder="Input date range here..." required>
                            <textarea name="area[]" class="form-control" rows="1" placeholder="Input your area here..." style="resize: none;width: 40%;margin-left:2%" required>{{ $row->area }}</textarea>
                            &nbsp;
                            <button type="button" value="{{ $count }}" onclick="remove($(this))" class="btn btn-danger" style="color: white" ><span class="fa fa-close"></span></button>
                        </div>
                    </td>
                </tr>
                <?php
                $count++;
                endforeach;
                ?>
                <input type="hidden" value="{{ $count }}" id="date_count">
                </tbody>
                <tr>
                    <td class="col-sm-3"></td>
                    <td class="col-sm-1"></td>
                    <td class="col-sm-8">
                        <button class="btn btn-primary pull-right" type="button" style="color: white" onclick="add_inclusive();"><i class="fa fa-plus"></i> Add inclusive date</button>
                    </td>
                </tr>
            @endif
        </table>
        @if($info->version == 1)
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button type="submit" class="btn btn-primary btn-submit" style="color:white"><i class="fa fa-pencil"></i> Update</button>
                <a href="{{ asset('form/so_view') }}" class="btn btn-info" style="color:white"><i class="fa fa-file"></i> Proceed form into v2</a>
                <button type="button" class="btn btn-success" data-dismiss="modal" style="color:white" data-toggle="modal" data-target="#paperSize"><i class="fa fa-barcode"></i> Barcode v1</button>
                <a target="_blank" href="{{ asset('pdf/track') }}" class="btn btn-success" style="color:white"><i class="fa fa-barcode"></i> Barcode v2</a>
                <a onclick="warning()" class="btn btn-success" style="color:white"><i class="fa fa-barcode"></i> Barcode v3</a>
                <button type="button" data-route="{{ $info->route_no }}" data-link="{{ asset('/form/info/'.$info->route_no) }}" style="color:white" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#deleteDocument"><i class="fa fa-trash"></i> Remove</button>
            </div>
        @else
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#deleteDocument" style="color:white"><i class="fa fa-trash"></i> Remove</button>
                <a href="{{ asset('form/so_view') }}" class="btn btn-warning" style="color:white"><i class="fa fa-barcode"></i> View Document</a>
                <button type="button" class="btn btn-success" data-dismiss="modal" style="color:white" data-toggle="modal" data-target="#paperSize"><i class="fa fa-barcode"></i> Barcode v1</button>
                <a target="_blank" href="{{ asset('pdf/track') }}" class="btn btn-success" style="color:white"><i class="fa fa-barcode"></i> Barcode v2</a>
                <a href="{{ asset('/form/so_pdf') }}" target="_blank" class="btn btn-success" style="color:white"><i class="fa fa-barcode"></i> Barcode v3</a>
            </div>
        @endif
    @endif
</form>
<script>
    $('.datepickercalendar').datepicker({
        autoclose: true
    });

    $(".select2").select2();
    $("#inclusive1").daterangepicker();
    for(var i = 1; i <= $("#date_count").val();i++){
        $('#inclusive'+i).daterangepicker();
    }
    var count = $("#date_count").val();
    function add_inclusive(){
        event.preventDefault();
        count++;
        var url = $("#so_append").data('link')+"?count="+count;
        $.get(url,function(result){
            $(".p_inclusive_date").append(result);
        });
    }

    function remove(id){
        $("#"+id.val()).remove();
    }

    $.get($('#inclusive_name').data('link'),function(result){
        //$('.select2').select2({}).select2('val', result);
        $('select').val(result).trigger('change');
        console.log(result);
    });

    $('.form-submit').on('submit',function(){
        $('.btn-submit').attr("disabled", true);
    });
    function warning(){
        Lobibox.alert('info', //AVAILABLE TYPES: "error", "info", "success", "warning"
                {
                    msg: "Please proceed you're form into version 2 before you print the barcode version 3!"
                });
    }
</script>
