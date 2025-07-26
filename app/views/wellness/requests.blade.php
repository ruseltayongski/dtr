@extends('layouts.app')

@section('title', 'Wellness Records')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Wellness Records</h2>
            
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
                <div class="panel-heading">
                    <h3 class="panel-title">All Wellness Records</h3>
                    <div class="clearfix"></div>
                </div>
                
                <div class="panel-body">
                    @if(count($wellness) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <!-- <th>ID</th> -->
                                        <th>Name</th>
                                        <th>Type of Request</th>
                                        <th>Scheduled Date</th>
                                        <th>Unique Code</th>
                                        <th>Remarks</th>
                                        <th>Created At</th>
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
                                            <td>
                                                @if($record->unique_code)
                                                    <code>{{ $record->unique_code }}</code>
                                                @else
                                                    <em class="text-muted">No code</em>
                                                @endif
                                            </td>
                                            <td>
                                                @if($record->remarks)
                                                    {{ Str::limit($record->remarks, 50) }}
                                                @else
                                                    <em class="text-muted">No remarks</em>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($record->created_at)->format('Y-m-d') }}</td>
                                            <td>
                                                 @if ($record->status !== 'approved' && $record->status !== 'cancelled')
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

                                                            <button type="submit" name="action" value="cancel" 
                                                                    class="btn btn-danger btn-xs" 
                                                                    onclick="return confirm('Are you sure you want to cancel this request?')"
                                                                    title="Cancel">
                                                                <i class="glyphicon glyphicon-remove"></i> Cancel
                                                            </button>
                                                        </div>
                                                    {{ Form::close() }}
                                                @elseif ($record->status === 'approved')
                                                    <span class="label label-success">Approved</span>

                                                     {{-- PDF Icon for Approved Requests --}}
                                                    <a href="{{ url('/wellness/pdf/' . $record->id) }}" 
                                                    class="btn btn-default btn-xs" 
                                                    title="Download PDF" target="_blank" style="margin-left: 5px;">
                                                        <i class="glyphicon glyphicon-file"></i> PDF
                                                    </a>
                                                    
                                                @elseif ($record->status === 'cancelled')
                                                    <span class="label label-danger">Cancelled</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination for Laravel 4.2 --}}
                        @if(method_exists($wellness, 'links'))
                            <div class="text-center">
                                {{ $wellness->links() }}
                            </div>
                        @endif

                    @else
                        <div class="alert alert-info">
                            <h4>No Records Found</h4>
                            <p>There are no wellness records to display. <a href="{{ URL::to('/wellness/create') }}">Create the first one</a>.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
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
@endsection