var express = require('express');
var router = express.Router();
var io = require('./index').io;

router.get('/', function(req, res, next){
    res.send({
        'status': 'success',
        'message': 'Success'
    });
});

router.post('/send', function(req, res, next){
    console.log(io);
    res.send({
        'status': 'success',
        'message': 'Success'
    });
});

module.exports = router;