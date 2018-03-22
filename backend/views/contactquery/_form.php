<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\Status;
/* @var $this yii\web\View */
/* @var $model backend\models\UniversityEnquiry */
/* @var $form yii\widgets\ActiveForm */
$status = Status::getStatus();

?>

<div class="university-enquiry-form">

    <?php $form = ActiveForm::begin(); ?>
 <?= Html::hiddenInput('id' ,$model->id); ?>
 
	<?= $form->field($model, 'username')->textInput();?> 
	  <?= $form->field($model, "status")->dropDownList($status) ?> 
	


     
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
