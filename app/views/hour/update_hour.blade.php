

@extends('layouts.app')
@section('content')
    <div class="alert alert-jim" id="inputText">
        <h2 class="page-header">Working Schedule</h2>

        <div class="clearfix"></div>
        <div class="page-divider"></div>
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <form action="{{ asset('edit/work-schedule/' .$sched->id) }}" method="POST">
                    <div class="modal-body">
                        <table class="table table-hover table-form table-striped">
                            <tr class="alert-info">
                                <td class="col-sm-3"><label>Description</label></td>
                                <td class="col-sm-1">:</td>
                                <td class="col-sm-5"><input  value="{{ $sched->description }}"  name="description" class="form-control" required></td>
                            </tr>
                            <tr>
                                <td class="col-sm-3"><label>AM Time In </label></td>
                                <td class="col-sm-1">:</td>
                                <td class="col-sm-5"><input id="input-a" value="{{ $sched->am_in }}" data-default="20:48" name="am_in" class="form-control clock" required></td>
                            </tr>
                            <tr>
                                <td class="col-sm-3"><label>AM Time Out</label></td>
                                <td class="col-sm-1">:</td>
                                <td class="col-sm-5"><input id="input-b" value="{{ $sched->am_out }}" data-default="20:48" name="am_out" class="form-control clock" required></td>
                            </tr>
                            <tr>
                                <td class="col-sm-3"><label>PM Time In</label></td>
                                <td class="col-sm-1">:</td>
                                <td class="col-sm-5"><input id="input-c" value="{{ $sched->pm_in }}" data-default="20:48" name="pm_in" class="form-control clock" required></td>
                            </tr>
                            <tr>
                                <td class="col-sm-3"><label>PM Time Out</label></td>
                                <td class="col-sm-1">:</td>
                                <td class="col-sm-5"><input id="input-d" value="{{ $sched->pm_out }}" data-default="20:48" name="pm_out" class="form-control clock" required></td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-default" href="{{ asset('work-schedule') }}"><i class="fa fa-times"></i> Cancel</a>
                        <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> Submit</button>
                    </div>
                </form>
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
            'default' : '{{ $sched->am_in }}'
        });
        var input = $('#input-b');
        input.clockpicker({
            autoclose: true,
            placement : 'top',
            align : 'left',
            donetext : 'Ok',
            'default' : '{{ $sched->am_out }}'
        });
        var input = $('#input-c');
        input.clockpicker({
            autoclose: true,
            placement : 'top',
            align : 'left',
            donetext : 'Ok',
            'default' : '{{ $sched->pm_in }}'
        });
        var input = $('#input-d');
        input.clockpicker({
            autoclose: true,
            placement : 'top',
            align : 'left',
            donetext : 'Ok',
            'default' : '{{ $sched->pm_out }}'
        });
        $('.clock').keyup(function(){
            $(this).val(null);
        });
    </script>
@endsection

