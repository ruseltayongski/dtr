@extends('layouts.app')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/plugin/select2/select2.min.css') }}" />
    <script src="{{ asset('public/plugin/select2/select2.full.min.js') }}"></script>
    <span id="so_append" data-link="{{ asset('so_append') }}"></span>
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h3>Office Order</h3>
            <div class="container">
                <div class="row">
                    <div class="col-md-11">
                        <form action="{{ asset('so_add') }}" method="POST" id="form_route">
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
                                        <td class="col-sm-8"><input class="form-control datepickercalendar" value="{{ date('m/d/Y') }}" name="prepared_date" required></td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-3"><label>Subject</label></td>
                                        <td class="col-sm-1">:</td>
                                        <td class="col-sm-8"><textarea name="subject" class="form-control" style="resize:none;" required></textarea></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <span>Header Body</span>
                                            <textarea class="form-control" id="textarea" name="header_body" rows="8" style="resize:none;" required></textarea>
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
                                        <tr>
                                            <td class="col-sm-3"><label>Inclusive Date and Area </label></td>
                                            <td class="col-sm-1">:</td>
                                            <td class="col-sm-8">
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control" id="inclusive1" name="inclusive[]" placeholder="Input date range here..." style="width: 40%;" required>
                                                    <textarea name="area[]" class="form-control" rows="1" placeholder="Input your area here..." style="resize: none;width: 40%;margin-left:2%" required></textarea>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td id="border-top">
                                            <a onclick="add_inclusive();" href="#">
                                                <p class="pull-right"><i class="fa fa-plus"></i> Add Inclusive date</a></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <span>Footer Body</span>
                                            <textarea class="form-control" id="textarea1" name="footer_body" rows="8" style="resize:none;" required></textarea>
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
                                    <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> Submit</button>
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
    @parent
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
        }
    </script>
@endsection