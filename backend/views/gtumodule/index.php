<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\GtuEnvironment;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\GtuModuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gtu Modules';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="gtu-module-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Gtu Module', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'gt_id',
            [
              'attribute'=>'gt_envid',
              'value'=>'gtEnv.gt_name',
              'filter'=>Html::dropDownList('GtuModuleSearch[gt_envid]',isset($_REQUEST['GtuModuleSearch']['gt_envid']) ? $_REQUEST['GtuModuleSearch']['gt_envid'] : null,ArrayHelper::map(GtuEnvironment::find()->all(), 'gt_id','gt_name' ),['class' => 'form-control', 'prompt' => 'Select Environment'])
            ],
            'gt_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
