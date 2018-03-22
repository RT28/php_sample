
function onDeleteCourseButtonClick(button) {
   var index = Number(button.getAttribute('data-index'));
    var i=0;
    var arr = []; 
    var x; 
    $('.course_type').each(function(){
        arr[i++] = $(this).val();
    });
    //remove from array.
    arr.splice(index, 1);    
    //update table DOM
    updateTableDOM(arr, 'course_type', true,'course-form','onDeleteCourseButtonClick(this)'); 
}

function onDeleteEstablishmentButtonClick(button) {
    var index = Number(button.getAttribute('data-index'));
    var i=0;
    var arr = []; 
    var x; 
    $('.establishment').each(function(){
        arr[i++] = $(this).val();
    });
    //remove from array.
    arr.splice(index, 1);    
    //update table DOM
    updateTableDOM(arr, 'establishment', true,'establishments-form','onDeleteEstablishmentButtonClick(this)'); 
}

function onDeleteInstitutionButtonClick(button) {
    var index = Number(button.getAttribute('data-index'));
    var i=0;
    var arr = []; 
    var x; 
    $('.institution_type').each(function(){
        arr[i++] = $(this).val();
    });
    //remove from array.
    arr.splice(index, 1);    
    //update table DOM
    updateTableDOM(arr, 'institution_type', true, 'institution-form','onDeleteInstitutionButtonClick(this)'); 
}

function onDeleteLanguageButtonClick(button) {
    var index = Number(button.getAttribute('data-index'));
    var i=0;
    var arr = []; 
    var x; 
    $('.languages').each(function(){
        arr[i++] = $(this).val();
    });
    //remove from array.
    arr.splice(index, 1);    
    //update table DOM
    updateTableDOM(arr, 'languages', true, 'language-form','onDeleteLanguageButtonClick(this)'); 
}


function onDeleteIntakeButtonClick(button) {
    var index = Number(button.getAttribute('data-index'));
    var i=0;
    var arr = []; 
    var x; 
    $('.intake').each(function(){
        arr[i++] = $(this).val();
    });
    //remove from array.
    arr.splice(index, 1);    
    //update table DOM
    updateTableDOM(arr, 'intake', true, 'intake-form','onDeleteIntakeButtonClick(this)'); 
}
function onDeleteDurationTypeButtonClick(button) {
    var index = Number(button.getAttribute('data-index'));
    var i=0;
    var arr = []; 
    var x; 
    $('.duration_type').each(function(){
        arr[i++] = $(this).val();
    });
    //remove from array.
    arr.splice(index, 1);    
    //update table DOM
    updateTableDOM(arr, 'duration_type', true, 'duration_type-form','onDeleteDurationTypeButtonClick(this)'); 
}

function onDeleteEventTypeButtonClick(button) {
    var index = Number(button.getAttribute('data-index'));
    var i=0;
    var arr = []; 
    var x; 
    $('.event_type').each(function(){
        arr[i++] = $(this).val();
    });
    //remove from array.
    arr.splice(index, 1);    
    //update table DOM
    updateTableDOM(arr, 'event_type', true, 'event_type-form','onDeleteEventTypeButtonClick(this)'); 
}



function updateTableDOM(arr, id, editable,form,deleteButton) {
    var table = document.getElementById(form);
    //remove all rows
    var i = table.children[0].children.length - 1;
    while(table.children[0].children.length != 1) {
        table.deleteRow(i--);
    }

    //add rows as per arr
    for(var i = 0; i < arr.length; i++) {
        var row = table.insertRow();                

        if (editable) {
            var cell0 = row.insertCell(0);
            var cell1 = row.insertCell(1);
          
            cell0.innerHTML = '<input class="'+id+'" id="test-' + i + '" value="' + arr[i] + '"/>';
            cell1.innerHTML = '<button data-index="' + i + '" class="btn btn-danger" onclick="'+deleteButton+'"><span class="glyphicon glyphicon-minus"></span></button>';
        } else {
            var cell0 = row.insertCell(0);        
            cell0.innerHTML = arr[i];       
        }                  
        
    }
}
function onAddClick(list, form, deleteButton) {  
    var table = document.getElementById(form);
    var i = table.children[0].children.length - 1;
    var row = table.insertRow();
    var cell0 = row.insertCell(0);  
    var cell1 = row.insertCell(1);   

    cell0.innerHTML = '<input class = '+ list +' name="test-' + i + '" value=""/>';
    cell1.innerHTML = '<button data-index="' + i + '" class="btn btn-danger" onclick="'+deleteButton+'"><span class="glyphicon glyphicon-minus"></span></button>';   
   
}

function onSaveChangesClick(e) {  
    var i=0;
    var arr = [];
    var x;  
    $("."+e).each(function(){
        arr[i++] = $(this).val();
    }); 
    var url = 'http://localhost/gotouniversity/backend/web/index.php?r=others/save-changes&arr='+arr+'&list='+e;
    console.log(url);
    $.ajax({ 
        type : 'POST',
        url: url,
        success: function (data) {

          alert('Changes Saved'); 
           location.reload(); 
        },
    });
    return false;    
}
