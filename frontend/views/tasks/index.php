<?php

use yii\helpers\Html;
use kartik\grid\GridView; 
use kartik\grid\ExportMenu;  
//use kartik\daterange\DateRangePicker;
use common\models\Student; 
use common\models\Tasks;
use partner\models\TaskCommentSearch;
use yii\widgets\Pjax;  
   

$this->title = 'Tasks';
$this->context->layout = 'profile';
$status = array('0'=>'Incomplete','1'=>'Completed');
$alerts = Tasks::TaskSpecificAlert(); 
?>
<div class="student-tasks-main col-sm-12">
<?= $this->render('/student/_student_common_details'); ?>

   <div class="row">
<div class="alert alert-danger remove-message hidden"></div>

    <div class="dashboard-detail">
<div class="taskgrid">
     
  <div class="alert alert-danger error-container hidden"></div>

    <h1><?= Html::encode($this->title) ?></h1>
   
	 	  <?php  
	  //if($dataProvider->getTotalCount() === 0): 
	 ?>
          <!--<h2> You don't have any tasks yet.</h2>
           <div class="col-xs-12 text-center"> 
        </div> -->
    <?php //else: ?>
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
	
	[	'attribute' => 'title',
		'value' => 'title',
		'label' => 'Task', 
		'contentOptions' => ['style' => '  max-width:100px; white-space: normal; ']
	], 
	   
	[
      'attribute'=>'created_at',
      'options' => [
          'format' => 'YYYY-MM-DD',
          ],      
'format' => 'date', 		  
      'filterType' => GridView::FILTER_DATE_RANGE,
      'filterWidgetOptions' => ([       
        'attribute' => 'created_at',
        'presetDropdown' => true,
        'convertFormat' => false,
        'pluginOptions' => [
          'separator' => ' - ',
          'format' => 'YYYY-MM-DD',
          'locale' => [
                'format' => 'YYYY-MM-DD'
            ],
        ],
        'pluginEvents' => [
          "apply.daterangepicker" => "function() { apply_filter('created_at') }",
        ],
      ])
    ],
	
	[
      'attribute'=>'due_date',
      'options' => [
          'format' => 'YYYY-MM-DD',
          ],    
		'format' => 'date', 		  
      'filterType' => GridView::FILTER_DATE_RANGE,
      'filterWidgetOptions' => ([       
        'attribute' => 'due_date',
        'presetDropdown' => true,
        'convertFormat' => false,
        'pluginOptions' => [
          'separator' => ' - ',
          'format' => 'YYYY-MM-DD',
          'locale' => [
                'format' => 'YYYY-MM-DD'
            ],
        ],
        'pluginEvents' => [
          "apply.daterangepicker" => "function() { apply_filter('due_date') }",
        ],
      ])
    ],
	
	/*[	'attribute' => 'due_date',
		
		'label' => 'Deadline',
		'format' => 'date', 
		'value' => function($searchModel){  
				if(!empty($searchModel->due_date)){
			return Yii::$app->formatter->asDate($searchModel->due_date, 'dd-MM-yyyy');
		} 
                 },
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
		'contentOptions' => ['style' => '  max-width:100px; white-space: normal; ']
	], */
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
		'filter'=>Html::dropDownList('TasksSearch[status]',isset($_REQUEST['TasksSearch']['status']) ? $_REQUEST['TasksSearch']['status'] : null,$TaskStatus,['class' => 'form-control', 'prompt' => 'Select status'])
	], 
	/*[	'attribute' => 'comments',
		'value' => 'comments',
		'label' => 'Comments', 
		'contentOptions' => ['style' => '  max-width:100px; white-space: normal; '],
		'header'=>'Plan Info',
		'value'=> function($data)
			  { 
				   return  Html::a(Yii::t('app', ' {modelClass}', [
						  'modelClass' => 'details',
						  ]), ['userdetails/plans','id'=>$data->id], ['class' => 'btn btn-success', 'id' => 'popupModal']);      
			  },
		'format' => 'raw'
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
	],	*/
	   ['class' => 'yii\grid\ActionColumn',
		'buttons' => [
		'update' => function ($url, $model, $key) {
		  if($model->verifybycounselor!=2){  
		  
			$html = '';
			$action = '';   
			return  '<a href="/tasks/update?id='.$model->id.'" title="Update" aria-label="Update" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>';
		  
		  }
 
		}, 
		'preview' => function ($url, $model, $key) {
		
		$html = '';
		$action = '';   
		return  '<a href="#" class="glyphicon glyphicon-eye-open" data-toggle="modal" 
data-target="#mytaskview" onclick="loadTaskview('.$model->id.')" ></a>';
 ;
		},  
		  				 ],
       'template' => '{update} {preview}'],
			  
			
        ],
    ]); 
 
	?> 
	<?php Pjax::end(); ?>
	 <?php //endif; ?>
</div> 
 </div>
  
  
    
</div> 
</div> 
</div>
</div>
 
 <div id="mytaskview" class="modal fade" role="dialog">
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
<script type="text/javascript">
	function loadTaskview(id) { 
	$.ajax({
            url: '/tasks/view?id='+id,
            method: 'GET', 
            success: function( data) {  
                $('#taskPreview').html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        });  
}
</script>
<?php
    $this->registerJsFile('js/student.js');
?>