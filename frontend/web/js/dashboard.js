/**
 * Dashboard JS
 */
function removeFromShortlist() {
    var id = $(this).attr('data-id');

    $.ajax({
        url: '/student/remove-from-shortlist',
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

function applyToCourseClick() {
    var button = $(this);
    var text = $(button).html();
    var course = $(button).attr('data-course-id');
    var university = $(button).attr('data-university-id');

    if(text === 'Apply') {
        if ($('#free-application-package').length > 0) {
            $('#apply-warning').modal('show');
            return false;
        } else {
            /*$('#course-application').modal('show');
            $('#course-application .modal-body').load('?r=student/get-application-fees', { course: course, university: university}, function(responseText, status, success){

            });*/

            $.ajax({
                url: '/university-applications/create',
                method: 'POST',
                data: {
                    course: course,
                    university: university,
                    term: 'Fall 2017'
                },
                error: function(error) {
                    alert('Error processing request');
                },
                success: function(responseText) {
                    var response;
                    try {
                        response = JSON.parse(responseText);
                    } catch(e) {
                        alert('Error processing response');
                    }
                    if (response.status === 'success') {
                        window.location = '/student/dashboard';
                    } else {
                        alert('Error processing response');
                    }
                }
            })
        }        
    }
}