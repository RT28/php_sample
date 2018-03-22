<?php
    use OpenTok\OpenTok;
    use common\components\ConnectionSettings;
    $this->context->layout = 'profile';
    $this->title = 'Video';
    $this->registerCssFile('../frontend/web/css/video.css');
?>

    <script src="https://static.opentok.com/v2/js/opentok.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
/*$(document).ready(function(){
publish();    
});*/
</script>
<input type="hidden" id="current_page" value="video"/>

<?php if(isset($message) && !empty($message)):?>
    <div class="alert alert-danger error-container hidden"><?= $message; ?></div>
<?php endif; ?>
<?php
    $isMeetingRequired =  true;
?>
<div class="col-sm-12">
    <?= $this->render('/student/_student_common_details'); ?>
    <div class="row">
        <div class="student-video col-xs-12">

            <!-- <a href="#openModal">Open Modal</a> -->

                <div>
                    <!-- <a title="End Call" onclick="endCall();"><img src="../frontend/web/images/end_call.png" height="30px" width="30px"></a>
                    <a title="Enable Video" onclick="publish()"><img src="../frontend/web/images/video-call-ic.png" height="30px" width="30px"></a>
                    <a title="Audio Call"><img src="../frontend/web/images/audio_call.png" height="30px" width="30px"></a>
                    <a title="Disable Video" onclick="unpublish()"><img src="../frontend/web/images/end_video.png" height="30px" width="30px"></a> -->
                    
                    <!-- <button onclick="check()" id="shareBtn">Share your screen</button>
                    <button onclick="resizePublisher()">Full screen</button>
                    <button onclick="publish()">Publish Video</button>
                    <button onclick="unpublish()">Unpublish</button> -->
                    <?php if($isMeetingRequired): ?>
                    <div id="videos">
                        <div class="col-xs-12" id="subscribe"></div>
                        <div class="col-xs-3" id="publish"></div>
                    </div>
                    <?php else:?>
                        <h3 class="text-center">You do not have any meetings scheduled at this time.</h3>
                    <?php endif; ?>
                    
                    </div>

            <!-- <h2><?= $this->title; ?></h2>
            <button onclick="check()" id="shareBtn">Share your screen</button>
            <button onclick="resizePublisher()">Full screen</button>
            <button onclick="publish()">Publish Video</button>
            <button onclick="unpublish()">Unpublish</button>
            <label id="minutes">00</label>:<label id="seconds">00</label>
            <div class="row">
                <?php if($isMeetingRequired): ?>
                <div id="videos">
                    <div class="col-xs-12" id="subscribe"></div>
                    <div class="col-xs-3" id="publish"></div>
                </div>
                <?php else:?>
                    <h3 class="text-center">You do not have any meetings scheduled at this time.</h3>
                <?php endif; ?>
            </div> -->
        </div>
        <?php
            if($isMeetingRequired) {
                $this->registerJsFile('../frontend/web/js/audio_call.js');
            }
        ?>
        <?php if(isset($openTokSessionToken) && !empty($openTokSessionToken)): ?>
            <input type="hidden" id="open-tok-api-key" value="<?= $openTokApiKey; ?>"/>
            <input type="hidden" id="open-tok-session-id" value="<?= $openTokSessionId; ?>"/>
            <input type="hidden" id="open-tok-token" value="<?= $openTokSessionToken; ?>"/>
        <?php endif;?>
    </div>
</div>