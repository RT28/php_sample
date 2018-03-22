var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var mysql = require('mysql');
var users = {};
var map = {};
var connections = {};
var notifications = require('./notifications');

app.get('/', function(req, res){
    res.sendFile(__dirname + '/index.html');
});

app.use('/notifications', notifications);

var conn = false;

var connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'gotouniv_db'
});

connection.connect(function(err){
    if (err) {
        throw err;
    } else {
        conn = true;
    }
});

io.on('connection', function(socket){
    socket.on('register', function(msg){
        var details = JSON.parse(msg);
        var key = details.from_id + '_' + details.from_role;
        users[key] = socket;
        map[socket.id] = key;

        //send last 10 chat messages;
        if(conn) {
            var query = 'SELECT * FROM `chat` where (from_id=' + details.from_id + ' AND from_type=' + details.from_role + ') OR (to_type=' + details.from_role + ' AND to_id=' + details.from_id + ') AND is_read=0 ORDER BY time_stamp DESC LIMIT 10';            
            connection.query(query, function(err, rows){
                if (err) {
                    console.error(err);
                } else {
                    socket.emit('chat history', JSON.stringify(rows));
                }
            });
        }
    });

    socket.on('get chat history', function(msg){
        var details = JSON.parse(msg);
        var key = details.from_id + '_' + details.from_role;
        users[key] = socket;
        map[socket.id] = key;     

        //send last 10 chat messages;
        if(conn) {
            var query = 'SELECT * FROM `chat` where (from_id=' + details.from_id + ' AND from_type=' + details.from_role + ' AND to_id=' + details.to_id + ' AND to_type=' + details.to_role + ') OR (to_type=' + details.from_role + ' AND to_id=' + details.from_id + ' AND from_id= ' + details.to_id + ' AND from_type=' + details.to_role + ') AND is_read=0 ORDER BY time_stamp DESC LIMIT 10';                                        
            connection.query(query, function(err, rows){
                if (err) {
                    console.error(err);
                } else {
                    socket.emit('chat history', JSON.stringify(rows));                
                }
            });
        }
    });

    socket.on('disconnect', function(){
        var key = map[socket.id];
        
        //multicast to connected users;
        if(key) {
            var temp = connections[key];
            if(temp) {
                for(var i = 0; i < temp.length; i++) {                
                    if(users[temp[i]]) {
                        var sock = users[temp[i]];
                        sock.emit('user offline', key);
                    }
                }    
            }
            //delete from active users map;
            delete map[socket.id];
            delete users[key];
        }        
    });

    socket.on('chat message', function(msg){
        var msg = JSON.parse(msg);
        if(conn) {
            connection.query("INSERT INTO chat(from_id, from_type, to_id, to_type, message, time_stamp) VALUES(?, ?, ?, ?, ?, ?)",[msg.from_id, msg.from_role, msg.to_id, msg.to_role, msg.message, new Date()], function(error, res){
                if (error) {
                    console.error(error);
                } else {
                    var key = msg.to_id + '_' + msg.to_role;
                    if(users.hasOwnProperty(key)) {
                        var sock = users[key];
                        sock.emit('chat message', JSON.stringify(msg));
                    }                                     
                }
            });
        }     
    });

    socket.on('active users', function(message){                     
        var details = JSON.parse(message);
        var key = details.from_id + '_' + details.from_role;
        let participants = [];
        connections[key] = details.to_ids;        
        for(let i = 0; i < details.to_ids.length; i++) {
            let user = details.to_ids[i];
            if (users[user]) {
                participants.push(user);
            }
        }
        socket.emit('active users', JSON.stringify(participants));

        var temp = details.to_ids;
        if(temp) {
            for(var i = 0; i < temp.length; i++) {
                if(users[temp[i]]) {
                    var sock = users[temp[i]];
                    sock.emit('user online', key);
                }
            }    
        }
    });

    socket.on('get student notifications', function(data){
        var data  = JSON.parse(data);
        var id = data.id;
        if(conn) {
            var query = 'SELECT * FROM `student_notifications` WHERE student_id=' + id;
            connection.query(query, function(err, rows){
                if (err) {
                    console.error(err);
                } else {
                    socket.emit('set student notifications', JSON.stringify(rows));
                }
            });
        }
    });

    socket.on('get srm notifications', function(data){
        var data  = JSON.parse(data);
        var id = data.id;
        if(conn) {
            var query = 'SELECT * FROM `srm_notifications` WHERE srm_id=' + id;
            connection.query(query, function(err, rows){
                if (err) {
                    console.error(err);
                } else {
                    socket.emit('set srm notifications', JSON.stringify(rows));
                }
            });
        }
    });

    socket.on('get consultant notifications', function(data){
        var data  = JSON.parse(data);
        var id = data.id;
        if(conn) {
            var query = 'SELECT * FROM `consultant_notifications` WHERE consultant_id=' + id;
            connection.query(query, function(err, rows){
                if (err) {
                    console.error(err);
                } else {
                    socket.emit('set consultant notifications', JSON.stringify(rows));
                }
            });
        }
    });

    socket.on('get university notifications', function(data){
        var data  = JSON.parse(data);
        var id = data.id;
        if(conn) {
            var query = 'SELECT * FROM `university_notifications` WHERE university_id=' + id;
            connection.query(query, function(err, rows){
                if (err) {
                    console.error(err);
                } else {
                    socket.emit('set university notifications', JSON.stringify(rows));
                }
            });
        }
    });
});

http.listen(3000, function(){
    console.log('listening on port *:3000');
});

module.exports = {
    map: map,
    users: users,
    connections: connections,
    io: io
}