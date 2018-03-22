function onAddCourseClick(tableID) {

	 var rowid = jQuery('#pcurrentrowid').val();
     var num = parseInt(rowid) + 1;
	 
	 $.get('?r=consultant/students/getuniversitieslist', function(response){
		 var valueobject =jQuery.parseJSON(response);  
		 $.each(valueobject, function (i, value) {
			var dropdownvalue='<option value="'+i+'" >'+value+'</option>';
			jQuery('#university_id_'+num).append(dropdownvalue); 
		});
    });
	
	$.get('?r=consultant/students/getdegreelevellist', function(response){
		 var valueobject =jQuery.parseJSON(response);  
		 $.each(valueobject, function (i, value) {
			var dropdownvalue='<option value="'+i+'" >'+value+'</option>';
			jQuery('#degree_level_id_'+num).append(dropdownvalue); 
		});
    });
	
	$.get('?r=consultant/students/getdegreelevellist', function(response){
		 var valueobject =jQuery.parseJSON(response);  
		 $.each(valueobject, function (i, value) {
			var dropdownvalue='<option value="'+i+'" >'+value+'</option>';
			jQuery('#degree_level_id_'+num).append(dropdownvalue); 
		});
    });
   
var test ='<tr id="'+num+'"><td><select id="university_id_'+num+'" name="document['+num+'][university_id]" style="width:120px;" required ><option value="">Select University</option></select></td><td><select id="degree_level_id_'+num+'" name="document['+num+'][degree_level_id]" style="width:120px;" required onchange="getPrograms($(this).val(),'+num+')"><option value="">Select University</option></select></td><td><div id="courselist'+num+'"></div></td></tr>';
	 
    jQuery("#"+tableID).append(test);
	jQuery('#pcurrentrowid').val(num);
 
}
 

function getPrograms(degree_level,num) {
      
	  
	var university = jQuery('#university_id_'+num).val();  
	 
	$.ajax({
            url: '?r=consultant/students/getprograms',
            method: 'POST',
            data: { 
                university: university,
				degree_level: degree_level,
				num: num,
            },
            success: function(response) { 
					jQuery('#courselist'+num).html(response); 
            },
            error: function(error) {
                console.log(error);
            }
        });
		
	
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
 