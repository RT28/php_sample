function updateCourses(element) {        
    var degree = element.value;
    if (degree !== null && degree !== undefined && degree !== "") {
        $.ajax({
            url: '/gotouniversity/backend/web/index.php?r=university/dependent-majors',
            method: 'POST',
            data: {
                'degree': degree,
            },
            success: function(response) {
                response = JSON.parse(response);
                if(response.status == "success") {
                    var row = element.id.split('-')[1];
                    var select = $('#universitycourselist-' + row + '-major_id');
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

window.onload = function(){
    $('.btn-upload').click(onBtnUploadClick);
}

function onBtnUploadClick(e) {
    var file = $('#programs-list-csv')[0].files[0];
    if (file) {
        $.ajax({
            url: '/gotouniversity/backend/web/index.php?r=university/upload-multiple-programmes',
            method: 'POST',
            data: new FormData().append('file', file),
            processData: false,
            contentType: false,
            dataType: 'json',         
            success: function(response) {
                alert('success');
            },
            error: function(error) {
                alert('An error occured. Please contact administrator');
                console.error(error);
            }
        })
    }
}