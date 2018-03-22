<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;      
use common\models\StandardTests;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\InstituteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Institutes';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="institute-index">
<div class="container">
     <div class="row">
        <div class="col-xs-10 col-md-10">

                <h1><?= Html::encode($this->title) ?></h1>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <p>
                    <?= Html::a('Create Institute', ['create'], ['class' => 'btn btn-success']) ?>
                </p>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        //'id',
                        'name',
                        'email:email',
                        //'adress',
                        //'country_id',
                        // 'state_id',
                        // 'city_id',
                        [
                        'format' => 'raw',
                        'label'=>'Tests Offered',
                        'attribute'=>'tests_offered',
                        'value'=>function ($model) {
                                $tests = ArrayHelper::map(StandardTests::find()->asArray()->all(),'id','name');
                                $StandardTests  =  explode(',', $model->tests_offered);
                                $tests_offered = [];
                                foreach ($StandardTests as $key => $value) {
                                   array_push($tests_offered, $tests[$value]);
                                }
                                $tests_offered  = implode(',', $tests_offered);        
                                return ISSET($tests_offered)?$tests_offered:'Not Assigned';
                            },
                        ],
                        'contact_details',
                        'website',
                        // 'description',
                        // 'created_at',
                        // 'created_by',
                        // 'updated_at',
                        // 'updated_by',

                        [
                          'class' => 'yii\grid\ActionColumn',
                          'template' => '{view}{update}{delete}{gotoinstitute}',
                          'buttons'=>
                            [

                                'gotoinstitute' => function ($url, $model, $key) {
                                    $url = $model->website;
                                     return 
                                     "<a href='http://$url'>
                                            <button class='btn btn-primary'>Go to Institute</button>
                                        </a>";

                                 },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
