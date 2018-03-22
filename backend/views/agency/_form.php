<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use kartik\date\DatePicker;
use yii\bootstrap\Modal;
use common\models\Country;
use yii\helpers\Url;

use common\components\Status;
$status = Status::getActiveInactiveStatus();

$codelist = Country::getAllCountriesPhoneCode();

  
    $city_data = [];
    $state_data = [];
    if (isset($model->city_id)) {
        $city_data = [$model->city_id => $model->city->name];
    }

    if (isset($model->state_id)) {
        $state_data = [$model->state_id => $model->state->name];
    }
	
   
	
?>

<div class="agency-form">

	
<?php if(isset($message) && strpos($message, 'Error') !== false): ?>
    <div class="alert alert-danger" role="alert"><?= $message ?></div>
<?php endif; ?>

<?php if(isset($message) && strpos($message, 'Success') !== false): ?>
    <div class="alert alert-success" role="alert"><?= $message ?></div>
<?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>
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
<?php if(!$model->isNewRecord){ ?>
 <?= $form->field($model, "status")->dropDownList($status) ?> 
<?php } ?>
 
	</div> 	</div>    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
