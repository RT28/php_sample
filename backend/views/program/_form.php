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

?>

<div class="university-course-list-form">

<div class="row">
<div class="col-sm-6" >
    <?php $form = ActiveForm::begin(); ?>
 
	<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	 
	<?= $form->field($model, "university_id")->dropDownList($university, ['prompt' => 'Select University']) ?>
<?= $form->field($model, "degree_id")->dropDownList($degree, ['prompt' => 'Select Discipline','id'=>'degree_id']) ?>
<?php
	$major = [];
	if(!empty($model->degree_id)) {
		$temp = $model->degree->majors;
		if(!empty($temp)) {
			$major = ArrayHelper::map($temp, 'id', 'name');
		}
	}
?>


                        <?php  if($model->isNewRecord){ ?>
                            <?= $form->field($model, 'major_id')->widget(DepDrop::classname(), [
                                'type'=>DepDrop::TYPE_SELECT2,
                                'options'=>['id'=>'major_id'], 
                                'pluginOptions'=>[
                                'depends'=>['degree_id'], // the id for cat attribute
                                'placeholder'=>'------Select Sub Discipline-----',
                                'url'=>  \yii\helpers\Url::to(['subcat'])
                                ]
                                ]); 
                            }else{ ?>
                            <?= $form->field($model, 'major_id')->widget(DepDrop::classname(), [
                                'data' => $major,
                                'type'=>DepDrop::TYPE_SELECT2,
                                'options'=>['id'=>'major_id','placeholder'=>'------Select Sub Discipline-----'], 
                                'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                'pluginOptions'=>[
                                    'depends'=>['degree_id'], 
                                    'url'=>  \yii\helpers\Url::to(['subcat']),
                                ]
                            ]); ?>
                            <?php } ?>

  
    <?= $form->field($model, "degree_level_id")->dropDownList($degreeLevels) ?> 
    
 <?php $id = isset($_GET['id']);
	if($id!=""){
	 /******* updated multiple select functionality *****/
	 $standard_test_list= explode(",",$model->standard_test_list);
	 ?>
		<div class="form-group field-universitycourselist-standard_test_list">
		<label class="control-label" for="universitycourselist-standard_test_list">Standard Test List</label>
			<select id="universitycourselist-standard_test_list" class="form-control" name="UniversityCourseList[standard_test_list][]" selected="selected" multiple="multiple" size="4">
			<option value="">Select</option>
			<?php foreach($standardTests as $key => $getres):?>
			<option value="<?php echo $key?>" <?php if(in_array($key, $standard_test_list)){?> selected="selected"<?php }?> ><?php echo $getres?></option>
			<?php
			endforeach;
			?>
			</select>
		<div class="help-block"></div>
		</div>
	  <?php }else {?>
	<?= $form->field($model, "standard_test_list")->dropDownList($standardTests,['multiple' => 'true','selected' => 'selected']);
	  } ?>
	 
    <?= $form->field($model, 'duration')->textInput(['maxlength' => true]) ?>
 
	<?= $form->field($model, "duration_type")->dropDownList($durationType) ?>


	 </div>
<div class="col-sm-6" >
    <?= $form->field($model, 'intake')->textInput() ?>
 
	  <?= $form->field($model, "language")->dropDownList($languages) ?>
    <?= $form->field($model, 'fees')->textInput() ?>

    <?= $form->field($model, 'fees_international_students')->textInput() ?>
 
	 <?= $form->field($model, "type")->dropDownList($courseType) ?>
 
    <?= $form->field($model, 'application_fees')->textInput() ?>

    <?= $form->field($model, 'application_fees_international')->textInput() ?>

    
</div>

<div class="col-sm-12" >
 
 
	<?= $form->field($model, 'program_website')->textInput(['maxlength' => true]) ?>  
	<?= $form->field($model, 'careers')->widget(CKEditor::className(), [
            'options' => ['rows' => 5],
            'preset' => 'basic'
        ]) ?>
		<?= $form->field($model, 'eligibility_criteria')->widget(CKEditor::className(), [
            'options' => ['rows' => 5],
            'preset' => 'basic'
        ]) ?>
<?= $form->field($model, 'description')->widget(CKEditor::className(), [
            'options' => ['rows' => 10],
            'preset' => 'basic'
        ]) ?>
	</div></div>
	<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
	<br>
	<br>
	<br>
	<br>
    <?php ActiveForm::end(); ?>

</div>
