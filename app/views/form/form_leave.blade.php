@extends('layouts.app')

@section('content')
    <style>
        tbody tr td:first-child{
            color: red;
        }
        tbody tr td:last-child{
            color: red;
        }
    </style>
    <div class="panel panel-default">
        <label class="text-success">Vacation Balance: <span class="badge bg-blue">{{ Session::get("vacation_balance") }}</span></label>
        <label class="text-danger">Sick Balance: <span class="badge bg-red">{{ Session::get("sick_balance") }}</span></label>
        <div class="alert alert-info"><strong>APPLICATION FOR LEAVE</strong> - (<small>CSC Form No.6 Revised 1998</small>)</div>
        <form action="{{ asset('form/leave') }}" method="POST">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" id="token" name="_token" value="<?php echo csrf_token(); ?>">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group has-success">
                                    <label class="control-label" for="inputSuccess1">(1.) Office/Agency</label>
                                    <input type="text" class="form-control" id="inputSuccess1" name="office_agency" value="DOH Central Visayas CHD">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group has-success">
                                    <label class="control-label" for="inputSuccess1">(2.)  Last Name</label>
                                    <input type="text" class="form-control" id="inputSuccess1" name="lastname" value="{{ $user->lname }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group has-success">
                                    <label class="control-label" for="inputSuccess1">First Name</label>
                                    <input type="text" class="form-control" id="inputSuccess1" name="firstname" value="{{ $user->fname }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group has-success">
                                    <label class="control-label" for="inputSuccess1">Middle Name</label>
                                    <input type="text" class="form-control" id="inputSuccess1" name="middlename" value="{{ $user->mname }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 has-success">
                                <label class="control-label" for="inputSuccess1">(3.) Date of Filling</label>
                                <input type="text" class="form-control" name="date_filling" value="{{ date("Y-m-d") }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group has-success">
                                    <label class="control-label" for="inputSuccess1">(4.)  Position</label>
                                    <input type="text" class="form-control" id="inputSuccess1" name="position" value="{{ $user->designation }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group has-success">
                                    <label class="control-label" for="inputSuccess1">(5.)Salary (Monthly)</label>
                                    <input type="text" class="form-control" id="inputSuccess1" name="salary" value="{{ $user->monthly_salary }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="alert alert-info"><strong>DETAILS OF APPLICATION</strong></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>(6a) TYPE OF LEAVE</strong>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="has-success">
                                                @foreach($leave_type as $row)
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="radio" class="minimal" id="leave_type" name="leave_type" onclick="dateRangeFunc('{{ $row->main_leave }}')" value="{{ $row->code }}" required>
                                                            {{ $row->desc }}
                                                            @if($row->code == 'Sick')
                                                            <div class="additional_sick"></div>
                                                            @endif
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <strong>(6c.) NUMBER OF WORKING DAYS APPLIED FOR :</strong>
                                <input type="text" class="form-control" name="applied_num_days" id="applied_num_days" readonly/>
                                <input type="hidden" class="form-control" name="credit_used" id="credit_used"/>
                                <div class="form-group inc_date_body"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <strong>(6b) WHERE LEAVE WILL BE SPENT</strong>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="has-success">
                                                    <div class="checkbox">
                                                        <label>(1.)In case of vacation leave</label>
                                                    </div>
                                                </div>
                                                <div class="has-success">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="radio" id="checkboxSuccess" class="vac_dis vac_dis_radio" value="local" name="vacation_loc">
                                                            Within the Philippines
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="has-success">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="radio" id="checkboxSuccess" class="vac_dis vac_dis_radio" value="abroad" name="vacation_loc">
                                                            Abroad (specify)
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="has-success">
                                                    <div class="form-group has-success">
                                                        <textarea type="text" class="form-control vac_dis vac_dis_txt" maxlength="200" id="inputSuccess1" name="abroad_others"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="has-success">
                                                    <div class="checkbox">
                                                        <label>(2.)In case of sick leave</label>
                                                    </div>
                                                </div>
                                                <div class="has-success">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="radio" id="checkboxSuccess" class="sic_dis sic_dis_radio" value="in_hostpital" name="sick_loc">
                                                            In Hospital (sepecify)
                                                            <input type="text"  name="in_hospital_specify" class="sic_dis sic_dis_txt" id="in_hos_txt" />
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="has-success">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="radio" id="checkboxSuccess" value="out_patient" name="sick_loc" class="sic_dis sic_dis_radio">
                                                            Out-patient (sepecify)
                                                            <input type="text" name="out_patient_specify" class="sic_dis sic_dis_txt" id="out_hos_txt" />
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <strong>(6d) COMMUTATION</strong>
                                    <div class="has-success">
                                        <div class="checkbox">
                                            <label>
                                                <input type="radio" id="checkboxSuccess" value="yes" name="com_requested">
                                                Requested
                                            </label>
                                            <label>
                                                <input type="radio" id="checkboxSuccess" value="no" name="com_requested">
                                                Not Requested
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding: 1%">
                        <div class="col-md-12 float-right">
                            <button type="submit" name="submit" class="btn btn-primary btn-lg">Submit</button>
                        </div>
                    </div>
                </div>
            </div> <!-- PANEL BODY -->
        </form>
    </div>
@endsection
@section('js')
    @parent
    @include('form.form_leave_script')
    <script>

        $('input[name="leave_type"]').change(function(){

            var val = this.value;
        
            if(val == "Vacation")
            {
                vac_radio_txt(false,false,'');
                sick_radio_txt(true,false,'');
                others1_txt(true,'');
                others2_txt(true,'');

            } else if(val == "To_sake_employement") 
            {
                vac_radio_txt(true,false,'');
                sick_radio_txt(true,false,'');
                others1_txt(true,'');
                others2_txt(true,'');

            } else if(val == "Others")
            {
                vac_radio_txt(true,false,'');
                sick_radio_txt(true,false,'');
                others1_txt(false,'');
                others2_txt(true,'');
            } else if(val == "Sick") 
            {
                vac_radio_txt(true,false,'');
                sick_radio_txt(false,false,'');
                others1_txt(true,'');
                others2_txt(true,'');

            } else if(val == "Maternity")
            {
                vac_radio_txt(true,false,'');
                sick_radio_txt(true,false,'');
                others1_txt(true,'');
                others2_txt(true,'');
            } else if(val == "Others2")
            {
                vac_radio_txt(true,false,'');
                sick_radio_txt(true,false,'');
                others1_txt(true,'');
                others2_txt(false,'');
            }
            
        });

       $('input[name="vacation_loc"]').change(function(){
            var val = this.value;
            if(val == "local")
            {
                $('.vac_dis_txt').prop('disabled', true).val('');
            } else if(val == "abroad"){
                $('.vac_dis_txt').prop('disabled', false).val('');

            }
       });

       $('input[name="in_hostpital"]').change(function(){
            var val = this.attr('checked');
            alert(val);
       });
    
        $('input[name="sick_loc"]').change(function(){
            var val = this.value;
            if(val == "in_hostpital")
            {
                $('#in_hos_txt').prop('disabled', false).val('');
                $('#out_hos_txt').prop('disabled',true).val('');
            }else if(val == "out_patient")
            {
                $('#out_hos_txt').prop('disabled',false).val('');
                $('#in_hos_txt').prop('disabled', true).val('');
            }
        }); 

         $('#in_hos_txt').prop('disabled', true);
         $('#out_hos_txt').prop('disabled',true);
        function vac_radio_txt(state,checked,txt_val)
        {
            $('.vac_dis').prop('disabled', state);
            $('.vac_dis_txt').val(txt_val);
            $('.vac_dis_txt').prop('disabled', state);
            $('.vac_dis_radio').prop('checked', checked);
        }
        function sick_radio_txt(state,checked,txt_val)
        {
             $('.sic_dis').prop('disabled', state);
             $('.sic_dis_radio').prop('disabled', state);
             $('.sic_dis_radio').prop('checked', checked);
             $('.sic_dis_txt').val(state);
             $('.sic_dis_txt').val(txt_val);   
        }

        function others1_txt(state,txt_val)
        {
            $('.others1_txt').val(txt_val);
            $('.others1_txt').prop('disabled', state);
            
        }
        function others2_txt(state,txt_val)
        {
            $('.others2_txt').val(txt_val);
            $('.others2_txt').prop('disabled', state);
        }


        function validate(evt) {
            var theEvent = evt || window.event;
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode( key );
            var regex = /[0-9]|\./;
            if( !regex.test(key) ) {
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
            }
            
        }

    </script>
@endsection