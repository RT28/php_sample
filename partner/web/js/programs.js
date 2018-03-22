function updateCourses(element) {        
    var degree = element.value;
    if (degree !== null && degree !== undefined && degree !== "") {
        $.ajax({
            url: '/gotouniversity/partner/web/index.php?r=university/program/dependent-majors',
            method: 'POST',
            data: {
                'degree': degree,
            },
            success: function(response) {
                response = JSON.parse(response);
                if(response.status == "success") { 
                    var select = $('#major_id');
                    select.empty();
                    var data = response.result;
					alert(data.length);
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