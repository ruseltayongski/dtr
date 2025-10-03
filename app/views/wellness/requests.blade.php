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

.tab-content > .tab-pane {
  display: none !important;
}

.tab-content > .tab-pane.active {
  display: block !important;
}


/* Default tab look */
#viewTabs > li > a {
    color: black; 
    background: #f9f9f9;          /* light gray bg */
    border: 1px solid #ddd;       /* border around tabs */
    border-radius: 0;             /* removes rounded corners */
    margin-right: 2px;            /* small spacing between tabs */
    padding: 10px 15px;
}

/* Hover effect */
#viewTabs > li > a:hover {
    background: #f1f1f1;
    color: #007bff;               /* blue text */
    border-color: #ccc;
}

/* Active tab */
#viewTabs > li.active > a,
#viewTabs > li.active > a:focus,
#viewTabs > li.active > a:hover {
    background: #fff;             /* white bg for active */
    color: black;               /* blue text */
    border: 1px solid #ddd;
    border-top: 3px solid #007bff; /* blue line on top */
    border-bottom-color: transparent; /* blends with content */
    border-radius: 0;
}

/* Circle buttons - base style */
.circle-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 29px;
    height: 29px;
    border-radius: 50%;
    text-decoration: none;
    margin: 0 2px;
    cursor: pointer;
    transition: all 0.2s ease;
    color: #fff;            /* icon color default white */
}

/* Icon size */
.circle-btn i {
    font-size: 15px;
    line-height: 1;
}

/* Approve (green default) */
.circle-btn[data-action="approve"] {
    background: #28a745;   /* green */
    border: 1px solid #28a745;
}

/* Hover - reverse */
.circle-btn[data-action="approve"]:hover {
    background: #fff;
    color: #28a745;
    border: 1px solid #28a745;
}

/* Decline (red default) */
.circle-btn[data-action="decline"] {
    background: #dc3545;   /* red */
    border: 1px solid #dc3545;
}

/* Hover - reverse */
.circle-btn[data-action="decline"]:hover {
    background: #fff;
    color: #dc3545;
    border: 1px solid #dc3545;
}

#loadingOverlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    /* background: rgba(255, 255, 255, 0.8); */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    display: none; /* hide initially */
}
#loadingOverlay img {
    width: 50px; /* adjust size as needed */
    height: 50px;
}

</style>
<!-- Tabs -->
<div id="loadingOverlay">
    <img src="{{ asset('public/img/spin.gif') }}" alt="Loading..." />
</div>
<div class="clearfix">

    <!-- Title on the left -->
    <nav aria-label="breadcrumb" style="float:left; margin-left:20px;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Wellness</a></li>
            @if($filter === 'past')
                <li class="breadcrumb-item active" aria-current="page">Past Activity</li>
            @elseif($filter === 'upcoming')
                <li class="breadcrumb-item active" aria-current="page">Upcoming Activity</li>
            @endif
        </ol>
    </nav>
        <ul class="nav nav-tabs pull-right" id="viewTabs" role="tablist" style="border-bottom:none;">
            <li class="active">
                <a href="#listView" data-toggle="tab" role="tab">
                    📋 List View
                </a>
            </li>
            <li>
                <a href="#calendarView" data-toggle="tab" role="tab">
                    📅 Calendar View
                </a>
            </li>
            <li>
                <a href="#reportView" data-toggle="tab" role="tab">
                   Wellness Report
                </a>
            </li>
        </ul>
</div>
<div class="tab-content" id="viewTabsContent">
    <div class="tab-pane active" id="listView" role="tabpanel">
        <!-- ✅ your table goes here -->
            <div class="row">
                <div class="col-md-12">
                    <!-- <h2>Wellness Records</h2> -->
                    <div>
                    
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
                                    <input type="hidden" name="filter" id="filterInput" value="{{ Input::get('filter') }}">

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

                                    @foreach($allStatuses as $status)
                                        <!-- Status checkboxes -->
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="status[]" value="{{$status}}"
                                                {{ in_array($status, $statuses) ? 'checked' : '' }}>
                                                {{ ucfirst($status) }}
                                            </label>                                        
                                        </div>
                                    @endforeach        
                                    <!-- <input type="hidden" name="filter" value="{{ $filter }}"> -->
                                </form>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        @if(count($wellness) > 0)
                                        <?php
                                            $hasActions = false;
                                            foreach ($wellness as $item) {
                                                if (!in_array($item->status, ['approved', 'declined'])) {
                                                    $hasActions = true;
                                                    break;
                                                }
                                            }
                                        ?>
                                            <!-- Table + Pagination -->
                                        <div id="results">
                                            @include('wellness.partials.results', ['wellness' => $wellness, 'logs' => $logs])
                                        </div>

                                            {{-- Pagination for Laravel 4.2 --}}
                
                                        @else
                                            <div class="alert alert-info static-alert">
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
        </div>
    <div class="tab-pane" id="calendarView" role="tabpanel">
        <div id="calendar" style="min-height:500px;"></div>
    </div>
    <div class="tab-pane" id="reportView" role="tabpanel">
        @include('wellness.partials.report', ['wellness' => $wellness])
    </div>
</div>

<!-- Reusable Modal -->
<div class="modal fade" id="actionModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="actionModalLabel">Confirm Action</h5>
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
    // let calendarFilter = '{{ $filter }}'; // initialize from URL
    $(document).ready(function() {
        // Auto-hide alerts after 5 seconds
        // $('.alert').delay(3000).fadeOut();
        $(".alert").not(".static-alert").delay(3000).slideUp(300);

        
        // Add some hover effects
        $('tbody tr').hover(
            function() { $(this).addClass('active'); },
            function() { $(this).removeClass('active'); }
        );
    });

    $('a[data-toggle="tab"][href="#calendarView"]').on('shown.bs.tab', function () {
        console.log('ca','dadasdaddd')
        setTimeout(function() {
            $('#calendar').fullCalendar('render');
        }, 100);
    });

    // $(document).ready(function () {
        // $('#calendar').fullCalendar({
        //     header: {
        //         left: 'prev,next today',
        //         center: 'title',
        //         right: 'month,agendaWeek,agendaDay,listWeek'
        //     },
        //     buttonText: {
        //         today: 'Today',
        //         month: 'Month',
        //         week: 'Week',
        //         day: 'Day',
        //         list: 'List'
        //     },
        //     events: [
        //         @foreach($logs as $i => $record)
        //         {
        //             title: '{{$record->type_of_request}} \n {{ $record->user_name }} \n ({{ \Carbon\Carbon::parse($record->time_start)->format("H:i") }} - {{ \Carbon\Carbon::parse($record->time_end)->format("H:i") }})',
        //             start: '{{ \Carbon\Carbon::parse($record->time_start)->format("Y-m-d") }}',
        //             color: '#5bc0de',
        //         }
        //         {{ $i+1 < count($logs) ? ',' : '' }}
        //         @endforeach
        //     ],
        //     eventClick: function(event, jsEvent, view) {
        //         // Prevent default URL navigation
        //         jsEvent.preventDefault();

        //         if (event.url) {
        //             $(event.url).modal('show'); // open your View Logs modal
        //         }
        //     }
        // });
    // });


//     $(document).ready(function () {

//     let today = new Date();
//     today.setHours(0,0,0,0);

//     function initCalendar() {
//         $('#calendar').fullCalendar('destroy'); // destroy previous instance if any

//         $('#calendar').fullCalendar({
//             header: { left:'prev,next today', center:'title', right:'month,agendaWeek,agendaDay,listWeek' },
//             buttonText: { today:'Today', month:'Month', week:'Week', day:'Day', list:'List' },

//             // Filtered events
//             events: function(start, end, timezone, callback) {
//                 let allEvents = [
//                     @foreach($logs as $record)
//                     {
//                         title: '{{ $record->type_of_request }} \n {{ $record->user_name }}',
//                         start: '{{ \Carbon\Carbon::parse($record->time_start)->format("Y-MM-dd") }}',
//                         color: '#5bc0de',
//                     },
//                     @endforeach
//                 ];

//                 let filteredEvents = allEvents.filter(function(event){
//                     let eventDate = new Date(event.start);
//                     if(calendarFilter === 'past') return eventDate < today;
//                     if(calendarFilter === 'upcoming') return eventDate >= today;
//                     return true; // all
//                 });

//                 callback(filteredEvents);
//             },

//             // Disable dates outside filter
//             validRange: function(nowDate) {
//                 if(calendarFilter === 'past'){
//                     return { end: today }; // only allow past dates
//                 } else if(calendarFilter === 'upcoming'){
//                     return { start: today }; // only allow today & future
//                 } else {
//                     return {}; // all dates selectable
//                 }
//             },

//             eventClick: function(event, jsEvent){
//                 jsEvent.preventDefault();
//                 if(event.url) $(event.url).modal('show'); // open modal if needed
//             }
//         });
//     }

//     // Initial render
//     initCalendar();

//     // Optional: re-render when filter changes dynamically
//     $(document).on('change', '#combinedForm input, #combinedForm select', function(){
//         initCalendar();
//     });

// });

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
    <!-- <script>
       $(".wysihtml5_1").wysihtml5();
        $('.input-daterange input').each(function() {
            $(this).datepicker("clearDates");
        });
        console.log("Initializing daterangepicker...");
        $('#inclusive3').daterangepicker();
        $('#filter_dates').daterangepicker();
    </script> -->
    <script>
    $(document).ready(function() {
        // Initialize WYSIWYG editor
        $(".wysihtml5_1").wysihtml5();

        // Clear old datepicker inputs
        $('.input-daterange input').each(function() {
            $(this).datepicker("clearDates");
        });

        console.log("Initializing daterangepicker...");

        // Get filter from server (Blade)
        let calendarFilter = '{{ $filter }}'; // 'past' or 'upcoming'

        function initDateRange() {
            let startDate = null;
            let endDate = null;

            let today = moment().startOf('day');

            if(calendarFilter === 'past') {
                startDate = moment().subtract(6, 'days'); // past 7 days including today
                endDate = today;
            } else if(calendarFilter === 'upcoming') {
                startDate = today;
                endDate = moment().add(6, 'days'); // next 7 days including today
            }

            $('#inclusive3').daterangepicker({
                autoUpdateInput: false,
                locale: { format: 'MM/DD/YYYY' },
                minDate: startDate,
                maxDate: endDate
            });

            // Update input when selected
            $('#inclusive3').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });

            $('#inclusive3').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        }

        initDateRange();

        // Re-init on menu filter change
        $(document).on('click', '.dropdown-menu a', function(e){
            e.preventDefault();
            let href = $(this).attr('href');
            let selectedFilter = href.split('filter=')[1]; // past/upcoming
            if(selectedFilter) {
                calendarFilter = selectedFilter;
                initDateRange(); // re-init with updated min/max dates
            }
        });
    });
    </script>

    <script>

    function getFormData() {
        // serializeArray preserves multiple checkboxes
        let formData = {};
        $('#combinedForm').serializeArray().forEach(function(item){
            if(formData[item.name]) {
                if(Array.isArray(formData[item.name])) {
                    formData[item.name].push(item.value);
                } else {
                    formData[item.name] = [formData[item.name], item.value];
                }
            } else {
                formData[item.name] = item.value;
            }
        });
        return formData;
        
    }

    // 2️⃣ Handle checkbox changes
    $('#combinedForm input[type="checkbox"]').on('change', function () {
        let formData = getFormData();
        console.log('Checkbox changed, submitting with data:', formData);
        loadResults($('#combinedForm').attr('action'), formData);
    });

    // 3️⃣ Handle pagination clicks
    $(document).on('click', '#pagination-links a', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');

        // always send current checkbox state
        let formData = getFormData();
        loadResults(url, formData);
    });

    function loadResults(url, data = {}) {
        $('#loadingOverlay').css('display', 'flex');

        $.ajax({
            url: url,
            method: 'GET',
            data: data,
            success: function(response) {
                $('#results').html(response); // update table + pagination only
            },
            complete: function() {
                $('#loadingOverlay').hide();
            },
            error: function() {
                alert('Failed to load data.');
                $('#loadingOverlay').hide();
            }
        });
    }
    </script>
@endsection