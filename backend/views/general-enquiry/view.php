<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop; 
use yii\helpers\FileHelper;
use kartik\file\FileInput;
use dosamigos\ckeditor\CKEditor;
 

use yii\helpers\ArrayHelper;
use common\models\Country;
/* @var $this yii\web\View */
/* @var $model backend\models\UniversityEnquiry */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'General Enquiry', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="university-enquiry-view">
<div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">
    <h1><?= Html::encode($this->title) ?></h1> 
   
     <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['readonly' => true]) ?> 

    <?= $form->field($model, 'email')->textInput(['readonly' => true]) ?>

	 <?= $form->field($model, 'code')->textInput(['disabled' => true]) ?> 
	 
    <?= $form->field($model, 'phone')->textInput(['readonly' => true]) ?> 
          

    <?= $form->field($model, 'message')->textarea(['rows' => 6,'readonly' => true]) ?>
 

    <?php ActiveForm::end(); ?>
</div>
</div>
</div>
</div>
