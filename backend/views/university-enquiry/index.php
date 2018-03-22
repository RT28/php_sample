<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;  
use common\components\Commondata;
use common\models\Country;

use backend\models\UniversityEnquiry;

$status  = UniversityEnquiry::status(); 

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UniversityEnquirySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'University/Agency Enquiries';
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
                'label' => 'Institution Type',
                'attribute' => 'institution_type',
                'value' => function($model) {
					 $institutionTypeList = Commondata::getOthers('institution_type');
 
                     return $institutionTypeList[$model->institution_type] ;
                },
                'filter'=>Html::dropDownList('UniversityEnquirySearch[institution_type]',isset($_REQUEST['UniversityEnquirySearch']['institution_type']) ? $_REQUEST['UniversityEnquirySearch']['institution_type'] : null,$institutionType,['class' => 'form-control', 'prompt' => 'Institution Type'])
            ], 
			[
                'label' => 'Status',
                'attribute' => 'status',
                'value' => function($model) {
					$status  = UniversityEnquiry::status(); 
                    return $status[$model->status];
                },
                'filter'=>Html::dropDownList('UniversityEnquirySearch[status]',isset($_REQUEST['UniversityEnquirySearch']['status']) ? $_REQUEST['UniversityEnquirySearch']['status'] : null,$status,['class' => 'form-control', 'prompt' => 'Select status'])
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
                            'filter'=>Html::dropDownList('UniversityEnquirySearch[country_id]',isset($_REQUEST['UniversityEnquirySearch']['country_id']) ? $_REQUEST['UniversityEnquirySearch']['country_id'] : null,$countries,['class' => 'form-control', 'prompt' => 'Select Country'])
                        ], 

            ['class' => 'yii\grid\ActionColumn',
			 'template' => '{view}{delete}{status}',
			 'buttons' => ['status' => function ($url, $model, $key) {
                                return Html::a('', ['/university-enquiry/changestatus', 'id' => $model->id] , ['class' => 'glyphicon glyphicon-list-alt','title' => 'Change Status']);
                            }, 
                           ],
			],
			  
        ],
    ]); ?>
</div>
</div>
</div>
</div>
