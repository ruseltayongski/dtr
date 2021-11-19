@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">AREA OF ASSIGNMENT</strong></div>
                <div class="panel-body">
                    <div class="row">
                        <form class="form-inline" method="POST" action="{{ asset('area-assignment/search') }}" id="searchForm">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <div class="col-md-8">
                                <input type="text" class="form-control" value="{{ Session::get('keyword') }}" name="keyword" style="width: 100%" placeholder="Area">
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                            @if(Auth::user()->usertype == 1)
                                <a href="#add_area" data-link="{{ asset('area-assignment/add') }}" class="btn btn-success" data-dismiss="modal" data-backdrop="static" data-toggle="modal" style="background-color:#1099;color: white;">
                                    <i class="fa fa-plus"></i> 
                                    Add new
                                </a>
                            @endif
                        </form>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-md-12">
                            @if(isset($area) and count($area) > 0)
                                <div class="table-responsive">
                                    <table class="table table-list table-hover table-striped">
                                        <thead>
                                        <tr>
                                            <th width="40%">Name of Area</th>
                                            <th width="15%" class="text-center">Latitude</th>
                                            <th width="15%" class="text-center">Longitude</th>
                                            <th width="15%" class="text-center">Radius</th>
                                            <th width="15%"></th>
                                        </tr>
                                        </thead>
                                        <tbody style="font-size: 10pt;">
                                        @foreach($area as $a)
                                            <tr>
                                                <td>
                                                    <a class="title-info" style="color: #f0ad4e;" data-backdrop="static" data-link="{{ asset('area-assignment/info/'.$a->id) }}" href="#area_info" data-toggle="modal">{{ $a->name }}</a>
                                                </td>

                                                <td class="text-center">{{ $a->latitude }}</td>
                                                <td class="text-center">{{ $a->longitude }}</td>
                                                <td class="text-center">{{ $a->radius }}</td>
                                                <td class="text-center">
                                                    <a class="title-info" style="color: #f0ad4e;" data-backdrop="static"  href="#area_delete" data-toggle="modal"  onclick="DeleteArea({{ $a->id }})">
                                                        <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                                    </a>
                                                    <a class="title-info" style="color: #f0ad4e;" data-backdrop="static" data-link="" href="#view_map" data-toggle="modal">
                                                        <button class="btn btn-success">
                                                            <i class="fa fa-map-o"></i> &nbsp View Map
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $area->links() }}
                            @else
                                <div class="alert alert-danger" role="alert"><span style="color:white;">No areas of assignment found.</span></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal m fade" role="dialog" id="add_area" style="overflow-y:scroll;">
        <div class="modal-dialog modal-m">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#9C8AA5;padding:15px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="color: white"></i>Area of Assignment</h4>
                </div>
                <div class="modal-body">
                    <div class="modal_content"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal m fade" role="dialog" id="area_info" style="overflow-y:scroll;">
        <div class="modal-dialog modal-m">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#9C8AA5;padding:15px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="color: white"></i>Update Area of Assignment</h4>
                </div>
                <div class="modal-body">
                    <div class="modal_content"></div>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ asset('area-assignment/delete') }}">
        <div class="modal modal-danger sm fade" id="area_delete" style="overflow-y:scroll;">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                        <div class="modal-header" style="background-color:red;">
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <input type="hidden" name="id_delete" class="id_delete">
                            <strong>Are you sure you want to delete?</strong>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">No</button>
                            <button type="submit" class="btn btn-outline"><i class="fa fa-trash"></i> Yes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </form>

@endsection
@section('js')
    <script>
        @if(Session::get('notif') != null)
        Lobibox.notify('info',{
            msg:"<?php echo Session::get('notif');?>",
            size: 'mini',
            rounded: true
        });
        @endif

        $("a[href='#area_info']").on('click',function(){
            $('.modal_content').html(loadingState);
            var url = $(this).data('link');
            setTimeout(function(){
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        $('.modal_content').html(data);
                    }
                });
            },500);
        });

        $("a[href='#add_area']").on('click',function(e){
            $('.modal_content').html(loadingState);
            var url = $(this).data('link');
            setTimeout(function(){
                $.ajax({
                    url: url,
                    type: 'POST',
                    success: function(data) {
                        $('.modal_content').html(data);
                    }
                });
            },500);
        });

        function DeleteArea(id){
            $(".id_delete").val(id);
        }
    </script>

@endsection
