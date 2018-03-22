<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model partner\modules\university\models\UniversityCourseListSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="university-course-list-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'program_code') ?>

    <?= $form->field($model, 'university_id') ?>

    <?= $form->field($model, 'degree_id') ?>

    <?= $form->field($model, 'major_id') ?>

    <?php // echo $form->field($model, 'degree_level_id') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'intake') ?>

    <?php // echo $form->field($model, 'language') ?>

    <?php // echo $form->field($model, 'fees') ?>

    <?php // echo $form->field($model, 'fees_international_students') ?>

    <?php // echo $form->field($model, 'duration') ?>

    <?php // echo $form->field($model, 'duration_type') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'standard_test_list') ?>

    <?php // echo $form->field($model, 'application_fees') ?>

    <?php // echo $form->field($model, 'application_fees_international') ?>

    <?php // echo $form->field($model, 'careers') ?>

    <?php // echo $form->field($model, 'eligibility_criteria') ?>

    <?php // echo $form->field($model, 'program_website') ?>

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
