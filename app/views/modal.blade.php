<div class="modal fade" tabindex="-1" role="dialog" id="track">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="fa fa-line-chart" ></i> Track Document</h4>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-form table-striped">
                    <tr>
                        <td class="col-sm-3"><label>Route Number</label></td>
                        <td class="col-sm-1">:</td>
                        <td class="col-sm-8"><input type="text" readonly id="track_route_no" value="" class="form-control"></td>
                    </tr>
                </table>
                <hr />
                <div class="track_history"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                <button type="button" class="btn btn-success"  onclick="window.open('{{ asset('pdf/track') }}')"><i class="fa fa-print"></i> Print</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="leave_form">
    <div class="modal-dialog modal-lg" role="document" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #9900cc;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus"></i>Application for Leave</h4>
            </div>
            <div class="modal-body" id="filtered_body">

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id="filtered_dtr">
    <div class="modal-dialog modal-lg" role="document" style="width: 90%;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #9C8AA5;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus"></i>Application for Leave</h4>
            </div>
            <div class="modal-body" id="filtered_body">

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="delete_time">
    <div class="modal-dialog modal-lg" role="document" style="width: 20%;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #9900cc;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus"></i>Delete Attendance</h4>
            </div>

            <form action="{{ asset('delete/attendance') }}" method="POST">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="dtr_id" value="" id="dtr_id_val">
                <div class="modal-body">
                    Delete attendance ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id="print_emp">
    <div class="modal-dialog modal-lg" role="document" style="width: 20%;">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#9C8AA5   ;padding:15px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus"></i>Print Employees</h4>
            </div>

            <form action="{{ asset('print/employee') }}" method="GET">
                <input type="hidden" name="dtr_id" value="" id="dtr_id_val">
                <div class="modal-body">
                    <div class="radio">
                        <label>
                            <input type="radio" name="emp_type" id="optionsRadios1" value="JO" checked>
                            Job Order
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="emp_type" id="optionsRadios2" value="REG">
                            Regular
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success col-sm-12">
                        <i class="fa fa-print" ></i> Print
                    </button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id="deleteDocument">
    <div class="modal-dialog modal-sm" role="document">
        @if(isset($delete))
            <div class="modal-content">
                <div class="modal-header" style="background-color: darkmagenta;color: white;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-question-circle"></i> DTS Says:</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <span style="color:white;">Are you sure you want to delete this {{ $doc_type }}?</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <form action="{{ $delete }}" method="post">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                        <button type="submit" name="delete" class="btn btn-danger" ><i class="fa fa-trash"></i> Yes</button>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        @endif
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="absentDocument">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#9C8AA5;padding:15px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="modal_content"><center><img src="{{ asset('public/img/spin.gif') }}" width="150" style="padding:20px;"></center></div>
            </div>
        </div><!-- /.modal-content -->
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="change_schedule">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" id="schedule_modal">

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="users_roles_modal">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#9C8AA5;color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Supervised of Employee(s)</h4>
            </div>
            <form action="{{ asset('supervise/add') }}" method="POST">
                <div class="modal-body ">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" value="" name="supervisor_id" id="supervisor_id" />
                    <div class="users_roles_select_body">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-success">
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id="form_type" style="z-index:999991;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#9C8AA5;padding:15px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="fa fa-file-pdf-o"></i> Select Form Type</h4>
            </div>
            <div class="modal-body text-center">
                <div class="col-xs-4" style="left: 10%">
                    <a href="#document_form" data-dismiss="modal" data-link="<?php if(isset($asset)) echo $asset.'/1'; ?>" data-backdrop="static" data-toggle="modal" data-target="#document_form" class="text-success">
                        <i class="fa fa-file-pdf-o fa-5x"></i><br>
                        <i>Form V1</i>
                    </a>
                </div>
                <div class="col-xs-4" style="left: 25%;">
                    <a href="#document_form" data-dismiss="modal" data-link="<?php if(isset($asset)) echo $asset.'/2'; ?>" data-backdrop="static" data-toggle="modal" data-target="#document_form" class="text-info">
                        <i class="fa fa-file-pdf-o fa-5x"></i><br>
                        <i>Form V2</i>
                    </a>
                </div>
            </div>
            <div class="clearfix"></div>
            <br />
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id="update_user_info">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" >&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> User Info</h4>
            </div>
            <div class="modal-body user_edit_modal">
                <div class="modal_content"><center><img src="{{ asset('public/img/spin.gif') }}" width="150" style="padding:20px;"></center></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="leave_info" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="width: 1010px">
            <div class="modal-header" style="background-color:#9C8AA5   ;padding:15px; width: 1010px">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" >&times;</span></button>
                <h4 class="modal-title" style="color: white"><i class="fa fa-plus"></i> Leave Details</h4>
            </div>
            <div class="modal-body_leave" style="padding:10px;">
                <div class="modal_content"><center><img src="{{ asset('public/img/spin.gif') }}" width="150" style="padding:20px;"></center></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="document_info" style="overflow-y:scroll;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#9C8AA5;padding:15px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" >&times;</span></button>
                <h4 class="modal-title" style="color:white"><i class="fa fa-plus"></i> Office Order</h4>
            </div>
            <div class="modal-body">
                <div class="modal_content"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="document_form" style="overflow-y:scroll;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#9C8AA5;padding:15px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="color: white"><i class="fa fa-plus"></i> Create Document</h4>
            </div>
            <div class="modal-body">
                <div class="modal_content">
                    <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#toggle-pane-88">Simple collapsible</button>
                    <div id="toggle-pane-88" class="collapse">Rusel</div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="paperSize" style="z-index:999991;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: darkmagenta">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="fa fa-file-pdf-o"></i> Select Paper Size</h4>
            </div>
            <div class="modal-body text-center">
                <div class="col-xs-4">
                    <a href="{{ asset('pdf/v1/letter') }}" class="text-success" target="_blank">
                        <i class="fa fa-file-pdf-o fa-5x"></i><br>
                        Letter
                    </a>
                </div>
                <div class="col-xs-4">
                    <a href="{{ asset('pdf/v1/a4') }}" class="text-info" target="_blank">
                        <i class="fa fa-file-pdf-o fa-5x"></i><br>
                        A4
                    </a>
                </div>
                <div class="col-xs-4">
                    <a href="{{ asset('pdf/v1/legal') }}" class="text-warning" target="_blank">
                        <i class="fa fa-file-pdf-o fa-5x"></i><br>
                        Legal
                    </a>
                </div>
            </div>
            <div class="clearfix"></div>
            <br />

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--
<div class="modal fade delete_all" tabindex="-1" role="dialog" id="delete_all">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#9C8AA5;padding:15px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete all time logs</h4>
            </div>
            <div class="modal-body">
                <center>
                    <form action="{{ asset('delete/attendance') }}" method="POST" class="delete_logs">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <label class="text-italic">Select date range to delete</label>
                        <input type="text" class="form-control" id="absent" name="date_range" placeholder="Input date range here..." required>
                        <br>
                        <button type="submit" class="btn btn-danger" style="color:white;"><i class="fa fa-trash"> Delete</i></button>
                    </form>
                </center>
                <script>
                    $(function(){
                        $("body").delegate("#absent","focusin",function(){
                            $(this).daterangepicker();
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<div class="modal fade delete_all" tabindex="-1" role="dialog" id="delete_one">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#9C8AA5;padding:15px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete time logs by employee</h4>
            </div>
            <div class="modal-body">
                <center>
                    <form action="{{ asset('delete/attendance') }}" method="POST" class="delete_logs">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="text" class="col-md-2 form-control form-group" id="inputEmail3" name="userid" value="" placeholder="Input userid" required>
                        <input type="text" class="form-control form-group" id="absent" name="date_range" placeholder="Input date range here..." required>
                        <br>
                        <button type="submit" class="btn btn-danger" style="color:white;"><i class="fa fa-trash"> Delete</i></button>
                    </form>
                </center>
                <script>
                    $(function(){
                        $("body").delegate("#absent","focusin",function(){
                            $(this).daterangepicker();
                        });
                    });
                </script>
            </div>
        </div>
</div>

-->

<div class="modal fade" tabindex="-1" role="dialog" id="delete_user_modal">
    <div class="modal-dialog modal-sm" role="document">

        <div class="modal-content">
            <div class="modal-header" style="background-color:#9C8AA5;color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle"></i> DTS Says:</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <span style="color:indianred">Are you sure you want to remove?</span>
                </div>
            </div>
            <div class="modal-footer">
                <form action="{{ asset('user/delete') }}" method="POST">
                    <input type="hidden" name="userid" value="" id="del_userid_input" />
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                    <button type="submit" name="delete" class="btn btn-danger" ><i class="fa fa-trash"></i> Yes</button>
                </form>

            </div>
        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="absent_desc">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" id="schedule_modal">
            <div class="modal-header" style="background-color:#9C8AA5;color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle"></i> Create absent description</h4>
            </div>
            <div class="modal-body center">
                <center>
                    <img src="{{ asset('public/img/spin.gif') }}" class="align-center center loading" width="150" style="padding:10px; color: whitesmoke;">
                </center>
                <div class="row">
                    <div class="col-sm-12 modal_content">

                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="delete_edited">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" id="schedule_modal">
            <div class="modal-header" style="background-color:#9C8AA5;color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle"></i> Delete user created logs</h4>
            </div>
            <div class="modal-body center">
                <center>
                    <form action="{{ asset('delete/user/created/logs') }}" autocomplete="off" method="POST" class="delete_logs">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="text" class="form-control form-group" id="absent" name="date_range" placeholder="Input date range here..." required>
                        <br>
                        <button type="submit" class="btn btn-success" style="color:white;">Submit</button>
                    </form>
                </center>
            </div>
        </div>
    </div>
</div>


<center class="modal fade" tabindex="-1" role="dialog" id="upload_loading">
    <img src="{{ asset('public/img/spin.gif') }}" width="150" style="padding:10px; color: whitesmoke;">
    <br />
    <strong style="color:white;">Uploading.....</strong>
</center>


<center class="modal fade" tabindex="-1" role="dialog" id="generate_dtr_jo">
    <img src="{{ asset('public/img/spin.gif') }}" width="150" style="padding:10px; color: whitesmoke;">
    <br />
    <strong style="color:white;">Generating DTR.....</strong>
</center>


<center class="modal fade" tabindex="-1" role="dialog" id="print_individual">
    <img src="{{ asset('public/img/spin.gif') }}" width="150" style="padding:10px; color: whitesmoke;">
    <br />
    <strong style="color:white;">Generating DTR.....</strong>
</center>

<center class="modal fade" tabindex="-1" role="dialog" id="loading_modal">
    <img src="{{ asset('public/img/spin.gif') }}" width="150" style="padding:10px; color: whitesmoke;">
    <br />
    <strong style="color:white;">Loading.....</strong>
</center>

<center class="modal fade" tabindex="-1" role="dialog" id="data_table">
    <img src="{{ asset('public/img/spin.gif') }}" width="150" style="padding:10px; color: whitesmoke;">
    <br />
    <strong style="color:white;">Loading.....</strong>
</center>

<div class="modal fade" tabindex="-1" role="dialog" id="modal_leave_approved">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#9C8AA5;color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> MONETIZATION:</h4>
            </div>
            <form action="{{ asset('leave/approved') }}" id="approved_form" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" value="" name="route_no" id="leave_route_approved" />
                    <input type="hidden" name="monetization" value="monetization">
                    <b>
                        <div class="">
                            <div class="row">
                                <label>VL Balance:</label>
                                <input class="mon_vl" name="mon_vl" value="Balance" readonly>
                            </div>
                            <div class="row">
                                <label>SL Balance:</label>
                                <input class="mon_sl" name="mon_sl" value="Balance" readonly>
                            </div>
                            <div class="row">
                                <label>50% MONETIZATION:</label>
                            </div>
                            <div class="row">
                                <label style="">No of Days:</label>
                                <input type="number" name="days" placeholder="10,15,20,25,30">
                            </div>
                            <div class="row">
                                <label style="margin-right:52px;">VL:</label>
                                <input type="number" name="vl_deduct">
                            </div>
                            <div class="row">
                                <label style="margin-right:52px;">SL:</label>
                                <input type="number" name="sl_deduct">
                            </div>
                        </div>
                    </b>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-success">
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_leave_disapproved">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" >
            <div class="modal-header" style="background-color:#9C8AA5;color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> (7.D) Disapproved due to:</h4>
            </div>
            <form action="{{ asset('leave/disapproved') }}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" value="" name="route_no" id="leave_route_disapproved" />
                    <textarea name="disapproved_due_to" id="" cols="30" rows="5" class="form-control"></textarea>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="modal_leave_pending">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" >
            <form action="{{ asset('leave/pending') }}" method="POST">
                <div class="modal-body" style="padding-bottom: 0px">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" value="" name="route_no" id="leave_route_pending" />
                    <div class="alert alert-info" style="text-align: center"><strong>Are you sure you want to unprocess this application?</strong></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Yes</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">No</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="5" role="dialog" id="move_leave">
    <div class="modal-dialog modal-sm" role="document" id="size">
        <div class="modal-content" id="move_date">
            <form action="{{asset('move_dates')}}" method="get">
                <div class="modal-header" style="background-color: orange">
                    <strong><h4 class="modal-title" style="display: inline-block"></h4></strong>
                    <button style="display: inline-block" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div>
                    <label style="margin-left: 3%">Select dates to Move:</label>
                    <div style="margin-left: 5%; text-align: center" class="for_clone">
                        <select class="chosen-select-static form-control" name="move_select" id="move_select" required style="width: 70%;margin-right: 10%">

                        </select>
                        <button type="button" class="btn btn-sm btn-info" style="width: 15%; height: 33px" onclick="addMove($(this))"> + </button>
                        <div class="input-group" style="background-color: green; margin-left: 10.5%; width: 180px;">
                            <div class="input-group-addon" style="height: 10px; vertical-align: top;">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input style="=vertical-align: top; height: 30px; width:100%" type="text" class="from-control move_datepickerInput" id="move_datepicker" name="move_datepicker[]" placeholder="Select Date/s...">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="check" value="" onclick="subsub()" class="btn btn-success ">Submit</button>
                    <input type="hidden" id="from_date" name="from_date">
                    <input type="hidden" id="to_date" name="to_date">
                    <input type="hidden" id="move_route" name="move_route">
                    <input type="hidden" id="dates_leave" name="dates_leave">
                    <input type="hidden" id="new_dates" name="new_dates">

                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="5" role="dialog" id="remarks">
    <div class="modal-dialog modal-sm" role="document" id="size">
        <div class="modal-content" id="remarks">
            <form action="{{asset('remarks')}}" method="get">
                <div class="modal-header" style="background-color: orange">
                    <strong><h4 class="modal-title" style="display: inline-block"></h4></strong>
                    <button style="display: inline-block" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div>
                    <table class="modal-body table" id="remarks_body">

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" value="submit" class="btn btn-success">Submit</button>
                    <input type="hidden" id="route_remarks" name="route_remarks">
                    <input type="hidden" id="dates_remarks" name="dates_remarks">
                    <input type="hidden" id="dis_dates" name="dis_dates">
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="restore" style="display: none; background: none; border: none;">
    <div class="modal-dialog modal-sm" role="document" id="size">
        <div class="modal-content" id="restore">
            <form action="{{asset('remarks')}}" method="get">
                <div class="modal-header" style="background-color: orange">
                    <strong><h4 class="modal-title" style="display: inline-block"></h4></strong>
                    <button style="display: inline-block" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div>
                    <label>Leave Type:</label>
                    <select class="chosen-select-static form-control" name="leave_type" required>
                        <?php echo $leave = LeaveTypes::get();?>
                    @if(isset($leave))
                        @foreach($leave as $type)
                            <option value="{{$type->code}}">{{$type->code}}</option>
                        @endforeach
                    @endif
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" value="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="supervise_view">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" >
            <form action="{{ asset('supervise/individual') }}" method="POST">
                <input type="hidden" name="supervise_id" id="supervise_id">
                <div class="modal-body">
                    <div class="alert alert-info"><strong class="supervise_name">Are you sure you want to set pending?</strong></div>
                    <button type="submit" class="btn btn-success leave_approved"><span class="fa fa-eye"></span> View Timelog</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="users_privilege_modal">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#9C8AA5;color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Privileged Employee(s)</h4>
            </div>
            <form action="{{ asset('privilege/add') }}" method="POST">
                <div class="modal-body ">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" value="" name="supervisor_id" id="supervisor_id" />
                    <div class="users_privilege_select_body">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-success">
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="8" role="dialog" id="beginning_balance">
    <div class="modal-dialog modal-sm" role="document" id="size">
        <div class="modal-content">
            <form action="{{ asset('update_bbalance') }}" method="POST">
                <div class="modal-header" style="background-color: #9C8AA5; color:white">
                    <button type="button" class="close" data-dismiss="modal" style="color:white" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="title"><i class="fa fa-pencil"></i> Update Beginning Balance</h4>
                </div>
                <div class="balance_body">
                    <div class="form-group" style="padding: 10px">
                        <div class="row">
                            <div class="col-sm-3"><strong>User Id</strong></div>
                            <div class="col-sm-1">:</div>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="user_id" name="user_id" value="" disabled>
                            </div>
                        </div>
                        <div class="trans_clone">
                            <button type="button" onclick="cloneField(this)" style="display:flex; text-align: left" class="btn btn-xs btn-info add_bal">Add More</button>
                            <div class="row" style="margin-top: 5px">
                                <div class="col-sm-3"><strong>Date</strong></div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input class="form-control datepickercalendar" value="" id="overtime_date" name="overtime_date[]" placeholder="select date..." required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 5px">
                                <div class="col-sm-3"><strong>Hours #</strong></div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control ot_hours" id="ot_hours" name="ot_hours[]" value="" required oninput="updateCTO(this)" autocomplete="off">
                                </div>
                            </div>
                            <div class="row" style="margin-top: 5px">
                                <div class="col-sm-3"><strong>Rate</strong></div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control ot_weight" id="ot_weight" name="ot_weight[]" value="" required oninput="updateCTO(this)" autocomplete="off">
                                </div>
                            </div>
                            <div class="row" style="margin-top: 5px">
                                <div class="col-sm-3"><strong>Total</strong></div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control cto_total" id="cto_total" name="cto_total[]" readonly>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 5px">
                                <div class="col-sm-3"><strong>Remarks</strong></div>
                                <div class="col-sm-1">:</div>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="remarks" name="remarks[]" value="" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="" id="userid" name="userid">
                    <input type="hidden" value="" id="total_total" name="total_total">
                    <input type="hidden" value="" id="row_id" name="row_id">
                    <input type="hidden" class="action" value="" id="action" name="action">
                    <button type="submit" id="option" name="option" class="btn btn-success" style="color:white;" onclick="setAction('update')"><i class="fa fa-pencil"> Update</i></button>
                    <button type="hidden" id="option2" name="option2" class="btn btn-danger" style="display: none; color:white;" onclick="setAction('delete')"><i class="fa fa-trash"> Delete</i></button>
                </div>
            </form>

        </div><!-- .modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="leave_ledger">
    <div class="modal-dialog modal-xl" role="document" id="size" style=" width: 90%;">
        <div class="modal-header" style="background-color: #9C8AA5">
            <span>Leave CardView Details</span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-content l_view_body">
        </div><!-- .modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="leave_ledger2">
    <div class="modal-dialog modal-xl" role="document" id="size" style=" width: 90%;">
        <div class="modal-header" style="background-color: #9C8AA5">
            <span>Leave CardView Details</span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-content l_view_body" style="padding:5px">
            <table class="table" id="leave_card_table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead style="background-color: darkgray; color:white;">
                    <tr style="background-color: darkgray; border:1px solid darkgray">
                        <td colspan="2" style="border:1px solid black; padding:5px;"><span class="user_ledger_leave"></span></td>
                        <td colspan="8" style="border:1px solid black; padding:5px;"><span class="user_ledger_section_division"></span></td>
                        <td colspan="1" style="border:1px solid black; padding:5px;"><span class="user_ledger_etd"></td>
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
                <tbody id="ledger_body2" name="ledger_body2"></tbody>
            </table>
        </div><!-- .modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="8" role="dialog" id="update_period">
    <div class="modal-dialog modal-m" role="document" id="size">
        <div class="modal-content">
            <form action="{{asset('')}}" method="get">
                <div class="modal-header" style="background-color: grey">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div>
                    <table class="table">
                        <tr>
                            <td class="col-md-3"><strong>USERID</strong></td>
                            <td class="col-md-1"><strong>:</strong></td>
                            <td class="col-md-9">
                                <input type="text" class="col-md-2 form-control" id="user_id" name="user_id" value="" disabled>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-m-3"><strong>DATE</strong></td>
                            <td class="col-m-1"><strong>:</strong></td>
                            <td class="col-m-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input class="form-control range" value="" id="range" name="range" placeholder="select date..." required autocomplete="off">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-3"><strong>EARNED</strong></td>
                            <td class="col-md-1"><strong>:</strong></td>
                            <td class="col-md-9">
                                <input type="text" class="col-md-2 form-control" id="earned" name="earned" value="" >
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="5" role="dialog" id="cancel_dates">
    <div class="modal-dialog modal-xs" role="document" id="size">
        <div class="modal-content" id="cancel_date">
            <form action="{{asset('cancel_dates')}}" method="get">
                <div class="modal-header" style="background-color: orange">
                    <strong><h4 class="modal-title" style="display: inline-block"></h4></strong>
                    <button style="display: inline-block" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div>
                    <table class="modal-body table" id="cancel_body">

                    </table>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="route" name="route">
                    <input type="hidden" id="selected_date" name="selected_date">
                    <input type="hidden" id="dates" name="dates">
                    <input type="hidden" id="cdo_hours" name="cdo_hours">
                    <input type="hidden" id="all_hours" name="all_hours">
                    <input type="hidden" id="cancel_type" name="cancel_type">
                    <button type="submit" value="specific_date" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="5" role="dialog" id="falsification" style="align-content: center">
    <div class="modal-dialog modal-lg" role="document" id="size" style="width: 1100px;">
        <div class="modal-container" id="falsification" >
            <div class="modal-content" style="display: flex;">
                <div style="width: 40%; text-align: right;  vertical-align: bottom">
                    <div class="text-left">
                        <img src="{{ asset('FPDF/image/WARNING.png') }}" alt="image" width="80%" />
                    </div>
                </div>
                <div style="width: 60%;">
                    <button style="color:rgb(220 38 38);" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <br><br>
                    <svg
                            width="550"
                            height="132"
                            viewBox="0 0 327 132"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                    >
                        <text x="10" y="90" font-family="Arial" font-size="120" font-weight="bold" stroke="rgb(220 38 38)" stroke-width="2" fill="none">Oopps!</text>
                        <text x="15" y="92" font-family="Arial" font-size="120" font-weight="bold" stroke="rgb(220 38 38)" stroke-width="2" fill="rgb(220 38 38)">Oopps!</text>
                    </svg>
                    <h3 class="text-dark mb-6 text-2xl font-bold dark:text-white" style="text-align: center;">We've Detected That You Are Doing FALSIFICATION in Your Account!</h3><br>
                    <p class="text-body-color dark:text-dark-6 mb-8 text-lg" style="margin-left: 170px;font-size: 15px">You're attempt to falsify has been recorded!</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="application_details">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="fa fa-info-circle" ></i>Leave Application Details</h4>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-form table-striped">
                    <tr style="border: 1px solid black">
                        <td class="col-sm-8 text-center" style="border: 1px solid black"><span type="text"><b>INSTRUCTIONS AND REQUIREMENTS</b></span></td>
                    </tr>
                    <tr>
                        <td>
                            <div style="float:left; text-align: justify; width: calc(50% - 15px); margin-right: 10px;">
                                <p>
                                    Application for any type of leave shall be made on this Form and <u><b>to be accomplished at least in duplicate</b></u>
                                    with documentary requirements, as follows:
                                </p>
                                <b>1. Vacation leave*</b>
                                <p style="margin-left: 15px">
                                    It shall be filed five (5) days in advance, whenever possible, of the effective date of such leave. Vacation leave within in he Philippines or
                                    abroad shall be indicated in the form for purposes of such securing travel authority and completing clearance from money and work accountabilities.
                                </p>
                                <b>2. Mandatory/Forced leave</b>
                                <p style="margin-left: 15px">
                                    Annual five-day vacation leave shall be forfeited if not taken during the year. In case the scheduled leave has been cancelled in the exigency
                                    of the service by the head of agency, it shall no longer be deducted from the accumulated vacation leave. Availment of one (1) day or more Vacation
                                    Leave (VL) shall be considered for complying the mandatory/forced leave subject to the conditions under Section 25, Rule  XVI of the Omnibus Rules
                                    Implementing E.O No. 292.
                                </p>
                                <b>3. Sick leave*</b>
                                <p style="margin-left: 15px">
                                    <b>&bull;</b> It shall be filed immediately upon employee's return from such leave.<br>
                                    <b>&bull;</b> If filed in advance or exceeding five (5) days, application shall be accompanied by a <u>medical certificate</u>. In case medical
                                    consultation was not availed of, an <u>affidavit</u> should be executed by an applicant.
                                </p>
                                <b>4. Maternity leave* - 105 days</b>
                                <p style="margin-left: 15px">
                                    <b>&bull;</b> Proof of pregnancy e.g. ultrasound, doctor's certificate on the expected date of delivery.<br>
                                    <b>&bull;</b> Accomplished Notice of Allocation of Maternity Leave Credits (CS Form No. 6a), if needed.
                                    <b>&bull;</b> Seconded female employees shall enjoy maternity leave with full pay in the recipient agency.
                                </p>
                                <b>5. Paternity leave - 7 days</b>
                                <p style="margin-left: 15px">
                                    Proof of child's delivery e.g. birth certificate, medical certificate and marriage contract.
                                </p>
                                <b>6. Special Privilege leave - 3 days</b>
                                <p style="margin-left: 15px">
                                    It shall be filed/approved for at least one (1) week prior to availment, except on emergency cases. Special privilege leave within the Philippines or
                                    abroad shall be indicated in the form from money and work accountabilities.
                                </p>
                                <b>7. Solo Parent leave - 7 days</b>
                                <p style="margin-left: 15px">
                                    It shall be filed in advance of whenevr possible five (5) days before going such leave with updated Solo Parent Identification Card.
                                </p>
                                <b>8. Study leave* - up to 6 months</b>
                                <p style="margin-left: 15px">
                                    <b>&bull;</b> Shall meet the agency's internal requirements, if any;<br>
                                    <b>&bull;</b> Contract between the agency head or authorized representative and employee concerned.
                                </p>
                                <b>9. VAWC leave - 10 days</b>
                                <p style="margin-left: 15px">
                                    <b>&bull;</b> It shall be filed in advance or immediately upon the woman employee's return from such leave.<br>
                                    <b>&bull;</b> It shall be accompanied by any of the following supporting documents:
                                </p>
                                <p style="margin-left: 25px">
                                    a. Barangay Protection Order (BPO) obtained from the barangay;<br>
                                    b. Temporary/Permanent Protection Order (TPO/PPO) obtained from the court;<br>
                                    b. If the protection order is not yet issued by the barangay or the court, a certification issued by the Punong Barangay/Kagawad or
                                    Prosecuter or the Clerk of Court that the application for the BPO,
                                </p>
                            </div>
                            <div style="float:right; width:50%; text-align: justify;">
                                <p style="margin-left: 25px">
                                    TPO or PPO has been filed with the said office shall be sufficient to support the application for the ten-day leave; or<br>
                                    d. In the absence of the BPO/TPO/PPO or the certification, a police report specifying the details of the occurrence of
                                    violence on the victim and a medical certificate may be considered, at the discretion of the immediate supervisor of the
                                    woman employee concerned.
                                </p>
                                <b>10. Rehabilitation leave* - up to 6 months</b>
                                <p style="margin-left: 15px">
                                    <b>&bull;</b> Application shall be made within one (1) week from the time of the accident except when a longer period is warranted.<br>
                                    <b>&bull;</b> Letter request supported by relevant reports such as the police report, if any,<br>
                                    <b>&bull;</b> Medical certificate on the nature of the injuries, the course of treatment involved, and the need to undergo rest, recuperation,
                                    and rehabilitation, as the case may be.<br>
                                    <b>&bull;</b> Written concurrence of a government physician should be obtained relative to the recommendation for the rehabilitation
                                    if the attending physician is a private practitioner, particularly on the duration of the period of rehabilitation.<br>
                                </p>
                                <b>11. Special leave benefits for women* - up to 2 months</b>
                                <p style="margin-left: 15px">
                                    <b>&bull;</b> The application may be filed in advance, that is, at least five (5) days prior to the scheduled date of the gynecological surgery
                                    that will be undergone by the employee. In case of emergency, the application for special leave shall be filed immediately upon the employee's
                                    return but during the confinement the agency shall be notified of said surgery.<br>
                                    <b>&bull;</b> The application shall be accompanied by a medical certificate filled out by the proper medical authorities, e.g. the attending
                                    surgeon accompanied by a clinical summary reflecting the gynecological disorder which shall be addressed or was addressed by the said surgery;
                                    the histopathological report; the operative technique used for the surgery; the duration of the surgery including the perioperative period
                                    (period of confinement around surgery); as well as the employees estimated period of recuperation for the same.
                                </p>
                                <b>12. Special Emergency (Calamity) leave - up to 5 days</b>
                                <p style="margin-left: 15px">
                                    <b>&bull;</b> The special emergency leave can be applied for a maximum of five (5) straight working days or staggered basis within thirty (30)
                                    days from the actual occurence of the natural calamity/. Said privilege shall be enjoyed once a year, not in every instance of calamity or
                                    disaster.<br>
                                    <b>&bull;</b> The head of office shall take full responsibility for the grant of special emergency leave and verification of the employee's
                                    eligibility to be granted thereof. Said verification shall include: validation of place of residence based on latest available records of the
                                    affected employee; verification that the place of residence is covered in the declaration of calamity area by the proper government agency;
                                    and such other proofs as may be necessary.
                                </p>
                                <b>13. Monetization of leave credits</b>
                                <p style="margin-left: 15px">
                                    Application for monetization of fifty percent (50%) or more of the accumulated leave credits shall be accompanied by letter request to the head
                                    of the agency stating the valid and justifiable reasons.
                                </p>
                                <b>14. Terminal leave*</b>
                                <p style="margin-left: 15px">
                                    Proof of employee's resignation or retirement or separation from the service.
                                </p>
                                <b>15. Adoption Leave</b>
                                <p style="margin-left: 15px">
                                    <b>&bull;</b> Application for adoption leave shall be filed with an authenticated copy of the Pre-Adoptive Placement Authority issued by the
                                    Department of Social Welfare and Development (DSWD).
                                </p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-sm-8 text-justify">
                            <p>
                                ____________________________________<br>
                                &bull; For leave of absence for thirty (30) calendar days or more and terminal leave, application shall be accompanied by a
                                <u>clearance from money, property and work-related accountabilities</u> (pursuant to CSC Memorandum Circular No. 2, s. 1985).
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" tabindex="5" role="dialog" id="leave_balance">
    <div class="modal-dialog modal-sm" role="document" id="size">
        <div class="modal-content" id="leave_balance">
            <form action="{{asset('leave/update_balance')}}" method="post">
                <input type="hidden" id="userid_bal" name="userid_bal">
                <div class="modal-header" style="background-color: orange">
                    <strong><h4 class="leave_title" style="display: inline-block"></h4></strong>
                    <button style="display: inline-block" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="leave_modal">

                </div>
                <div class="modal-footer">
                    <button type="submit" value="specific_date" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="8" role="dialog" id="modify_deduction">
    <div class="modal-dialog modal-sm" role="document" id="size">
        <div class="modal-content">
            <form action="{{ asset('update_absence') }}" method="post">
                <div class="modal-header" style="background-color: #9C8AA5; color:white">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-pencil"></i> Update Leave Balance</h4>
                </div>
                <div>
                    <table class="table" id="absence_table">
                        <tr>
                            <td class="col-sm-3"><strong>User Id </strong></td>
                            <td class="col-sm-1">: </td>
                            <td class="col-sm-9">
                                <input type="text" class="col-md-2 form-control modify_userid" id="user_id" name="user_id" value="" disabled>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-3"><strong>Month</strong></td>
                            <td class="col-sm-1"> :</td>
                            <td class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input class="form-control datarangepicker" value="" id="month_date" name="month_date" placeholder="select month range..." required autocomplete="off">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-3"><strong><span class="type_label">Deduction/ Absence</span></strong></td>
                            <td class="col-sm-1">: </td>
                            <td class="col-sm-9">
                                <input type="text" class="col-md-2 form-control" id="absence" name="absence" value="" required autocomplete="off">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <input type="hidden" class="card_id" name="card_id">
                    <button type="submit" value="update" name="action" class="btn btn-success mod_update_btn" style="color:white;" ><i class="fa fa-pencil"> Update</i></button>
                    <button type="submit" value="delete" name="action" class="btn btn-danger delete_btn" style="color:white;"><i class="fa fa-trash"> Delete</i></button>
                </div>
            </form>

        </div><!-- .modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" tabindex="5" role="dialog" id="monetize">
    <div class="modal-dialog modal-sm" role="document" id="size">
        <div class="modal-content">
            <form>
                <div class="modal-header" style="background-color: orange">
                    <strong><h4 class="modal-title" style="display: inline-block">Monetize Leave</h4></strong>
                    <button style="display: inline-block" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div style="text-align: center; width: 100%">
                    <select class="monetize_select form-control" onchange="monetize($(this).val())" style="margin-left:20%; width:150px !important; background-color: yellow" required>
                        <option value="">Please select value</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="30">30</option>
                        <option value="50">50% Monetization</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="5" role="dialog" id="approved_logs">
    <div class="modal-dialog modal-md" role="document" id="size">
        <div class="modal-content">
            <form method="POST" action="{{ asset('cdo_approved_pdf') }}" target="_blank">
                <div class="modal-header" style="background-color: cornflowerblue">
                    <strong><h4 class="modal-title" style="display: inline-block">Approved CDO</h4></strong>
                    <button style="display: inline-block" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div style="text-align: center; width: 100%" class="approved_body"></div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" style="color:white; margin-right:5px; border-radius: 0px"><i class="fa fa-barcode"></i>GENERATE PDF</button>
                </div>
            </form>
        </div>
    </div>
</div>



