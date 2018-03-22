<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\file\FileInput;
use yii\helpers\FileHelper;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\bootstrap\Modal;
use common\models\Country;
use yii\helpers\Url;

$this->title = 'Agency Profile';
$this->context->layout = 'main';


$codelist = Country::getAllCountriesPhoneCode();


$city_data = [];
$state_data = [];
if (isset($model->city_id)) {
	$city_data = [$model->city_id => $model->city->name];
}

if (isset($model->state_id)) {
	$state_data = [$model->state_id => $model->state->name];
}

$initialPreview = [];
$user = $model->partner_login_id;
if (is_dir("./uploads/agency/$user/")) {
	$cover_photo_path = FileHelper::findFiles("./uploads/agency/$user/", [
		'caseSensitive' => true,
		'recursive' => false,
		//'only' => ['profile_photo.*']
	]);       

	if (count($cover_photo_path) > 0) {
		$name =  $model->name;
		$initialPreview = [Html::img($cover_photo_path[0], ['title' => $name, 'class' => 'cover-photo'])];
	}
}
?>
<div class="consultant-index col-xs-12">
    <div class="row">
	
        <h1><?= Html::encode($this->title) ?> </h1> 
        <div class="dashboard-detail">
		
            <?php if(isset($message) && !empty($message)): ?>
                <div class="alert alert-danger" role="alert"><?= $message ?></div>
            <?php endif; ?>
            <?php $form = ActiveForm::begin(['id' => 'consultant-registration-form', 'options' => ['enctype' => 'multipart/form-data']]) ?>
             
				 <div class="row">
				 
<div class="col-sm-6" >
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'establishment_year')->textInput() ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->widget(Select2::classname(), [
'name' => 'codelist','data' => $codelist,'maintainOrder' => true,
'options' => ['placeholder' => 'Code (+) *', 'multiple' => false],
'pluginOptions' => ['tags' => true,]
]) ?>

    <?= $form->field($model, 'mobile')->textInput() ?>

	    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    
	</div> 
<div class="col-sm-6" >
 <?= $form->field($model, 'country_id')->dropDownList($countries, ['id' => 'country_id','prompt'=>'Select Country'])->label('Country'); ?>


  <?= $form->field($model, 'state_id')->widget(DepDrop::classname(), [
               'options' => ['id' => 'state_id'],
               'data' => $state_data,
               'type' => DepDrop::TYPE_SELECT2,
               'pluginOptions' => [
                   'depends' => ['country_id'],
                   'placeholder' => 'Select State',
                   'url' => Url::to(['/agency/dependent-states'])
               ]
               ]); ?>
			   
			   
            <?= $form->field($model, 'city_id')->widget(DepDrop::classname(), [
               'options' => ['id' => 'city_id'],
               'data' => $city_data,
               'type' => DepDrop::TYPE_SELECT2,
               'pluginOptions' => [
                   'depends' => ['country_id', 'state_id'],
                   'placeholder' => 'Select City',
                   'url' => Url::to(['/agency/dependent-cities'])
               ]
               ]); ?>
			   

    <?= $form->field($model, 'pincode')->textInput() ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

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
 
                <div class="form-group">
                    <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'id' => 'btn-update']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
</div>
</div>