{{-- wellness/partials/report.blade.php --}}
<div class="report-container p-3">
    {{-- Filter Form --}}
    <form class="form-inline" method="GET" action="{{ asset('wellness/get-wellness') }}" id="combinedForm" style="flex: 1; display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="hidden" name="filter" id="filterInput" value="{{ Input::get('filter') }}">

        <!-- Search input -->
        <div class="input-group">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control" id="inclusive3" value="{{ isset($_SESSION['date_range']) ? $_SESSION['date_range'] : '' }}" name="filter_range" placeholder="Input date range here...">
        </div>
        
        <button type="submit" class="btn btn-success" name="filter_date" value="filter">
            Filter 
        </button>
        <a href="{{ url('/wellness/report/export/excel') }}?filter_range={{ Input::get('filter_range') }}"
            class="btn btn-success">
            Export Excel
        </a>

        <a href="{{ url('/wellness/report/export/pdf') }}?filter_range={{ Input::get('filter_range') }}"
            class="btn btn-danger">
            Export PDF
        </a>
    </form>

    {{-- Report Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Scheduled Date</th>
                    <th>Name</th>
                    <th>Type of Request</th>
                    <th>Status</th>
                    <th>Logs</th>
                </tr>
            </thead>
            <tbody>
                @forelse($wellness as $record)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($record->scheduled_date)->format('m/d/Y') }}</td>
                        <td>{{ $record->user_name }}</td>
                        <td>{{ $record->type_of_request }}</td>
                        <td>{{ ucfirst($record->status) }}</td>
                        <td>
                            @if(!empty($record->logs))
                                <ul class="list-unstyled mb-0">
                                    <!-- @foreach($record->logs as $log)
                                        <li>{{ $log->created_at }} - {{ $log->action }}</li>
                                    @endforeach -->
                                </ul>
                            @else
                                <em>No logs</em>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
