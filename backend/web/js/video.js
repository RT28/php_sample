function initVideo() {
    var apiKey = $('#open-tok-api-key').val();
    var sessionId = $('#open-tok-session-id').val();
    var token = $('#open-tok-token').val();

    if (validateOpenTokRequirements(apiKey, sessionId, token)) {
        var session = OT.initSession(apiKey, sessionId)
        .on('streamCreated', function(event) {
            var options = {insertMode: 'append'}
            session.subscribe(event.stream, 'subscribe', options);
        })
        .connect(token, function(error) {
            var publisherOptions = {
                insertMode: 'append'
            };
            var publisher = OT.initPublisher('publish', publisherOptions);
            session.publish(publisher);
        });
    }
}

function validateOpenTokRequirements(apiKey, sessionId, sessionToken) {
    var errorContainer = $('.error-container');
    if(apiKey === '' || apiKey === null || apiKey === undefined) {
        errorContainer.removeClass('hidden');
        errorContainer.html('Open Tok API Key not found! Please contact administrator');
        return false;
    }
    if(sessionId === '' || sessionId === null || sessionId === undefined) {
        errorContainer.removeClass('hidden');
        errorContainer.html('Open Tok Session Id not found! Please contact administrator');
        return false;
    }
    if(sessionToken === '' || sessionToken === null || sessionToken === undefined) {
        errorContainer.removeClass('hidden');
        errorContainer.html('Open Tok Session Token not found! Please contact administrator');
        return false;
    }
    return true;
}