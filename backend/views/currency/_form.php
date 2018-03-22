<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Currency */
/* @var $form yii\widgets\ActiveForm */
?>

<!--<div class="currency-form col-xs-12 col-sm-4">-->
    <div class="currency-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <div class="panel panel-default" style="width:90%">
                <div class="panel-heading">Currency</div>
                <div class="panel-body">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'iso_code')->textInput(['maxlength' => true]) ?>
                    
                    <?= $form->field($model, 'country_id')->widget(Select2::classname(),[
                            'data' => $countries,
                            'options' => ['placeholder' => 'Country']
                        ]);
                    ?>

                    <?= $form->field($model, 'symbol')->textInput(['maxlength' => true]) ?>

                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
