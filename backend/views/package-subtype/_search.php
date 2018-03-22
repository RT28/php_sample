<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PackageSubtypeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="package-subtype-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'package_type_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'limit_count') ?>

    <?= $form->field($model, 'fees') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'currency') ?>

    <?php // echo $form->field($model, 'limit_type') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'rank') ?>

    <?php // echo $form->field($model, 'package_offerings') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
