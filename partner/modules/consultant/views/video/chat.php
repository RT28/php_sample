<?php
use common\models\Consultant;
use common\models\PartnerEmployee;
use common\components\Roles;
use yii\helpers\ArrayHelper;
use common\models\StudentConsultantRelation;
use common\models\User;
use common\components\Commondata;
use common\models\ChatHistory;

?>
<?php
    use OpenTok\OpenTok;
    use common\components\ConnectionSettings;
    $this->context->layout = 'main';
    $this->title = 'Video';
    $this->registerCssFile('css/chatstyle.css');
    $this->registerCssFile('css/video.css');
?>
<?php if(isset($openTokSessionToken) && !empty($openTokSessionToken)): ?>
<script src="https://static.opentok.com/v2/js/opentok.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<?php endif;?>
<input type="hidden" id="current_page" value="chat"/>    


<?php if(isset($message) && !empty($message)):?>
    <div class="alert alert-danger error-container hidden"><?= $message; ?></div>
<?php endif; ?>
<?php
    $isMeetingRequired =  true;
?>
<div class="col-sm-12">
    <div class="row">
        <div class="col-xs-12">
            <div class="chat-container">
                <div class="chat-ui-header">
                    <div class="row">
                        <div class="col-sm-9">
                        <?php 
                        if(isset($partner_login_id) && !empty($partner_login_id)){
                        $ids = Commondata::encrypt_decrypt('encrypt', $partner_login_id);?>
                        <h3 class="chat-ui-titles"><?= $chat_name; ?> <a href="index.php?r=consultant/video/videocall&id=<?= $ids; ?>" target="_blank"><img id="video_call" src="../../frontend/web/images/video-call-ic.png"/></a></h3>
                        <?php } ?>
                        </div>
                        <div class="col-sm-3">
                            <h3 class="chat-ui-titles">My Students</h3>
                        </div>
                    </div>
                </div>
                
                <div class="chat-ui-body">

                    <div class="row">

                        <div class="col-sm-9">
                        <?php if(isset($openTokSessionToken) && !empty($openTokSessionToken)): ?>
                            <div class="chat-messager">
                            <div class="chat-box" id="history">
                        <?php 
                        if(!empty($chatHistory)){
                        foreach($chatHistory as $history){ ?>
                        <div id="videos" style="display: none;">
                            <div class="col-xs-12" id="subscribe"></div>
                            <div class="col-xs-3" id="publish"></div>
                        </div>

                    <?php if($history['sender_id']==$history['partner_login_id']){ ?>
                    <div class="msg-tile users-msg">
                    <p class="users-msg-text"><?= $history['message']; ?>
                        </p>
                        <div class="chat-date"><?= date_format($date,"M-d h:i"); ?></div>
                        <div class="users-img">
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
								
								$date=date_create($history['created_at']);
                                ?>
                                <img src="<?= $src; ?>"/>
                        </div>
                        
                    </div>
                    <?php } else if($history['sender_id']==$history['student_id']){ ?>
                        <div class="msg-tile consultants-msg">
                            <div class="consultants-img">
                                <?php
                                $cover_photo_path = [];
                                $src = './noprofile.gif';
                                $is_profile = 0;
                                if(is_dir("../../frontend/web/uploads/".$history['student_id']."/profile_photo")) {
                                    $cover_photo_path = "../../frontend/web/uploads/".$history['student_id']."/profile_photo/logo_170X115";
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
                                } 
								$date=date_create($history['created_at']); 
								?>
                                <img src="<?= $src; ?>"/>
                            </div>
                            <p class="consultants-msg-text"><?= $history['message']; ?></p>
                            
                        <div class="chat-date"><?= date_format($date,"M-d h:i"); ?></div>
                        </div>
                        <?php } } } else  echo "<p class='no-message'>No Messages!</p>"; ?>

                        </div>
                        

                            <div class="type-chat" id="type-chat" >
                                <div class="input-group">
                                <form id='chatform'>
                                      <input type="text" class="form-control" placeholder="Input your text here" id="msgTxt" autocomplete="off"></input>
                                 </form>
                                  <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><img src="../../frontend/web/images/chat-send-ic.png"/></button>
                                  </span>
                                </div>
                            </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <?php $id = Yii::$app->user->identity->id; ?>
                        <div class="col-sm-3 pad-left-0">
                            <div class="other-chat">
                                    <!-- listing consultants -->
                                    <?php
                                    $id = Yii::$app->user->identity->id; 
                                    $students = User::find()
                                    ->leftJoin('student_consultant_relation', 'user_login.id = student_consultant_relation.student_id') 
                                    ->where('student_consultant_relation.consultant_id = '.$id.'')
                                    ->all();
                                 
                                    foreach($students as $student){ $active_con = 'active';
                                        if($student['logged_status']==1) { $active_con = 'active'; } else { $active_con = ''; } 
                                            $name = $student['first_name']." ".$student['last_name'];
                                            $ids = Commondata::encrypt_decrypt('encrypt', $student['id']);
                                         ?>
                                         <a href="index.php?r=consultant/video/chat&id=<?= $ids; ?>">
                                         <div class="other-chat-trigger <?= $active_con; ?>" id="online_student<?= $student['id']; ?>">
                                            <div class="other-chat-img">
                                                <?php
                                                $cover_photo_path = [];
                                                $src = './noprofile.gif';
                                                $is_profile = 0;
                                                if(is_dir("../../frontend/web/uploads/".$student['id']."/profile_photo")) {
                                                    $cover_photo_path = "../../frontend/web/uploads/".$student['id']."/profile_photo/logo_170X115";
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
                                                     
                                                }
                                                 $date=date_create($history['created_at']); 
                                                ?>
                                                <img id="partner_img_<?= $student['id']; ?>" src="<?= $src; ?>"/>
                                                
                                            </div>
                                            <div class="other-chat-name">
                                            <?php $m_count = 0; 
                                            $m_count = ChatHistory::find()
                                                    ->where('partner_login_id = '.$id)
                                                    ->andWhere('role_id = '.Roles::ROLE_STUDENT)
                                                    ->andWhere('student_id = '.$student['id'].'')
                                                    ->andWhere('partner_read_status = 0')
                                                    ->all();
                                                    $m_count =  count($m_count); ?>
                                                <?= $name; ?>&nbsp;<span class="m_count" id="countP_<?= $student['id']; ?>"><?php if($m_count!=0){ echo $m_count; } ?></span>
                                            </div>
                                        </div>
                                        </a>
                                    <?php } ?>            
                                
                                    
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if(isset($openTokSessionToken) && !empty($openTokSessionToken)): ?>
            <?php
            if($isMeetingRequired) {
                $this->registerJsFile('/partner/web/js/video.js');
            }
            ?>
            <input type="hidden" name="partner_login_id" id="partner_login_id" value="<?= $partner_login_id; ?>">
            <input type="hidden" id="open-tok-api-key" value="<?= $openTokApiKey; ?>"/>
            <input type="hidden" id="open-tok-session-id" value="<?= $openTokSessionId; ?>"/>
            <input type="hidden" id="open-tok-token" value="<?= $openTokSessionToken; ?>"/>
        <?php endif;?>
    </div>
</div>
</div>
</div>
<script type="text/javascript">
window.setInterval(function(){
  fnGetloggedUser();
}, 5000);
function fnGetloggedUser() {
    var partner_login_id = $("#partner_login_id").val();
    $.ajax({
            url: '?r=consultant/video/getloggeduser',
            method: 'POST',
            dataType:'json',
            data: {
            partner_login_id: partner_login_id,
            },
            success: function(response) {
                if(response.unread_total=='null' || response.unread_total==0){
                    $('#m_count').text('');
                } else {
                   $('#m_count').text(response.unread_total); 
                }
                $('.other-chat-trigger').removeClass('active');
                $.each(response['online_students'],function(i,v){
                $('#online_student'+v).addClass('active');
                });
                if(response['unread_students'])
                $.each(response['unread_students'],function(i,v){
                if(v[1]=='null'){
                    $('#countP_'+v[0]).text('');
                } else {
                    $('#countP_'+v[0]).text(v[1]);
                }
                });
                /*$.each(response['online_trainees'],function(i,v){
                $('#online_trainees'+v).addClass('active');
                });
                $.each(response['online_editors'],function(i,v){
                $('#online_editors'+v).addClass('active');
                });
                $.each(response['online_employees'],function(i,v){
                $('#online_employees'+v).addClass('active');
                });*/
            },
            error: function(error) {
                console.log(error);
            }
        }); 
}
</script>
