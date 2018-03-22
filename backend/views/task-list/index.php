<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\Models\TaskListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Task Lists';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="task-list-index">
<div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Task List', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
			[
				'label' => 'Task Category',
				'attribute' => 'task_category_id',
				'value'=>'taskCategory.name'
			],
            'name', 

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
	</div>
        </div>
    </div>
</div>
