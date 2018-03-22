<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Country;
use common\models\State;
use common\models\City;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UniversitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Universities';
$this->params['breadcrumbs'][] = $this->title; 
$countries = ArrayHelper::map(Country::getAllCountries(), 'id', 'name');
$states = ArrayHelper::map(State::find()->orderBy('name')->all(), 'id', 'name');
$cities = ArrayHelper::map(City::find()->orderBy('name')->all(), 'id', 'name');

?>
<div class="university-index">
 <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">

                <h1><?= Html::encode($this->title) ?></h1>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

					<?php if(isset($message) && strpos($message, 'Error') !== false): ?>
    <div class="alert alert-danger" role="alert"><?= $message ?></div>
<?php endif; ?>

<?php if(isset($message) && strpos($message, 'Success') !== false): ?>
    <div class="alert alert-success" role="alert"><?= $message ?></div>
<?php endif; ?>
                <p>
                    <?= Html::a('Create University', ['create'], ['class' => 'btn btn-success']) ?>
                </p>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        //'id',
                        'name',
                        //'establishment_date',
                        //'address',
                        [
                            'label' => 'City',
                            'attribute' => 'city_id',
                            'value'=>'city.name',
                            'filter'=>Html::dropDownList('UniversitySearch[city_id]',isset($_REQUEST['UniversitySearch']['city_id']) ? $_REQUEST['UniversitySearch']['city_id'] : null,$cities,['class' => 'form-control', 'prompt' => 'Select City'])
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
                        // 'pincode',
                        //'email:email',
                        //'website',
                        // 'description:ntext',
                        // 'fax',
                        //'phone_1',
                        //'phone_2',
                        //'contact_person',
                        //'contact_person_designation',
                        //'contact_mobile',
                        //'contact_email:email',
                        //'location',
                        //'institution_type',
                        // 'establishment',
                        // 'no_of_students',
                        // 'no_of_international_students',
                        // 'no_faculties',
                        // 'cost_of_living',
                        // 'accomodation_available:boolean',
                        // 'hostel_strength',            
                        // 'institution_ranking',
                        // 'vide:ntext',
                        // 'virual_tour:ntext',
                        // 'avg_rating',
                        // 'comments:ntext',
                        // 'status',
                        // 'created_by',
                        // 'created_at',
                        // 'updated_by',
                        // 'updated_at',
                        // 'reviewed_by',
                        // 'reviewed_at',

                        ['class' => 'yii\grid\ActionColumn',
                         'template' => '{view}{update}',
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
