<?php 
use yii\helpers\Url;  
use common\models\Tasks;
use common\models\TaskCategory;
use common\models\TaskList; 
use common\models\Student;
use common\models\Consultant;

$timestamp = strtotime($model->created_at); 
$createddate = date('d-m-Y', $timestamp); 

 
  
$studentProfile = Student::find()->where(['=', 'id', $model->student_id])->one();
$studentname =   $studentProfile->first_name." ".$studentProfile->last_name;

if($model->consultant_id!=0){
	$consultantProfile = Consultant::find()->where(['=', 'consultant_id', $model->consultant_id])->one();
	$consultantname =   $consultantProfile->first_name." ".$consultantProfile->last_name;
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
Dear <?= $studentname; ?>,
<br/><br/>  
Please notice that the following task assigned to you by your GoToUniversity
consultant is due on due date.<br/><br/> 
 
<table width="100%" border="2">
<tbody> 
<tr>
<td width="20%"><strong>Created Date</strong></td><td width="80%" colspan="3"><?php echo Yii::$app->formatter->asDate($model->created_at, 'dd-MM-yyyy'); ?> </td> 
</tr>
<tr> 
<td width="20%"><strong>Student Name</strong></td><td width="80%" colspan="3"><?= $studentname; ?></td>
</tr>

<tr>
<td width="20%"><strong>Master Task Category</strong></td><td width="30%"> <?= $catName; ?></td>
<td width="20%"><strong>Standard Task</strong></td><td width="30%"> <?=  $ListName?></td>
</tr>
<?php if($model->task_list_id==2){?>
<tr> 
<td width="20%"><strong>Non Standard Task</strong></td><td width="80%" colspan="3"> <?=  $model->title ?></td>
</tr>
<?php }?>
<tr>
<td width="20%"><strong>People to be Notified </strong></td>
<td width="80%" colspan="3"> <?php 
 $notifiedData= array();
 if(!empty($model->notified)){ 
	$notifiedData = explode(',',$model->notified);
	
} 
?>
Student, Counselor, <?php if(in_array(3, $notifiedData)){?> Parent/Guardian, <?php }?> 
<?php if(in_array(4, $notifiedData)){?> Additional <?php }?>
</td> 
</tr>

<?php if(!empty($model->additional)){?>  
<tr>
<td width="20%"><strong>Additional </strong></td>
<td width="80%" colspan="3">  <?= $model->additional ?></td> 
</tr>
 <?php }?>
 
<tr>
<td width="20%"><strong>Standard Alert</strong></td><td width="30%">1 Day before</td>
<td width="20%"><strong>Specific Alert</strong></td><td width="30%"><?php if(!empty($model->specific_alert)){
echo $alerts[$model->specific_alert];
} ?></td>
</tr>

<tr>
<td width="20%"><strong>Responsibility</strong></td><td width="30%"> <?= $TaskResponsbility[$model->responsibility]; ?></td>
<td width="20%"><strong>Others</strong></td><td width="30%"><?= $model->others ?></td>
</tr>

<tr>
<td width="20%"><strong>Deadline</strong></td><td width="30%"> <?php echo Yii::$app->formatter->asDate($model->due_date, 'dd-MM-yyyy'); ?></td>
<td width="20%"><strong>Action</strong></td><td width="30%"><?= $TaskActions[$model->action]; ?></td>
</tr>

<tr>
<td width="20%"><strong>Counselor Verification</strong></td><td width="30%"><?= $actions[$model->verifybycounselor]; ?></td>
<td width="20%"><strong>Status</strong></td><td width="30%"><?= $TaskStatus[$model->status]; ?></td>
</tr>

<tr>
<td width="20%"><strong>Description</strong></td><td width="80%" colspan="3"><?=  $model->description ?></td>
 </tr>
<tr> 
<td width="20%"><strong>Comments</strong></td><td width="80%" colspan="3"><?=  $model->comments ?></td>
</tr>

</tbody> 
</table>
 
 
 Please complete the task before the deadline to complete the application process on
time. <a href="<?=Url::to('site/index', true)?>">Click here to visit your student dashboard for further details. </a>


<br/><br/> 
Regards,<br/>
GoToUniversity Team
