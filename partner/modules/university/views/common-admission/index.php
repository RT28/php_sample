<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\StandardTests;

/* @var $this yii\web\View */
/* @var $searchModel partner\models\UniversityCommonAdmissionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Common Admissions';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'profile';



?>
<div class="university-common-admission-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Common Admission', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'], 
			[ 'attribute' => 'degree_level_id',
			'value' => 'degreeLevel.name',
			],
			[
			'label' => 'Standard Test',
			'value' => function($searchModel){ 
				$standardTests = StandardTests::find()->where(['=', 'id',$searchModel->test_id])->one();
				return $standardTests->name;	 
				}
			],
			'score',

			['class' => 'yii\grid\ActionColumn'],
			],
    ]); ?>
</div>
