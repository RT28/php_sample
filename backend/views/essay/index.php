<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\Status;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EssaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Essays';
$this->params['breadcrumbs'][] = $this->title;

$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="university-course-list-index">
 
    <div class="container">
        
            <div class="col-xs-10 col-md-10">
<div class="essay-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Essay', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
 
            'title', 
            [
                'label' => 'Status',
                'value' => function($model) {
                    return Status::getStatusName($model->status);
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
</div>
</div>

