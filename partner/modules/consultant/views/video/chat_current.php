<?php
use common\models\Consultant;
use common\models\PartnerEmployee;
use common\components\Roles;
use yii\helpers\ArrayHelper;
use common\models\StudentConsultantRelation;
use common\models\user;

?>
<?php
    use OpenTok\OpenTok;
    use common\components\ConnectionSettings;
    $this->context->layout = 'main';
    $this->title = 'Video';
    $this->registerCssFile('http://localhost/gotouniversity/frontend/web/css/style.css');
    $this->registerCssFile('http://localhost/gotouniversity/partner/web/css/video.css');
?>
    <script src="https://static.opentok.com/v2/js/opentok.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


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
                            <h3 class="chat-ui-titles" id="chat_person_name"> <img src="images/video-call-ic.png"/></h3>
                        </div>
                        <div class="col-sm-3">
                            <h3 class="chat-ui-titles">My Students</h3>
                        </div>
                    </div>
                </div>
                <div class="chat-ui-body">
                    <div class="row">
                    <?php if($isMeetingRequired): ?>
                <div id="videos" style="display: none;">
                    <div class="col-xs-12" id="subscribe"></div>
                    <div class="col-xs-3" id="publish"></div>
                </div>
                <?php else:?>
                    <h3 class="text-center">You do not have any meetings scheduled at this time.</h3>
                <?php endif; ?>
                        <div class="col-sm-9">
                            <div class="chat-messager">
                            <div class="chat-box" id="history">
                                <!-- <div class="msg-tile consultants-msg">
                                    <div class="consultants-img">
                                        <img src="http://gotouniversity.com/partner/web/uploads/consultant/19/profile_photo/consultant_image_228X228.jpg"/>
                                    </div>
                                        <p class="consultants-msg-text">This package is specially designed for applicants looking to enrol in MBA programs. Our consultants will help you shortlist the perfect schools from the thousands of MBA programs available globally, and will then assist you.</p>
                                </div>
                                <div class="msg-tile users-msg" >
                                    <p class="users-msg-text">Oh I see.</p>
                                    <div class="users-img">
                                        <img src="http://gotouniversity.com/partner/web/uploads/consultant/20/profile_photo/consultant_image_228X228.jpg"/>
                                    </div>
                                </div> -->
                            </div>
                            <div class="type-chat" id="type-chat" style="display: none;">
                                <div class="input-group">
                                <form>
                                      <input type="text" class="form-control" placeholder="Input your text here" id="msgTxt"></input>
                                 </form>
                                  <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><img src="images/chat-send-ic.png"/></button>
                                  </span>
                                </div>
                            </div>
                            </div>
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
                                         ?>
                                         <div class="other-chat-trigger <?= $active_con; ?>" id="online_student<?= $student['id']; ?>" onclick="funGetmychat('<?= $student['id']; ?>','<?= $name; ?>');">
                                            <div class="other-chat-img">
                                                <?php
                                                $cover_photo_path = [];
                                                $src = './noprofile.gif';
                                                $is_profile = 0;
                                                if(is_dir('http://localhost/gotouniversity/frontend/web/uploads/' . $student['id'] . '/profile_photo')) {
                                                    $cover_photo_path = "http://localhost/gotouniversity/frontend/web/uploads/".$student['id']."/profile_photo/logo_170X115";
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
                                                 $src = "http://localhost/gotouniversity/frontend/web/uploads/".$student['id']."/profile_photo/logo_170X115.png"; 
                                                ?>
                                                <img src="<?= $src; ?>"/>
                                            </div>
                                            <div class="other-chat-name">
                                                <?= $name; ?>
                                            </div>
                                        </div>
                                    <?php } ?>            
                                
                                    
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            if($isMeetingRequired) {
                $this->registerJsFile('http://localhost/gotouniversity/partner/web/js/video.js');
            }
        ?>
        <input type="text" name="partner_login_id" id="partner_login_id" value="">

        <?php if(isset($openTokSessionToken) && !empty($openTokSessionToken)): ?>
            <input type="hidden" id="open-tok-api-key" value="<?= $openTokApiKey; ?>"/>
            <input type="hidden" id="open-tok-session-id" value="<?= $openTokSessionId; ?>"/>
            <input type="hidden" id="open-tok-token" value="<?= $openTokSessionToken; ?>"/>
        <?php endif;?>
    </div>
</div>
</div>
</div>
<script type="text/javascript">
function funGetmychat(partner_login_id,name){
$('#partner_login_id').val(partner_login_id);
$.ajax({
            url: '?r=consultant/video/chatsingle',
            method: 'POST',
            data: { partner_login_id : partner_login_id },
            dataType:'html',
            success: function(data) {
                $('#history').html(data);
                $('#chat_person_name').text(name);
                $('#type-chat').show();
            },
            error: function(error) {
                console.log(error);
            }
        }); }
window.setInterval(function(){
  fnGetloggedUser();
}, 5000);
function fnGetloggedUser() {
    $.ajax({
            url: '?r=consultant/video/getloggeduser',
            method: 'POST',
            dataType:'json',
            success: function(response) {
                $('.other-chat-trigger').removeClass('active');
                $.each(response['online_students'],function(i,v){
                $('#online_student'+v).addClass('active');
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