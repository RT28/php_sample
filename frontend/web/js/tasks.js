function updateCourses(element) {        
    var category = element.value;
    if (category !== null && category !== undefined && category !== "") {
        $.ajax({
            url: '/tasks/list',
            method: 'POST',
            data: {
                'task_category_id': category,
            },
            success: function(response) {
                response = JSON.parse(response);
                if(response.status == "success") {
                    var row = element.id.split('-')[1];
                    var select = $('#studentask-' + row + '-task_list_id');
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

 
 