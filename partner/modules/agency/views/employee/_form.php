<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use kartik\date\DatePicker;
use kartik\time\TimePicker;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use common\models\Country;
use common\components\Commondata;  
use common\models\StandardTests;  
use common\models\DegreeLevel; 

$titles = Commondata::getTitle();
$gender = Commondata::getGender();
$days = Commondata::getDay();

$codelist = Country::getAllCountriesPhoneCode();
$tests = StandardTests::getAllStandardTests();
$degree_level = DegreeLevel::getAllDegreeLevels();

    $city_data = [];
    $state_data = [];
    if (isset($model->city_id)) {
        $city_data = [$model->city_id => $model->city->name];
    }

    if (isset($model->state_id)) {
        $state_data = [$model->state_id => $model->state->name];
    }
	
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
<?= $form->field($model, 'title')->dropDownList($titles, ['prompt' => 'Select Title']); ?>
</div> 
<div class="col-sm-6" >
<?= $form->field($model, 'gender')->dropDownList($gender, ['prompt' => 'Select Gender']); ?>
</div> 
</div> 
<div class="row">
<div class="col-sm-6" >
<?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
</div> 
<div class="col-sm-6" >
<?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?></div> 
</div> 

 

<div class="row">
<div class="col-sm-6" >
<?= $form->field($model, 'email')->textInput(['type' => 'email']) ?> 
</div> 
<div class="col-sm-6" >
<?= $form->field($model, 'date_of_birth')->widget(DatePicker::classname(),[
'name' => 'date_of_birth',
'type' => DatePicker::TYPE_INPUT,
'pluginOptions' => [
'autoClose' => true,
'format' => 'yyyy-mm-dd',
		'todayHighlight' => true
]
]);?></div> 
</div> 


<div class="row">
<div class="col-sm-6" >
<?= $form->field($model, 'code')->widget(Select2::classname(), [
'name' => 'codelist','data' => $codelist,'maintainOrder' => true,
'options' => ['placeholder' => 'Code (+) *', 'multiple' => false],
'pluginOptions' => ['tags' => true,]
]) ?></div> 
<div class="col-sm-6" >
<?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
</div> 
</div>

<div class="row">
<div class="col-sm-6" >
<?= $form->field($model, 'country_id')->dropDownList($countries, [ 'prompt'=>'Select Country'])->label('Country *'); ?>

</div> 
<div class="col-sm-6" >
  <?= $form->field($model, 'state_id')->widget(DepDrop::classname(), [
               'options' => ['id' => 'partneremployee-state_id'],
               'data' => $state_data,
               'type' => DepDrop::TYPE_SELECT2,
               'pluginOptions' => [
                   'depends' => ['partneremployee-country_id'],
                   'placeholder' => 'Select State',
                   'url' => Url::to(['/agency/consultant/dependent-states'])
               ]
               ]); ?>
</div> 
</div> 

 <div class="row">
<div class="col-sm-6" >
  <?= $form->field($model, 'city_id')->widget(DepDrop::classname(), [
               'options' => ['id' => 'city_id'],
               'data' => $city_data,
               'type' => DepDrop::TYPE_SELECT2,
               'pluginOptions' => [
                   'depends' => ['partneremployee-country_id', 'partneremployee-state_id'],
                   'placeholder' => 'Select City',
                   'url' => Url::to(['/agency/consultant/dependent-cities'])
               ]
               ]); ?>
</div> 
<div class="col-sm-6" >
<?= $form->field($model, 'pincode')->textInput() ?>
</div> 
</div>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'description')->textArea(['rows' => 4]) ?>

</div> 
<div class="col-sm-6" style="text-align:justify;">
 




<?php 
	if($model->country_level){
		$model->country_level = explode(',',$model->country_level); 
	}
?>

<?= $form->field($model, 'country_level')->widget(Select2::classname(), [
			'name' => 'country_level',
			'data' => $countries,
			'maintainOrder' => true,
			'options' => ['placeholder' => 'Select Country', 'multiple' => true], ]); ?>
			
<?php 
	if($model->responsible){
		$model->responsible = explode(',',$model->responsible); 
	}
?>			

		<?= $form->field($model, 'responsible')->widget(Select2::classname(), [
			'name' => 'responsible',
			'data' => $countries,
			'maintainOrder' => true,
			'options' => ['placeholder' => 'Select Country', 'multiple' => true], ]); ?>
<?php 
	if($model->degree_level){
		$model->degree_level = explode(',',$model->degree_level); 
	}
?>			
			<?= $form->field($model, 'degree_level')->widget(Select2::classname(), [
			'name' => 'degree_level',
			'data' => $degree_level,
			'maintainOrder' => true,
			'options' => ['placeholder' => 'Select Country', 'multiple' => true], ]); ?>
			
<?php 
	if($model->standard_test){
		$model->standard_test = explode(',',$model->standard_test); 
	}
?>

		<?= $form->field($model, 'standard_test')->widget(Select2::classname(), [
			'name' => 'standard_test',
			'data' => $tests,
			'maintainOrder' => true,
			'options' => ['placeholder' => 'Select Tests', 'multiple' => true], ]); ?>
			

 
 
<?php 
	if(!empty($model->speciality)){
		$model->speciality = explode(',',$model->speciality); 
	}
?>
<?= $form->field($model, 'speciality')->widget(Select2::classname(), [
'name' => 'degrees','data' => $degrees,'maintainOrder' => true,
'options' => ['placeholder' => 'Select Speciality', 'multiple' => true],
'pluginOptions' => ['tags' => true,]
]); ?> 
<div class="row" >
<div class="col-sm-6" >
<?= $form->field($model, 'experience_years')->textInput(['maxlength' => true, 'placeholder' => 'Experience in Years...']) ?>
</div> 
<div class="col-sm-6" >
<?= $form->field($model, 'experience_months')->textInput(['maxlength' => true, 'placeholder' => 'Experience in Months...']) ?>
</div>
</div> 




<div class="row">
<div class="col-sm-6" >
<?= $form->field($model, 'work_hours_start')->widget(TimePicker::classname(),[
'name' => 'work_hours_start', 
'pluginOptions' => [
'autoClose' => true,
 'showSeconds' => false
]
]);?>
</div> 
<div class="col-sm-6" >
<?= $form->field($model, 'work_hours_end')->widget(TimePicker::classname(),[
'name' => 'work_hours_start', 
'pluginOptions' => [
'autoClose' => true,
 'showSeconds' => false
]
]);?></div> 
</div> 
		<?php 
	if(!empty($model->work_days)){
		$model->work_days = explode(',',$model->work_days); 
	}
?>
<?php
 
 echo $form->field($model, 'work_days')->checkboxList($days);
?>
 

<?= $form->field($model, 'skills')->textArea(['rows' => 4]) ?>
</div>
<div class="col-sm-12" >
<div class="form-group">


<?= Html::submitButton(  'Submit', ['class' => 'btn btn btn-primary']) ?>
</div></div>
</div>
<?php ActiveForm::end(); ?>