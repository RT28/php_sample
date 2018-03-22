$(document).ready(function(){
    // consultant index page.
    if($('.consultant-index').length > 0) {
        $('body').click(onBodyClick);
    }
	if($('.employee-index').length > 0) {
        $('body').click(onBodyClickEmployee);
    }
    if($('.trainer-index').length > 0) {
        $('body').click(onBodyClickTrainer);
    }
});

function onBodyClick(e) {
    var target = $(e.target);  
    if (target.hasClass('btn-enable-disable')) {
        return onBtnEnableDisableClick(target);
    }
} 

function onBtnEnableDisableClick(target) {
    var id = target.attr('data-consultant');
    var url = '?r=agency/consultant/enable';
    if (target.hasClass('btn-danger')) {
        url = '?r=agency/consultant/disable';
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
                //window.location.reload();
            } else {
                $(container).removeClass('hidden');
                $(container).html('Error.' + response/message);
            }
        }
    });
}

 
function onBodyClickEmployee(e) {
    var target = $(e.target);  
    if (target.hasClass('btn-enable-disable')) {
        return onBtnEnableDisableClickforEmployee(target);
    }
}

function onBtnEnableDisableClickforEmployee(target) {
    var id = target.attr('data-employee');
    var url = '?r=agency/employee/enable';
    if (target.hasClass('btn-danger')) {
        url = '?r=agency/employee/disable';
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


function onBodyClickTrainer(e) {
    var target = $(e.target);  
    if (target.hasClass('btn-enable-disable')) {
        return onBtnEnableDisableClickforTrainer(target);
    }
}

function onBtnEnableDisableClickforTrainer(target) {
    var id = target.attr('data-trainer');
    var url = '?r=agency/trainer/enable';
    if (target.hasClass('btn-danger')) {
        url = '?r=agency/trainer/disable';
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
