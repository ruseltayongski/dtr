
@extends('layouts.app')

@section('content')

    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h4 class="page-header">Print Individual DTR
            </h4>
            <div class="container">
                <div class="row">
                    <div class="col-md-11">
                        <form action="{{ asset('FPDF/test.php') }}" method="POST">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-md-2 control-label">User ID</label>
                                        <div class="col-sm-5">
                                            @if(Auth::user()->usertype == "1")
                                                <input type="text" class="col-md-2 form-control" id="inputEmail3" name="userid" value="" required>
                                            @else
                                                <input type="text" readonly class="col-md-2 form-control" id="inputEmail3" name="userid" value="{{ Auth::user()->userid }}" required>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-md-2 control-label">Inclusive Dates</label>
                                        <div class="col-sm-5">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control" id="inclusive3" name="filter_range" placeholder="Input date range here..." required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <div class="col-sm-5 col-md-offset-2">
                                            <input type="submit" name="submit" class="btn btn-success" value="Print">
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
