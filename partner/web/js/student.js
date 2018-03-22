function onShowDocumentsModalClick() {
	alert('test');
    $('#transcripts').modal('show');
}

function onAddDocumentClick(tableID) {

/****************************
@Created by: Pankaj
@Use :- Student document list is inserting in student_document table.
**************************/
	var documentlist=[];
	 var rowid = jQuery('#currentrowid').val();
     var num = parseInt(rowid) + 1;
	 
	 $.get('?r=consultant/students/getdocumentlist', function(response){
		 var valueobject =jQuery.parseJSON(response);
		 $.each(valueobject, function (i, value) {
			$.each(value, function (j, valu) {
				var dropdownvalue='<option value='+j+'>'+valu+'</option>';
				jQuery('#document_type_id_'+num).append(dropdownvalue);
				//documentlist.push(dropdownvalue);
			});
		});
    });
	
var test ='<tr id="101"><td><select id="document_type_id_'+num+'" name="document_type_id_'+num+'" style="width:120px;" required ><option value="">Select Document</option></select></td><td><input name="test-'+num+'"  required /></td><td><input name="document-'+num+'" type="file" required /></td></tr>';
	
    jQuery("#"+tableID).append(test);
	jQuery('#currentrowid').val(num);

	
}

function onUploadClick(e) {
    var formData = new FormData($('#docs')[0]);
 
	$.ajax({
        url: '?r=consultant/students/upload-documents',
        type: 'POST',
        xhr: function() {
            var myXhr = $.ajaxSettings.xhr();
            return myXhr;
        },
        success: function (data) {
            var response = JSON.parse(data);
			
			console.log(response);
            if (response.status == 'success') {
               window.location.reload();
            } /*else {
               // alert("Update failed");
				//alert(response.error);
                console.error(response);
				//$('#message_display').html(response.error);
            }*/
           //document.getElementById("modal-close").click();
        },
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
    return false;
}
 
deleteStudentDocument = function (documentFileName,studentDocumentId) {
	 
	if(studentDocumentId!=""){
	$.ajax({
        url: '?r=consultant/students/deletedocument',
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
        //cache: false,
       // contentType: false,
       // processData: false
    });
	}else {
		alert('Document is empty!');
	}
	
}


function loadTaskview(id) { 
	$.ajax({
            url: '?r=tasks/view&id='+id,
            method: 'GET', 
            success: function( data) {  
                $('#taskPreview').html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        });  
}
 

function removeFromShortlist() {
    var id = $(this).attr('data-id');
	confirm("Are you sure?");
 
    $.ajax({
        url: '?r=consultant/students/remove-from-shortlist',
        method: 'POST',
        data: {
            id: id
        },
        success: function(responseText) {
            var response = JSON.parse(responseText);

            if(response.status === 'success') {
                window.location.reload();
            } else {
                alert(response.message);
            }
        },
        error: function(error) {
            alert('Error removing from shortlist');
            console.log(error);
        }
    })
}
