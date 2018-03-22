<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\EmployeeLogin;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\TestCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Test Categories';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
$employee = ArrayHelper::map(EmployeeLogin::find()->asArray()->all(), 'id', 'username');
?>
<div class="test-category-index">
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">

            <h1><?= Html::encode($this->title) ?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a('Create Test Category', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    //'id',
                    'name',
                     [
                    'label'=>'Created By',
                    'attribute'=>'created_by',
                    'value' => function ($model) {
                            $employee = EmployeeLogin::find()->select('username')->where(['id' => $model->created_by])->asArray()->one();
                           return isset($employee['username']) ? $employee['username']: 'not assigned';
                        },
                    'filter' => Html::dropDownList('MajorsSearch[created_by]',isset($_REQUEST['MajorsSearch']['created_by']) ? $_REQUEST['MajorsSearch']['created_by'] : null,$employee,['class' => 'form-control', 'prompt' => 'Select'])
                    ],
                    'created_at',
                    'updated_at',
                    // 'updated_by',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            </div>
        </div>
    </div>
</div>
