
@extends('layouts.app')

@section('content')
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">Add new user
            </h2>
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <form action="{{ asset('add/user') }}" method="POST" class="form-horizontal">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Userid</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputEmail3" value="{{ str_pad($lastUserid+1, 4, '0', STR_PAD_LEFT) }}" name="userid" placeholder="Userid">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Firstname</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputEmail3" name="fname" placeholder="Firstname" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Lastname</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputEmail3" name="lname" placeholder="Lastname" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Work Schedule</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="sched" required>
                                        <option value="">Select Schedule</option>
                                        @if(isset($scheds) and count($scheds) > 0)
                                            @foreach($scheds as $sched)
                                                <option value="{{ $sched->id }}">{{ $sched->description }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Job Status</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="emptype" required>
                                        <option value="JO">Job Order</option>
                                        <option value="REG">Regular</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-5">
                                    <button type="submit" class="btn btn-lg btn-success">Submit</button>
                                    <a href="{{ asset('/') }}" class="btn btn-lg btn-default">Cancel</a>
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
        @if(Session::has('useridExist'))
        Lobibox.notify('error', {
            position: 'center top',
            msg: "<?php echo Session::get('useridExist'); ?>"
        });
        @endif

        var input = $('#input-a');
        input.clockpicker({
            autoclose: true,
            placement : 'top',
            align : 'left',
            donetext : 'Ok',
            'default' : '8:00'
        });

        var input = $('#input-b');
        input.clockpicker({
            autoclose: true,
            placement : 'top',
            align : 'left',
            donetext : 'Ok',
            'default' : '12:00'
        });

        var input = $('#input-c');
        input.clockpicker({
            autoclose: true,
            placement : 'top',
            align : 'left',
            donetext : 'Ok',
            'default' : '13:00'
        });

        var input = $('#input-d');
        input.clockpicker({
            autoclose: true,
            placement : 'top',
            align : 'left',
            donetext : 'Ok',
            'default' : '17:00'
        });

        $('.input-daterange input').each(function() {
            $(this).datepicker("clearDates");
        });

    </script>

@endsection
