$(document).ready(function(){
    $('.action-buttons').click(function(e){        
        var button = $('#btn-ok');
        button.attr('data-action', $(this).html());
        button.attr('data-model', $(this).attr('data-model'));
        button.attr('data-state', $(this).attr('data-state'));
    });
    $('#btn-ok').click(function(e){
        $.ajax({
            url: '/gotouniversity/backend/web/index.php?r=university-applications/update-state',
            method: 'POST',
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                return myXhr;
            },
            success: function (data) {
                var response = JSON.parse(data);
                if(response.status == 'success') {
                    window.location.reload();
                } else {
                    if(response.code == 100) {
                        alert(response.message);
                        window.location.reload();    
                    }
                    alert(response.message);
                }
            },
            data: {
                'action': $(this).attr('data-action'),
                'id': $(this).attr('data-model'),
                'status': $(this).attr('data-state'),
                'remarks': $('#txt-remarks').val()
            },
            cache: false,
        });
        return false; 
    });
});
