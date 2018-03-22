<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\EmployeeLogin;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\DegreeLevelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Degree Levels';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
$employee = ArrayHelper::map(EmployeeLogin::find()->asArray()->all(), 'id', 'username');

?>
<div class="degree-level-index">
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">

            <h1><?= Html::encode($this->title) ?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a('Create Degree Level', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    'name',
					'position',
                    'created_by',
                    'updated_by',
                    // 'updated_at',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            </div>
        </div>
    </div>
</div>
