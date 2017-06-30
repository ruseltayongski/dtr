@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>
                <div class="panel-body">
                    
                    <form class="form-horizontal" role="form" method="POST" action="http://localhost:8000/password/email">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Old Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" value="" required>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="newpass" class="col-md-4 control-label">New Password</label>

                            <div class="col-md-6">
                                <input id="newpass" type="text" class="form-control" name="newpass" value="" required>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="confirmpass" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="confirmpass" type="text" class="form-control" name="confirmpass" value="" required>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Change Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop





