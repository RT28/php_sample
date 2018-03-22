var currentEvent = null;

function initCalendar() {
    populateEventTypes();         
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
         
        $('#calendar-detailed').fullCalendar('render');

        $('.btn-event-add').click(onBtnEventAddClick);
        $('.btn-event-update').click(onBtnEventUpdateClick);
        $('.btn-event-delete').click(onBtnEventDeleteClick);
        $('.btn-event-form-update').click(onBtnEventFormUpdateClick);
        $('#input-event-event_type').change(onEventTypeChange);

}


function onBtnExpandButtonClick(e) {
    $('#calendar-modal').modal('show');
}

function getCalendarEvents(start, end, timezone, callback) {    
    $.ajax({
        url: '?r=consultant/consultant/get-consultant-calendar',
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
                        case 0: events[i].className = "event-unavailable"; break;
                        case 1: events[i].className = "event-reminder"; break;
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
    $("#calendar-allmeetings").hide();
    $('#event-form').trigger('reset');
    $('#calendar-event-detail').addClass('hidden');
    $('#calendar-form').removeClass('hidden');
    $('.btn-event-form-update').addClass('hidden');
    $('.btn-event-add').removeClass('hidden');  

    $('#input-event-title').val('');
    $('#input-event-location').val('');
    $('#input-event-start').val('')
    $('#input-event-end').val('')
    $('#input-event-mode option[value="0"]').prop("selected", true);
    $('#input-event-remarks').val('');
    $('#input-event-alerts option[value="0"]').prop("selected", true);

    $(".ids_students").prop("checked", false);
   
}

function calendarEventClick(event, e, view) {
    $("#calendar-allmeetings").hide();
    $('#calendar-event-detail').removeClass('hidden');
    $('#calendar-form').addClass('hidden');
    $("#all_mtg").remove();
    $.ajax({
        url: '?r=consultant/consultant/get-eventdetails',
        dataType: 'html',
        data: {id : event.id},
        method: 'POST',
        success: function(response) {
                $('#calendar-event-detail').html(response);
        },
        error: function(){
            console.log('error', arguments);
        }
    });      
 
    currentEvent = event;
    return false;
}

function onBtnEventAddClick() {
    if(($('#input-event-title').val()=='') || $('#input-event-start').val()=='' || $('#input-event-end').val()==''){
        $('#err_msg').show();
    } else{
        $('#err_msg').hide();
        $("#calendar-allmeetings").hide();
        var ids_students = [];
        $('.ids_students:checked').each(function(i, e) {
            ids_students.push($(this).val());
        });
    var event = {
        title: $('#input-event-title').val(),
        location: $('#input-event-location').val(),
        start: $('#input-event-start').val(),
        end: $('#input-event-end').val(),
        mode: $('#input-event-mode').val(),  
        remarks: $('#input-event-remarks').val(),
        alert: $('#input-event-alerts').val(),                
    };

    event.start = moment(event.start).utc().format('YYYY-MM-DD HH:mm:ss');
    event.end = moment(event.end).utc().format('YYYY-MM-DD HH:mm:ss');


    $.ajax({
        url: '?r=consultant/consultant/add-event',
        dataType: 'json',
        data: {event : event , ids_students : ids_students},
        method: 'POST',
        success: function(response) {
            if(response.status == "success") {
                $('#calendar-detailed').fullCalendar('refetchEvents');
                $('#calendar').fullCalendar('refetchEvents');
                $(".popup-closer").trigger("click");
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
}

function onBtnEventUpdateClick(id) { 
    var event = currentEvent;
    $.ajax({
        url: '?r=consultant/consultant/get-invities',
        dataType: 'html',
        data: {id : id},
        method: 'POST',
        success: function(response) {
                $('#calendar-form').html(response);
        },
        error: function(){
            console.log('error', arguments);
        }
    });
    $("#calendar-allmeetings").hide();
    $('#calendar-event-detail').addClass('hidden');
    $('#calendar-form').removeClass('hidden');
    $('.btn-event-form-update').removeClass('hidden');    
    $('.btn-event-add').addClass('hidden');
    
    currentEvent = null;
    return false;
}
function onBtnEventDeleteClick(id) {
    var event = {        
        id: id,                
    };
    
    /*if(currentEvent.event_type == 2 && currentEvent.appointment_status == 1 ) {
        alert("You cannot delete an approved appointment. Please contact your Concellor/Consultant to change it");
        return false;
    }*/

    $.ajax({
        url: '?r=consultant/consultant/delete-event',
        dataType: 'json',
        data: event,
        method: 'POST',
        success: function(response) {
            if(response.status == "success") {
                $('#calendar-detailed').fullCalendar('refetchEvents');
                $('#calendar').fullCalendar('refetchEvents');
                $(".popup-closer").trigger("click");
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
    if(($('#input-event-title').val()=='') || $('#input-event-start').val()=='' || $('#input-event-end').val()==''){
        $('#err_msg').show();
    } else{
        $('#err_msg').hide();
    var event = {
        title: $('#input-event-title').val(),
        id: $('#input-event-id').val(),
        location: $('#input-event-location').val(),
        start: $('#input-event-start').val(),
        end: $('#input-event-end').val(),
        mode: $('#input-event-mode').val(),         
        remarks: $('#input-event-remarks').val(), 
        alert: $('#input-event-alerts').val(), 
        //appointment_with: $('#input-event-appointment-with').val(),
        //appointment_role: $('#input-event-appointment-with').attr('role'),                
    };
    event.start = moment(event.start).utc().format('YYYY-MM-DD HH:mm:ss');
    event.end = moment(event.end).utc().format('YYYY-MM-DD HH:mm:ss');

    var ids_students = [];
    $('.ids_students:checked').each(function(i, e) {
        ids_students.push($(this).val());
    });


    $.ajax({
        url: '?r=consultant/consultant/update-event',
        dataType: 'json',
        data: {event : event , ids_students : ids_students},
        method: 'POST',
        success: function(response) {
            if(response.status == "success") {
                $('#calendar-detailed').fullCalendar('refetchEvents');
                $('#calendar').fullCalendar('refetchEvents');
                $(".popup-closer").trigger("click");
            }
        },
        error: function(){
            console.log('error', arguments);
        }
    });
    return false;
}
}

var event_types = [];
function populateEventTypes() {
    $.ajax({
        url: '?r=consultant/consultant/get-event-types',                
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

var meetingtypes = ['Appointment','Event','Followup','Task']; 

function getMeetingType(index) {
    return meetingtypes[index];
}

function getMeetingTypeIndex(name) {
    return meetingtypes.indexOf(name);
}

var modetypes = ['Telephone','Skype','Face to Face','Others']; 

function getModeType(index) {
    return modetypes[index];
}

function getModeTypeIndex(name) {
    return modetypes.indexOf(name);
}
 
function getConsultantId() {
    var optionSelected = $("#input-event-appointment-with option");
    var consultantId = null;
    optionSelected.each(function(index, option){
        if ($(option).attr('role') == 6) {
            consultantId = $(option).val();
            return false;
        }
    });
    return consultantId;
}
function getAllmeetings(){ 

    /*$(".cal-popup").addClass("open");
            $("body").addClass("open-cal-popup");
            $(".popup-closer").addClass("active");*/
    $('#calendar-form').addClass('hidden');     
    $('#calendar-event-detail').addClass('hidden');  
    $.ajax({
        url: '?r=consultant/consultant/get-consultant-allmeetings',
        dataType: 'html',
        method: 'POST',
        success: function(response) {
            $("#calendar-allmeetings").show();
            $("#calendar-allmeetings").html(response);

        },
        error: function(){
            console.log('error', arguments);
        }
    });        
            
}

/*function deleteMeeting(id){
    
    $.ajax({
        url: '/student/delete-event',
        dataType: 'json',
        data: {id : id },
        method: 'POST',
        success: function(response) {
            if(response.status == "success") {
                $('#meeting_row'+id).remove();
                $('#calendar-detailed').fullCalendar('refetchEvents');
                $('#calendar').fullCalendar('refetchEvents');
                $(".popup-closer").trigger("click");
            }
        },
        error: function(){
            console.log('error', arguments);
        }
    });
}*/

function editMeeting(id){
    $("#calendar-allmeetings").hide();
    $('#calendar-event-detail').removeClass('hidden');
    $('#calendar-form').addClass('hidden');
    $.ajax({
        url: '?r=consultant/consultant/get-eventdetails',
        dataType: 'html',
        data: {id : id},
        method: 'POST',
        success: function(response) {
                $('#calendar-event-detail').html(response);
        },
        error: function(){
            console.log('error', arguments);
        }
    });
    $('#event-id').html(event.id);

}
function changeEventStatus(status,id) {
$.ajax({
        url: '?r=consultant/consultant/change-eventstatus',
        dataType: 'JSON',
        data: {id : id, status : status},
        method: 'POST',
        success: function(response) { 
               if(status == 1){
                $('#btn_e_accept'+id).addClass('hidden');
                $('#btn_e_reject'+id).removeClass('hidden');
               }else if(status == 2){
                $('#btn_e_accept'+id).removeClass('hidden');
                $('#btn_e_reject'+id).addClass('hidden');
               }
               if(response.e_count > 0){
               $('#e_count').text(response.e_count); 
               }
        },
        error: function(){
            console.log('error', arguments);
        }
    });
}
