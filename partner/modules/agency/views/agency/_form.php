<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\bootstrap\Modal;
use common\models\Country;
$codelist = Country::getAllCountriesPhoneCode();

?>
<?php if(isset($message) && strpos($message, 'Error') !== false): ?>
    <div class="alert alert-danger" role="alert"><?= $message ?></div>
<?php endif; ?>

<?php if(isset($message) && strpos($message, 'Success') !== false): ?>
    <div class="alert alert-success" role="alert"><?= $message ?></div>
<?php endif; ?>
<?php $form = ActiveForm::begin(['id' => 'counselor-registration-form']) ?>
<div class="row">
 
<div class="col-sm-6" style="text-align:justify;">
<div class="row">
<div class="col-sm-6" >
<?= $form->field($model, 'title')->dropDownList([1 => 'Mr.', 2 => 'Mrs.', 3 => 'Miss.'], ['prompt' => 'Select Title']); ?>
   
	</div> 
	<div class="col-sm-6" >
	<?= $form->field($model, 'gender')->dropDownList(['M' => 'Male', 'F' => 'Female'], ['prompt' => 'Select Gender']); ?>
   
	</div> 
</div> 	
	<?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
	
    <?= $form->field($model, 'email')->textInput(['type' => 'email']) ?> 
     
	 
	 
	<?= $form->field($model, 'description')->textArea(['rows' => 4]) ?>
	</div> 
<div class="col-sm-6" style="text-align:justify;">
<?= $form->field($model, 'code')->widget(Select2::classname(), [
			'name' => 'codelist',
			'data' => $codelist,
			'maintainOrder' => true,
			'options' => ['placeholder' => 'Code (+) *', 'multiple' => false],
			'pluginOptions' => [
				'tags' => true,
			]
		]) ?>
    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
    
			<?= $form->field($model, 'country_id')->widget(Select2::classname(), [
			'name' => 'countries',
			'data' => $countries,
			'maintainOrder' => true,
			'options' => ['placeholder' => 'Select Country', 'multiple' => false], ]); ?>
		
		<?php 
	if($model->speciality){
		$model->speciality = explode(',',$model->speciality); 
	}
?>
			<?= $form->field($model, 'speciality')->widget(Select2::classname(), [
			'name' => 'degrees',
			'data' => $degrees,
			'maintainOrder' => true,
			'options' => ['placeholder' => 'Select Speciality', 'multiple' => true],
			'pluginOptions' => [
				'tags' => true,
			]
		]); ?>
		
    <?= $form->field($model, 'experience')->textInput(['maxlength' => true, 'placeholder' => 'Experience in Years...']) ?>
    <?= $form->field($model, 'skills')->textArea(['rows' => 4]) ?>
	</div>
	<div class="col-sm-12" >
    <div class="form-group">
		<a href="?r=site/uniterm" data-toggle="modal" data-target="#myModal2" >By clicking Sign Up, you agree to GTU Terms of Use and Policy</a>
	 <?= $form->field($model, 'agree')->checkbox() ?>
	 
        <?= Html::submitButton(  'Submit', ['class' => 'btn btn btn-primary']) ?>
    </div></div>
	</div>
<?php ActiveForm::end(); ?>