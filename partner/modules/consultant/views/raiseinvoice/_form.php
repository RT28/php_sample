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
use kartik\datetime\DateTimePicker;
use common\models\TaskList;
use yii\widgets\Pjax;
use common\models\Tasks;
use common\models\TaskCategory; 
use common\models\Student;
 
$this->registerJsFile('@web/libs/select2/select2.full.min.js');
$this->registerCssFile('@web/libs/select2/select2.min.css');

 
?>
<?php   
if(!$model->isNewRecord){
$timestamp = strtotime($model->created_at); 
$createddate = date('d-m-Y', $timestamp); 

$due_date = strtotime($model->due_date); 
$deadline = date('d-m-Y', $due_date);

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
}
?>
<div class="student-tasks-form">

<?php
Pjax::begin([
// Pjax options
]);
$form = ActiveForm::begin(['id'=>'student-tasks-active-form',
'validateOnSubmit' => true,
'enableAjaxValidation' => true,
'options' => ['enctype' => 'multipart/form-data']]); ?>


<div class="row">


<div class="col-xs-6 col-sm-6"> 

<?php     
if(!empty($student_id)){?>
<label class="control-label" for="task_category_id">Student Name</label><br/>
<?php 	 
echo  $students[$student_id];
$model->student_id = $student_id;
?>
<?= $form->field($model, "student_id")->hiddenInput()->label(false); ?>

<?php }else{ ?>
<?= $form->field($model, "student_id")->dropDownList($students, ['prompt' => 'Select Students']) ?>
<?php }?>

<?= $form->field($model, "task_category_id")->dropDownList($TaskCategories, ['prompt' => 'Select Category','id'=>'task_category_id']) ?>

<?php
$major = [];
if(!empty($model->task_category_id)) {
$temp = $model->taskCategory->taskList;
if(!empty($temp)) { 
array_push($temp,['id'=>'0', 'name'=>'Others']);   
$major = ArrayHelper::map($temp, 'id', 'name');
}
}
?>


<?php  if($model->isNewRecord){ ?>
<?= $form->field($model, 'task_list_id')->widget(DepDrop::classname(), [
'type'=>DepDrop::TYPE_SELECT2,
'options'=>[  'id' => 'task_list_id', 'placeholder'=>'------Select Type-----'], 
'pluginOptions'=>[ 
'depends'=>['task_category_id'], // the id for cat attribute
'placeholder'=>'------Select Type-----',
'url'=>  \yii\helpers\Url::to(['subcat'])
]
]); 
}else{ 

?>

<?= $form->field($model, 'task_list_id')->widget(DepDrop::classname(), [
'data' => $major,
'type'=>DepDrop::TYPE_SELECT2,
'options'=>[  'id' => 'task_list_id','placeholder'=>'------Select Type-----'], 
'select2Options'=>[  'pluginOptions'=>['allowClear'=>true]],
'pluginOptions'=>[
'depends'=>['task_category_id'], 
'url'=>  \yii\helpers\Url::to(['subcat']),
]
]); ?>
<?php } ?>

<div id="nonstandard" style="display:none;" > 
<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?> 
</div>

<div id="task_detail" style="display:none;" >

</div>	


<?= $form->field($model, 'description')->textarea(['rows' => 5]) ?>

<?= $form->field($model, 'comments')->textarea(['rows' => 5]) ?>


</div>
<div class="col-xs-6 col-sm-6">

<div class="form-group field-tasks-notified required">
<label class="control-label" for="tasks-notified">People to be Notified</label>
<?php 
$notifiedData= array();
if(!empty($model->notified)){ 
$notifiedData = explode(',',$model->notified);

} 
?>
<div id="tasks-notified">
<label><input name="Tasks[notified][]"  id="notified1" value="1" type="checkbox"  checked="checked" > Student</label>
<label><input name="Tasks[notified][]"  id="notified2" value="2" type="checkbox"  checked="checked" > Counselor</label>
<label><input name="Tasks[notified][]"  id="notified3" value="3" type="checkbox" <?php if(in_array(3, $notifiedData)){?> checked="checked"<?php }?> > Parent/Guardian</label>
<label><input name="Tasks[notified][]"  id="notified4" value="4" type="checkbox" <?php if(in_array(4, $notifiedData)){?> checked="checked"<?php }?> > Additional</label></div>
<div class="help-block"></div>
</div>
<?php if(!empty($model->additional)){ 
$style= ' style="display:block;"';
}else{
$style= ' style="display:none;"';
}?>

<div id="checkedAdditional" <?php echo $style; ?> >
<?= $form->field($model, 'additional')->textInput(['maxlength' => true]) ?>
</div>

<div class="form-group field-tasks-standard_alert ">
<label class="control-label" for="tasks-standard_alert">Standard Alert</label>
<input name="Tasks[standard_alert]" value="" type="hidden">
<div id="tasks-standard_alert">
<label><input name="Tasks[standard_alert]"  id="1" value="1" type="checkbox" disabled="disabled"  checked > 1 Day before</label>
</div> 
</div>

<?= $form->field($model, "specific_alert")->dropDownList($TaskSpecificAlert) ?>


<?= $form->field($model, "responsibility")->dropDownList($TaskResponsbility, ['prompt' => 'Select Responsbility']) ?>

<div id="ResOthers" <?php if($model->responsibility!=2){ echo 'style="display:none;"';}?> >
<?= $form->field($model, 'others')->textInput(['maxlength' => true]) ?>
</div> 

<?= $form->field($model, 'due_date')->widget(DateTimePicker::classname(),[
'name' => 'due_date',
'type' => DateTimePicker::TYPE_INPUT,
'pluginOptions' => [
'autoClose' => true,
'format' => 'yyyy-mm-dd hh:ii', 
'todayHighlight' => true, 

]
]);?>

<?php    if(!$model->isNewRecord){ ?>
<?= $form->field($model, "action")->dropDownList($TaskActions) ?>

<?= $form->field($model, "verifybycounselor")->dropDownList($VerificationByCounselor) ?>

<?= $form->field($model, "status")->dropDownList($TaskStatus) ?>

<?php }?>
<?php /*$form->field($upload, 'attachment')->widget(FileInput::classname(), [ 
'pluginOptions' => [
'showUpload' => false, 
] 
]);  */
?> 
</div>
</div> 


<div class="form-group">
<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); 
Pjax::end();
?>

</div>
<script language="javascript">
$( document ).ready(function() {

$('#tasks-responsibility').on('change', function() {	  
if(this.value==2){	  
$('#ResOthers').show();
}else{
$('#ResOthers').hide();
}
}); 

$('#notified4').on('click', function() {	  

if(this.checked){	  
$('#checkedAdditional').show();
}else{
$('#checkedAdditional').hide();
}
}); 

$('#task_list_id').on('change', function() {	 

getTaskDetail(this.value);
if(this.value==0){
$('#nonstandard').show(); 
$('#task_detail').hide();  
}
if(this.value!=0){
$('#nonstandard').hide();			 
$('#task_detail').show();  
}
}); 

function getTaskDetail(id) {		
$.ajax({
url: '?r=consultant/tasks/getdetail&id='+id,
method: 'GET', 
success: function(response, data) {
response = JSON.parse(response); 				
$('#task_detail').html(response.result); 
},
error: function(error) {
console.log(error);
}
});  
}

});


</script>