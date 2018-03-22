<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Country;
use common\models\State;
use common\models\City;
use common\components\ConnectionSettings;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UniversitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Universities';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'main';
$countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name');
$states = ArrayHelper::map(State::find()->orderBy('name')->all(), 'id', 'name');
$cities = ArrayHelper::map(City::find()->orderBy('name')->all(), 'id', 'name');
$path= ConnectionSettings::BASE_URL.'partner/';


$this->registerCssFile('css/style.css');

?>
<div class="university-index">
 <div class="container">

        <div class="row">
            <div class="col-xs-10 col-md-10">

                <h1><?= Html::encode($this->title) ?></h1>
				
				<?php if(isset($message) && strpos($message, 'Error') !== false): ?>
    <div class="alert alert-danger" role="alert"><?= $message ?></div>
<?php endif; ?>

<?php if(isset($message) && strpos($message, 'Success') !== false): ?>
    <div class="alert alert-success" role="alert"><?= $message ?></div>
<?php endif; ?>

                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <p style="float: right;">
                    <?= Html::a('Ask questions to the university','?r=consultant/universityinfo/', ['class' => 'btn btn-success']) ?>
                </p>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
 
                        //'name', 
                         /*[
                               'label' => 'Name',

                               'format' => 'raw',
                               'value' => function ($data) {
                                             return Html::a($data->name, ['/consultant/university/view', 'id' => $data->id]);
                                         },
                               
                        ],*/
                        ['attribute' => 'name',
                            'format' => 'raw',
                            'label' => 'Name',
                            'value' => function($model){  
                                $name = $model->name;
                                if (isset($name)) {
                                    $temp = Html::a($name,'?r=consultant/university/view&id='.$model->id);
                                    return $temp; 
                                } else{ 
                                    return 'not assigned'; 
                                }
                            }, 
                            ], 
                        [
                            'label' => 'City',
                            'attribute' => 'city_id',
                            'value'=>'city.name',
                            'filter'=>Html::dropDownList('UniversitySearch[city_id]',isset($_REQUEST['UniversitySearch']['city_id']) ? $_REQUEST['UniversitySearch']['city_id'] : null,$cities,['class' => 'form-control', 'prompt' => 'Select City']),


                        ],
                        [
                            'label' => 'State',
                            'attribute' => 'state_id',
                            'value'=>'state.name',
                            'filter'=>Html::dropDownList('UniversitySearch[state_id]',isset($_REQUEST['UniversitySearch']['state_id']) ? $_REQUEST['UniversitySearch']['state_id'] : null,$states,['class' => 'form-control', 'prompt' => 'Select State'])                
                        ],
                        [
                            'label' => 'Country',
                            'attribute' => 'country_id',
                            'value'=>'country.name',
                            'filter'=>Html::dropDownList('UniversitySearch[country_id]',isset($_REQUEST['UniversitySearch']['country_id']) ? $_REQUEST['UniversitySearch']['country_id'] : null,$countries,['class' => 'form-control', 'prompt' => 'Select Country'])
                        ], 

                        
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
<?php
    $this->registerJsFile('js/chatnotification.js');
?>