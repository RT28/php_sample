<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\Status;
use common\components\Commondata; 
use common\models\Agency;
use common\models\Consultant;

$agencies = Agency::getAllAgencies();
$gender = Commondata::getGender();
 
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ConsultantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Consultants';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';



?>

<div class="alert alert-danger hidden">
</div>
<div class="consultant-index">
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

 
            <p>
                <?php // Html::a('Create Consultant', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
 
					 [
                            'label'=>'Agency/University Name.',
                            'attribute' => 'parentPartner.name',
							'filter'=>Html::dropDownList('ConsultantSearch[parent_partner_login_id]',isset($_REQUEST['ConsultantSearch']['parent_partner_login_id']) ? $_REQUEST['ConsultantSearch']['parent_partner_login_id'] : null,$agencies,['class' => 'form-control', 'prompt' => 'Select Agency'])
                        ],
                   [
                            'label'=>'Name',
                            'attribute' => 'first_name',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $name = $model->first_name . ' ' .$model->last_name ;
                                if (isset($name)) {
                                   return Html::a(Html::encode($name),['admin-consultant/view', 'id' => $model->id]);
                                }
                                else{ return 'not assigned'; }
                            },
                        ],
						/*[ 
                            'attribute' => 'gender', 
                            'value' => function ($model) { 
							$gender = Commondata::getGender();
							return $gender[$model->gender];
                            },
							'filter'=>Html::dropDownList('ConsultantSearch[gender]',isset(	$_REQUEST['ConsultantSearch']['gender']) ? $_REQUEST['ConsultantSearch']['gender'] : null,$gender,['class' => 'form-control', 'prompt' => 'Select Gender'])
							
						
                        ],*/
						
						
                    'email:email',
					['attribute' => 'is_active', 
						'value' => function($searchModel){  
						 					
						return  Consultant::getStateName($searchModel->is_active); 
						},
'filter'=>Html::dropDownList('ConsultantSearch[is_active]',isset(	$_REQUEST['ConsultantSearch']['is_active']) ? $_REQUEST['ConsultantSearch']['is_active'] : null,Consultant::State(),['class' => 'form-control', 'prompt' => 'Status'])						
					], 
					['attribute' => 'mobile',
						'label' => 'Contact  Number',
						'value' => function($searchModel){   
							return  "+".$searchModel->code.$searchModel->mobile; 
						}, 
					], 	
                    ['class' => 'yii\grid\ActionColumn',
                     'template' => '{view}{update}{disable}{verify}{createlogin}{delete}',
                     'buttons' => [
                        'disable' => function ($url, $model, $key) {
                            if($model->consultant->status === Status::STATUS_INACTIVE){
                                return Html::button('Enable', ['class' => 'btn btn-success btn-enable-disable', 'data-consultant' => $model->consultant->id]);
                            }
                            if($model->consultant->status == Status::STATUS_ACTIVE){
                                return Html::button('Disable', ['class' => 'btn btn-danger btn-enable-disable', 'data-consultant' => $model->consultant->id]);
                            }
                            return null;
                        },
                        'verify' => function($url, $model, $key) {
                            if($model->consultant->status === Status::STATUS_NEW) {
                                return Html::button('Verify', ['class' => 'btn btn-primary btn-verify', 'data-consultant' => $model->consultant->id]);
                            }
							if($model->consultant->status != Status::STATUS_NEW || $model->consultant->status!= Status::STATUS_INACTIVE) {
                                return Html::button('Verified', ['class' => 'btn  btn-success']);
                            }
							
                            return null;
                        },  
						'createlogin' => function ($url, $model, $key) {
							return Html::a('', ['admin-consultant/createlogin', 'id' => $model->id] , ['class' => 'glyphicon glyphicon-user','title' => 'Create Login Credentials']);
						},
				
				],
                    ],
                ],
            ]); ?>
            </div>
        </div>
    </div>
</div>

<?php
    $this->registerJsFile('js/consultant.js');
?>