function connectDisconnectAssociate(consultant,student) {
	
	astatus = $('#status'+consultant).val();
	//alert(astatus);
    
    $.ajax({
        url: '?r=consultant/students/connect-disconnect-associate',
        data: {
            consultant: consultant,
            student: student,
			astatus: astatus,
        },
        method: 'POST',
        error: function(err) {
            alert('Error reaching server');
        },
        success: function(responseText, xhr) {
            var response;
            try {
                response = JSON.parse(responseText);
            } catch(e) {
                alert('Alert parsing response');
            }

            if (response.status === 'success') {
				//alert( response.astatus ); 
				$('#status'+consultant).val(response.astatus)
				 if(response.astatus==1){   
				    $('#status'+consultant).removeClass('btn-danger');
					 $('#status'+consultant).addClass('btn-success'); 
					 $('#status'+consultant).text('Assign'); 
				 }
				 if(response.astatus==0){  
					 $('#status'+consultant).removeClass('btn-success');
					 $('#status'+consultant).addClass('btn-danger'); 
					 $('#status'+consultant).text('unassign'); 
				 }
				 
            } else {
                alert(response.message);
            }
        }
    });
}
 