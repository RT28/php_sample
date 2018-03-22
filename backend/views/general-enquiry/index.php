<?php

use yii\helpers\Html;
use yii\grid\GridView;    
use backend\models\GeneralEnquiry;
 
$status  = GeneralEnquiry::status(); 

/* @var $this yii\web\View */
/* @var $searchModel backend\models\GeneralEnquirySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'General Enquiries';
$this->params['breadcrumbs'][] = $this->title;
 
$this->context->layout = 'admin-dashboard-sidebar';
  

?>
<div class="university-enquiry-index">
<div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">
    <h1><?= Html::encode($this->title) ?></h1>
	
<?php if(Yii::$app->session->getFlash('Error')): ?>
<div class="alert alert-danger" role="alert"><?= Yii::$app->session->getFlash('Error') ?></div>
<?php endif; ?>

<?php if(Yii::$app->session->getFlash('Success')): ?>
<div class="alert alert-success" role="alert"><?= Yii::$app->session->getFlash('Success') ?></div>
<?php endif; ?>
  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'email:email',
            [
                'label' => 'Phone',
                'attribute' => 'phone',
                'value' => function($model) {
					 $phone =  $model->phone ;
						if($model->code){
						$phone = 	"+".$model->code.$model->phone;
						} 
                    return  $phone;
                }, 
            ],  
			 
			[
                'label' => 'Status',
                'attribute' => 'status',
                'value' => function($model) {
					 $status  = GeneralEnquiry::status(); 

                    return $status[$model->status];
                },
                'filter'=>Html::dropDownList('GeneralEnquirySearch[status]',isset($_REQUEST['GeneralEnquirySearch']['status']) ? $_REQUEST['GeneralEnquirySearch']['status'] : null,$status,['class' => 'form-control', 'prompt' => 'Select status'])
            ], 
             

            ['class' => 'yii\grid\ActionColumn',
			 'template' => '{view}{delete}{status}',
			 'buttons' => ['status' => function ($url, $model, $key) {
                                return Html::a('', ['/general-enquiry/changestatus', 'id' => $model->id] , ['class' => 'glyphicon glyphicon-list-alt','title' => 'Change Status']);
                            }, 
                           ],
			],
			  
        ],
    ]); ?>
</div>
</div>
</div>
</div>
