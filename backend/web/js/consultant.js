function onBodyClick(e) {
    var target = $(e.target);
    if (target.hasClass('btn-verify')) {
        return onBtnVerifyClick(target);
    }
    if (target.hasClass('btn-enable-disable')) {
        return onBtnEnableDisableClick(target);
    }
}

function onBtnVerifyClick(target) {
    var id = target.attr('data-consultant');

    $.ajax({
        url: '?r=admin-consultant/verify',
        data: {
            id: id
        },
        method: 'POST',
        error: function(error) {
            var container = $('.alert-danger');
            $(container).removeClass('hidden');
            $(container).html('Server Error. Please contact administrator');
        },
        success:function(responseText) {
            var container = $('.alert-danger');
            try {
                var response = JSON.parse(responseText);
            }
            catch(e) {
                $(container).removeClass('hidden');
                $(container).html('Error parsing response. Please contact administrator');
            }
            if(response.status === 'success') {
                window.location.reload();
            } else {
                $(container).removeClass('hidden');
                $(container).html('Error.' + response/message);
            }
        }
    });
}



function onBtnEnableDisableClick(target) {
    var id = target.attr('data-consultant');
    var url = '?r=admin-consultant/enable';
    if (target.hasClass('btn-danger')) {
        url = '?r=admin-consultant/disable';
    }
    $.ajax({
        url: url,
        data: {
            id: id
        },
        method: 'POST',
        error: function(error) {
            var container = $('.alert-danger');
            $(container).removeClass('hidden');
            $(container).html('Server Error. Please contact administrator');
        },
        success:function(responseText) {
            var container = $('.alert-danger');
            try {
                var response = JSON.parse(responseText);
            }
            catch(e) {
                $(container).removeClass('hidden');
                $(container).html('Error parsing response. Please contact administrator');
            }
            if(response.status === 'success') {
                window.location.reload();
            } else {
                $(container).removeClass('hidden');
                $(container).html('Error.' + response/message);
            }
        }
    });
}


function updateAgency(element) {        
    var agency_id = element.value;
	alert(agency_id);
    if (agency_id !== null && agency_id !== undefined && agency_id !== "") {
        $.ajax({
            url: '/gotouniversity/backend/web/index.php?r=admin-student/dependent-agency',
            method: 'POST',
            data: {
                'agency_id': agency_id,
            },
            success: function(response) {
                response = JSON.parse(response);
                if(response.status == "success") {
                    var row = element.id.split('-')[1];
                    var select = $('#studentconsultantrelation-' + row + '-consultant_id');

                    select.empty();
                    var data = response.result;
                    for(var i = 0; i < data.length; i++) {
                        select.append( '<option value="' + data[i].id + '">'
                                    + data[i].name
                                    + '</option>' ); 
                    }
                }
            },
            error: function(){
                console.log('error', arguments);
            }
        });
    }
}