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

use yii\grid\GridView; 
use common\models\Consultant; 
$this->title =  "Task Preview"; 
 
?>

<?php   
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

 ?>
 
		 
 
<div class="student-tasks-form ">  
    <div class="dashboard-detail">
        <div class="tab-content">
		
   <h1><?= Html::encode($this->title) ?></h1>
   
     <?php $form = ActiveForm::begin(['id'=>'student-tasks-active-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="row text-left col-sm-12">
		 
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
 
<?php ActiveForm::end(); ?>

</div> 
</div> 
<div class="student-profile-main">
    
    <div class="dashboard-detail"> 
 
	 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel, 
        'columns' => [
		 ['class' => 'yii\grid\SerialColumn'], 
		 
	[	'attribute' => 'comment',
		'value' => 'comment',
		'label' => 'Comments',  		
		 'filter'=>false,
		 'contentOptions' => ['style' => '  max-width:300px; white-space: normal; ']
		 
	],		 
	[	'attribute' => 'action',
		'value' => function($searchModel){
					$TaskActions = Tasks::TaskActions();
					return $TaskActions[$searchModel->action];
                },
		'label' => 'Action', 
		 'filter'=>false,
		 'contentOptions' => ['style' => '  max-width:100px; white-space: normal; ']
	], 
	[	'attribute' => 'status',
		'value' => function($searchModel){ 
					$TaskStatus = Tasks::TaskStatus(); 			
					return $TaskStatus[$searchModel->status];
                },
		'label' => 'Status', 
		'filter'=>false,
		'contentOptions' => ['style' => '  max-width:100px; white-space: normal; ']
	], 
	
	[	'attribute' => 'created_at',
		'value' => function($searchModel){  
				 $timestamp = strtotime($searchModel->created_at); 
				 return date('d-M-Y H:i:s a', $timestamp);
                 },
		'label' => 'Date',
		'filter' => false, 	
		'contentOptions' => ['style' => '  max-width:100px; white-space: normal; ']		
	], 
	[	'attribute' => false,
		'value' => function($searchModel){  
					$comment = '' ;
		 
				   if($searchModel->student_id!=0) { 
				    $studentInfo = Student::findOne(['student_id' => $searchModel->student_id]);
					  if(isset($studentInfo)){
						  return  $comment = $studentInfo->first_name." ".$studentInfo->last_name;
					  }
				  } 
				   if($searchModel->consultant_id!=0) {  
						$consultantInfo = Consultant::findOne(['consultant_id' => $searchModel->consultant_id]);
						  if(isset($consultantInfo)){
							  return  $comment =  $consultantInfo->first_name.' '.$consultantInfo->last_name;
						  }
				   }     
                 },
		'label' => 'Updated By',
		'filter' => false, 	
		'contentOptions' => ['style' => '  max-width:100px; white-space: normal; ']		
	], 
	
 
	   ['class' => 'yii\grid\ActionColumn',
			'visible' => false,
			],
			  
			
        ],
    ]); ?> 
</div>
</div> 



