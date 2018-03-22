<?php
    use OpenTok\OpenTok;
    use common\components\ConnectionSettings;
    $this->context->layout = 'main';
    $this->title = 'Video';
?>
<?php if(isset($message) && !empty($message)):?>
    <div class="alert alert-danger error-container hidden"><?= $message; ?></div>
<?php endif; ?>
<?php
    $isMeetingRequired = (!empty($event)) ? true : false;
?>
<div class="student-video col-xs-12">
    <h2><?= $this->title; ?></h2>
    <div class="row">
        <?php if($isMeetingRequired): ?>
            <div class="col-xs-12" id="subscribe"></div>
            <div class="col-xs-3" id="publish"></div>
        <?php else:?>
            <h3 class="text-center">You do not have any meetings scheduled at this time.</h3>
        <?php endif; ?>
    <div>
</div>
<?php
    if($isMeetingRequired) {
        $this->registerJsFile('js/video.js');
    }
?>
<?php if(isset($openTokSessionToken) && !empty($openTokSessionToken)): ?>
    <input type="hidden" id="open-tok-api-key" value="<?= $openTokApiKey; ?>"/>
    <input type="hidden" id="open-tok-session-id" value="<?= $openTokSessionId; ?>"/>
    <input type="hidden" id="open-tok-token" value="<?= $openTokSessionToken; ?>"/>
<?php endif;?>