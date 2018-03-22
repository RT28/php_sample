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
use kartik\date\DatePicker;



$this->title = 'Invoice Requisition'; 
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'main';
$status = array('0'=>'Incomplete','1'=>'Completed');
//$alerts = Tasks::TaskSpecificAlert();
$path= ConnectionSettings::BASE_URL.'partner/';
?>

<div class=" taskgrid">
     
	 <div class="row">
<div class="col-sm-12 ">
   <h1><?= Html::encode($this->title) ?></h1>
<?php if(Yii::$app->session->getFlash('Error')): ?>
    <div class="alert alert-danger" role="alert"><?= Yii::$app->session->getFlash('Error') ?></div>
<?php endif; ?>

<?php if(Yii::$app->session->getFlash('Success')): ?>
    <div class="alert alert-success" role="alert"><?= Yii::$app->session->getFlash('Success') ?></div>
<?php endif; ?>
		
<div id='content' style="display:none;" class="">
<?php  echo $this->render('_search', ['model' => $searchModel]); ?>
</div>
</div>
<?php if($dataProvider->getTotalCount() != 0): ?>
<!-- <div class="col-sm-12 text-right">
<input type='button' id='hideshow' value='Filters'>
</div> -->
 <?php endif; ?>
</div>

 

	<p >
        <?= Html::a('My Invoices',$path.'web/index.php?r=consultant/invoice/', ['class' => 'btn btn-success']) ?>
    </p>
	  
	  <?php  
	  if($dataProvider->getTotalCount() === 0): 
	 ?>
          <h2> You do not have any task for invoicing.</h2>
           <div class="col-xs-12 text-center"> 
        </div>
    <?php else: ?>
	
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
		'filter'=>Html::dropDownList('RaiseinvoiceSearch[student_id]',isset($_REQUEST['RaiseinvoiceSearch']['student_id']) ? $_REQUEST['RaiseinvoiceSearch']['student_id'] : null,$students,['class' => 'form-control', 'prompt' => 'Students'])

	],
	[	'attribute' => 'title',
		'value' => 'title',
		'label' => 'Task', 
		'contentOptions' => ['style' => '  max-width:100px; white-space: normal; '],
		'filter' => false,
	], 
	 [	'attribute' => 'created_at',
		'value' => function($searchModel){  
				 $timestamp = strtotime($searchModel->created_at); 
				 return date('d-m-Y', $timestamp);
                 },
		'label' => 'Created Date', 
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
				 $timestamp = strtotime($searchModel->due_date); 
				 return date('d-m-Y', $timestamp);
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
		'filter' => false,
		/*'filter'=>Html::dropDownList('RaiseinvoiceSearch[responsibility]',isset($_REQUEST['RaiseinvoiceSearch']['responsibility']) ? $_REQUEST['RaiseinvoiceSearch']['responsibility'] : null,$TaskResponsbility,['class' => 'form-control', 'prompt' => 'Responsibility'])*/
	],  
	[	'attribute' => 'action',
		'value' => function($searchModel){
					$TaskActions = Tasks::TaskActions();
					return $TaskActions[$searchModel->action];
                },
		'label' => 'Action', 
		'filter' => false,
		/*'filter'=>Html::dropDownList('RaiseinvoiceSearch[action]',isset($_REQUEST['RaiseinvoiceSearch']['action']) ? $_REQUEST['RaiseinvoiceSearch']['action'] : null,$TaskActions,['class' => 'form-control', 'prompt' => 'Action'])*/
	], 
	/*[	'attribute' => 'verifybycounselor', 
		'value' => function($searchModel){
					$actions = Tasks::TaskVerificationByCounselor(); 
					return $actions[$searchModel->verifybycounselor];
                },
		'label' => 'Counselor Verification ', 
		'filter' => false,
		'filter'=>Html::dropDownList('RaiseinvoiceSearch[verifybycounselor]',isset($_REQUEST['RaiseinvoiceSearch']['verifybycounselor']) ? $_REQUEST['RaiseinvoiceSearch']['verifybycounselor'] : null,$TaskStatus,['class' => 'form-control', 'prompt' => 'Verification'])
	], */
	[	'attribute' => 'status',
		'value' => function($searchModel){ 
					$TaskStatus = Tasks::TaskStatus(); 			
					return $TaskStatus[$searchModel->status];
                },
		'label' => 'Status', 
		'filter' => false,
		/*'filter'=>Html::dropDownList('RaiseinvoiceSearch[status]',isset($_REQUEST['RaiseinvoiceSearch']['status']) ? $_REQUEST['RaiseinvoiceSearch']['status'] : null,$TaskStatus,['class' => 'form-control', 'prompt' => 'Status'])*/
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
	
	   ['class' => 'yii\grid\ActionColumn',
		'buttons' => [
		'update1' => function ($url, $model, $key) {
		// $url = 'http://localhost/gotouniversity/partner/web/index.php?r=invoice/create';
		return  '<a href="#" class="btn btn-blue" data-toggle="modal" 
		data-target="#addInvoiceModal" onclick="pendingInvoice('.$model->student_id.','.$model->id.')" >Raise Invoice</a>';
		 ;
				},
		],
       'template' => '{update1}'],
			  
			
        ],
    ]); 
 
	?> 
	 <?php endif; ?>
</div> 
    <div id="addInvoiceModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body" id="AddInvoicePreview" style="height:800px; overflow:scroll;">
                  
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
            </div>
    </div>

    <div id="invoiceUpdateModal" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body" id="invoiceUpdate" style="height:800px; overflow:scroll;">
              
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
    //$this->registerJsFile('js/main.js');
?>
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