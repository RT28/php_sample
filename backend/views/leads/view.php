<?php

use yii\helpers\Html;
use yii\grid\GridView; 
use common\models\StudentLeadFollowup;
$this->title = 'Follow Up Details';

?>
<div class="employee-view">
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">

                <h4><?= Html::encode($this->title) ?></h4>

    
<div class="student-profile-main">
    
    <div class="dashboard-detail"> 
 
	 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel, 
        'columns' => [
		 ['class' => 'yii\grid\SerialColumn'], 
		 
	[	'attribute' => 'status',		 
		'label' => 'Status',
		'value' => function ($model) {
                                  $status = $model->status;
                                 if($status==1) {
                                            $exist_followup = StudentLeadFollowup:: getlastfollowup($model->student_id);
                                            if(empty($exist_followup)) {
                                                return 'New Entry';
                                            } else { return 'Active'; }   
                                 }
                                 else if($status==2) { return 'Inactive/Closed'; }
                                 else if($status==3) { return 'Access Sent'; }
                                 else if($status==4) { return 'Subscribed'; }
                                
                            },
		 'filter'=>false,
		 'contentOptions' => ['style' => '  width:300px; white-space: normal; ']
		 
	],	
	[	'attribute' => 'created_at',		 
		'label' => 'Created Date',  		
		 'filter'=>false,
		 'contentOptions' => ['style' => '  width:300px; white-space: normal; ']
		 
	],	 
	[	'attribute' => 'comment',		 
		'label' => 'Comments',  		
		 'filter'=>false,
		 'contentOptions' => ['style' => '  width:500px; white-space: normal; ']
		 
	],
	[	'attribute' => 'comment_date',		 
		'label' => 'Comment Date',  		
		 'filter'=>false,
		 'contentOptions' => ['style' => '  width:300px; white-space: normal; ']
		 
	],
	
	[	'attribute' => 'next_followup',		 
		'label' => 'Next followup date',
		'value' => function ($model) {
                                  $next_followup = $model->next_followup;
                                 if($next_followup=='0000-00-00 00:00:00') { return 'NA'; }
                                 else { return $next_followup; }
                                
                            },  		
		 'filter'=>false,
		 'contentOptions' => ['style' => '  width:300px; white-space: normal; ']
		 
	],
	[	'attribute' => 'next_follow_comment',		 
		'label' => 'Next Followup Comment',  		
		 'filter'=>false,
		 'value' => function ($model) {
                                  $next_follow_comment = $model->next_follow_comment;
                                 if($next_follow_comment=='') { return 'NA'; }
                                 else { return $next_follow_comment; }
                                
                            },
		 'contentOptions' => ['style' => '  width:300px; white-space: normal; ']
		 
	],
	[	'attribute' => 'mode',		 
		'label' => 'Mode of Contact',  		
		 'filter'=>false,
		 'contentOptions' => ['style' => '  width:300px; white-space: normal; ']
		 
	],
	[	'attribute' => 'reason_code',		 
		'label' => 'Reason code',  
		'value' => function ($model) {
                                  $reason_code = $model->reason_code;
                                 if($reason_code==1) { return 'Not Interested'; }
                                 else if($reason_code==2) { return 'Price not reasonable'; }
                                 else if($reason_code==3) { return 'Not Now'; }
                                 else { return 'NA'; }                                
                            },		
		 'filter'=>false,
		 'contentOptions' => ['style' => '  width:300px; white-space: normal; ']
		 
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
</div>
</div>
