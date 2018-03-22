<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\Status;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PackageTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Package Types';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="package-type-index">
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">

            <h1><?= Html::encode($this->title) ?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a('Create Package Type', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    'name',
                    'name_fa',
                    [
                        'label' => 'Status',
                        'attribute'=>'status',
                        'value' => function($model) {
                            return Status::getStatusName($model->status);
                        },
                        'filter'=>Html::dropDownList('PackageTypeSearch[status]',isset($_REQUEST['PackageTypeSearch']['status']) ? $_REQUEST['PackageTypeSearch']['status'] : null,Status::getStatus(),['class' => 'form-control', 'prompt' => 'Select status'])
                    ],
                    'rank',
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
