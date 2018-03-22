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
        <div class="col-xs-12 col-sm-12">
				        <div class="col-xs-12 col-sm-12">
				        <?= $form->field($model, 'description')->widget(CKEditor::className(), [
				            'options' => ['rows' => 10],
				            'preset' => 'basic'
				        ]) ?>
				       </div>
      </div>
   </div>
   