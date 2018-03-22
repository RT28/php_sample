<?php

use yii\helpers\Html;
use common\components\Notifications;
$this->context->layout = 'profile';
?>
<?php
    $defaultClass = 'dashboard-checklist-item';
    $completeClass = 'dashboard-checklist-item dashboard-checklist-item-done';
?>
                        
<div class="col-sm-12">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_student_common_details', []); ?>
    <div class="row">
    	<div class="col-sm-6">
    <table class="table table-bordered">
        <tr>
            <?php
                $href = '';
                $hrefClass = 'disabled';
                $className = $defaultClass;
                $text = 'Pending';
                if ($hasFreeApplicationPackage) {
                    $href = '?r=student/create&id=' . Yii::$app->user->identity->id;
                    $hrefClass = '';
                }
                if($hasFreeApplicationPackage && $isProfileComplete) {
                    $href = '?r=student/view';
                    $className = $completeClass;
                    $text = 'Completed';
                }
            ?>
            <td class="table-cell-highlight"><strong>Profile:</strong></td>
            <td class="table-cell-highlight-light"><a href="<?= $href; ?>"><?= $text ?></a></td>
        </tr>
        <tr>
            <?php
                $href = '';
                $hrefClass = 'disabled';
                $className = $defaultClass;
                $text = 'Pending';
                if($hasFreeApplicationPackage && $isProfileComplete && $areDocumentsUploaded) {
                    $href = '?r=student/view';
                    $className = $completeClass;
                    $text = 'Completed';
                    $hrefClass = '';
                }
            ?>
            <td class="table-cell-highlight"><strong>Application:</strong></td>
            <td class="table-cell-highlight-light"><a href="<?= $href; ?>"><?= $text ?></a></td>
        </tr>
        <tr>
            <?php
                $href = '';
                $text = 'Pending';
                if($hasFreeApplicationPackage && $isProfileComplete && $areDocumentsUploaded) {
                    $href = '?r=student/view';
                    $className = $completeClass;
                    $text = 'Completed';
                    $hrefClass = '';
                }
            ?>
            <td class="table-cell-highlight"><strong>Documents:</strong></td>
            <td class="table-cell-highlight-light"><a href="<?= $href; ?>"><?= $text ?></a></td>
        </tr>
    </table>
</div>
<div class="col-sm-6 text-right">
    <a href="?r=site/register-for-free-counselling-session" class="btn btn-blue" title="Book an appointment with the consultant">Book an appointment with the consultant</a>
</div>                   
              
</div>
    <?= $this->render('_university_applications'); ?>
</div>
</div>
</div>
<?php
    $this->registerJsFile('@web/js/dashboard.js');
?>
