var currentEvent = null;
$(document).ready(function() {
    //populateEventTypes();    

    var calendar = $('#calendar');
    $(calendar).click(onBtnExpandButtonClick);

    if(calendar.length > 0) {
        $('#calendar').fullCalendar({
            events: getCalendarEvents,
            header: {
                left: 'prev',
                center: 'title',
                right: 'next'
            },            
        });        

        $('#calendar-detailed').fullCalendar({            
            header: {
                left: 'prev, next, today',
                center: 'title',
                right: 'month, basicWeek, basicDay, agendaWeek'
            },
            events: getCalendarEvents,
            dayClick: calendarDayClick,
            eventClick: calendarEventClick
        });

        $('#calendar-modal').on('shown.bs.modal', function(){            
            $('#calendar-detailed').fullCalendar('render');
        });

        $('.btn-event-add').click(onBtnEventAddClick);
        $('.btn-event-update').click(onBtnEventUpdateClick);
        $('.btn-event-delete').click(onBtnEventDeleteClick);
        $('.btn-event-form-update').click(onBtnEventFormUpdateClick);
        $('#input-event-event_type').change(onEventTypeChange);
    }
});


function onBtnExpandButtonClick(e) {
    $('#calendar-modal').modal('show');
}

function getCalendarEvents(start, end, timezone, callback) {    
    $.ajax({
        url: '?r=srm/get-srm-calendar',
        dataType: 'json',
        data: {            
            start: moment(start).format('Y-MM-DD hh:mm:ss'),            
            end: moment(end).format('Y-MM-DD hh:mm:ss')            
        },
        method: 'POST',
        success: function(response) {
            if(response.status == "success") {
                var events = response.response;                
                for(var i = 0; i < events.length; i++) {
                    events[i].start = moment.utc(events[i].start).local();
                    events[i].end = moment.utc(events[i].end).local();
                    switch(events[i].event_type) {
                        case 0: events[i].className = "event-reminder"; break;
                        case 1: events[i].className = "event-unavailable"; break;
                        case 2: events[i].className = "event-appointment"; break;
                        case 3: events[i].className = "event-other"; break;
                    }
                }
                callback(events);
            }
        },
        error: function(){
            console.log('error', arguments);
        }
    });
    
    $('#event-form').trigger('reset');
    $('.btn-event-form-update').addClass('hidden');
    $('.btn-event-add').removeClass('hidden');
    $('#calendar-event-detail').addClass('hidden');
    $('#calendar-form').removeClass('hidden');
}

function calendarDayClick() {
    $('#event-form').trigger('reset');
    $('#calendar-event-detail').addClass('hidden');
    $('#calendar-form').removeClass('hidden');
    $('.btn-event-form-update').addClass('hidden');
    $('.btn-event-add').removeClass('hidden');   
}

function calendarEventClick(event, e, view) {
    $('#calendar-event-detail').removeClass('hidden');
    $('#calendar-form').addClass('hidden');
    $('#event-title').html(event.title);
    $('#event-url').html(event.url);

    if (event.url && event.url.search('http://') == -1) {
        $('#event-url').attr('href', 'http://' + event.url);    
    } else {
        $('#event-url').attr('href', event.url);
    }      
    $('#event-start').html(moment(event.start).local().format("YYYY-MM-DD HH:mm:ss"));
    $('#event-end').html(moment(event.end).local().format("YYYY-MM-DD HH:mm:ss"));
    $('#event-type').html(getEventType(event.event_type));
    $('#event-id').html(event.id);
    $('#event-remarks').html(event.remarks);
    
    if(event.event_type == 2) {
        $('#event-status-container').removeClass('hidden');        
        if(event.student_appointment_id != null) {
            $('#event-appointment-with').html(event.student_appointment_id);
            $('#event-appointment-with').attr('role', 3);            
        }
        $('#event-status').html(event.appointment_status == 0 ? 'Pending' : 'Approved');
        $('#event-status').attr('data-status', event.appointment_status);
    } else {        
        $('#event-status-container').addClass('hidden');
        $('#event-appointment-with').html(null);
        $('#event-appointment-with').attr('role', null);        
    }

    currentEvent = event;
    return false;
}

function onBtnEventAddClick() {
    var event = {
        title: $('#input-event-title').val(),
        start: $('#input-event-start').val(),
        end: $('#input-event-end').val(),
        url: $('#input-event-url').val(),
        event_type: $('#input-event-event_type').val(),        
        remarks: $('#input-event-remarks').val(),                
    };

    event.start = moment(event.start).utc().format('YYYY-MM-DD HH:mm:ss');
    event.end = moment(event.end).utc().format('YYYY-MM-DD HH:mm:ss');

    if(event.event_type == 2) {
        var selection = $('#input-event-appointment-with option:selected');
        event.appointment_with = selection.val();
        event.appointment_role =  selection.attr('data-role');
    }

    $.ajax({
        url: '?r=srm/add-event',
        dataType: 'json',
        data: event,
        method: 'POST',
        success: function(response) {
            if(response.status == "success") {
                $('#calendar-detailed').fullCalendar('refetchEvents');
                $('#calendar').fullCalendar('refetchEvents');
            } else {
                var container = $('.calendar-alert');
                $('.calendar-alert-text').text(response.message);
                container.removeClass("hidden");
                setTimeout(function(){
                    container.addClass("hidden");
                }, 5000);
            }
        },
        error: function(){            
            console.log('error', arguments);
        }
    });

    return false;
}

function onBtnEventUpdateClick() {    
    var event = currentEvent;
    if(currentEvent.event_type == 2 && currentEvent.appointment_status == 1 ) {
        alert("You cannot update an approved appointment. Please contact your Concellor/Consultant to change it");
        return false;
    }

    $('#calendar-event-detail').addClass('hidden');
    $('#calendar-form').removeClass('hidden');
    $('#input-event-title').val(event.title);
    $('#input-event-id').val(event.id);
    $('#input-event-start').val(moment(event.start).format("YYYY-MM-DD HH:mm:ss"));
    $('#input-event-end').val(moment(event.end).format("YYYY-MM-DD HH:mm:ss"));
    $('#input-event-url').val(event.url);
    $('#input-event-event_type').val(event.event_type);
    if (event.event_type == 2) {
        $('#appointment-container').removeClass('hidden');
        if(event.student_appointment_id != null) {
            $('#input-event-appointment-with').val(getStudentId());
        }
        $('#input-event-appointment-status').html(event.appointment_status == 1 ? 'Approved' : 'Pending');
        $('#input-event-status-container').removeClass('hidden');
                
    } else {
        $('#input-event-appointment-with').val(null);
        $('#appointment-container').addClass('hidden');
        $('#input-event-status-container').addClass('hidden');        
        $('#input-event-appointment-status').html(null);
    }
    $('#input-event-remarks').val(event.remarks);
    $('#input-event-appointment-status').val(event.status);
    $('.btn-event-form-update').removeClass('hidden');    
    $('.btn-event-add').addClass('hidden');
    currentEvent = null;
    return false;
}

function onBtnEventDeleteClick() {
    var event = {        
        id: $('#event-id').html(),                
    };

    $.ajax({
        url: '?r=srm/delete-event',
        dataType: 'json',
        data: event,
        method: 'POST',
        success: function(response) {
            if(response.status == "success") {
                $('#calendar-detailed').fullCalendar('refetchEvents');
                $('#calendar').fullCalendar('refetchEvents');
            }
        },
        error: function(){
            console.log('error', arguments);
        }
    });
    currentEvent = null;
    return false;
}

function onBtnEventFormUpdateClick() {
    var event = {
        title: $('#input-event-title').val(),
        id: $('#input-event-id').val(),
        start: $('#input-event-start').val(),
        end: $('#input-event-end').val(),
        url: $('#input-event-url').val(),
        event_type: $('#input-event-event_type').val(),
        remarks: $('#input-event-remarks').val(),
        status: $('#input-event-status').val(),
    };

    event.start = moment(event.start).utc().format('YYYY-MM-DD HH:mm:ss');
    event.end = moment(event.end).utc().format('YYYY-MM-DD HH:mm:ss');

    if(event.event_type == 2) {
        var selection = $('#input-event-appointment-with option:selected');
        event.appointment_with = selection.val();
        event.appointment_role =  selection.attr('data-role');
    }

    $.ajax({
        url: '?r=srm/update-event',
        dataType: 'json',
        data: event,
        method: 'POST',
        success: function(response) {
            if(response.status == "success") {
                $('#calendar-detailed').fullCalendar('refetchEvents');
                $('#calendar').fullCalendar('refetchEvents');
            }
        },
        error: function(){
            console.log('error', arguments);
        }
    });
    return false;
}

var event_types = [];
function populateEventTypes() {
    $.ajax({
        url: '/gotouniversity/backend/web/index.php?r=srm/get-event-types',                
        method: 'GET',
        success: function(response) {
            response = JSON.parse(response);
            if(response.status == "success") {
                var select = $('#input-event-event_type');
                select.empty();
                var data = event_types = response.response;
                for(var i = 0; i < data.length; i++) {
                    select.append( '<option value="' + i + '"' + (i == 0 ? 'selected="selected"' : '') + '>'
                                 + data[i]
                                 + '</option>' ); 
                }
            }
        },
        error: function(){
            console.log('error', arguments);
        }
    });
}

function onEventTypeChange() {
    var optionSelected = $("option:selected", this);
    if(this.value == 2) {
       $('#appointment-container').removeClass('hidden'); 
    } else {
        $('#appointment-container').addClass('hidden');
    }
}

function getEventType(index) {
    return event_types[index];
}

function getEventTypeIndex(name) {
    return event_types.indexOf(name);
}

function getStudentId() {
    var optionSelected = $("#input-event-appointment-with option");
    var srmID = null;
    optionSelected.each(function(index, option){
        if ($(option).attr('role') == 4) {
            srmID = $(option).val();
            return false;
        }
    });
    return srmID;
}