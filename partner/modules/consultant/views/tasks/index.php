<?php

use yii\helpers\Html;
use kartik\grid\GridView; 
use kartik\grid\ExportMenu; 
use kartik\daterange\DateRangePicker; 
use common\models\Student; 
use common\models\Tasks;
use partner\models\TaskCommentSearch;
use yii\widgets\Pjax; 
use common\components\ConnectionSettings;
use common\components\Commondata; 



$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'main';
$status = array('0'=>'Incomplete','1'=>'Completed');
$alerts = Tasks::TaskSpecificAlert();
$path= ConnectionSettings::BASE_URL.'partner/';

?>
<div class="taskgrid">
     
	 <div class="row">
<div class="col-sm-6 ">
   <h1><?= Html::encode($this->title) ?></h1>
<?php if(Yii::$app->session->getFlash('Error')): ?>
    <div class="alert alert-danger" role="alert"><?= Yii::$app->session->getFlash('Error') ?></div>
<?php endif; ?>

<?php if(Yii::$app->session->getFlash('Success')): ?>
    <div class="alert alert-success" role="alert"><?= Yii::$app->session->getFlash('Success') ?></div>
<?php endif; ?>
		

</div>
<?php if($dataProvider->getTotalCount() != 0): ?>
<div class="col-sm-6 text-right">
<input type="button" id="hideshow" value="Filters">
</div>
 <?php endif; ?>
 <div class="col-sm-12">
 	<div id='content' style="display:none;" class="">
<?php  echo $this->render('_search', ['model' => $searchModel]); ?>
</div>
 </div>
</div>

 

    <p> 
		
		 <a href="#" class="btn btn-blue" data-toggle="modal" 
data-target="#addtaskModal" onclick="loadTaskAdd('?r=consultant/tasks/create');" >Add Task</a>
    </p>
	  
	  <?php  
	  if($dataProvider->getTotalCount() === 0): 
	 ?>
          <h2> You haven't any tasks yet.</h2>
           <div class="col-xs-12 text-center"> 
        </div>
    <?php else: ?>
	<?php Pjax::begin(); ?>   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel, 
		'export' => false,
		'pjax' => true,
        'columns' => [
		['class' => 'kartik\grid\ExpandRowColumn',
		  'value' => function ($model, $key, $index) { 
						return GridView::ROW_COLLAPSED;
				},
		'expandOneOnly' => true,				
		'detail' => function ($model, $key, $index) { 
	    $searchModel = new TaskCommentSearch(); 		
	    $searchModel->task_id = $model->id; 
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
	  
        return Yii::$app->controller->renderPartial('_comments', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider, 
        ]);
				}
		], 
		 [	'attribute' => 'student_id',
		'value' => function($searchModel){  
				 $id = $searchModel->student_id;	
				   $studentProfile = Student::find()->where(['=', 'id', $id])->one();
		 
		return  $studentProfile->first_name." ".$studentProfile->last_name;
		
		
                 },
		'label' => 'Student', 
		'filter'=>Html::dropDownList('TasksSearch[student_id]',isset($_REQUEST['TasksSearch']['student_id']) ? $_REQUEST['TasksSearch']['student_id'] : null,$students,['class' => 'form-control', 'prompt' => 'Students'])

	],
	[	'attribute' => 'title',
		'value' => 'title',
		'label' => 'Task', 
		'contentOptions' => ['style' => '  max-width:100px; white-space: normal; ']
	], 
	 [	'attribute' => 'created_at',
		'value' => function($searchModel){ 
		if(!empty($searchModel->created_at)){
			return Yii::$app->formatter->asDate($searchModel->created_at, 'dd-MM-yyyy');
		} 
		 },
		'label' => 'Date', 
		'filter' => DateRangePicker::widget([
        'model' => $searchModel,
        'attribute' => 'created_at',
        'convertFormat' => true,
        'pluginOptions' => [
            'locale' => [
                'format' => 'Y-m-d'
					],
				],
		]),
	
	], 
	 
[	'attribute' => 'due_date',
		'value' => function($searchModel){  
				if(!empty($searchModel->due_date)){
			return Yii::$app->formatter->asDate($searchModel->due_date, 'dd-MM-yyyy');
		} 
                 },
		'label' => 'Deadline',  
		'filter' => DateRangePicker::widget([
        'model' => $searchModel,
        'attribute' => 'due_date',
        'convertFormat' => true,
        'pluginOptions' => [
            'locale' => [
                'format' => 'Y-m-d'
					],
				],
		]),
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
		'filter'=>Html::dropDownList('TasksSearch[verifybycounselor]',isset($_REQUEST['TasksSearch']['verifybycounselor']) ? $_REQUEST['TasksSearch']['verifybycounselor'] : null,$TaskStatus,['class' => 'form-control', 'prompt' => 'Verification'])
	], 
	[	'attribute' => 'status',
		'value' => function($searchModel){ 
					$TaskStatus = Tasks::TaskStatus(); 			
					return $TaskStatus[$searchModel->status];
                },
		'label' => 'Status', 
		'filter'=>Html::dropDownList('TasksSearch[status]',isset($_REQUEST['TasksSearch']['status']) ? $_REQUEST['TasksSearch']['status'] : null,$TaskStatus,['class' => 'form-control', 'prompt' => 'Status'])
	], 
	[	'attribute' => 'comments',
		'value' => 'comments',
		'label' => 'Comments', 
		'contentOptions' => ['style' => '  max-width:100px; white-space: normal; '],
		/*'header'=>'Plan Info',
		'value'=> function($data)
			  { 
				   return  Html::a(Yii::t('app', ' {modelClass}', [
						  'modelClass' => 'details',
						  ]), ['userdetails/plans','id'=>$data->id], ['class' => 'btn btn-success', 'id' => 'popupModal']);      
			  },
		'format' => 'raw'*/
	],

	[	'attribute' => 'specific_alert',
		'value' => function($searchModel){
			if(!empty($searchModel->specific_alert)){
					$alerts = Tasks::TaskSpecificAlert(); 			
					return $alerts[$searchModel->specific_alert];
                }
		 },
		'label' => 'Specific Alert', 
		'contentOptions' => ['style' => '  max-width:100px; white-space: normal; '],
		'filter'=>Html::dropDownList('TasksSearch[specific_alert]',isset($_REQUEST['TasksSearch']['specific_alert']) ? $_REQUEST['TasksSearch']['specific_alert'] : null,$alerts,['class' => 'form-control', 'prompt' => 'Alert'])
	],	
	   ['class' => 'yii\grid\ActionColumn',
		'buttons' => [
		'update' => function ($url, $model, $key) {
		 
		return  '<a href="#" class="glyphicon glyphicon-pencil" data-toggle="modal" 
data-target="#taskUpdateModal" onclick="loadTaskUpdate('.$model->id.')" ></a>';
 ;
		},
		'preview' => function ($url, $model, $key) {
		  
		return  '<a href="#" class="glyphicon glyphicon-eye-open" data-toggle="modal" 
data-target="#myModal2" onclick="loadTaskView('.$model->id.')" ></a>';
 ;
		},  
		'reminder' => function ($url, $model, $key) {
		 
		 return  '<a onclick="sendTaskReminder('.$model->id.')" ><span id="taskreminder'.$model->id.'" >Send Reminder</span></a>';

		//return  '<button class="btn btn-danger send-reminder" data-task='.$model->id.'>Send <br> Reminder</button>';
  
		},
		'delete' => function ($url, $model, $key) {
		 if($model->status == 0){
			 $id = Commondata::encrypt_decrypt('encrypt', $model->id);
		  return '<a href="?r=consultant/tasks/delete&id='.$id.'" title="Delete" aria-label="Delete" data-confirm="Are you sure you want to delete this item?"  ><span class="glyphicon glyphicon-trash"></span></a>';
		 }  
  
		}
							 
							 ],
       'template' => '{preview} {update}{delete}<br/>{reminder}'],
			  
			
        ],
    ]); 
 
	?> 
	
<?php Pjax::end(); ?>
	 <?php endif; ?>
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
    
</div>
</div> 
<?php
    $this->registerJsFile('js/chatnotification.js');
?>
<?php
    $this->registerJsFile('js/consultant.js');
?>
<script> 
jQuery(document).ready(function(){ 
jQuery('#hideshow').on('click', function(event) {  
jQuery('#content').toggle('show');
});
});
function toggle(id) { 
$('.kv-expand-detail-row').hide();
$('#'+id).show();
$(this).attr('data-color')
} 
</script>