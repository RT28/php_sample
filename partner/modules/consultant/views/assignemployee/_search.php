<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\StudentConsultantRelationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-consultant-relation-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'student_id') ?>

    <?= $form->field($model, 'consultant_id') ?>

    <?= $form->field($model, 'is_sub_consultant') ?>

    <?= $form->field($model, 'verify_by_consultant') ?>

    <?php // echo $form->field($model, 'comment_by_consultant') ?>

    <?php // echo $form->field($model, 'assigned_work_satus') ?>

    <?php // echo $form->field($model, 'comment_by_subconsultant') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
