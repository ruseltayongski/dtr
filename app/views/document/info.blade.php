<style>
    .green {
        color: #11540c;
    }
    .orange {
        color: #d68036;
    }
</style>
<span id="so_append" data-link="{{ asset('so_append') }}"></span>
<form action="{{ asset('so_update') }}" method="POST" class="form-submit form-horizontal">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="version" value="{{ $info->version }}">
    <div class="col-md-12 wrapper">
        <div class="row" style="text-align: center;">
            <div class="col-sm-2">
                <img height="130" width="130" src="{{ asset('public/img/ro7.png') }}" />
            </div>
            <div class="col-sm-8">
                <div class="align small-text">
                    Republic of the Philippines<br>
                    DEPARTMENT OF HEALTH<br>
                    <strong>CENTRAL VISAYAS CENTER for HEALTH DEVELOPMENT</strong><br>
                    Osmeña Boulevard,Sambag II,Cebu City, 6000 Philippines<br>
                    Regional Director’s Office Tel. No. (032) 253-6355 Fax No. (032) 254-0109<br>
                    Official Website: http://www.ro7.doh.gov.ph Email Address: dohro7@gmail.com<br>
                </div>
            </div>
            <div class="col-sm-2">
                <img height="130" width="130" src="{{ asset('public/img/f1.jpg') }}" />
            </div>
        </div>
        <div class="box box-info">
            <div class="box-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label green">Prepared date</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar-plus-o"></i>
                            </div>
                            <input class="form-control datepickercalendar" value="{{ date('m/d/Y',strtotime($info->prepared_date)) }}" name="prepared_date">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label green">Subject</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-book"></i>
                            </div>
                            <textarea class="form-control" name="subject" rows="3" style="resize:none;" required>{{ $info->subject }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="proceed_loading"></div>
                <div class="proceed">
                    <div class="form-group">
                        <label class="col-sm-3 control-label green">Header Body</label>
                        <div class="col-sm-9">
                            <textarea class="form-control wysihtml5" name="header_body" rows="3" style="resize:none;" required>.</textarea>
                        </div>
                    </div>
                </div>
                @if($info->version == 2)
                    <div class="form-group">
                        <label class="col-sm-3 control-label green">Header Body</label>
                        <div class="col-sm-9">
                            <textarea class="form-control wysihtml5" name="header_body" rows="5" required>{{ $info->header_body }}</textarea>
                        </div>
                    </div>
                @endif

                <div class="form-group">
                    <label class="col-sm-3 control-label orange">Check if select all employee (Optional)</label>
                    <div class="col-sm-9">
                        <input type="checkbox" class="form-control" name="all_employee">
                        &nbsp;&nbsp;<button type="button" class="btn-xs btn-info" onclick="clear_name()" style="color: white">Clear Inclusive Name</button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label orange">Select section to include (Optional)</label>
                    <div class="col-sm-9">
                        <select onchange="selectSection($(this))" class="select2">
                            <option value="">Select Section</option>
                            @foreach($section as $row)
                                <option value="{{ $row->id }}">{{ $row->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label green">Inclusive Name</label>
                    <div class="col-sm-9">
                        <div class="name_loading"></div>
                        <div class="inclusive_name">
                            <select class='form-control select2 list_inclusive_name' name='inclusive_name[]' multiple='multiple' data-placeholder='Select a name' required>
                                @foreach($users as $row)
                                    <option value='{{ $row->userid }}'>{{ $row->fname.' '.$row->mname.' '.$row->lname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                <div class="p_inclusive_date">
                    <?php
                    $count = 1;
                    foreach($inclusive_date as $row):
                    ?>
                    <div class="{{ $count }}">
                  
                        <hr>
                        <div class="form-group">
                            <label class="col-sm-3 control-label green">Inclusive Date and Area</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control" value="{{ date('m/d/Y',strtotime($row->start)).' - '.date('m/d/Y',strtotime($row->end)) }}" id="inclusive1" name="inclusive[]" placeholder="Input date range here..." readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label green">Area</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-location-arrow"></i>
                                    </div>
                                    <textarea name="area[]" id="area1" class="form-control" style="resize: none;" rows="1" placeholder="Input your area here..." required>{{ $row->area }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label green">SO Time</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="so_time[]" id="so_time">
                                    @if( $row->so_time == 'wholeday' )
                                        <option value="wholeday">Whole Day</option>
                                        <option value="am">Half day / AM</option>
                                        <option value="pm">Half day / PM</option>
                                    @elseif( $row->so_time == 'am' )
                                        <option value="am">Half day / AM</option>
                                        <option value="pm">Half day / PM</option>
                                        <option value="wholeday">Whole Day</option>
                                    @else
                                        <option value="pm">Half day / PM</option>
                                        <option value="am">Half day / AM</option>
                                        <option value="wholeday">Whole Day</option>   
                                    @endif
                                </select>
                            </div>
                            @if( $count > 1 )
                            <div class="col-sm-1" style="margin-top:1%;">
                                <button type="button" value="{{ $count }}" onclick="remove_row($(this));" class="btn-xs btn-danger" style="color: white" ><span class="fa fa-close"></span></button>
                            </div>
                            @endif
                        </div>

                    </div>
                    <?php
                    $count++;
                    endforeach;
                    ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label orange">How many driver you include? (Optional)</label>
                        <div class="col-sm-9" style="margin-top: 1.2%;">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-car"></i>
                                </div>
                                <input type="number" class="form-control" value="{{ $info->driver }}" id="driver" name="driver">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" value="{{ $count }}" id="date_count">
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <button class="btn-xs btn-primary pull-right" type="button" style="color: white" onclick="add_inclusive();"><i class="fa fa-plus"></i> Add inclusive date</button>
                    </div>
                </div>
                <div class="proceed_loading"></div>
                <div class="proceed">
                    <div class="form-group">
                        <label class="col-sm-3 control-label green">Entitled Body</label>
                        <div class="col-sm-9">
                            <textarea class="form-control wysihtml5_1" name="footer_body" rows="3" style="resize:none;" required>.</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label green">To be approve by</label>
                        <div class="col-sm-9">
                            <input type="hidden" value="Jaime S. Bernadas, MD, MGM, CESO III" id="proceed_director">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-thumbs-up"></i>
                                </div>
                                <select name="approved_by" id="approved_by" class="form-control" onchange="approved($(this))" required>
                                    <option value="Jaime S. Bernadas, MD, MGM, CESO III">Jaime S. Bernadas, MD, MGM, CESO III</option>
                                    <option value="Ruben S. Siapno,MD,MPH">Ruben S. Siapno,MD,MPH</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label green">Designation</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-book"></i>
                                </div>
                                <input type="text" class="form-control director" readonly/>
                            </div>
                        </div>
                    </div>
                </div>
                @if($info->version == 2)
                    <div class="form-group">
                        <label class="col-sm-3 control-label green">Entitled Body</label>
                        <div class="col-sm-9">
                            <textarea class="form-control wysihtml5_1" name="footer_body" rows="5" required>{{ $info->footer_body }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label green">To be approve by</label>
                        <div class="col-sm-9">
                            <input type="hidden" id="get_director" value="{{ $info->approved_by }}">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-thumbs-up"></i>
                                </div>
                                <select name="approved_by" id="approved_by" class="form-control" onchange="approved($(this))" required>
                                    @if($info->version == 1)
                                        <option value="">Select Name</option>
                                        <option value="Jaime S. Bernadas, MD, MGM, CESO III">Jaime S. Bernadas, MD, MGM, CESO III</option>
                                        <option value="Ruben S. Siapno,MD,MPH">Ruben S. Siapno,MD,MPH</option>
                                        <option value="Sophia M. Mancao, MD, DPSP">Sophia M. Mancao, MD, DPSP</option>
                                    @else
                                        <option value="{{ $info->approved_by }}">{{ $info->approved_by }}</option>
                                        <option value="Jaime S. Bernadas, MD, MGM, CESO III">Jaime S. Bernadas, MD, MGM, CESO III</option>
                                        <option value="Sophia M. Mancao, MD, DPSP">Sophia M. Mancao, MD, DPSP</option>
                                        <option value="Ellenietta HMV N. Gamolo,MD,MPH,CESE">Ellenietta HMV N. Gamolo,MD,MPH,CESE</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label green">Designation</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-book"></i>
                                </div>
                                <input type="text" class="form-control director" readonly/>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
         </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
        @if($info->approved_status)
            <button type="button" onclick="warning('update')" class="btn btn-primary btn-submit" style="color:white"><i class="fa fa-pencil"></i> Update</button>
        @else
            <button type="submit" class="btn btn-primary btn-submit" style="color:white"><i class="fa fa-pencil"></i> Update</button>
            @if($info->version == 1)
                <a href="#" class="btn btn-warning btnV1" onclick="proceedv1()" style="color:white"><i class="fa fa-file"></i> Downgrade form into v1</a>
                <a href="#" class="btn btn-info btnV2" onclick="proceedv2()" style="color:white"><i class="fa fa-file"></i> Proceed form into v2</a>
            @endif
        @endif
        <button type="button" class="btn btn-success" data-dismiss="modal" style="color:white" data-toggle="modal" data-target="#paperSize"><i class="fa fa-barcode"></i> Barcode v1</button>
        <a target="_blank" href="{{ asset('pdf/track') }}" class="btn btn-success" style="color:white"><i class="fa fa-barcode"></i> Barcode v2</a>
        @if($info->version == 1)
            <a onclick="warning('barcode')" class="btn btn-success" style="color:white"><i class="fa fa-barcode"></i> Barcode v3</a>
        @elseif($info->version == 2)
            <a href="{{ asset('/form/so_pdf') }}" target="_blank" class="btn btn-success" style="color:white"><i class="fa fa-barcode"></i> Barcode v3</a>
        @endif
        <button type="button" data-route="{{ $info->route_no }}" data-link="{{ asset('/form/info/'.$info->route_no) }}" style="color:white" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#deleteDocument"><i class="fa fa-trash"></i> Remove</button>
    </div>
</form>
<script>


    $('.datepickercalendar').datepicker({
        autoclose: true
    });

    $(".proceed").hide();
    $(".btnV1").hide();

    function proceedv1(){
        $('.modal-title').html('Office Order. Form Version 1');
        $(".proceed_loading").html(loadingState);
        $('input[name=version]').val("1");
        setTimeout(function(){
            $(".proceed_loading").html('');
            $(".proceed").hide();
            $(".btnV1").hide();
            $(".btnV2").show();
        },500);
    }

    function proceedv2(){
        $('.modal-title').html('Office Order. Form Version 2');
        $(".proceed_loading").html(loadingState);
        $('input[name=version]').val("2");
        setTimeout(function(){
            $(".proceed_loading").html('');
            $(".proceed").show();
            $(".btnV1").show();
            $(".btnV2").hide();
        },500);
    }


    $(".wysihtml5").wysihtml5();
    $(".wysihtml5_1").wysihtml5();
    $(".select2").css('width','100%').select2();
    $("#inclusive1").daterangepicker();


    $('.list_inclusive_name').val(<?php echo $inclusive_name; ?>).trigger('change');

    for(var i = 1; i < $("#date_count").val();i++){
        $(function() {
            $("body").delegate("#inclusive"+i, "focusin", function(){
                $(this).daterangepicker();
            });
        });
    }

    var count = $("#date_count").val();
    function add_inclusive(){
        event.preventDefault();
        count++;
        var url = $("#so_append").data('link')+"?count="+count;
        $.get(url,function(result){
            $(".p_inclusive_date").append(result);
            $("."+count).hide().fadeIn();
        });
        $(function() {
            $("body").delegate("#inclusive"+count, "focusin", function(){
                $(this).daterangepicker();
            });
        });
    }

    function remove_row(id){
        //make multiple call to remove
        for(var i=0; i<10; i++){
            $("."+id.val()).remove();
        }
    }

    $('.form-submit').on('submit',function(){
        $('.btn-submit').attr("disabled", true);
    });

    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });

    $('input[name=all_employee]').on('ifChecked', function(event){
        $(".name_loading").html(loadingState);
        $(".inclusive_name").hide();
        setTimeout(function(){
            $('.list_inclusive_name').val(<?php echo $all_user?>).trigger('change');
            $(".name_loading").html('');
            $(".inclusive_name").show();
        },500);
    });

    $('input[name=all_employee]').on('ifUnchecked', function(event){
        $(".name_loading").html(loadingState);
        $(".inclusive_name").hide();
        setTimeout(function(){
            $('.list_inclusive_name').val(<?php echo $inclusive_name?>).trigger('change');
            $(".name_loading").html('');
            $(".inclusive_name").show()
        },500);
    });

    function clear_name()
    {
        $('input[name=all_employee]').iCheck('uncheck');
        $(".name_loading").html(loadingState);
        $(".inclusive_name").hide();
        setTimeout(function(){
            $('.list_inclusive_name').val('').trigger('change');
            $(".name_loading").html('');
            $(".inclusive_name").show();
        },500);
    }

    function warning(data){
        if(data == 'update')
            var message = "Cannot update if your OFFICE_ORDER is already approved..";
        else if(data == 'proceed')
            var message = "Cannot proceed if your OFFICE_ORDER is already approved..";
        else if(data == 'barcode')
            var message = "Please proceed you're form into version 2 before you generate the barcode version 3!";
        Lobibox.alert('info', //AVAILABLE TYPES: "error", "info", "success", "warning"
        {
            msg: message
        });
    }

    approved($("#get_director"));
    function approved(data){
        if(data.val() == 'Jaime S. Bernadas, MD, MGM, CESO III')
            $(".director").val('Director IV');
        else if(data.val() == 'Ruben S. Siapno,MD,MPH')
            $(".director").val('Director III');
        else if(data.val() == 'Ellenietta HMV N. Gamolo,MD,MPH,CESE')
            $(".director").val('Director III');
        else
            $(".director").val('');
    }

    function selectSection(result){
        $(".name_loading").html(loadingState);
        $(".inclusive_name").hide();
        var sectionArray = [];
        console.log(sectionArray);
        $.each(<?php echo $users; ?>,function(index,data){
            if( result.val() == data.section_id ){
                sectionArray.push(data.userid);
            }
        });

        setTimeout(function(){
            $('.list_inclusive_name').val(sectionArray).trigger('change');
            $(".name_loading").html('');
            $(".inclusive_name").show()
        },500);

    }

</script>