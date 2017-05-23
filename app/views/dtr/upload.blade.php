@extends('layouts.app')

@section('content')
    <div class="col-md-12 wrapper" id="upload_body">
        <div class="alert alert-jim">
            <h3 class="page-header">Upload DTR File
            </h3>
            <div class="container">
                <div class="row">
                    <div class="col-md-11">
                        <div class="alert alert-warning alert-dismissible col-lg-12" role="alert">
                            <strong>Warning!</strong>You selected an invalid file. Select a file that ends with .txt file extension.
                        </div>
                        <div class="row upload-section">
                            <div class="alert-success alert col-md-8 col-lg-offset-2">
                                <form id="form_upload" action="{{ asset('admin/upload') }}" method="POST" enctype="multipart/form-data">
                                    <h3 style="font-weight: bold;" class="text-center">Upload a file</h3>
                                    <div class="modal-body">
                                        <table class="table table-hover table-form table-striped">
                                            <tr class="alert-info">
                                                <td class="col-sm-3"><label>Remarks</label></td>
                                                <td class="col-sm-1">:</td>
                                                <td class="col-sm-5"><input  value=""  name="remarks" class="form-control" required></td>
                                            </tr>
                                            <tr>
                                                <td class="col-sm-3"><label>Inclusive Dates</label></td>
                                                <td class="col-sm-1">:</td>
                                                <td class="col-sm-5">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control" id="inclusive2" name="filter_range" placeholder="Input date range here..." required>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-sm-3"><label>Browse File</label></td>
                                                <td class="col-sm-1">:</td>
                                                <td class="col-sm-5">
                                                    <input id="file" type="file"  class="hidden" value="" name="dtr_file" onchange="readFile(this);"/>
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                    <p class="text-center" id="file_select" style="border: dashed;padding:20px;">
                                                        Click here to select a file
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                        <button type="submit"  class="btn-lg btn-success center-block" id="upload">
                                            <span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span> Upload File
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script>
        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('input[type="file"]').attr('value', e.target.result);
                    $('#file_select').html('<strong>'+ $('input[type="file"]').val() + '</strong>');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#file_select").click(function() {
            $('input[type="file"]').trigger("click");
        });
        (function($){
            $('.progress').hide();
            $('.alert-warning').hide();

            $('#form_upload').on('submit', function(e){
                var x = $('input[type="file"]').val();
                var arr = x.split('.');
                if(arr[1] === "txt"){
                    $('.alert-warning').hide();
                    $('a').prop('disabled',true);
                    $('#upload_loading').modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: true
                    });
                } else {
                    e.preventDefault();
                    $('.alert-warning').show();
                }
            });
        })($);

        function check_file() {
            $('#file').change(function(event){
                var file = this.files[0];
                var reader = new FileReader();
                reader.onload = function(progress){
                    var lines = this.result.split('\n');

                    for (var line = 0; line < 1;line++) {
                        if(line == 0 ){
                            console.log(lines[line]);
                            var data = lines[line].split(',');
                            if(data[0].length < 9){
                                $("#upload").prop("disabled",true);
                            }
                        }
                    }

                };
                reader.readAsText(file);
            });
        }
        $('#inclusive2').daterangepicker();
    </script>

@endsection
