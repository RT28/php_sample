<?php 
use yii\helpers\Url; 
 
use common\models\Tasks;
$studentname = $student->first_name ." ".$student->last_name ;
$TaskStatus = Tasks::TaskStatus(); 
 ?>
Dear <?= $studentname ?>,
<br/><br/>

Your GoToUniversity consultant has created the following task/tasks for you to
complete:<br/><br/>
 
<table align="left" width="100%" cellpadding="0" cellspacing="0" border="0" style="padding: 10px 0;">
<tbody>
<tr>
<td  > 

<table align="left"  width="100%" cellpadding="0" cellspacing="0" border="0"  >
<thead >
<tr>
<th align="left" style="margin-bottom: 10px;"><b>Assigned Date</b></th>
<th align="left" style="margin-bottom: 10px;"><b>Task Name</b></th>
<th align="left" style="margin-bottom: 10px;"><b>Deadline</b></th>
<th align="left" style="margin-bottom: 10px;"><b>Status</b></th>
</tr>
</thead>
<tbody style="padding: 10px 0 10px 0;">  
<?php foreach($tasks as $task){ ?>
<tr >
<td> 
<?php echo Yii::$app->formatter->asDate($task->created_at, 'dd-MM-yyyy'); ?> 
</td> 
<td>  <?= $task->title;?>  </td> 
<td> <?php echo Yii::$app->formatter->asDate($task->due_date, 'dd-MM-yyyy'); ?> 
</td> 
<td> <?= $TaskStatus[$task->status]; ?>  </td> 
</tr>  
<?php }?> 
</tbody> 
</table>
  
</td> 
</tr>
</tbody>
</table>

<a href="<?=Url::to('site/index', true)?>"> Please click here to visit your student dashboard for further details. </a>
  
<br/>  
Regards,<br/>
GoToUniversity Team
