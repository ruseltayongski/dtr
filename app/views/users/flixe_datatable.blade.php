@extends('layouts.app')

@section('content')
    <div class="alert alert-jim" id="inputText">
        <h2>Employee's Work Schedule Group</h2>
        <hr />
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"><strong style="color: #f0ad4e;font-size:medium;">Group Lists</strong></div>
                        <div class="panel-body">
                            <form class="form-inline form-filter" method="GET" >
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <div class="form-group">
                                    <div class="input-group">
                                        <select class="form-control col-sm-5" name="sched" id="work_sched">
                                            <option disabled selected>Select work schedule</option>
                                            @if(isset($scheds) and count($scheds) > 0)
                                                @foreach($scheds as $sched)
                                                    <option value="{{ $sched->id }}">{{ $sched->description }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <div class="clearfix"></div>
                            <div class="page-divider"></div>
                            <div class="table-responsive">
                                <table class="table table-list table-hover table-striped" id="group_datatables">
                                    <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>Name </th>
                                        <th>Work Schedule</th>
                                        <th>Time</th>
                                    </tr>
                                    </thead>
                                    <tbody id="td_td">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <span id="data_link" data-link="{{ asset('change/work-schedule') }}" />
@endsection
@section('js')
    @parent
   <script>

       $(document).ready(function(){
           $('#data_table').modal('show');
           var url = '{{ asset('datatables') }}';
           var data = 'sched=1';
           $.get(url,data,function(data){
               $('#group_datatables').DataTable({
                   pageLength : 25,
                   data : data,
                   columns : [
                       { data : 'userid' },
                       { data : 'name' },
                       { data : 'description' },
                       { data : 'sched'}
                    ]
               });
               $('#data_table').modal('hide');
           });
           $('#work_sched').change(function(e) {
                var sched = $("#work_sched").val();
                var data = 'sched=' + sched;
               $.get(url,data,function(data){
                   $('#data_table').modal('show');
                   $('#group_datatables').DataTable().clear().destroy();
                   $('#group_datatables').DataTable({
                       pageLength : 25,
                       data : data,
                       columns : [
                           { data : 'userid' },
                           { data : 'name' },
                           { data : 'description' },
                           { data : 'sched' }
                       ]
                   });
                   $('#data_table').modal('hide');

               });
           });
       });
   </script>
@endsection



