<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Country */
/* @var $form yii\widgets\ActiveForm */

$status = array(0=>'Inactive',1=> 'Active');
?>

<div class="country-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <div class="panel panel-default" style="width:90%">
                <div class="panel-heading">Country</div>
                <div class="panel-body">
				    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
					<?= $form->field($model, 'iso_code')->textInput(['maxlength' => true]) ?>
					 <?= $form->field($model, 'phone_code')->textInput(['maxlength' => true]) ?>
					
					 <?= $form->field($model, "status")->dropDownList($status) ?> 
				    <div class="form-group">
				        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
				    </div>
				    </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
