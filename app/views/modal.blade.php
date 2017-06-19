<div class="modal fade" tabindex="-1" role="dialog" id="track">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#9C8AA5;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class=""><i class="fa fa-line-chart"></i> Track Document</h4>
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



<div class="modal fade" tabindex="-1" role="dialog" id="deleteDocument">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: darkmagenta;color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle"></i> DTS Says:</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <strong>Are you sure you want to delete this office order?</strong>
                </div>
            </div>
            <div class="modal-footer">
                <form action="<?php if(isset($delete)) echo $delete; ?>" method="post">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
                    <button type="submit" name="delete" class="btn btn-danger" ><i class="fa fa-trash"></i> Yes</button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id="change_schedule">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" id="schedule_modal">

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="form_type" style="z-index:999991;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#9C8AA5	;padding:15px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4><i class="fa fa-file-pdf-o"></i> Select Form Type</h4>
            </div>
            <div class="modal-body text-center">
                <div class="col-xs-4" style="left: 10%">
                    <a href="#document_form" data-dismiss="modal" data-link="<?php if(isset($asset)) echo $asset; ?>" data-backdrop="static" data-toggle="modal" data-target="#document_form" class="text-success">
                        <i class="fa fa-file-pdf-o fa-5x"></i><br>
                        <i>Form V1</i>
                    </a>
                </div>
                <div class="col-xs-4" style="left: 25%;">
                    @if(isset($doc_type))
                        @if($doc_type == 'CDO')
                            <a href="#" onclick="soon()" class="text-info">
                                <i class="fa fa-file-pdf-o fa-5x"></i><br>
                                <i>Form V2</i>
                            </a>
                        @else
                            <a href="so" class="text-info">
                                <i class="fa fa-file-pdf-o fa-5x"></i><br>
                                <i>Form V2</i>
                            </a>
                        @endif
                    @endif
                </div>
            </div>
            <div class="clearfix"></div>
            <br />
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="document_info">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#9C8AA5	;padding:15px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" >&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> Office Order</h4>
            </div>
            <div class="modal-body">
                <div class="modal_content"><center><img src="{{ asset('public/img/spin.gif') }}" width="150" style="padding:20px;"></center></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id="leave_info">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#9C8AA5	;padding:15px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" >&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> Application fo Leave</h4>
            </div>
            <div class="modal-body_leave" style="padding:10px;">
                <div class="modal_content"><center><img src="{{ asset('public/img/spin.gif') }}" width="150" style="padding:20px;"></center></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id="document_form" style="overflow-y:scroll;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#9C8AA5;padding:15px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> Create Document</h4>
            </div>
            <div class="modal-body">
                <div class="modal_content"><center><img src="{{ asset('public/img/spin.gif') }}" width="150" style="padding:20px;"></center></div>
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



