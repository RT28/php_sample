<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\components\Status; 
use common\components\ConnectionSettings;
use common\models\Country;
use common\components\Commondata;

$this->title = 'Trainers';
$this->params['breadcrumbs'][] = $this->title; 
$this->context->layout = 'main';

$countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name');
?>

<div class="alert alert-danger hidden">
</div>
<div class="trainer-index">
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

<a class="btn btn-success" href="?r=agency/trainer/create">Add Trainer</a> 
 
			
			<br/>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    [
                            'label'=>'Name',
                            'attribute' => 'first_name',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $name = $model->first_name . ' ' .$model->last_name ;
                              
                                   return $name;
                                 
                            },
                        ], 
                    'email:email',
                      [
                            'label'=>'Phone Number',
                            'attribute' => 'mobile',
                            'format' => 'raw',
                            'value' => function ($model) {
                                
                              return  '+'.$model->code.'-'.$model->mobile;
                                 
                            },
                        ],
                    [
						'label'=>'Status',
						'attribute' => 'first_name',
						'format' => 'raw',
						'value' => function ($model) {
							return Status::getStatusName($model->employee->status);
						},
						'filter'=>Html::dropDownList('PartnerTrainerSearch[status]',isset($_REQUEST['PartnerTrainerSearch']['status']) ? $_REQUEST['PartnerTrainerSearch']['status'] : null,Status::getActiveInactiveStatus(),['class' => 'form-control', 'prompt' => 'Select Status'])

					],
					[
						'label' => 'Country',
						'attribute' => 'country_id',
						'value'=>'country.name',
						'filter'=>Html::dropDownList('PartnerTrainerSearch[country_id]',isset($_REQUEST['PartnerTrainerSearch']['country_id']) ? $_REQUEST['PartnerTrainerSearch']['country_id'] : null,$countries,['class' => 'form-control', 'prompt' => 'Select Country'])
					],  
                    ['class' => 'yii\grid\ActionColumn',
                     'template' => '{view}{update}{disable}{createlogin}',
                     'buttons' => [
                        'disable' => function ($url, $model, $key) {
							 if($model->employee->status === Status::STATUS_NEW){
                                return Html::button('Enable', ['class' => 'btn btn-success btn-enable-disable', 'data-trainer' => $model->employee->id]);
                            }
                            if($model->employee->status === Status::STATUS_INACTIVE){
                                return Html::button('Enable', ['class' => 'btn btn-success btn-enable-disable', 'data-trainer' => $model->employee->id]);
                            }
                            if($model->employee->status == Status::STATUS_ACTIVE){
                                return Html::button('Disable', ['class' => 'btn btn-danger btn-enable-disable', 'data-trainer' => $model->employee->id]);
                            }
                            return null;
                        },   
						'createlogin' => function ($url, $model, $key) {
							$id = Commondata::encrypt_decrypt('encrypt', $model->id);
							
							return Html::a('', ['/agency/trainer/createlogin', 'id' => $id] , ['class' => 'glyphicon glyphicon-user','title' => 'Create Login Credentials']);
						},
						'update' => function ($url, $model, $key) {
							
							$id = Commondata::encrypt_decrypt('encrypt', $model->id);
							
							return Html::a('', ['/agency/trainer/update', 'id' => $id] , ['class' => 'glyphicon glyphicon-pencil','title' => 'Create Login Credentials']);
						},
						'view' => function ($url, $model, $key) {
							
							$id = Commondata::encrypt_decrypt('encrypt', $model->id);
							
							return Html::a('', ['/agency/trainer/view', 'id' => $id] , ['class' => 'glyphicon glyphicon-eye-open','title' => 'Create Login Credentials']);
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
$path= ConnectionSettings::BASE_URL.'partner';
    $this->registerJsFile($path.'/web/js/agency.js');
?> 