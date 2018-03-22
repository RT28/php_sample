var session;
function initVideo() {
    var apiKey = $('#open-tok-api-key').val();
    var sessionId = $('#open-tok-session-id').val();
    var token = $('#open-tok-token').val();

    if (validateOpenTokRequirements(apiKey, sessionId, token)) {
        session = OT.initSession(apiKey, sessionId)
        .on('streamCreated', function(event) {
            var options = {insertMode: 'append'}
            session.subscribe(event.stream, 'subscribe', options);
        })
        .connect(token, function(error) {
            var publisherOptions = {
                insertMode: 'append',publishVideo:false,videoSource: null
            };
            var publisher = OT.initPublisher('publish', publisherOptions);
            session.publish(publisher);
        });
    }
    initializeSession();
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

    var apiKey = $('#open-tok-api-key').val();
    var sessionId = $('#open-tok-session-id').val();
    var token = $('#open-tok-token').val();

function initializeSession() {
  session = OT.initSession(apiKey, sessionId);

  // Subscribe to a newly created stream
  session.on('streamCreated', function(event) {
    var subscriberOptions = {
      insertMode: 'append',
      width: '100%',
      height: '100%'
    };
    session.subscribe(event.stream, 'subscriber', subscriberOptions, function(error) {
      if (error) {
        console.log('There was an error publishing: ', error.name, error.message);
      }
    });
  });

  session.on('sessionDisconnected', function(event) {
    console.log('You were disconnected from the session.', event.reason);
  });

  // Connect to the session
  session.connect(token, function(error) {
    // If the connection is successful, initialize a publisher and publish to the session
    if (!error) {
      var publisherOptions = {
        insertMode: 'append',
        width: '100%',
        height: '100%'
      };
      var publisher = OT.initPublisher('publisher', publisherOptions, function(error) {
        if (error) {
          console.log('There was an error initializing the publisher: ', error.name, error.message);
          return;
        }
        session.publish(publisher, function(error) {
          if (error) {
            console.log('There was an error publishing: ', error.name, error.message);
          }
        });
      });
    } else {
      console.log('There was an error connecting to the session: ', error.name, error.message);
    }
  });

}




