<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Seofields;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SeofieldsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Seofields';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gt-seofields-index">

    <h1><?= Html::encode($this->title)?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Seofields', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'gt_id',
            'gt_title',
            //'gt_desccontent',
            //'gt_keycontent',
            'gt_linkurl:url',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
