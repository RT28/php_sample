<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cities';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="city-index">
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">
                    <h1><?= Html::encode($this->title) ?></h1>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <p>
                        <?= Html::a('Create City', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //'id',
                            'name',
                            [
                                'label'=>'State',
                                'attribute' => 'state_id',
                                'value' => 'state.name',
                            ],
                            [
                                'label'=>'Country',
                                'attribute' => 'country_id',
                                'value' => 'country.name',
                            ],

                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>
                </div>
        </div>
    </div>
</div>
