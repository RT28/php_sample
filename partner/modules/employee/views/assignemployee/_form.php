<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker; 
use common\models\StudentPartneremployeeRelation; 
use common\models\PartnerEmployee;
use common\models\PartnerAssignedworkHistory;
use yii\widgets\Pjax;

$status = PartnerEmployee::Status();  
$parentConsultantId = Yii::$app->user->identity->id; 
/* @var $this yii\web\View */
/* @var $model common\models\StudentPartneremployeeRelation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-consultant-relation-form">
<div class="row">

<?php 
Pjax::begin([
    // Pjax options
]);
 
 $action = '?r=employee/assignemployee/update&id='.$model->id;
 
$action = '?r=consultant/assignemployee/create';
if(!$model->isNewRecord){
	$action = '?r=employee/assignemployee/update&id='.$model->id;
}

$form = ActiveForm::begin(['action' =>  $action, 'id' => 'subconsultant_update']); ?>
  
<?php  if(!$model->isNewRecord){ 
  ?>
<div class="row">
<div class="col-sm-6" > 
<p><strong>Student Name : </strong>  <?= $students[$model->student_id] ?></p>  
 
<p><strong>Start Date : </strong> <?= Yii::$app->formatter->asDate($model->start_date,'php: d M, Y') ?></p> 
<p><strong>End Date : </strong> <?= Yii::$app->formatter->asDate($model->end_date,'php: d M, Y') ?></p> 
</div> 
<div class="col-sm-6" > 
<p><strong>Consultant verification: </strong> <?= $status[$model->assigned_work_status] ?></p> 
<p><strong>Access List : </strong> 
 <?php 
 $accessData= array();
 if(!empty($model->access_list)){ 
	$accessData = explode(',',$model->access_list);
	
} 
?>
 
<?php if(in_array(1, $accessData)){?> Complete Profile, <?php }?>  
<?php if(in_array(2, $accessData)){?>  Document Upload,  <?php }?>  
<?php if(in_array(3, $accessData)){?> Complete Tasks <?php }?> 
  </p> 
<p><strong>Consultant Comments : </strong> <?= $model->comment_by_consultant ?></p>
</div> 
 
</div>
<div class="row">
<div class="col-sm-6" >
<?= $form->field($model, 'comment_by_consultant')->textarea(['rows' => 6])->label('Comments') ?>

</div>
<div class="col-sm-6" >
<?php   
 $status = array(0=>'Pending',1=>'In Progress', 2=>'Complete'); ?>
<?= $form->field($model, "assigned_work_status")->dropDownList($status, ['id'=>'status']) ?>

</div>
</div>
<?php }
  ?>
 
 
<div class="col-sm-12" >
<div class="form-group text-left">
<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
</div> 

<?php ActiveForm::end(); 
Pjax::end();?> 


<?php  
if(!$model->isNewRecord){
$histories = PartnerAssignedworkHistory::find()->where(['AND',['=', 'assignedwork_id', $model->id]])->all();
 
if(!empty($histories)){		
$status = PartnerEmployee::Status();  		
?>

<table class="table table-bordered">
        <th>Comment</th> 
        <th>Status</th>
		<th>Comments by</th>
		<th>Commented At</th> 
        <?php foreach($histories as $history):  ?>
	<tr>

	<td><?= $history->comments; ?></td>
	<td><?= $status[$history->status]; ?></td>
	<td><?= $history->consultant->first_name." ".$history->consultant->last_name; ?></td>
	<td><?= Yii::$app->formatter->asDate($history->created_at,'php: d M, Y H:i:s A'); ?></td> 
	</tr>
        <?php endforeach;?>
    </table>
	<?php
}
}				
?>


</div>
</div>
