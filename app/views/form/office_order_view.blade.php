@extends('layouts.app')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugin/select2/select2.min.css') }}" />
    <script src="{{ asset('public/plugin/select2/select2.full.min.js') }}"></script>
    <span id="so_append" data-link="{{ asset('so_append') }}"></span>
    <span id="inclusive_name" data-link="{{ asset('inclusive_name') }}"></span>
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h3>Office Order</h3>
            <div class="container">
                <div class="row">
                    <div class="col-md-11">
                        <form action="{{ asset('/') }}" method="POST" id="form_route">

                            <div class="table-responsive">
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
                                        <td class="col-sm-8"><input class="form-control datepickercalendar" value="{{ $office_order->prepared_date }}" name="prepared_date" required></td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-3"><label>Subject</label></td>
                                        <td class="col-sm-1">:</td>
                                        <td class="col-sm-8"><textarea name="subject" class="form-control" style="resize:none;" required>{{ $office_order->subject }}</textarea></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <span>Header Body</span>
                                            <textarea class="form-control" id="textarea" name="header_body" rows="8" style="resize:none;" required>
                                                {{ $office_order->header_body }}
                                            </textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-3"><label>Inclusive Name</label></td>
                                        <td class="col-sm-1">:</td>
                                        <td class="col-sm-8">
                                            <select class="form-control select2" name="inclusive_name[]" multiple="multiple" data-placeholder="Select a name" required>
                                                @foreach($users as $row)
                                                    <option value="{{ $row['userid'] }}">{{ $row['fname'].' '.$row['mname'].' '.$row['lname'] }}</option>
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
                                        <td class="col-sm-1">:</td>
                                        <td class="col-sm-8">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control" style="width: 40%;" value="{{ date('m/d/Y',strtotime($row->start)).' - '.date('m/d/Y',strtotime($row->end)) }}" id="{{ 'inclusive'.$count }}" name="inclusive[]" placeholder="Input date range here..." required>
                                                <textarea name="area[]" class="form-control" rows="1" placeholder="Input your area here..." style="resize: none;width: 40%;margin-left:2%" required>{{ $row->area }}</textarea>
                                                &nbsp;
                                                <button type="button" value="{{ $count }}" onclick="remove($(this))" class="btn btn-danger" style="color: white" ><span class="fa fa-close"></span> remove</button>
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
                                        <td></td>
                                        <td></td>
                                        <td id="border-top">
                                            {{--<a onclick="add_inclusive();" href="#">
                                                <p class="pull-right"><i class="fa fa-plus"></i> Add Inclusive date</p>
                                            </a>--}}
                                            <button class="btn btn-primary pull-right" type="button" style="color: white" onclick="add_inclusive();"><i class="fa fa-plus"></i> Add inclusive date</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <span>Footer Body</span>
                                            <textarea class="form-control" id="textarea1" name="footer_body" rows="8" style="resize:none;" required>
                                                {{ $office_order->footer_body }}
                                            </textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-3"><label>To be approve by:</label></td>
                                        <td class="col-sm-1">:</td>
                                        <td class="col-sm-8">
                                            <input type="text" name="approved_by" value="Ruben S. Siapno,MD,MPH" class="form-control" readonly/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-3"><label>Designation</label></td>
                                        <td class="col-sm-1">:</td>
                                        <td class="col-sm-8"><input type="text" value="Director III" class="form-control" readonly/></td>
                                    </tr>
                                </table>
                                <div class="modal-footer">
                                    <a href="{{ asset('/form/so_list') }}" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</a>
                                    <button type="submit" class="btn btn-info" style="color: white" ><i class="fa fa-edit"></i> Update</button>
                                    <a href="{{ asset('/form/so_pdf') }}" target="_blank" type="submit" class="btn btn-danger" style="color: white" ><i class="fa fa-file"></i> Generate PDF</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    @@parent
    <style>
        .underline {
            border-bottom: 1px solid #000000;
            width: 50px;
        }
    </style>
@endsection
@section('js')
    @parent
    <script>
        $("#textarea").wysihtml5();
        $("#textarea1").wysihtml5();
        $(".select2").select2();
        $('.datepickercalendar').datepicker({
            autoclose: true
        });
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
            $('.select2').select2({}).select2('val', result);
            console.log(result);
        });
        //var array = ['0019','0031'];
    </script>
@endsection