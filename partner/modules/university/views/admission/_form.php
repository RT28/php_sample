<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm; 
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use kartik\file\FileInput;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\UniversityAdmission */
/* @var $form yii\widgets\ActiveForm */

  
$this->registerJsFile('@web/libs/select2/select2.full.min.js');
$this->registerCssFile('@web/libs/select2/select2.min.css');
?>
 

<div class="university-admission-form">

    <?php $form = ActiveForm::begin(); ?>
 
    <?= $form->field($model, "degree_level_id")->dropDownList($degreeLevels, ['prompt' => 'Select Degree Level','id'=>'degree_level_id']) ?> 
  
	<?php echo Html::hiddenInput('input-type-1', 'Additional value 1', ['id'=>'input-type-1']) ?>
	
	<?php  if($model->isNewRecord){ ?>
	<?= $form->field($model, 'course_id')->widget(DepDrop::classname(), [
	'type'=>DepDrop::TYPE_SELECT2,
	'options'=>['id'=>'course_id'], 
	'pluginOptions'=>[
	'depends'=>['degree_level_id'], // the id for cat attribute
	'placeholder'=>'------Select Program-----',
	//'url'=>  \yii\helpers\Url::to(['subcat']),
	'url'=>Url::to(['/university/admission/subcat'])
	]
	]); 
	}else{ ?>
	<?= $form->field($model, 'course_id')->widget(DepDrop::classname(), [
	'data' =>$programs,
	'type'=>DepDrop::TYPE_SELECT2,
	'options'=>['id'=>'course_id','placeholder'=>'------Select Program-----'], 
	'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
	'pluginOptions'=>[
	'depends'=>['degree_level_id'], 
	//'url'=>  \yii\helpers\Url::to(['subcat']),
	'url'=>Url::to(['/university/admission/subcat'])
	]
	]); ?>
	<?php } ?>


	<?php echo $form->field($model, 'start_date')->widget(DatePicker::classname(),[
				'name' => 'start_date',
				//'value' => date('d-M-Y', strtotime('+2 days')),
				'options' => ['placeholder' => 'Select Start Date'],
				'pluginOptions' => [
				'format' => 'yyyy-m-d',
				'todayHighlight' => true
				]
			]); 
		?> 
	
	
	<?php echo $form->field($model, 'end_date')->widget(DatePicker::classname(),[
				'name' => 'end_date',
				//'value' => date('d-M-Y', strtotime('+2 days')),
				'options' => ['placeholder' => 'Select End Date'],
				'pluginOptions' => [
				'format' => 'yyyy-m-d',
				'todayHighlight' => true
				]
			]); 
		?>
 
    <?= $form->field($model, "intake")->dropDownList($intake) ?> 

   
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>

</script>