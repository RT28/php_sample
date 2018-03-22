<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UniversityCommonAdmission */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="university-common-admission-form">

    <?php $form = ActiveForm::begin(); ?>
 
   <?= $form->field($model, "degree_level_id")->dropDownList($degreeLevels) ?> 
    
	<?= $form->field($model, "test_id")->dropDownList($standardTests) ?>

    <?= $form->field($model, 'score')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
