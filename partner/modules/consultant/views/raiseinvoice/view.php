<?php

use yii\helpers\Html;
use yii\widgets\DetailView; 
use common\models\Tasks;
use common\models\TaskCategory;
use common\models\TaskList; 
use common\models\Student; 

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Task', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'main';
?>
<?php   
$timestamp = strtotime($model->created_at); 
$createddate = date('d-m-Y', $timestamp); 

$due_date = strtotime($model->due_date); 
$deadline = date('d-m-Y', $due_date);
  
$studentProfile = Student::find()->where(['=', 'id', $model->student_id])->one();
$studentname =  $studentProfile->first_name." ".$studentProfile->last_name;

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
<div class="university-course-list-view">

<div class="row">
<div class="col-sm-11">
 <h1><?= Html::encode($this->title) ?></h1>
</div> 
</div>
	<div class="row">
<div class="col-sm-6" > 
<p><strong>Date :</strong> 
<?= $createddate;?>
</p> 
<p><strong>Student Name:</strong> <?= $studentname; ?></p>
<p><strong>Master Task Category:</strong> <?= $catName; ?></p>
<p><strong>Standard Task:</strong> <?=  $ListName?></p>
<?php if($model->task_list_id==2){?>
<p><strong>Non Standard Task:</strong> <?=  $model->title ?></p>
<?php }?>
<p><strong>People to be Notified:</strong>
 <?php 
 $notifiedData= array();
 if(!empty($model->notified)){ 
	$notifiedData = explode(',',$model->notified);
	
} 
?>
Student, Counselor, <?php if(in_array(3, $notifiedData)){?> Parent/Guardian, <?php }?> 
<?php if(in_array(4, $notifiedData)){?> Additional<?php }?> 
</p>
<p><strong>Additional:</strong> <?= $model->additional ?></p> 

	</div>
<div class="col-sm-6">
	 
<p><strong>Standard Alert:</strong>  1 Day before</p>	
<p><strong>Specific Alert:</strong> <?php if(!empty($model->specific_alert)){
						
					 echo $alerts[$model->specific_alert];
                } ?></p>
<p><strong>Responsibility:</strong> <?= $TaskResponsbility[$model->responsibility]; ?></p>
<p><strong>Others:</strong> <?= $model->others ?></p>
<p><strong>Deadline:</strong> <?= $deadline; ?></p>
<p><strong>Action:</strong> <?= $TaskActions[$model->action]; ?></p>
<p><strong>Counselor Verification:</strong> <?= $actions[$model->verifybycounselor]; ?></p>
<p><strong>Status:</strong> <?= $TaskStatus[$model->status]; ?></p>
     </div>
<div class="col-sm-12">
<p><strong>Description:</strong> <br/><?=  $model->description ?></p>
<p><strong>Comment:</strong> <br/><?=  $model->comments ?></p>
		 
</div>
</div>
</div>
 
</div>
</div>