<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Seofields;


/* @var $this yii\web\View */
/* @var $model app\models\GtSeofields */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gt-seofields-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gt_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gt_desccontent')->textarea(['maxlength' => true,'rows'=>3]) ?>

    <?= $form->field($model, 'gt_keycontent')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gt_linkurl')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
