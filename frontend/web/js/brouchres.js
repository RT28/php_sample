
 

function onBtnUpdateClick(e) {
    var container = $(this).attr('data-container');
    var url = $(this).attr('href');
    
    $('#' + container).load(url,function(response, status, xhr){
        if(status !== 'success') {
            alert('errror');
            console.log(status);
        }
    });

    return false;
}


deleteDocument = function (documentFileName,studentDocumentId) {
	
	if(studentDocumentId!=""){
	$.ajax({
        url: '/university/university/deletedocument',
        type: 'GET',
		data:{name:documentFileName,studocuid:studentDocumentId},
        success: function (data) {
            var response = JSON.parse(data);
			console.log(response);
            if (response.status == 'success') {
               window.location.reload();
            }else{
				
			alert('There is no valid document id');	
			}
        }
         
    });
	}else {
		alert('Document is empty!');
	}
	
}
