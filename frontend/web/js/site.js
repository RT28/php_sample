function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
}

function onBtnSendContactQueryClick(e) {
    var firstName = $('#txt-first-name').val(); 
    var email = $('#txt-contact-email').val();
    var code = $('#contact-phone_code').val();
	var phone = $('#txt-contact-phone').val();
    var message = $('#txt-contact-message').val();

	if(firstName ==''){
		$('#first-name-help').html('First Name is Required.');
		$('#first-name-help').css('color','red');
		return false;
	}else{
		
		$('#first-name-help').html('');
	}
	
	if(email ==''){
		$('#contact-email-help').html('Email is Required.');
		$('#contact-email-help').css('color','red');
		return false;
	}else {
		if(!ValidateEmail(email)) {
			$('#contact-email-help').html('Invalid email address.');
			$('#contact-email-help').css('color','red');
			return false;
		 }else{
			 $('#contact-email-help').html('');
		 }
	}
	
	if(code ==''){
		$('#contact-phone_code-help').html('Country Code is Required.');
		$('#contact-phone_code-help').css('color','red');
		return false;
	}else{
		
		$('#contact-phone_code-help').html('');
	}
	
	if(phone ==''){
		$('#contact-phone-help').html('Phone Number is Required.');
		$('#contact-phone-help').css('color','red');
		return false;
	}else{
		$('#contact-phone-help').html('');
	}
	if(message ==''){
		$('#contact-message-help').html('Message is Required.');
		$('#contact-message-help').css('color','red');
		return false;
	}else{
		$('#contact-message-help').html('');
	}
	 
    $.ajax({
        url: '/site/contact-query',
        method: 'POST',
        data: {
            first_name: firstName, 
            email: email,
            phone: phone,
            code: code,
            message: message,
            source: window.location.pathname
        },
        success: function(response) {
            response = JSON.parse(response);
            if(response.status === 'success') { 
				$('#contact-query-status').removeClass('alert alert-danger');
				$('#contact-query-status').addClass('alert alert-success');
				$('#contact-query-status').html(response.message);
				$('#contact-query-status').show(); 
				document.getElementById("frm-contact").reset();
            }
			
			if(response.status === 'error') { 
				$('#contact-query-status').removeClass('alert alert-success');
				$('#contact-query-status').addClass('alert alert-danger');
				$('#contact-query-status').show();
				$('#contact-query-status').html(response.message);
			}  
        },
        error: function(error) {
            console.error(error); 
			$('#contact-query-status').removeClass('alert alert-success');
			$('#contact-query-status').addClass('alert alert-danger');
			$('#contact-query-status').show();
           $('#contact-query-status').html(response.message);
        }
    });
	
	
}

function isEmpty(value, label, container) {
    var result = value === null || value === undefined || value === '';

    if(result === true) {
        $('#' + label).html('Required');
        $('#' + container).addClass('has-error');
    } else {
        $('#' + label).html('');
        $('#' + container).removeClass('has-error');
    }
    return result;
}
