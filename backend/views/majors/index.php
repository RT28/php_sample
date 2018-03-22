<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\EmployeeLogin;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MajorsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Majors';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';

$employee = ArrayHelper::map(EmployeeLogin::find()->asArray()->all(), 'id', 'username');
?>
<div class="majors-index">
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">

            <h1><?= Html::encode($this->title) ?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a('Create Majors', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    'name', 
					 'degree.name',
                    'created_by',
                    'created_at',
                    'updated_by',
                    // 'updated_at',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            </div>
        </div>
    </div>
</div>