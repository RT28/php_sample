<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Country;
use common\models\State;
use common\models\City;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AgencySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Agencies';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';

$countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name');
$states = ArrayHelper::map(State::find()->orderBy('name')->all(), 'id', 'name');
$cities = ArrayHelper::map(City::find()->orderBy('name')->all(), 'id', 'name');

?>
<div class="agency-index">
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
        <?= Html::a('Create Agency', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
           // 'partner_login_id',
            'name',  
            [
				'label' => 'City',
				'attribute' => 'city_id',
				'value'=>'city.name',
				'filter'=>Html::dropDownList('AgencySearch[city_id]',isset($_REQUEST['AgencySearch']['city_id']) ? $_REQUEST['AgencySearch']['city_id'] : null,$cities,['class' => 'form-control', 'prompt' => 'Select City'])
			],
			[
				'label' => 'State',
				'attribute' => 'state_id',
				'value'=>'state.name',
				'filter'=>Html::dropDownList('AgencySearch[state_id]',isset($_REQUEST['AgencySearch']['state_id']) ? $_REQUEST['AgencySearch']['state_id'] : null,$states,['class' => 'form-control', 'prompt' => 'Select State'])                
			],
			[
				'label' => 'Country',
				'attribute' => 'country_id',
				'value'=>'country.name',
				'filter'=>Html::dropDownList('AgencySearch[country_id]',isset($_REQUEST['AgencySearch']['country_id']) ? $_REQUEST['AgencySearch']['country_id'] : null,$countries,['class' => 'form-control', 'prompt' => 'Select Country'])
			],

           ['class' => 'yii\grid\ActionColumn',
                     'template' => '{view}{update}{delete}{createlogin}',
                     'buttons' => [
                       
						'createlogin' => function ($url, $model, $key) {
							return Html::a('', ['agency/createlogin', 'id' => $model->id] , ['class' => 'glyphicon glyphicon-user','title' => 'Create Login Credentials']);
						},
				
				],
                    ],
					
        ],
    ]); ?>
</div>
</div>
</div>
</div>
