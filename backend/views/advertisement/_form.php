<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm; 
use yii\helpers\FileHelper;
use kartik\file\FileInput; 
use yii\helpers\Url; 
use yii\helpers\Json;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Advertisement */
/* @var $form yii\widgets\ActiveForm */

$status = array(0=>'Inactive',1=>'Active');
   $initialPreview = [];
   
if (is_dir("./../../backend/web/uploads/advertisements/$model->id/")) {
	$logo_path = FileHelper::findFiles("./../../backend/web/uploads/advertisements/$model->id/", [
		'caseSensitive' => true,
		'recursive' => false,
		//'only' => ['logo.*']
	]);       

	if (count($logo_path) > 0) {
		$initialPreview = [Html::img($logo_path[0], ['title' => $model->id])];
	}
}  

$pages = array('home'=>'Home','programfinder'=>'Program Finder','university'=>'University','university_detail'=>'University Detail','package'=>'Package','aboutus'=>'About Us','contactus'=>'Contact Us','signup'=>'Sign Up','consultant'=>'Consultant');

$sections = array('top'=>'Top','bottom'=>'Bottom','left'=>'Left','right'=>'Right','between'=>'Between');


?>

<div class="advertisement-form">
 
   <?php $form = ActiveForm::begin(['id'=>'advertisement-active-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
    
	<div class="row">
    <div class="col-xs-6 col-sm-6">
	<?= $form->field($model, 'pagename')->dropDownList($pages); ?>
	<?= $form->field($model, 'imagetitle')->textInput(['maxlength' => true])->label('Advertisement Title') ?>
	<?= $form->field($model, 'redirectlink')->textInput(['maxlength' => true])->label('Redirect Link') ?>	
 <?= $form->field($model, "status")->dropDownList($status) ?> 
	
	
	<?= $form->field($model, 'section')->dropDownList($sections)->label('Sections (Top)'); ?>
	
	</div>
    <div class="col-xs-6 col-sm-6">
 
	 <div class="row">
	 <div class="col-xs-6 col-sm-6">
	 <?= $form->field($model, 'height')->textInput(['maxlength' => true])->label('Height (150px)') ?>
	 </div>
	  <div class="col-xs-6 col-sm-6">
	  <?= $form->field($model, 'width')->textInput(['maxlength' => true])->label('Width (150px)') ?>
	  </div>
	  </div>
	 
  <div class="row">
  
	 <div class="col-xs-6 col-sm-6">
	  <?= $form->field($model, 'startdate')->widget(DatePicker::classname(),[
        'name' => 'startdate',
            'type' => DatePicker::TYPE_INPUT,
            'pluginOptions' => [
            'autoClose' => true,
            'format' => 'yyyy-mm-dd',
			'value' =>null,
			 'todayHighlight' => true, 
			   
        ]
    ]);?>
	 </div>
	  <div class="col-xs-6 col-sm-6">
	   <?= $form->field($model, 'enddate')->widget(DatePicker::classname(),[
        'name' => 'enddate',
            'type' => DatePicker::TYPE_INPUT,
            'pluginOptions' => [
            'autoClose' => true,
            'format' => 'yyyy-mm-dd',
			'value' =>null,
			 'todayHighlight' => true, 
        ]
    ]);?>
	  </div>
	 
	  </div> 
	 <?= $form->field($model, 'rank')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'timing')->textInput(['maxlength' => true],['placeHolder'=>'Time'])->label('Time (In Seconds)'); ?>
	
 <?= $form->field($model, 'position')->textInput(['maxlength' => true])->label('Position') ?>
   

	</div>
		</div>
			<div class="row">
			<div class="col-xs-12">
			<?= $form->field($model, 'advertisementcode')->textarea(['rows' => 6]) ?>
			
			<?= $form->field($upload, 'imageadvert')->widget(FileInput::classname(), [
					'options' => [
						'accept' => 'image/*'
					],
					'pluginOptions' => [
						'showUpload' => false,
						'showPreview' => true,
						'intialPreviewAsData' => true,
						'resizeImages' => true,
					   // 'minImageWidth' => 1350,
						'initialPreview' => $initialPreview,
					  //  'minImageHeight' => 650,
					] 
				]); 
			?>

			
			</div>
			</div>
		
			
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
