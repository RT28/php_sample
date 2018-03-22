<?php
    $this->context->layout = 'profile';
    $this->title = 'Video';
?>
<?php if(isset($message) && !empty($message)):?>
    <div class="alert alert-danger error-container hidden"><?= $message; ?></div>
<?php endif; ?>

<div class="col-sm-12">
    <?= $this->render('/student/_student_common_details'); ?>
    <div class="row">
        <div class="student-video col-xs-12">
            <iframe src="https://tokbox.com/embed/embed/ot-embed.js?embedId=f906977e-6117-4665-a96d-c0be6d7e4285&room=<?= $openTokSessionToken?>&iframe=true" width="800px" height="640px" >
            </iframe>
        </div>
    </div>
</div>
</div>
</div>