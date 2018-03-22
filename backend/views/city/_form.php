<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\City */
/* @var $form yii\widgets\ActiveForm */

$state_data = [];
 if (isset($model->state_id)) {
        $state_data = [$model->state_id => $model->state->name];
    }
?>

<div class="city-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <div class="panel panel-default" style="width:90%">
                <div class="panel-heading">Employee</div>
                <div class="panel-body">
              <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

              <?= $form->field($model, 'country_id')->dropDownList($countries, ['id' => 'country_id','prompt'=>'Select Country'])->label('Country'); ?>

              <?= $form->field($model, 'state_id')->widget(DepDrop::classname(), [
                         'options' => ['id' => 'state_id'],
                         'data' => $state_data,
                         'type' => DepDrop::TYPE_SELECT2,
                         'pluginOptions' => [
                             'depends' => ['country_id'],
                             'placeholder' => 'Select State',
                             'url' => Url::to(['/university/dependent-states'])
                         ]
                         ])->label('State'); ?>

              <div class="form-group">
                  <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
              </div>
              </div>
            </div>
        </div>
    </div>
    <?php // Yii::$app->user->identity->role_id; ?>
    <?php ActiveForm::end(); ?>

</div>
