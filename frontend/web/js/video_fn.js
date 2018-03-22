var session;
var apiKey = $('#open-tok-api-key').val();
var sessionId = $('#open-tok-session-id').val();
var token = $('#open-tok-token').val();
var publisher;
function initVideocall() {
    if (validateOpenTokRequirements(apiKey, sessionId, token)) {
        session = OT.initSession(apiKey, sessionId)
        .on('streamCreated', function(event) {
            var options = {insertMode: 'append'}
            session.subscribe(event.stream, 'subscribe', options);
        })
        .connect(token, function(error) {
            var publisherOptions = {
                insertMode: 'append'
            };
            publisher = OT.initPublisher('publish', publisherOptions);
            session.publish(publisher);
        });
    }
    //initializeSession();
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

function publish(){
  var publisherOptions = {
          insertMode: 'append',
          publishVideo:true
      };
      publisher=  OT.initPublisher("publish",publisherOptions, function (error) {
      if (error) {
      console.log(error);
      } else {
      console.log("Publisher initialized.");
      }
      });
      session.publish(publisher,function(error){  if(error){
      console.log("error:"+error.message);
      }
      else{
          console.log("no error");
          eventHandling();
      }});
}
  
  $('.audiobtn').click(function(){
    if($(this).hasClass('mute')){
      publisher.publishAudio(true);
      $(this).removeClass('mute');
    }else{
      publisher.publishAudio(false);
      $(this).addClass('mute');
    }
  });
  
  $('.videobtn').click(function(){
    if($(this).hasClass('off')){
      publisher.publishVideo(true);
      $(this).removeClass('off');
    }else{
      publisher.publishVideo(false);
      $(this).addClass('off');
    }
  });

function unpublish(){
    session.unpublish(publisher);
}

function endCall(){
  session.disconnect();
  window.location.assign('/video/chat');
}

function check(){
console.log("testing");
    OT.checkScreenSharingCapability(function(response){
    console.log(response.supported);
        console.log(response.extensionRegistered);
        
        if(!response.supported || response.extensionRegistered===false){
    console.log("one");
        }
        else if(response.extensionInstalled ===false){
        console.log ("two");
        }
        else{
    
            publisher= OT.initPublisher("publish",{videoSource:"screen"}, function (error) {
            if (error) {
            console.log(error);
            } else {
            console.log("Publisher initialized.");
            }
            });         
            session.publish(publisher,function(error){
            if(error){
            console.log("error:"+error.message);
            }
                else{
                    console.log("no error");
                    eventHandling();
                }
            });
        }
        });
}

function eventHandling(){
    publisher.on("streamCreated",function(){
     var newOptions = {
      publishAudio: true, videoSource: null, width: '100%', height: '100%'
    };
    }
    );
   
  publisher.on('streamDestroyed', function (event) {
    if(event.reason==='unpublished' && event.stream.videoType === 'camera'){
    event.preventDefault();
        check();
        
    }else if(event.reason==='unpublished' && event.stream.videoType === 'screen'){
    event.preventDefault();
        //publish();
    }
});
}

function resizePublisher() {
  var publisherContainer = document.getElementById("subscribe");
  publisherContainer.style.width = "100%";
  publisherContainer.style.height = "100%";
  publisherContainer.style.position = "fixed";
  publisherContainer.style.left = "0px";
  publisherContainer.style.top = "0px";
  publisherContainer.style.overflow = "hidden";
}        

    OT.registerScreenSharingExtension('chrome', 'kjchpkhooaknjklhfodjcooaafnpinbc', 2);

    function screenshare() {
      OT.checkScreenSharingCapability(function(response) {
        if (!response.supported || response.extensionRegistered === false) {
          alert('This browser does not support screen sharing.');
        } else if (response.extensionInstalled === false) {
          alert('Please install the screen sharing extension and load your app over https.');
        } else {
          // Screen sharing is available. Publish the screen.
          var screenSharingPublisher = OT.initPublisher('screen-preview', {videoSource: 'screen'});
          session.publish(screenSharingPublisher, function(error) {
            if (error) {
              alert('Could not share the screen: ' + error.message);
            }
          });
        }
      });
    }
    $(document).ready(function(){
      initVideocall();
    });
      
