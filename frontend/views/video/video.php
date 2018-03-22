<?php
	use common\models\Consultant;
    use OpenTok\OpenTok;
    use common\components\ConnectionSettings;
    $this->context->layout = 'profile';
    $this->title = 'Video';
    $this->registerCssFile('../frontend/web/css/video.css');
?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://static.opentok.com/v2/js/opentok.min.js"></script>


<input type="hidden" id="current_page" value="video"/>

<?php if(isset($message) && !empty($message)):?>
    <div class="alert alert-danger error-container hidden"><?= $message; ?></div>
<?php endif; ?>
<?php
    $isMeetingRequired =  true;
?>
<div class="col-sm-12 video-ui">
    <?= $this->render('/student/_student_common_details'); ?>
   <div class="student-video">
   <div class="row">
   <div class="col-sm-12">
   		<div class="call-with">
        <div class="v-call-profile-pic"></div>
        	<!--<p>Video Call with <?= $chat_name; ?></p>-->
        </div>
   </div>
   	<div class="col-sm-12">
        <?php if($isMeetingRequired): ?>
    <div class="video-call-screen" id="videos">
                    <div id="subscribe"></div>
                    <div id="publish"></div>
        <div class="video-side-buttons">
        	<button class="vid-btn btn-1" onclick="publish();"><img src="../frontend/web/images/vid-ic-1.png"/></button>
        	<button class="vid-btn btn-2 full-screen"><img src="../frontend/web/images/vid-ic-2.png"/></button>
        	<button class="vid-btn btn-3" onclick="sharescreen();"><img src="../frontend/web/images/vid-ic-3.png"/></button>
        </div>
        <script>
        	$(document).ready(function(){
			$(".full-screen").click(function(){
				$("#videos").toggleClass("full-view");
				$("body").toggleClass("full-view-active");
			});
		});
        </script>
        <div class="video-buttom-buttons">
        	<a class="vid-btn end-v-call" onclick="endCall();"><img src="../frontend/web/images/end-v-call.png"/></a>
        	<a class="vid-btn audiobtn"></a>
            <a class="vid-btn videobtn"></a>
        </div>
    </div>
    <?php else:?>
        <h3 class="text-center">You do not have any meetings scheduled at this time.</h3>
    <?php endif; ?>
    </div>
   </div>
        <?php
            if($isMeetingRequired) {
                $this->registerJsFile('../frontend/web/js/video_fn.js');
            }
        ?>
        <?php if(isset($openTokSessionToken) && !empty($openTokSessionToken)): ?>
            <input type="hidden" id="open-tok-api-key" value="<?= $openTokApiKey; ?>"/>
            <input type="hidden" id="open-tok-session-id" value="<?= $openTokSessionId; ?>"/>
            <input type="hidden" id="open-tok-token" value="<?= $openTokSessionToken; ?>"/>
        <?php endif;?>
    </div>
</div>