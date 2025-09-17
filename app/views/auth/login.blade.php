<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>DOHRO7 HRMIS | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('public/assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/AdminLTE.min.css') }}">
    <link rel="icon" href="{{ asset('public/img/favicon.png') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  </head>
  <body class="hold-transition login-page" style="background-color:#E8F5FD;">
    @if(Session::has('ok'))
        <div class="row">
            <div class="alert alert-success text-center">
                <strong class="text-center">{{ Session::get('ok') }}</strong>
            </div>
        </div>
    @endif
    <div class="login-box">
      <div class="login-logo">
        <img src="{{ asset('public/img/doh.png') }}" style="width: 20%" />
        <br>
        <h3 >DOH DTR</h3>
      </div><!-- /.login-logo -->
          <div class="login-box-body">
              @if(Session::has('ops'))
                  <div class="has-feedback text-center alert-danger">
                      {{ Session::get('ops') }}
                  </div><br>
              @endif
                  <form role="form" method="POST" action="{{ asset('/') }}" autocomplete="off">
                      <div class="form-group has-feedback {{ Session::has('ops') ? ' has-error' : '' }}">
                        <input id="username" value="@if(Session::has('username')){{ Session::get('username') }}@endif" type="text" placeholder="Login using your ID No." class="form-control" name="username">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                      </div>
                      <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                      <div class="form-group has-feedback{{ Session::has('ops') ? ' has-error' : '' }}">
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                      </div>
                        <div class="row">
                            <div class="col-xs-8">
                                <div class="form-group">
                                    <label style="cursor:pointer;">
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                                <!--
                                <a data-url="{{ asset('open/reset') }}" class="btn btn-info" id="btn_reset">Reset Password</a>
                                -->
                            </div><!-- /.col -->
                            <div class="col-xs-4">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>

                            </div><!-- /.col -->
                        </div>
                  </form>
                  <div class="row">
                    <br>
                    <div class="col-md-12">
                        <a href="{{ asset('public/apk/version_4/dtr.apk') }}" target="_blank" type="button" class="btn btn-success" download><i class="fa fa-mobile-phone"></i> <small>Mobile DTR(apk) v4.1.0</small></a>
                        <!--
                        <a href="{{ asset('public/apk/dtr_office.apk') }}" target="_blank" type="button" class="btn btn-warning" download><i class="fa fa-mobile-phone"></i> <small>Mobile DTR CV-CHD Edition v1.4.0 for OFFICE</small></a>
                        -->
                    </div>
                    <!--
                    <a href="https://drive.google.com/drive/folders/100ARffzYqtT4BdWK-9rem8_8Zm6UCOUi" target="_blank">DTR MANUAL</a>
                    -->
                  </div>
                  <!-- <div class="row">
                      <div class="col-md-12">
                          <h5>Search your ID No. here</h5>
                          <form action="{{ asset('search/id') }}" method="GET">
                              <input type="text" name="q" class="form-control" placeholder="Search using your firstname or lastname">
                          </form>
                          <table class="table">
                              @if(isset($users) AND count($users) > 0)
                                  <tr>
                                      <th>UserID</th>
                                      <th>Employee Name</th>
                                  </tr>
                                  @foreach($users as $user)
                                      <tr>
                                          <td><span style="font-weight:bolder;color:orange;">{{ $user->userid }}</span></td>
                                          <td>{{ $user->fname . " " . $user->lname}}
                                      </tr>
                                  @endforeach
                              @endif
                          </table>
                      </div>
                  </div> -->
            </div><!-- /.login-box-body -->



    </div><!-- /.login-box -->
    @include('auth.modal')
    <!-- jQuery 2.1.4 -->
    <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="{{ asset('public/assets/js/bootstrap.min.js') }}"></script>
    <script>
        $("#btn_reset").click(function(e){
            e.preventDefault();
            $("#reset_modal").modal("show");
        });
    </script>
    <!-- iCheck -->
  </body>
</html>
