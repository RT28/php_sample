<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\PackageSubtype */
/* @var $form yii\widgets\ActiveForm */
?>

<!--<div class="package-subtype-form col-xs-12 col-sm-6">-->
<div class="package-subtype-form">
    <?php $form = ActiveForm::begin(); ?>
     <div class="row">
        <div class="col-xs-12 col-sm-12">
            <div class="panel panel-default" style="width:90%">
                <div class="panel-heading">Package Subtypes</div>
                    <div class="panel-body">

                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'package_type_id')->dropDownList($packageType, ['prompt' => 'Select Package Type...']) ?>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <?= $form->field($model, 'currency')->dropDownList($currency, ['prompt' => 'Select Currency...']) ?>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <?= $form->field($model, 'fees')->textInput(['type' => 'number']) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <?= $form->field($model, 'limit_type')->dropDownList($limitType, ['prompt' => 'Select limit type']) ?>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <?= $form->field($model, 'limit_count')->textInput(['type' => 'number']) ?>
                            </div>
                        </div>

                        <?= $form->field($model, 'package_offerings')->widget(Select2::classname(),[
                            'data' => $packageOfferings,
                            'options' => [
                                'multiple' => true,
                                'placholder' => 'Select Package Offerings'
                            ],
                            'pluginOptions' => [
                                'tags' => true
                            ]
                        ]) ?>

                        <?= $form->field($model, 'rank')->textInput(['type' => 'number']) ?>

                        <?= $form->field($model, 'description')->textArea(['rows' => 4]) ?>
                        
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
