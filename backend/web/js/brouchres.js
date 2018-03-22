function onAddDocumentClick(tableID) {
 
	 var rowid = jQuery('#currentrowid').val();
     var num = parseInt(rowid) + 1;
	 
	 $.get('?r=university/getdocumentlist', function(response){
		 var valueobject =jQuery.parseJSON(response); 
		 $.each(valueobject, function (i, value) {
			$.each(value, function (j, valu) { 
				var dropdownvalue='<option value='+j+'>'+valu+'</option>';
				jQuery('#document_type_id_'+num).append(dropdownvalue); 
			});
		});
    });

var test ='<tr id="'+num+'"><td><select id="document_type_id_'+num+'" name="document['+num+'][document_type_id]" style="width:120px;" required ><option value="">Select Document</option></select></td><td><input name="document['+num+'][title]"  required /></td><td><input name="document-'+num+'" type="file" required /></td></tr>';
	
	
    jQuery("#"+tableID).append(test);
	jQuery('#currentrowid').val(num);

	
}
 

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
        url: '?r=university/deletedocument',
        type: 'GET',
		data:{name:documentFileName,studocuid:studentDocumentId},
        success: function (data) {
            var response = JSON.parse(data);
			console.log(response);
            if (response.status == 'success') {				
				jQuery('#thumbnail'+studentDocumentId).remove(); 
            }else{
				
			alert('There is no valid document id');	
			}
        }
         
    });
	}else {
		alert('Document is empty!');
	}
	
}
