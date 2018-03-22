<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\StudentUniveristyApplication */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-univeristy-application-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'student_id')->textInput() ?>

    <?= $form->field($model, 'srm_id')->dropDownList($srm_name, ['prompt'=>'Select SRM'])->label('SRM') ?>

    <?= $form->field($model, 'consultant_id')->dropDownList($consultant_name, ['id'=>'consultant_id','prompt'=>'Select Consultant'])->label('Consultant') ?>

    <?= $form->field($model, 'university_id')->textInput() ?>

    <?= $form->field($model, 'course_id')->textInput() ?>

    <?= $form->field($model, 'start_term')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'remarks')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton( 'Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
