@extends('layouts.app')

@section('title', 'Wellness Records')

@section('content')
<style>
/* Enhanced Modal Styles */
.wellness-header {
    background: #9C8AA5;
    border: none;
    padding: 20px 25px;
    color: white;
    position: relative;
    overflow: hidden;
}

.wellness-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="60" r="1.5" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
    opacity: 0.3;
}

.user-profile {
    display: flex;
    align-items: center;
    gap: 15px;
    position: relative;
    z-index: 1;
}

.profile-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 18px;
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.profile-info {
    flex: 1;
}

.modal-title {
    margin: 0;
    font-size: 20px;
    font-weight: 700;
}

.wellness-subtitle {
    font-size: 14px;
    opacity: 0.9;
}

.modern-close {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    font-size: 18px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    z-index: 1;
}

.modern-close:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
}

/* Stats Bar */
.stats-bar {
    background: #f8f9fa;
    padding: 20px 25px;
    display: flex;
    justify-content: space-around;
    border-bottom: 1px solid #e9ecef;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 24px;
    font-weight: 800;
    color: #2c3e50;
    margin-bottom: 2px;
}

.stat-label {
    font-size: 12px;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Feed Container */
.feed-container {
    padding: 0;
    max-height: 400px;
    overflow-y: auto;
    background: #f8f9fa;
}

.activity-feed {
    padding: 15px;
}

/* Feed Post */
.feed-post {
    background: white;
    border-radius: 12px;
    margin-bottom: 15px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.feed-post:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

/* Post Header */
.post-header {
    padding: 15px 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    border-bottom: 1px solid #f1f3f4;
}

.activity-icon-container {
    position: relative;
}

.activity-icon {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: white;
    font-weight: 600;
}

.activity-icon.quick {
    /* background: #9C8AA5; */
    background: #67E8F9;
    /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
}

.activity-icon.moderate {
    /* background: #9C8AA5; */
    background: #67E8F9;
    /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
}

.activity-icon.intensive {
    /* background: #9C8AA5; */
    background: #67E8F9;

    /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
}

.latest-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #ff4757;
    color: white;
    font-size: 10px;
    padding: 4px 8px;
    border-radius: 12px;
    font-weight: 600;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.post-meta {
    flex: 1;
}

.activity-title {
    font-weight: 600;
    color: #2c3e50;
    font-size: 16px;
    margin-bottom: 2px;
}

.post-time {
    font-size: 13px;
    color: #6c757d;
}

.post-actions {
    display: flex;
    gap: 10px;
}

.action-btn {
    background: none;
    border: none;
    font-size: 18px;
    color: #6c757d;
    cursor: pointer;
    padding: 5px;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.action-btn:hover {
    background: #f1f3f4;
    color: #ff4757;
}

/* Post Content */
.post-content {
    padding: 15px 20px;
}

.duration-display {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #f8f9fa;
    padding: 10px 15px;
    border-radius: 20px;
    margin-bottom: 15px;
    font-size: 14px;
    color: #495057;
}

.duration-icon {
    font-size: 16px;
}

.activity-progress {
    margin-top: 15px;
}

.progress-bar {
    width: 100%;
    height: 8px;
    /* background: #e9ecef; */
    background: #E5E7EB;
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 5px;
}

.progress-fill {
    height: 100%;
    border-radius: 4px;
    transition: width 0.3s ease;
}

.progress-fill.quick {
    background: #3B82F6;
}

.progress-fill.moderate {
    background: #3B82F6;
}

.progress-fill.intensive {
    background: #3B82F6;
}

.progress-label {
    font-size: 11px;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Post Footer */
.post-footer {
    padding: 15px 20px;
    background: #f8f9fa;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
}

.engagement-stats {
    display: flex;
    gap: 15px;
}

.engagement-stats .stat {
    display: flex;
    align-items: center;
    gap: 5px;
    color: #6c757d;
}

.engagement-stats .icon {
    font-size: 14px;
}

.points-earned {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 6px 12px;
    border-radius: 15px;
    font-weight: 600;
    font-size: 12px;
}

/* Empty State */
.empty-feed {
    text-align: center;
    padding: 60px 20px;
    color: #6c757d;
}

.empty-icon {
    font-size: 48px;
    margin-bottom: 20px;
}

.empty-feed h3 {
    color: #2c3e50;
    margin-bottom: 10px;
}

/* .start-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 25px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 15px;
    transition: transform 0.3s ease;
}

.start-btn:hover {
    transform: translateY(-2px);
} */

/* Footer */
.wellness-footer {
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
    padding: 20px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.footer-stats {
    color: #6c757d;
    font-size: 14px;
}

.modern-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 12px 20px;
    border-radius: 25px;
    color: white;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.modern-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    color: white;
}

/* Custom Scrollbar */
.feed-container::-webkit-scrollbar {
    width: 6px;
}

.feed-container::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.feed-container::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
}

/* Animation for feed items */
.feed-post {
    animation: slideInUp 0.5s ease forwards;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
<div class="box box-info">
    <div class="box-body">
        <div style="margin-bottom:10px;" class="clearfix">
            <button id="toggleViewBtn" class="btn btn-primary" style="float: right;">
               📅 Calendar View
            </button>
        </div>

        <div id="calendar" style="display:none;">
        </div>
        <div id="wellnessTable">
            <span style="color:black;font-size: 15pt;padding: 1%;display:inline-flex; float: left;"> All Wellness Records </span>
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
                                                name="keyword" style="width: 100%" placeholder="Name">
                                        </div>
                                        
                                        <button type="submit" class="btn btn-success" name="filter_date" value="filter">
                                            Filter 
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
                                                                <th>Wellness Started</th>
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
                                                                        <div class="modal fade" id="viewLogsModal{{ $record->id }}" tabindex="-1" role="dialog" aria-labelledby="viewLogsLabel{{ $record->id }}">
                                                                        <div class="modal-dialog modal-lg" role="document">
                                                                            <div class="modal-content">
                                                                                <!-- Enhanced Header -->
                                                                                <div class="modal-header wellness-header">
                                                                                    <button type="button" class="close modern-close" data-dismiss="modal">
                                                                                            <span aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    <div class="user-profile">
                                                                                        <div class="profile-avatar">
                                                                                            {{ strtoupper(substr($record->user_name, 0, 1)) }}
                                                                                        </div>
                                                                                        <div class="profile-info">
                                                                                            <h4 class="modal-title">{{ $record->user_name }}</h4>
                                                                                            <span class="wellness-subtitle">🩺 Wellness Activity Feed</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Stats Overview -->
                                                                                <div class="stats-bar">
                                                                                    <div class="stat-item">
                                                                                        <div class="stat-number">{{ count($record->logs ?? []) }}</div>
                                                                                        <div class="stat-label">Activities</div>
                                                                                    </div>
                                                                                    <div class="stat-item">
                                                                                        <div class="stat-number">
                                                                                            {{ array_sum(array_column($record->logs ?? [], 'time_consumed')) < 1000 
                                                                                                ? array_sum(array_column($record->logs ?? [], 'time_consumed')) . 'ms' 
                                                                                                : floor(array_sum(array_column($record->logs ?? [], 'time_consumed')) / 1000) . 's' }}
                                                                                        </div>
                                                                                        <div class="stat-label">Total Time</div>
                                                                                    </div>
                                                                                    <div class="stat-item">
                                                                                        <div class="stat-number">{{ \Carbon\Carbon::today()->format('M j') }}</div>
                                                                                        <div class="stat-label">Today</div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Social Feed Body -->
                                                                                <div class="modal-body feed-container">
                                                                                    @if (!empty($record->logs))
                                                                                        <div class="activity-feed">
                                                                                            @foreach ($record->logs as $index => $log)
                                                                                            <div class="feed-post" data-activity-time="{{ $log->time_consumed ?? 0 }}">
                                                                                                <!-- Post Header -->
                                                                                                <div class="post-header">
                                                                                                    <div class="activity-icon-container">
                                                                                                        <div class="activity-icon {{ ($log->time_consumed ?? 0) < 60 ? 'quick' : (($log->time_consumed ?? 0) < 1000 ? 'moderate' : 'intensive') }}">
                                                                                                        
                                                                                                        </div>
                                                                                                        @if($index === 0)
                                                                                                            <div class="latest-badge">Latest</div>
                                                                                                        @endif
                                                                                                    </div>
                                                                                                    <div class="post-meta">
                                                                                                        <div class="activity-title">
                                                                                                            {{ $record->type_of_request ?? 'Wellness Activity' }}
                                                                                                        </div>
                                                                                                        <div class="post-time">
                                                                                                            {{ \Carbon\Carbon::parse($log->created_at)->format('g:i A') }} • 
                                                                                                            {{ \Carbon\Carbon::parse($log->created_at)->format('M j') }}
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="post-actions">
                                                                                                        <button class="action-btn">
                                                                                                            <span class="heart">♡</span>
                                                                                                        </button>
                                                                                                    </div>
                                                                                                </div>

                                                                                                <!-- Post Content -->
                                                                                                <div class="post-content">
                                                                                                    <div class="duration-display">
                                                                                                        <span class="duration-icon">⏱️</span>
                                                                                                        <span class="duration-text">
                                                                                                            
                                                                                                            {{
                                                                                                                $log->remarks ?? 'No remarks provided'
                                                                                                            }}
                                                                                                        </span>
                                                                                                        <span></span>
                                                                                                    </div>
                                                                                                    
                                                                                                    <!-- Progress Bar -->
                                                                                                    <div class="activity-progress">
                                                                                                        <div class="progress-bar">
                                                                                                            <div class="progress-fill {{ ($log->time_consumed ?? 0) < 60 ? 'quick' : (($log->time_consumed ?? 0) < 1000 ? 'moderate' : 'intensive') }}" 
                                                                                                                style="width: {{ min(100, ($log->time_consumed ?? 0) / 10) }}%"></div>
                                                                                                        </div>
                                                                                                        <span class="progress-label">Time Consumed: 
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
                                                                                                        </span>
                                                                                                    </div>
                                                                                                </div>

                                                                                                <!-- Engagement Footer -->
                                                                                                <!-- <div class="post-footer"> -->
                                                                                                    <!-- <div class="engagement-stats">
                                                                                                        <span class="stat">
                                                                                                            <span class="icon">⚡</span>
                                                                                                            {{ ($log->time_consumed ?? 0) > 500 ? 'High' : 'Low' }} Intensity
                                                                                                        </span>
                                                                                                        <span class="stat">
                                                                                                            <span class="icon">🎯</span>
                                                                                                            {{ ($log->time_consumed ?? 0) > 100 ? 'Goal Met' : 'Quick Task' }}
                                                                                                        </span>
                                                                                                    </div> -->
                                                                                                    <!-- <div class="points-earned">
                                                                                                        <i class="fa fa-check-circle"></i>  
                                                                                                    </div>
                                                                                                </div> -->
                                                                                            </div>
                                                                                            @endforeach
                                                                                        </div>
                                                                                    @else
                                                                                        <div class="empty-feed">
                                                                                            <div class="empty-icon">🌱</div>
                                                                                            <h3>No wellness activities yet</h3>
                                                                                            <p>Start your wellness journey today!</p>
                                                                                        </div>
                                                                                    @endif
                                                                                </div>

                                                                                <!-- Enhanced Footer -->
                                                                                <div class="modal-footer wellness-footer">
                                                                                    <div class="footer-stats">
                                                                                        <span class="total-activities">{{ count($record->logs ?? []) }} total activities</span>
                                                                                    </div>
                                                                                    <button type="button" class="btn btn-primary modern-btn" data-dismiss="modal">
                                                                                        <span class="btn-icon">✨</span> Close Logs
                                                                                    </button>
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
                                                                                 {{-- 🔽 Add the hidden inputs here --}}
                                                                                    {{ Form::hidden('action', '', ['class' => 'actionInput']) }}
                                                                                    {{ Form::hidden('id', $record->id) }}
                                                                                <!-- <div class="btn-group" role="group">
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
                                                                                </div> -->
                                                                                <div class="btn-group" role="group">
                                                                                    <button type="button" 
                                                                                        class="btn btn-success btn-xs" 
                                                                                        data-toggle="modal" 
                                                                                        data-target="#actionModal" 
                                                                                        data-action="approve" 
                                                                                        data-message="Are you sure you want to approve this request?"
                                                                                        data-id="{{ $record->id }}"
                                                                                        title="Approve">
                                                                                        <i class="glyphicon glyphicon-ok"></i> Approve
                                                                                    </button>
                                                                                     <button type="button" 
                                                                                        class="btn btn-danger btn-xs" 
                                                                                        data-toggle="modal" 
                                                                                        data-target="#actionModal" 
                                                                                        data-action="decline" 
                                                                                        data-message="Are you sure you want to cancel this request?"
                                                                                        data-id="{{ $record->id }}"
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
                                                    <!-- <p>Thre are no wellness records to display. <a href="{{ URL::to('/wellness/create') }}">Create the first one</a>.</p> -->
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center" style="margin-top: 10px; margin-bottom: 10px;">
                    {{ $wellness->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Reusable Modal -->
<div class="modal fade" id="actionModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="actionModalLabel">Confirm Action</h5>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
        <button type="button" class="close text-white ml-auto" data-dismiss="modal" aria-label="Close" style="position: absolute; right: 1rem; top: 0.75rem;">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <p id="actionMessage">Are you sure?</p>
      </div>
      
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="actionConfirmBtn">Yes, Continue</button>
        </form>
      </div>
      
    </div>
  </div>
</div>
@endsection
@section('js')
@parent
<script src="{{ asset('public/assets/js/jquery4.js') }}"></script>
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
$(document).ready(function () {
    // Default: Table is visible, Calendar is hidden
    $("#toggleViewBtn").on("click", function () {
        if ($("#calendar").is(":visible")) {
            // Switch to Table view
            $("#calendar").hide();
            $("#wellnessTable").show();
            $(this).text("📅 Calendar View");
        } else {
            // Switch to Calendar view
            $("#wellnessTable").hide();
            $("#calendar").show().fullCalendar('render');
            $(this).text("📋 Table View");
        }
    });
});

$(document).ready(function () {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek'
        },
        buttonText: {
            today: 'Today',
            month: 'Month',
            week: 'Week',
            day: 'Day',
            list: 'List'
        },
        events: [
            @foreach($logs as $i => $record)
            {
                title: '{{$record->type_of_request}} \n {{ $record->user_name }} \n ({{ \Carbon\Carbon::parse($record->time_start)->format("H:i") }} - {{ \Carbon\Carbon::parse($record->time_end)->format("H:i") }})',
                start: '{{ \Carbon\Carbon::parse($record->time_start)->format("Y-m-d") }}',
                color: '#5bc0de',
            }
            {{ $i+1 < count($logs) ? ',' : '' }}
            @endforeach
        ],
        eventClick: function(event, jsEvent, view) {
            // Prevent default URL navigation
            jsEvent.preventDefault();

            if (event.url) {
                $(event.url).modal('show'); // open your View Logs modal
            }
        }
    });
});
$('#actionModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); 
    var action = button.data('action');
    var message = button.data('message');

    var modal = $(this);
    modal.find('#actionMessage').text(message);

    // Save form reference + action to modal
    modal.data('form', button.closest('form'));
    modal.data('action', action);
});

$('#actionConfirmBtn').on('click', function () {
    var modal = $('#actionModal');
    var form = modal.data('form');
    var action = modal.data('action');

    form.find('.actionInput').val(action);
    form.submit();
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