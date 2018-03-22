window.setInterval(function(){
  fnGetloggedUser();
  fnGetchatnotify();
  //fnGetcallnotify();
}, 5000);
function fnGetloggedUser() {
    $.ajax({
            url: '?r=consultant/consultant/getchatcount',
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
function fnGetchatnotify() {
    $.ajax({
            url: '?r=consultant/consultant/chatnotification',
            method: 'POST',
            dataType:'json',
            success: function(response) { 
                $.each(response['student_chats'],function(i,v){
                  if($('#box_chatpop'+v[0]).length!==1){
                  $("#wrapper-content").prepend("<div class='box' id='box_chatpop"+v[0]+"'><div class='box-inner'>New message from "+v[1]+"<button class='close_chatnf' id='"+v[0]+"' onclick='fn_closechat("+v[0]+");'>Cancel</button><a href='index.php?r=consultant/video/chat&id="+v[2]+"'><button>Open</button></a></div></div>");
                  $('#box_videopop'+v[0]).animate({left: '250px'});
                  }
                  });
                $.each(response['student_calls'],function(i,v){
                  if($('#box_callpop'+v[0]).length!==1){
                  $("#wrapper-content").prepend("<div class='box' id='box_callpop"+v[0]+"'><div class='box-inner'>"+v[1]+" calling....<button class='close_callnf' id='"+v[0]+"' onclick='fn_closevideo("+v[0]+");'>Decline</button><a href='index.php?r=consultant/video/videocall&id="+v[2]+"'><button>Accept</button></a></div></div>");
                  $('#box_videopop'+v[0]).animate({left: '250px'});
                  }
                  });
            },
            error: function(error) {
                console.log(error);
            }
        }); 
}
function fn_closechat(id){ 
  $('#box_chatpop'+id).remove();
}
function fn_closevideo(id){ 
  $('#box_callpop'+id).remove();
}

function fnGetcallnotify() {
    $.ajax({
            url: 'getcallnotify',
            method: 'POST',
            dataType:'json',
            success: function(response) { 
                
                  $.each(response['student_calls'],function(i,v){
                  if($('#box_videopop'+v[0]).length!==1){
                  $("#wrapper-content").prepend("<div class='box' id='box_videopop"+v[0]+"'><div class='box-inner'>"+v[1]+" calling..<br><button onclick='fnChange_notify(2)'>Accept</button><button onclick='fnChange_notify(1)'>Decline</button></div></dvi>");
                  $('#box_videopop'+v[0]).animate({left: '250px'})
                  }
                  });

            },
            error: function(error) {
                console.log(error);
            }
        }); 
}
