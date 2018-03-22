<?php 

use common\models\Tasks;
use common\models\TaskCategory;
use common\models\TaskList; 
use common\models\Student;
use common\models\Consultant; 

$timestamp = strtotime($model->created_at); 
$createddate = date('d-m-Y', $timestamp); 

$due_date = strtotime($model->due_date); 
$deadline = date('d-m-Y', $due_date);
  
$studentProfile = Student::find()->where(['=', 'id', $model->student_id])->one();
$studentname =   $studentProfile->first_name." ".$studentProfile->last_name;

$gtuUser = 'GTU Team';

if($model->consultant_id!=0){
	$consultantProfile = Consultant::find()->where(['=', 'id', $model->consultant_id])->one();
	$consultantname =    $consultantProfile->first_name." ".$consultantProfile->last_name;
	$gtuUser = $consultantname;
}

 
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


Hi <?= $gtuUser ?>,
<br/><br/>

Task has been updated by <?= $studentname; ?>.

<div class="row">
<div class="col-sm-11">
 <h1><?= $this->title?></h1>
</div> 
</div>
	<div class="row">
<div class="col-sm-6" > 
<p><strong>Date :</strong> 
<?= $createddate;?>
</p>  
<p><strong>Master Task Category:</strong> <?= $catName; ?></p>
<p><strong>Standard Task:</strong> <?=  $ListName?></p>
<?php if($model->task_list_id==2){?>
<p><strong>Non Standard Task:</strong> <?=  $model->title ?></p>
<?php }?>  
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
<br/><br/> 
Regards,<br/>
<?= $studentname; ?>
