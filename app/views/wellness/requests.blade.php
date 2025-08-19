@extends('layouts.app')

@section('title', 'Wellness Records')

@section('content')
<style>
  .timeline {
    position: relative;
    margin: 20px 0;
    padding-left: 40px;
    border-left: 2px solid #e0e0e0;
  }

  .timeline-item {
    position: relative;
    margin-bottom: 30px;
  }

  .timeline-time {
    position: absolute;
    left: -90px;
    top: 4px;
    font-size: 12px;
    color: #888;
    white-space: nowrap;
  }

  .timeline-dot {
    position: absolute;
    left: -12px;
    top: 8px;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background-color: #ccc;
    border: 2px solid white;
    z-index: 1;
  }

  .timeline-content {
    background: #fff;
    border: 1px solid #eee;
    border-left: 4px solid #28a745;
    border-radius: 6px;
    padding: 12px 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
  }

  .timeline-title {
    font-weight: bold;
    margin-bottom: 4px;
  }

  .timeline-subtitle {
    color: #0073aa;
    font-size: 13px;
    text-decoration: none;
  }

  .timeline-meta {
    font-size: 12px;
    color: #999;
    margin-top: 4px;
  }
</style>
<div class="box box-info">
    <div class="box-body">
        <span style="color:black;font-size: 15pt;padding: 1%;display:inline-flex;"> All Wellness Records </span>
            <span style="color:green;display:inline-flex;font-size: 17pt;">
            </span>
            <div class="row">
                <div class="col-md-12">
                    <!-- <h2>Wellness Records</h2> -->
                     <div class="active tab-pane">
                    
                        @if(Session::has('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        @if(Session::has('error'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                {{ Session::get('error') }}
                            </div>
                        @endif

                        <div class="panel panel-default">
                            <div class="panel-heading" style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                                <form class="form-inline" method="GET" action="{{ asset('wellness/get-wellness') }}" id="combinedForm" style="flex: 1; display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    
                                    <!-- Search input -->
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control" id="inclusive3" value="{{ isset($_SESSION['date_range']) ? $_SESSION['date_range'] : '' }}" name="filter_range" placeholder="Input date range here...">
                                    </div>
                                    
                                    <div style="flex: 1; min-width: 200px;">
                                        <input type="text" class="form-control" value="{{ Session::get('keyword') }}" 
                                            name="keyword" style="width: 100%" placeholder="Name, Type of Activity">
                                    </div>
                                    
                                    <!-- Buttons -->
                                    <button type="submit" class="btn btn-success" name="filter_date" value="filter">
                                        Filter Date
                                    </button>
                                    <button type="submit" class="btn btn-primary" name="search" value="search">
                                        <span class="glyphicon glyphicon-search"></span> Search
                                    </button>
                                </form>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        @if(count($wellness) > 0)
                                            <div class="table-responsive">
                                                <table class="table table-list table-hover table-striped">
                                                    <thead>
                                                        <tr>
                                                            <!-- <th>ID</th> -->
                                                            <th>Name</th>
                                                            <th>Type of Request</th>
                                                            <th>Date Started</th>
                                                            <th>Logs</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($wellness as $record)
                                                            <tr>
                                                                <!-- <td>{{ $record->id }}</td> -->
                                                                <td>{{ $record->user_name }}</td>
                                                                <td>
                                                                    <span class="label 
                                                                        @if($record->type_of_request == 'ML')
                                                                            label-info
                                                                        @elseif($record->type_of_request == 'SL')
                                                                            label-warning
                                                                        @else
                                                                            label-default
                                                                        @endif
                                                                    ">
                                                                        {{ $record->type_of_request }}
                                                                    </span>
                                                                </td>
                                                                <td>{{ date('M d, Y', strtotime($record->scheduled_date)) }}</td>
                                                                <!-- <td>{{ \Carbon\Carbon::parse($record->created_at)->format('Y-m-d') }}</td> -->
                                                                 <td>
                                                                    <button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#viewLogsModal{{ $record->id }}">
                                                                        View Logs
                                                                    </button>

                                                                    <!-- Modal -->
                                                                    <!-- <div class="modal fade" id="viewLogsModal{{ $record->id }}" tabindex="-1" role="dialog" aria-labelledby="viewLogsLabel{{ $record->id }}">
                                                                    <div class="modal-dialog modal-lg" role="document">
                                                                        <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                            <h4 class="modal-title" id="viewLogsLabel{{ $record->id }}">
                                                                            Wellness Logs - {{ $record->user_name }}
                                                                            </h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            @if (!empty($record->logs))
                                                                                <ul class="list-group">
                                                                                    @foreach ($record->logs as $log)
                                                                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                                                                            <div class="ms-2 me-auto">
                                                                                                <div class="fw-bold">
                                                                                                    {{ \Carbon\Carbon::parse($log->created_at)->format('M d, Y H:i') }}
                                                                                                </div>
                                                                                                {{ $log->activity ?? 'No activity info' }}
                                                                                            </div>
                                                                                            <div>
                                                                                                <span class="badge bg-secondary text-white rounded-pill" style="min-width: 60px; text-align: center;">
                                                                                                    {{
                                                                                                        ($log->time_consumed ?? 0) < 60
                                                                                                            ? ($log->time_consumed ?? 0) . ' sec'
                                                                                                            : floor(($log->time_consumed ?? 0) / 60) . ' min' . ((($log->time_consumed ?? 0) % 60) > 0 ? ' ' . (($log->time_consumed ?? 0) % 60) . ' sec' : '')
                                                                                                    }}
                                                                                                </span>
                                                                                            </div>
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            @else
                                                                                <div class="alert alert-info mb-0">
                                                                                    No logs available for this request.
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                        </div>
                                                                    </div>
                                                                    </div> -->
                                                                    <!-- <div class="modal fade" id="viewLogsModal{{ $record->id }}" tabindex="-1" role="dialog" aria-labelledby="viewLogsLabel{{ $record->id }}">
                                                                    <div class="modal-dialog modal-lg" role="document">
                                                                        <div class="modal-content">

                                                                        <div class="modal-header" style="border-bottom: 1px solid #ddd;">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                            <h4 class="modal-title" id="viewLogsLabel{{ $record->id }}" style="font-weight: bold;">
                                                                            ❤️ Wellness Logs - {{ $record->user_name }}
                                                                            </h4>
                                                                        </div>

                                                                        <div class="modal-body" style="background-color: #f9f9f9;">
                                                                            @if (!empty($record->logs))
                                                                            <ul class="list-group">
                                                                                @foreach ($record->logs as $log)
                                                                                <li class="list-group-item" style="border: 1px solid #eee; margin-bottom: 10px; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                                                                    <div class="row">
                                                                                    <div class="col-xs-10">
                                                                                        <strong style="font-size: 14px;">
                                                                                        📋 {{ \Carbon\Carbon::parse($log->created_at)->format('M d, Y H:i') }}
                                                                                        </strong>
                                                                                        <div class="text-muted" style="font-style: italic; margin-top: 4px;">
                                                                                        {{ $log->activity ?? 'ℹ️ No activity info' }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-xs-2 text-right">
                                                                                        <span class="badge" style="background-color: #ccc; font-size: 12px; min-width: 60px;">
                                                                                        {{
                                                                                            ($log->time_consumed ?? 0) < 60
                                                                                            ? ($log->time_consumed ?? 0) . ' sec'
                                                                                            : floor(($log->time_consumed ?? 0) / 60) . ' min' . ((($log->time_consumed ?? 0) % 60) > 0 ? ' ' . (($log->time_consumed ?? 0) % 60) . ' sec' : '')
                                                                                        }}
                                                                                        </span>
                                                                                    </div>
                                                                                    </div>
                                                                                </li>
                                                                                @endforeach
                                                                            </ul>
                                                                            @else
                                                                            <div class="alert alert-info mb-0">
                                                                                No logs available for this request.
                                                                            </div>
                                                                            @endif
                                                                        </div>

                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                                                            ✖ Close
                                                                            </button>
                                                                        </div>

                                                                        </div>
                                                                    </div>
                                                                    </div> -->
                                                                    <div class="modal fade" id="viewLogsModal{{ $record->id }}" tabindex="-1" role="dialog" aria-labelledby="viewLogsLabel{{ $record->id }}">
                                                                    <div class="modal-dialog modal-lg" role="document">
                                                                        <div class="modal-content">

                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                            <h4 class="modal-title">
                                                                            🩺 Wellness Logs - {{ $record->user_name }}
                                                                            </h4>
                                                                        </div>

                                                                        <div class="modal-body" style="background: #f8f9fa;">
                                                                            @if (!empty($record->logs))
                                                                            <div class="timeline">
                                                                                @foreach ($record->logs as $log)
                                                                                <div class="timeline-item">
                                                                                    <div class="timeline-time">
                                                                                        {{ \Carbon\Carbon::parse($log->created_at)->format('g:i A') }}  
                                                                                    </div>
                                                                                    <div class="timeline-dot" style="
                                                                                    background-color:
                                                                                        {{ ($log->activity ?? 'No activity info') ? '#6c757d' : (($log->time_consumed ?? 0) < 60 ? '#ffc107' : '#28a745') }};
                                                                                    "></div>
                                                                                    <div class="timeline-content">
                                                                                    <div class="timeline-title">
                                                                                        {{ $log->activity ?? 'No activity info' }}
                                                                                    </div>
                                                                                    <a href="#" class="timeline-subtitle">
                                                                                        Duration:
                                                                                        {{
                                                                                            ($log->time_consumed ?? 0) < 1000
                                                                                                ? ($log->time_consumed ?? 0) . ' ms'
                                                                                                : (
                                                                                                    ($minutes = floor(($log->time_consumed ?? 0) / 60000)) > 0 ? $minutes . ' min ' : ''
                                                                                                ) .
                                                                                                (
                                                                                                    ($seconds = floor((($log->time_consumed ?? 0) % 60000) / 1000)) > 0 ? $seconds . ' sec ' : ''
                                                                                                )
                                                                                        }}
                                                                                    </a>
                                                                                    <div class="timeline-meta">
                                                                                        {{ \Carbon\Carbon::parse($log->created_at)->format('F j, Y') }}
                                                                                    </div>
                                                                                    </div>
                                                                                </div>
                                                                                @endforeach
                                                                            </div>
                                                                            @else
                                                                            <div class="alert alert-info">No logs available for this request.</div>
                                                                            @endif
                                                                        </div>

                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">✖ Close</button>
                                                                        </div>

                                                                        </div>
                                                                    </div>
                                                                    </div>


                                                                </td>

                                                                <td>
                                                                    @if ($record->status !== 'approved' && $record->status !== 'declined')
                                                                        {{ Form::open(array(
                                                                            'url' => '/wellness/get-wellness/' . $record->id,
                                                                            'method' => 'POST',
                                                                            'style' => 'display:inline',
                                                                            'class' => 'wellness-action-form'
                                                                        )) }}
                                                                            {{ Form::token() }}
                                                                            <div class="btn-group" role="group">
                                                                                <button type="submit" name="action" value="approve" 
                                                                                        class="btn btn-success btn-xs" 
                                                                                        onclick="return confirm('Are you sure you want to approve this request?')"
                                                                                        title="Approve">
                                                                                    <i class="glyphicon glyphicon-ok"></i> Approve
                                                                                </button>

                                                                                <button type="submit" name="action" value="decline" 
                                                                                        class="btn btn-danger btn-xs" 
                                                                                        onclick="return confirm('Are you sure you want to cancel this request?')"
                                                                                        title="Cancel">
                                                                                    <i class="glyphicon glyphicon-remove"></i> Cancel
                                                                                </button>
                                                                            </div>
                                                                        {{ Form::close() }}
                                                                    @elseif ($record->status === 'approved')
                                                                        <span class="label label-success">Approved</span>

                                                                        <?php $updatedAt = \Carbon\Carbon::parse($record->updated_at); ?>

                                                                        <a href="{{ url('/admin/wellness/individual-report/' . $record->unique_code . '/' . $updatedAt->format('Y') . '/' . $updatedAt->format('m')) }}"
                                                                        class="btn btn-default btn-xs" 
                                                                        title="Download PDF" target="_blank" style="margin-left: 5px;">
                                                                            <i class="glyphicon glyphicon-file"></i> PDF
                                                                        </a>
                                                                        
                                                                    @elseif ($record->status === 'declined')
                                                                        <span class="label label-danger">Declined</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            {{-- Pagination for Laravel 4.2 --}}
                
                                        @else
                                            <div class="alert alert-info">
                                                <h4>No Records Found</h4>
                                                <p>Thre are no wellness records to display. <a href="{{ URL::to('/wellness/create') }}">Create the first one</a>.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- @if($wellness->getTotal() > $wellness->getPerPage())
        <div class="text-center">
            {{ $wellness->links() }}
        </div>
    @endif -->
    <div class="text-center" style="margin-top: 10px; margin-bottom: 10px;">
        {{ $wellness->links() }}
    </div>
</div>
@endsection
@section('js')
<script>
$(document).ready(function() {
    // Auto-hide alerts after 5 seconds
    $('.alert').delay(5000).fadeOut();
    
    // Add some hover effects
    $('tbody tr').hover(
        function() { $(this).addClass('active'); },
        function() { $(this).removeClass('active'); }
    );
});
</script>
 @parent
    <script>
       $(".wysihtml5_1").wysihtml5();
        $('.input-daterange input').each(function() {
            $(this).datepicker("clearDates");
        });
        console.log("Initializing daterangepicker...");
        $('#inclusive3').daterangepicker();
        $('#filter_dates').daterangepicker();
    </script>
@endsection