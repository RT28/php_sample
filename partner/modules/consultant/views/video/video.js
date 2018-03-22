var session;
function initVideo() {
    var apiKey = $('#open-tok-api-key').val();
    var sessionId = $('#open-tok-session-id').val();
    var token = $('#open-tok-token').val();

    if (validateOpenTokRequirements(apiKey, sessionId, token)) {
      var current_page = $('#current_page').val();
      if(current_page == 'video'){
        session = OT.initSession(apiKey, sessionId)
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

  // Receive a message and append it to the history
  /*var msgHistory = document.querySelector('#history');
  session.on('signal:msg', function(event) {
    var msg = document.createElement('p');
    msg.textContent = event.data;
    msg.className = event.from.connectionId === session.connection.connectionId ? 'mine' : 'theirs';
    msgHistory.appendChild(msg);
    msg.scrollIntoView();
  });
}*/
var msgHistory = document.querySelector('#history');
  session.on('signal:msg', function(event) {
    //var msg = document.createElement('p');
    //msg.textContent = event.data;
    var sender = event.from.connectionId === session.connection.connectionId ? 'mine' : 'theirs';
    var imgSrc = $('#target_logo').attr('src');
    var partner_login_id = $('#partner_login_id').val();
    var imgSrc_partner = $('#partner_img_'+partner_login_id).attr('src');
    if(sender=='mine'){
    $("#history").append("<div class='msg-tile users-msg'><p class='users-msg-text'>"+event.data+"</p><div class='users-img'><img src="+imgSrc+"></div></div>");
    } else if(sender=='theirs'){
    $("#history").append("<div class='msg-tile consultants-msg'><div class='consultants-img'><img src="+imgSrc_partner+"></div><p class='consultants-msg-text'>"+event.data+"</p></div>");  
    }
    //msgHistory.append("<div class='msg-tile users-msg'>"+event.data+"</div>");
    //msg.scrollIntoView();
  });
}
// Text chat
var form = document.querySelector('#chatform');
var msgTxt = document.querySelector('#msgTxt');

// Send a signal once the user enters data in the form
form.addEventListener('submit', function(event) {
  event.preventDefault();

  session.signal({
      type: 'msg',
      data: msgTxt.value
    }, function(error) {
      if (error) {
        console.log('Error sending signal:', error.name, error.message);
      } else {
        funSavechat(msgTxt.value);
        msgTxt.value = '';

      }
    });
});

function funSavechat(message){
  var partner_login_id = $('#partner_login_id').val();
$.ajax({
            url: '?r=consultant/video/savechat',
            method: 'POST',
            data: { message : message , partner_login_id : partner_login_id},
            dataType:'html',
            success: function(data) {
                $('.no-message').hide();
                console.log(success);
            },
            error: function(error) {
                console.log(error);
            }
        }); 
}

