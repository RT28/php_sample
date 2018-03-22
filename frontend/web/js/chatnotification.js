window.setInterval(function(){
  fnGetlchatCount();
  fnGetchatnotify();
  fnGetcallnotify();
}, 5000);
function fnGetlchatCount() {
    $.ajax({
            url: '/student/getchatcount',
            method: 'POST',
            dataType:'json',
            success: function(response) { 
                if(response.unread_total=='null' || response.unread_total==0){
                    $('#m_count').text('');
                } else {
                   $('#m_count').text(response.unread_total); 
                }
            },
            error: function(error) {
                console.log(error);
            }
        }); 
}
var myFunction = function() {
  window.location = "https://gotouniversity.com/video/chat";
};
var myImg = "http://gotouniversity.com/images/logo.png";
function fnGetchatnotify() {
    $.ajax({
            url: '/student/chatnotification',
            method: 'POST',
            dataType:'json',
            success: function(response) { 
              $.each(response['student_chats'],function(i,v){
                  var options = {
                  title: '',
                  options: {
                    body: 'Message from '+v[1],
                    icon: '../partner/web/uploads/consultant/'+v[0]+'/profile_photo/consultant_image_228X228.jpeg',
                    lang: 'en-US',
                    onClick: myFunction
                  }
                };
                console.log(options);
                $("#easyNotify").easyNotify(options);
                
                $.notify({
                  // options
                  icon: '../partner/web/uploads/consultant/'+v[0]+'/profile_photo/consultant_image_228X228.jpeg',
                  title: v[1],
                  message: 'Sent you a message',
                  url: 'https://gotouniversity.com/video/chat?id='+v[2],
                  target: '_blank'
                },{
                  type: 'minimalist',
                  delay: 30000,
                  icon_type: 'image',
                  template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                    '<img data-notify="icon" class="img-circle pull-left">' +
                    '<span data-notify="title">{1}</span>' +
                    '<span data-notify="message">{2}</span>' +
                    '<a href="{3}" target="{4}" data-notify="url"></a>'+
                  '</div>'
                });

              });
            },
            error: function(error) {
                console.log(error);
            }
        }); 
}

var x = document.getElementById("myAudio"); 

function playAudio() { 
    x.play(); 
} 

function pauseAudio() { 
    x.pause(); 
} 

function fnGetcallnotify() {
    $.ajax({
            url: '/student/getcallnotify',
            method: 'POST',
            dataType:'json',
            success: function(response) { 
                
                  $.each(response['student_calls'],function(i,v){
                    playAudio();
                    $.notify({
                      // options
                      icon: '../partner/web/uploads/consultant/'+v[0]+'/profile_photo/consultant_image_228X228.jpeg',
                      title: v[1],
                      message: " is calling...",
                      url: '/video/videocall?id='+v[2]+'&q=video',
                      target: '_blank'
                    },{
                      // settings
                      element: 'body',
                      position: null,
                      type: "minimalist",
                      allow_dismiss: true,
                      newest_on_top: false,
                      showProgressbar: false,
                      placement: {
                        from: "top",
                        align: "right"
                      },
                      offset: 20,
                      spacing: 10,
                      z_index: 1031,
                      delay: 90000,
                      timer: 1000,
                      url_target: '_blank',
                      mouse_over: null,
                      animate: {
                        enter: 'animated fadeInDown',
                        exit: 'animated fadeOutUp'
                      },
                      onShow: null,
                      onShown: null,
                      onClose: null,
                      onClosed: null,
                      icon_type: 'image',
                      template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert" onClick="pauseAudio()">' +
                      '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                      '<img data-notify="icon" class="img-circle pull-left">' +
                      '<span data-notify="title">{1}</span>' +
                      '<span data-notify="message">{2}</span>' +
                      '<a href="{3}" target="{4}" data-notify="url"></a>'+
                      '</div>'
                      /*template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                        '<span data-notify="icon"></span> ' +
                        '<span data-notify="title">{1}</span> ' +
                        '<span data-notify="message">{2}</span>' +
                        //'<button type="button" onclick="fnChange_notify(2)">Accept</button><button type="button" onclick="fnChange_notify(1)">Decline</button>'+
                        '<div class="progress" data-notify="progressbar">' +
                          '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                        '</div>' +
                        '<a href="{3}" target="{4}" data-notify="url">Accept</a>' +
                      '</div>' */
                    });
                  });

            },
            error: function(error) {
                console.log(error);
            }
        }); 
}