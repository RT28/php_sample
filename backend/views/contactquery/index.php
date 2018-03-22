<?php

use yii\helpers\Html;
use yii\grid\GridView;    
use common\models\ContactQuery;
 
$status  = ContactQuery::status(); 

/* @var $this yii\web\View */
/* @var $searchModel backend\models\GeneralEnquirySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Leave Us Messages';
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
 
			[
                'label' => 'Name',
                'attribute' => 'first_name', 
            ],  
			 
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
			 
			 
            ['class' => 'yii\grid\ActionColumn',
			 'template' => '{view}{delete}',
			 
			],
			  
        ],
    ]); ?>
</div>
</div>
</div>
</div>
