@extends('layouts.app')


@section('content')
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h3 class="page-header">Create Application for Leave
            </h3>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-11">
                        <form action="{{ asset('form/leave') }}" method="POST">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group has-success">
                                        <label class="control-label" for="inputSuccess1">(1.) Office/Agency</label>
                                        <input type="text" class="form-control" id="inputSuccess1" name="office_agency" value="DOH 7">
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
                            <hr />
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group has-success  input-daterange">
                                        <label class="control-label" for="inputSuccess1">(3.) Date of Filling</label>
                                        <input type="text" class="form-control" name="date_filling" value="2012-04-05">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-success">
                                        <label class="control-label" for="inputSuccess1">(4.)  Position</label>
                                        <input type="text" class="form-control" id="inputSuccess1" name="position">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group has-success">
                                        <label class="control-label" for="inputSuccess1">(5.)Salary (Monthly)</label>
                                        <input type="text" class="form-control" id="inputSuccess1" name="salary">
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <h3 class="text-center">Details of Application</h3>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="alert alert-success">
                                        <strong>(6a) Type of Leave</strong>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="has-success">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="radio" id="checkboxSuccess" value="Vication" name="leave_type">
                                                                Vacation
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="has-success">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="radio" id="checkboxSuccess" value="To_sake_employement" name="leave_type">
                                                                To seek employement
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="has-success">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="radio" id="radio_others" value="Others" name="leave_type" />
                                                                Others(Specify)
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="has-success">
                                                        <div class="form-group has-success">
                                                            <textarea type="text" class="form-control" maxlength="200" id="inputSuccess1" name="leave_type_others_1"></textarea>
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
                                                            <label>
                                                                <input type="radio" id="checkboxSuccess" value="Sick" name="leave_type" />
                                                                Sick
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="has-success">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="radio" id="checkboxSuccess" value="Maternity" name="leave_type" />
                                                                Maternity
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="has-success">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="radio" id="checkboxSuccess" value="Others2" name="leave_type">
                                                                Others(Specify)
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="has-success">
                                                        <div class="form-group has-success">
                                                            <textarea type="text" class="form-control" maxlength="200" id="inputSuccess1" name="leave_type_others_2"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <strong>(6c.)Number of working days applied <br />For :</strong>
                                        <input type="text" name="applied_num_days" />
                                        <div class="form-group">
                                            <label class="control-label" for="inputSuccess1">Inclusive Dates :</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control" id="inc_date" name="inc_date" placeholder="Input date range here..." required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="alert alert-success">
                                        <strong>(6b) Where leave will be spent</strong>
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
                                                                <input type="radio" id="checkboxSuccess" class="vic_dis" value="local" name="vication_loc">
                                                                Within the Philippines
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="has-success">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="radio" id="checkboxSuccess" class="vic_dis" value="abroad" name="vication_loc">
                                                                Abroad (specify)
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="has-success">
                                                        <div class="form-group has-success">
                                                            <textarea type="text" class="form-control vic_dis" maxlength="200" id="inputSuccess1" name="abroad_others"></textarea>
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
                                                                <input type="radio" id="checkboxSuccess"  class="sic_dis" value="in_hostpital" name="sick_loc">
                                                                In Hospital (sepecify)
                                                                <input type="text"  name="in_hospital_specify" class="sic_dis" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="has-success">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="radio" id="checkboxSuccess" value="out_patient" name="sick_loc" class="sic_dis">
                                                                Out-patient (sepecify)
                                                                <input type="text" name="out_patient_specify" class="sic_dis" />
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <strong>(6d) Communication</strong>
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
                                        <div class="has-success text-center">
                                            <br />
                                            <br />
                                            <p style="border-top: solid 2px black; width: 100%;">Signature</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <h3 class="text-center">Details of Action on Application</h3>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="alert alert-success">
                                        <div class="form-group has-success  input-daterange">
                                            <label class="control-label" for="inputSuccess1">(7a) Certification of leave credits <br /> as of :</label>
                                            <input type="text" class="form-control" name="credit_date" value="2012-04-05">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tr>
                                                            <th>Vacation</th>
                                                            <th>Sick</th>
                                                            <th>Total</th>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <input type="text" name="vation_total"> days
                                                            </td>
                                                            <td>
                                                                <input type="text" name="sick_total"> days
                                                            </td>
                                                            <td>
                                                                <input type="text" name="over_total"> days
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <br />
                                                <u style="text-decoration: underline solid; color: #000; width: 100%;"><b>REBECCA Q. BULAWAN</b></u>
                                                <br />
                                                <strong>ADMINISTRATIVE OFFICER V</strong>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <hr style="border: dashed; " />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <strong>(7c.) Approved For :</strong>
                                                <div class="form-group">
                                                    <div class="has-success">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="text" name="a_days_w_pay" size="5"/>
                                                                day(s) with pay
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="text" name="a_days_wo_pay" size="5"/>
                                                                day(s) without pay
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="text" name="a_others" size="5"/>
                                                                others (specify)
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="alert alert-success">
                                        <strong>(7b.)Recommendation</strong>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="has-success">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="radio" id="checkboxSuccess" value="approve" name="reco_approval">
                                                                Approval
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="has-success">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="radio" id="checkboxSuccess" value="disapprove" name="reco_approval">
                                                                Disapproval
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="has-success">
                                                        <div class="form-group has-success">
                                                            Due to :
                                                            <textarea type="text" class="form-control" maxlength="200" id="inputSuccess1" name="reco_disaprove_due_to"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <br />
                                                <br />
                                                <p style="border-top: solid 2px black; width: 100%;">Authorized Official</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <strong>(7d.) DISAPPROVED DUE TO:</strong>
                                                <textarea type="text" class="form-control" maxlength="200" id="inputSuccess1" name="disaprove_due_to"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <h3 class="text-center">By Authority of the Secretary of Health</h3>
                                <div class="col-md-12">
                                    <br />
                                    <br /><br />
                                    <div class="row has-success">
                                        <div class="col-md-3">
                                            <p class="text-center" style="border-top: solid 2px black; width: 100%;">Date</p>
                                        </div>

                                        <div class="col-md-6">
                                            <p class="text-center" style="border-top: solid 2px black; width: 100%;">Authorized Official</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <br />
                            <div class="row">
                                <div class="col-md-12 center-block">
                                    <button type="submit" name="submit" class="btn btn-primary btn-lg col-md-5">Submit</button>
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
    @@parent
    <script>
        $('.input-daterange input').each(function() {
            $(this).datepicker("clearDates");
        });
        $('#inc_date').daterangepicker();
        $('input[name="leave_type"]').change(function(){
            var val = this.value;

            if(val != "Vication") {
                $('.vic_dis').prop('disabled', true);
            } else {
                $('.vic_dis').prop('disabled', false);
            }

            if(val != "Sick") {
                $('.sic_dis').prop('disabled', true);
            } else {
                $('.sic_dis').prop('disabled', false);
            }
        });
    </script>
@endsection