$(document).ready(function(){
    // consultant index page.
    if($('.consultant-index').length > 0) {
        $('body').click(onBodyClick);
    }

    // consultant view page.
    if($('.consultant-view').length > 0) {
        $('body').click(onBodyClick);
    }

    if(typeof initVideo !== 'undefined') {
        initVideo();
    }
    if(establishSockets !== 'undefined') {
        establishSockets();
    }
});

function loadPreviewInfoOfPartner(universityId) {
	 var params = {};
	 params['university_id']=universityId;
    $('#partnerPagePreview').load('http://localhost/gotouniversity/frontend/web/index.php?r=university/preview', params, function(responseText, status, xhr){
        if(status !== 'success') {
            // TODO error handling.
        }
    });
}