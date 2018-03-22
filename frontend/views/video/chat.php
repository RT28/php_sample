<?php
use common\models\Consultant;
use common\models\PartnerEmployee;
use common\components\Roles;
use yii\helpers\ArrayHelper;
use common\models\StudentConsultantRelation;
use common\components\Commondata;
use common\models\ChatHistory;

    $this->context->layout = 'profile';
    $this->title = 'Inbox';
?>
<?php
    use OpenTok\OpenTok;
    use common\components\ConnectionSettings;
    $this->context->layout = 'profile';
    $this->title = 'Live Chat';
    $this->registerCssFile('../frontend/web/css/video.css');
?>
<?php if(isset($openTokSessionToken) && !empty($openTokSessionToken)): ?>
<script src="https://static.opentok.com/v2/js/opentok.js"></script>
<input type="hidden" id="current_page" value="chat"/>

<?php endif;?>

<?php if(isset($message) && !empty($message)):?>
    <div class="alert alert-danger error-container hidden"><?= $message; ?></div>
<?php endif; ?>
<?php
    $isMeetingRequired =  true;
?>
<style type="text/css">
    .other-chat-trigger.inactive .other-chat-img {
    border: 3px solid #ffff00;
}
</style>
<div class="col-sm-12 chat-page">
    <?= $this->render('/student/_student_common_details'); ?>
    <div class="row">
        <div class="col-xs-12">
            <div class="chat-container">
                <div class="chat-ui-header">
                    <div class="row">
                        <div class="col-sm-9">
                        <?php 
                        if(isset($partner_login_id) && !empty($partner_login_id)){
                        $ids = Commondata::encrypt_decrypt('encrypt', $partner_login_id);?>
                        <h3 class="chat-ui-titles"><?= $chat_name; ?>
                        <?php if($logged_status==1){ $active = 'active_logged'; } else { $active = 'inactive_logged'; } ?>
                        <a href="videocall?id=<?= $ids; ?>&q=video" target="_blank"><img style="width: 34px;" class="<?php echo $active; ?>" id="video_icon_<?php echo $partner_login_id; ?>" src="../frontend/web/images/video-call-ic.png" title="Video Call"/></a>
                        <!--<a href="videocall?id=<?= $ids; ?>&q=audio" target="_blank"><img style="width: 24px;" class="<?php echo $active; ?>" id="audio_icon_<?php echo $partner_login_id; ?>" src="../frontend/web/images/audio_call.png" title="Audio Call"/></a>-->
                        </h3>
                        <?php } ?>
                        </div>
                        <div class="col-sm-3">
                            <h3 class="chat-ui-titles">My Consultants</h3>
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
                                            $date=date_create($history['created_at']); 
                                        ?>
                                            <img src="<?= $src; ?>"/>
                                        </div>
                                            <p class="consultants-msg-text"><?= $history['message']; ?>
                                            </p>
                                        <div class="chat-date"><?= date_format($date,"M-d h:i"); ?></div>
                                    </div>
                                    <?php } else if($history['sender_id']==$history['student_id']){ ?>
                                    <div class="msg-tile users-msg" >
                                        <p class="users-msg-text"><?= $history['message']; ?>
                                        </p>
                                        
                                        <div class="users-img">
                                            <?php
                                            $cover_photo_path = [];
                                            $src = '../frontend/web/noprofile.gif';
                                            $is_profile = 0;
                                            if(is_dir('../../frontend/web/uploads/' . $history['student_id'] . '/profile_photo')) {
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
                                        <div class="chat-date"><?= date_format($date,"M-d h:i"); ?></div>
                                    </div>
                                    
                                    <?php } } } else  echo "<p class='no-message'>No Messages!</p>"; ?>
                            </div>
                            <div class="type-chat" id="type-chat">
                                <div class="input-group">
                                <form id="formChat">
                                      <input type="text" class="form-control" placeholder="Input your text here" id="msgTxt" autocomplete="off"></input>
                                 </form>
                                  <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" id="send_btn" ><img src="../frontend/web/images/chat-send-ic.png"/></button>
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
                                    $consultants = Consultant::find()
                                    ->leftJoin('student_consultant_relation', 'student_consultant_relation.consultant_id = consultant.consultant_id') 
                                    ->where('student_consultant_relation.student_id = '.$id)
                                    ->all(); 
                                 
                                    foreach($consultants as $consultant){ 
                                        $ids = Commondata::encrypt_decrypt('encrypt', $consultant['partner_login_id']);
                                        if($consultant['logged_status']==1) {
                                        $alertTime = date('Y-m-d H:i:s',strtotime('+5 minutes',strtotime($consultant['last_active']))); 
                                        if(gmdate('Y-m-d H:i:s') > $alertTime){
                                        $active_con = 'inactive';
                                        } else { $active_con = 'active'; }  
                                        } else {
                                        $active_con = 'loggedout';    
                                        }
                                         //$active_con = 'active'; } else { $active_con = ''; } 
                                            $name = $consultant['first_name'].' '.$consultant['last_name'];
                                         ?>
                                         <a href="chat?id=<?= $ids; ?>">
                                        <div class="other-chat-trigger <?= $active_con; ?>" id="online_consultant<?= $consultant['id']; ?>" style="height: 40px;">
                                            <div class="other-chat-img">
                                                <?php
                                                $profile_path = "./../../partner/web/uploads/consultant/".$consultant['partner_login_id']."/profile_photo/consultant_image_228X228";
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
                                                else { $src = './../../partner/web/noprofile.gif'; }
                                                ?>
                                                <img id="partner_img_<?= $consultant['partner_login_id']; ?>" src="<?= $src; ?>"/>
                                            </div>
                                            <div class="other-chat-name">
                                            <?php $m_count = 0; 
                                            $m_count = ChatHistory::find()
                                                    ->where('student_id = '.$id)
                                                    ->andWhere('role_id = '.Roles::ROLE_CONSULTANT)
                                                    ->andWhere('partner_login_id = '.$consultant['partner_login_id'].'')
                                                    ->andWhere('student_read_status = 0')
                                                    ->all();
                                                    $m_count =  count($m_count); ?>
                                                <?= $name; ?>&nbsp; <span class="m_count" id="countP_<?= $consultant['partner_login_id']; ?>"><?php if($m_count!=0){ echo $m_count; } ?></span>
                                            </div>
                                            
                                        </div>
                                        </a>
                                    <?php } ?>            
                                
                                    <!-- lsiting trainee -->
                                    <?php
                                    $id = Yii::$app->user->identity->id;
                                    $trainees = PartnerEmployee::find()
                                    ->leftJoin('student_partneremployee_relation', 'student_partneremployee_relation.parent_employee_id = partner_employee.partner_login_id') 
                                    ->where('student_partneremployee_relation.student_id = '.$id)
                                    ->andWhere('partner_employee.role_id = '.Roles::ROLE_TRAINER)
                                    ->andWhere('partner_employee.profile_type = '.Roles::PROFILE_TRAINER)
                                    ->all(); 
                                    if(!empty($trainees)){ ?>
                                    <h3 class="chat-ui-titles"> My Trainers</h3>
                                    <?php foreach($trainees as $trainee){
                                    $ids = Commondata::encrypt_decrypt('encrypt', $trainee['partner_login_id']); ?> 
                                        <?php if($trainee['logged_status']==1) { $active_con = 'active'; } else { $active_con = ''; } 
                                        $name = $trainee['first_name'].' '.$trainee['last_name']; ?> 
                                        <a href="chat?id=<?= $ids; ?>">
                                        <div class="other-chat-trigger <?= $active_con; ?>" id="online_trainees<?= $trainee['id']; ?>" style="height: 40px;">
                                            <div class="other-chat-img">
                                                <?php
                                                $profile_path = "./../../partner/web/uploads/employee/".$trainee['partner_login_id']."/profile_photo/consultant_image_228X228";
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
                                                else { $src = './../../partner/web/noprofile.gif'; }
                                                ?>
                                                <img src="<?= $src; ?>"/>
                                            </div>
                                            <div class="other-chat-name">
                                                <?php $m_count = 0; 
                                                $m_count = ChatHistory::find()
                                                    ->where('student_id = '.$id)
                                                    ->andWhere('role_id = '.Roles::ROLE_TRAINER)
                                                    ->andWhere('partner_login_id = '.$trainee['partner_login_id'].'')
                                                    ->andWhere('student_read_status = 0')
                                                    ->all();
                                                    $m_count =  count($m_count); ?>
                                                <?= $name; ?>&nbsp; <span class="m_count" id="countP_<?= $trainee['partner_login_id']; ?>"><?php if($m_count!=0){ echo $m_count; } ?></span>
                                            </div>
                                        </div>
                                        </a>
                                    <?php } } ?>

                                    <?php
                                    $id = Yii::$app->user->identity->id;
                                    $editors = PartnerEmployee::find()
                                    ->leftJoin('student_partneremployee_relation', 'student_partneremployee_relation.parent_employee_id = partner_employee.partner_login_id') 
                                    ->where('student_partneremployee_relation.student_id = '.$id)
                                    ->andWhere('partner_employee.role_id = '.Roles::ROLE_TRAINER)
                                    ->andWhere('partner_employee.profile_type = '.Roles::PROFILE_EDITOR)
                                    ->all(); 
                                    if(!empty($editors)){ ?>
                                    <h3 class="chat-ui-titles"> My Editor</h3>
                                    <?php foreach($editors as $editor){ 
                                        $ids = Commondata::encrypt_decrypt('encrypt', $editor['partner_login_id']); 
                                        if($editor['logged_status']==1) { $active_con = 'active'; } else { $active_con = ''; }
                                        $name = $editor['first_name'].' '.$editor['last_name'];  ?> 
                                        <a href="chat?id=<?= $ids; ?>">
                                        <div class="other-chat-trigger <?= $active_con; ?>" id="online_editors<?= $editor['id']; ?>" style="height: 40px;">
                                            <div class="other-chat-img">
                                                <?php
                                                $profile_path = "./../../partner/web/uploads/employee/".$editor['partner_login_id']."/profile_photo/consultant_image_228X228";
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
                                                else { $src = './../../partner/web/noprofile.gif'; }
                                                ?>
                                                <img src="<?= $src; ?>"/>
                                            </div>
                                            <div class="other-chat-name">
                                                <?php $m_count = 0; 
                                                $m_count = ChatHistory::find()
                                                    ->where('student_id = '.$id)
                                                    ->andWhere('role_id = '.Roles::ROLE_TRAINER)
                                                    ->andWhere('partner_login_id = '.$editor['partner_login_id'].'')
                                                    ->andWhere('student_read_status = 0')
                                                    ->all();
                                                    $m_count =  count($m_count); ?>
                                                <?= $name; ?>&nbsp; <span class="m_count" id="countP_<?= $editor['partner_login_id']; ?>"><?php if($m_count!=0){ echo $m_count; } ?></span>
                                            </div>
                                        </div>
                                        </a>
                                    <?php } } ?>
                                
                                
                                <?php
                                    $id = Yii::$app->user->identity->id;
                                    $employees = PartnerEmployee::find()
                                    ->leftJoin('student_partneremployee_relation', 'student_partneremployee_relation.parent_employee_id = partner_employee.partner_login_id') 
                                    ->where('student_partneremployee_relation.student_id = '.$id)
                                    ->andWhere('partner_employee.role_id = '.Roles::ROLE_EMPLOYEE)
                                    ->all(); 
                                    if(!empty($employees)){ ?>
                                    <h3 class="chat-ui-titles"> Others</h3>
                                    <?php foreach($employees as $employee){ 
                                        $ids = Commondata::encrypt_decrypt('encrypt', $employee['partner_login_id']);
                                        if($employee['logged_status']==1) { $active_con = 'active'; } else { $active_con = ''; }
                                        $name = $employee['first_name'].' '.$employee['last_name']; ?>
                                        <a href="chat?id=<?= $ids; ?>">  
                                        <div class="other-chat-trigger <?= $active_con; ?>" id="online_employees<?= $employee['id']; ?>" style="height: 40px;">
                                            <div class="other-chat-img">
                                                <?php
                                                $profile_path = "./../../partner/web/uploads/employee/".$employee['id']."/profile_photo/consultant_image_228X228";
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
                                                else { $src = './../../partner/web/noprofile.gif'; }
                                                ?>
                                                <img src="<?= $src; ?>"/>
                                            </div>
                                            <div class="other-chat-name">
                                                <?php $m_count = 0; 
                                                $m_count = ChatHistory::find()
                                                    ->where('student_id = '.$id)
                                                    ->andWhere('role_id = '.Roles::ROLE_EMPLOYEE)
                                                    ->andWhere('partner_login_id = '.$employee['partner_login_id'].'')
                                                    ->andWhere('student_read_status = 0')
                                                    ->all();
                                                    $m_count =  count($m_count); ?>
                                                <?= $name; ?>&nbsp; <span class="m_count" id="countP_<?= $employee['partner_login_id']; ?>"><?php if($m_count!=0){ echo $m_count; } ?></span>
                                            </div>
                                        </div>
                                        </a>
                                    <?php } } ?>
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <?php if(isset($openTokSessionToken) && !empty($openTokSessionToken)): ?>
            <?php
            if($isMeetingRequired) {
                $this->registerJsFile('../frontend/web/js/video.js');
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
  fnGetchatnotify();
}, 5000);
function fnGetloggedUser() {
    var partner_login_id = $("#partner_login_id").val();
    $.ajax({
            url: 'getloggeduser',
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
                $('.other-chat-trigger').removeClass('inactive');
                $.each(response['online_consultants'],function(i,v){
                if(v[1]==1){    
                $('#online_consultant'+v[0]).addClass('active');
                } else {
                $('#online_consultant'+v[0]).addClass('inactive');    
                }
                });
                $.each(response['online_trainees'],function(i,v){
                $('#online_trainees'+v).addClass('inactive');
                });
                $.each(response['online_editors'],function(i,v){
                $('#online_editors'+v).addClass('active');
                });
                $.each(response['online_employees'],function(i,v){
                $('#online_employees'+v).addClass('active');
                });
                $.each(response['unread_consultants'],function(i,v){
                if(v[1]=='null'){
                    $('#countP_'+v[0]).text('');
                } else {
                    $('#countP_'+v[0]).text(v[1]);
                }
                });
                $.each(response['unread_trainees'],function(i,v){
                if(v[1]=='null'){
                    $('#countP_'+v[0]).text('');
                } else {
                    $('#countP_'+v[0]).text(v[1]);
                }
                });
                $.each(response['unread_employees'],function(i,v){
                if(v[1]=='null'){
                    $('#countP_'+v[0]).text('');
                } else {
                    $('#countP_'+v[0]).text(v[1]);
                }
                }); 
                
            },
            error: function(error) {
                console.log(error);
            }
        }); 
}
function submitchatForm() { alert("dsf");
       $("#formChat").submit();
    }
function fnGetchatnotify() {
    var partner_login_id = $("#partner_login_id").val();
    $.ajax({
            url: 'chatnotification',
            method: 'POST',
            dataType:'json',
            data: {
            partner_login_id: partner_login_id,
            },
            success: function(response) { 
                $.each(response['student_calls'],function(i,v){
                  if($('#box_callpop'+v[0]).length!==1){
                  $("#wrapper-content").prepend("<div class='box' id='box_callpop"+v[0]+"'><div class='box-inner'>"+v[1]+" calling....<button class='close_callnf' id='"+v[0]+"' onclick='fn_closevideo("+v[0]+");'>Decline</button><a href='/video/videocall?id="+v[2]+"'><button>Accept</button></a></div></div>");
                  $('#box_videopop'+v[0]).animate({left: '250px'});
                  }
                  });
            },
            error: function(error) {
                console.log(error);
            }
        }); 
}

function fn_closevideo(id){ 
  $('#box_callpop'+id).remove();
}
  /*$(document).ready(function(){
    $.ajax({
            url: 'video/getchatcount',
            method: 'POST',
            dataType:'json',
            success: function(response) {
                response.coun
            },
            error: function(error) {
                console.log(error);
            }
        });
        });  */
</script>