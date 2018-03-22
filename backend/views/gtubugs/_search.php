<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GtuBugsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gtu-bugs-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'gt_id') ?>

    <?= $form->field($model, 'gt_subject') ?>

    <?= $form->field($model, 'gt_description') ?>

    <?= $form->field($model, 'gt_steptoreproduce') ?>

    <?= $form->field($model, 'gt_platform') ?>

    <?php // echo $form->field($model, 'gt_operatingsystem') ?>

    <?php // echo $form->field($model, 'gt_browser') ?>

    <?php // echo $form->field($model, 'gt_url') ?>

    <?php // echo $form->field($model, 'gt_severity') ?>

    <?php // echo $form->field($model, 'gt_envid') ?>

    <?php // echo $form->field($model, 'gt_bugmoduleid') ?>

    <?php // echo $form->field($model, 'gt_createdby') ?>

    <?php // echo $form->field($model, 'gt_createdon') ?>

    <?php // echo $form->field($model, 'gt_status') ?>

    <?php // echo $form->field($model, 'gt_summary') ?>

    <?php // echo $form->field($model, 'gt_verifiedby') ?>

    <?php // echo $form->field($model, 'gt_verifiedon') ?>

    <?php // echo $form->field($model, 'gt_resolvedby') ?>

    <?php // echo $form->field($model, 'gt_resolvedon') ?>

    <?php // echo $form->field($model, 'gt_modifiedby') ?>

    <?php // echo $form->field($model, 'gt_lastmodified') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
