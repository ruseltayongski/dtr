
@extends('layouts.app')

@section('content')
<div class="container">
    @if(Session::has('not_match'))
        <div class="row">
            <div class="alert alert-danger">
                <strong class="text-center">{{ Session::get('not_match') }}</strong>
            </div>
        </div>
    @endif
    @if(Session::has('error'))
        <div class="row">
            <div class="alert alert-danger">
                <ul>
                    @foreach(Session::get('error')->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    <li>Password must contain at least one uppercase or lowercase letters and one number</li>
                </ul>
            </div>
        </div>
    @endif
    @if(Session::has('pass_change'))
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-info-sign"></span>
            {{ Session::get('pass_change') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Change Password</div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ asset('resetpass')  }}">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Current password</label>
                            <div class="col-md-6">
                                <input id="email" type="password" class="form-control" name="current_password" required />
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required />
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-btn fa-send"></i> Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
    