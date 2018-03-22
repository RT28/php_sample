<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UniversityNotifications */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="university-notifications-form">

    <?php $form = ActiveForm::begin(); ?>
 
    <?= $form->field($model, 'title')->textInput() ?>
	<?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>
 

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
