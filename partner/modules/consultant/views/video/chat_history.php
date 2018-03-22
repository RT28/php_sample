<?php 
if(!empty($chatHistory)){
foreach($chatHistory as $history){ ?>
<div id="videos" style="display: none;">
    <div class="col-xs-12" id="subscribe"></div>
    <div class="col-xs-3" id="publish"></div>
</div>

    <?php if($history['sender_id']==$history['partner_login_id']){ ?>
    <div class="msg-tile consultants-msg">
        <div class="consultants-img">
            <?php
            $profile_path = "./../../partner/web/uploads/consultant/".$history['partner_login_id']."/profile_photo/consultant_image_228X228";
            if(glob($profile_path.'.jpg')){
              $src = $profile_path.'.jpg';
            } else if(glob($profile_path.'.png')){
              $src = $profile_path.'.png';
            } else if(glob($profile_path.'.gif')){
              $src = $profile_path.'.gif';
            } else if(glob($profile_path.'.jpeg')){
              $src = $profile_path.'.jpeg';
            } else if(glob($profile_path.'.JPG')){
              $src = $profile_path.'.JPG';
            } else if(glob($profile_path.'.PNG')){
              $src = $profile_path.'.PNG';
            } else if(glob($profile_path.'.GIF')){
              $src = $profile_path.'.GIF';
            } else if(glob($profile_path.'.JPEG')){
              $src = $profile_path.'.JPEG';
            }

            else {
                $src = './../../partner/web/noprofile.gif';
            }
        ?>
            <img src="<?= $src; ?>"/>
        </div>
            <p class="consultants-msg-text"><?= $history['message']; ?></p>
    </div>
    <?php } else if($history['sender_id']==$history['student_id']){ ?>
    <div class="msg-tile consultants-msg">
        
        <div class="consultants-img">
            <?php
            $cover_photo_path = [];
            $src = './noprofile.gif';
            $is_profile = 0;
            if(is_dir('./../web/uploads/' . $history['student_id'] . '/profile_photo')) {
                $cover_photo_path = "./../web/uploads/".$history['student_id']."/profile_photo/logo_170X115";
                if(glob($cover_photo_path.'.jpg')){
                  $src = $cover_photo_path.'.jpg';
                  $is_profile = 1;
                } else if(glob($cover_photo_path.'.png')){
                  $src = $cover_photo_path.'.png';
                  $is_profile = 1;
                } else if(glob($cover_photo_path.'.gif')){
                  $src = $cover_photo_path.'.gif';
                  $is_profile = 1;
                }
            } $src = "http://gotouniversity.com/frontend/web/uploads/".$history['student_id']."/profile_photo/logo_170X115.png"; ?>
            <img src="<?= $src; ?>"/>
        </div>
        <p class="consultants-msg-text"><?= $history['message']; ?></p>
    </div>
    
    <?php } } } else  echo "<p class='no-message'>No Messages!</p>"; ?>

