<?php

use yii\helpers\Html;
use yii\grid\GridView; 
use common\models\Student; 
use common\models\Consultant; 
use common\models\Tasks;

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'main';
//$status = array('0'=>'Incomplete','1'=>'Completed');
?>
<div class="student-profile-main">
    
    <div class="dashboard-detail"> 
 Task History :
	 
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
				 return date('d-m-Y H:i:s a', $timestamp);
                 },
		'label' => 'Date',
		'filter' => false, 	
		'contentOptions' => ['style' => '  max-width:100px; white-space: normal; ']		
	], 
	[	'attribute' => false,
		'value' => function($searchModel){  
					$commentby = '' ;
		 
				   if($searchModel->student_id!=0) { 
				    $studentInfo = Student::findOne(['student_id' => $searchModel->student_id]);
					  if(isset($studentInfo)){
						  return  $commentby = $studentInfo->first_name." ".$studentInfo->last_name;
					  }
				  } 
				   if($searchModel->consultant_id!=0) {  
						$consultantInfo = Consultant::findOne(['consultant_id' => $searchModel->consultant_id]);
 
						  if(isset($consultantInfo)){
							  return  $commentby =  $consultantInfo->first_name." ".$consultantInfo->last_name;
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
</div>
</div>
