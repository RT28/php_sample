var socket = io('http://localhost:3000');
function establishSockets (){    
    $('.chat-unit').click(onChatUnitClick);
    registerUser(socket);
    getActiveChatUsers(socket);
    getNotifications(socket);
    $('.send-btn').on('click', submitMessage);

    socket.on('chat message', onMessageReceived);
    socket.on('chat history', getChatHistory);
    socket.on('active users', setActiveUsers);
    socket.on('user offline', onUserStatusOnline);
    socket.on('user online', onUserStatusOffline);
    socket.on('set student notifications', setNotifications);
}

function registerUser(socket) {
    socket.emit('register', JSON.stringify({
        from_id: $('#from_id').val(),
        from_role: $('#from_role').val()
    }));
}

function getActiveChatUsers(socket) {
    socket.emit('active users', JSON.stringify({
        from_id: $('#from_id').val(),
        from_role: $('#from_role').val(),
        to_ids: [$('#to_id').val() + '_' + $('#to_role').val()]
    }));
}

function getNotifications(socket) {
    socket.emit('get student notifications', JSON.stringify({
        id: $('#from_id').val()
    }));
}

function submitMessage(id, role){
    var msg =document.getElementById('message-' + id + '-' + role).value;
    if(msg && msg.length > 0) {
        var message = {
            message: msg,
            from_id: $('#from_id').val(),
            from_role: $('#from_role').val(),
            to_id: id,
            to_role: role,
        }
        socket.emit('chat message', JSON.stringify(message));
        document.getElementById('message-' + id + '-' + role).value = '';
        $('#chat-' + id + '-' + role + ' .chat-body').append("<div class=\"sent-message\">"+msg+"</div>");
    }
    return false;
}

function onMessageReceived(msg) {
    msg = JSON.parse(msg);
    from_id = msg.from_id;
    from_role = msg.from_role;
    $('#chat-' + from_id + '-' + from_role + ' .chat-body').append("<div class=\"received-message\">"+msg.message+"</div>");
}

function getChatHistory(msg){
    msg = JSON.parse(msg);
    var me = $('#from_id').val();
    for(var i = msg.length - 1; i >= 0; i--) {
        if(msg[i].from_id == me) {
            $('.chat-body').append("<div class=\"sent-message\">"+msg[i].message+"</div>");
        } else {
            $('.chat-body').append("<div class=\"received-message\">"+msg[i].message+"</div>");
        }
    }
}

function setActiveUsers(users){
    users = JSON.parse(users); 
    if(users[0] == $('#to_id').val() + '_' + $('#to_role').val()) {
        $('.user-status').addClass('user-online');
    } else {
        $('.user-status').removeClass('user-online');
    }
}

function onUserStatusOnline(user){
	
    if(user == $('#to_id').val() + '_' + $('#to_role').val()) {
        $('.user-status').removeClass('user-online');
    }
}

function onUserStatusOffline(user){
    if(user == $('#to_id').val() + '_' + $('#to_role').val()) {
        $('.user-status').addClass('user-online');
    }
}

function setNotifications(data){
    var data = JSON.parse(data);
    var container = $('#notifications-panel');
    for(var i = 0; i < data.length; i++) {
        var message = JSON.parse(data[i].message);
        var content = message.message;
        if (message.link != null) {
            content = '<a href="' + message.link + '">' + message.message + '</a>';
        }
        var time = moment.utc(data[i].timestamp);
        if (time) {
            time = moment(time).local().format('D MMM, H:m');
        }

        var str = '<div class="noti-unit"><div class="noti-time"> ' + time + ' </div><div class="noti-content">' + content +'</div></div>';
        container.append(str);
    }
    $('.noti-count').html(data.length);
}

function onChatUnitClick() {
    var src = $(this).find('img').attr('src');
    var to = $(this).attr('data-to').split('-');
    var id = to[0];
    var role = to[1];
    var name = $(this).find('.chat-name').html();
    var isOnline = $(this).find('.chat-status').hasClass('online');
    if($('#chat-' + id + '-' + role).length > 0) {
        return;
    }
    var dom = getChatWindowHtml(id, name, role, isOnline, src);
    $('.chat-parent').append(dom);
    $('#btn-chat-close-' + id).on('click', onBtnChatCloseClick);
    socket.emit('get chat history', JSON.stringify({
        from_id: $('#from_id').val(),
        from_role: $('#from_role').val(),
        to_id: id,
        to_role: role
    }));
}

function getChatWindowHtml(toId, toName, toRole, isOnline, src) {
    var userStatus = isOnline === true ? 'user-online' : '';
    
	return '' + 
	'<div class="chat-window panel panel-default" id="chat-' + toId + '-' + toRole + '">' + 
	'<div class="chat-window-inner">' +
	'<div class="panel-heading panel-heading-chat-title" data-studentid="' + toId + '">'  + 
		'<img src="' + src +'" alt="' + toName +'" class="chat-title-image"/>' +
		toName  +
		'<span id="user-status-window' + toId + '" class="user-status ' + userStatus + '"></span>' + 
		'<a class="btn btn-link btn-chat-close" onclick="onBtnChatCloseClick(\'' + 'chat-' + toId + '-' + toRole + '\')"><span class="fa fa-close"></span></a>' +
	'</div>' + 
	'<div id="chat-container' + toId + '" class="chat-container">' +
	'<div class="panel-body chat-body" id="chat-body'+ toId + '-' + toRole + '"></div>' +
	'<div class="panel-footer">' + 
		'<div class="row" style="position: relative;">' +
			'<input type="text" class="form-control message-input" name="message" id="message-'+ toId +'-' + toRole + '" placeholder="Message" />' + 
			'<button type="button" class="chat-send" data-to-id="'+ toId +'" onclick="submitMessage(' + toId +',' + toRole + ')"><span class="fa fa-paper-plane"></span></button>' +
		'</div></div>' +
	'<input type="hidden" name="to_id" id="to_id'+ toId +'" value="' + toId +  '"/>'+ 
	'<input type="hidden" name="to_role" id="to_role'+ toRole +'" value="' + toRole + '"/>' +
	'</div>' +        
	'</div>' +
	'</div>';
}

function onBtnChatCloseClick(id) {    
    var chatContainer = $('#' + id);
    $(chatContainer).remove();
}