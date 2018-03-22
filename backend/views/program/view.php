<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor; 
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;

$this->registerJsFile('@web/js/programs.js');
$this->registerJsFile('@web/libs/select2/select2.full.min.js');
$this->registerCssFile('@web/libs/select2/select2.min.css');
 
 

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Programs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="university-course-list-create">
 <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">
    <h1><?= Html::encode($this->title) ?></h1>

<div class="university-course-list-form">

<div class="row">
<div class="col-sm-6" >
    <?php $form = ActiveForm::begin(); ?>
 
	<?= $form->field($model, 'name')->textInput(['maxlength' => true,'readonly' => true]) ?>
	 
	<?= $form->field($model, "university_id")->dropDownList($university, ['prompt' => 'Select University','readonly' => true],['readonly' => true]) ?>
<?= $form->field($model, "degree_id")->dropDownList($degree, ['prompt' => 'Select Discipline','id'=>'degree_id','readonly' => true],['readonly' => true]) ?>
<?php
	$major = [];
	if(!empty($model->degree_id)) {
		$temp = $model->degree->majors;
		if(!empty($temp)) {
			$major = ArrayHelper::map($temp, 'id', 'name');
		}
	}
?>

 

  <?= $form->field($model, "major_id")->dropDownList($major,['readonly' => true]) ?> 
    
    <?= $form->field($model, "degree_level_id")->dropDownList($degreeLevels,['readonly' => true]) ?> 
    
 
	<?php 
	 /******* updated multiple select functionality *****/
	 $standard_test_list= explode(",",$model->standard_test_list);
	 ?>
		<div class="form-group field-universitycourselist-standard_test_list">
		<label class="control-label" for="universitycourselist-standard_test_list">Standard Test List</label>
			<select id="universitycourselist-standard_test_list" class="form-control" name="UniversityCourseList[standard_test_list][]" selected="selected" multiple="multiple" readonly="readonly" size="4">
			<option value="">Select</option>
			<?php foreach($standardTests as $key => $getres):?>
			<option value="<?php echo $key?>" <?php if(in_array($key, $standard_test_list)){?> selected="selected"<?php }?> ><?php echo $getres?></option>
			<?php
			endforeach;
			?>
			</select>
		<div class="help-block"></div>
		</div>
	  
	
	
	
    <?= $form->field($model, 'duration')->textInput(['maxlength' => true,'readonly' => true]) ?>
 
	<?= $form->field($model, "duration_type")->dropDownList($durationType,['readonly' => true]) ?>


	 </div>
<div class="col-sm-6" >
    <?= $form->field($model, 'intake')->textInput(['readonly' => true]) ?>
 
	  <?= $form->field($model, "language")->dropDownList($languages,['readonly' => true]) ?>
    <?= $form->field($model, 'fees')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'fees_international_students')->textInput(['readonly' => true]) ?>
 
	 <?= $form->field($model, "type")->dropDownList($courseType,['readonly' => true]) ?>
 
    <?= $form->field($model, 'application_fees')->textInput(['readonly' => true]) ?>

    <?= $form->field($model, 'application_fees_international')->textInput(['readonly' => true]) ?>

    
</div>

<div class="col-sm-12" >
 
 
	<?= $form->field($model, 'program_website')->textInput(['maxlength' => true,'readonly' => true]) ?>  
 
		
		 <?= Html::activeLabel($model, 'careers'); ?>
        <?php 
        echo '<br><br>';
        echo  strip_tags($model->careers);
        echo '<br><br>';
        ?>
		
		 <?= Html::activeLabel($model, 'eligibility_criteria'); ?>
        <?php 
        echo '<br><br>';
        echo  strip_tags($model->eligibility_criteria);
        echo '<br><br>';
        ?>
		  <?= Html::activeLabel($model, 'description'); ?>
        <?php 
        echo '<br><br>';
        echo  strip_tags($model->description);
        echo '<br><br>';
        ?>
		
	</div></div> 
	<br>
	<br>
	<br>
	<br>
    <?php ActiveForm::end(); ?>

</div>

</div>
</div>
</div>
</div>