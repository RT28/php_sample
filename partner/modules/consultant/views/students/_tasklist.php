<?php

use yii\helpers\Html;
use kartik\grid\GridView; 
use kartik\grid\ExportMenu;  
use common\models\Student; 
use common\models\Tasks;
use partner\models\TaskCommentSearch;
use yii\widgets\Pjax; 
use common\components\ConnectionSettings;
use kartik\date\DatePicker;
use common\models\AccessList;


$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'main';
$status = array('0'=>'Incomplete','1'=>'Completed');

$path= ConnectionSettings::BASE_URL.'partner/';

$TaskStatus = Tasks::TaskStatus(); 
$TaskActions =  Tasks::TaskActions();
$TaskResponsbility = Tasks::TaskResponsbility();
$TaskSpecificAlert =  Tasks::TaskSpecificAlert(); 
$VerificationByCounselor = Tasks::TaskVerificationByCounselor();

	 
$path = $path.'web/index.php?r=consultant/tasks/create&id='.$model->student_id;
	
?>

<?php 
$accessAuth = AccessList::accessActions('create');  
if($accessAuth ==true){   
?>
<a href="#" class="btn btn-success" data-toggle="modal"  
	data-target="#addtaskModal" onclick=loadTaskAdd('<?php echo $path; ?>'); >Add Task</a>
<?php
} 
?>

	
	
<div class=" taskgrid"> 
 
    <?= GridView::widget([
        'dataProvider' => $taskdataProvider,
        'filterModel' => $taskModel, 
		'export' => false,
		'pjax' => true,
        'columns' => [
		 ['class' => 'yii\grid\SerialColumn'],
		 [	'attribute' => 'student_id',
		'value' => function($searchModel){  
				 $id = $searchModel->student_id;	
				   $studentProfile = Student::find()->where(['=', 'id', $id])->one();
		 
		return  $studentProfile->first_name." ".$studentProfile->last_name;
		
		
                 },
		'label' => 'Student', 
		'filter'=>false

	],
	[	'attribute' => 'title',
		'value' => 'title',
		'label' => 'Task', 
		'contentOptions' => ['style' => '  max-width:100px; white-space: normal; ']
	], 
	 
	 
	 
	 
	[	'attribute' => 'responsibility',
		'value' => function($searchModel){
					$TaskResponsbility = Tasks::TaskResponsbility();
					return $TaskResponsbility[$searchModel->responsibility];
                },
		'label' => 'Responsibility', 
		'filter'=>Html::dropDownList('TasksSearch[responsibility]',isset($_REQUEST['TasksSearch']['responsibility']) ? $_REQUEST['TasksSearch']['responsibility'] : null,$TaskResponsbility,['class' => 'form-control', 'prompt' => 'Responsibility'])
	],  
	[	'attribute' => 'action',
		'value' => function($searchModel){
					$TaskActions = Tasks::TaskActions();
					return $TaskActions[$searchModel->action];
                },
		'label' => 'Action', 
		'filter'=>Html::dropDownList('TasksSearch[action]',isset($_REQUEST['TasksSearch']['action']) ? $_REQUEST['TasksSearch']['action'] : null,$TaskActions,['class' => 'form-control', 'prompt' => 'Action'])
	], 
	[	'attribute' => 'verifybycounselor',
		'value' => function($searchModel){
					$actions = Tasks::TaskVerificationByCounselor(); 			
					return $actions[$searchModel->verifybycounselor];
                },
		'label' => 'Counselor Verification ', 
		'filter'=>Html::dropDownList('TasksSearch[verifybycounselor]',isset($_REQUEST['TasksSearch']['verifybycounselor']) ? $_REQUEST['TasksSearch']['verifybycounselor'] : null,$TaskStatus,['class' => 'form-control', 'prompt' => 'Action by Counselor'])
	], 
	[	'attribute' => 'status',
		'value' => function($searchModel){ 
					$TaskStatus = Tasks::TaskStatus(); 			
					return $TaskStatus[$searchModel->status];
                },
		'label' => 'Status', 
		'filter'=>Html::dropDownList('TasksSearch[status]',isset($_REQUEST['TasksSearch']['status']) ? $_REQUEST['TasksSearch']['status'] : null,$TaskStatus,['class' => 'form-control', 'prompt' => 'Status'])
	],  
	[	'attribute' => 'specific_alert',
		'value' => function($searchModel){
			if(!empty($searchModel->specific_alert)){
					$alerts = Tasks::TaskSpecificAlert(); 			
					return $alerts[$searchModel->specific_alert];
                }
		 },
		'label' => 'Specific Alert', 
		'contentOptions' => ['style' => '  max-width:100px; white-space: normal; ']
	],	
	   ['class' => 'yii\grid\ActionColumn',
		'buttons' => [
		'update' => function ($url, $model, $key) {
		 
		return  '<a href="#" class="glyphicon glyphicon-pencil" data-toggle="modal" 
data-target="#taskUpdateModal" onclick="loadTaskUpdate('.$model->id.')" ></a>';
 
		},
		'preview' => function ($url, $model, $key) {
		  
		return  '<a href="#" class="glyphicon glyphicon-eye-open" data-toggle="modal" 
data-target="#myModal2" onclick="loadTaskView('.$model->id.')" ></a>';

		},   
							 
							 ],
       'template' => '{preview}'],
			  
			
        ],
    ]); 
 
	?> 
</div> 


<div id="addtaskModal" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body" id="AddTaskPreview" style="height:800px; overflow:scroll;">

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>

</div>
</div> 

<div id="taskUpdateModal" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body" id="taskUpdate" style="height:800px; overflow:scroll;">

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>

</div>
</div>  

<div id="myModal2" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body" id="taskPreview" style="height:800px; overflow:scroll;">

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>

</div>
</div> 
 <div id="addtaskModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="AddTaskPreview" style="height:800px; overflow:scroll;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> 

<?php
    $this->registerJsFile('js/consultant.js');
?>