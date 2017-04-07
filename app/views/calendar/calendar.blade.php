@extends('layouts.app')
@section('content')
    <span id="calendar_event" data-link=" {{ asset('calendar_event') }} "></span>
    <span id="save" data-link=" {{ asset('calendar_save') }} "></span>
    <!-- fullCalendar 2.2.5-->
    <link href="{{ asset('public/plugin/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/plugin/fullcalendar/fullcalendar.print.css') }}" media="print">
    <!-- Theme style -->
    <link href="{{ asset('public/plugin/dist/css/AdminLTE.min.css') }}" rel="stylesheet">
    <div class="col-md-12 wrapper">
        <div class="alert alert-jim">

            <div class="box box-primary">
                <div class="box-body no-padding">
                    <!-- THE CALENDAR -->
                    <div id="calendar"></div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="{{ asset('public/plugin/fullcalendar/moment.js') }}"></script>
    <script src="{{ asset('public/plugin/fullcalendar/fullcalendar.min.js') }}"></script>

    <script>
        $(function () {

            /* initialize the external events
             -----------------------------------------------------------------*/
            function ini_events(ele) {
                ele.each(function () {

                    // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                    // it doesn't need to have a start or end
                    var eventObject = {
                        title: $.trim($(this).text()) // use the element's text as the event title
                    };

                    // store the Event Object in the DOM element so we can get to it later
                    $(this).data('eventObject', eventObject);

                    // make the event draggable using jQuery UI
                    $(this).draggable({
                        zIndex: 1070,
                        revert: true, // will cause the event to go back to its
                        revertDuration: 0  //  original position after the drag
                    });

                });
            }

            ini_events($('#external-events div.external-event'));

            /* initialize the calendar
             -----------------------------------------------------------------*/
            //Date for the calendar events (dummy data)
            var calendar_event = $("#calendar_event").data('link');
            $.get(calendar_event,function(result){
                $('#calendar').fullCalendar({

                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    buttonText: {
                        today: 'today',
                        month: 'month',
                        week: 'week',
                        day: 'day'
                    },
                    //Random default events
                    events: result,

                    editable: true,
                    droppable: true, // this allows things to be dropped onto the calendar !!!
                    drop: function (date, allDay) { // this function is called when something is dropped

                        // retrieve the dropped element's stored Event Object
                        var originalEventObject = $(this).data('eventObject');

                        // we need to copy it, so that multiple events don't have a reference to the same object
                        var copiedEventObject = $.extend({}, originalEventObject);

                        // assign it the date that was reported
                        copiedEventObject.start = date;
                        copiedEventObject.allDay = allDay;
                        copiedEventObject.backgroundColor = $(this).css("background-color");
                        copiedEventObject.borderColor = $(this).css("border-color");

                        // render the event on the calendar
                        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                        var url = $('#save').data('link');
                        var json = {
                            'title' : $(this).data('eventObject')['title'],
                            'start' : date.format(),
                            'background_color' : $(this).css('background-color'),
                            'border_color' : $(this).css('border-color'),
                            "_token" : $('#token').data('token')
                        };
                        $.post(url,json,function(){
                            console.log("Successfully added event");
                        });
                        $(this).remove();
                    }
                });
            });

            /* ADDING EVENTS */
            var currColor = "#3c8dbc"; //Red by default
            //Color chooser button
            var colorChooser = $("#color-chooser-btn");
            $("#color-chooser > li > a").click(function (e) {
                e.preventDefault();
                //Save color
                currColor = $(this).css("color");
                //Add color effect to button
                $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
            });
            $("#add-new-event").click(function (e) {
                e.preventDefault();
                //Get value and make sure it is not null
                var val = $("#new-event").val();
                if (val.length == 0) {
                    return;
                }

                //Create events
                var event = $("<div />");
                event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
                event.html(val);
                $('#external-events').prepend(event);

                //Add draggable funtionality
                ini_events(event);

                //Remove event from text input
                $("#new-event").val("");
            });

        });

        function addEvent(result){
            $('#calendar_modal').modal('show');
            $('.modal_content').html(loadingState);
            $('.modal-title').html('Add New Event');
            var url = result.data('link');
            setTimeout(function() {
                $.get(url,function(data){
                    $('.modal_content').html(data);
                });
            },1000);
        }
    </script>
@endsection