<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UniversitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Universities';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<body>
<div class="university-index">
    <div class="container">
        <div class="row">
            <div class="col-xs-8 col-md-8">  
            <h1><?= Html::encode($this->title) ?></h1>
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
                        'value'=>'city.name'
                    ],
                    [
                        'label' => 'State',
                        'attribute' => 'state_id',
                        'value'=>'state.name'
                    ],
                    [
                        'label' => 'Country',
                        'attribute' => 'country_id',
                        'value'=>'country.name'
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

                    //['class' => 'yii\grid\ActionColumn'],
                    [
                          'class' => 'yii\grid\ActionColumn',
                          'template' => '{view}{update}{button}',
                          'buttons' => [
                            'button' => function ($url, $model, $key) {
                                return Html::a('View Applications', ['admin-university/view-applications', 'id' => $model->id] , ['class' => 'btn btn-primary']);
                            },
                            ],
                    ],
                ],
            ]); ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>