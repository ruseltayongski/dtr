@extends('layouts.app')
@section('content')
    <span id="calendar_holiday" data-link="/dtr/calendar_holiday"></span>
    <span id="calendar_id" data-link="/dtr/calendar_id"></span>
    <span id="calendar_last_id" data-link="/dtr/calendar_last_id"></span>
    <span id="calendar_save" data-link="/dtr/calendar_save"></span>
    <span id="calendar_delete" data-link="/dtr/calendar_delete"></span>
    <span id="calendar_update" data-link="/dtr/calendar_update"></span>
    <span id="calendar_banner" data-link="{{ asset('resources/img/banner.png') }}"></span>
    <div class="row">
        <div class="<?php if(Auth::user()->usertype == '1') echo 'col-md-9 wrapper'; else echo 'col-md-12 wrapper'; ?>">
            <div class="box box-primary">
                <div class="box-body no-padding">
                    <!-- THE CALENDAR -->
                    <div id="calendar"></div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!--CREATE EVENT SIDEBAR -->
        @if(Auth::user()->usertype == '1')
            <div class="col-md-3">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h4 class="box-title">Draggable Events</h4>
                    </div>
                    <div class="box-body">
                        <!-- the events -->
                        <div id="external-events"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /. box -->
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Create Holiday</h3>
                    </div>
                    <div class="box-body">
                        <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                            <!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
                            <ul class="fc-color-picker" id="color-chooser">
                                <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
                                <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
                            </ul>
                        </div>
                        <!-- /btn-group -->
                        <div class="input-group">
                            <input id="new-event" type="text" class="form-control" placeholder="Holiday Title">

                            <div class="input-group-btn">
                                <button id="add-new-event" type="button" class="btn btn-primary btn-flat" style="color: white;">Add</button>
                            </div>
                            <!-- /btn-group -->
                        </div>
                        <!-- /input-group -->
                    </div>
                </div>
            </div>
        @endif
    </div>

@endsection
@section('js')
    @parent
    <script src="{{ asset('public/assets/js/jquery4.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
        var calendar_event = $("#calendar_holiday").data('link');

        $(function () {
            function ini_events(ele) {
                ele.each(function () {

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
            var id = 1000000;
            var json = '';
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
                    eventResize: function(event)
                    {
                        <?php if(Auth::user()->usertype): ?>
                        var url = $('#calendar_update').data('link');
                        var object = {
                            'type' : 'resize',
                            //'event_id' : event.event_id+"<?php echo Auth::user()->userid; ?>",
                            'event_id' : event.event_id,
                            'end' : event.end.format()
                        };
                        $.post(url,object,function(result){
                            Lobibox.notify('info',{
                                msg:'Successfully Holiday Resized!'
                            });
                        });
                        <?php else: ?>
                            event.resizable = false;
                        <?php endif; ?>
                    },
                    eventRender: function(event, element) {
                        element.append( "<span class='remove_event' style='color: red'><i class='fa fa-remove'></i></span>" );
                        <?php if(Auth::user()->usertype): ?>
                        element.find(".remove_event").click(function() {
                            Lobibox.confirm({
                                msg: "Are you sure you want to delete this holiday?",
                                callback: function ($this, type, ev) {
                                    if(type == 'yes'){
                                        $('#calendar').fullCalendar('removeEvents',event.id);
                                        //var calendar_delete = $('#calendar_delete').data('link')+'/'+event.event_id+"<?php echo Auth::user()->userid; ?>";
                                        var calendar_delete = $('#calendar_delete').data('link')+'/'+event.event_id;
                                        $.get(calendar_delete,function(){
                                            Lobibox.notify('error',{
                                                msg:'Successfully Deleted!'
                                            });
                                        });
                                    } else {
                                        Lobibox.notify('info',{
                                            size: 'mini',
                                            rounded: true,
                                            delayIndicator: false,
                                            msg:"You have clicked 'No' button."
                                        });
                                    }
                                }
                            });
                        });
                        <?php else: ?>
                            event.editable = false;
                        <?php endif; ?>
                    },
                    eventDrop: function(event,jsEvent) {

                        var url = $('#calendar_update').data('link');
                        var object = {
                            'type' : 'drop',
                            //'event_id' : event.event_id+"<?php echo Auth::user()->userid; ?>",
                            'event_id' : event.event_id,
                            'start' : event.start.format()
                        };
                        $.post(url,object,function(result){
                            Lobibox.notify('warning',{
                                msg:'Holiday Transferred!'
                            });
                            console.log(result);
                        });
                    },
                    eventMouseover: function(event, jsEvent, view) {
                        //var tooltip = '<div class="tooltipevent" id='+event.id+'>' + event.title + '</div>';
                        var tooltip = '<button type="button" class="tooltipevent" data-toggle="tooltip" data-placement="top" title="Tooltip on top" id='+event.id+'>'+ event.title + '</button>';
                        $("body").append(tooltip);
                        $(this).mouseover(function(e) {
                            $(this).css('z-index', 10000);
                            //$('.tooltipevent').fadeIn('500');
                            $('.tooltipevent').fadeTo('10', 1.9);
                        }).mousemove(function(e) {
                            $('.tooltipevent').css('top', e.pageY + 10);
                            $('.tooltipevent').css('left', e.pageX + 20);
                        });
                    },
                    eventMouseout: function(event, jsEvent, view) {
                        $('#'+event.id).remove();
                    },
                    droppable: true, // this allows things to be dropped onto the calendar !!!
                    drop: function (date, allDay) { // this function is called when something is dropped

                        // retrieve the dropped element's stored Event Object
                        var originalEventObject = $(this).data('eventObject');

                        id++;
                        json = {
                            'id' : id,
                            'event_id' : new Date(),
                            'title' : $(this).data('eventObject')['title'],
                            'start' : date.format(),
                            'end' : date.format(),
                            'backgroundColor' : $(this).css('background-color'),
                            'borderColor' : $(this).css('border-color'),
                            'status' : 1
                        };
                        var url = $('#calendar_save').data('link');
                        $('#calendar').fullCalendar('renderEvent', json, true);
                        $.post(url,json,function(){
                            Lobibox.notify('success',{
                                msg:'Successfully Added!'
                            });
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
    </script>
@endsection
