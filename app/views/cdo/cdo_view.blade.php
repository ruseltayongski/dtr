<title>CTO</title>
<head>
    <style>
        .align{
            text-align: center;
        }
        .align-right{
            text-align: right;
        }
        .align-left{
            text-align: left;
        }
        .new-times-roman{
            font-family: "Times New Roman", Times, serif;
            font-size: 11.5pt;
            padding: 15px;;
        }
        #border{
            border-collapse: collapse;
            border: 1px solid black;
        }
        .table-info tr td{
            font-weight:bold;
            color: #2b542c;
        }
    </style>
</head>
<body>
<form action="{{ $data['asset'] }}" method="POST" class="form-submit">
    <input type="hidden" value="{{ csrf_token() }}" name="_token">
    <div class="clearfix"></div>
    <div class="new-times-roman table-responsive">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td class="align"><img src="{{ asset('public/img/doh.png') }}" width="100"></td>
                <td width="90%" >
                    <div class="align small-text">
                        Republic of the Philippines<br>
                        <strong>DEPARTMENT OF HEALTH REGIONAL OFFICE VII</strong><br>
                        Osmeña Boulevard, Cebu City, 6000 Philippines<br>
                        Regional Director’s Office Tel. No. (032) 253-6355 Fax No. (032) 254-0109<br>
                        Official Website: http://www.ro7.doh.gov.ph Email Address: dohro7@gmail.com<br>
                        5:12 PM 7/10/2017
                    </div>
                </td>
                <td class="align"><img src="{{ asset('public/img/ro7.png') }}" width="100"></td>
            </tr>
        </table>
        <br>
        <table class="table table-hover table-striped">
            <tr>
                <td class="col-sm-1">Section: </td>
                <td>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-universal-access"></i>
                        </div>
                        <input type="text" value="{{ $data['section'] }}" class="form-control" readonly>
                    </div>
                </td>
                <td class="col-sm-1">Cluster: </td>
                <td >
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-universal-access"></i>
                        </div>
                        <input type="text" value="{{ $data['division'] }}" class="form-control" readonly>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="col-sm-1">Prepared Date: </td>
                <td>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar-o"></i>
                        </div>
                        <input class="form-control datepickercalendar" value="<?php if(isset($data['cdo']['prepared_date'])) echo date('m/d/Y',strtotime($data['cdo']['prepared_date'])); else echo date('m/d/Y'); ?>" name="prepared_date" required>
                    </div>
                </td>
                <td class="col-sm-1">Subject:</td>
                <td>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-book"></i>
                        </div>
                        <textarea name="subject" class="form-control" rows="1" style="resize: none;width: 100%;" required><?php if(isset($data['cdo']['subject']) and $data['type'] == 'update') echo $data['cdo']['subject'] ?></textarea>
                    </div>
                </td>
            </tr>
        </table>
        <table class="table table-hover table-striped">
            <tr>
                <td class="col-sm-7">
                    <table class="table table-list table-hover table-striped table-info">
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                        </tr>
                        <tr>
                            <td>
                                <i class="fa fa-user"></i>
                                {{ $data['name'] }}
                            </td>
                            <td>
                                <i class="fa fa-user-secret"></i>
                                {{ $data['position'] }}
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="col-sm-7">
                    <table class="table table-list table-hover table-striped">
                        <tr>
                            <td colspan="2">NUMBER OF WORKING DAY/S APPLIED FOR:</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control" value="<?php if(isset($data['cdo']['start'])) echo date('m/d/Y',strtotime($data['cdo']['start'])).' - '.date('m/d/Y',strtotime('-1 day',strtotime($data['cdo']['end']))); ?>" id="inclusive1" name="inclusive_dates" placeholder="Input date range here..." required>
                                </div>
                            </td>
                            <td class="col-sm-4">Inlusive Dates</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table class="table table-hover table-striped">
            <tr>
                <td class="col-sm-7">
                    <table class="table table-list table-hover table-striped">
                        <tr>
                            <td colspan="3"><strong>CERTIFICATION OF COMPENSATORY OVERTIME CREDITS</strong></td>
                        </tr>
                        <tr>
                            <td>Beginning Balance</td>
                            <td>Less Applied for</td>
                            <td>Remaining Balance</td>
                        </tr>
                        <tr>
                            <td><input type="text" value="{{ $data['cdo']['beginning_balance'] }}" class="form-control" name="beginning_balance" maxlength="15"
                                <?php
                                        if($data['type'] == 'add' || !\Illuminate\Support\Facades\Auth::user()->usertype)
                                            echo 'disabled';
                                        ?>>
                            </td>
                            <td><input type="text" value="{{ $data['cdo']['less_applied_for'] }}" class="form-control" name="less_applied" maxlength="15"
                                <?php
                                        if($data['type'] == 'add' || !\Illuminate\Support\Facades\Auth::user()->usertype)
                                            echo 'disabled';
                                        ?>>
                            </td>
                            <td><input type="text" value="{{ $data['cdo']['remaining_balance'] }}" class="form-control" name="remaining_balance" maxlength="15"
                                <?php
                                        if($data['type'] == 'add' || !\Illuminate\Support\Facades\Auth::user()->usertype)
                                            echo 'disabled';
                                        ?>>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table class="table table-list table-hover table-striped">
                        <tr>
                            <th colspan="2">RECOMENDATION:</th>
                        </tr>
                        <tr>
                            <td class="col-sm-3 align-right">
                                <input type="checkbox" name="approval" id="approval" class="form-control input-lg"
                                <?php
                                        if($data['type'] == 'add')
                                            echo 'disabled';
                                        else{
                                            if($data['cdo']['approved_status'] == 1){
                                                if(\Illuminate\Support\Facades\Auth::user()->usertype)
                                                    echo 'checked';
                                                else
                                                    echo 'disabled checked';
                                            }
                                            else{
                                                if(\Illuminate\Support\Facades\Auth::user()->usertype)
                                                    echo '';
                                                else
                                                    echo 'disabled';
                                            }
                                        }
                                        ?>>
                            </td>
                            <td class="align-left">Approval</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3 align-right">
                                <input type="checkbox" style="color: black;" name="disapproval" id="disapproval" class="form-control input-lg"
                                <?php
                                        if($data['type'] == 'add')
                                            echo 'disabled';
                                        else{
                                            if($data['cdo']['approved_status'] == 0){
                                                if(\Illuminate\Support\Facades\Auth::user()->usertype)
                                                    echo 'checked';
                                                else
                                                    echo 'disabled';
                                            }
                                            else{
                                                if(\Illuminate\Support\Facades\Auth::user()->usertype)
                                                    echo '';
                                                else
                                                    echo 'disabled';
                                            }
                                        }
                                        ?>>
                            </td>
                            <td class="align-left">Disapproval</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <td class="col-sm-7">
                    <table width="100%">
                        <tr><td class="align"><strong>THERESA Q. TRAGICO</strong></td></tr>
                        <tr><td class="align">Administrative Officer V</td></tr>
                        <tr><td class="align">Personel Section</td></tr>
                    </table>
                </td>
                <td>
                    <table width="100%">
                        <tr>
                            <td class="align">
                                <select  class="chosen-select-static form-control" name="immediate_supervisor" required>
                                    @if($data['type'] == 'update')
                                        <option value="{{ $data['section_head'][0]['id'] }}">{{ $data['section_head'][0]['fname'].' '.$data['section_head'][0]['mname'].' '.$data['section_head'][0]['lname'] }}</option>
                                    @endif
                                    @foreach($data['section_head'] as $section_head)
                                        @if($data['section_head'][0]['id'] != $section_head['id'] and $data['type'] == 'update')
                                            <option value="{{ $section_head['id'] }}">{{ $section_head['fname'].' '.$section_head['mname'].' '.$section_head['lname'] }}</option>
                                        @elseif($data['type'] == 'add')
                                            <option value="{{ $section_head['id'] }}">{{ $section_head['fname'].' '.$section_head['mname'].' '.$section_head['lname'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr><td class="align">Immediate Supervisor</td></tr>
                        <tr>
                            <td class="align">
                                <br><br>
                                <select  class="form-control" name="division_chief" required>
                                    @if($data['type'] == 'update')
                                        <option value="{{ $data['division_head'][0]['id'] }}">{{ $data['division_head'][0]['fname'].' '.$data['division_head'][0]['mname'].' '.$data['division_head'][0]['lname'] }}</option>
                                    @endif
                                    @foreach($data['division_head'] as $division_head)
                                        @if($data['division_head'][0]['id'] != $division_head['id'] and $data['type'] == 'update')
                                            <option value="{{ $division_head['id'] }}">{{ $division_head['fname'].' '.$division_head['mname'].' '.$division_head['lname'] }}</option>
                                        @elseif($data['type'] == 'add')
                                            <option value="{{ $division_head['id'] }}">{{ $division_head['fname'].' '.$division_head['mname'].' '.$division_head['lname'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr><td class="align">Division/Cluster Chief</td></tr>
                    </table>
                </td>
            </tr>
        </table>
        <hr>
        @if($data['type'] == "update")
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#deleteDocument" style="color:white"><i class="fa fa-trash"></i> Remove</button>
                <button type="button" class="btn btn-success" data-dismiss="modal" style="color:white" data-toggle="modal" data-target="#paperSize"><i class="fa fa-barcode"></i> Barcode v1</button>
                <a target="_blank" href="{{ asset('pdf/track') }}" class="btn btn-success" style="color:white"><i class="fa fa-barcode"></i> Barcode v2</a>
                <a target="_blank" href="{{ asset('form/cdov1/pdf') }}" class="btn btn-success" style="color:white"><i class="fa fa-barcode"></i> Barcode v3</a>
                @if(!$data['cdo']['approved_status'])
                    <button type="submit" class="btn btn-primary btn-submit" style="color:white"><i class="fa fa-pencil"></i> Update</button>
                @else
                    <button onclick="warning()" type="button" class="btn btn-primary btn-submit" style="color:white"><i class="fa fa-pencil"></i> Update</button>
                @endif
            </div>
        @else
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                <button type="submit" class="btn btn-success btn-submit" style="color:white;"><i class="fa fa-send"></i> Submit</button>
            </div>
        @endif
    </div>
</form>
</body>
<script>
    $('.chosen-select-static').chosen();
    $('.datepickercalendar').datepicker({
        autoclose: true
    });

    $(function(){
        $("body").delegate("#inclusive1","focusin",function(){
            $(this).daterangepicker();
        });
    });

    $('.form-submit').on('submit',function(){
        $('.btn-submit').attr("disabled", true);
    });

    $('input[name=approval]').on('ifChecked', function(event){
        $('input[name="disapproval"]').iCheck('uncheck');
    });
    $('input[name=disapproval]').on('ifChecked', function(event){
        $('input[name="approval"]').iCheck('uncheck');
    });

    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });

    function warning(){
        Lobibox.alert('info', //AVAILABLE TYPES: "error", "info", "success", "warning"
                {
                    msg: "Cannot update if your CTO is already approved.."
                });
    }
</script>
