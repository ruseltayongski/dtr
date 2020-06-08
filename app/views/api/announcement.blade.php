@extends('layouts.app')

@section('content')
    <h3 class="page-header">Announcement API</h3>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-list table-hover table-striped">
                <thead>
                <tr style="background-color:grey;">
                    <th>Link</th>
                    <th>Code</th>
                    <th>Message</th>
                    <th>Option</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td width="50%"><b class="text-success">{{ asset('mobile/office/announcement') }}</b></td>
                    <td>{{ $announcement_api->code }}</td>
                    <td>{{ $announcement_api->message }}</td>
                    <td >
                        <button type="button" class="btn btn-primary btn-sm update" ><span class="glyphicon glyphicon-question-sign"></span> Update</button>
                        <a href="{{ asset('mobile/office/announcement') }}" target="_blank" class="btn btn-success btn-sm" ><span class="fa fa-eye"></span> View API</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="modal_announcement_api">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content" >
                <form action="{{ asset('mobile/office/announcement/post') }}" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <table class="table table-list table-hover table-striped">
                            <tr>
                                <td>Code</td>
                                <td>
                                    <select name="code" class="form-control">
                                        <option value="0" <?php if($announcement_api->code == 0) echo 'selected'; ?>>0</option>
                                        <option value="1" <?php if($announcement_api->code == 1) echo 'selected'; ?>>1</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Message</td>
                                <td>
                                    <input type="text" class="form-control" name="message" value="{{ $announcement_api->message }}">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button type="submit" class="btn-success btn pull-right">Save</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@section('js')
    @parent
    <script>
        $(".update").click(function(){
            $('#modal_announcement_api').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        });
    </script>
@endsection
