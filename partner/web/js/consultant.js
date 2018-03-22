function disconnectConsulant() {
    var button = $(this);
    var student = button.attr('data-student');
    var errorContainer = $('.error-container').addClass('hidden');
    $.ajax({
        url: '?r=consultant/students/disconnect',
        method: 'POST',
        data: {
            student: student,
        },
        error: function(err) {
            errorContainer.removeClass('hidden');
            errorContainer.html('Error connecting to server!');
        },
        success: function(responseText, xhr) {
            var response;
            try {
                response = JSON.parse(responseText);
            } catch(e) {
                errorContainer.removeClass('hidden');
                errorContainer.html('Error parsing response');
            }

            if(response.status === 'success') {
                window.location.reload();
            } else {
                errorContainer.removeClass('hidden');
                errorContainer.html(response.message);
            }
        }
    })
}

function sendTaskReminder() {
    var button = $(this);
    var task = button.attr('data-task');
    var errorContainer = $('.error-container').addClass('hidden');
    $.ajax({
        url: '?r=consultant/tasks/reminder',
        method: 'POST',
        data: {
            id: task,
        },
        error: function(err) { 
            errorContainer.removeClass('hidden');
            errorContainer.html('Error connecting to server!');
        },
        success: function(responseText, xhr) {
            var response;
            try {
                response = JSON.parse(responseText);
				alert(response.status);
            } catch(e) {
                errorContainer.removeClass('hidden');
                errorContainer.html('Error parsing response');
            }

            if(response.status === 'success') {
				alert(response.status);
                //window.location.reload();
            } else {
                errorContainer.removeClass('hidden');
                errorContainer.html(response.message);
            }
        }
    })
}
    function get_studetList(status){ alert("DSf");
        //dataString=$('form[name=date_filter]').serialize();
        //var start_date = $('#start_date').val();
         //var end_date = $('#end_date').val();
            $.ajax({
            url: '?r=consultant/leads/index',
            method: 'POST',
            data: {
                status: status
            },
            success: function(data) {
                /*$('#stab_712330').html(data);
                $('.act_common').removeClass("active");
                $('#act_'+status).addClass("active"); 
                if(status=='5'){
                    $('.date_filter_arrow').show();
                    $('.date_filter').hide();
                } else {
                    $('.date_filter_arrow').hide();
                    $('.date_filter').hide();
                }*/
            },
            error: function(error) {
                console.log(error);
            }
        });
           // get_sListCount();
        }
    /*function get_studetList(status,date_range){
        //dataString=$('form[name=date_filter]').serialize();
        var start_date = $('#start_date').val();
         var end_date = $('#end_date').val();
            $.ajax({
            url: '?r=consultant/studentslist/studentlist',
            method: 'POST',
            data: {
                status: status, date_range : date_range, start_date : start_date, end_date : end_date
            },
            success: function(data) {
                $('#stab_712330').html(data);
                $('.act_common').removeClass("active");
                $('#act_'+status).addClass("active"); 
                if(status=='5'){
                    $('.date_filter_arrow').show();
                    $('.date_filter').hide();
                } else {
                    $('.date_filter_arrow').hide();
                    $('.date_filter').hide();
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
            get_sListCount();
        }*/
    function fn_getfollowup(id){
        $.ajax({
            url: '?r=consultant/studentslist/followup',
            method: 'POST',
            data: {
                student_id: id,
            },
            success: function(data) {
                if($("#flp_713548").length!==1){
                $('#sfb_712330'+id).html("<div id='flp_713548'></div>");
                }
                $('#flp_713548').html(data);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
    function fn_closefollowup(){
        $('#flp_713548').remove();
    }
    function fn_followstatus(val){
       if(val==0){
        $('#flp_714234').hide();
        $('#rsn_714234').hide();
        $('#message_submit').hide();
        $('#package_send').hide();
       } else if(val==1){
       $('#flp_714234').show();
        $('#rsn_714234').hide();
        $('#message_submit').show();
        $('#package_send').hide();
       } else if(val==2){
        $('#flp_714234').hide();
        $('#rsn_714234').show();
        $('#message_submit').show();
        $('#package_send').hide();
       } else if(val==3){ 
        $('#flp_714234').hide();
        $('#rsn_714234').hide();
        $('#message_submit').hide();
        $('#package_send').show();
       }
       else if(val==4){ 
        $('#flp_714234').hide();
        $('#rsn_714234').hide();
        $('#message_submit').show();
        $('#package_send').hide();
       }
       else if(val==6){ 
        $('#flp_714234').hide();
        $('#rsn_714234').hide();
        $('#message_submit').show();
        $('#package_send').hide();
       }
       
    }
    function fn_savefoloowUp(){
        dataString=$('form[name=folloup_form]').serialize();
        var error_status = '0';
        if($('#follow_comment').val()=='' || $('#comment_date').val()=='' || $('#fl_mode').val()=='0'){
            if($("#err_msg724").length!==1){
            $('#student_id').after("<i id='err_msg724' style='color: rgb(148, 34, 34);'>Fields marked as <span class='red_star'>*</span> are mandatory!!</i>");
            }
            error_status = '1';
        } 
        var status_val = $('#st_714230').val();
        if(status_val=='1'){
            if($('#next_followup').val()=='' || $('#next_follow_comment').val()==''){
            if($("#err_msg724").length!==1){
            $('#student_id').after("<i id='err_msg724' style='color: rgb(148, 34, 34);'>Fields marked as <span class='red_star'>*</span> are mandatory!!</i>");
            }
            error_status = '1';
            }
        } else if(status_val=='2'){
            if($('#reason_code').val()=='0'){
            if($("#err_msg724").length!==1){
            $('#student_id').after("<i id='err_msg724' style='color: rgb(148, 34, 34);'>Fields marked as <span class='red_star'>*</span> are mandatory!!</i>");
            }
            error_status = '1';
            }

        }
        if(error_status=='0'){
        $.ajax({
            url: '?r=consultant/studentslist/savefollowup',
            method: 'POST',
            data: dataString,
            success: function(response, data) { 
                response = JSON.parse(response); 
                //$('#flp_713548').remove();
                if(response.status_message==3 && response.send_package=='yes'){
                    location.href = '?r=consultant/students/assign-package&id='+response.student_id;
                }
                get_studetList(response.status_message);
                fn_getfollowup(response.student_id);
            },
            error: function(error) {
                console.log(error);
            }
        });
        }
    }
    function get_sListCount(){
        $.ajax({
            url: '?r=consultant/studentslist/getslistcount',
            method: 'POST',
            success: function(response, data) { 
                response = JSON.parse(response);
                $('#cnt_0').html(response.count_new);
                $('#cnt_1').html(response.count_active);
                $('#cnt_2').html(response.count_inactive);
                $('#cnt_3').html(response.count_accesssend);
                $('#cnt_4').html(response.count_subscribed);
                $('#cnt_5').html(response.count_today);
                $('#cnt_6').html(response.count_closed);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
function toggle(id) {
$('.collapse').hide();
$('#'+id).show();
} 

$(document).on('click', '#btwn_date_li', function () {
   $('#btwn_dates').show();
   $('.date_filter').hide();
});
$(document).on('click', '#close_dtfilter', function () {
   $('#btwn_dates').hide();
});

