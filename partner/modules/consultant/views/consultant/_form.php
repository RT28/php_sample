<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\bootstrap\Modal;
use common\models\Country; 
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
 
<?php $form = ActiveForm::begin(['id' => 'counselor-registration-form']) ?>
<div class="row site-signup">
 
<div class="col-sm-8">
<div class="row">
<div class="col-sm-4 pad-right-0">
<?= $form->field($model, 'title')->dropDownList([1 => 'Mr.', 2 => 'Mrs.', 3 => 'Miss.'], ['prompt' => 'Title'])->label(false); ; ?>
   
	</div> 
	  
<div class="col-sm-4 pad-0" >
<?= $form->field($model, 'first_name')->textInput(['placeholder' => 'First Name *'])->label(false);  ?>
</div> 
<div class="col-sm-4 pad-left-0" >
<?= $form->field($model, 'last_name')->textInput(['placeholder' => 'Last Name *', 'maxlength' => true])->label(false);  ?></div> 
</div> 
<div class="row">
<div class="col-sm-6 pad-right-0">
    <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email *','type' => 'email'])->label(false);  ?> 
 </div> 
<div class="col-sm-6 pad-left-0">    
	 	<?= $form->field($model, 'country_id')->widget(Select2::classname(), [
			'name' => 'countries',
			'data' => $countries,
			'maintainOrder' => true,
			'options' => ['placeholder' => 'Select Country', 'multiple' => false], ])->label(false);  ?>
</div> 
</div> 			
			
<div class="row">
<div class="col-sm-6 pad-right-0">
<?= $form->field($model, 'code')->widget(Select2::classname(), [
'name' => 'codelist','data' => $codelist,'maintainOrder' => true,
'options' => ['placeholder' => 'Code (+) *', 'multiple' => false],
'pluginOptions' => ['tags' => true,]
])->label(false);  ?>
</div> 
<div class="col-sm-6 pad-left-0">
<?= $form->field($model, 'mobile')->textInput(['maxlength' => true])->label(false);  ?>
</div> 
</div> 
	 
	<?= $form->field($model, 'description')->textArea(['placeholder' => 'Message *','rows' => 4])->label(false); ?>
    <div class="form-group">
	 <?= $form->field($model, 'agree')->checkbox(['label'=>'I agree to <a  data-toggle="modal" data-target="#terms" onclick="termpopup();" > GTU Terms of Use and Policy</a>'], true)->label(''); ?>
	 
        <?= Html::submitButton(  'Submit', ['class' => 'btn btn btn-blue', 'id' => 'signup-button']) ?>
    </div></div>
	</div>
<?php ActiveForm::end(); ?>

<div id="terms" class="modal fade" role="dialog" >
  <div id="termscontent" class="modal-dialog modal-lg"> 
  </div>
</div>