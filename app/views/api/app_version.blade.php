@extends('layouts.app')

@section('content')
    <h3 class="page-header">App Version API</h3>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-list table-hover table-striped">
                <thead>
                <tr style="background-color:grey;">
                    <th>Link</th>
                    <th>Message</th>
                    <th>Code</th>
                    <th style="width:200px">Latest Version</th>
                    <th>Option</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td width="50%"><b class="text-warning">{{ asset('mobile/office/version') }}</b></td>
                    <td>{{ $app_version_api->message }}</td>
                    <td>{{ $app_version_api->code }}</td>
                    <td>{{ $app_version_api->latest_version }}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm update" style="width:100px"><span class="glyphicon glyphicon-question-sign"></span> Update</button>
                        <a href="{{ asset('mobile/get/version/' . $app_version_api->device_type) }}" target="_blank" class="btn btn-success btn-sm" style="width:100px"><span class="fa fa-eye"></span> View API</a>
                        {{--<a href="{{ asset('mobile/office/force-update/'. $app_version_api->id) }}" target="_blank" class="btn btn-warning btn-sm" style="width:100px" ><span class="fa fa-eye"></span>Force Update</a>--}}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="modal_app_version_api">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content" >
                <form action="{{ asset('mobile/office/version/post') }}" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <table class="table table-list table-hover table-striped">
                            <tr>
                                <td>Message</td>
                                <td>
                                    <textarea name="message" class="form-control" id="" cols="30" rows="10">{{ $app_version_api->message }}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>Code</td>
                                <td>
                                    <select name="code" class="form-control">
                                        <option value="0" <?php if($app_version_api->code == 0) echo 'selected'; ?>>0</option>
                                        <option value="1" <?php if($app_version_api->code == 1) echo 'selected'; ?>>1</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Latest Version</td>
                                <td>
                                    <input type="text" class="form-control" name="latest_version" value="{{ $app_version_api->latest_version }}">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button type="submit" class="btn-success btn pull-right">Save</button>
                                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
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
            $('#modal_app_version_api').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        });
    </script>
@endsection
