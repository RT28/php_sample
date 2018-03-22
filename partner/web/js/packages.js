function changePackageLimit() {
    var button = $(this);
    var id = button.attr('data-id');
    var input = button.siblings('input');
    var errorContainer = $('.error-container');
    errorContainer.addClass('hidden');
    if (input.length > 0) {
        var value = input.val();
        $.ajax({
            url: '?r=consultant/students/change-package-limt',
            method: 'POST',
            data: {
                id: id,
                value: value,
            },
            error: function(err) {
                errorContainer.removeClass('hidden');
                errorContainer.html('Error connecting to server.');
            },
            success: function(responseText, xhr) {
                var response;
                try {
                    response = JSON.parse(responseText);
                } catch(e) {
                    errorContainer.removeClass('hidden');
                    errorContainer.html('Error connecting to server.');
                }
                if (response.status === 'success') {
                    window.location.reload();
                } else {
                    errorContainer.removeClass('hidden');
                    errorContainer.html(response.message);
                }
            }
        })
    }
}