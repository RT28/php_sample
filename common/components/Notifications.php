<?php
    namespace common\components;

    class Notifications {

         public static function sendNotification($data) {
            $postData = http_build_query($data);
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,'http://localhost:3000/notifications/send');
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch,CURLOPT_HEADER, false); 
            curl_setopt($ch, CURLOPT_POST, count($postData));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    

            $output=curl_exec($ch);

            curl_close($ch);
            return $output;
        }
    }
?>