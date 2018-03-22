<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\StandardTests;
use common\models\University;
/* @var $this yii\web\View */
/* @var $searchModel partner\models\UniversityCommonAdmissionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Common Admissions';
$this->params['breadcrumbs'][] = $this->title;
$this->context->layout = 'admin-dashboard-sidebar'; 


?>
<div class="university-common-admission-index">
 <div class="container">
        <div class="row">
            <div class="col-xs-10 col-md-10">
			
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
			[ 'attribute' => 'university_id',
			'value' => function($searchModel){ 
				$University = University::find()->where(['id'=>$searchModel->university_id])->one();	
				if(isset($University)){
				 return $University->name;
				}	
                },
			],
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
</div>
</div>
</div>
