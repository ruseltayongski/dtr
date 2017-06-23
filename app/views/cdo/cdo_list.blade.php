@extends('layouts.app')
@section('content')

    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">
            <h3 class="page-header">Compensatory Time Off
            </h3>
            <div class="row">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Option</strong></div>
                                <div class="panel-body">
                                    <form class="form-inline" method="POST" action="{{ asset('form/cdo_list') }}" onsubmit="return searchDocument();" id="searchForm">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <td class="col-sm-3" style="font-size: 12px;"><strong>Keyword</strong></td>
                                                    <td class="col-sm-1">: </td>
                                                    <td class="col-sm-9">
                                                        <input type="text" class="col-md-2 form-control" id="inputEmail3" value="{{ Session::get('keyword') }}" name="keyword" placeholder="Route no, Subject">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-sm-3" style="font-size: 12px;"><strong>Dates</strong></td>
                                                    <td class="col-sm-1"> :</td>
                                                    <td class="col-sm-9">
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </div>
                                                            <input type="text" class="form-control" id="inclusive3" name="filter_range" placeholder="Input date range here...">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <button type="submit" name="search" class="btn-lg btn-success center-block col-sm-12" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Printing DTR">
                                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#approve" data-toggle="tab">Approve</a></li>
                                    <li><a href="#disapprove" data-toggle="tab">Dissaprove</a></li>
                                </ul>
                                <div class="tab-content">
                                    {{--APPROVE--}}
                                    <div class="active tab-pane" id="approve">
                                        <div class="panel panel-default">
                                            <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">List</strong></div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        @if($type == "list")
                                                            <a href="#document_form" data-link="{{ asset('form/cdov1/form') }}" class="btn btn-success" data-dismiss="modal" data-backdrop="static" data-toggle="modal" data-target="#document_form" style="background-color:darkmagenta;color: white;"><i class="fa fa-plus"></i> Create new</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <br />
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="ajax_approve">
                                                            @include('cdo.cdo_approve')
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{--DISAPPROVE--}}
                                    <div class="tab-pane" id="disapprove">
                                        <div class="panel panel-default">
                                            <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">List</strong></div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        @if($type == "list")
                                                            <a href="#document_form" data-link="{{ asset('form/cdov1/form') }}" class="btn btn-success" data-dismiss="modal" data-backdrop="static" data-toggle="modal" data-target="#document_form" style="background-color:darkmagenta;color: white;"><i class="fa fa-plus"></i> Create new</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <br />
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="ajax_disapprove">
                                                            @include('cdo.cdo_disapprove')
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        $("#inclusive3").daterangepicker();
        $('.input-daterange input').each(function() {
            $(this).datepicker("clearDates");
        });
        //document information
        $("a[href='#document_info']").on('click',function(){
            var route_no = $(this).data('route');
            $('.modal_content').html(loadingState);
            $('.modal-title').html('Route #: '+route_no);
            var url = $(this).data('link');
            setTimeout(function(){
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        $('.modal_content').html(data);
                        $('#reservation').daterangepicker();
                        var datePicker = $('body').find('.datepicker');
                        $('input').attr('autocomplete', 'off');
                    }
                });
            },1000);
        });

        $("a[href='#document_form']").on('click',function(){
            $('.modal-title').html('CTO');
            var url = $(this).data('link');
            $('.modal_content').html(loadingState);
            setTimeout(function(){
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        $('.modal_content').html(data);
                        $('#reservation').daterangepicker();
                        var datePicker = $('body').find('.datepicker');
                        $('input').attr('autocomplete', 'off');
                    }
                });
            },1000);
        });

        $("a[href='#form_type']").on("click",function(){
            <?php
            $asset = asset('form/cdov1');
            $delete = asset('cdo_delete');
            $doc_type = 'CDO';
            ?>
        });

        var type = 'approve';
        $("a[href='#approve']").on("click",function(){
            type = 'approve'
        });
        $("a[href='#disapprove']").on("click",function(){
            type = 'disapprove'
        });

        $(window).on('hashchange', function() {
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                } else {
                    getPosts(page);
                }
            }
        });
        $(document).ready(function() {
            $(document).on('click', '.pagination a', function (e) {
                getPosts($(this).attr('href').split('page=')[1]);
                e.preventDefault();
            });
        });
        function getPosts(page) {
            $.ajax({
                url : '?type='+type+'&page=' + page,
                dataType: 'json',
            }).done(function (data) {
                if(type == 'approve')
                    $('.ajax_approve').html(data);
                else if(type == 'disapprove')
                    $('.ajax_disapprove').html(data);

                location.hash = page;
            }).fail(function (data) {
                console.log(data.responseText);
                console.log('Posts could not be loaded.');
            });
        }
    </script>
@endsection