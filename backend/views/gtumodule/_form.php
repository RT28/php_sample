<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\GtuEnvironment;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\GtuModule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gtu-module-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gt_envid')->dropDownList(ArrayHelper::map(GtuEnvironment::find()->all(), 'gt_id',
                'gt_name' ), ['id'=>'gt_envid','prompt' => '------Select Environment-----',])->Label('Environment'); ?>

    <?= $form->field($model, 'gt_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
