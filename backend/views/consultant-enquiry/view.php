<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop; 
use yii\helpers\FileHelper;
use kartik\file\FileInput;
use dosamigos\ckeditor\CKEditor;
 

use yii\helpers\ArrayHelper;
use common\models\Country; 

$codelist = Country::getAllCountriesPhoneCode();


$this->title = $model->first_name.' '.$model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Consultant Enquiry', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="university-enquiry-view">
<div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">
    <h1><?= Html::encode($this->title) ?></h1>
   
   
     <?php $form = ActiveForm::begin(); ?>

	 <div class="row">
 
<div class="col-sm-6" style="text-align:justify;">
<div class="row">
<div class="col-sm-4" >
<?= $form->field($model, 'title')->dropDownList([1 => 'Mr.', 2 => 'Mrs.', 3 => 'Miss.'], ['prompt' => 'Select Title','readonly' => true]); ?> 
</div> 
<div class="col-sm-4" > 
<?= $form->field($model, 'first_name')->textInput(['readonly' => true]) ?>
</div> 
<div class="col-sm-4" >
<?= $form->field($model, 'last_name')->textInput(['readonly' => true]) ?> 

</div>
</div> 	
<div class="row">
<div class="col-sm-6" >
 <?= $form->field($model, 'email')->textInput(['readonly' => true]) ?>  
    
</div> 
<div class="col-sm-6" > 
	<?= $form->field($model, 'country_id')->dropDownList($countries, ['Select Country','disabled' => true]); ?>
	</div>  
</div>
<div class="row">
<div class="col-sm-6" >
<?= $form->field($model, 'code')->dropDownList($codelist, ['prompt' => 'Code (+) *','disabled' => true]); ?>
</div> 
<div class="col-sm-6" > 
<?= $form->field($model, 'mobile')->textInput(['readonly' => true]) ?>
    
</div>  
</div>
<div class="row">
<div class="col-sm-12" > 
<?= $form->field($model, 'description')->textarea(['rows' => 6,'readonly' => true]) ?>
</div>	 
	</div>	 
	
 

    <?php ActiveForm::end(); ?>
 
</div>
</div>
</div>
