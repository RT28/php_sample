<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TestSubjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Test Subjects';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar';
?>
<div class="test-subject-index">
<div class="container">
		<div class="row">
			<div class="col-xs-12 col-md-12">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Test Subject', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

			
            'name',
			

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
	</div>
	</div>
</div>

</div>
