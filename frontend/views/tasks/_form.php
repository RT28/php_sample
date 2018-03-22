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
use common\models\TaskList;
use common\models\Tasks;
use common\models\TaskCategory; 
use common\models\Student;


$this->registerJsFile('@web/js/tasks.js');
$this->registerJsFile('@web/libs/select2/select2.full.min.js');
$this->registerCssFile('@web/libs/select2/select2.min.css');
 
?>

<?php   
$timestamp = strtotime($model->created_at); 
$createddate = date('d-M-Y', $timestamp); 

$due_date = strtotime($model->due_date); 
$deadline = date('d-M-Y', $due_date);
  
$studentProfile = Student::find()->where(['=', 'id', $model->student_id])->one();
$studentname = $studentProfile->id . ' - '. $studentProfile->first_name." ".$studentProfile->last_name;

$catName = '';
$masterCategory = TaskCategory::find()->where(['=', 'id', $model->task_category_id])->one();
if(!empty($masterCategory)){
	$catName = $masterCategory->name;
}

$ListName = '';
$taskList = TaskList::find()->where(['=', 'id', $model->task_list_id])->one();
if(!empty($taskList)){
	$ListName = $taskList->name;
}	

$TaskStatus = Tasks::TaskStatus(); 
$actions = Tasks::TaskVerificationByCounselor(); 			
$TaskActions = Tasks::TaskActions();
$TaskResponsbility = Tasks::TaskResponsbility();
$alerts = Tasks::TaskSpecificAlert();  

 ?>
 
<div class="student-tasks-form ">  

 
     <?php $form = ActiveForm::begin(['id'=>'student-tasks-active-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
		 <div>
		 
<div class="row ">
<div class="col-sm-6" > 
<p><strong>Date :</strong> 
<?= $createddate;?>
</p> 
<p><strong>Master Task Category:</strong> <?= $catName; ?></p>
<p><strong>Standard Task:</strong> <?=  $ListName?></p>
<?php if($model->task_list_id==2){?>
<p><strong>Non Standard Task:</strong> <?=  $model->title ?></p>
<?php }?>
 
<?php if(!empty($model->additional)){ ?>
<p><strong>Additional:</strong> <?= $model->additional ?></p> 
<?php } ?>
<p><strong>Description:</strong> <br/><?=  $model->description ?></p>
<p><strong>Comment:</strong> <br/><?=  $model->comments ?></p>

</div>
<div class="col-sm-6">
 
<p><strong>Responsibility:</strong> <?= $TaskResponsbility[$model->responsibility]; ?></p>
<p><strong>Others:</strong> <?= $model->others ?></p>
<p><strong>Deadline:</strong> <?= $deadline; ?></p>
<p><strong>Action:</strong> <?= $TaskActions[$model->action]; ?></p>
<p><strong>Counselor Verification:</strong> <?= $actions[$model->verifybycounselor]; ?></p>
<p><strong>Status:</strong> <?= $TaskStatus[$model->status]; ?></p>
</div>

</div>
<?php if($model->verifybycounselor!=2){ ?>
	 <div class="col-xs-6 col-sm-6"> 
	 <?= $form->field($model, "action")->dropDownList($TaskActions, ['prompt' => 'Select Action']) ?>
 
	<?= $form->field($model, 'comments')->textarea(['rows' => 5]) ?>
	   
	 </div>
	  </div>  
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
<?php }?>
<?php ActiveForm::end(); ?>

</div> 



