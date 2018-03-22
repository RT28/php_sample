<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\WebinarCreateRequestSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="webinar-create-request-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'topic') ?>

    <?= $form->field($model, 'date_time') ?>

    <?= $form->field($model, 'author_name') ?>

    <?= $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'logo_image') ?>

    <?php // echo $form->field($model, 'duration') ?>

    <?php // echo $form->field($model, 'country') ?>

    <?php // echo $form->field($model, 'disciplines') ?>

    <?php // echo $form->field($model, 'degreelevels') ?>

    <?php // echo $form->field($model, 'university_admission') ?>

    <?php // echo $form->field($model, 'test_preperation') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
