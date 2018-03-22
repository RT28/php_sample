<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\StandardTests;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Json;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Institute */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile('@web/js/institute.js');
$this->registerJsFile('https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js');

$state_data = [];
 if (isset($model->state_id)) {
        $state_data = [$model->state_id => $model->state->name];
    }
   $tests = ArrayHelper::map(StandardTests::find()->asArray()->all(),'id','name');
?>

<div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">Name & Adress</div>
                    <div class="panel-body">
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'adress')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'country_id')->dropDownList($countries, ['id' => 'country_id','prompt'=>'Select Country'])->label('Country');  ?>

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

                        <?= $form->field($model, 'city_id')->textInput(['maxlength' => true]) ?>
            </div>
      </div>
   </div>
   <div class="col-xs-12 col-sm-6">
      <div class="panel panel-default">
         <div class="panel-heading">Contact</div>
         <div class="panel-body">

                        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'contact_details')->textInput() ?>

                        <?= $form->field($model, 'contact_person')->textInput() ?>

                        <?= $form->field($model, 'contact_person_designation')->textInput() ?>

                        </div>
                </div>
            </div>
        </div>