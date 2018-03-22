<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WebinarCreateRequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Webinar Create Requests';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'index';
?>
<div class="webinar-create-request-index">

<div class="container">
<div class="col-xs-10 col-md-10">
<div class="webinar-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Webinar Create Request', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'topic',
            'date_time',
            'author_name',
            'email:email',
            // 'phone',
            // 'logo_image',
            // 'duration',
            // 'country',
            // 'disciplines',
            // 'degreelevels',
            // 'university_admission',
            // 'test_preperation',
            // 'status',
            // 'created_by',
            // 'created_at',
            // 'updated_by',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
</div>
</div>
</div>