<table class="table table-list table-hover table-striped">
    <thead>
        <tr>
            <th>User</th>
            <th>Request Type</th>
            <th>Scheduled Date</th>
            <th>Logs</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($wellness as $record)
            <tr>
                <td>{{ $record->user_name }}</td>
                <td><span style="text-transform: uppercase;">{{ $record->type_of_request }}</span></td>
                <td>{{ date('M d, Y', strtotime($record->scheduled_date)) }}</td>
                <td>
                    <a data-toggle="modal" data-target="#viewLogsModal{{ $record->id }}">View Logs</a>

                    <!-- Modal -->
                    <div class="modal fade" id="viewLogsModal{{ $record->id }}" tabindex="-1" role="dialog" aria-labelledby="viewLogsLabel{{ $record->id }}">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header wellness-header">
                                    <button type="button" class="close modern-close" data-dismiss="modal"><span>&times;</span></button>
                                    <div class="user-profile">
                                        <div class="profile-avatar">{{ strtoupper(substr($record->user_name, 0, 1)) }}</div>
                                        <div class="profile-info">
                                            <h4 class="modal-title">{{ $record->user_name }}</h4>
                                            <span class="wellness-subtitle">🩺 Wellness Activity Feed</span>
                                        </div>
                                    </div>
                                </div>

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

                                <div class="modal-body feed-container">
                                    @if(!empty($record->logs))
                                        <div class="activity-feed">
                                            @foreach($record->logs as $index => $log)
                                                <div class="feed-post" data-activity-time="{{ $log->time_consumed ?? 0 }}">
                                                    <div class="post-header">
                                                        <div class="activity-icon-container">
                                                            <div class="activity-icon {{ ($log->time_consumed ?? 0) < 60 ? 'quick' : (($log->time_consumed ?? 0) < 1000 ? 'moderate' : 'intensive') }}"></div>
                                                            @if($index === 0)
                                                                <div class="latest-badge">Latest</div>
                                                            @endif
                                                        </div>
                                                        <div class="post-meta">
                                                            <div class="activity-title">{{ $record->type_of_request ?? 'Wellness Activity' }}</div>
                                                            <div class="post-time">{{ \Carbon\Carbon::parse($log->created_at)->format('g:i A • M j') }}</div>
                                                        </div>
                                                        <div class="post-actions">
                                                            <button class="action-btn"><span class="heart">♡</span></button>
                                                        </div>
                                                    </div>
                                                    <div class="post-content">
                                                        <div class="duration-display">
                                                            <span class="duration-icon">⏱️</span>
                                                            <span class="duration-text">{{ $log->remarks ?? 'No remarks provided' }}</span>
                                                        </div>
                                                        <div class="activity-progress">
                                                            <div class="progress-bar">
                                                                <div class="progress-fill {{ ($log->time_consumed ?? 0) < 60 ? 'quick' : (($log->time_consumed ?? 0) < 1000 ? 'moderate' : 'intensive') }}" 
                                                                     style="width: {{ min(100, ($log->time_consumed ?? 0) / 10) }}%"></div>
                                                            </div>
                                                            <span class="progress-label">
                                                                Time Consumed: {{
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
                    @if ($record->status === 'approved')
                        <span>Approved</span>
                    @elseif ($record->status === 'declined')
                        <span>Declined</span>
                    @else
                        <span>Pending</span>
                    @endif
                </td>

                @if ($record->status !== 'approved' && $record->status !== 'declined')
                    <td>    
                        {{ Form::open([
                            'url' => '/wellness/get-wellness/' . $record->id,
                            'method' => 'POST',
                            'style' => 'display:inline',
                            'class' => 'wellness-action-form'
                        ]) }}
                            {{ Form::token() }}
                            {{ Form::hidden('action', '', ['class' => 'actionInput']) }}
                            {{ Form::hidden('id', $record->id) }}

                            <div class="btn-group" role="group">
                                <a data-toggle="modal" data-target="#actionModal" 
                                   data-action="approve" 
                                   data-message="Are you sure you want to approve this request?"
                                   data-id="{{ $record->id }}"
                                   title="Approve"
                                   class="circle-btn">
                                    <i class="glyphicon glyphicon-ok" style="font-size:18px;"></i>
                                </a>
                                <a data-toggle="modal" data-target="#actionModal" 
                                   data-action="decline" 
                                   data-message="Are you sure you want to cancel this request?"
                                   data-id="{{ $record->id }}"
                                   title="Cancel"
                                   class="circle-btn">
                                    <i class="glyphicon glyphicon-remove" style="font-size:18px;"></i>
                                </a>
                            </div>
                        {{ Form::close() }}
                    </td>
                @endif
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No wellness records found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Pagination -->
@if($wellness->getTotal() > $wellness->getPerPage())
    <!-- <div id="pagination-links"> -->
    <div class="text-center" style="margin-top: 10px; margin-bottom: 10px;">
        {{ $wellness->links() }}
    </div>
@endif
