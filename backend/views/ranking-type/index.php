<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\RankingTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ranking Type';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="faq-category-index">
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">

            <h1><?= Html::encode($this->title) ?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a('Create Ranking Type', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //'id',
                    'type',
                    'name',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            </div>
        </div>
    </div>
</div>
