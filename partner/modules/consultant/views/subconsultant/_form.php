<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker; 
use common\components\Commondata; 
use common\models\Consultant;  
use common\models\ConsultantAssignedworkHistory;
use common\models\AccessList;
use yii\widgets\Pjax;
$status = Consultant::Status(); 
$list = AccessList::getAllAccessLIst();

$parentConsultantId = Yii::$app->user->identity->id; 


   
 
?>

<div class="student-consultant-relation-form">
<div class="row">

<?php 
Pjax::begin([
    // Pjax options
]);
$action = '?r=consultant/subconsultant/create';
if(!$model->isNewRecord){
	$action = '?r=consultant/subconsultant/update&id='.$model->id;
}

$form = ActiveForm::begin(['action' =>  $action, 'id' => 'subconsultant_update']); ?>

<?php  if($model->isNewRecord){ ?>

<div class="row">
<div class="col-sm-6" >
<?php
 
if(!empty($student_id) && isset($students[$student_id])){?>
<label class="control-label" for="task_category_id">Student Name</label><br/>
<?php 	 
echo  $students[$student_id];
$model->student_id = $student_id;
?>
<?= $form->field($model, "student_id")->hiddenInput()->label(false); ?>

<?php }else{ ?>
<?= $form->field($model, "student_id")->dropDownList($students, ['prompt' => 'Select Student']) ?>
<?php }?>

<?= $form->field($model, "consultant_id")->dropDownList($Subconsultants, ['prompt' => 'Select Sub  Consultant'])
->label('Sub Consultant')	?>
<?= $form->field($model, 'comment_by_consultant')->textarea(['rows' => 6])->label('Comments') ?>

</div> 
<div class="col-sm-6" >
   
<?php  
if($model->access_list){
	$model->access_list = explode(',',$model->access_list); 
}  
?> 
	
<?= $form->field($model, 'access_list')->widget(Select2::classname(), [
'name' => 'access_list', 'data' => $list, 'maintainOrder' => true,
'options' => ['placeholder' => 'Select Access List', 'multiple' => true], ]); ?>
			
 

<div class="row" >
<div class="col-sm-6" >
<?= $form->field($model, 'start_date')->widget(DatePicker::classname(),[
'name' => 'due_date',
'type' => DatePicker::TYPE_INPUT,
'pluginOptions' => [
'autoClose' => true,
'format' => 'yyyy-mm-dd',
'value' =>null,
'todayHighlight' => true, 

]
]);?>

</div> 
<div class="col-sm-6" >
<?= $form->field($model, 'end_date')->widget(DatePicker::classname(),[
'name' => 'due_date',
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
  
</div>
</div>


  
<?php



}
?>

<?php
if($model->parent_consultant_id==$parentConsultantId){ ?>
<div class="row">
<div class="col-sm-6" >
<?php 
if(!empty($model->student_id) && isset($students[$model->student_id])){?>
 
<p><strong>Student : </strong>  <?= $students[$model->student_id] ?></p>  
 
<?php } ?> 

<?php 
if(!empty($model->consultant_id) && isset($Subconsultants[$model->consultant_id])){?>
 
<p><strong>Associate Consultant : </strong>  <?= $Subconsultants[$model->consultant_id] ?></p>  
 
<?php } ?> 
 
<?= $form->field($model, 'comment_by_consultant')->textarea(['rows' => 6])->label('Comments') ?>

</div> 
<div class="col-sm-6" >

<div class="form-group field-tasks-notified required"> 

<?php  
if($model->access_list){
	$model->access_list = explode(',',$model->access_list); 
}  
?> 
 
<?= $form->field($model, 'access_list')->widget(Select2::classname(), [
'name' => 'access_list', 'data' => $list, 'maintainOrder' => true,
'options' => ['placeholder' => 'Select Access List', 'multiple' => true], ]); ?>
	  
<div class="row" >
<div class="col-sm-6" >
<?= $form->field($model, 'start_date')->widget(DatePicker::classname(),[
'name' => 'due_date',
'type' => DatePicker::TYPE_INPUT,
'pluginOptions' => [
'autoClose' => true,
'format' => 'yyyy-mm-dd',
'value' =>null,
'todayHighlight' => true, 

]
]);?>

</div> 
<div class="col-sm-6" >
<?= $form->field($model, 'end_date')->widget(DatePicker::classname(),[
'name' => 'due_date',
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
 
</div>
 
<?php   
if($model->assigned_work_status==2){ 
$status = array(3=>'Approve', 4=>'Reject'); ?>
<?= $form->field($model, "assigned_work_status")->dropDownList($status, ['id'=>'status']) ?>
 
 <?php }
 ?>
</div>
</div> 
  
<?php }
 ?>

<?php  if(!$model->isNewRecord){ 
if($model->parent_consultant_id!=$parentConsultantId){ ?>
<div class="row">
<div class="col-sm-6" > 
<p><strong>Student Name : </strong>  <?= $students[$model->student_id] ?></p>  
 
<p><strong>Start Date : </strong> <?= Yii::$app->formatter->asDate($model->start_date,'php: d M, Y') ?></p> 
<p><strong>End Date : </strong> <?= Yii::$app->formatter->asDate($model->end_date,'php: d M, Y') ?></p> 
</div> 
<div class="col-sm-6" > 
<p><strong>Work Status : </strong> <?= $status[$model->assigned_work_status] ?></p> 
<p> 

<?php  
if($model->access_list){
	$model->access_list = explode(',',$model->access_list); 
}  
?> 
 
<?= $form->field($model, 'access_list')->widget(Select2::classname(), [
'name' => 'access_list', 'data' => $list, 'maintainOrder' => true,
'options' => ['placeholder' => 'Select Access List', 'multiple' => true], ]); ?>
 
 
  </p> 
 
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
} ?>
 
  
<div class="col-sm-12" >
<div class="form-group text-left">
<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
</div> 

<?php ActiveForm::end(); 
Pjax::end();?> 
<?php  
if(!$model->isNewRecord){
$histories = ConsultantAssignedworkHistory::find()->where(['AND',['=', 'assignedwork_id', $model->id]])->all();
 
if(!empty($histories)){		
$status = Consultant::Status();  		
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
	<td><?php 
echo 	$history->consultant->first_name." ".$history->consultant->last_name; 
?></td>
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

 