<?php

use yii\helpers\Html;
$this->context->layout = 'profile';
$this->title = 'Shortlisted Courses';
use common\models\PackageType;
use common\models\StudentPackageDetails;
use common\models\FreeCounsellingSessions;
?>

<?php
    $package = PackageType::find()->where(['=', 'name', 'Free Application Package'])->one()->id;
    $hasFreeApplicationPackage = StudentPackageDetails::find()->where(['AND', ['=', 'student_id', Yii::$app->user->identity->id], ['=', 'package_type_id', $package]])->one();
    if(empty($hasFreeApplicationPackage)) {
        echo '<p type="hidden" id="free-application-package"></p>';
    }
?>
<div class="">
    <?= $this->render('_student_common_details'); ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php if(sizeof($models) === 0): ?>
        <h2> You haven't shortlisted any course yet.</h2>
        <div class="col-xs-12 text-center">
            <a class="btn btn-blue" href="?r=course/index&degreeLevel=Bachelors">View Programs</a>
        </div>
    <?php else: ?>
        <?php foreach($models as $model): ?>
            <div class="col-xs-12 bordered">
                <h3><?= $model->course->name; ?></h3>
                <p>
                    <a href="?r=university/view&id=<?= $model->university->id; ?>"><?= $model->university->name; ?></a>
                </p>
                <?php
                    $counsellingSession = FreeCounsellingSessions::find()->where(['=', 'student_id', Yii::$app->user->identity->id])->one();
                ?>
                <?php if(empty($counsellingSession)): ?>
                    <a href="?r=site/register-for-free-counselling-session" class="btn btn-blue">Click to get Free counselling session</a>
                <?php endif; ?>
                <button class="btn btn-danger btn-unlist-course" data-id="<?= $model->id; ?>">Remove</button>
                <?php if($model->university->is_partner): ?>
                    <button class="btn btn-success btn-apply" data-course-id="<?= $model->course->id; ?>" data-university-id="<?= $model->university->id; ?>">Apply</button>
                <?php endif; ?>
                <hr/>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</div>
</div>
<?php
    $this->registerJsFile('@web/js/dashboard.js');
?>

<div class="modal fade" tabindex="-1" role="dialog" id="apply-warning">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Alert</span></button>
      </div>
      <div class="modal-body">
        <p>Please buy the <strong> Free Application Package </strong> to apply to this course.</p>
        <a href="?r=packages/index" class="btn btn-blue">Buy</a>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" tabindex="-1" role="dialog" id="course-application">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Alert</span></button>        
      </div>
      <div class="modal-body">
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger btn-pay">Proceed to Pay</button>
      </div>
    </div>
  </div>
</div>