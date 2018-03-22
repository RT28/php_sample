<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Students';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="student-index">
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">

                <h1><?= Html::encode($this->title) ?></h1>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <p>
                    <?= Html::a('Create Student', ['create'], ['class' => 'btn btn-success']) ?>
                </p>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        //'id',
                        'first_name',
                        'last_name',
                        'date_of_birth',
                        'gender',
                        // 'address',
                        // 'street',
                        // 'city',
                        // 'state',
                        // 'country',
                        // 'pincode',
                        // 'email:email',
                        // 'parent_email:email',
                        // 'phone',
                        // 'parent_phone',
                        // 'created_by',
                        // 'updated_by',
                        // 'created_at',
                        // 'updated_at',

                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>
                </div>
        </div>
    </div>
</div>
