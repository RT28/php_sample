<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model frontend\models\FeaturedUniversities */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="featured-universities-form col-xs-6">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'university_id')->widget(Select2::classname(),[
        'data' => $universities,
        'options' => ['placeholder' => 'Select university...'],
        'pluginOptions' => [
            'allowClear' => true
        ]
    ]); ?>

    <?= $form->field($model, 'rank')->textInput(['type' => 'number']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
