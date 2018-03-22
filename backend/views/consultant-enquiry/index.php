<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;  
use common\models\Country;

use common\models\ConsultantEnquiry;
 
$status  = ConsultantEnquiry::status();

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ConsultantEnquirySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Consultants Enquiries';
$this->params['breadcrumbs'][] = $this->title;

$countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name');
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

            'first_name',
            'email:email',
            'mobile',  
			[
                'label' => 'Status',
                'attribute' => 'status',
                'value' => function($model) {
					$status  = ConsultantEnquiry::status();
                    return $status[$model->status];
					
                },
                'filter'=>Html::dropDownList('ConsultantEnquirySearch[status]',isset($_REQUEST['ConsultantEnquirySearch']['status']) ? $_REQUEST['ConsultantEnquirySearch']['status'] : null,	$status ,['class' => 'form-control', 'prompt' => 'Select status'])
            ], 
            [
                            'label' => 'Country',
                            'attribute' => 'country_id',
                            'value'=>function($searchModel){ 
				 
			if(isset($searchModel->country_id)){
				$CountryVal = Country::find()->where(['id'=>$searchModel->country_id])->one();	
								  					 
				if(!empty($CountryVal->name)){
					return $CountryVal->name;
				 }else{
					 return "";
				 }
				}					
				
                },
                            'filter'=>Html::dropDownList('ConsultantEnquirySearch[country_id]',isset($_REQUEST['ConsultantEnquirySearch']['country_id']) ? $_REQUEST['ConsultantEnquirySearch']['country_id'] : null,$countries,['class' => 'form-control', 'prompt' => 'Select Country'])
			], 

		['class' => 'yii\grid\ActionColumn',
			'template' => '{view}{delete}{status}',
			'buttons' => [
				'status' => function ($url, $model, $key) {
					return Html::a('', ['/consultant-enquiry/changestatus', 'id' => $model->id] , ['class' => 'glyphicon glyphicon-list-alt','title' => 'Change Status']);
				},  
			],
		],
			  
        ],
    ]); ?>
</div>
</div>
</div>
</div>
