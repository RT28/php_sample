<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SeofieldsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gt-seofields-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'gt_id') ?>

    <?= $form->field($model, 'gt_title') ?>

    <?= $form->field($model, 'gt_desccontent') ?>

    <?= $form->field($model, 'gt_keycontent') ?>

    <?= $form->field($model, 'gt_linkurl') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
