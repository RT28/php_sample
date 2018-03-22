<?php

namespace common\components;

class ConnectionSettings {
    const BASE_URL = 'https://www.gotouniversity.com/'; 
    const ASW_URL = 'https://s3.ap-south-1.amazonaws.com/gotouniv/';
    //const BASE_URL = 'http://gotouniversity.com/';
    const OPEN_TOK_API_KEY = '46055072';
    const OPEN_TOK_API_SECRET = '2163c1dd293a982c4c12ce6785c17673c638e353';
}
if (!(isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || 
   $_SERVER['HTTPS'] == 1) ||  
   isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&   
   $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'))
{
   $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
   header('HTTP/1.1 301 Moved Permanently');
   header('Location: ' . $redirect);
   exit();
}
?>