$("#history").scrollTop($("#history")[0].scrollHeight);
var session;

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

  // Connect to the session
  session.connect(token, function(error) {
  });

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
    $("#history").scrollTop($("#history")[0].scrollHeight);

    //msgHistory.append("<div class='msg-tile users-msg'>"+event.data+"</div>");
    //msg.scrollIntoView();
  });
}
// Text chat
var form = document.querySelector('#formChat');
var msgTxt = document.querySelector('#msgTxt');

// Send a signal once the user enters data in the form
form.addEventListener('submit', function(event) {
  event.preventDefault();
  if(msgTxt.value){
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
  }
});

    $(document).ready(function(){
      initializeSession();
    });

function funSavechat(message){
  var partner_login_id = $('#partner_login_id').val();
$.ajax({
            url: 'savechat',
            method: 'POST',
            data: { message : message , partner_login_id : partner_login_id},
            dataType:'html',
            success: function(data) {
                $('.no-message').hide();
                $('#chat_pop').html('2 message');
                //console.log(success);
            },
            error: function(error) {
                console.log(error);
            }
        }); 
}