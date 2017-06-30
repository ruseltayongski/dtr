@extends('layouts.app')

@section('content')
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h3 class="page-header">Add new attendance
            </h3>
            <div class="container">
                <div class="row">
                    <div class="col-md-11">
                        <form action="{{ asset('add/attendance') }}" method="POST">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-md-2 control-label">User ID</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="col-md-2 form-control" id="inputEmail3" name="userid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-md-2 control-label">Department</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="inputEmail3" value="GENERAL" readonly name="department">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-md-2 control-label">Firstname</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="inputEmail3" name="firstname">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-md-2 control-label">Lastname</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="inputEmail3" name="lastname">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group  input-daterange">
                                        <label class="control-label col-md-2" for="inputSuccess1">Date In</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" name="datein" value="2012-04-05">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-md-2 control-label">Event Time</label>
                                        <div class="col-sm-5">
                                            <input id="input-a" value="" data-default="20:48" name="time" class="form-control clock" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-md-2 control-label">Event</label>
                                        <div class="col-sm-5">
                                            <select name="event" class="col-md-2 form-control">
                                                <option value="IN">IN</option>
                                                <option value="OUT">OUT</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-md-2 control-label">Terminal</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="col-md-2 form-control" value="WEB" readonly name="terminal">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-md-2 control-label">Remarks</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="col-md-2 form-control" value="WEB" readonly name="remarks">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <div class="col-sm-5 col-md-offset-2">
                                            <input type="submit" name="submit" class="btn btn-success" value="Submit">
                                            <a href="{{ asset('home') }}" class="btn btn-default">Cancel</a>
                                        </div>
                                    </div>
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

        var input = $('#input-a');
        input.clockpicker({
            autoclose: true,
            placement : 'top',
            align : 'left',
            donetext : 'Ok',
            'default' : '8:00'
        });

        $('.input-daterange input').each(function() {
            $(this).datepicker("clearDates");
        });

    </script>

@endsection
