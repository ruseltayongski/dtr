
@extends('layouts.app')

@section('content')
    @if(Session::has('msg'))
        <div class="alert alert-success">
            <strong>{{ Session::get('msg') }}</strong>
        </div>
    @endif
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h4 class="page-header">Reset Password
            </h4>
            <div class="container">
                <div class="row">
                    <div class="col-md-11">
                        <form action="{{ asset('reset/password') }}" method="POST">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-md-2 control-label">User ID</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="col-md-2 form-control" id="inputEmail3" name="userid" value="" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <div class="col-sm-5 col-md-offset-2">
                                            <button type="submit"  class="btn btn-success">Reset</button>
                                            <a href="{{ asset('/') }}" class="btn btn-default">Cancel</a>
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

        $('#inclusive3').daterangepicker();
    </script>

@endsection
