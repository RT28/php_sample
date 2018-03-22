<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use kartik\date\DatePicker;
use kartik\time\TimePicker;
use kartik\file\FileInput;
use yii\helpers\FileHelper;  
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

$this->title = 'Profile';
$this->context->layout = 'main';
?> 
<div class="consultant-index col-xs-11">
    <div class="row">
        <div class="dashboard-detail">
            <?php if(isset($message) && !empty($message)): ?>
                <div class="alert alert-danger" role="alert"><?= $message ?></div>
            <?php endif; ?>
            <?php $form = ActiveForm::begin(['id' => 'consultant-registration-form', 'options' => ['enctype' => 'multipart/form-data']]) ?>
              
 
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
<?= $form->field($model, 'country_id')->dropDownList($countries, ['id' => 'country_id','prompt'=>'Select Country'])->label('Country *'); ?>

</div> 
<div class="col-sm-6" >
  <?= $form->field($model, 'state_id')->widget(DepDrop::classname(), [
               'options' => ['id' => 'state_id'],
               'data' => $state_data,
               'type' => DepDrop::TYPE_SELECT2,
               'pluginOptions' => [
                   'depends' => ['country_id'],
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
                   'depends' => ['country_id', 'state_id'],
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
 
			
<?php 
	if($model->standard_test){
		$model->standard_test = explode(',',$model->standard_test); 
	}
?>

 
			

 
<?php 
	if($model->speciality){
		$model->speciality = explode(',',$model->speciality); 
	}
?>
<?= $form->field($model, 'speciality')->widget(Select2::classname(), [
'name' => 'degrees','data' => $degrees,'maintainOrder' => true,
'options' => ['placeholder' => 'Select Speciality', 'multiple' => true],
'pluginOptions' => ['tags' => true,]
]); ?>


<?php 
  
	if(!empty($model->languages)){  
		$model->languages = explode(',',$model->languages); 
	}
 	
?>

<?= $form->field($model, 'languages')->widget(Select2::classname(), [
'name' => 'languages','data' => $languages,'maintainOrder' => true,
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
	if($model->work_days){
		$model->work_days = explode(',',$model->work_days); 
	} 
 echo $form->field($model, 'work_days')->checkboxList($days);
?>






<?= $form->field($model, 'skills')->textArea(['rows' => 4]) ?>
</div>
<div class="row" >
<div class="col-sm-12" >
	<div class="form-group">
		<?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'id' => 'btn-update']) ?>
	</div>
</div>
</div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>