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
  <h1>
    <?= Html::encode($this->title) ?>
  </h1>
  <?= $this->render('_student_common_details', []); ?>
  <div class="row">
    <div class="col-sm-4 col-xs-4">
      <div class="profile-update-section done"> <i class="fa fa-check-square-o" aria-hidden="true"></i> Profile </div>
    </div>
    <div class="col-sm-4 col-xs-4">
      <div class="profile-update-section done"> <i class="fa fa-check-square-o" aria-hidden="true"></i> Application </div>
    </div>
    <div class="col-sm-4 col-xs-4">
      <div class="profile-update-section"> <i class="fa fa-clock-o" aria-hidden="true"></i> Documents </div>
    </div>
    <div class="col-sm-12 col-xs-12">
      <div class="profile-updated-status back">
        <div class="profile-updated-status front" style="width: 66%;"> </div>
      </div>
    </div>
  </div>
  <div class="student-course-history">
    <table class="table">
      <thead>
        <tr>
          <th>Program</th>
          <th>University</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>A.B in Applied Mathematics</td>
          <td>Harvard University</td>
          <td>Results Awaited</td>
        </tr>
      </tbody>
    </table>
  </div>
  <!--<div class="row">
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
              
</div>-->
  <?php /*?><?= $this->render('_university_applications'); ?><?php */?>
</div>
</div>
</div>
<?php
    $this->registerJsFile('../frontend/web/js/dashboard.js');
?>
