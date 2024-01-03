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

<div class="modal fade" tabindex="-1" role="dialog" id="leave_info">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#9C8AA5   ;padding:15px;">
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
                <h4 class="modal-title"><i class="fa fa-plus"></i> Office Order</h4>
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
                <h4 class="modal-title"> 7.C APPROVED FOR:</h4>
            </div>
            <form action="{{ asset('leave/approved') }}" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" value="" name="route_no" id="leave_route_approved" />
                    <b>
                        <div class="has-success">
                            <div class="checkbox">
                                <label>
                                    <input type="radio" value="1" name="approved_for"> days with pay
                                </label><br>
                                <label>
                                    <input type="radio" value="2" name="approved_for"> days without pay
                                </label>
                                <label>
                                    <input type="radio" value="3" name="approved_for"> others (Specify)
                                    <input type="text"  name="for_others" style=" height: 40px;width: 250px" />
                                </label>
                            </div>
                        </div>
                    </b>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-success">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
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
                    <table class="modal-body table" id="move_body">

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" value="specific_date" class="btn btn-success">Submit</button>
                    <input type="hidden" id="from_date" name="from_date">
                    <input type="hidden" id="to_date" name="to_date">
                    <input type="hidden" id="move_route" name="move_route">
                    <input type="hidden" id="dates_leave" name="dates_leave">
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
            <form action="{{ asset('update_bbalance') }}" method="get">
                <div class="modal-header" style="background-color: #9C8AA5;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-pencil"></i> Update Beginning Balance</h4>
                </div>
                <div>
                    <table class="table">
                        <tr>
                            <td class="col-sm-3"><strong>User Id </strong></td>
                            <td class="col-sm-1">: </td>
                            <td class="col-sm-9">
                                <input type="text" class="col-md-2 form-control" id="user_id" name="user_id" value="" disabled>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-3"><strong>Overtime Date </strong></td>
                            <td class="col-sm-1"> :</td>
                            <td class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input class="form-control datepickercalendar" value="" id="overtime_date" name="overtime_date" placeholder="select date..." required autocomplete="off">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-3"><strong>Number of Hours </strong></td>
                            <td class="col-sm-1">: </td>
                            <td class="col-sm-9">
                                <input type="text" class="col-md-2 form-control" id="ot_hours" name="ot_hours" value="" required oninput="updateCTO()" autocomplete="off">
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-3"><strong>Rate </strong></td>
                            <td class="col-sm-1">: </td>
                            <td class="col-sm-9">
                                <input type="text" class="col-md-2 form-control" id="ot_weight" name="ot_weight" value="" required oninput="updateCTO()" autocomplete="off">
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-3"><strong>Total CTO to Add</strong></td>
                            <td class="col-sm-1">: </td>
                            <td class="col-sm-9">
                                <input type="text" class="col-md-2 form-control" id="cto_total" name="cto_total" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-sm-3"><strong>Remarks</strong></td>
                            <td class="col-sm-1">: </td>
                            <td class="col-sm-9">
                                <input type="text" class="col-md-2 form-control" id="remarks" name="remarks" value="" autocomplete="off">
                            </td>
                        </tr>
                    </table>
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
    <div class="modal-dialog modal-xl" role="document" id="size" style=" width: 70%;">
        <div class="modal-content">
            <form action="{{asset('leave_credits')}}" method="POST">

            <div class="header-container">
                <div class="modal-header sticky-top" style="background-color: #9C8AA5;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <b><label style="font-size: 15px; color: black; margin-bottom: 2px" class="name"></label></b>
                    <strong><h4 class="modal-title"></h4></strong>
                </div>
            </div>
                <div  style="max-height: calc(100vh - 50px); overflow-y: auto;">
                    <table class="table" id="card_table table-bordered"  style="border-collapse: collapse;">
                        <thead style="position:sticky; top: 0; z-index: 5;">
                        <tr>
                            <th rowspan="2" STYLE="vertical-align: middle; border: 1px solid black">PERIOD</th>
                            <th rowspan="2" STYLE="vertical-align: middle; border: 1px solid black">PARTICULARS</th>
                            <th colspan="4" style="text-align: center; border: 1px solid black">VACATION LEAVE
                            <th colspan="4" style="text-align: center; border: 1px solid black">SICK LEAVE
                            <th rowspan="2" STYLE="vertical-align: middle; border: 1px solid black">DATE AND ACTION TAKEN ON APPL. FOR LEAVE</th>
                            <th type="hidden"></th>
                        </tr>
                        <tr>
                            <th style="border: 1px solid black">EARNED</th>
                            <th style="border: 1px solid black">ABS.UND.W/P</th>
                            <th style="border: 1px solid black">BAL.</th>
                            <th style="border: 1px solid black">ABS.UND.WOP</th>
                            <th style="border: 1px solid black">EARNED</th>
                            <th style="border: 1px solid black">ABS.UND.W/P</th>
                            <th style="border: 1px solid black">BAL.</th>
                            <th style="border: 1px solid black">ABS.UND.WOP</th>
                        </tr>
                        </thead>
                        <tbody id="ledger_body" name="ledger_body" style="overflow-y: auto;"></tbody>
                    </table>
                </div>

            <div class="modal-footer">
                <input type ="hidden"value="" id="user_iid" name="user_iid">
            </div>
            </form>
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



