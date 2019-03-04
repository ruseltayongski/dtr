@extends('layouts.app')
@section('content')
    <style>
        .table-info tr td:first-child {
            color: #2b542c;
        }
    </style>
    <span id="so_append" data-link="{{ asset('so_append') }}"></span>
    <div class="col-md-12 wrapper">
        <div class="box box-info">
            <div class="box-body">
                <h3>Office Order</h3>
                <div class="row">
                    <div class="col-md-11">
                        <form action="{{ asset('form/so') }}" method="POST" id="form_route" class="form-submit">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="table-responsive" style="color:#444;">
                                <table class="table">
                                    <tr>
                                        <td class="col-md-1"><img height="130" width="130" src="{{ asset('public/img/doh.png') }}" /></td>
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
                                <table class="table table-hover table-form table-striped">
                                    <tr>
                                        <td class="col-sm-3"><label>Prepared by</label></td>
                                        <td class="col-sm-1">:</td>
                                        <td class="col-sm-8"><input type="text" name="prepared_by" class="form-control" value="{{ Auth::user()->fname }} {{ Auth::user()->lname }}" required readonly></td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-3"><label>Prepared date</label></td>
                                        <td class="col-sm-1">:</td>
                                        <td class="col-sm-8">
                                            <input class="form-control datepickercalendar" value="{{ date('m/d/Y') }}" name="prepared_date" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-3"><label>Subject:</label><small style="color:red;">required field</small></td>
                                        <td class="col-sm-1">:</td>
                                        <td class="col-sm-8"><textarea name="subject" id="subject" class="form-control" style="resize:none;" required></textarea></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <div style="color: red">
                                                <span><label>Header Body:</label><small style="color:red;">required field</small></span>
                                                <textarea class="form-control" id="textarea" name="header_body" rows="8" style="resize:none;" required></textarea>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-3"><label>Inclusive Name</label><small style="color:red;">required field</small></td>
                                        <td class="col-sm-1">:</td>
                                        <td class="col-sm-8">
                                            <select class="form-control select2" id="inclusive_name" name="inclusive_name[]" multiple="multiple" data-placeholder="Select a name" required>
                                                @foreach($users as $row)
                                                    <option value="{{ $row['id'] }}">{{ $row['fname'].' '.$row['mname'].' '.$row['lname'] }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tbody class="p_inclusive_date">
                                    <tr>
                                        <td class="col-sm-3"><label>Inclusive Date and Area:</label><small style="color:red;">required</small></td>
                                        <td class="col-sm-1">:</td>
                                        <td class="col-sm-8">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control" id="inclusive1" name="inclusive[]" placeholder="Input date range here..." style="width: 40%;" required>
                                                <textarea name="area[]" id="area1" class="form-control" rows="1" placeholder="Input your area here..." style="resize: none;width: 40%;margin-left:2%" required></textarea>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td id="border-top">
                                            <a onclick="add_inclusive();" href="#">
                                                <p class="pull-right"><i class="fa fa-plus"></i> Add Inclusive date</p>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <label>Entitled Body:</label><small style="color:red;">required field</small>
                                            <textarea class="form-control" id="textarea1" name="footer_body" rows="8" style="resize:none;" required></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-3"><label>To be approve by:</label><small style="color:red;">required field</small></td>
                                        <td class="col-sm-1">:</td>
                                        <td class="col-sm-8">
                                            <select name="approved_by" id="approved_by" class="form-control" onchange="approved($(this))" required>
                                                <option value="">Select Name</option>
                                                <option value="Jaime S. Bernadas, MD, MGM, CESO III">Jaime S. Bernadas, MD, MGM, CESO III</option>
                                                <option value="Ruben S. Siapno,MD,MPH">Ruben S. Siapno,MD,MPH</option>
                                                <option value="Ellenietta HMV N. Gamolo,MD,MPH,CESE">Ellenietta HMV N. Gamolo,MD,MPH,CESE</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-3"><label>Designation</label></td>
                                        <td class="col-sm-1">:</td>
                                        <td class="col-sm-8"><input type="text" id="director" class="form-control" readonly/></td>
                                    </tr>
                                </table>
                                <div class="modal-footer">
                                    <a href="{{ asset('/form/so_list') }}" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</a>
                                    <button type="submit" onclick="check_textarea()" class="btn btn-success btn-submit" style="color:white"><i class="fa fa-send"></i> Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script>
        $("#textarea3").wysihtml5();
        $('.chosen-select-static').chosen();
        $("#textarea").wysihtml5();
        $("#textarea1").wysihtml5();
        $(".select2").select2();
        $('.datepickercalendar').datepicker({
            autoclose: true
        });
        //rusel
        $('#inclusive1').daterangepicker();
        var count = 1;
        function add_inclusive(){
            event.preventDefault();
            count++;
            var url = $("#so_append").data('link')+"?count="+count;
            $.get(url,function(result){
                $(".p_inclusive_date").append(result);
            });
            $(function() {
                $("body").delegate("#inclusive"+count, "focusin", function(){
                    $(this).daterangepicker();
                });
            });
        }

        function remove_row(id){
            $("#"+id.val()).remove();
        }

        $('select').val(<?php echo $prepared_by;?>).trigger('change');

        $('.form-submit').on('submit',function(){
            $('.btn-submit').attr("disabled", true);
        });

        function approved(data){
            if(data.val() == 'Jaime S. Bernadas, MD, MGM, CESO III')
                $("#director").val('Director IV');
            else if(data.val() == 'Ruben S. Siapno,MD,MPH')
                $("#director").val('Director III');
            else
                $("#director").val('');
        }

        function check_textarea(){
            //console.log($('iframe').contents().find('.wysihtml5-editor').text());
            if($("#subject").val() && $("#inclusive_name").val() && $("#inclusive1").val() && $("#area1").val() && $("#approved_by").val()){
                if(!$("#textarea").val() || !$("#textarea1").val()){
                    Lobibox.alert('error', //AVAILABLE TYPES: "error", "info", "success", "warning"
                            {
                                msg: 'Please input all required field'
                            });
                }
            }
        }

    </script>
@endsection