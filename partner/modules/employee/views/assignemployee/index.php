<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\Student; 
use common\models\Consultant; 
use common\models\StudentConsultantRelation; 

$VerifyStatus = StudentConsultantRelation::VerifyStatus(); 

/* @var $this yii\web\View */
/* @var $searchModel common\models\StudentConsultantRelationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Assigned Sub Consultants';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-consultant-relation-index col-sm-12">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Assign Consultant', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
  <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel, 
		'export' => false,
		'pjax' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
 	[	'attribute' => 'consultant_id',
	'value' => function($searchModel){  
	$consultant_id = $searchModel->consultant_id;	
	$Consultant = Consultant::find()->where(['=', 'consultant_id', $consultant_id])->one(); 
	return  $Consultant->first_name." ".$Consultant->last_name; 
	},
	'label' => 'Sub Consultant', 
	'filter'=>Html::dropDownList('StudentConsultantRelation[consultant_id]',isset($_REQUEST['TasksSearch']['consultant_id']) ? $_REQUEST['TasksSearch']['consultant_id'] : null,$Subconsultants,['class' => 'form-control', 'prompt' => 'Sub Consultant'])

	],
             [	'attribute' => 'student_id',
		'value' => function($searchModel){  
				 $id = $searchModel->student_id;	
				   $studentProfile = Student::find()->where(['=', 'id', $id])->one(); 
					return  $studentProfile->first_name." ".$studentProfile->last_name; 
                 },
		'label' => 'Student', 
		'filter'=>Html::dropDownList('StudentConsultantRelation[student_id]',isset($_REQUEST['TasksSearch']['student_id']) ? $_REQUEST['TasksSearch']['student_id'] : null,$students,['class' => 'form-control', 'prompt' => 'Student'])

	],

	[	'attribute' => 'verify_by_consultant',
		'value' => function($searchModel){
					$verify = StudentConsultantRelation::VerifyStatus(); 			
					return $verify[$searchModel->verify_by_consultant];
                },
		'label' => 'Verify By Consultant ', 
		'filter'=>Html::dropDownList('StudentConsultantRelation[verifybycounselor]',isset($_REQUEST['StudentConsultantRelation']['verifybycounselor']) ? $_REQUEST['StudentConsultantRelation']['verifybycounselor'] : null,$VerifyStatus,['class' => 'form-control', 'prompt' => 'Verify By Consultant'])
	], 
	
	  
          

			['class' => 'yii\grid\ActionColumn',
			'buttons' => [
			'update' => function ($url, $model, $key) {

			return  '<a href="#" class="glyphicon glyphicon-pencil" data-toggle="modal" 
			data-target="#subconsultantUpdateModal" onclick="loadSubConUpdate('.$model->id.')" ></a>';
			;
			}, ],
			'template' => ' {update}{delete}'],
        ],
    ]); ?>
 </div>
 

<div id="subconsultantUpdateModal" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body" id="subconsultantUpdate" style="height:800px; overflow:scroll;">

</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</div>

</div>
</div> 